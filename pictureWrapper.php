<?php
/*
 * Created on Sep 1, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

define("DEBUG",false);
require_once("./etc/roots.init.php");
require_once(CONF."system.init.php");
require_once(BACKEND."functions.php");
function debuglog() {}
error_reporting(E_ALL);

$str = $_REQUEST['show'];

$c = _new("cache");
if(!$crypt = $c->get("g:".$str)) {

echo "<h1>ERROR FILE NOT FOUND</h1>Please make sure that all parameters are set";
exit;
}

if(file_exists($crypt)) {
	$info = GetImageSize($crypt);
	header("Content-type: ".$info['mime']);
	echo file_get_contents($crypt);
} else {
	header("HTTP/1.0 404 Not Found");
	echo "<h1>ERROR FILE NOT FOUND</h1>Please make sure that all parameters are set";
}
?>
