<h1><img src="{$_tpl}misc/pmdelete.png" alt="" border=0 /> {lng k="deletepm" d="pm"}</h1>
{if $do == false}
<div class="box">
{lng k="deleterealy" d="pm"}
<br/><br/><br/><center>
<input type="button" value="{lng k='delete'}" onclick="location.href='pm.php?action=delete&amp;id={$id}&amp;delete=go'" />
<input type="button" value="{lng k='cancel'}" onclick="location.href='pm.php'" />
</center></div>
{else}
<div class="box">
{lng k="deletesuccess" d="pm"}<br/><br/>
<a href="pm.php">{lng k="back"}</a>
</div>
{/if}