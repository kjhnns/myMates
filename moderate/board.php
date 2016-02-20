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
	$db->saveQry("SELECT * FROM `#_boards`");
	while($row = $db->fetch_assoc()) $res[] = $row;
	$parser->assign("res",$res);
	$parser->setContent("ls/board.tpl");
}

if($_GET['action']=='add') {
	$db = _new("db");
	$db->insert("boards",array("title","desc"),array($_POST['title'],$_POST['desc']));
	$c = _new("cache");
	$c->delete("boards");

	$parser->assign("title",lang("addboardtitle","mod"));
	$parser->assign("text",lang("addboardtext","mod").$pw);
	$parser->setContent("ls/success.tpl");
}

if($_GET['action']=='delete') {
	$db = _new("db");
	$db->delete("boards","WHERE `ID` = '".(int)$_GET['id']."'");
	$c = _new("cache");
	$c->delete("boards");

	$parser->assign("title",lang("delboardtitle","mod"));
	$parser->assign("text",lang("delboardtext","mod").$pw);
	$parser->setContent("ls/success.tpl");
}

$parser->display("sites/index.tpl");

?>
