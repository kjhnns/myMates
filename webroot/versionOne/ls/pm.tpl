<h1><img src="{$_tpl}misc/pmStatus1.png" border="0" alt=""/> {lng k='inbox' d='pm'}</h1>
<center>
<table cellpadding=2 cellspacing=1 border=0>
<tr>
	<th style="width: 150px;">{lng k='date' d='pm'}</th>
	<th>&nbsp;</th>
	<th style="width: 350px;">{lng k='title' d='pm'}</th>
	<th>{lng k='author' d='pm'}</th>
</tr>
{foreach key=id item=item from=$messages}
<tr>
	<td>{$item.time|date_format:"%d.%m.%y - %H:%I"}</td>
	<td><img src="{$_tpl}misc/pmStatus{$item.new}.png" border="0" alt=""/></td>
	<td><a href="pm.php?action=read&amp;id={$item.ID}">
	{if $item.title == ""}
	{lng k="noTitle" d="pm"}
	{else}
	{$item.title}
	{/if}
	</a></td>
	<td>{uName id=$item.sID}</td>
</tr>
{/foreach}
</table>
{pagination url=$p_url act_page=$p_act per_page=$p_epp count=$p_cou var="page"}
</center>


