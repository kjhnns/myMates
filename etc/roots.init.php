<?php
/*
 * Created on Mar 17, 2010
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

/*
 * MAIN FOLDERS
 */
define("ROOT",							"./");
define("MAIN",							ROOT."lib/");
define("TEMP",							ROOT."tmp/");
define("CONF",							ROOT."etc/");

/*
 * FOLDER STRUCTURE
 */
define("BACKEND",						MAIN."backend/");
define("CLIENTLIB",						MAIN."client/");
define("FUNCLIB",						BACKEND."common/");
define("WEBROOT",						ROOT."webroot/");
define("LANGUAGES",						MAIN."languages/");
define("THUMBS", 						TEMP."thumbs/");
define("LOGS", 							TEMP."logs/");
define("CACHE_DIR", 					TEMP."cache/");
define("SESSIONSAVEPATH",				TEMP."sessions/");
define("GALLERY",						ROOT."gallery/");
define("AVATARS",						TEMP."avatars/");
?>
