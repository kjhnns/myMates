<h1><img src="{$_tpl}misc/addthread.png" alt="" border=0 /> {lng k='addthread' d='board'}</h1>
<center>
<form action="./board.php?action=threads&do=add&bid={$smarty.get.bid}" method="post">
<div class="box" style="width: 520px;">
<table cellpadding=2 cellspacing=1 border=0>
<tr>
	<td style="width: 100px;">{lng k='title' d='board'}:</td>
	<td><input style="width: 400px;" type="text" name="title" /></td>
</tr>
<tr>
	<td valign="top">{lng k='text' d='board'}:</td>
	<td><textarea style="width: 400px;height: 200px;" name="text"></textarea></td>
</tr>
<tr>
	<td></td>
	<td><input type="checkbox" name="poll" value="1" /> {lng k='attendancePoll' d='board'}?</td>
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