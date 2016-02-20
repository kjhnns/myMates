<?php
/*
 * Created on May 31, 2010
 *
 * (c) by vanja k. | zigeuner51@gmail.com
 */
 session_start();

include("./header.php");

 function genRandomString($length) {
    $characters = '0123456789!¤-.,#+%&()=?abcdefghiQWERTZUIOPASDFGHJKLYXCNMBXYjklmnopqrstuvwxyz';
    $string = '';
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters-1))];
    }
    return $string;
}

$db = @mysql_connect($_POST['db']['host'],$_POST['db']['user'],$_POST['db']['pw']);

if(!$db) {
	echo "ERROR: Couldn't establish mysql connection! Setup cancled!";exit;
}
if(!mysql_select_db($_POST['db']['db'])) {
	echo "ERROR: Database is not available! Setup cancled!";exit;
}
mysql_close($db);

$_POST['sys']['str'] = genRandomString(30);
$_SESSION['sys'] = $_POST['sys'];
$_SESSION['db'] = $_POST['db'];
$_SESSION['user'] = $_POST['user'];
?>
<h1>Last step...</H1>
In the next step you are finally going to install myMates v.2 this is your last chance to cancle the setup!
<br><br>
<input type="button" onclick="location.href='./install.php';value='installing...';disabled='disabled'" value="Install"/>
