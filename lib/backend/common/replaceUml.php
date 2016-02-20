<?php
/*
 * Created on 24.01.2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

 /*
  * replaces ger uml
  * @param str
  * @return str
  */
 function replaceUml($str) {
	$str = str_replace( array("ä","ö","ü","ß","Ä","Ü","Ö"),
						array("ae","oe","ue","ss","Ae","Ue","Oe"),
						$str);

	return $str;
 }
?>
