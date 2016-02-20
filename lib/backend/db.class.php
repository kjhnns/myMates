<?php
/*
 * Created on 12.04.2008
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */


 /*
  * CONNECTION TO MYSQL SERVER
  */
 debugLog("Verbindung zur DB", "Verbindung zur Datenbank wird aufgebaut", __FILE__,__LINE__);

 if(file_exists(CONF."db.inc.php"))
 include(CONF."db.inc.php");
 else
 dispError( 7 );

 define("DB_DATABASE",		$db_conf['database']);
 define("DB_PREFIX", 		$db_conf['prefix']);
 define("DB_CONN", 			@mysql_connect(		$db_conf['host'],
	  											$db_conf['user'],
	  											$db_conf['password']	));
 if(!DB_CONN) dispError(1, __FILE__, __LINE__ );
 unset($db_conf);
 /*
  * END OF BUILD
  */


 /*
  * DEFINITION OF DB HANDLER
  */
 class db {
 	var $conn = false;
	var $qryRes = false;
	var $prefix;
	var $db;
	var $fQry = true;

	/*
	 * DB CONSTRUCTOR
	 *
	 * @param res [connID]
	 * @param str [database]
	 * @param str [prefix]
	 */
	function db($conn = false, $db = false, $pre = false) {
		if($conn) {
			$this->conn = $conn;
		} else {
			$this->conn = DB_CONN;
		}
		if($pre) {
			$this->prefix = $pre;
		} else {
			$this->prefix = DB_PREFIX;
		}
		if($db) {
			$this->db = $db;
		} else {
			$this->db = DB_DATABASE;
		}
		//debugLog("DB instanz erstellt","Eine instanz des DB handlers wurde erstellt.", __FILE__,__LINE__);
	}


	/*
	 * qrys the database
	 *
	 * @param str qry
	 * return qryResult
	 */
	function _qry($str) {
		global $_GLOBAL_QRYS;
		if($this->fQry) {
			mysql_select_db($this->db, $this->conn);
			$this->fQry = false;
		}
		$start =_microTime();
		$this->qryRes = mysql_query(replaceUml($str), $this->conn);
		$bench = _microTime() - $start;
		$_GLOBAL_QRYS++;
		if($this->qryRes) {
			debugLog("Qry gesendet erfolgreich", ">".$str."< - ".$bench."ms", __FILE__,__LINE__);
		} else {
			debugLog("Qry gesendet FEHLER", ">".$str."< - ".$bench."ms", __FILE__,__LINE__, DBUG_WARNING);
		}
		return $this->qryRes;
	}

	/*
	 * sends a save qry
	 * ? replaces parameters
	 *
	 * @param str qry
	 * return qryResult
	 */
	function saveQry($qry) {
		$args = func_get_args();
		$_qry = str_replace('#_', $this->prefix, $qry);
		$parts = explode("?",$_qry);
		$pos = strlen($parts[0]);
		for($i = 1; $i< count($args);$i++) {
			$arg = "'".$this->_esc($args[$i])."'";
			$_qry=substr_replace($_qry, $arg, $pos, 1);
			$pos+= strlen($arg) + strlen($parts[$i]);
		}
		return $this->_qry($_qry);
	}

	/*
	 * addslashes and escapes the qry
	 *
	 * @param str qry
	 * return str qry
	 */
	function _esc($str) {
		if(function_exists('mysql_real_escape_string'))
			return(mysql_real_escape_string($str, $this->conn));
		else if(function_exists('mysql_escape_string'))
			return(mysql_escape_string($str));
		else
			return(addslashes($str));
	}

	/*
	 * selects field from qry
	 *
	 * @param str qry
	 * @param str field
	 * return mixed field
	 */
	function select($str, $field) {
		$this->saveQry($str);
		$row = $this->fetch_assoc();
		return $row[$field];
	}

	/*
	 * mysql_num_rows
	 *
	 * @return int
	 */
	function numRows($table, $where = false) {
		if($where != false)
			$this->saveQry( "SELECT COUNT(*) as `datasets` FROM `#_".$table."` ".$where );
		else
			$this->saveQry( "SELECT COUNT(*) as `datasets` FROM `#_".$table."`" );
		$result = $this->fetch_assoc();
		return $result['datasets'];
	}

	/*
	 * mysql_fetch_assoc
	 *
	 * return array
	 */
	function fetch_assoc() {
        while ($row = mysql_fetch_assoc($this->qryRes)) {
            foreach($row as $k => $v) $res[stripslashes($k)]=stripslashes($v);
            return $res;
        }
    }

	/*
	 * mysql_insert_id
	 *
	 * return int ID
	 */
    function returnID() {
		return mysql_insert_id($this->conn);
    }

	/*
	 * inserts values into tables
	 *
	 * @param str table
	 * @param mixed fields
	 * @param mixed values
	 */
    function insert($table, $fields, $values,$replace = false) {
        if(is_array($fields)) {
        	for($i = 0; $i < count($fields); $i++) {
	            $fields[$i] = "`" . $this->_esc($fields[$i]) . "`";
	        }
        	$f = implode(",", $fields);
        } else {
        	$f = $this->_esc($fields);
        }
        if(is_array($values)) {
        	for($i = 0; $i < count($values); $i++) {
	            $values[$i] = "'" . $this->_esc($values[$i]) . "'";
	        }
	        $v = implode(",", $values);
        } else {
        	$v = "'".$this->_esc($values)."'";
        }
        if($replace) $job = "REPLACE ";
        else $job = "INSERT ";

        $str = 	$job."INTO " . $this->prefix . $table . " (".
        		$f . ") VALUES (".
        		$v . ")";

		return $this->_qry($str);
    }

	/*
	 * updates table row
	 *
	 * @param str table
	 * @param array fields
	 * @param array values
	 * @param str where
	 */
    function update($table, $fields, $values, $where) {
        $str = "UPDATE " . $this->prefix . $table . " SET ";
        for($i = 0; $i < count($values); $i++) {
            $strs[$i] = "`". $this->_esc($fields[$i]) . "` = '" . $this->_esc($values[$i]) . "'";
        }

        $s = implode(",", $strs);
        $str .= $s . " ";
        $str .= $where;

		return $this->_qry($str);
   }

	/*
	 * deletes from table where
	 *
	 * @param str table
	 * @param str where
	 * return result
	 */
   function delete($table, $where) {
		$str = "DELETE FROM " . $this->prefix . $table . " " . $where . "";
		return $this->_qry($str);
	}

	/*
	 * mysql_free_result
	 */
	function free() {
		mysql_free_result($this->qryRes);
	}
 }
?>
