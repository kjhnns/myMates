<?php
/*
 * Created on 06.01.2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

 function isWriteAbleCheck($dir) {
	if(is_array($dir)) {
		foreach($dir as $d) {
			if(!is_writable($d))
				dispError(	6, $d);
		}
	} else {
		if(!is_writable($dir))
			dispError(	6, $dir);
	}
 }
?>
