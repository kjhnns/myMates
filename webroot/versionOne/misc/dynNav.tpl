{if $_dynNav != false}
<div id="dynTitle">{lng k='options'} | <a style="color: #FFFFFF; font-weight: normal;" href="javascript:switchDynNav()">{lng k="online"} ({$_usersOnline})</a></div>
<div id="dynNavBox">
	{foreach key=dtitle item=durl from=$_dynNav}
	{if $durl|strstr:'fullimage'}
		<div class="nItem"><a href="javascript:full()" id="wrapper">{$dtitle}</a></div>
	{elseif $durl|strstr:'cryptlink' or $durl|strstr:'pictureWrapper.php'}
		<div class="nItem"><a href="javascript:wrapper()" id="wrapper">{$dtitle}</a></div>
	{elseif $durl|substr:0:7 == 'http://'}
		<div class="nItem"><a href="{$durl}" target="_blank">{$dtitle}</a></div>
	{else}
		<div class="nItem"><a href="{$durl}">{$dtitle}</a></div>
	{/if}
	{/foreach}
</div>
{/if}

{if $_dynNav != false}<div id="onlineBox" style="display: none;">{/if}
{if $_dynNav == false}<div id="dynTitle">{lng k="online"} ({$_usersOnline})</div>{/if}

	{foreach key=user item=status from=$_onlineList}
	<div class="nItem">
		<table cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 2px;"><tr>
			<td style="width: 25px;"><img src="thumb.php?url={avatar k=$user}&amp;x=20&amp;y=15" border=0 class="avatar" alt="" style="float: left;" /></td>
			<td style="width: 220px;">&nbsp;<a href="profile.php?uid={$user}">{uInfo id=$user f='displayName'}</a></td>
			<td><a href="pm.php?action=send&amp;uid={$user}"><img src="{$_tpl}misc/pmStatus1.png" border="0" /></a></td>
		</tr></table>
	</div>
	{/foreach}

{if $_dynNav != false}</div>{/if}