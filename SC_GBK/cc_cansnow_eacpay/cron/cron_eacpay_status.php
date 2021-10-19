
<?php
 
 
 //cronname:Eacpay支付
 //week:
 //day:
 //hour:
 //minute:0,5,10,15,20,25,30,35,40,45,50,55         设置哪些分钟执行本任务，至多可以设置 12 个分钟值，多个值之间用半角逗号 "," 隔开，留空为不限制
  
  
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

require_once "../base.php";
$time = time()-60*5;
$list = DB::fetch_all("select * from ".DB::table("eacpay_order")." where status='wait' and type='recharge' and last_time<".$time);
//$vo =DB::fetch_first("select * from ".DB::table("eacpay_order")." where order_id='".$_GET['orderid']."'");
foreach($list as $vo){
    $ret = check($vo);
}
 