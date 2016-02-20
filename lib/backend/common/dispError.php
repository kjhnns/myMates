<?php
/*
 * Created on 10.06.2008
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */
 isWriteAbleCheck(LOGS);

 /*
  * dispError function
  *
  * return ErrorMsg - exits script
  * @param int id
  * @param str file
  * @param int line
  */

  function dispError($id = UNKWN, $file = UNKWN, $line = UNKWN) {

		/*
		 * Ends ob session
		 */
		if(!DEBUG) { ob_end_clean(); }

		if($id == UNKWN) {
			echo "############################ ErrorID failure ############################"; return 0;
		}

		/*
		 * Including errorList && parsing
		 */
		$errorList = file_get_contents(CONF."errorList.csv");
		$errorList = explode("\n",$errorList);
		$title = false;
		foreach($errorList as $row) {
			$col = explode("###", $row);
			if((int)$col[0] == (int)$id) {
				$id = $col[0]; $title = $col[1]; $text = $col[2];
				break;
			}
		}
		if($title === false) {
			echo "############################ ErrorID failure ############################"; return 0;
		}

		debugLog($title,$text,$file,$line,DBUG_ERROR.$id);
		?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
			<head>
				<title>Fatalerror - #<?=$id?></title>
				<meta http-equiv="content-type" content="text/html; charset=utf-8" />
				<style type="text/css">
				div#box {
					padding: 5px;
					width: 800px;
					left: 10%;
					top: 30;
					min-height: 300px;
					position: relative;
					background: #FFFFFF;
					font-family: Tahoma, Arial, "Lucida Sans Unicode", sans-serif;
					font-size: 13px;
					border: 2px #d00101 solid;
					border-left: 10px #d00101 solid;
				}
				div#text {	padding: 10px;	}
				h1 { font-family: "Trebuchet MS", Arial, "Lucida Sans Unicode", Tahoma, sans-serif;	font-size: 23px; border-bottom: 3px #d00101 solid;	}
				body {	background: #000000; }
				</style>
			</head>
			<body>
			<div id="box">
			<h1>#<?=$id?> - <?=$title?></h1>
			<i>File / Folder: <?=$file?> - Line: <?=$line?></i><br/><br/>
			<div id="text"><?=$text?></div>
			</div>
			</body>
			</html>
		<?php

		if(CREATE_LOG_FILES) {
			@file_put_contents(
					LOGS.$id."#_error.log",
					"timeStp:".time()."\n".
					"date:".date("d.m.Y H:i:s")."\n" .
					"ID:".$id."\n".
					"title:".$title."\n".
					"text:".$text."\n".
					"file:".$file."\n".
					"line:".$line."\n".
					"addr:".$_SERVER['REMOTE_ADDR']."\n".
					"client:".$_SERVER['HTTP_USER_AGENT']."\n".
					"reqUrl:".$_SERVER["REQUEST_URI"]."\n".
					"----------------------------------------------------------------------------------------------\n",
					FILE_APPEND
				 );
		}

		/*
		 * Exits script if Debug mode is off
		 */
		if(!DEBUG) exit;
  }
?>