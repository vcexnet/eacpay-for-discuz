
<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
include DISCUZ_ROOT.'./source/plugin/cc_cansnow_eacpay/config.php';
$action = empty($_REQUEST['action']) ? 'index' : daddslashes($_REQUEST['action']);
$gpformhash = daddslashes($_GET['formhash']);
$gppage = daddslashes($_GET['page']);
$atclass[$action] = "class='a'";
$uid = $_G['uid'];
$username = $_G['username'];
$adminid = $_G['adminid'];
$closemsg = $csetting['closemsg'];

$bizhongarr = array(
    'RMB'=>'￥',
    'USD'=>'$',
    'EUR'=>'€',
);

$bizhongtxtarr = array(
    'RMB'=>'人民幣',
    'USD'=>'美元',
    'EUR'=>'歐元',
);
$bizhong = $bizhongarr[$csetting['bizhong']];
$bizhongTxt = $bizhongtxtarr[$csetting['bizhong']];
if ($csetting['open'] == '0') {
	showmessage("$closemsg","index.php");
}
function get_block_height(){
	global $csetting;
	return cansnow_get($csetting['eacpay_server']."/getblockcount/Block_height");
}
function test($vo){
	global $csetting;
	//P($csetting);
	$exp = ceil((time()-$vo['create_time'])/60);
	$exp = $exp < 10 ? 10 : $exp;
	//$vo['eac'] = 5.498;
	$url = $csetting['eacpay_server']."/checktransaction/".$csetting['recive_token']."/".$vo['eac'].'/'.$vo['order_id'].'/'.($vo['block_height']+1).'/1000';
	//echo $url;
	$ret = cansnow_get($url);
	echo ($ret);
}
function check($vo=array()){
	if($vo['status'] == 'complete'){
		return 'ok';
	}
	global $csetting;
	$exp = ceil((time()-$vo['create_time'])/60);
	$exp = $exp < 10 ? 10 : $exp;
	if($vo['type']=='cash'){

	}else{
		//$vo['eac'] = 1;
		$url = $csetting['eacpay_server']."/checktransaction/".$csetting['recive_token']."/".$vo['eac'].'/'.$vo['order_id'].'/'.$vo['block_height'].'/100';
	}
	//echo $url;
	$ret = cansnow_get($url);
	//P($ret);
	$ret = json_decode($ret,true);
	if($ret['Error']){
		return $ret['Error'];
	}
	
	$data =array(
		'last_time' => time(),
		'pay_time' => time(),
		'status' 	=> 'payed',
		'real_eac'	=>0
	);
	if ($ret['confirmations'] >= $csetting['receiptConfirmation']) {
		//P(round($ret['vout'][0]['value'],strlen(explode('.',$vo['eac'])[1])));
		//P($vo['eac']);
		foreach($ret['vout'] as $v){
			if($v['scriptPubKey']['addresses'][0] == $csetting['recive_token']){
				$data['real_eac'] = $v['value'];
				if(round($v['value'],strlen(explode('.',$vo['eac'])[1])) == $vo['eac']){
					$d = array();
					$d['extcredits'.$csetting['moneytype']] = $vo['amount'];
					updatemembercount($vo['uid'],$d);
					$data['status']		=	'complete';
					DB::update('eacpay_order', $data, "order_id='$vo[order_id]'");
					return true;
				}else{
					DB::update('eacpay_order', $data, "order_id='$vo[order_id]'");
					return '交易數值不一致，請自行聯繫站長解決';
				}
				break;
			}
		}
	}else{
		return '已確認'.$ret['confirmations'];
	}
}

function getExchange(){
	global $csetting;
	$priceType = 'CNY';
	switch($csetting['bizhong']){
		case 'USD':
			$priceType = 'USD';
			break;
		case 'EUR':
			$priceType = 'EUR';
			break;
		default:
			break;
	}
	$ret = cansnow_post($csetting['exhangeapi'],array('mk_type'=>'usdt','coinname'=>'eac'));
	$ret = json_decode($ret,true);
	$unitPrice = 0;
	$ret = $ret['data']['bids'];
	//P(json_encode($ret));
	
	foreach( $ret as $k=>$v){
		$unitPrice +=$v[0];
		if($k==4){
			break;
		}
	}
	$unitPrice = round($unitPrice/5,6);
	$hl = UsdtPrice($priceType);
	$unitPrice=$unitPrice * $hl;
	return round($unitPrice,6);
}

function UsdtPrice($priceType='CNY'){
    if($priceType =='USD'){return 1;}
	$hlret = cansnow_get('http://data.bank.hexun.com/other/cms/fxjhjson.ashx?callback=cansnow');
	$hlret = iconv('GB2312','UTF-8',$hlret);
	$USDrate=1;
	preg_match("/\{currency:'美元',refePrice:'(.*?)',code:'USD.*?\}/",$hlret,$macths);
	if(count($macths)!=0){
		$USDrate = floatval($macths[1])/100;
	}
    if($priceType =='CNY'){
        return $USDrate;
    }else if($priceType =='EUR'){
    	$EURrate=1;
    	preg_match("/\{currency:'歐元',refePrice:'(.*?)',code:'EUR.*?\}/",$hlret,$macths);
    	if(count($macths)!=0){
    		$EURrate = floatval($macths[1])/100;
    	}
        return $USDrate/$EURrate;
    }
	return 1;
}