<?php
/*
 * Created on 19.01.2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

 /*
  * Class for managing the temporary folders
  */

class tmp {

	/*
	 * construct
	 */
    function tmp() {
    }

	/*
	 * clears the thumb folder
	 *
	 * @param int [expired time] bsp. time()-DAY
	 */
    function clearThumbs($expired) {
    	$db = _new("db");
		if($expired === TRUE) {
			$folderContent = _scandir(THUMBS);
			foreach($folderContent as $file) {
				@unlink(THUMBS.$file);
			}
			$db->saveQry("TRUNCATE TABLE #_thumbs");
		} else {
			$db->saveQry("SELECT * FROM `#_thumbs` WHERE `time` <= ?", $expired);
			while($thumb = $db->fetch_assoc()) {
				@unlink(THUMBS.$thumb['file']);
			}
			$db->saveQry("DELETE FROM `#_thumbs` WHERE `time` <= ?", $expired);
		}
		debugLog("Cleared Thumbs folder", "Thumbnail folder got cleaned");
    }

	/*
	 * CLEARS THE TMP FOLDER
	 *
	 * * thumbnails
	 * * Cachefiles
	 * * Logfiles
	 */
    function clearTMP() {
		$db = _new("db");

		// THUMBNAILS
		$folderContent = _scandir(THUMBS);
		foreach($folderContent as $file) {
			@unlink(THUMBS.$file);
		}
		$db->saveQry("TRUNCATE TABLE #_thumbs");
		debugLog("Cleared Thumbs", "Thumbnails got cleaned");

		// CACHE
		$c = _new("cache");
		$c->clean(true);
		debugLog("Cleared CACHE", "cache got cleaned");

		// LOG FILES
		$folderContent = _scandir(LOGS);
		foreach($folderContent as $file) {
			@unlink(LOGS.$file);
		}
		debugLog("erased Log files", "all log files got erased!");
    }

    function clearCache($total = false) {

    }
}
?>