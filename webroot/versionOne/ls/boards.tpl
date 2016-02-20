<h1><img src="{$_tpl}misc/board.png" border="0" alt="" /> {lng k='board' d='board'}</h1>

<table cellpadding=0 cellspacing=0 border=0 style="width: 96%;margin: 2%;">
<tr><td class="btitle" style="width: 50%;">{lng k='title'}</td>
<td class="btitle" style="text-align: center;">{lng k='author' d='board'}</td>
<td class="btitle" style="text-align: center;">{lng k='lpost' d='board'}</td>
<td class="btitle" style="text-align: center;">{lng k='posts' d='board'}</td></tr>
{foreach from=$res item=row}
{cycle values='brow,brow2' assign=css}
<tr>
<td class="{$css}" style="font-size: 14px;">
<table cellpadding=0 cellspacing=0 border=0>
<tr><td><a href="./board.php?action=thread&amp;tid={$row.ID}&amp;page={$row.sites}#last">{$row.title}</a></td></tr>
<tr><td class="bdesc">{lng k='createdat' d='board'}{$row.stp|date_format:"%d.%m.%y - %H:%I"} - {lng k='sites' d='board'}: {$row.sites}</td></tr>
</table>
</td>
<td class="{$css}" style="text-align: center;">{uName id=$row.user slim=true}</td>
<td class="{$css}" style="text-align: center;">{uName id=$row.lpost.user slim=true}</td>
<td class="{$css}" style="text-align: center;">{$row.posts}</td>
</tr>
<tr><td style="background: url('{$_tpl}misc/dotted.png'); height: 1px;" colspan="4"></td></tr>
{/foreach}
</table>
<p align="center">{pagination url=$p_url act_page=$p_act per_page=$p_epp count=$p_cou var="page"}</p>