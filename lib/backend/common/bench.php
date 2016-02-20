<?php
/*
 * Created on Oct 11, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

 /*
  * function vor reporting bench and analysis
  */

function bench($total,$ini, $after, $qrys) {
	$dump = file_get_contents(LOGS."bench_".date("Ym").".txt");
	$bench = @unserialize($dump);
	if($bench == "") $bench = array();
	$bench[] = array($total, $ini,$after,$qrys,time(),$_SERVER["PHP_SELF"],
					$_SERVER["QUERY_STRING"],memory_get_usage(true));
	$dump = @serialize($bench);
	file_put_contents(LOGS."bench_".date("Ym").".txt",$dump);
	debugLog("Benchreport update","benchreport time:".$total);
}
?>
