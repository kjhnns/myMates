<?php
/*
 * Created on Nov 7, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */
include("./lib/init.php");
$parser = _new("parser");

if(!(isset($_GET['action']) && $_GET['action'] != "")) {
	$_GET['action'] = "index";
}

if($_GET['action'] == 'index') {
	$_SESSION['moderate'] = "loggedOut";
	$parser->setContent("ls/logout.tpl");
}

$parser->display("sites/index.tpl");

?>
