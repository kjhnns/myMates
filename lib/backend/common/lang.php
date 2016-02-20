<?php
/*
 * Created on Feb 27, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

 /*
  * function for the language selection
  *
  * @param str key
  * return str string in the language
  */
 function lang($key, $dim= false, $lang = false) {
	$c = _new("cache");
	if($lang === false) {
		$lang = ULANG;
	} else {
		if($lang == "") $lang = defaultLng;
		$langUrl = LANGUAGES.$lang.".lang.php";
		if(!file_exists($langUrl)) $lang = defaultLng;
	}
	if($dim === false) {
		$dim = "page";
	}

	$part = $c->get("langPart-".$lang."-".$dim);
	return $part[$key];
 }
?>
