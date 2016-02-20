<?php
/*
 * Created on Mar 5, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */
include("./lib/init.php");

function cacheProfiles($id) {
	$c = _new("cache");
	if(!$res =$c->get("userProfile:".$id)) {
		$db = _new("db");
		$db->saveQry("SELECT * FROM `#_profiles` WHERE `user` = ? ORDER BY `ID` DESC",$id);
		while($r = $db->fetch_assoc()) {
			$res[$r['ID']] = $r;
		}
		$c->set("userProfile:".$id, $res, time() + MONTH);
	}
	return $res;
}

$parser = _new("parser");

if(!(isset($_GET['action']) && $_GET['action'] != "")) {
	$_GET['action'] = "index";
}

if($_GET['action'] == 'index') {
 	if(isset($_GET['uid']) && $_GET['uid'] != "" && $_GET['uid'] != UID) {
 		$uid = (int)$_GET['uid'];
 		$parser->setNav(lang("sendMsg"), "pm.php?action=send&amp;uid=".$uid);

 		if(isset($_GET['delete']) && $_GET['delete'] != 0) {
 			$did = (int)$_GET['delete'];
			$db = _new("db");
			$db->delete("profiles","WHERE `ID` = ".$did." AND `user` = '".$uid."'");
			$c = _new("cache");
			$c->delete("userProfile:".$uid);
			$parser->assign("deleted",true);
 		}
 	} else {
 		$uid = UID;
 		$parser->setNav(lang("myAccount"), "myAccount.php");
 	}
 	$cache = _new("cache");
	$users = $cache->get("userInfo");
	$sess = _new("session");
 	$parser->assign("user",$users[$uid]);
 	$parser->assign("posts",$sess->userPosts($uid));
 	$parser->assign("profs",cacheProfiles($uid));

	setTitle($users[$uid]['displayName']);
	$parser->setContent("ls/profile.tpl");
}

if($_GET['action'] == 'members') {
	$cache = _new("cache");
	$users = $cache->get("userInfo");
	$parser->assign("users", $users);
	$parser->setContent("ls/members.tpl");
}

$parser->display("index.tpl");
?>
