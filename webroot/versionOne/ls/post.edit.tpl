<h1><img src="{$_tpl}misc/editpost.png" alt="" border=0 /> {lng k='editpost' d='board'}</h1>
<center>
<form action="./board.php?action=post&do=update&pid={$smarty.get.pid}&tid={$smarty.get.tid}" method="post">
<div class="box" style="width: 520px;">
<table cellpadding=2 cellspacing=1 border=0>
<tr>
	<td valign="top" style="width: 100px;">{lng k='posttext' d='board'}:</td>
	<td><textarea style="width: 400px;height: 200px;" name="text">{$txt}</textarea></td>
</tr>
</table>
</div>
<table>
<tr>
	<td></td>
	<td><input type="submit" value="{lng k='edit'}" /> <input type="reset" value="{lng k='reset'}" /></td>
</tr>
</table>
</center>