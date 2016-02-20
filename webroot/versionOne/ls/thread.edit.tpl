<h1><img src="{$_tpl}misc/editthread.png" alt="" border=0 /> {lng k='editthread' d='board'}</h1>
<center>
<form action="./board.php?action=threads&do=update&tid={$smarty.get.tid}" method="post">
<div class="box" style="width: 520px;">
<table cellpadding=2 cellspacing=1 border=0>
<tr>
	<td style="width: 100px;">{lng k='title' d='board'}:</td>
	<td><input style="width: 400px;" type="text" name="title" value="{$title}" /></td>
</tr>
<tr>
	<td></td>
	<td><input type="checkbox" name="poll" value="1" {if $poll}checked=checked{/if} /> {lng k='attendancePoll' d='board'}?</td>
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