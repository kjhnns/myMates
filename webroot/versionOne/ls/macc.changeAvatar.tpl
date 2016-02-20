<form action="myAccount.php?action=changeAvatar&amp;upload" method="post" enctype="multipart/form-data">
<h1><img src="{$_tpl}misc/changeAvatar.png" alt="" /> {lng k='catitle' d='macc'}</h1>
{if $result != ""}
<div class="box_error">{$result}</div>
{/if}
<div class="box" style="height: 150px;">
<div style="text-align: right;float: right;"><img src="thumb.php?url={$_avatar}&amp;y=150&amp;x=100" class="avatar" border=0 alt="" /></div>
{lng k='cadesc' d='macc'}<br/><br/><br/>
<input name="pic" type="file" accept="image/*" /><br/>
<input type="submit" value="{lng k='submit'}" />
</div></form>