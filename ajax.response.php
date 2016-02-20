<?php
/*
 * Created on Apr 5, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

// COMMENT
if($_GET['section'] == 'comment') {
	define("DEBUG", false);
	define("NOLASTACTREFRESH", true);
	include("./lib/init.php");
	postComment(html(utf8_decode($_REQUEST['text'])), $_REQUEST['cat'], $_REQUEST['item'], $_REQUEST['report']);
}


// CHANGELOG
if($_GET['section'] == 'clog') {
	if($_GET['action'] == 'post') {
		define("DEBUG", false);
		define("NOLASTACTREFRESH", false);
		include("./lib/init.php");

		$cl = _new("changelog");
		if($_REQUEST['key'] == 'clogstatus') {
			$_prefs['user']->statusUpdate(utf8_decode($_REQUEST['text']),html($_REQUEST['key']));
			$cl->post(CLOG_PUBLIC, CLOG_STATUS, UID, false, utf8_decode($_REQUEST['text']));
			$cache = _new("cache");	$cache->set("changelog_change",time(),time()+day);
		}
		if($_REQUEST['key'] == 'cloglink') {
			$cl->post(CLOG_PUBLIC, CLOG_LINK, UID, false, urlencode($_REQUEST['text']));
			$cache = _new("cache");	$cache->set("changelog_change",time(),time()+day);
		}
	} elseif($_GET['action'] == 'fetch') {
		define("DEBUG", false);
		define("NOLASTACTREFRESH", false);
		include("./lib/init.php");

		$parser = _new("parser");
		$cl = _new("changelog");
		$clog=$cl->read();
		$parser->assign("log", $clog);
		$parser->display("misc/clog.tpl");
		$_SESSION['lastChangelog_refresh_'.UID] = time();
	} elseif($_GET['action'] == 'whatsup') {
		define("DEBUG", false);
		define("NOLASTACTREFRESH", false);
		include("./lib/init.php");

		$cache = _new("cache");
		$res = $cache->get("changelog_change");
		if($_SESSION['lastChangelog_refresh_'.UID] > $res && $cache->get("changelog_content")) {
			echo "0";
		} else {
			echo "1";
		}
	} elseif($_GET['action'] == 'delete') {
		include("./lib/init.php");
		$parser = _new("parser");
		$cl = _new("changelog");
		$res = $cl->delete($_GET['id']);
		if($res !== FALSE) {
			$parser->assign("delresult","2");
		} else {
			$parser->assign("delresult","1");
		}

		$parser->setNav(lang("myProfil"),  "profile.php?uid=".UID);
		$parser->setNav(lang("myAcc","nav"),  "myAccount.php");
		$parser->setContent("ls/index.tpl");

		$parser->display("index.tpl");
	}
}


//attendance Status
if($_GET['section'] == 'attStatus') {
	define("DEBUG", false);
	define("NOLASTACTREFRESH", false);
	include("./lib/init.php");

	$id = md5($_POST['threadID'].UID);
	$db = _new("db");
	$db->insert("attend",array("ID","user","status","thread"),
	array($id,UID,$_POST['stat'],$_POST['threadID']),true);
	$c = _new("cache");
	$c->delete("thread:".$_POST['threadID']);
}



//USER PROFILES
if($_GET['section'] == 'profile') {
	define("DEBUG", false);
	define("NOLASTACTREFRESH", false);
	include("./lib/init.php");
	if($_POST['text'] != "" && $_POST['user'] != UID) {
	$db = _new("db");
	$db->insert("profiles",array("text","user"),
	array(utf8_decode($_POST['text']),$_POST['user']));
	$c = _new("cache");
	$c->delete("userProfile:".$_POST['user']);


	putChangelog(CLOG_PUBLIC, CLOG_PROFILE, $_POST['user'], 0);
	notify(NOTIFY_PROFILE,userInfo($_POST['user'],'displayName'),array(userInfo($_POST['user'],'displayName'),$_POST['text']));
	}
}


// CHAT
if($_GET['section'] == 'chat') {
	if(isset($_GET['act'])) {
		if($_GET['act'] == 'fetch') {
			define("DEBUG", false);
			define("NOLASTACTREFRESH", true);
			include("./lib/init.php");
		 	$cache = _new("cache");
		 	$sbt = $cache->get("sbTimes");
		 	if($sbt['fetch'] == "" or $sbt['post'] == "") {
		 		$sbt['fetch'] = time()-1;$sbt['post'] = time();
		 	}
			$sbcache = $cache->get("sbCache");
			if($sbt['post'] >= $sbt['fetch']) {
				$db = _new("db");
				$db->saveQry("SELECT * FROM `#_sbox` ORDER BY `ID` DESC LIMIT 0,".CHATBOXPOSTS);
				$sbcache = ""; $first = true;
				while($row = $db->fetch_assoc()) {
					if($first) {
						$sbFirst = sprintf(tplCfg("chatboxrow"),
									$row['user'],$_prefs['session']->uName($row['user']), $row['text']);
						$first = false;
					} else {
					$sbcache .= sprintf(tplCfg("chatboxrow"),
									$row['user'],$_prefs['session']->uName($row['user']), $row['text']);
					}
				}
				$db->free();
				$cache->set("sbCache",$sbFirst.$sbcache,time()+WEEK);
				$sbt['fetch']=time();
				$cache->set("sbTimes", $sbt, time()+WEEK);
				$sbcache =  sprintf(tplCfg("chatboxrownew"),$sbFirst,$sbcache);
			}
			$sess = _new("session");
			echo sprintf(tplCfg("chatboxonlineuser"),$sess->online(),$sess->online(),$sbcache);
	 	}elseif($_GET['act'] == 'write') {
			define("DEBUG", false);
			define("NOLASTACTREFRESH", false);
			include("./lib/init.php");
		 	$cache = _new("cache");
		 	$sbt = $cache->get("sbTimes");
		 	if($sbt['fetch'] == "" or $sbt['post'] == "") {
		 		$sbt['fetch'] = time()-1;$sbt['post'] = time();
		 	}
			$sbt['post']=time();
			$cache->set("sbTimes", $sbt, time()+WEEK);
			$db =_new("db");
			$db->insert("sbox", array("user", "text"), array(UID, utf8_decode($_REQUEST['text'])));
	 	}
	}
}
?>
