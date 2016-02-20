<?php
/*
 * Created on 22.01.2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
*/

include("./lib/init.php");
$parser = _new("parser");

if(!(isset($_GET['action']) && $_GET['action'] != "")) {
	$_GET['action'] = "index";
}

if($_GET['action'] == 'index') {
	$parser->assign("delresult","0");
	$parser->setNav(lang("changelogArchive"),  "index.php?action=archive");
	$parser->setNav(lang("chatArchive"),  "index.php?action=chatarchive");
	$parser->setNav(lang("myProfil"),  "profile.php?uid=".UID);
	$parser->setNav(lang("myAcc","nav"),  "myAccount.php");
	$parser->setContent("ls/index.tpl");
	$parser->display("index.tpl");
}

if($_GET['action'] == 'rss') {
	$rss = _new("rss",lang("title","rss"),HTTP_ROOT,lang("desc","rss"));
	$db = _new("db");
	$db->saveQry("SELECT * FROM `#_changelog` WHERE `visible` = '0' OR `visible` = ? ORDER BY `time` DESC LIMIT 0,".eppRss, UID);
	while($row = $db->fetch_assoc()) {
		$txt = lang($row['key'], 'rss');
		if($txt != '') {
			$txt = lang($row['key'], 'rss');
			$search =array("%BY%","%NAME%","%REL%","%VAL%");
			$replace = array($row['by'],userInfo($row['by'],"displayName"),$row['related'],$row['value']);
			$row['value'] = str_replace($search,$replace,$txt);
		}
		$title =$row['value'];$link =HTTP_ROOT;
		switch($row['key']) {
			case CLOG_LINK: $title =lang("link").": ".http(urldecode($row['value'])); $link=http(urldecode($row['value']));break;
			case CLOG_PM:  $link=HTTP_ROOT."pm.php?action=read&amp;id=".$row['related'];break;
			case CLOG_GALLERY: $link=HTTP_ROOT."gallery.php?action=view&amp;gid=".$row['related'];break;
			case CLOG_THREAD: $link = HTTP_ROOT."board.php?action=thread&amp;tid=".$row['related']."#last";break;
			case CLOG_POST: $link = HTTP_ROOT."board.php?action=thread&amp;tid=".$row['related']."#last";break;
			case CLOG_PROFILE: $link = HTTP_ROOT."profile.php?uid=".$row['by']."&amp;show=profs";break;
			case CLOG_QUOTE: $link = HTTP_ROOT."quotes.php";break;
		}
		$rss->addItem(html($title),html($link),$row['time']);
	}
	$rss->output();
}

if($_GET['action'] == 'archive') {
	$page = 1; $epp = eppClogArchiv;
	if(isset($_GET['page'])) {
		$page = (int)$_GET['page'];
	}
	$start = ($epp * $page)-$epp;


	$cl = _new("changelog");
	$res = $cl->read($epp,$start);

	$db = _new("db");
	$db->saveQry("SELECT COUNT(*) as `datasets` FROM `#_changelog` WHERE `visible` = '0' OR `visible` = ?",UID);
	$count = $db->fetch_assoc(); $db->free();

	$parser->assign("p_act", $page);
	$parser->assign("p_epp", $epp);
	$parser->assign("p_url","./index.php?action=archive");
	$parser->assign("p_cou", $count['datasets']);

	$parser->assign("log", $res);
	$parser->setNav(lang("changelogArchive"),  "index.php?action=archive");
	$parser->setNav(lang("chatArchive"),  "index.php?action=chatarchive");
	$parser->setNav(lang("myProfil"),  "profile.php?uid=".UID);
	$parser->setNav(lang("myAcc","nav"),  "myAccount.php");
	$parser->setContent("ls/index.clog.tpl");
	$parser->display("index.tpl");
}

if($_GET['action'] == 'changeTemplate') {
	$sess = _new("session");
		if($_GET['tpl'] != "")
		$sess->changeTemplate($_GET['tpl']);
		else
		$sess->changeTemplate();
	$parser->display("sites/template.tpl");
}

if($_GET['action'] == 'chatarchive') {
	$page = 1; $epp = eppSboxArchiv;
	if(isset($_GET['page'])) {
		$page = (int)$_GET['page'];
	}
	$start = ($epp * $page)-$epp;

	$db = _new("db");
	$db->saveQry("SELECT * FROM `#_sbox` ORDER BY `ID` DESC LIMIT ".$start.",".$epp);
	while($row = $db->fetch_assoc()) {
		$res[] = $row;
	}

	$db->saveQry("SELECT COUNT(*) as `datasets` FROM `#_sbox`");
	$count = $db->fetch_assoc(); $db->free();

	$parser->assign("p_act", $page);
	$parser->assign("p_epp", $epp);
	$parser->assign("p_url","./index.php?action=chatarchive");
	$parser->assign("p_cou", $count['datasets']);

	$parser->assign("res", $res);
	$parser->setNav(lang("changelogArchive"),  "index.php?action=archive");
	$parser->setNav(lang("chatArchive"),  "index.php?action=chatarchive");
	$parser->setNav(lang("myProfil"),  "profile.php?uid=".UID);
	$parser->setNav(lang("myAcc","nav"),  "myAccount.php");
	$parser->setContent("ls/index.chat.tpl");
	$parser->display("index.tpl");
}

if($_GET['action'] == 'changeLang') {
	$sess = _new("session");
		if($_GET['lang'] != "")
		$sess->changeLang($_GET['lang']);
		else
		$sess->changeLang();
	$parser->display("sites/lang.tpl");
}
?>
