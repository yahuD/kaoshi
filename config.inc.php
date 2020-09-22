<?php
date_default_timezone_set('PRC');
defined('PHPOX') or die(header("HTTP/1.1 403 Not Forbidden"));
define('DOCUMENT_ROOT',__FILE__ ? dirname(__FILE__).'/' : './');

define('G_PHPOX_VAR','__PHPOX_CORE__');

define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_USER', 'root');
define('DB_PASS','root');
define('DB_NAME','kuks');
define('DB_CHARSET','utf8');
define('DB_PREFIX','kp_');



define('CHARSET','utf-8');
define('SYSTEM_RUN',true);

define('SMARTY_DIR', dirname(__FILE__).'/smarty/');
define('SMARTY_SYSPLUGINS_DIR', dirname(__FILE__).'/smarty/sysplugins/');
define('HOSTNAME',empty($_SERVER['HTTPS']) ?  'http://'.$_SERVER['HTTP_HOST'] : 'https://'.$_SERVER['HTTP_HOST']);
define('CDN_DOMAIN_BASE','');
define('CDN_DOMAIN_BBS','');

define('PATH','/');
define('PAGESIZE',20);


?>