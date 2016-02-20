
<h1><img src="{$_tpl}misc/infos.png" alt="" border=0 /> {lng k='editinformation' d='profile'}</h1>
<div class="box_n">
<form action="./myAccount.php?action=editInfos&amp;edit=true" method="post">
<table cellpadding=2 cellspacing=1 border=0 style="width: 95%;">
<tr><td style="width: 25%;">{lng k='name' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="name" type="text" value="{$user.name}" style="width: 100%;"></td></td></tr>
<tr><td>{lng k='nick' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="displayName" type="text" value="{$user.displayName}" style="width: 100%;"></td></tr>
<tr><td>{lng k='bday' d='profile'}:</td>
<td style="width: 75%;">{html_select_date start_year=1930 month_format="%B" time=$user.bday field_order="DMY"}</td></tr>
<tr><td>{lng k='icq' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="icq" type="text" value="{$user.icq}" style="width: 100%;"></td></tr>
<tr><td>{lng k='skype' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="skype" type="text" value="{$user.skype}" style="width: 100%;"></td></tr>
<tr><td>{lng k='msn' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="msn" type="text" value="{$user.msn}" style="width: 100%;"></td></tr>
<tr><td>{lng k='mobile' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="mobile" type="text" value="{$user.mobile}" style="width: 100%;"></td></tr>
<tr><td valign="top">{lng k='signature' d='profile'}:</td>
<td style="width: 75%;"><textarea style="width: 100%; padding: 2px; font-size: 10pt;" rows="10" name="signature">{$user.signature}</textarea></td></tr>
</table>
<br>

<center>
<input type="submit" value="{lng k='submit'}" />
<input type="reset" value="{lng k='reset'}" />
</center>
</form>
<br>
</div>