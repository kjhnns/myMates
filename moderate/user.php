<?php
/*
 * Created on Nov 7, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */
include("./lib/init.php");

if(!(isset($_GET['action']) && $_GET['action'] != "")) {
	$_GET['action'] = "index";
}

if($_GET['action'] == 'index') {
	$db = _new("db");
	$db->saveQry("SELECT `ID`,`displayName`,`email`,`template`,`language` FROM `#_user` WHERE `password` != 'deleted'");
	while($row = $db->fetch_assoc())
	$res[] = $row;

	$parser->assign("res",$res);
	$parser->setContent("ls/user.tpl");
}

if($_GET['action'] == 'create') {
	if(isset($_GET['save']) && $_GET['save']!="") {
		$db = _new("db");
		$pw = substr(rand(),-4);
		$f = array("displayName","name","password","email","notify");
		$v = array($_POST['name'],$_POST['name'],md5($pw.PASSWORDUNIQUESTRING),$_POST['email'],62);
		$db->insert("user",$f,$v);
		$s = _new("session");
		$s->changedUser();

		$parser->assign("title",lang("creausertitle","mod"));
		$parser->assign("text",lang("creausertext","mod").$pw);
		$parser->setContent("ls/success.tpl");
	} else $parser->setContent("ls/ucreate.tpl");
}

if($_GET['action'] == 'delete') {
	$db = _new("db");
	$f = array("displayName","name","email","notify","password");
	$v = array("#######","#######","######","0","deleted");
	$db->update("user",$f,$v,"WHERE `ID` = '".(int) $_GET['id']."'");
	$c = _new("cache");
	$c->delete("userInfo");

	$parser->assign("title",lang("delusertitle","mod"));
	$parser->assign("text",lang("delusertext","mod"));
	$parser->setContent("ls/success.tpl");
}

if($_GET['action']=='resetpw') {
	$pw = substr(rand(),-4);
	$db = _new("db");
	$db->update("user",array("password"),array(md5($pw.PASSWORDUNIQUESTRING)),"WHERE `ID` = '".(int)$_GET['id']."'");


	$parser->assign("title",lang("resetpwtitle","mod"));
	$parser->assign("text",lang("resetpwtext","mod").$pw);
	$parser->setContent("ls/success.tpl");
}


$parser->display("sites/index.tpl");

?>
