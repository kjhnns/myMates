<?php
/*
 * Created on Feb 23, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

include("./lib/init.php");
$parser = _new("parser");

if(!(isset($_GET['action']) && $_GET['action'] != "")) {
	$_GET['action'] = "index";
}

if($_GET['action'] == 'index') {
	$parser->setContent("ls/myAccount.tpl");
}

if($_GET['action'] == 'changeAvatar') {
	if(isset($_GET['upload'])) {
		if((int)$_FILES['pic']['size'] <= AVATARSIZELIMIT) {
			if($_prefs['user']->uploadAvatar($_FILES['pic']['tmp_name'])) {
				$parser->assign("title",lang("catitle","macc"));
				$parser->assign("result",lang("casuccess","macc"));
				$parser->assign("back","myAccount.php?action=changeAvatar");
				$parser->setContent("ls/success.tpl");
			} else {
				$parser->assign("result",lang("caerror","macc"));
				$parser->setContent("ls/macc.changeAvatar.tpl");
			}
		} else {
			$parser->assign("result",lang("caerror.size","macc"));
			$parser->setContent("ls/macc.changeAvatar.tpl");
		}
	} else {
		$parser->setContent("ls/macc.changeAvatar.tpl");
	}
}

if($_GET['action'] == 'editInfos') {
 	if(isset($_GET['edit']) && $_GET['edit'] == 'true') {
		$db =_new("db");
		$f = array("name","displayName","icq", "msn", "skype", "mobile","signature");
		foreach($f as $vls) {
			$v[] = $_POST[$vls];
		}
		$f[] = "bday";
		$v[] = $_POST['Date_Year']."-".$_POST['Date_Month']."-".$_POST['Date_Day'];
		$db->update("user",$f, $v, "WHERE `ID` = '".UID."'");
		$sess = _new("session");
		$sess->changedUser(USER_CHANGE_INFOS);
		putChangelog(CLOG_PUBLIC, CLOG_INFOS, UID);
		$cache = _new("cache");
		$sbt['post']=time();
		$cache->set("sbTimes", $sbt, time()+WEEK);

		$parser->assign("title",lang("eititle","macc"));
		$parser->assign("result",lang("eisuccess","macc"));
		$parser->assign("back","myAccount.php?action=editInfos");
		$parser->setContent("ls/success.tpl");
 	} else {
 		$cache = _new("cache");
		$users = $cache->get("userInfo");
	 	$parser->assign("user",$users[UID]);
		$parser->setContent("ls/macc.editInfos.tpl");
 	}
}

if($_GET['action'] == 'editLogin') {
 	if(isset($_GET['edit']) && $_GET['edit'] == 'true') {
		if($_POST['pw'] == $_POST['pw2']) {
			$f = array("email");
			$v = array($_POST['email']);

			if($_POST['pw'] != '      ') {
				$pw = md5($_POST['pw'].PASSWORDUNIQUESTRING);
				$f[] = 'password';
				$v[] = $pw;
			}
			$db =_new("db");
			$db->update("user",$f,$v,"WHERE `ID` = '".UID."'");
			$sess = _new("session");
			$sess->changedUser();

			$parser->assign("title",lang("eltitle","macc"));
			$parser->assign("result",lang("elsuccess","macc"));
			$parser->assign("back","myAccount.php");
			$parser->setContent("ls/success.tpl");
		} else {
			$parser->assign("title",lang("eltitle","macc"));
			$parser->assign("text",lang("elerror","macc"));
			$parser->assign("back","myAccount.php");
			$parser->setContent("ls/error.tpl");
		}
 	} else {
 		$cache = _new("cache");
		$users = $cache->get("userInfo");
	 	$parser->assign("user",$users[UID]);
		$parser->setContent("ls/macc.login.tpl");
 	}
}

if($_GET['action'] == 'editFavs') {
 	if(isset($_GET['edit']) && $_GET['edit'] == 'true') {
		$db =_new("db");
		$f = array("favMovie","favMusic","favFood","favPlace","favCar","favSports","favSportsclub","favHp1","favHp2","favHp3");
		foreach($f as $vls) {
			$v[] = $_POST[$vls];
		}
		$db->update("user",$f, $v, "WHERE `ID` = '".UID."'");
		$sess = _new("session");
		$sess->changedUser(USER_CHANGE_FAVS);
		putChangelog(CLOG_PUBLIC, CLOG_FAVS, UID);

		$parser->assign("title",lang("eftitle","macc"));
		$parser->assign("result",lang("efsuccess","macc"));
		$parser->assign("back","myAccount.php?action=editFavs	");
		$parser->setContent("ls/success.tpl");
 	} else {
 		$cache = _new("cache");
		$users = $cache->get("userInfo");
	 	$parser->assign("user",$users[UID]);
		$parser->setContent("ls/macc.editFavs.tpl");
 	}
}

if($_GET['action'] == 'notification') {
 	if(isset($_GET['edit']) && $_GET['edit'] == 'true') {
		$notify = 0;
		foreach($_notify_level as $cat => $val) {
			if($_POST['not'][$cat] == 'on') {
				$notify += $val;
			}
		}
		$db = _new("db");
		$db->update("user",array("notify"),array($notify),"WHERE `ID` = '".UID."'");

		$sess = _new("session");
		$sess->changedUser();
		$parser->assign("title",lang("entitle","macc"));
		$parser->assign("result",lang("ensuccess","macc"));
		$parser->assign("back","myAccount.php?action=notification");
		$parser->setContent("ls/success.tpl");
 	} else {
	$lvl = userInfo(UID,"notify");
	foreach($_notify_level as $cat => $val) {
		if($lvl & $val) {
			$level[$cat] = true;
		} else {
			$level[$cat] = false;
		}
	}
	$parser->assign("nofs",$level);
	$parser->setContent("ls/macc.notify.tpl");
 	}
}

$parser->display("index.tpl");
?>
