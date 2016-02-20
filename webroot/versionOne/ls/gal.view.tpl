<h1><img src="{$_tpl}misc/gallery.png" border=0 alt="" /> {$gal.title}</h1>
<div class="box_n" style="width: 80%; min-height: 50px;margin-left: 10%">
<div style="float:right">{lng k='size'}: {$size}MB<br>
<a href="./gallery.php?action=slide&id=0&gid={$gid}">{lng k='slide'}</a></div>
{$gal.desc}</div>
<div style="text-align:center;width: 100%;">{pagination url=$p_url act_page=$p_act per_page=$p_epp count=$p_cou var="page"}</div>
<div style="margin-left: 4%;">
{foreach from=$res item=pic}
{if $pic.comment == 'true'}
<div class="albumpiccomment">
{else}
<div class="albumpic">
{/if}
<a href="./gallery.php?action=comments&id={$pic.ID}&gid={$gid}">
<img src="./thumb.php?url=./gallery/{$gid}/{$pic.title}&x=130&y=110" border=0 alt=""/>
</a>
</div>
{/foreach}
</div>