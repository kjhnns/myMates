<?php
/*
 * Created on 30.08.2008
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

 /*
  * converts image to thumbnail
  * @param str imageurl
  * @param int maxxsize
  * @param int maxysize
  */
 function thumb($image,$x_size=800,$y_size=600) {
		if(!($info = @GetImageSize($image))) {
			debugLog("Fehler beim Thumbnail erstellen.","Die folgende Datei konnte nicht in ein Thumbnail umgewandelt werden.",$image);
			return 0;
		}
		$ix = $info[0];
		$iy = $info[1];
		switch ($info[2]) {
			case '1': $end="gif";
					  break;
			case '2': $end="jpg";
					  break;
			case '3': $end="png";
					  break;
			default: $end="jpg";
		}

		$srcFilesize = filesize($image);
		$thumbfile = md5($image.$x_size.$y_size).$srcFilesize.".".$end;
		$thumbnail = THUMBS.$thumbfile;

 		$types = array (1 => "gif", "jpeg", "png");
 		if($info[2] > 3)
 		debugLog("Fehler beim Thumbnail erstellen.","Es konnte kein Thumbnail aus dem Format erzeugt werden!",$image);
 		if(!file_exists($thumbnail) or $ix <= $x_size and $iy <= $y_size) {
			if($ix >= $iy) {
				$_div = $iy/$ix;
				$x = $x_size;
				$y = $x * $_div;
				if($y > $y_size) {
					$_div = $ix/$iy;
					$y = $y_size;
					$x = $y * $_div;
				}
			 } else {
				$_div = $ix/$iy;
				$y = $y_size;
				$x = $y * $_div;
				if($x > $x_size) {
					$_div = $iy/$ix;
					$x = $x_size;
					$y = $x * $_div;
				}
			 }
			$src = call_user_func("imagecreatefrom".$types[$info[2]], $image);
			$dst = ImageCreateTrueColor ( $x, $y );
			imagecopyresized ( $dst, $src, 0, 0, 0, 0, $x, $y, $ix, $iy );
			call_user_func("image".$types[$info[2]], $dst, $thumbnail);
			imagedestroy ($src);
			imagedestroy ($dst);
			debugLog("Thumbnail erfolgreich erstellt.",
			"Das Thumbnail konnte erfolgreich generiert werden. Abm&auml;ssung: ".$x_size."x".$y_size,$image);
 		}

 		// creating db entrie
 		$db = _new("db");
 		$db->insert("thumbs", array("file","time","size"),
 		array($thumbfile,time(),filesize($thumbnail)), true);

		return $thumbnail;
 }
?>
