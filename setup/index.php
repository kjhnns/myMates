<?php
/*
 * Created on May 31, 2010
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */
include("./header.php");
?>
<h1>Install myMates v.2 beta</h1>
<?php
$goOn = true;
if(!is_writable("../etc")) {
	$goOn = false;
	$echo[] = "/etc/ Folder is not writable!";
}
if(!is_writable("../tmp")) {
	$goOn = false;
	$echo[] = "/tmp/ Folder is not writable!";
}
if(!is_writable("../gallery")) {
	$goOn = false;
	$echo[] = "/gallery/ Folder is not writable!";
}
if(!is_writable("../webroot/versionOne/cache")) {
	$goOn = false;
	$echo[] = "/webroot/versionOne/cache/ Folder is not writable!";
}
if(!is_writable("../moderate/webroot/cache")) {
	$goOn = false;
	$echo[] = "/moderate/webroot/cache/ Folder is not writable!";
}
if(!function_exists("mysql_connect")) {
	$goOn = false;
	$echo[] = "No mysql support!";
}

if($goOn == false) {
	echo "Some errors appeared!" .
			"<ul>";
		foreach($echo as $e) {
			echo "<li><b>".$e."</b></li>";
		}
	echo "</ul>";
}

?>
In the following steps you are going to install the myMates v.2 beta.
<br>
Lizenz und Hinweise:<br>
<textarea style="width: 800px;height: 300px;">
<?php
echo file_get_contents("./LIZENZ.txt");
?>
</textarea>
<br/><br/>
<?php
if($goOn) echo '<input type="button" onclick="location.href=\'step2.php\'" value="Ich akzeptiere die Lizenzbedingungen"/>';
?>
