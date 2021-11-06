
<?php
 
 
 //cronname:Eacpay支付
 //week:
 //day:
 //hour:
 //minute:0,5,10,15,20,25,30,35,40,45,50,55         設置哪些分鐘執行本任務，至多可以設置 12 個分鐘值，多個值之間用半角逗號 "," 隔開，留空為不限制
  
  
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

require_once "../base.php";
$maxtime = time()-$csetting['maxwaitpaytime']*60;
DB::update('eacpay_order',array(
	'status'=>'cancel'
),"status='wait' and type='recharge' and create_time<".$maxtime);

$time = time()-60*5;
$list = DB::fetch_all("select * from ".DB::table("eacpay_order")." where status='wait' and type='recharge' and last_time<".$time);
//$vo =DB::fetch_first("select * from ".DB::table("eacpay_order")." where order_id='".$_GET['orderid']."'");
foreach($list as $vo){
    $ret = check($vo);
}
 