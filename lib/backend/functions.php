<?php
/*
 * Created on 10.06.2008
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */
 $funcs = array(
 				"isWriteAbleCheck",
				"_new",
 				"_scandir",
 				"checkMail",
 				"dispError",
 				"file_get_contents",
 				"file_put_contents",
 				"html",
 				"nullStr",
 				"pagination",
 				"shutdownFunction",
 				"thumb",
 				"replaceUml",
 				"lang",
 				"changelog",
 				"userInfo",
 				"http",
 				"comments",
 				"gID",
 				"notify",
 				"tplCfg",
 				"bench",
 				"textCodes",
 				"setTitle",
 				"loadSettings"		);

foreach($funcs as $func)
	include(FUNCLIB.$func.".php");
?>