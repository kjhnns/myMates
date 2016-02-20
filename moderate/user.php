<?php
/*
 * Created on Nov 7, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */
include("./lib/init.php");
$parser = _new("parser");

if(!(isset($_GET['action']) && $_GET['action'] != "")) {
	$_GET['action'] = "index";
}

if($_GET['action'] == 'index') {
	$parser->setContent("ls/user.tpl");
}

if($_GET['action'] == 'create') {
	if(isset($_GET['save']) && $_GET['save']!="") {
		$db = _new("db");
		$pw = substr(mt_rand(),-4);
		$f = array("displayName","name","password","email","notify");
		$v = array($_POST['name'],$_POST['name'],md5($pw.PASSWORDUNIQUESTRING),$_POST['email'],62);
		$db->insert("user",$f,$v);
		$parser->assign("pw",$pw);
		$cache = _new("cache");
		$cache->delete("userInfo");
	}

	$parser->setContent("ls/ucreate.tpl");
}


$parser->display("sites/index.tpl");

?>
