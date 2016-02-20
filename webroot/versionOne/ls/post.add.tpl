<h1><img src="{$_tpl}misc/addpost.png" alt="" border=0 /> {lng k='addpost' d='board'}</h1>
<center>
<form action="./board.php?action=post&do=add&tid={$smarty.get.tid}" method="post">
<div class="box" style="width: 520px;">
<table cellpadding=2 cellspacing=1 border=0>
<tr>
	<td valign="top" style="width: 100px;">{lng k='posttext' d='board'}:</td>
	<td><textarea style="width: 400px;height: 200px;" name="text">{$quote}</textarea></td>
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
{if $res != true}<br/><br/>
<h1><img src="{$_tpl}misc/clog.png" alt="" border=0 /> {lng k='olderPosts' d='board'}</h1>
<table cellpadding=0 cellspacing=0 border=0 style="width: 96%;margin: 2%;">
<tr><td class="btitle">{lng k='author' d='board'}</td>
<td class="btitle">{lng k='post' d='board'}</td></tr>
{foreach from=$posts item=row}
<tr>
<td class="brow" style="vertical-align: top;font-size: 10px;">{uName id=$row.user}</td>
<td class="brow4">{$row.text|nl2br}</td>
</tr>
<tr><td style="background: url('{$_tpl}misc/dotted.png'); height: 1px;" colspan="2"></td></tr>
{foreachelse}
<tr><td colspan="2">{lng k='noItems'}</td></tr>
{/foreach}
</table>
{/if}