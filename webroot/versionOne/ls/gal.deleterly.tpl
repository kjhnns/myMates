<div class="box_info">
<h2><img src="{$_tpl}misc/delete.png" alt="" border="0" /> {lng k="rdelete"}</h2>
{lng k="rdelete" d="gal"}<br/><br/><center>
<input type="button" onclick="location.href='./gallery.php'" value="{lng k='cancel'}" />
<input type="button" onclick="location.href='./gallery.php?action=delete&gid={$smarty.get.gid}&amp;do=true'" value="{lng k='delete'}" /></center>
</div>
