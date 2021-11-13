<?php
/*
 * Install Uninstall Upgrade AutoStat System Code 2021092519UViX9TVi3L
 * This is NOT a freeware, use is subject to license terms
 * From www.1314study.com
 */
if(!defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$sql = file_get_contents(DISCUZ_ROOT.'/source/plugin/cc_cansnow_eacpay/install.sql');

runquery($sql);
$finish = TRUE;
