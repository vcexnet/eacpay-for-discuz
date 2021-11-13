

<?php
require_once "base.php";
$type = $_REQUEST['type'] ? $_REQUEST['type'] : 'cash';
if ($action == 'buy') {

}elseif ($action == 'changestatus') {
    $status = trim($_REQUEST['status']);
    $orderid = trim($_REQUEST['order_id']);
    $vo =DB::fetch_first("select * from ".DB::table("eacpay_order")." where order_id='".$orderid."'");
    $type = trim($vo['type']);
    $data=array(
        'status'=>$status
    );
    if($status=='complete'){
        $data['pay_time'] = time();
        $data['last_time'] = time();
    }
    DB::update('eacpay_order',$data,"order_id='".$orderid."'");
    //DB::query("update pre_eacpay_order set status='wait' where order_id='".$orderid."'");
    //$vo =DB::fetch_first("select * from ".DB::table("eacpay_order")." where order_id='".$orderid."'");
    //P($vo);
    //exit;
    $d = array();
    $d['extcredits'.$csetting['moneytype']] = $vo['amount']; 
    if($status=='reject' && $type == 'cash'){
		updatemembercount($vo['uid'],$d,false,'cash','0','','Rejection','Rejection');
    }
    if($status == 'complete' && $type=='recharge'){
        updatemembercount($vo['uid'],$d,false,'recharge','0','','Recharge','Recharge');
    }
    ob_clean();
    exit('ok');
}elseif($action == 'qrcode'){
    $address = $_REQUEST['address'];
    $exchangeData = getExchange();

	$orderid = trim($_GET['orderid']);
    $vo =DB::fetch_first("select * from ".DB::table("eacpay_order")." where order_id='".$orderid."'");
    $eac = $vo['eac'];
    
	require_once DISCUZ_ROOT.'source/plugin/mobile/qrcode.class.php';
	$str = "earthcoin:".$vo['address']."?amount=".$eac."&message=".$orderid;

	ob_clean();
	QRcode::png($str, false, QR_ECLEVEL_Q,4,4);
	exit;
}else{
    $uid = $_REQUEST['uid'];
    $username = $_REQUEST['username'];
    $orderid = $_REQUEST['order_id'];
    $status = $_REQUEST['status'];
    $field = "o.uid,o.amount,o.create_time,o.address,o.type,o.status,o.order_id,o.eac,o.real_eac,u.username";
    $sql=" from ".DB::table("eacpay_order")." AS o ".
        "JOIN ".DB::table("common_member")." AS u ON u.uid = o.uid ".
        "where o.`type`='".$type."'";
    if($uid){
        $sql.=' and o.uid='.$uid;
    }
    if($orderid){
        $sql.=" and o.order_id='".$orderid."'";
    }
    if($status){
        $sql.=" and o.status='".$status."'";
    }
    if($username){
        $username.=" and u.username='".$username."'";
    }
    $vo = DB::fetch_first('select count(o.order_id) as count '.$sql);
    $totalCount = $vo['count'];
    $page = intval($_REQUEST['page']);
    $page = $page<1 ? 1 : $page;
    $pagesize = 10;

    $datalist = DB::fetch_all('select '.$field.$sql.' order by create_time desc limit '.($page-1)*$pagesize.','.$pagesize);
    if($type=='cash'){
        include template('cc_cansnow_eacpay:cash_list');
    }elseif($type=='recharge'){
        include template('cc_cansnow_eacpay:recharge_list');
    }
}
?>