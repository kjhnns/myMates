<?php
/*
 * Created on 11.10.2008
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

 function nullStr($int, $length) {
	$out = (string)$int;
	$null="";
	for($i = strlen($out); $i < $length; $i++) {
		$null .= "0";
	}
	return $null.$out;
 }
?>
