<?xml version="1.0" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset={$_charset}" />
	<title>{$_title}</title>
	<link rel="shortcut icon" type="image/png" href="./favicon.png">
	<link rel="alternate" type="application/atom+xml" title="{lng k='desc' d='rss'}" href="{$_rss}" />
	<link rel="stylesheet" type="text/css" href="{$_tpl}css/tpl_layout.css" />
	<link rel="stylesheet" type="text/css" href="{$_tpl}css/tpl_basics.css" />
	<link rel="stylesheet" type="text/css" href="{$_tpl}css/tpl_content.css" />
	<link rel="stylesheet" type="text/css" href="{$_tpl}css/tpl_misc.css" />
	<link rel="stylesheet" type="text/css" href="{$_tpl}css/jquery.lightbox-0.5.css" media="screen" />
	<script type="text/javascript" src="{$_lib}jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="{$_lib}jquery.lightbox-0.5.min.js"></script>
	<script type="text/javascript" src="{$_lib}myMates.js"></script>
	<script type="text/javascript" src="{$_tpl}misc/template.js"></script>
	<script type="text/javascript">
		var chatRefreshTime = {$_chatRefreshTime};
		var lng_online = "{lng k='online'}";
		var lng_options = "{lng k='options'}";
		var lng_status = "{lng k='postStatus'}";
		var lng_link = "{lng k='postLink'}";
		var lng_clogText = "{lng k='clogPostText'}";
		var onlineUser = "{$_usersOnline}";
		var p_tpl = "{$_tpl}";
		{literal}$(function() {
			$('a.lightbox').lightBox({
				imageLoading: p_tpl+'misc/lightbox/loading.gif',
				imageBtnClose: p_tpl+'misc/lightbox/close.gif',
				imageBtnPrev: p_tpl+'misc/lightbox/prev.gif',
				imageBtnNext: p_tpl+'misc/lightbox/next.gif'
			});
		});{/literal}
	</script>
</head>
<body>
<audio id="chatBing" preload="preload" src="{$_tpl}misc/bing.ogg"></audio>
<div id="pg_center">
	<div id="pg_pageframe">
		<div id="pg_headbar">
			<div id="pg_logo">myMates v.2</div>
			<div class="pg_navButton"><a class="navItem" href="./index.php">{lng k="index" d="nav"}</a></div>
			<div class="pg_navButton"><a class="navItem" href="./board.php">{lng k="board" d="nav"}</a></div>
			<div class="pg_navButton"><a class="navItem" href="./gallery.php">{lng k="gallery" d="nav"}</a></div>
			<div class="pg_navButton"><a class="navItem" href="./profile.php?action=members">{lng k="community" d="nav"}</a></div>
			<div class="pg_navButton"><a class="navItem" href="./quotes.php">{lng k="quotes" d="nav"}</a></div>
			<div class="pg_navButton"><a class="navItem" href="./pm.php">{lng k="pm" d="nav"}</a></div>
			<div style="float:right;">
			<div id="online">{lng k='hello'}, <a style="color: #FFFFFF; text-decoration: underline;" href="profile.php?uid={$_uid}">{uInfo f='displayName'}</a></div>
			<div class="pg_navButton" style="width: 100px;border-left:1px #123D98 solid;"><a class="navItem" href="myAccount.php">{lng k="myAcc" d="nav"}</a></div>
			<div class="pg_navButton" style="width: 60px;"><a class="navItem" href="logout.php">{lng k="logout" d="nav"}</a></div>
			</div>
		</div><br/>
		<div id="pg_contentArea">
		{if $_includeContent != ""}
			{include file="$_includeContent"}
		{else}
			{include file="misc/noContent.tpl"}
		{/if}
		</div>
		<div id="pg_rightbar">
			<div id="pg_chat">{include file="misc/chat.tpl"}</div>
			<div id="pg_dynNavigation">{include file="misc/dynNav.tpl"}<br/><br/><br/></div>
		</div>
		<div id="pg_bottom">{$_copy} - <a href="#">{lng k='top'}</a> - v.{$_version}</div>
	</div>
</div>
</body>
</html>