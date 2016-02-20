<?php
/*
 * Created on 10.06.2008
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

/*
 * CORE INITIATION
 *
 */

/*
 * INIT BENCHMARK
 */
function _microTime() { list($a,$b) = explode(" ", microtime()); return $a+$b;}
define("BENCHSTART", _microTime());
$GLOBALS['_GLOBAL_QRYS'] = 0;

/*
 * INC DEFINITIONS
 */
require_once("./etc/roots.init.php");
if(!file_exists(CONF."system.init.php") && is_dir(ROOT."setup/")) header("Location: ./setup/");
require_once(CONF."system.init.php");
define("MODERATE", false);

/*
 * PHP CONFIG
 */
@session_save_path(SESSIONSAVEPATH);
session_start();
@set_magic_quotes_runtime(0);
mt_srand((double)microtime() * 10000);
ob_start();

/*
 * DEF DEBUG MODE
 */
if(!defined("DEBUG")) define("DEBUG", DEBUGSETTINGS);
if(DEBUG) {
	error_reporting(E_ALL & ~E_NOTICE);
	$debugLogArray = NULL;
	include(FUNCLIB."debugLog.php");
} else {
   	error_reporting(0);
	function debugLog() { return 0; }
}

/*
 * MISC
 */
if(!defined("PICFASTRENDER")) 		define("PICFASTRENDER", false);
if(!defined("NOLASTACTREFRESH")) 	define("NOLASTACTREFRESH", false);
include(MAIN."version.init.php");
include(BACKEND."functions.php");
include(MAIN."requirementCheck.php");
/*
 * DEFINE PREFERENCES
 */
/*
 * LOAD SETTINGS
 */
loadSettings();
if(is_dir(ROOT."setup/")) dispError(10);
/*
 * user login status
 */
$_prefs['user'] = _new("user"); $login_return = false;
if(isset($_POST['trytologin']) && $_POST['trytologin'] == 'true') {
	if($_POST['email'] == "") $_POST['email'] = "wrong";
	if($_POST['pass'] == "") $_POST['pass'] = "wrong";
	if(isset($_POST['saveLogin']) && $_POST['saveLogin'] == 'true') {
		$login_return = $_prefs['user']->login($_POST['email'],$_POST['pass'], true);
	} else {
		$login_return = $_prefs['user']->login($_POST['email'],$_POST['pass']);
	}
	define("LOGINSITE", TRUE);
} else {
	$_prefs['user']->login();
}
if($_prefs['user']->logged()) { define("UID",$_prefs['user']->logged()); }
else {
	define("UID",false);
	if(!defined("LOGINSITE")) define("LOGINSITE", TRUE);
}
if(!NOLASTACTREFRESH && UID) {
	$db = _new("db");
	$db->update("user",array("lastAct"), array(time()), "WHERE `ID` = '".UID."'");
}

if(!PICFASTRENDER) {
/*
 * session
 */
$_prefs['session'] = _new("session");
$_prefs['session']->sessionCrons();
if(!NOLASTACTREFRESH)
	$_prefs['session']->_onlineList();
/*
 * TEMPLATE & LANGUAGE FILES
 */
$_prefs['session']->template();
$_prefs['session']->language();
}

/*
 * USER DEFINITIONS
 */
$ava=AVATARS.md5(UID);
if(file_exists($ava) && $ava != AVATARS) {
	define("UAVATAR", $ava);
} else {
	define("UAVATAR", TEMPLATE."misc/avatar.png");
}
define("UDNAME", $_prefs['user']->info("displayName"));


/*
 * LOGINSITE ???
 */
if(!defined("LOGINSITE")) define("LOGINSITE", false);
if(!PICFASTRENDER) {
	if(LOGINSITE && ($login_return == LOGIN_SUCCESS || $login_return == LOGIN_CKSUCCESS)) {
		$parser = _new("parser");
		if($login_return == LOGIN_SUCCESS) {
			$parser->assign("cookie","false");
		} else {
			$parser->assign("cookie","true");
		}
		$parser->display("sites/login_success.tpl");
		exit();
	} elseif(LOGINSITE && $login_return == LOGIN_FAILED) {
		$parser = _new("parser");
		$parser->assign("error", true);
		$parser->display("sites/login.tpl");
		exit();
	} elseif(LOGINSITE && $login_return === FALSE) {
		$parser = _new("parser");
		$parser->assign("error", false);
		$parser->display("sites/login.tpl");
		exit();
	}
} else {
	if(LOGINSITE) {
		echo "error no permission";
	}
}


define("InitBench",_microTime() - BENCHSTART);
debugLog("Initialisierung beendet", "Enviroment wurde initialisiert");
define("afterInitBench",_microTime());
?>
