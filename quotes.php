<?php
/*
 * Created on Mar 5, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

include("./lib/init.php");
$parser = _new("parser");

if(!(isset($_GET['action']) && $_GET['action'] != "")) {
	$_GET['action'] = "index";
}

if($_GET['action'] == 'add') {
	$parser->assign("save",false);
	$parser->setContent("ls/q.add.tpl");
}

if($_GET['action'] == 'index') {
	$page = 1; $epp = eppQuotes;
	if(isset($_GET['page'])) {
		$page = (int)$_GET['page'];
	}
	$start = ($epp * $page)-$epp;


	$c = _new("cache");
	if(!$res = $c->get("quotes")) {
		$db = _new("db");
		$db->saveQry("SELECT * FROM `#_quotes` ORDER BY `ID` DESC");
		while($row = $db->fetch_assoc()) {
			$res[$row['ID']] = $row;
		}
		$c->set("quotes",$res,time()+WEEK);
		$db->free();
	}

	$quotes = array_slice($res,$start, $epp);

	$db->saveQry("SELECT COUNT(*) as `datasets` FROM `#_quotes`");
	$count = $db->fetch_assoc(); $db->free();

	$parser->assign("p_act", $page);
	$parser->assign("p_epp", $epp);
	$parser->assign("p_url","./quotes.php");
	$parser->assign("p_cou", $count['datasets']);

	$parser->setNav(lang("addquo","misc"),  "./quotes.php?action=add");
	$parser->setNav(lang("rquote","misc"),  "./quotes.php?action=random");
	$parser->assign("quotes",$quotes);
	$parser->setContent("ls/quotes.tpl");
}

if($_GET['action'] == 'delete') {
	$id = (int)$_GET['id'];
	$db = _new("db");
	$c = _new("cache");
	$db->delete("quotes", "WHERE `ID` = '".$id."'");
	$c->delete("rquotes");
	$c->delete("quotes");
	$parser->setContent("ls/q.delete.tpl");
}

if($_GET['action'] == 'addquote') {
	$f = array("quote","who","where","added","by");
	$v = array($_POST['quote'],$_POST['who'],$_POST['where'],time(),UID);
	$db = _new("db");
	$db->insert("quotes",$f,$v);
	$c = _new("cache");
	$c->delete("quotes");
	$c->delete("rquotes");

	putChangelog(CLOG_PUBLIC, CLOG_QUOTE, UID, $db->returnID(),$_POST['who']);
	notify(NOTIFY_QUOTE,false,array($_POST['quote'],$_POST['who']));

	$parser->assign("save",true);
	$parser->setContent("ls/q.add.tpl");
}

if($_GET['action'] == 'random') {
	$c = _new("cache");
	if(!$res = $c->get("quotes")) {
		$db = _new("db");
		$db->saveQry("SELECT * FROM `#_quotes` ORDER BY `ID` DESC");
		while($row = $db->fetch_assoc()) {
			$res[$row['ID']] = $row;
		}
		$c->set("quotes",$res,time()+WEEK);
		$db->free();
	}

	shuffle($res);
	for($i = 0; $i< eppRandQuotes; $i++) {
		$return[] = $res[$i];
	}

	$parser->setNav(lang("addquo","misc"),  "./quotes.php?action=add");
	$parser->setNav(lang("rquote","misc"),  "./quotes.php?action=random");
	$parser->assign("quotes",$return);
	$parser->setContent("ls/q.rand.tpl");
}

$parser->display("index.tpl");
?>
