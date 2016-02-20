<?php
/*
 * Created on May 31, 2010
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */
include("./header.php");
?>
<h1>Install myMates v.2 beta</h1>
<form action="./step3.php" method="post">
<h2>mysql configuration</h2>
<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td style="width: 140px;">Host</td>
<td><input type="text" name="db[host]" value="localhost"/></td>
</tr>
<tr>
<td>User</td>
<td><input type="text" name="db[user]" value="root" /></td>
</tr>
<tr>
<td>Password</td>
<td><input type="text" name="db[pw]" value="password" /></td>
</tr>
<tr>
<td>Database</td>
<td><input type="text" name="db[db]" value="database" /></td>
</tr>
<tr>
<td>Prefix</td>
<td><input type="text" name="db[prefix]" value="" /></td>
</tr>
</table>
<h2>first user</h2>
<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td style="width: 140px;">Nickname</td>
<td><input type="text" name="user[disp]" value="MaxXx"/></td>
</tr>
<tr>
<td style="width: 140px;">Name</td>
<td><input type="text" name="user[name]" value="Max Mustermann"/></td>
</tr>
<tr>
<td style="width: 140px;">E-Mail</td>
<td><input type="text" name="user[mail]" value="example@server.com"/></td>
</tr>
</table>
<h2>system settings</h2>
<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td style="width: 140px;">Url</td>
<td><input type="text" name="sys[url]" value="http://server/myMates/"/></td>
</tr>
<tr>
<td style="width: 140px;">Page title</td>
<td><input type="text" name="sys[title]" value="myMates v.2"/></td>
</tr>
<tr>
<td style="width: 140px;">Admin password</td>
<td><input type="text" name="sys[admin]" value="password"/></td>
</tr>
</table>
<input type="submit" value="Abschicken" />
</form>