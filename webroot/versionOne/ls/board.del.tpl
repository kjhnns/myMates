{if $res == true}
<div class="box_info">
<h2><img src="{$_tpl}misc/delete.png" alt="" border=0 /> {lng k='delBoardTitle' d='board'}</h2>
{lng k='delBoardText' d='board'}
</div>
{/if}
<h1><img src="{$_tpl}misc/delboard.png" alt="" border=0 /> {lng k='addboard' d='board'}</h1>
<div class="box_n" style="width: 50%;margin-left: 25%;min-height: 80px;">
<form action="./board.php?action=board&amp;do=delete" method="post">
<table cellpadding=2 cellspacing=0 border=0 style="width: 100%">
<tr>
<td style="width: 30%">{lng k='title'}:</td>
<td style="width: 70%">{html_options name=id options=$bs}</td>
</tr><tr>
<td></td>
<td><input type="submit" value="{lng k='delete'}" /></td>
</tr>
</table>
</form>
</div>