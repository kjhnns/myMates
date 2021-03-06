<?php
/*
 * Created on 04.10.2008
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

 if (!function_exists('file_put_contents')) {
	 function file_put_contents($n, $d, $flag = false) {
	    $mode = ($flag == FILE_APPEND || strtoupper($flag) == 'FILE_APPEND') ? 'a' : 'w';
	    $f = @fopen($n, $mode);
	    if ($f === false) {
	        return 0;
	    } else {
	        if (is_array($d)) $d = implode($d);
	        $bytes_written = fwrite($f, $d);
	        fclose($f);
	        return $bytes_written;
	    }
	 }
 }
?>
