<?php
/*
 * Created on 22.01.2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
*/
define("DEBUG",false);
include("./lib/init.php");
$parser = _new("parser");
$_prefs['user']->logout();
$parser->display("sites/logout.tpl");
?>