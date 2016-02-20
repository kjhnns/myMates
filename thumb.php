<?php
/*
 * Created on Feb 23, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

 define("PICFASTRENDER",	true);
 define("DEBUG", 			false);
 define("NOLASTACTREFRESH", true);
 include("./lib/init.php");
 $url = addslashes((string)$_GET['url']);

 if($url != "") {
	 // creating thumbnail
	 $thumb = thumb($url,(int)$_GET['x'],(int)$_GET['y']);
	 if(!$thumb) die("failed");
	 // reading size
	 $size = getimagesize($thumb);

	 $fp = fopen($thumb, 'rb');
	 header("Content-Type: " . $size['mime']);
	 header("Content-Length: " . filesize($thumb));

	 fpassthru($fp);
 } else {
 	die("No url given");
 }
?>