<h5><img src="{$_tpl}misc/pmStatus1.png" border="0" alt=""/>
{if $item.title == ""}
	{lng k="noTitle" d="pm"}
	{else}
	{$item.title}
	{/if}</h5>
<table cellpadding=2 cellspacing=1 border=0>
<tr><td>
{if $role == "receiver"}
{lng k='author' d='pm'}
{else}
{lng k='receiver' d='pm'}
{/if}
:</td><td>
{if $role == "receiver"}
{uName id=$message.sID}
{else}
{uName id=$message.rID}
{/if}
</td></tr>
<tr><td>{lng k='created' d='pm'}</td><td>{$message.time|date_format:"%d.%m.%y - %H:%I"}</td></tr>
</table>
<div class="box" style="margin-left: 100px;width: 450px; min-height: 200px;">
{$message.text}
</div>
