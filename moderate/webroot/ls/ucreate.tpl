<form action="?action=create&save=true" method="post">
<h1><img src="{$_tpl}misc/user.png" /> {lng k="createUser"}</h1>
<div class="box">
	<table cellpadding=2 cellspacing=3 border=0>
	<tr><td>{lng k="email" d="page"}:</td><td><input style="width: 300px;" type="text" name="email" /></td></tr>
	<tr><td>{lng k="name" d="page"}:</td><td><input style="width: 300px;" type="text" name="name" /></td></tr>
	<tr><td></td><td><input type="submit" value="{lng k="submit" d="page"}" /></td></tr>
	</table>
</div>
</form>