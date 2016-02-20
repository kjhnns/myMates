<?xml version="1.0" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset={$_charset}" />
	<title>{$_title}</title>
	<link rel="shortcut icon" type="image/png" href="../favicon.png">
	<link rel="stylesheet" type="text/css" href="{$_tpl}css/tpl_layout.css" />
	<link rel="stylesheet" type="text/css" href="{$_tpl}css/tpl_content.css" />
	<link rel="stylesheet" type="text/css" href="{$_tpl}css/jquery.lightbox-0.5.css" media="screen" />
	<script type="text/javascript" src="{$_lib}jquery.js"></script>
	<script type="text/javascript" src="{$_lib}jquery.lightbox-0.5.min.js"></script>
</head>
<body>
<div id="pg_header">myMates v.2 - {lng k="moderate"}</div>
<div id="pg_nav">
	<ul id="pg_navItems">
		<li><a href="./index.php">{lng k="nstart"}</a></li>
		<li><a href="./user.php">{lng k="nuser"}</a></li>
		<li><a href="./settings.php">{lng k="nsettings"}</a></li>
		<li><a href="./board.php">{lng k="nboard"}</a></li>

		<li style="padding-top: 80px;"><a href="./logout.php">{lng k="logout"}</a></li>
		<li><a href="../">{lng k="npage"}</a></li>
	</ul>
</div>
<div id="pg_subhead"></div>
<div id="pg_content">
{if $_includeContent != ""}
	{include file="$_includeContent"}
{else}
	{include file="ls/noContent.tpl"}
{/if}
</div>
</body>
</html>