{if $res==false}
<div class="box_info">
<form action="./board.php?action=threads&amp;do=del&amp;tid={$smarty.get.tid}" method="post">
<h2><img src="{$_tpl}misc/delete.png" border=0 alt="" /> {lng k='rlyDelThreadTitle' d='board'}</h2>
{lng k='rlyDelThreadText' d='board'}
<br/><br/><br/>
<center><input type="submit" value="{lng k='delete'}" /></center>
</form>
</div>
{else}
<div class="box_info">
<h2><img src="{$_tpl}misc/success.png" border=0 alt="" /> {lng k='DelThreadTitle' d='board'}</h2>
{lng k='DelThreadText' d='board'}
</div>
{/if}