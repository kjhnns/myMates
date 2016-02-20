<?php
/*
 * Created on 11.06.2008
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

 /*
  * Shutdown Function
  */
 function shutdownFunction() {
	@mysql_close(DB_CONN);
	if(DEBUG) {
 		$bench=sprintf( "bench: %f ms <br/>" .
		 				"afterSessionStart: %f ms<br>" .
		 				"InitBench: %f ms<br>" .
		 				"memory: %dkb<br>" .
		 				"mysql: %d qrys",
				 		(_microTime() - BENCHSTART),
				 		InitBench,
				 		(_microTime()- afterInitBench),
				 		memory_get_peak_usage(true)/1024,
				 		$GLOBALS['_GLOBAL_QRYS']);
 		echo 	"<div style='padding: 20px;position:absolute;left:100%;" .
 				" width: 1200px;border: 4px #000000" .
 				" solid; background-color: #FFFFFF;'>".
 				$bench.displayDebugLog()."</div>";
 	}

// 	bench((_microTime() - BENCHSTART),InitBench,
// 		(_microTime()- afterInitBench),$GLOBALS['_GLOBAL_QRYS']);
 }

 register_shutdown_function("shutdownFunction");
?>
