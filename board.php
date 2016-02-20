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
	return $str;
}

function cacheThread($id) {
	$c=_new("cache");
	if(!$res = $c->get("thread:".$id)) {
		$db2 = _new("db");
		$db2->saveQry("SELECT * FROM `#_threads` WHERE `ID` = ?",$id);
		$row = $db2->fetch_assoc();
		$db2->saveQry("SELECT * FROM `#_posts` WHERE `thread` = ? ORDER BY `ID` DESC",$id);
		$row['lpost'] = $db2->fetch_assoc();
		unset($row['lpost']['text']);
		$row['posts'] = $db2->numRows("posts","WHERE `thread` = '".$id."'");
		$row['sites'] = ceil($row['posts']/eppPosts);
		if($row['attendance'] == '1') {
			$db2->saveQry("SELECT * FROM `#_attend` WHERE `thread` = ?",$row['ID']);
			while($r = $db2->fetch_assoc()) {
				$attends[$r['ID']] = $r;
			}
			$row['attends'] = $attends;
		} else {
			$row['attends'] = 0;
		}
		$res = $row;
		$c->set("thread:".$id,$row,time()+WEEK);
	}
	return $res;
}

function cacheBoard($id) {
	$c = _new("cache");
	if(!$res = $c->get("boardInfo:".$id)) {
		$db2 = _new("db");$db3 = _new("db");
		$db2->saveQry("SELECT * FROM `#_boards` WHERE `ID`=?",$id);
		$row = $db2->fetch_assoc();
		$row['threads'] =$db2->numRows("threads", "WHERE `board`='".(int)$id."'");
		$db2->saveQry("SELECT COUNT(`#_posts`.`ID`) as `posts` " .
				"FROM `#_threads` INNER JOIN `#_posts` ON `#_threads`.`ID` = `#_posts`.`thread` " .
				"WHERE `#_threads`.`board` = ?",$id);
		$r = $db2->fetch_assoc();
		$row['posts'] = $r['posts'];
		$db2->free();
		$res = $row;
		$c->set("boardInfo:".$id,$res,time()+MONTH);
	}
	return $res;
}

function cachePosts($id) {
	$c = _new("cache");
	if(!$res = $c->get("posts:".$id)) {
		$db = _new("db");
		$db->saveQry("SELECT * FROM `#_posts` WHERE `thread` = ? ORDER BY `ID`",$id);
		while($row = $db->fetch_assoc()) {
			$row['text'] = textCodes($row['text']);
			$res[$row['ID']] = $row;
		}
		$db->free();
		$c->set("posts:".$id, $res,time()+MONTH);
	}
	return $res;
}

if(!(isset($_GET['action']) && $_GET['action'] != "")) {
	$_GET['action'] = "index";
}

if($_GET['action'] == 'index') {
	$c=_new("cache");
	if(!$res = $c->get("boards")) {
		$db = _new("db");
		$db->saveQry("SELECT * FROM `#_boards` ORDER BY `title`");
		while($row = $db->fetch_assoc()) {
			$res[] = cacheBoard($row['ID']);
		}
		$c->set("boards",$res,time()+WEEK);
		$db->free();
	}
	if(!$res) unset($res);
	$parser->setNav(lang("addboard","board"),  "./board.php?action=board&do=add");
	$parser->setNav(lang("delboard","board"),  "./board.php?action=board&do=del");

	$parser->assign("res",$res);
	$parser->setContent("ls/board.tpl");
}

if($_GET['action'] == 'post') {
	if($_GET['do'] == 'post') {
		$c = _new("cache");
		$ps = $c->get("posts:".$_GET['tid']);
		if(isset($_GET['quote']) && $_GET['quote'] !="") {
			$db = _new("db");
			$db->saveQry("SELECT `text`,`user` FROM `#_posts` WHERE `ID` = ?",$_GET['quote']);
			$quote = $db->fetch_assoc();
			$quote="\n\n-----------------------------\n".quote(lang("quoteby","board").userInfo($quote['user'],"displayName")."\n".$quote['text']);
		} else { $quote = ""; }
		$ps = array_reverse($ps,true);
		$ps = array_slice($ps,0,5);

		$parser->assign("quote",$quote);
		$parser->assign("posts",$ps);
		$parser->assign("res",false);
		$parser->setContent("ls/post.add.tpl");
	} elseif($_GET['do'] == 'add') {
		$f = array("user","text","stp","thread");
		$v = array(UID,$_POST['text'],time(),$_GET['tid']);
		$db = _new("db");
		$db->insert("posts",$f,$v);

		$info =cacheThread($_GET['tid']);

		putChangelog(CLOG_PUBLIC, CLOG_POST, UID, $_GET['tid'],$info['title']);
		notify(NOTIFY_POST,$info['title'],array(userInfo(UID,"displayName"),$info['title'],quote($_POST['text']),"board.php?action=thread&tid=".$_GET['tid']."#last"));
		$c = _new("cache");
		$c->delete("user_post:".UID);
		$c->delete("board:".$info['board']);
		$c->delete("boards");
		$c->delete("thread:".$_GET['tid']);
		$c->delete("posts:".$_GET['tid']);

		$parser->assign("title", lang("savedPostTitle","board"));
		$parser->assign("result", lang("savedPostText","board"));
		$parser->assign("back", "board.php?action=thread&tid=".$_GET['tid']);
		$parser->setContent("ls/success.tpl");
	} elseif($_GET['do'] == 'edit') {
		$db = _new("db");
		$db->saveQry("SELECT `text` FROM `#_posts` WHERE `ID` = ?",$_GET['pid']);
		$res = $db->fetch_assoc();

		$parser->assign("txt",$res['text']);
		$parser->assign("res",false);
		$parser->setContent("ls/post.edit.tpl");
	} elseif($_GET['do'] == 'update') {
		$c = _new("cache");
		$ps = $c->get("posts:".$_GET['tid']);
		if($ps[$_GET['pid']]['user'] == UID) {
		$db = _new("db");
		$db->update("posts",array("text","stp"),array($_POST['text'],time()),"WHERE `ID` = '".(int)$_GET['pid']."'");

		$c->delete("posts:".$_GET['tid']);

		$parser->assign("title", lang("editPostTitle","board"));
		$parser->assign("result", lang("editPostText","board"));
		$parser->assign("back", "board.php?action=thread&tid=".$_GET['tid']);
		$parser->setContent("ls/success.tpl");
		} else {
		$parser->assign("txt","");
		$parser->assign("res",false);
		$parser->setContent("ls/post.edit.tpl");
		}
	}
}

if($_GET['action'] == 'threads') {
	if($_GET['do'] == 'post') {
		$parser->assign("res",false);
		$parser->setContent("ls/thread.add.tpl");
	} elseif($_GET['do'] == 'add') {
		$db = _new("db");
		($_POST['poll']==1)?$poll=1:$poll=0;
		$db->insert("threads", array("user","title","board","stp","attendance"),
		array(UID,$_POST['title'],$_GET['bid'],time(),$poll));
		$id = $db->returnID();
		$db->insert("posts",array("user","text","thread","stp"),
		array(UID,$_POST['text'],$id,time()));

		$c = _new("cache");
		$bb =$c->get("boardInfo:".$_GET['bid']);
		$c->delete("boardInfo:".$_GET['bid']);
		$c->delete("board:".$_GET['bid']);
		$c->delete("boards");


		putChangelog(CLOG_PUBLIC, CLOG_THREAD, UID, $id,$_POST['title']);
		notify(NOTIFY_THREAD,false,array($bb['title'],$_POST['title'],quote($_POST['text']),"board.php?action=thread&tid=".$id."#last"));

		$parser->assign("title", lang("savedThreadTitle","board"));
		$parser->assign("result", lang("savedThreadText","board"));
		$parser->assign("back", "board.php");
		$parser->setContent("ls/success.tpl");
	} elseif($_GET['do'] == 'rlydel') {
		$parser->assign("res",false);
		$parser->setContent("ls/thread.del.tpl");
	} elseif($_GET['do'] == 'del') {
		$db = _new("db");
		$c = _new("cache");
		$info =$c->get("thread:".$_GET['tid']);
		if($info['user'] == UID) {
		$c->delete("board:".$info['board']);
		$c->delete("boards");
		$c->delete("thread:".$_GET['tid']);
		$c->delete("posts:".$_GET['tid']);

		$db->saveQry("DELETE FROM `#_threads` WHERE `ID` = ?",$_GET['tid']);
		$db->saveQry("DELETE FROM `#_posts` WHERE `thread` = ?",$_GET['tid']);
		$db->saveQry("DELETE FROM `#_attend` WHERE `thread` = ?",$_GET['tid']);

		$parser->assign("res",true);
		} else {
			$parser->assign("res",false);
		}
		$parser->setContent("ls/thread.del.tpl");
	} elseif($_GET['do'] == 'edit') {
		$c = _new("cache");
		$info =$c->get("thread:".$_GET['tid']);

		$parser->assign("title",$info['title']);
		$parser->assign("poll",(is_array($info['attends'])?true:false));
		$parser->assign("res",false);
		$parser->setContent("ls/thread.edit.tpl");
	} elseif($_GET['do'] == 'update') {
		$c = _new("cache");
		$info =$c->get("thread:".$_GET['tid']);
		if($info['user'] == UID) {

		($_POST['poll']==1)?$poll=1:$poll=0;
		$parser->assign("title",$_POST['title']);
		$parser->assign("poll",$poll);

		$c->delete("board:".$info['board']);
		$c->delete("boards");
		$c->delete("thread:".$_GET['tid']);

		$db = _new("db");
		$db->update("threads",array("title","attendance"),
		array($_POST['title'],$poll),"WHERE `ID` = '".(int)$_GET['tid']."'");


		$parser->assign("title", lang("editThreadTitle","board"));
		$parser->assign("result", lang("editThreadText","board"));
		$parser->assign("back", "board.php");
		$parser->setContent("ls/success.tpl");
		} else {
			$parser->assign("res",false);
			$parser->setContent("ls/thread.edit.tpl");
		}
	}
}

if($_GET['action'] == 'board') {
	if($_GET['do'] == 'post') {
		$db = _new('db'); $c = _new("cache");
		$db->insert("boards", array("title","desc"), array($_POST['title'],$_POST['desc']));
		$c->delete("boards");

		$parser->assign("title", lang("savedBoardTitle","board"));
		$parser->assign("result", lang("savedBoardText","board"));
		$parser->assign("back", "board.php");
		$parser->setContent("ls/success.tpl");
	} elseif($_GET['do'] == 'add') {
		$parser->assign("res",false);
		$parser->setContent("ls/board.add.tpl");
	} elseif($_GET['do'] == 'del') {
		$c = _new("cache");
		$bs = $c->get("boards");
		foreach($bs as $b) {
			$as[$b['ID']] = $b['title'];
		}

		$parser->assign("bs",$as);
		$parser->assign("res",false);
		$parser->setContent("ls/board.del.tpl");
	} elseif($_GET['do'] == 'delete') {
		$db = _new('db'); $c = _new("cache");
		$bs = $c->get("boards");
		$c->delete("boards");
		$db->delete("boards","WHERE `ID` = '".$_POST['id']."'");

		foreach($bs as $b) {
			if($_POST['id'] != $b['ID'])
			$as[$b['ID']] = $b['title'];
		}

		$parser->assign("bs",$as);
		$parser->assign("res",true);
		$parser->setContent("ls/board.del.tpl");
	}

}

if($_GET['action'] == 'show') {
	$id=(int)$_GET['bid'];
	$c = _new("cache");

	$page = 1; $epp = eppBoard;
	if(isset($_GET['page'])) {
		$page = (int)$_GET['page'];
	}
	$start = ($epp * $page)-$epp;

	if(!$res =$c->get("board:".$id)) {
		$db = _new("db");
		$db->saveQry("SELECT `ID` FROM `#_threads` WHERE `board` = ? ORDER BY `ID` DESC",$id);
		while($row = $db->fetch_assoc()) {
			$res[] = cacheThread($row['ID']);
		}
		$c->set("board:".$id,$res,time()+WEEK);
		$db->free();
	}

	$res =array_slice($res,$start,$epp);

	$db->saveQry("SELECT COUNT(*) as `datasets` FROM `#_threads` WHERE `board` = ?",$id);
	$count = $db->fetch_assoc(); $db->free();

	$parser->assign("p_act", $page);
	$parser->assign("p_epp", $epp);
	$parser->assign("p_url","./board.php?action=show&bid=".$id);
	$parser->assign("p_cou", $count['datasets']);

	$parser->assign("res",$res);
	$parser->setNav(lang("addthread","board"),  "./board.php?action=threads&do=post&bid=".$id);
	$parser->setContent("ls/boards.tpl");
}

if($_GET['action'] == 'thread') {
	$id=(int)$_GET['tid'];
	$db = _new("db");

	// DELETING A POST !
	if(isset($_GET['delete']) && $_GET['delete'] != "") {
		$delID = (int)$_GET['delete'];
		$c = _new("cache");
		$posts = $c->get("posts:".$id);
		if($posts[$delID]['user'] == UID) {
		$db->delete("posts", "WHERE `ID` = '".$delID."'");
		$parser->assign("deleted",1);
		$t = $c->get("thread:".$id);
		$c->delete("board:".$t['board']);
		$c->delete("posts:".$id);
		$c->delete("thread:".$id);
		} else { $parser->assign("deleted",0); }
	} else { $parser->assign("deleted",0); }

	$thread = cacheThread($id);
	$res = cachePosts($id);

	$page = $thread['sites']; $epp = eppPosts;
	if(isset($_GET['page'])) {
		$page = (int)$_GET['page'];
	}
	$start = ($epp * $page)-$epp;

	$res =array_slice($res,$start,$epp);

	$counter = $epp*($page-1);

	$parser->assign("counter",$counter);
	$parser->assign("info",$thread);
	$parser->assign("res",$res);
	setTitle($thread['title']);

	$db->saveQry("SELECT COUNT(*) as `datasets` FROM `#_posts` WHERE `thread` = ?",$id);
	$count = $db->fetch_assoc(); $db->free();

	$parser->assign("p_act", $page);
	$parser->assign("p_epp", $epp);
	$parser->assign("p_url","./board.php?action=thread&tid=".$id);
	$parser->assign("p_cou", $count['datasets']);

	$parser->setNav(lang("addpost","board"),  "./board.php?action=post&do=post&tid=".$id);
	if($thread['user']== UID) {
		$parser->setNav(lang("editthread","board"),  "./board.php?action=threads&do=edit&tid=".$id);
		$parser->setNav(lang("delthread","board"),  "./board.php?action=threads&do=rlydel&tid=".$id);
	}
	$parser->setContent("ls/thread.tpl");
}

$parser->display("index.tpl");
?>
