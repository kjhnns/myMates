<script type="text/javascript">
var err = "{lng k='pweqerr' d='profile'}";
{literal}
function check() {
if(ebi("pw").value == ebi("pw2").value) {
return true;
} else {
alert(err);
return false;
}
}
{/literal}
</script>
<h1><img src="{$_tpl}misc/login.png" alt="" border=0 /> {lng k='editlogin' d='profile'}</h1>
<div class="box_n">
<form action="./myAccount.php?action=editLogin&amp;edit=true" method="post" onsubmit="check()">
<table cellpadding=2 cellspacing=1 border=0 style="width: 95%;">
<tr><td>{lng k='mail' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="email" type="text" value="{$user.email}" style="width: 100%;"></td></tr>
<tr><td>{lng k='pw' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" id="pw" name="pw" type="password" value="      " onclick="value=''" style="width: 100%;"></td></tr>
<tr><td>{lng k='pwwdh' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" id="pw2" name="pw2" type="password" value="      " onclick="value=''" style="width: 100%;"></td></tr>
</table>
<br>

<center>
<input type="submit" value="{lng k='submit'}" />
<input type="reset" value="{lng k='reset'}" />
</center>
</form>
<br>
</div>