<?php
/*
 * Created on Nov 7, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */
include("./lib/init.php");

function dataSize($total) {
	$dataSizes = array("Byte","KiB","MB","GB","TB");
	for($i=0;strlen((int)$total)>3;$total/=1024,$i++);
	$total = round($total,2)." ".$dataSizes[$i];
	return $total;
}

if(!(isset($_GET['action']) && $_GET['action'] != "")) {
	$_GET['action'] = "index";
}

if($_GET['action'] == 'index') {
	$db = _new("db");

	$db->saveQry("SHOW TABLE STATUS");
	$total=$rows=0;
	while($row = $db->fetch_assoc()) {
		if(substr($row['Name'],0,strlen($db->prefix)) == $db->prefix) {
			$total += $row['Data_length']+$row['Index_length'];
			$rows += $row['Rows'];
		}
	}

	$db->saveQry("SELECT sum( `size` ) as `cache` FROM `#_fileCache`");
	$r = $db->fetch_assoc();
	$cache = $r['cache'];
	$db->saveQry("SELECT sum( `size` ) as `cache` FROM `#_thumbs`");
	$r = $db->fetch_assoc();
	$thumbs = $r['cache'];
	$tmp = $thumbs+$cache;

	$db->saveQry("SELECT sum( `size` ) as `cache` FROM `#_gallery_pics`");
	$r = $db->fetch_assoc();
	$gallery = $r['cache'];

	$db->saveQry("SELECT COUNT(*) as `data` FROM `#_gallery`");
	$r = $db->fetch_assoc();
	$galleries = $r['data'];

	$db->saveQry("SELECT COUNT(*) as `data` FROM `#_gallery_pics`");
	$r = $db->fetch_assoc();
	$pics = $r['data'];

	$parser->assign("size",dataSize($total));
	$parser->assign("rows",$rows);
	$parser->assign("thumbs",dataSize($thumbs));
	$parser->assign("cache",dataSize($cache));
	$parser->assign("tmp",dataSize($tmp));
	$parser->assign("gsize",dataSize($gallery));
	$parser->assign("galleries",$galleries);
	$parser->assign("pics",$pics);
	$parser->setContent("ls/index.tpl");
}

if($_GET['action'] == 'ccache') {
	$tmp = _new("cache");
	$tmp->clean(true);

	$parser->assign("title",lang("delcachetitle","mod"));
	$parser->assign("text",lang("delcachetext","mod"));
	$parser->setContent("ls/success.tpl");
}


$parser->display("sites/index.tpl");

?>
