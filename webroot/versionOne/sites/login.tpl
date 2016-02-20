<?xml version="1.0" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Language" content="en" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{$_title}</title>
	<link rel="stylesheet" type="text/css" href="{$_tpl}css/tpl_login.css" />
</head>
<body>
<div id="pg_center">
<div id="pg_pageframe">
	<form action="index.php" method="post">
		<input type="hidden" name="trytologin" value="true" />
		<div id="header">myMates v.2</div>
		<div id="loginTitle">{lng k='login'}</div><br/>
		<div id="login_area">
			{if $error eq 'true'}
			<center><i>{lng k='login_failed'}</i></center>
			{/if}
			<table cellpadding="2" cellspacing="0" border="0">
				<tr>
					<td style="width: 100px;"><label for="f1">{lng k='email'}:</label></td>
					<td><input type="text" id="f1" name="email" style="width: 251px;" /></td>
				</tr>
				<tr>
					<td><label for="f2">{lng k='password'}:</label></td>
					<td><input type="password" id="f2" name="pass" style="width: 251px;" /></td>
				</tr>
				<tr><td></td><td>
					<input type="checkbox" name="saveLogin" id="f3" value="true" /> <label for="f3">{lng k='login_remember'}</label>
				</td></tr>
				<tr><td></td><td style="text-align: left;">
					<input type="submit" style="font-size: 10px;" value="{lng k='submit'}" /> <input type="reset" style="font-size: 10px;" value="{lng k='reset'}" />
				</td></tr>
			</table>
			<div id="rights">{$_copy}</div>
		</div>
	</form>
</div>
</div>
</body>
</html>