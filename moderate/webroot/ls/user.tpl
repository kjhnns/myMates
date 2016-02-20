<script type="text/javascript">
var delText = "{lng k="rlyDelUser"}";
{literal}function pop(id) {
	Check = confirm(delText);
	if (Check == true)
	location.href="?action=delete&id="+id;
}{/literal}

var resText = "{lng k="rlyresetpw"}";
{literal}function reset(id) {
	Check = confirm(resText);
	if (Check == true)
	location.href="?action=resetpw&id="+id;
}{/literal}
</script>
<h1><img src="{$_tpl}misc/user.png" /> {lng k="usercp"}</h1>
<div class="box">
<table cellpadding=3 cellspacing=2 border=0>
<tr>
	<th style="width: 35%;">{lng k="name"}</th>
	<th style="width: 35%;">{lng k="email"}</th>
	<th style="width: 15%;">{lng k="lang"}</th>
	<th style="width: 15%;">{lng k="tpl"}</th>
	<th style="width: 5%;">{lng k="resetpw"}</th>
	<th style="width: 5%;">{lng k="delete"}</th>
</tr>
{foreach from=$res item=row}
<tr>
	<td>{$row.displayName}</td>
	<td>{$row.email}</td>
	<td>{$row.language}</td>
	<td>{$row.template}</td>
	<td style="text-align: center;"><a href="javascript:reset({$row.ID})">X</a></td>
	<td style="text-align: center;"><a href="javascript:pop({$row.ID})">X</a></td>
</tr>
{/foreach}
</table><br/><br/>
<a href="?action=create">{lng k="useradd"}</a>
</div>