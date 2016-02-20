<?php
/*
 * Created on 12.04.2008
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

 /*
  * _new contructor
  *
  * @return classID [, arg1[, arg2 ...]]
  * @param str
  */
 function _new() {
	global $__classes;

	$args = func_get_args();
	$class=$args[0];
	if($__classes[$class] != "" && $class != "db") {
		$res = $__classes[$class];
	} else {
		if(!class_exists($class)) {
			//init class
			if (file_exists(BACKEND.$class.".class.php"))
				include(BACKEND.$class.".class.php");
			else
				return false;
		}

		for($i = 1; $i< count($args);$i++) $_args[] .= "\$args['".$i."']";

		$__args = "";
		if(@count($_args) > '0') {
			$__args = "(".implode(",",$_args).")";
		}

		$res = "";
		eval("\$res = new ".$class.$__args.";");
		debuglog("neue Klasse","Neue Klasse initiert:".$class);
		$__classes[$class] = $res;
	}
	return $res;
 }
?>