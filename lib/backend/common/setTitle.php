<?php
/*
 * Created on Oct 18, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

function setTitle($str) {
	define("pageTitleExt", $str);
	debuglog("Neuer Pagetitle","Page titel geseetzt : ".$str);
	return true;
}
?>
