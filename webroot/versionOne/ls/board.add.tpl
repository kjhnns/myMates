<h1><img src="{$_tpl}misc/addboard.png" alt="" border=0 /> {lng k='addboard' d='board'}</h1>
<div class="box_n" style="width: 50%;margin-left: 25%;">
<form action="./board.php?action=board&amp;do=post" method="post">
<table cellpadding=2 cellspacing=0 border=0 style="width: 100%">
<tr>
<td style="width: 30%">{lng k='title'}:</td>
<td style="width: 70%"><input type="text" style="width: 80%" name="title" /></td>
</tr><tr>
<td>{lng k='description'}:</td>
<td><input type="text" style="width: 80%" name="desc" /></td>
</tr><tr>
<td></td>
<td><input type="submit" value="{lng k='submit'}" /> <input type="reset" value="{lng k='reset'}" /></td>
</tr>
</table>
</form>
</div>