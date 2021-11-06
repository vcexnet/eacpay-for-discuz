<?php
require_once "base.php";
if(empty($uid)) showmessage('to_login', 'member.php?mod=logging&action=login', array(), array('showmsg' => true, 'login' => 1));
ob_clean();
if ($action == 'buy') {
	include template('cc_cansnow_eacpay:recharge');
}elseif($action == 'test'){
	$vo =DB::fetch_first("select * from ".DB::table("eacpay_order")." where order_id='".$_GET['orderid']."'");
	test($vo);
}elseif($action == 'check'){
	$vo =DB::fetch_first("select * from ".DB::table("eacpay_order")." where order_id='".$_GET['orderid']."'");
	if($vo){
		$ret = check($vo);
		ob_clean();
	    exit(json_encode($ret));
	}

}elseif($action == 'getExchange'){
	echo getExchange();
}elseif($action == 'geteac'){
	$amount = floatval($_GET['amount']);
	$submit = intval($_REQUEST['submit']);
	$exchangeData = getExchange();
	list($msec, $sec) = explode(' ', microtime());
	$msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
	$arr = array(
		"amount"		=>	$amount,
		"exchange"		=>	$exchangeData,
		"rmb"			=>	$amount/$csetting['moneybl'],
		"eacamount"		=>	round($amount/$csetting['moneybl'] / $exchangeData,3),
		"orderid"		=>	$_SERVER['SERVER_NAME']."_recharge_".$uid.'_'.$msectime.rand(100000,999999),
	);
	$arr['qrcode']='plugin.php?id=cc_cansnow_eacpay:recharge&action=qrcode&eac='.$arr['eacamount'].'&orderid='.$arr['orderid'];
	if($submit){
		DB::insert('eacpay_order', array(
			"uid"			=>	$uid,
			"order_id"		=>	$arr['orderid'],
			"amount"		=>	$arr['amount'],
			"eac"			=>	$arr['eacamount'],
			'block_height'	=>	get_block_height(),
			"create_time"	=>	time(),
			"last_time"		=>	time(),
			"pay_time"		=>	0,
			"type"			=>	'recharge',
			"status"		=>	'wait',
		), true);
	}
	echo json_encode($arr);

}elseif($action == 'qrcode'){
	$eac = floatval($_GET['eac']);
	$orderid = trim($_GET['orderid']);
	$vo =DB::fetch_first("select * from ".DB::table("eacpay_order")." where order_id='".$_GET['orderid']."'");
	if($vo){
		$eac = $vo['eac'];
	}
	require_once DISCUZ_ROOT.'source/plugin/mobile/qrcode.class.php';
	$str = "earthcoin:".$csetting['recive_token']."?amount=".$eac."&message=".$orderid;

	ob_clean();
	QRcode::png($str, false, QR_ECLEVEL_Q,4,4);
	exit;
}elseif($action == 'log'){
    $field = "o.uid,o.amount,o.create_time,o.address,o.type,o.status,o.order_id,o.eac,o.real_eac";
    $sql=" from ".DB::table("eacpay_order")." AS o where o.`type`='recharge'";
	$sql.=' and o.uid='.$uid;
	$sql.=" and o.status<>'wait'";
	
    $vo = DB::fetch_first('select count(o.order_id) as count '.$sql);
    $totalCount = $vo['count'];
    $page = intval($_REQUEST['page']);
    $page = $page<1 ? 1 : $page;
    $pagesize = 10;

    $orderlist = DB::fetch_all('select '.$field.$sql.' order by o.`create_time` desc limit 0,10');
	$statusArr=array(
		'reject'	=>	'退回',
		'wait'	=>	'等待支付',
		'payed'	=>	'系统确认中',
		'complete'	=>	'成功',
	);
	include template('cc_cansnow_eacpay:recharge_log');
}else{	
    $field = "o.uid,o.amount,o.create_time,o.address,o.type,o.status,o.order_id,o.eac,o.real_eac";
    $sql=" from ".DB::table("eacpay_order")." AS o where o.`type`='recharge'";
	$sql.=' and o.uid='.$uid;
	//$sql.=" and o.status<>'wait'";
    $orderlist = DB::fetch_all('select '.$field.$sql.' order by o.`create_time` desc limit 0,10');
	$statusArr=array(
		'reject'	=>	'退回',
		'wait'	=>	'等待支付',
		'payed'	=>	'系统确认中',
		'complete'	=>	'成功',
	);
}
?>