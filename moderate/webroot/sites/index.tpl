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
<div id="pg_header">myMates v.2 - Administration</div>
<div id="pg_nav"><a href="./index.php">Index</a><br><a href="./user.php">users</a>
<br><a href="./logout.php">logout</a></div>
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