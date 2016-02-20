<?php
/*
 * Created on Mar 5, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

function cacheGallery($id) {
	$c = _new("cache");
	if(!$res = $c->get("gallery:".(int)$id)) {
		$db = _new("db");
		$db->saveQry(	"SELECT #_gallery_pics.ID,#_gallery_pics.title,#_gallery_pics.gid,#_comments.ID AS cID,#_comments.cat_id " .
						"FROM `#_gallery_pics` " .
						"LEFT JOIN `#_comments` " .
						"ON #_gallery_pics.ID = #_comments.cat_item " .
						"WHERE #_gallery_pics.gid = ? " .
						"ORDER BY #_gallery_pics.ID DESC",$id);
		while($row = $db->fetch_assoc()) {
			if($row['cat_id'] == "picture" && $row['cID'] != "") {
				$row['comment'] = true;
				unset($row['cat_id']);
				unset($row['cid']);
			} else {
				$row['comment'] = false;
				unset($row['cat_id']);
				unset($row['cid']);
			}
			$res[$row['ID']] = $row;
		}
		$db->free();
		$c->set("gallery:".(int)$id, $res, time());
	}
	return $res;
}

function gallerySize($id=false) {
	$c = _new("cache");
	if(!$size = $c->get("GallerySize:".$id)) {
		$db = _new("db");
		if($id)
			$db->saveQry("SELECT size FROM `#_gallery_pics` WHERE `gid` = ?",$id);
		else
			$db->saveQry("SELECT size FROM `#_gallery_pics`");

		$size = 0;
		while($r = $db->fetch_assoc()) {
			$size += $r['size'];
		}
		$size = round($size / (1024*1024),2);
		$c->set("GallerySize:".$id,$size,time()+YEAR);
	}
	return $size;
}


if(isset($_GET['action']) && $_GET['action'] == 'moveuploaded') {
	// own init
	function _microTime() { list($a,$b) = explode(" ", microtime()); return $a+$b;}
	define("DEBUG",false);
	function debugLog() { return 0; }
	require_once("./etc/roots.init.php");
	require_once(CONF."system.init.php");
	define("MODERATE", false);
	include(BACKEND."functions.php");

	// script shit
	$valstr = md5(RANDUNIQUESTRING.$_SERVER['REMOTE_ADDR'].date("HDMY"));
	if($_GET['valstr'] == $valstr) {
		$size = getimagesize($_FILES['Filedata']["tmp_name"]);
		if(substr($size["mime"],0,5) == 'image') {
			$db = _new("db");
			$f = array("title","gid","size","added");
			$v = array($_FILES['Filedata']["name"],$_GET['gid'],$_FILES['Filedata']["size"],time());
			$url = GALLERY.gID($_GET['gid'])."/".$_FILES['Filedata']["name"];
			if(@move_uploaded_file($_FILES['Filedata']["tmp_name"],$url)) {
				$c = _new("cache");
				$c->delete("gallery:".(int)$_GET['gid']);
				$c->delete("GallerySize:".(int)$_GET['gid']);
				$c->delete("GallerySize:".false);
				$db->insert("gallery_pics", $f,$v);
				echo "1";
			} else {
				echo "E1";
			}
		} else {
			echo "E2";
		}
	} else {
		echo "E3";
	}
	exit;
}

include("./lib/init.php");
$parser = _new("parser");

if(!(isset($_GET['action']) && $_GET['action'] != "")) {
	$_GET['action'] = "index";
}

if($_GET['action'] == 'index') {
	$db = _new("db");
	$c = _new("cache");
	$db->saveQry("SELECT * FROM `#_gallery` ORDER BY `ID` DESC LIMIT 0,".eppGalleryIndex);
	while($row = $db->fetch_assoc()) {
		if($pics = cacheGallery($row['ID'])) {
			$row['cover'] = GALLERY.gID($row['ID'])."/".$pics[$row['cover']]['title'];
		}
		if(!file_exists($row['cover']) || $row['cover'] == GALLERY.gID($row['ID'])."/") {
			$row['cover'] = TEMPLATE.'misc/noCover.jpg';
		}
		$res[$row['ID']] = $row;
	}
	$db->free();
	$parser->assign("res",$res);

	$parser->setNav(lang("picuploadlink","gal"),  "./gallery.php?action=upload");
	$parser->setNav(lang("newbtn","gal"),  "./gallery.php?action=new");
	$parser->setContent("ls/gallery.tpl");
}

if($_GET['action'] == 'upload') {
	$db->saveQry("SELECT ID,title FROM `#_gallery` WHERE `by` = ? ORDER BY `ID` DESC",UID);
	while($row = $db->fetch_assoc()) { $gal[$row['ID']] = $row['title']; }

	$parser->assign("gal",$gal);
	$parser->assign("str", md5(RANDUNIQUESTRING.$_SERVER['REMOTE_ADDR'].date("HDMY")));
	$parser->setContent("ls/gal.upload.tpl");
}

if($_GET['action'] == 'new') {
	if($_GET['do']=='create') {
		$db = _new("db");
		$f = array("title","desc","created","by","cover");
		$v = array($_POST['title'],$_POST['desc'],time(),UID,-1);
		$db->insert("gallery",$f,$v);
		$id = $db->returnID();
		@mkdir(GALLERY.gID($id)."/",0777);
		putChangelog(CLOG_PUBLIC, CLOG_GALLERY, UID, $id,$_POST['title']);
		notify(NOTIFY_GALLERY,false,array($_POST['title'],UDNAME));
		$parser->assign("create",1);
	} else {
		$parser->assign("create",0);
	}
	$parser->setContent("ls/gal.new.tpl");
}

if($_GET['action'] == 'view') {
	$page = 1; $epp = eppGalleryView;
	if(isset($_GET['page'])) {
		$page = (int)$_GET['page'];
	}
	$start = ($epp * $page)-$epp;

	$res = cacheGallery($_GET['gid']);
	$res = array_slice($res, $start,$epp);
	$parser->assign("res",$res);
	$parser->assign("gid",gID((int)$_GET['gid']));
	$parser->assign("size", gallerySize((int)$_GET['gid']));

	$db->saveQry("SELECT * FROM `#_gallery` WHERE `ID` = ?",$_GET['gid']);
	$gal = $db->fetch_assoc(); $db->free();
	$parser->assign("gal",$gal);
	setTitle($gal['title']);

	$db->saveQry("SELECT COUNT(*) as `datasets` FROM `#_gallery_pics` WHERE `gid` = ?",$_GET['gid']);
	$count = $db->fetch_assoc(); $db->free();

	$parser->assign("p_act", $page);
	$parser->assign("p_epp", $epp);
	$parser->assign("p_url","./gallery.php?action=view&gid=".(int)$_GET['gid']);
	$parser->assign("p_cou", $count['datasets']);

	$parser->setNav(lang("picuploadlink","gal"),  "./gallery.php?action=upload&gid=".(int)$_GET['gid']);
	if(UID == $gal['by']) {
		$parser->setNav(lang("editGal","gal"),  "./gallery.php?action=edit&gid=".(int)$_GET['gid']);
		$parser->setNav(lang("delGal","gal"),  "./gallery.php?action=delete&gid=".(int)$_GET['gid']);
	}
	$parser->setContent("ls/gal.view.tpl");
}

if($_GET['action'] == 'edit') {
	if(!isset($_GET['do'])) {
	$db->saveQry("SELECT * FROM `#_gallery` WHERE `ID` = ?",$_GET['gid']);
	$gal = $db->fetch_assoc(); $db->free();
	$parser->assign("gal",$gal);

	$res = cacheGallery($_GET['gid']);
	$parser->assign("pics",$res);
	$parser->assign("gid",gID($_GET['gid']));

	$parser->setContent("ls/gal.edit.tpl");
	} elseif($_GET['do'] == 'gal') {
		$f = array("title","desc");
		$v = array($_POST['title'],$_POST['desc']);
		if($db->update("gallery",$f,$v,"WHERE `ID` = '".(int)$_GET['gid']."' AND `by` = '".UID."'")) {
			$parser->assign("title",lang("gedittitle","gal"));
			$parser->assign("result",lang("geditress","gal"));
			$parser->assign("back","gallery.php");

			$parser->setContent("ls/success.tpl");
		} else {
			$parser->assign("title",lang("gedittitle","gal"));
			$parser->assign("text",lang("geditrese","gal"));
			$parser->assign("back","gallery.php");

			$parser->setContent("ls/error.tpl");
		}
	} elseif($_GET['do'] == 'cover') {
		$f = array("cover");
		$v = array($_POST['cover']);
		if($db->update("gallery",$f,$v,"WHERE `ID` = '".(int)$_GET['gid']."' AND `by` = '".UID."'")) {
			$parser->assign("title",lang("covtitle","gal"));
			$parser->assign("result",lang("covress","gal"));
			$parser->assign("back","gallery.php");

			$parser->setContent("ls/success.tpl");
		} else {
			$parser->assign("title",lang("covtitle","gal"));
			$parser->assign("text",lang("covrese","gal"));
			$parser->assign("back","gallery.php");

			$parser->setContent("ls/error.tpl");
		}
	}
}

if($_GET['action'] == 'delete') {
	if($_GET['do'] == 'true') {
		$id = (int)$_GET['gid'];
		$path = GALLERY.gID($id)."/";

		$db = _new("db");
		$db->saveQry("SELECT `by` FROM `#_gallery` WHERE `ID` = ?",$id);
		$res = $db->fetch_assoc();
		if($res['by'] == UID) {
			$content = _scandir($path);
			foreach($content as $f) {
				@unlink($path.$f);
			}
			@rmdir($path);
			$db->delete("gallery","WHERE `ID` = '".$id."'");
			$db->delete("gallery_pics","WHERE `gid` = '".$id."'");

			$parser->assign("title",lang("deltitle","gal"));
			$parser->assign("result",lang("delress","gal"));
			$parser->assign("back","gallery.php");

			$parser->setContent("ls/success.tpl");
		} else {
			$parser->assign("title",lang("deltitle","gal"));
			$parser->assign("text",lang("delrese","gal"));
			$parser->assign("back","gallery.php");

			$parser->setContent("ls/error.tpl");
		}
	} else {
		$parser->setContent("ls/gal.deleterly.tpl");
	}
}

if($_GET['action'] == 'all') {
	$page = 1; $epp = eppGallery;
	if(isset($_GET['page'])) {
		$page = (int)$_GET['page'];
	}
	$start = ($epp * $page)-$epp;

	$db = _new("db");
	$c = _new("cache");
	$db->saveQry("SELECT * FROM `#_gallery` ORDER BY `ID` DESC LIMIT ".$start.",".$epp);
	while($row = $db->fetch_assoc()) {
		if($pics = cacheGallery($row['ID'])) {
			$row['cover'] = GALLERY.gID($row['ID'])."/".$pics[$row['cover']]['title'];
		}
		if(!file_exists($row['cover']) || $row['cover'] == GALLERY.gID($row['ID'])."/") {
			$row['cover'] = TEMPLATE.'misc/noCover.jpg';
		}
		$res[$row['ID']] = $row;
	}
	$db->free();
	$parser->assign("res",$res);

	$db->saveQry("SELECT COUNT(*) as `datasets` FROM `#_gallery`");
	$count = $db->fetch_assoc(); $db->free();

	$parser->assign("p_act", $page);
	$parser->assign("p_epp", $epp);
	$parser->assign("p_url","./gallery.php?action=all");
	$parser->assign("p_cou", $count['datasets']);

	$parser->assign("size", gallerySize());

	$parser->setNav(lang("picuploadlink","gal"),  "./gallery.php?action=upload");
	$parser->setNav(lang("newbtn","gal"),  "./gallery.php?action=new");
	$parser->setContent("ls/gal.all.tpl");
}

if($_GET['action'] == 'slide') {
	$res = cacheGallery((int)$_GET['gid']);

	$db->saveQry("SELECT * FROM `#_gallery` WHERE `ID` = ?",$_GET['gid']);
	$gal = $db->fetch_assoc(); $db->free();
	$parser->assign("gal",$gal);

	setTitle($gal['title']);

	$i = 0;
	$c = _new("cache");
	foreach($res as $k => $v) {
		if($k == $_GET['id']) $id = $i;
		$str = $v['title'] = GALLERY.gID($_GET['gid'])."/".$v['title'];
		$public = md5($str.CRYPTSTRING);
		$c->set("g:".$public,$str,time()+DAY);
		$v['crypt'] = HTTP_ROOT."pictureWrapper.php?show=".$public;
		$pics[] = $v;
		$i++;
	}
	$parser->assign("pics",$pics);


	$parser->setNav(lang("cryptLink","gal"),  	"cryptlink");
	$parser->setNav(lang("fullimage","gal"),	"fullimage");
	$parser->setNav(lang("galback","gal"),		"./gallery.php?action=view&amp;gid=".$_GET['gid']);

	$parser->setContent("ls/gal.slide.tpl");
}

if($_GET['action'] == 'comments') {
	$res = cacheGallery((int)$_GET['gid']);

	$db->saveQry("SELECT * FROM `#_gallery` WHERE `ID` = ?",$_GET['gid']);
	$gal = $db->fetch_assoc(); $db->free();
	$parser->assign("gal",$gal);

	setTitle($gal['title']);

	$i = 0;
	foreach($res as $k => $v) {
		if($k == $_GET['id']) $id = $i;
		$v['title'] = GALLERY.gID($_GET['gid'])."/".$v['title'];
		$pics[] = $v;
		$i++;
	}
	$end = count($pics)-1;

	$npic =$pics[($id+1)];
	if($end == $id) {
		$npic =$pics[0];
	}
	$ppic =$pics[($id-1)];
	if(0 == $id) {
		$ppic =$pics[$end];
	}

	$picUrl =$pics[$id];

	$parser->assign("pic",$picUrl);
	$parser->assign("ppic",$ppic);
	$parser->assign("npic",$npic);

	// CRYPTING URL
	$str = $picUrl['title'];
	$public = md5($str.CRYPTSTRING);
	$c = _new("cache"); $c->set("g:".$public,$str,time()+DAY);

	$parser->assign("cryptLink",HTTP_ROOT."pictureWrapper.php?show=".$public);
	$parser->setNav(lang("cryptLink","gal"),  	HTTP_ROOT."pictureWrapper.php?show=".$public);
	$parser->setNav(lang("fullimage","gal"),	$picUrl['title']);
	$parser->setNav(lang("galback","gal"),		"./gallery.php?action=view&amp;gid=".$_GET['gid']);

	$parser->assign("gid",gID($_GET['gid']));
	$parser->setContent("ls/gal.comments.tpl");
}

$parser->display("index.tpl");
?>
