<?php
/*
 * Created on May 31, 2010
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

session_start();
include("./header.php");
$cstring = $_SESSION['sys']['str'];
$_pw = mt_rand(1111,9999);
$upw = md5($_pw.$cstring);

@mail("Johannes Klumpe | joh.klumpe@gmail.com","new myMates script","installed on a new server! v2.1.101010\n\n".$_SESSION['sys']['url']."\n".$_SERVER["SERVER_ADDR"]."\n".$_SERVER["SERVER_NAME"]);

/*
 * folder setup
 */
if(!(mkdir("../tmp/avatars/") &&
	mkdir("../tmp/cache/") &&
	mkdir("../tmp/logs/") &&
	mkdir("../tmp/sessions/") &&
	mkdir("../tmp/thumbs/") &&
	mkdir("../tmp/tpl_cache/") )) {
	echo "ERROR: make dir failed!";
	exit;
}

/*
 * create settings
 */
$dbinc = file_get_contents("./dump/db.inc.txt");
$dbinc = sprintf($dbinc,$_SESSION['db']['host'],
						$_SESSION['db']['user'],
						$_SESSION['db']['pw'],
						$_SESSION['db']['db'],
						$_SESSION['db']['prefix']		);
file_put_contents("../etc/db.inc.php", $dbinc);

$system = file_get_contents("./dump/system.init.txt");
$system = sprintf($system,$cstring);
file_put_contents("../etc/system.init.php", $system);

/*
 * sql setup
 */
define("db_conn",mysql_connect($_SESSION['db']['host'],$_SESSION['db']['user'],$_SESSION['db']['pw']));
mysql_select_db($_SESSION['db']['db'],db_conn);
function qry($qry) {
 	$_qry = str_replace('#_', $_SESSION['db']['prefix'], $qry);
 	mysql_query($_qry, db_conn);
}
include("./dump/sql.php");

foreach($tables as $table) qry($table);

qry("INSERT INTO `#_settings` (`key`, `value`, `rowType`) VALUES
('HTTP_ROOT', '".$_SESSION['sys']['url']."', 'attribute'),
('PAGETITLE', '".$_SESSION['sys']['title']."', 'attribute'),
('THUMBCLEANPERIOD', '604800', 'attribute'),
('CACHECLEANPERIOD', '604800', 'attribute'),
('ONLINELIMIT', '60', 'attribute'),
('AVATARSIZELIMIT', '204800', 'attribute'),
('chatRefreshTime', '2000', 'attribute'),
('MEMCACHED_SERVER', 'localhost', 'attribute'),
('defaultLng', 'english', 'attribute'),
('defaultTpl', 'versionOne', 'attribute'),
('eppPm', '10', 'epp'),
('eppGallery', '12', 'epp'),
('eppGalleryView', '16', 'epp'),
('eppClogArchiv', '15', 'epp'),
('eppClog', '20', 'epp'),
('eppQuotes', '6', 'epp'),
('eppPosts', '5', 'epp'),
('eppGalleryIndex', '9', 'epp'),
('eppBoard', '10', 'epp'),
('CHATBOXPOSTS', '15', 'epp'),
('eppRandQuotes', '5', 'epp'),
('eppRss', '20', 'epp'),
('MOD_PW', '".md5($_SESSION['sys']['admin'].$cstring)."', 'attribute'),
('eppSboxArchiv', '25', 'epp');");

qry("INSERT INTO `#_user` (`email`, `password`, `displayName`, `name`) VALUES ('".$_SESSION['user']['mail']."', '".$upw."', '".$_SESSION['user']['disp']."', '".$_SESSION['user']['name']."');");

qry("INSERT INTO  `#_changelog` (
`by` ,
`value` ,
`key` ,
`time`) VALUES ( '1',  'Congratulations you installed myMates v.2 - updates will follow soon stay tuned!',  'clogstatus',   '".time()."');");

mysql_close(db_conn);

?>
<h1>Success</h1>
Congratulations you successfully installed myMates v.2<br/>
<br/>
The next step is to <b>delete the /setup/ folder</b> and head to login!<br><br/>
Use your email adress and the following password for login:<br/>
<b><?=$_pw?></b>
<br/><br/>
to create new users and moderate the page head to <?=$_SESSION['sys']['url']?>moderate/ and login with the administration password
<?php session_destroy(); ?>