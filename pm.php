<?php
/*
 * Created on Mar 5, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

include("./lib/init.php");
$parser = _new("parser");

function quote($str) {
	$str = explode("\n",$str);
	foreach($str as $row) {
		$new[] = "> ".wordwrap($row,55,"\n> ",true);
	}
	$str= implode("\n",$new);
	$str = "\n\n-----------------------------\n".$str;
	return $str;
}

if(!(isset($_GET['action']) && $_GET['action'] != "")) {
	$_GET['action'] = "index";
}

if($_GET['action'] == 'delete') {
	$id = (int)$_GET['id'];
	if(isset($_GET['delete'])) {
		$db = _new("db");
		$db->saveQry("DELETE FROM `#_pms` WHERE `ID`=? AND `rID` = ?",$id,UID);
		$parser->assign("do", true);
	} else {
		$parser->assign("id", $id);
		$parser->assign("do", false);
	}
	$parser->setNav(lang("newMsg","pm"), 	 "pm.php?action=send");
	$parser->setNav(lang("inbox","pm"),  "pm.php");
	$parser->setNav(lang("outbox","pm"), "pm.php?action=outbox");
	$parser->setContent("ls/pm.delete.tpl");
}

if($_GET['action'] == 'read') {
	$id = (int)$_GET['id'];
	$db = _new("db");
	$db->saveQry("SELECT * FROM `#_pms` WHERE `ID` = ? AND (`rID` = ? OR `sID` = ?)",$id,UID,UID);
	$res = $db->fetch_assoc(); $db->free();

	if($res['ID'] != "") {
		if($res['new'])	$db->saveQry("UPDATE `#_pms` SET `new` = '0' WHERE `ID` = ?",$id);
		$res['text'] = nl2br(textCodes($res['text']));

		if($res['rID'] == UID){
			$parser->assign("role","receiver");
			$parser->setNav(lang("reply","pm"), 	 "pm.php?action=send&amp;reply=".$id);
			$parser->setNav(lang("delete","pm"), 	 "pm.php?action=delete&amp;id=".$id);
		}else{
			$parser->assign("role","sender");
		}

		$parser->setNav(lang("newMsg","pm"), 	 "pm.php?action=send");
		$parser->setNav(lang("inbox","pm"),  "pm.php");
		$parser->setNav(lang("outbox","pm"), "pm.php?action=outbox");
		$parser->assign("message",$res);
		$parser->setContent("ls/pm.read.tpl");
	}
}

if($_GET['action'] == 'deliver') {
	$_POST['receiver'] = (int)$_POST['receiver'];

	if($_POST['text'] == "") {
		$parser->assign("title", lang("errtext","pm"));
		$parser->assign("text",	 lang("errtexttext","pm"));
		$parser->assign("back",	 "javascript:history.back()");
		$parser->setContent("ls/error.tpl");
	} elseif($_POST['receiver'] == UID) {
		$parser->assign("title", lang("errrID","pm"));
		$parser->assign("text",	 lang("errrIDtext","pm"));
		$parser->assign("back",	 "javascript:history.back()");
		$parser->setContent("ls/error.tpl");

	} else {
		$db = _new("db");
		$fields = array("title","text","rID","sID","time");
		$values = array($_POST['title'],$_POST['text'],$_POST['receiver'],UID,time());
		$db->insert("pms",$fields, $values);
		$id = $db->returnID();

		$c = _new("cache");
		$c->set("unreadPms:".$_POST['receiver'], true, time()+MONTH);

		putChangelog($_POST['receiver'], CLOG_PM, UID, $id);

		$parser->assign("title", lang("sTitle","pm"));
		$parser->assign("result", lang("sText","pm"));
		$parser->assign("back", "pm.php");
		$parser->setContent("ls/success.tpl");
	}
}

if($_GET['action'] == 'index') {
	$db = _new("db");

	$page = 1; $epp = eppPm;
	if(isset($_GET['page'])) {
		$page = (int)$_GET['page'];
	}
	$start = ($epp * $page)-$epp;

	$db->saveQry("SELECT COUNT(*) as `datasets` FROM `#_pms` WHERE `rID` = ?",UID);
	$count = $db->fetch_assoc(); $db->free();

	$parser->assign("p_act", $page);
	$parser->assign("p_epp", $epp);
	$parser->assign("p_url", "pm.php");
	$parser->assign("p_cou", $count['datasets']);

	$db->saveQry("SELECT * FROM `#_pms` WHERE `rID` = ? ORDER BY `ID` DESC LIMIT ".$start.",".$epp,UID);
	while($row = $db->fetch_assoc()) {
		$res[$row['ID']] = $row;
	}
	$db->free();
	$parser->assign("messages", $res);

	$parser->setNav(lang("newMsg","pm"), 	 "pm.php?action=send");
	$parser->setNav(lang("outbox","pm"), "pm.php?action=outbox");
	$parser->setContent("ls/pm.tpl");
}

if($_GET['action'] == 'send') {
	if(isset($_GET['reply'])) {
		$db = _new("db");
		$db->saveQry("SELECT * FROM `#_pms` WHERE `ID` = ? AND `rID` = ?",$_GET['reply'],UID);
		$res = $db->fetch_assoc(); $db->free();
		if($res['ID'] != "") {
			$parser->assign("receiver",$res['sID']);
			$parser->assign("title",$res['title']);
			$parser->assign("text",quote($res['text']));
		} else {
			$sess = _new("session");
			$parser->assign("receiver",$sess->usersInfo("displayName"));
		}
	} elseif(isset($_GET['uid'])) {
		$uid = (int)$_GET['uid'];
		$parser->assign("receiver",$uid);
	} else {
		$sess = _new("session");
		$parser->assign("receiver",$sess->usersInfo("displayName"));
	}

	$parser->setNav(lang("inbox","pm"),  "pm.php");
	$parser->setNav(lang("outbox","pm"), "pm.php?action=outbox");
	$parser->setContent("ls/pm.send.tpl");
}

if($_GET['action'] == 'outbox') {
	$db = _new("db");

	$page = 1; $epp = eppPm;
	if(isset($_GET['page'])) {
		$page = (int)$_GET['page'];
	}
	$start = ($epp * $page)-$epp;

	$db->saveQry("SELECT COUNT(*) as `datasets` FROM `#_pms` WHERE `sID` = ?",UID);
	$count = $db->fetch_assoc(); $db->free();

	$parser->assign("p_act", $page);
	$parser->assign("p_epp", $epp);
	$parser->assign("p_url", "pm.php?action=outbox");
	$parser->assign("p_cou", $count['datasets']);

	$db->saveQry("SELECT * FROM `#_pms` WHERE `sID` = ? ORDER BY `ID` DESC LIMIT ".$start.",".$epp,UID);
	while($row = $db->fetch_assoc()) {
		$res[$row['ID']] = $row;
	}
	$db->free();
	$parser->assign("messages", $res);

	$parser->setNav(lang("newMsg","pm"), 	 "pm.php?action=send");
	$parser->setNav(lang("inbox","pm"),  "pm.php");
	$parser->setContent("ls/pm.outbox.tpl");
}

$parser->display("index.tpl");
?>
