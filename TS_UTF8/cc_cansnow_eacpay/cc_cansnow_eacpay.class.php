<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once 'base.php';
class plugin_cc_cansnow_eacpay {

	function cc_cansnow_eacpay() {
		global $_G;
		$csetting = $_G['cache']['plugin']['cc_cansnow_eacpay'];
		$lincolor = $csetting['linkcolor'];
		$pluginname = $csetting['pluginname'];
		if ($csetting['open']) {
			return "<a href='home.php?mod=spacecp&ac=plugin&op=credit&id=cc_cansnow_eacpay:recharge'><font color='".$lincolor."'>".$pluginname."</font></a>";
		} else {
			return '';
		}
	}

	function global_cpnav_extra1() {
		global $_G;
		$csetting = $_G['cache']['plugin']['cc_cansnow_eacpay'];
		$linktype = $csetting['linktype'];
		if ($linktype == '0') {
			return $this->cc_cansnow_eacpay();
		} else {
			return '';
		}
	}

	function global_cpnav_extra2() {
		global $_G;
		$csetting = $_G['cache']['plugin']['cc_cansnow_eacpay'];
		$linktype = $csetting['linktype'];
		if ($linktype == '1') {
			return $this->cc_cansnow_eacpay();
		} else {
			return '';
		}
	}

	function global_usernav_extra3() {
		global $_G;
		$csetting = $_G['cache']['plugin']['cc_cansnow_eacpay'];
		$linktype = $csetting['linktype'];
		if ($linktype == '2') {
			return $this->cc_cansnow_eacpay();
		} else {
			return '';
		}
	}
	
	function global_nav_extra() {
		global $_G;
		$csetting = $_G['cache']['plugin']['cc_cansnow_eacpay'];
		$linktype = $csetting['linktype'];
		if ($linktype == '3') {
			return '<ul><li>'.$this->cc_cansnow_eacpay().'</li></ul>';
		} else {
			return '';
		}
	}
}
/*
class plugin_cc_cansnow_eacpay_home extends plugin_cc_cansnow_eacpay {
	
	function spacecp_credit_extra() {
	
		global $_G;
		$csetting = $_G['cache']['plugin']['cc_cansnow_eacpay'];
		$style='<style>.flex_row {display: flex;flex-direction: row;margin: 10px 0;}.flex_row>b {width: 80px;}.flex_col {display: flex;flex-direction: column;}.flex_1 {flex: 1;}.eacpay_remark {padding: 0 10px;}.eacpay_remark p {}'.
        '.eacdetaildata {display: none;}
		#qrcode>div {border: 3px dotted #666;border-radius: 5px;width: 157px;text-align: center;}
        #qrcode>div>div {line-height: 1;margin-bottom: 10px;}
        .eacpay_payment {border: 1px solid #ddd;display: inline-block;padding: 5px;vertical-align: baseline;}
        .eacpay_payment img {vertical-align: top;}
        .eacpay_payment span {padding: 0 5px;display: inline-block;height: 48px;line-height: 24px;font-weight: 700;}
		.cc_cansnow_eacpay{display:none;}</style>';
		return $style.'<script>var moneytype_title="'.$_G['setting']['extcredits'][$csetting['moneytype']]['title'].'";var exchangeData='.getExchange().';var moneybl='.$csetting['moneybl'].';var moneymin='.$csetting['moneymin'].';</script><script src="source/plugin/cc_cansnow_eacpay/jquery.min.js" type="text/javascript"></script><script src="source/plugin/cc_cansnow_eacpay/template/spacecp_credit_extra.js"></script>';
		return '<ul><li>'.$this->cc_cansnow_eacpay().'</li></ul>';
	}
}
*/
?>