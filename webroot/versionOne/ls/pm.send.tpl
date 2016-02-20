<h1><img src="{$_tpl}misc/pmwrite.png" border="0" alt=""/> {lng k='sendMsg'}</h1>
<center>
<form action="pm.php?action=deliver" method="post">
<div class="box" style="width: 520px;">
<table cellpadding=2 cellspacing=1 border=0>
<tr>
	<td style="width: 100px;">{lng k='receiver' d='pm'}:</td>
	<td>
		{if is_array($receiver)}
		{html_options name=receiver options=$receiver}
		{else}
		{uName id=$receiver}<input type="hidden" name="receiver" value="{$receiver}" />
		{/if}
	</td>
</tr>
<tr>
	<td>{lng k='title' d='pm'}:</td>
	<td>
	{if $title != ""}
	<input style="width: 400px;" type="text" name="title" value="{$title}" />
	{else}
	<input style="width: 400px;" type="text" name="title" />
	{/if}
	</td>
</tr>
<tr>
	<td valign="top">{lng k='text' d='pm'}:</td>
	<td>
	{if $text != ""}
	<textarea style="width: 400px;height: 200px;" name="text">{$text}</textarea>
	{else}
	<textarea style="width: 400px;height: 200px;" name="text"></textarea>
	{/if}
	</td>
</tr>
</table>
</div>
<table>
<tr>
	<td></td>
	<td><input type="submit" value="{lng k='submit'}" /> <input type="reset" value="{lng k='reset'}" /></td>
</tr>
</table>
</center>