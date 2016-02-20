<script type="text/javascript">
var delText = "{lng k="rlyDelBoard"}";
{literal}function pop(id) {
	Check = confirm(delText);
	if (Check == true)
	location.href="?action=delete&id="+id;
}{/literal}
</script>
<h1><img src="{$_tpl}misc/board.png" /> {lng k="board"}</h1>
<div class="box">
<h4>{lng k="addboard"}</h4>
<form action="?action=add" method="post">
<table cellpadding=2 cellspacing=2 border=0>
<tr><td style="width: 30%;">{lng k="title" d="page"}</td><td><input style="width: 95%;" type="text" name="title" /></td></tr>
<tr><td>{lng k="description" d="page"}</td><td><input style="width: 95%;" type="text" name="desc" /></td></tr>
<tr><td></td><td><input type="submit" value="{lng k="submit" d="page"}" />
</table>
</form>
<h4>{lng k="delboard"}</h4><center>
<table cellpadding=3 cellspacing=2 border=0 style="width: 70%;">
<tr>
	<th style="width: 30%;">{lng k="title" d="page"}</th>
	<th style="width: 60%;">{lng k="description" d="page"}</th>
	<th style="width: 10%;">{lng k="delete"}</th>
</tr>
{foreach from=$res item=row}
<tr>
	<td>{$row.title}</td>
	<td><i>{$row.desc}</i></td>
	<td style="text-align: center;"><a href="javascript:pop({$row.ID})">X</a></td>
</tr>
{/foreach}
</table></center>
</div>