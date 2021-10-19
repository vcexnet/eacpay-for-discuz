<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$csetting = $_G['cache']['plugin']['cc_cansnow_eacpay'];
$payhid = $csetting['hid'];
$paypass = $csetting['paypass'];
function P($arr=""){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}
function cansnow_get($url) {
	global $_G;
	if (function_exists('curl_init')) {
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, $url); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_REFERER, $_G['siteurl']); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		$result = curl_exec($curl); 
		curl_close($curl);
	} else {
		$result = dfsockopen($url);
	}
	return $result;
}
function cansnow_post($url,$data=array()) {
	global $_G;
	if (function_exists('curl_init')) {
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, $url); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_REFERER, $_G['siteurl']); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		$result = curl_exec($curl); 
		curl_close($curl);
	} else {
		$result = dfsockopen($url,3000,$data);
	}
	return $result;
}

?>