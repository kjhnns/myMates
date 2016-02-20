<h1><img src="{$_tpl}misc/tpl.png" alt="" border=0 /> {lng k='selectTpl' d='macc'}</h1>
<div class="box_n"><center>
<table cellpadding="2" cellspacing="0" border="0" style="width: 80%">
<tr>
<th style="width: 20%">{lng k='preview'}</th>
<th style="width: 40%">{lng k='template'}</th>
<th style="width: 20%">{lng k='author'}</th>
<th style="width: 20%"></th>
</tr>
{foreach from=$tpls item=tpl}
<tr>
<td><a class="lightbox" href="{$_webroot}{$tpl.root}{$tpl.preview}"><img style="border: 1px #AAAAAA solid;" src="./thumb.php?url={$_webroot}{$tpl.root}{$tpl.preview}&amp;y=100&amp;x=100" /></a></td>
<td>{$tpl.title}</td>
<td>{$tpl.author}</td>
<td style="text-align:right">
{if $tpl.version == true}
<input type="button" value="{lng k='select'}" onclick="location.href='index.php?action=changeTemplate&tpl={$tpl.selectroot}'" />
{else}
<input type="button" value="{lng k='deprecated'}" disabled="disabled"/>
{/if}
</td>
</tr>
{/foreach}
</table></center>
</div>