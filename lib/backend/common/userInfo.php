<?php
/*
 * Created on Apr 7, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

 function userInfo($id,$field) {
 	global $_prefs;
 	return $_prefs['session']->userInfo($id,$field);
 }
?>
