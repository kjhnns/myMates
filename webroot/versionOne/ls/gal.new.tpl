{if $create == '1'}
<div class="box_info" style="min-height: 30px;"><h2>Erfolgreich erstellt</h2>
Sie konnten die Galerie erfolgreich erstellen.</div>
{/if}
<h1><img src="{$_tpl}misc/gallery.png" border="0" alt="" /> {lng k='newtitle' d='gal'}</h1>
<div class="box" style="width: 400px;margin-left: 170px;">
<form action="gallery.php?action=new&amp;do=create" method="post">
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
<td><input type="submit" value="{lng k='submit'}" /></td>
</tr>
</table>
</form>
</div>