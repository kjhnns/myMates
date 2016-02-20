<?php
/*
 * Created on 07.10.2008
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

function html($string)
{
	static $patterns, $replaces;
	if (!$patterns) {
        $patterns = array('#&lt;#', '#&gt;#', '#&amp;#', '#&quot;#');
        $replaces = array('<', '>', '&', '"');
    }
    $string = htmlspecialchars(preg_replace($patterns, $replaces, $string));
    return $string;
}
?>