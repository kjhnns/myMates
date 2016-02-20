<h1><img src="{$_tpl}misc/members.png" border=0 alt=""/> {lng k='user'}</h1>
<div class="box"><center>
<table cellpadding="2" cellspacing="1" border="0">
<tr>
	<th></th>
	<th style="width: 150px;">{lng k='nickname'}</th>
	<th style="width: 150px;">{lng k='name'}</th>
	<th style="width: 200px;text-align:center;">{lng k='lastchange'}</th>
	<th style="width: 20px;">{lng k='spm'}</th>
</tr>
{foreach key=id item=user from=$users}
<tr>
	<td style="text-align:center;padding-right: 10px;"><a href="thumb.php?url={avatar k=$id}&amp;x=400&amp;y=400" class="lightbox"><img class="avatar" src="thumb.php?url={avatar k=$id}&amp;x=100&amp;y=100" border="0" alt="" /></a></td>
	<td>{uName id=$id}</td>
	<td>{$user.name}</td>
	<td style="text-align:center;">{lng k=$user.lastEditCat d="userEdit"} ({$user.lastEdit|date_format:"%d.%m.%y"})</td>
	<td><a href="pm.php?action=send&amp;uid={$id}"><img src="{$_tpl}misc/pmStatus1.png" border="0" alt=""/></a></td>
</tr>
{/foreach}
</table>
</center></div>