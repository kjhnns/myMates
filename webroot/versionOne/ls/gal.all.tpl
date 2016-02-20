<h1><img src="{$_tpl}misc/gallery.png" border=0 alt="" /> {lng k='title' d='gal'}</h1>
<p align="center">{pagination url=$p_url act_page=$p_act per_page=$p_epp count=$p_cou var="page"}</p>
<center><table cellpadding=0 cellspacing=0 border=0><tr>
{assign var="incInt" value=1}
{foreach from=$res item=gal}<td>
<div class="album" style="margin-right: 30px;">
<div class="albumTitle"><a href="./gallery.php?action=view&gid={$gal.ID}">{$gal.title}</a></div>
<a href="./gallery.php?action=view&gid={$gal.ID}">
<img style="border: 1px #666666 solid;" src="thumb.php?url={$gal.cover}&x=150&y=150" alt=""/>
</a><br/>
<span style="color: #555555;margin:0px;">{$gal.created|date_format:"%d.%m.%Y"} {lng k='by'} {uName id=$gal.by slim='true'}</span>
</div></td>
{if $incInt%3==0}</tr><tr>{/if}
{assign var="incInt" value=$incInt+1}
{/foreach}
</tr></table></center><br>
<p align="center">{pagination url=$p_url act_page=$p_act per_page=$p_epp count=$p_cou var="page"}</p>
<p align="right">{$size}MB</p>