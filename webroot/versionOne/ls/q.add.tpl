{if $save == true}
<div class="box_info" style="width: 70%;margin-left: 15%;">
<h2><img src="{$_tpl}misc/quote.gif" border="0" alt="" /> {lng k='addquo' d='misc'}</h2><br>
{lng k='savequo' d='misc'}
</div>
{/if}

<h1><img src="{$_tpl}misc/quote.gif" border="0" alt="" /> {lng k='addquo' d='misc'}</h1><br>
<div class="box_n" style="margin-left: 20%;width:60%;">
<form action="./quotes.php?action=addquote" method="post">
<table cellpadding=2 cellspacing=0 border=0 style="width:100%;">
<tr>
<td style="width: 30%;">{lng k='quote' d='misc'}:</td>
<td><input style="width:95%;" type="text" name="quote" /></td>
</tr>
<tr>
<td>{lng k='who'} ?</td>
<td><input style="width:95%;" type="text" name="who" /></td>
</tr>
<tr>
<td>{lng k='where'} ?</td>
<td><input style="width:95%;" type="text" name="where" /></td>
</tr>
<tr>
<td></td>
<td><input type="submit" value="{lng k='submit'}" /> <input type="reset" value="{lng k='reset'}" /></td>
</tr>
</table>
</form>
</div>