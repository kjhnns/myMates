<h1><img src="{$_tpl}misc/board.png" border="0" alt="" /> {lng k='board' d='board'}</h1>

<table cellpadding=0 cellspacing=0 border=0 style="width: 96%;margin: 2%;">
<tr><td class="btitle" style="width: 70%;">{lng k='area' d='board'}</td>
<td class="btitle" style="text-align: center;">{lng k='topics' d='board'}</td>
<td class="btitle" style="text-align: center;">{lng k='posts' d='board'}</td></tr>
{foreach from=$res item=row}
{cycle values='brow,brow2' assign=css}
<tr>
<td class="{$css}" style="font-size: 14px;">
<table cellpadding=0 cellspacing=0 border=0>
<tr><td rowspan="2"><img src="{$_tpl}misc/bicon.png" border="0" alt="" style="margin:0px;margin-bottom:-2px;" /></td>
<td><a href="./board.php?action=show&amp;bid={$row.ID}">{$row.title}</a></td></tr>
<tr><td class="bdesc">{$row.desc}</td></tr>
</table>
</td>
<td class="{$css}" style="text-align: center;">{$row.threads}</td>
<td class="{$css}" style="text-align: center;">{$row.posts}</td>
</tr>
<tr><td style="background: url('{$_tpl}misc/dotted.png'); height: 1px;" colspan="3"></td></tr>
{foreachelse}
<tr>
<td class="brow" colspan="3" style="text-align: center;">
{lng k='noItems'}</td>
</tr>
{/foreach}
</table>