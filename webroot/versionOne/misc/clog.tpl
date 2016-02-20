{assign var="incInt" value=1}
<table cellpadding="2" cellspacing="0" border="0" style="width:95%;">
{foreach from=$log item=row}
{if $archive != 1 && $_time-31*24*60*60 > $row.time or $row.key == 'clogcomm' or $row.key == 'quote' or $row.key == 'newPm' or $row.key == 'thread' or $row.key == 'post' or $row.key == 'profile'}
	<tr>
	<td style="width: 135px;">
	<img src="thumb.php?url={avatar k=$row.by}&amp;x=16&amp;y=16" border="0" class="avatar" style="margin:0px; margin-right:5px; margin-left: 30px;float:left;" alt="" />
	{uName id=$row.by slim='true'}
	</td>
	<td>
	{if $row.key=='clogstatus'}
		<span style="color: #888888;">{lng k='wrote'}:</span> {$row.value}
	{elseif $row.key=='image'}
		<a href="{$row.value}" target="_blank">{lng k='openPic'}: {$row.value|substr:0:30}...</a>
	{elseif $row.key=='cloglink'}
		<a href="{$row.value}" target="_blank">{$row.value|substr:0:30}...</a>
	{elseif $row.key=='youtube'}
		<a href="http://www.youtube.com/watch?v={$row.value}" target="_blank">{lng k='youtubevideo'}: {$row.title}</a>
	{elseif $row.key=='clogcomm'}
		{if $row.cat == 'profil'}
		<a href="profile.php?uid={$row.catitem}" style="color: #888888;font-weight:bold;">
		{elseif $row.cat == 'picture'}
		<a href="gallery.php?action=comments&id={$row.catitem}&gid={$row.gID}" style="color: #888888;">
		{else}
		<a style="color: #888888;">
		{/if}
		{lng k='commented'}:</a> {$row.value}
	{else}
		{$row.value}
	{/if}
	</td>
	<td><img src="{$_tpl}misc/clog/{$row.key}.png" alt="{$row.key}" border="0" /></td>
	<td style="text-align:center;color: #555555;">{$row.time|date_format:"%d"}.{months k=$row.time}</td>
	</tr>
	<tr><td colspan="4" class="trimmer"><img src="{$_tpl}misc/trimmer_old.jpg" border="0" alt="" /></td></tr>
{else}
	{* DIE ERSTEN 5 EINTaeGE *}
	<tr>
	<td class="clog_01">
	<h3 style="margin:2px;padding:0px;">{uName id=$row.by}</h3>
	<img src="thumb.php?url={avatar k=$row.by}&amp;x=100&amp;y=100" border="0" class="avatar" style="margin:2px;" alt="" />
	</td>
	<td class="clog_02">
	{if $row.key=='clogstatus'}
		<span style="color: #888888;">{lng k='wrote'}:</span> <span style="font-family: Trebuchet MS, Helvetica, sans-serif; font-size: 13pt;">{$row.value}</span>
	{elseif $row.key=='image'}
		<div style="float:right;margin-right: 15px;">
		<a href="{$row.value}" target="_blank">{lng k='openPic'}</a>
		</div>
		<img src="{$row.value}" id="clogimg{$incInt}" class="clogpostimage" onload="setSize('clogimg{$incInt}','{$row.value}')" onclick="zoomImg('clogimg{$incInt}','{$row.value}')" border="0" alt="Changelog post" />
	{elseif $row.key=='cloglink'}
		<h3 style="margin-bottom:2px;">{$row.title}</h3>
		<a href="{$row.value}" target="_blank" style="color: #666666;">{$row.value}</a>
		{if $row.desc != ""}<br>{$row.desc}{/if}
	{elseif $row.key=='youtube'}
	<h3 style="margin-bottom:2px;">{$row.title}</h3>
		<div id="vid" style="float: left; width: 305px;">
		<object width="300" height="200">
			<param name="movie" value="http://www.youtube.com/v/{$row.value}"></param>
			<param name="allowFullScreen" value="true"></param>
			<param name="allowscriptaccess" value="always"></param>
			<embed src="http://www.youtube.com/v/{$row.value}" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="300" height="200"></embed>
		</object>
		</div>
		<div style="height: 200px; padding: 5px; margin-bottom: 10px; color: #666666;">{$row.desc|wordwrap:25:" ":true}</div>
	{else}
		{$row.value}
	{/if}
	{if $row.visible == '0' && $row.key != "clogcomm" && $row.key != "thread"}
	<div style="padding: 3px;">
	{comments cat="clog" item=$row.ID report='false' layout="misc/clogcomments.tpl"}
	</div>
{/if}
</td>
<td class="clog_03">
	<img src="{$_tpl}misc/clog/{$row.key}.png" alt="{$row.key}" border="0" />
	{if $row.by==$_uid}
	<div style="margin-top: 5px;"><a href="#" onclick="ddel({$row.ID})"
	title="{lng k='delete'}"><img src="{$_tpl}misc/delete.png" alt="" border="0" /></a></div>
	{/if}
</td>
<td class="clog_04">
	<div class="year">{$row.time|date_format:"%d"}</div>
	<div class="mon">{months k=$row.time}</div>
	<div class="time">{$row.time|date_format:"%H:%I"}</div>
</td>
</tr>
<tr><td colspan="4" class="trimmer"><img src="{$_tpl}misc/trimmer.jpg" border="0" alt="" /></td></tr>
{/if}
{assign var="incInt" value=$incInt+1}
{/foreach}
</table>