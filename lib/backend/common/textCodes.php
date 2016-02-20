<?php
/*
 * Created on Feb 22, 2010
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

function textCodes($str) {
	$pattern = array(
						'/http:\/\/(.*)(([^A-Za-z0-9&\?\.=\-_#+%\/])|$)/iU'
					);
	$replaces = array(
						'<a target="_blank" href="http://$1">http://$1</a>$2'
					 );
	$str=preg_replace($pattern, $replaces, $str);
	return $str;
}
?>
