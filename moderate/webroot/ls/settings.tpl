<h1><img src="{$_tpl}misc/attributes.png" /> {lng k="preferences"}</h1>
<div class="box">
<form action="?action=editAttributes" method="post">
<table cellpadding=2 cellspacing=2 border=0>
<tr><th>{lng k="pref"}</th><th>{lng k="value"}</th></tr>
{foreach from=$atts item=row}
{if $row.key == 'defaultLng'}
<tr>
	<td style="width: 40%;height:25px;">{lng k=$row.lng}</td>
	<td>
<select style="width: 100%;" name="atts[{$row.key}]">
{html_options output=$langs values=$langs selected=$row.value}
</select></td>
</tr>
{elseif $row.key == 'defaultTpl'}
<tr>
	<td style="width: 40%;height:25px;">{lng k=$row.lng}</td>
	<td><select style="width: 100%;" name="atts[{$row.key}]">
{html_options output=$temps values=$temps selected=$row.value}
</select></td>
</tr>
{else}
<tr>
	<td style="width: 40%;height:25px;">{lng k=$row.lng}</td>
	<td><input style="width: 100%;" type="text" name="atts[{$row.key}]" value="{$row.value}" /></td>
</tr>
{/if}
{/foreach}
<tr><td></td><td><input type="submit" value="{lng k="submit" d="page"}" />
</table>
</form>
</div>

<h1><img src="{$_tpl}misc/epp.png" /> {lng k="epps"}</h1>
<div class="box">
<form action="?action=editEpps" method="post">
<table cellpadding=2 cellspacing=2 border=0>
<tr><th>{lng k="pref"}</th><th>{lng k="value"}</th></tr>
{foreach from=$epps item=row}
<tr>
	<td style="width: 40%;height:25px;">{lng k=$row.lng}</td>
	<td><input style="width: 100%;" type="text" name="epps[{$row.key}]" value="{$row.value}" /></td>
</tr>
{/foreach}
<tr><td></td><td><input type="submit" value="{lng k="submit" d="page"}" />
</table>
</form>
</div>

<script type="text/javascript">
{literal}function pwCheck() {
if(document.getElementById("pw1").value != document.getElementById("pw2").value ||
		document.getElementById("pw1").value == ""){
	document.getElementById("info").style.display = "inline";
	return false;
}

return true;
}{/literal}
</script>
<h1><img src="{$_tpl}misc/password.png" /> {lng k="password"}</h1>
<div class="box">
<form action="?action=editpw" method="post" onsubmit="return pwCheck()">
<table cellpadding=2 cellspacing=2 border=0>
<tr>
	<td style="width: 40%;height:25px;">{lng k="pw1"}</td>
	<td><input type="password" id="pw1" name="pw1" /></td>
</tr>
<tr>
	<td>{lng k="pw2"}</td>
	<td><input type="password" id="pw2" name="pw2" /></td>
</tr>
<tr><td></td><td><input type="submit" value="{lng k="submit" d="page"}" />
</table>
</form>
</div>
<div class="box_info" id="info" style="display:none;">{lng k="pwequal"}</div>