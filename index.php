<?php
error_reporting(0);
define('DEBUG', false);
define('SMARTY_FORCE_COMPILE', false);

set_time_limit(0);
!defined('PHPOX') && define('PHPOX',true);
define('APP_PATH', dirname(__FILE__).'/' );

require_once('include/functions.php');
require_once('config.inc.php');
$GLOBALS[G_PHPOX_VAR]['APP_INF'] = require_once(DOCUMENT_ROOT.'/app_inf.php');

require_once('App/FrameWork/DTC.php');
DTC::registerAutoload();

if (DEBUG == true){
	define('ERROR_TYPES', E_ERROR | E_WARNING | E_PARSE );
	//define('ERROR_TYPES', E_ALL);
	error_reporting(ERROR_TYPES);
	ErrorHandler::SetHandler();
}

$DTC = new DTC();
$DTC->appRun();

//log_visitor();

?>