<?php
/*
 * Created on Aug 20, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

/*
 * notify sends email notification to the users who activated it
 * koennte man noch optimieren von speed usw aber hab ich gerade kein bock mehr zu :X
 *
 * @param const cat
 * @param array Title Replaces
 * @param array Text Replaces
 */
function notify($cat, $titlePattern=false, $textPattern=false) {
	global $_notify_level;
	$i = 0;

	$sess = _new("session");
	$n = $sess->usersInfo("notify");
	$l = $sess->usersInfo("language");
	$m = $sess->usersInfo("email");
	foreach($n as $uid => $level) {
		if($level & $_notify_level[$cat] && $uid != UID) {
			($l[$uid] != '')?$userlang = $l[$uid]:$userlang = defaultLng;
			$mail = $m[$uid];

			// Titel zusammenbauen
			$title = lang($cat."_title", "mail", $userlang);
			if($titlePattern != false) {
			if(is_array($titlePattern)) {
				foreach($titlePattern as $pat) $args[] = "'".$pat."'";
				$args = implode(',',$args);
			} else {
				$args = "'".$titlePattern."'";
			}
			eval("\$title = sprintf(\$title,".$args.");");
			}

			unset($args);
			// text zusammenbauen
			$text = lang($cat."_text", "mail", $userlang);
			if($textPattern != false) {
			if(is_array($textPattern)) {
				foreach($textPattern as $pat) $args[] = "'".$pat."'";
				$args = implode(',',$args);
			} else {
				$args = "'".$textPattern."'";
			}
			eval("\$text = sprintf(\$text,".$args.");");
			}

			// SEND EMAIL
			debugLog("Email an ".$mail, "##".$title."##".$text);
			@mail($mail, $title, $text); $i++;
		}
	}

	debugLog("Erfolgreich Notified", "Es wurden insg. ".$i." Emails verschickt!");
}
?>
