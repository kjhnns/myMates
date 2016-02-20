<?php
/*
 * Created on Aug 17, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */


// returns comments of cat and item
function fetchComments($cat, $item) {
	$c = _new("cache");
	if(!$res = $c->get("comments".$cat.$item)) {
		$db = _new("db");
		$db->saveQry("SELECT * FROM `#_comments` WHERE `cat_id` = ? AND `cat_item` = ?",$cat,$item);
		$res = "";
		while($row = $db->fetch_assoc()) {
			$row['text'] = textCodes($row['text']);
			$res[] = $row;
		}
		$c->set("comments".$cat.$item, $res, time() + WEEK);
		$db->free();
	}
	if(count($res) > 0)
	return $res;
	return false;
}

function postComment($text, $cat, $item, $report=1) {
	$db = _new("db");
	$f = array("by", "text", "time", "cat_id", "cat_item");
	$v = array(UID, $text, time(), $cat, (int)$item);
	$db->insert("comments", $f, $v);
	$id = $db->returnID();
	if($report == 1) putChangelog(CLOG_PUBLIC, CLOG_COMMENT, UID, $id, $text);
	$c = _new("cache");
	if($cat == 'clog') {
		$c->delete("changelog_content");
		$db->update("changelog",array("time"),array(time()),"WHERE `ID` = '".intval($item)."'");
	}
	$c->delete("comments".$cat.$item);
	$c->clean();
}
?>