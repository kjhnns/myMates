
<h1><img src="{$_tpl}misc/lang.png" alt="" border=0 /> {lng k='selectLang' d='macc'}</h1>
<div class="box_n"><center>
<table cellpadding="2" cellspacing="0" border="0" style="width: 80%">
<tr>
<th style="width: 50%">{lng k='lang'}</th>
<th style="width: 30%">{lng k='author'}</th>
<th style="width: 20%"></th>
</tr>
{foreach from=$langs item=lang}
<tr>
<td>{$lang.title}</td>
<td>{$lang.author}</td>
<td style="text-align:right">
{if $lang.version == true}
<input type="button" value="{lng k='select'}" onclick="location.href='index.php?action=changeLang&lang={$lang.file}'" />
{else}
<input type="button" value="{lng k='deprecated'}" disabled="disabled"/>
{/if}
</td>
</tr>
{/foreach}
</table></center>
</div>