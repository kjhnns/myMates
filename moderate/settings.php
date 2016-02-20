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

	$db->saveQry("SELECT `key`,`value` FROM `#_settings` WHERE `rowType` = 'attribute' and `key` != 'MOD_PW'");
	while($row = $db->fetch_assoc()) {
		$row['lng'] = 'att_'.$row['key'];
		$attributes[] = $row;
	}
	$langs = _scandir(LANGUAGES);
	foreach($langs as $v) $_ls[] = basename ($v,".lang.php");
	$webroot = _scandir(WEBROOT,true);
	$db->free();

	$db->saveQry("SELECT `key`,`value` FROM `#_settings` WHERE `rowType` = 'epp'");
	while($row = $db->fetch_assoc()) {
		$row['lng'] = 'epp_'.$row['key'];
		$epps[] = $row;
	}
	$db->free();

	$parser->assign("atts",$attributes);
	$parser->assign("epps",$epps);
	$parser->assign("langs",$_ls);
	$parser->assign("temps",$webroot);
	$parser->setContent("ls/settings.tpl");
}

if($_GET['action']=='editpw') {
	$db = _new("db");
	$db->update("settings",array("value"),array(md5($_POST['pw1'].PASSWORDUNIQUESTRING)),"WHERE `key` = 'MOD_PW'");
	$c = _new("cache");
	$c->delete("SETTINGS");

	$parser->assign("title",lang("editpwtitle","mod"));
	$parser->assign("text",lang("editpwtext","mod").$pw);
	$parser->setContent("ls/success.tpl");
}

if($_GET['action']=='editEpps') {
	$db = _new("db");
	foreach($_POST['epps'] as $k => $v) {
		$db->update("settings",array("value"),array($v),"WHERE `key` = '".$k."'");
	}
	$c = _new("cache");
	$c->delete("SETTINGS");

	$parser->assign("title",lang("editeppstitle","mod"));
	$parser->assign("text",lang("editeppstext","mod").$pw);
	$parser->setContent("ls/success.tpl");
}

if($_GET['action']=='editAttributes') {
	$db = _new("db");
	foreach($_POST['atts'] as $k => $v) {
		$db->update("settings",array("value"),array($v),"WHERE `key` = '".$k."'");
	}
	$c = _new("cache");
	$c->delete("SETTINGS");

	$parser->assign("title",lang("editattstitle","mod"));
	$parser->assign("text",lang("editattstext","mod").$pw);
	$parser->setContent("ls/success.tpl");
}

$parser->display("sites/index.tpl");

?>
