<?php
/*
 * Created on Oct 5, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

function tplCfg($field) {
	include(TEMPLATE."tplinfo.php");
	return $_tplCFG[$field];
}
?>
