<?php
/*
 * Created on Feb 15, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

 // php numeric version
 list($a,$b,$c) = explode(".",phpversion());
 $phpVersionCompareVal= $a.$b.$c;

 $check = array("php" => true, "mysql" => true, "gd" => true);

 // phpversion compare
 if((int)$phpVersionCompareVal < REQUIREDPHPVERSIONNUM)
  	$check['php'] = false;

 // mysql mod check
 if(!function_exists("mysql_connect"))
  	$check['mysql'] = false;

 // gd lib check
 if(!function_exists("imagecreate"))
	$check['gd'] = false;

 if(!($check['php'] && $check['mysql'] && $check['gd'])) {
	dispError(8);
 }

 // Checking chmod
 isWriteAbleCheck(array(	THUMBS,CACHE_DIR,AVATARS,GALLERY	));
?>
