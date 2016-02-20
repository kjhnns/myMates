<?php
/*
 * Created on 10.06.2008
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

 /*
  * debugLog function
  *
  * return NULL
  * @param title
  * @param text
  * @param file
  * @param line
  * @param typ
  */

 function debugLog($title=UNKWN,$text=UNKWN,$file=UNKWN,$line=UNKWN,$typ=DBUG_INFO) {
	if(DEBUG) {
		$puffer = array(	"typ" 	=> $typ,
							"title" => $title,
							"text" 	=> $text,
							"file" 	=> $file,
							"line"	=> $line	);

		global $debugLogArray;

		// checking for missing values
		foreach($puffer as $k => $v) {
			$res[$k] = $v;
			if($v === false) {
				$res[$k] = UNKWN;
			}
		}

		// saving
		$debugLogArray[] = $res;
	}
 }


 /*
  * displayDebugLog function
  *
  * echos the Debuglog
  *
  * return NULL
  */
 function displayDebugLog() {
	global $debugLogArray;
	if($debugLogArray) {
		$res =  "<h1>Debug Log</h1>" .
				"<table border=1><tr><th>Typ</th>" .
				"<th>Titel</th><th>Text</th><th>Datei</th>" .
				"<th>Zeile</th></tr>";
		foreach($debugLogArray as $row) {
			$res .= "<tr><td>".$row['typ']."</td>" .
					"<td>".$row['title']."</td><td>".$row['text']."</td>" .
					"<td>".$row['file']."</td><td>".$row['line']."</td></tr>";
		}
		$res .= "</table>";
		return $res;
	} else { return "kein DebugLog vorhanden"; }
 }
?>