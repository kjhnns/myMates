<h1><img src="{$_tpl}misc/gallery.png" border="0" alt="" /> {lng k='gedittitle' d='gal'}</h1>
<div class="box" style="width: 400px;margin-left: 170px;">
<form action="gallery.php?action=edit&amp;gid={$smarty.get.gid}&amp;do=gal" method="post">
<table cellpadding=0 cellspacing=2 border=0>
<tr>
<td style="width: 150px; vertical-align:top;"><label for="title">{lng k='title'}:</label></td>
<td><input style="width: 200px;" type="text" id="title" value="{$gal.title}" name="title" /></td>
</tr>
<tr>
<td style="width: 150px; vertical-align:top;"><label for="desc">{lng k='desc'}:</label></td>
<td><textarea style="width: 200px;" id="desc" name="desc">{$gal.desc}</textarea></td>
</tr>
<tr>
<td></td>
<td><input type="submit" value="{lng k='edit'}" /></td>
</tr>
</table>
</form>
</div>
<form action="gallery.php?action=edit&amp;gid={$smarty.get.gid}&amp;do=cover" method="post">
<h1><img src="{$_tpl}misc/photo.png" border="0" alt="" /> {lng k='coveredit' d='gal'}</h1>
<div class="box" style="width: 400px;margin-left: 170px; min-height: 20px;">
{lng k='editcov' d='gal'}<br/><br/>
<input type="submit" value="{lng k='select'}" />
</div>
{foreach from=$pics item=pic key=id}
<div class="albumpicedit">
<img src="./thumb.php?url=./gallery/{$gid}/{$pic.title}&x=65&y=55" border=0 alt=""/><br/>
{if $gal.cover==$id}
<input type="radio" name="cover" value="{$id}" checked="checked" />
{else}
<input type="radio" name="cover" value="{$id}" />
{/if}
</div>
{/foreach}
</form>