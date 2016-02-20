<?php
/*
 * Created on Mar 8, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

/**
 * reeaads the whole changelog formated
 *
 * @returns array
 */
function changelog() {
	$c = _new("cache");
	$return = $c->get("changelog_content");
	if($return[UID] == "") {
		$db = _new("db");
		$db->saveQry("SELECT * FROM `#_changelog` WHERE `visible` = '0' OR `visible` = ? ORDER BY `time` DESC LIMIT 0,".eppClog, UID);
		while($row = $db->fetch_assoc()) {
			$res[$row['ID']] = clogRowParser($row);
		}
		$db->free();
		$return[UID] = $res;
		$c->set("changelog_content", $return,time()+DAY);
	}
	return $return[UID];
}

/**
 * puts a new entrie into the changelog
 *
 * @param int private(ID)/public(0)
 * @param var entriekey
 * @param int by(ID)
 * [@param int related(ID)]
 * [@param txt value]
 * return boolean success
 */
function putChangelog($show, $key, $by, $related= false, $val = false) {
	$c = _new("cache");	$c->delete("changelog_content"); $_SESSION['lastChangelog_refresh_'.UID] = 0;
	$db = _new("db");
	$db->saveQry("SELECT * FROM `#_changelog` WHERE `by` = ? ORDER BY `ID` DESC LIMIT 0,1",$by);
	$r = $db->fetch_assoc();
	if($r['key'] == $key && $r['value'] == $val && $show == $r['show'] && $related == $r['related']) {
		$f = array("time"); $v = array(time());
		return $db->update("changelog", $f,$v, "WHERE `ID` = '".$r['ID']."'");
	} else {
		if($related === FALSE) $related = 0;
		if($val === FALSE) $val = "";
		$f = array("by","related","key","value","visible","time");
		$v = array((int)$by, (int)$related, $key, $val, (int)$show,time());
		return $db->insert("changelog",$f,$v);
	}
}

/**
 * parses a changelog row
 *
 * @param str Row
 * @return str Parsedrow
 */
function clogRowParser($row) {
	$txt = lang($row['key'], 'changelog');
	if($txt != '') {
		$txt = lang($row['key'], 'changelog');
		$search =array("%BY%","%NAME%","%REL%","%VAL%");
		$replace = array($row['by'],userInfo($row['by'],"displayName"),$row['related'],$row['value']);
		$row['value'] = str_replace($search,$replace,$txt);
	}
	if($row['key'] == 'cloglink') {
		$row['value'] = urldecode($row['value']); $row['value'] = http($row['value']);

		// youtube
		if(detectYoutube($row['value'])) {
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $row['value']);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$out = curl_exec($ch);
			curl_close($ch);

			preg_match('/<meta name="title" content="(.*)"/i',$out,$match);
			$row['title'] = html(utf8_decode($match[1]));


			preg_match('/<meta name="description" content="(.*)"/i',$out,$match);
			$row['desc'] = html(utf8_decode($match[1]));
			$row['value'] = parseYoutubeID($row['value']);
			$row['key'] = 'youtube';
		}

		if(detectHtml($row['value'])) {
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $row['value']);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$out = curl_exec($ch);
			curl_close($ch);

			preg_match("/<title>(.*)<\/title>/i",$out,$match);
			$row['title'] = html(utf8_decode($match[1]));
			preg_match('/<meta name="description" content="(.*)"/i',$out,$match);
			if($match[1] != "")
			$row['desc'] = html(utf8_decode($match[1]));
		}

		//imgs
		if(detectImage($row['value'])) {
			$row['key'] = 'image';
		}
	}
	if($row['key'] == 'clogcomm') {
		$dba = _new("db");
		$dba->saveQry("SELECT * FROM `#_comments` WHERE `ID` = ?",$row['related']);
		$comm = $dba->fetch_assoc(); $dba->free();
		$row['cat'] = $comm['cat_id'];
		$row['catitem'] = $comm['cat_item'];
		if($row['cat'] == 'picture') {
			$dba->saveQry("SELECT * FROM `#_gallery_pics` WHERE `ID` = ?",$row['catitem']);
			$gal = $dba->fetch_assoc(); $dba->free();
			$row['gID'] = gID($gal['gid']);
		}
	}
	return $row;
}

/**
 * detects if the given url is a youtube link
 *
 * @param str url
 * return boolean
 */
function detectYoutube($url) {
	$vidparser['query'] = "";
	$vidparser = parse_url($url);$query ="";
	parse_str($vidparser['query'], $query);
	if(strstr($url,"youtube.com") === FALSE || $query['v'] == "") {
		return false;
	} else {
		return true;
	}
}

/**
 * detects whether a url is leading to html content
 *
 * @param str url
 */
function detectHtml($url) {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$out = curl_exec($ch);
	curl_close($ch);

	$out = explode("\n",$out);
	foreach($out as $ln)
	if(substr($ln,0,strlen("Content-Type: ")) == "Content-Type: ") {
	if(strstr($ln,"text/html")) return true; else return false;
	break; }

	return false;
}

/**
 * parses the id of the utube video
 *
 * @param str url
 * return str id
 */
function parseYoutubeID($url) {
	$vidparser = parse_url($url);
	parse_str($vidparser['query'], $query);
	return $query['v'];
}

/**
 * detects whether the url leads to an image
 * some kind of critical shit function
 *
 * @param str url
 * return boolean
 */
function detectImage($url) {
	/*
	 * das hier macht die ganze kacke richtig langsam garantiert aber das es ein bild ist
	if(@getimagesize($url) === FALSE) {
		return false;
	} else {
		return true;
	}
	*/
	/*$end = substr($url,-4,4);
	if(	$end == '.jpg' || $end == '.gif' || $end == '.png' ||
		$end == '.jpeg' || $end == '.JPG' || $end == '.GIF' || $end == '.PNG') {
		return true;
	} else {
		return false;
	}*/
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$out = curl_exec($ch);
	curl_close($ch);

	$out = explode("\n",$out);
	foreach($out as $ln)
	if(substr($ln,0,strlen("Content-Type: ")) == "Content-Type: ") {
	if(strstr($ln,"image")) return true; else return false;
	break; }

	return false;
}
?>
