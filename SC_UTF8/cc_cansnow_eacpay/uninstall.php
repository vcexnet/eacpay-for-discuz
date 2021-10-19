<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$sql = <<<EOF
DROP TABLE IF EXISTS `cdb_eacpay_order`;
DROP TABLE IF EXISTS `cdb_eacpay_address`;
EOF;
runquery($sql);

$finish = true;
