<?php
/*
 * Created on 10.06.2008
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */
if(CACHE_OPTION == CACHE_MEMCACHE) {
	class cache extends cache_memcache { }
	debugLog("Memcache Initiert","Memcache als cache_option gewaehlt",__FILE__,__LINE__);
} elseif(CACHE_OPTION == CACHE_MYMATES) {
	class cache extends cache_myMates { }
	debugLog("cache wurde initiert","standard cache wurde initiert",__FILE__,__LINE__);
}

 /*
  * cache class Memcache
  *
  * cache management
  * based on the memcache lib
  */
 class cache_memcache {
		var $server;
		var $inst;

		/*
		 * Construct
		 */
		function __construct () {
			$this->server = explode(";", MEMCACHED_SERVER);
			$this->inst = new Memcache();
			foreach($this->server as $server) {
				$this->inst->addServer( $server );
			}
		}

		/*
		 * adds object to the cache
		 *
		 * return bool
		 * @param key
		 * @param value
		 * @param expires
		 */
		function add($key, $pVal, $exp = 0) {
			return $this->inst->add($key,$pVal,0,$exp);
		}

		/*
		 * updates cache object
		 * the actual time is to sum with the expire time
		 *
		 * return bool
		 * @param key
		 * @param value
		 * @param expires
		 */
		function set($key, $pVal, $exp) {
			return $this->inst->set($key,$pVal,0,$exp);
		}

		/*
		 * retrieve object from cache
		 *
		 * return mixed
		 * @param key
		 */
		function get($key) {
			return $this->inst->get($key);
		}

		/*
		 * deletes object from cache
		 *
		 * return bool
		 * @param key
		 */
		function delete($key) {
			return $this->inst->delete($key);
		}

		/*
		 * cleans whole cache
		 *
		 * return bool
		 */
		function clean($all = false) {
			if($all) {
				return $this->inst->flush();
			}
		}
 }

 /*
  * TABLE FÜR DIE CACHE FILES
  *
  * CREATE TABLE IF NOT EXISTS `fileCache` (
  *		`key` varchar(50) NOT NULL,
  * 	`expires` int(10) unsigned NOT NULL,
  * 	`size` int(10) unsigned NOT NULL,
  * 	PRIMARY KEY  (`key`)
  *	) TYPE=MyISAM;
  */

 /*
  * cache class mymates
  *
  * cache management
  */
 class cache_myMates {
		var $db;

		/*
		 * Construct
		 */
		function __construct() {
			$this->db = _new("db");
		}

		/*
		 * adds object to the cache
		 *
		 * return bool
		 * @param key
		 * @param value
		 * @param expires
		 */
		function add($key, $pVal, $exp = 0) {
			$file = CACHE_DIR.md5($key).".cache";
			if(!file_exists($file)) {
				return $this->set($key,$pVal,$exp);
			} else {
				return false;
			}

		}

		/*
		 * updates cache object
		 * the actual time is to sum with the expire time
		 *
		 * return bool
		 * @param key
		 * @param value
		 * @param expires
		 */
		function set($key, $pVal, $exp) {
			$file = CACHE_DIR.md5($key).".cache";
			$val = serialize($pVal);
			$stream = @fopen($file, "wb");
			if($stream) {
				@fwrite($stream,$val);
				fclose($stream);
				$this->db->insert("fileCache", array("key","expires","size"),
				array(md5($key),intval($exp), filesize($file)),true);
				debugLog("Cache file erstellt", "Es wurde eine neues Cache file erstellt - KEY: '".$key."'",$file);
				global $__cachemem;
				$__cachemem[$key] = $pVal;
				return true;
			}
		}

		/*
		 * retrieve object from cache
		 *
		 * return mixed
		 * @param key
		 */
		function get($key) {
			global $__cachemem;
			$file = CACHE_DIR.md5($key).".cache";
			if($__cachemem[$key] != "") {
				return $__cachemem[$key];
			}
			if(@file_exists($file)) {
				$dump = file_get_contents($file);
				debugLog("Cache file gelesen", "Cache File wurde erfolgreich gelesen - KEY: '".$key."'",$file);
				$res = @unserialize($dump);
				$__cachemem[$key] = $res;
				return $res;
			} else {
				//debugLog("Cache File fehler","Cache file konnte nicht gefunden werden, expired?",$file,UNKWN,DBUG_WARNING);
				return false;
			}
		}

		/*
		 * deletes object from cache
		 *
		 * return bool
		 * @param key
		 */
		function delete($key) {
			$file = CACHE_DIR.md5($key).".cache";
			if(@file_exists($file)) {
				@unlink($file);
				$this->db->delete("fileCache","WHERE key='".md5($key)."'");
				debugLog("Cache file deleted","Cache file wurde erfolgreich gel&ouml;scht - KEY: '".$key."'",$file);
				return true;
			} else {
				return false;
			}
		}

		/*
		 * cleans whole cache
		 *
		 * return bool
		 */
		function clean($all = false) {
			if(!$all) {
				$keys = array();
				$this->db->saveQry("SELECT `key` FROM `#_fileCache` WHERE `expires` < '".time()."'");
				while($row = $this->db->fetch_assoc()) {
					@unlink(CACHE_DIR.$row['key'].".cache");
					$keys[] = $row['key'];
				}
				if(count($keys)>1)
					$this->db->saveQry('DELETE FROM `#_fileCache` WHERE `key` IN(\'' . implode("','", $keys) . '\')');
				elseif(count($keys) >0)
					$this->db->saveQry('DELETE FROM `#_fileCache` WHERE `key` IN(\'' . $keys['0'] . '\')');
				debugLog("Cleaned up Cache","expired cache files wurden gel&ouml;scht",__FILE__,__LINE__);
			} else {
				$dir = _scandir(CACHE_DIR);
				foreach($dir as $f) {
					if(file_exists(CACHE_DIR.$f)) {
						@unlink(CACHE_DIR.$f);
					}
				}
				$this->db->saveQry("TRUNCATE TABLE #_fileCache");
				debugLog("Cache Folder geleert","Cache Ordner wurde erfolgreich geleert",__FILE__,__LINE__);
			}
		}
 }
?>
