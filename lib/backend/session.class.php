<?php
/*
 * Created on 19.01.2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

class session {

	var $unification = false;

	/**
	 * construct
	 */
    function session() {
		//debugLog("Session intialisiert","Es wurde eine neue Session angelegt.", __FILE__,__LINE__);
		//$this->_lastSession();
    }

	/**
	 * no real cron just running every first init
	 */
    function sessionCrons() {
    	$this->_fetch_userInfo();
		$this->_unification();
		$this->_cleanCache();
		$this->_cleanThumbs();
		$this->_bdayCongrats();
		define("chatRefreshTimeAssigned",chatRefreshTime+($this->online()*500));
    }

    /**
     * Checks each day if the running day is a Birthday
     */
    function _bdayCongrats() {
		$dayStp = date("Ymd");
		$c = _new("cache");
		if($c->get("bdayCheck") != $dayStp) {
			$data =$this->usersInfo("bday");
			foreach($data as $k => $v) {
				list($y,$m,$d) = explode("-",$v);

				if($m.$d == date("md"))
				putChangelog(CLOG_PUBLIC, CLOG_BDAY, $k, $k);

			}
			$c->set("bdayCheck", $dayStp, time()+DAY);
		}
    }

    /**
     * returns the last Session of the user
     */
    function _lastSession() {
		$la = $this->userInfo(UID,"lastAct");
		if($la < time()-ONLINELIMIT) {
			$_SESSION['lastSession_'.UID] = $la;
		}
		if(!isset($_SESSION['lastSession_'.UID])) {
			$_SESSION['lastSession_'.UID] = $la;
		}
		if(!defined("lastSession"))
		define("lastSession", $_SESSION['lastSession_'.UID]);
    }

	/**
	 * refreshes the user onlinelist
	 */
    function _onlineList() {
		$cache = _new("cache");
		$ol = $cache->get("onlineList");
		if(is_array($ol) && time()-$ol['last'] <= ONLINELIMIT) {
			if(UID) $ol[UID] = time();
		} else {
			$db = _new("db");
			$db->saveQry("SELECT ID,lastAct FROM `#_user`");
			while($row = $db->fetch_assoc()) {
				$ol[$row['ID']] = 0;
			}
			$ol['last'] = time();
			$db->free();
		}
		$cache->set("onlineList",$ol, time()+HOUR);
    }

    /**
     * function returns the actual online user
     *
     * @return Integer users
     */
    function online() {
		$cache = _new("cache");
		$ol = $cache->get("onlineList");
		$i=0;
		if(is_array($ol))
		foreach($ol as $u => $v) {
			if($v > intval(time()-ONLINELIMIT) && $u != "last") $i++;
		}
		else return 0;
		return $i;
    }

    /**
     * function returns array of users online
     *
     * @return array userlist
     */
    function onlineUser() {
		$cache = _new("cache");
		$ol = $cache->get("onlineList");
		$return = array();
		foreach($ol as $u => $v) {
			if($v > intval(time()-ONLINELIMIT) && $u != "last")
			$return[$u] = $v;
		}
		return $return;
    }

    /**
     * function returns if a user is online
     *
     * @param integer id
     * @return boolean isonline?
     */
    function uOnline($id) {
		$cache = _new("cache");
		$ol = $cache->get("onlineList");
		$return = array();
		foreach($ol as $u => $v) {
			if($v > intval(time()-ONLINELIMIT) && $u != "last")
			$return[] = $u;
		}
		if(in_array($id, $return)) {
			return true;
		} else {
			return false;
		}
    }

	/**
	 * fetches all user info into a session
	 *
	 */
    function _fetch_userInfo() {
		$cache = _new("cache");
		$uInfo = $cache->get("userInfo");
		if($uInfo === false) {
			$db = _new("db");
			$db->saveQry("SELECT * FROM `#_user` ORDER BY `lastEdit` DESC");
			while($row = $db->fetch_assoc()) {
				if($row['password'] == 'deleted') {
					$row = array("ID" => $row['ID'],"displayName" => "------");
				} else {
					$row['signature'] = textCodes($row['signature']);
					$uInfodel[$row['ID']] = $row;
				}
				$uInfo[$row['ID']] = $row;
			}
			$db->free();
			$cache->set("userInfo",$uInfo,time()+DAY);
			$cache->set("userInfo/del",$uInfodel,time()+DAY);
			debugLog("userInfo db fetched", "User info wurde aus db ausgelesen");
		} else {
			debugLog("userInfo cache fetched", "User info wurde via Cache ausgelesen");
		}
    }

    /**
     * returns user info
     *
     * @return mixed
     */
    function userInfo($id,$field) {
		$cache = _new("cache");
		$users = $cache->get("userInfo");
		return $users[$id][$field];
    }

    /**
     * returns users info
     *
     * @return mixed
     */
    function usersInfo($field) {
		$cache = _new("cache");
		$uInfo = $cache->get("userInfo");
		foreach($uInfo as $uid => $user) {
			$result[$uid] = $user[$field];
		}
		return $result;
    }

	/**
	 * return the user posts done in the forum
	 *
	 * @param int uid
	 * @return int counter
	 */
    function userPosts($uid) {
		$c = _new("cache");
		if(!$count = $c->get("user_post:".$uid)) {
			$db = _new("db");
			$db->saveQry("SELECT COUNT(*) as `datasets` FROM `#_posts` WHERE `user` = ?",$uid);
			$count = $db->fetch_assoc(); $db->free();
			$count = $count['datasets'];
			$c->set("user_post:".$uid,$count, time()+ MONTH);
		}
		return $count;
    }

	/**
	 * returns userName
	 *
	 * @return str
	 */
    function uName($id) {
    	$cache = _new("cache");
		$users = $cache->get("userInfo");
		return $users[$id]['displayName'];
    }

    /**
     * userInfo changed
     * if user info changes cache will get deleted
     *
     * @return boolean
     */
    function changedUser($field = false) {
		if($field != false) {
			$db = _new("db");
			$db->saveQry("UPDATE `#_user` SET `lastEdit` = ?, `lastEditCat` = ? WHERE `ID` = ?",time(),$field,UID);
		}
		debugLog("userInfo wird resettet", "User info wird neu ausgelesen...", false,false,DBUG_WARNING);
		$cache = _new("cache");
		$cache->delete("userInfo");
		$cache->delete("userInfo/del");
		$this->_fetch_userInfo();
		debugLog("userInfo wurde resettet", "User info wurde neu ausgelesen!", false,false,DBUG_WARNING);
    }

    /**
     * session unification
     *
     * @return boolean
     */
    function _unification() {
		if($this->unification === false) {
			if(isset($_SESSION['IP']) && $_SESSION['IP'] != "") {
				if($_SESSION['IP'] != $_SERVER['REMOTE_ADDR']) {
					session_destroy();
					dispError(9);
				}
			} else {
				$_SESSION['IP'] = $_SERVER['REMOTE_ADDR'];
				$this->unification = $_SESSION['IP'];
			}
		}
		//debugLog("Unification","Successfully");
    }

	/**
	 * cleans the tmp files after a period of time
	 *
	 * cache over expired
	 * compiled tpls
	 * cached tpls
	 */
    function _cleanCache() {
		$cache = _new("cache");
		if($cache->get("lastClean") <= time()-CACHECLEANPERIOD){
			$cache->clean();
			$cache->set("lastClean",time(),time()+YEAR);
			debugLog("Cache cleaned","Periodic cache cleaning");
		}
    }

	/**
	 * cleans the tmp thumbs after a period of time
	 */
    function _cleanThumbs() {
    	$cache = _new("cache");
		if($cache->get("lastThumbClean") <= time()-THUMBCLEANPERIOD){
	    	$tmp = _new("tmp");
	    	$tmp->clearThumbs(time()- THUMBCLEANPERIOD);
			debugLog("Thumbs cleaned","Periodic thumb cleaning");
			$cache->set("lastThumbClean",time(),time()+YEAR);
		}
    }

    /**
     * readLanguage File
     *
     */
    function language() {
		$ulang = $this->userInfo(UID,"language");
		if($ulang == "")
			$ulang = defaultLng;
		$langUrl = LANGUAGES.$ulang.".lang.php";
		if(!file_exists($langUrl)) {
			debugLog("Language File is corrupt","The requested Language File is corrupt please contact your webmaster",$langUrl,UNKWN,DBUG_WARNING);
			$ulang = defaultLng; $langUrl = LANGUAGES.$ulang.".lang.php";
		}
		define("ULANG",	$ulang);

		$c = _new("cache");
		// Read language Data
		if(!$langData = $c->get("langFile-".$ulang)) {
			$fp = @fopen($langUrl, 'r');
			while($ln = fgets($fp)) {
				if(substr($ln, 0, strlen('// ##languageFile##')) == '// ##languageFile##')	{
					list(,, $langData['title'],
							$langData['author'],
							$langData['charset'],
							$langData['locale']) = explode('##', trim($ln));
					break;
				}
			}
			fclose($fp);
			$c->set("langFile-".$ulang,$langData, time()+MONTH);
		}

		// cache language parts
		$included = false;
		foreach(explode(";",languageFileParts) as $part) {
			if($c->get("langPart-".$ulang."-".$part) === FALSE) {
				if(!$included) @include_once($langUrl);
				$c->set("langPart-".$ulang."-".$part, $_lng_page[$part],time()+MONTH);
			}
		}

		//Finalize
    	setlocale(LC_ALL, $langData['locale']);
    	header('Connection: close');
		header('Content-Type: text/html; charset=' . $langData['charset']);
		define("LANGFILE", $langUrl);
		define("LANGCHARSET", $langData['charset']);
    }

    /**
     * template return
     *
     * @return str template
     */
    function template() {
    	$res = defaultTpl;
    	if(isset($_SESSION['template']) && $_SESSION['template'] != "") {
			$res = $_SESSION['template'];
		} else {
			$res = $_SESSION['template'] = $this->userInfo(UID,"template");
		}
		if(!is_dir( WEBROOT.$res."/") || $res == "")
			$res = defaultTpl;
		define("TEMPLATE", WEBROOT.$res."/");
    }

	/**
	 * changes the page Template
	 *
	 * @param String template name
	 */
    function changeTemplate($tpl = false) {
    	$db = _new("db");
    	if($tpl) $db->update("user",array("template"),array($tpl),"WHERE `ID` = '".UID."'");
    	else $db->update("user",array("template"),array(defaultTpl),"WHERE `ID` = '".UID."'");
    	unset($_SESSION['template']);
    	$cache = _new("cache");
		$cache->delete("userInfo");
		$this->_fetch_userInfo();
		debugLog("Template CHANGE","Das template wurde geaendert ! zu :".$tpl);
    }

	/**
	 * changes the language
	 *
	 * @param String Language
	 */
    function changeLang($tpl = false) {
    	$db = _new("db");
    	if($tpl) $db->update("user",array("language"),array($tpl),"WHERE `ID` = '".UID."'");
    	else $db->update("user",array("language"),array(defaultTpl),"WHERE `ID` = '".UID."'");
    	$cache = _new("cache");
		$cache->delete("userInfo");
		$cache->delete("changelog_content");
		$this->_fetch_userInfo();
		debugLog("Language CHANGE","Die Sprache wurde geaendert zu:".$tpl);
    }

}
?>