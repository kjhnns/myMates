<?php
/*
 * Created on Mar 3, 2010
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

function loadSettings() {
	$c = _new("cache");
	if(!$res = $c->get("SETTINGS")) {
		$db = _new("db");
		$db->saveQry("SELECT * FROM `#_settings`");
		while($row = $db->fetch_assoc())
			$res[] = $row;
		$c->set("SETTINGS",$res,time()+WEEK);
	}
	foreach($res as $r) define($r['key'],$r['value']);
	debugLog("Settings loaded", "Loaded Settings from db");
}
?>
