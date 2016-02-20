<?php
/*
 * Created on 19.01.2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

class user {
    var $logged;
    var $_ID;

    function user() {
    	$this->logged = false;
    	$this->_ID = false;
    }

	/*
	 * returns the field requested of the users db entrie
	 *
	 * return mixed result
	 */
    function info($field) {
		if($this->logged()) {
			$cache = _new("cache");
			$users = $cache->get("userInfo");
			return $users[$this->logged()][$field];
		} else {
			return false;
		}
    }
    function userInfo($field) { return $this->info($field); }

	/*
	 * doing the whole login procedure
	 *
	 * @param str email
	 * @param str password
	 * @param bool cookie
	 * @return login status
	 */
    function login($mail = FALSE, $pass = FALSE, $cook = FALSE) {
		debugLog("Tries to login", "Trying to login");
		if($mail && $pass) {
			if($cook === FALSE) {
				return $this->_login($mail,$pass);
			} else {
				if($this->_login($mail,$pass) == LOGIN_SUCCESS) {
					$this->_saveLogin();
					return LOGIN_CKSUCCESS;
				} else {
					return LOGIN_FAILED;
				}
			}
		} else {
			if(isset($_SESSION['logged']) && $_SESSION['logged'] != "") {
				$this->logged = true; $this->_ID = $_SESSION['logged'];
				return LOGIN_SUCCESS;
			} elseif(isset($_COOKIE['m8slogin']) && $_COOKIE['m8slogin'] != "") {
				return $this->_remeberLogin();
			}
		}
    }

	/*
	 * remebers a login whether there is one saved into a cookie
	 *
	 * @return boolean success
	 */
    function _remeberLogin() {
		$ckData = $_COOKIE['m8slogin'];
		$ckData = base64_decode($ckData);
		$ckData = @unserialize($ckData);
		if((int)$ckData['ID'] > 0) {
			$db = _new("db");
			$db->saveQry("SELECT * FROM `#_user` WHERE `ID`= ?",$ckData['ID']);
			$user = $db->fetch_assoc();
			$db->free();
			if(md5($user['password']) == $ckData['password']) {
				$this->logged = TRUE;
				$_SESSION['logged'] = $this->_ID = $user['ID'];
				debugLog("remeberootred Login", "Login konnte aus dem Cookie geladen werden.");
				return LOGIN_SUCCESS;
			} else {
				return LOGIN_FAILED;
			}
		} else {
			return LOGIN_FAILED;
		}
    }

	/*
	 * saves user login into a cookie
	 *
	 */
    function _saveLogin() {
        $save = array("ID" => $this->logged(), "password" => md5($this->info('password')));
        $ckContent = base64_encode(@serialize($save));
        setCookie("m8slogin", $ckContent, LOGINCOOKIELIFETIME);
        debugLog("Cookie gesaved", "Login cookie wurde gespeichert");
    }

	/*
	 * loggs in the user with given parameters
	 *
	 * @param str email
	 * @param str password
	 * @returns successstatus
	 */
    function _login($mail = FALSE, $pass = FALSE) {
		if($mail != FALSE && $pass != FALSE) {
			$db = _new("db");
			$db->saveQry("SELECT * FROM `#_user` WHERE `email` = ?",$mail);
			$user = $db->fetch_assoc(); $db->free();
			if(md5($pass.PASSWORDUNIQUESTRING) == $user['password']) {
				$this->logged = true;
				$_SESSION['logged'] = $this->_ID = $user['ID'];
				return LOGIN_SUCCESS;
			} else {
				return LOGIN_FAILED;
			}
		} else {
			return LOGIN_FAILED;
		}
    }

    /*
     * returns whether the user is logged in or not
     *
     * @return int UID
     */
    function logged() {
		if($this->logged) {
			return $this->_ID;
		} else {
			return false;
		}
    }

    /*
     * logout logs the user out
     */
    function logout() {
    	debugLog("Ausgeloggt", "User konnte erfolgreich ausgeloggt werden.");
		setCookie("m8slogin", "", 0);
		$cache = _new("cache");
		$cache->delete("onlineList");
		$this->logged = $_SESSION['logged'] = $this->_ID = false;
		session_destroy();
		return true;
    }

	/*
	 * changes the user avatar
	 *
	 * @param str tmp file
	 * @return boolean success
	 */
    function uploadAvatar($file) {
		if(@move_uploaded_file($file, AVATARS.md5(UID))) {
			$sess = _new("session");
			$sess->changedUser(USER_CHANGE_AVATAR);
			putChangelog(CLOG_PUBLIC, CLOG_AVATAR, UID);
			debugLog("Avatar uploaded", "avatar successfully uploaded",AVATARS.md5(UID));
			return true;
		} else {
			return false;
		}
    }

    /*
     * change user status
     */
    function statusUpdate($text) {
    	$db = _new("db");
		$db->saveQry("UPDATE `#_user` SET `status` = ? WHERE `ID` = ?",$text,UID);
		$s = _new("session");
		$s->changedUser(USER_CHANGE_STATUS);
		debugLog("Status changed", "status konnte erfolgriech geaendert werden",$text);
    }
}
?>