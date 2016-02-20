<?php
/*
 * Created on 14.04.2008
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

/*
 * TPL FUNCTIONS
 *
 * {months k=%UNIXTIMESTAMP%} - gibt en aktuellen monatsnamen zurueck
 * {online id=%UID%} - gibt nen html bild code zurueck ob ID online ist
 * {lng k=%KEY% d=%DIM%} - returned das wort in der sprache ;)
 * {pagination url=a count=b act_page=c per_page=d var=e} - pagination
 * {uencode url=%URL%} - urlencode()
 * {avatar k=%UID%} - gibt die bildadresse des jeweiligen avatars
 * {uInfo id=%UID% f=%field%} gibt die jeweiligen daten aus der user db
 * {uName id=%UID% slim=true} gibt den usernamen zurueck
 * {comments cat=%CATEGORY% item=%CATID% layout=%URL%} Kommentar funktion
 * {uposts id=%UID%} gibt die user posts im forum zurueck
 * {uSignature id=%UID%} gibt die signatur des Benutzers zurŸck
 * {bday date=%BDAY%} gibt das alter sowie das geburtsdatum des users zurueck
 * {http url=%url%} gibt die richtige url zurueck
 */

define("SMARTY_DIR", BACKEND . "smarty/");
require_once SMARTY_DIR . "Smarty.class.php";

class parser extends Smarty {

    var $_dynNav;

    function parser() {
        //debugLog("Neue parser Instanz", "Es wurde eine neue parser instanz geladen");
        $this->Smarty();
        $this->__enviroment();
    }

    /*
     * LOADS THE ENV FOR MODUL LAYOUTS
     */
    function __enviroment() {
        $this->template_dir = TEMPLATE;
        $this->compile_dir = TEMPLATE . tplCfg('compiledFolder');
        $this->config_dir = TEMPLATE;
        $this->cache_dir = TEMP . 'tpl_cache/';
        if (DEBUG) {
            //$this->debugging = true;
        } else {
            $this->error_reporting = 0;
        }
        $this->compile_check = COMPILE_CHECK;
        $this->writeAbleCheck();
        $this->_defaultAssigns();
        $this->_registerFunctions();
        $this->_assignOnlineList();
        $this->_dynNav = false;
        //debugLog("parser Env geladen", "Enviroment konnte geladen werden");
    }

    /*
     * defines important template vars
     */
    function _defaultAssigns() {
        $this->assign("_tpl", $this->template_dir);
        $this->assign("_charset", LANGCHARSET);
        $this->assign("_lib", CLIENTLIB);
        $this->assign("_copy", COPYRIGHT);
        $this->assign("_avatar", UAVATAR);
        $this->assign("_uid", UID);
        $this->assign("_version", VERSION);
        $this->assign("_time", time());
        $this->assign("_rss", HTTP_ROOT . "index.php?action=rss");
        $this->assign("_chatRefreshTime", chatRefreshTimeAssigned);
    }

    /*
     * registers template important functions
     */
    function _registerFunctions() {
        $this->register_function("lng", "tplpageLng");
        $this->register_function("uName", "tpluserName");
        $this->register_function("online", "tplonline");
        $this->register_function("avatar", "tpluserAvatar");
        $this->register_function("pagination", "tplpagination");
        $this->register_function("uInfo", "tpluserInfo");
        $this->register_function("months", "tplmonths");
        $this->register_function("uencode", "tplurlencode");
        $this->register_function("http", "tplhttp");
        $this->register_function("comments", "tplcomments");
        $this->register_function("uposts", "tpluserposts");
        $this->register_function("uSignature", "tplusignature");
        $this->register_function("bday", "tplbday");
    }

    /*
     * assigns the online list
     */
    function _assignOnlineList() {
        $sess = _new("session");
        $this->assign("_usersOnline", $sess->online());
        $this->assign("_onlineList", $sess->onlineUser());
    }

    /*
     * Assigns Arrays
     */
    function assignArray($fields, $values) {
        $i = 0;
        foreach ($fields as $f) {
            $this->assign($f, $values[$i]);
            $i++;
        }
    }

    /*
     * sets the path to the content layout
     */
    function setContent($url) {
        if (!$this->_dynNav) {
            $this->assign("_dynNav", false);
        } else {
            $this->assign("_dynNav", $this->_dynNav);
        }

        $this->assign("_includeContent", $url);
    }

    /*
     * sets the path to the secondary navigationm
     */
    function setNav($title, $url = false) {
        $this->_dynNav[$title] = $url;
    }

    function display($c) {
        if (defined("pageTitleExt")) {
            $this->assign("_title", PAGETITLE . " - " . pageTitleExt);
        } else {
            $this->assign("_title", PAGETITLE);
        }
        echo $this->fetch($c);
    }

    /*
     * Activates/deactivates caching
     */
    function cache($bool) {
        $this->caching = $bool;
    }

    /*
     * RETURNING writeAbleCheck
     */
    function writeAbleCheck() {
        isWriteAbleCheck(array($this->compile_dir, $this->cache_dir));
    }
}

function tplpageLng($params, &$smarty) {
    if (empty($params['k'])) {
        $key = "unknown";
    } else {
        $key = $params['k'];
    }
    if (empty($params['d'])) {
        $dim = false;
    } else {
        $dim = $params['d'];
    }
    return lang($key, $dim);
}

function tpluserName($params) {
    $sess = _new("session");
    if ($params['id'] == "") {
        $params['id'] = UID;
    }

    if ($params['slim'] == 'true') {
        $ret = "";
    } else {
        if ($sess->uOnline($params['id'])) {
            $ret = "<img src=\"" . TEMPLATE . tplCfg("onlinePic") . "\" border=\"0\" alt=\"\" /> ";
        } else {
            $ret = "<img src=\"" . TEMPLATE . tplCfg("offlinePic") . "\" border=\"0\" alt=\"\" /> ";
        }
    }
    return $ret . "<a href=\"profile.php?uid=" . $params['id'] . "\">" . $sess->uName($params['id']) . "</a>";
}

function tplonline($params) {
    $sess = _new("session");
    if ($params['id'] == "") {
        $params['id'] = UID;
    }

    if ($sess->uOnline($params['id'])) {
        $ret = "<img src=\"" . TEMPLATE . tplCfg("onlinePic") . "\" border=\"0\" alt=\"\" />";
    } else {
        $ret = "<img src=\"" . TEMPLATE . tplCfg("offlinePic") . "\" border=\"0\" alt=\"\" />";
    }
    return $ret;
}

function tpluserInfo($params) {
    $sess = _new("session");
    if ($params['id'] == "") {
        $params['id'] = UID;
    }

    return $sess->userInfo($params['id'], $params['f']);
}

function tplusignature($params) {
    $sess = _new("session");
    $sig = $sess->userInfo($params['id'], "signature");
    if ($sig != "") {
        return $params['divide'] . $sig;
    } else {
        return "";
    }

}

function tplpagination($params, &$smarty) {
    return pagination($params['url'], $params['count'], $params['act_page'], $params['per_page'], $params['var']);
}

function tpluserAvatar($params, &$smarty) {
    if ($params['k'] == "") {
        $params['k'] = UID;
    }

    $key = $params['k'];
    $ava = AVATARS . md5($key);
    if (file_exists($ava) && $ava != AVATARS) {
        return $ava;
    } else {
        return TEMPLATE . tplCfg('avatarDefault');
    }
}

function tplmonths($params) {
    if ($params['k'] == "") {
        $params['k'] = time();
    }

    $k = $params['k'];
    $mon = (int) date("m", $k);
    $ms = lang("months");
    return $ms[$mon];
}

function tplbday($params) {
    $k = $params['date'];
    list($y, $m, $d) = explode("-", $k);
    $_Y = date("Y") - $y - 1;
    if (intval($m . $d) < intval(date("m") . date("d"))) {
        $_Y++;
    }

    return $d . "." . $m . "." . $y . " (" . $_Y . ")";
}

function tplhttp($params) {
    $k = $params['url'];
    return http($k);
}

function tpluserposts($params) {
    $sess = _new("session");
    return $sess->userPosts($params['id']);
}

function tplcomments($params, &$smarty) {
    // params: cat_id cat_item layout
    $comms = fetchComments($params['cat'], $params['item']);
    // pagination func ---- kein bock gehabt :D
    $smarty->assign("comments", $comms);
    $smarty->assign("cat_id", $params['cat']);
    $smarty->assign("cat_item", $params['item']);

    if ($params['report'] == 'false') {
        $smarty->assign("report", "0");
    } else {
        $smarty->assign("report", "1");
    }

    if ($params['layout'] == "") {
        $params['layout'] = tplCfg('commentsDefault');
    }

    return $smarty->fetch($params['layout']);
}

function tplurlencode($params) {
    return urlencode($params['url']);
}

?>
