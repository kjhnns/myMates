<h1><img src="{$_tpl}misc/quote.gif" border="0" alt="" /> {lng k="qrand" d="misc"}</h1>

{foreach from=$quotes item=row}
<table cellpadding=0 cellspacing=0 border=0 style="width:98%;margin-bottom: 15px;margin-left: 1%;">
<tr><td class="btitle" style="height: 5px; padding:0px;"></td></tr>
<tr><td class="box_n" style="overflow: visible;height: 30px;">
	<div style="width: 5%;text-align:center;float:left;padding-top: 5px;"><img src="{$_tpl}misc/quote.png" alt="\"" /></div>
	<div style="width: 90%;float:left;">
		<span style="font-size: 15px;">{$row.quote}</span>
		<div style="color: #888888; font-size: 10px;">
		{lng k='who'}: {$row.who} - {lng k='where'}: {$row.where} - {$row.added|date_format:"%d.%m.%y"}
		</div>
	</div>
	<div style="width: 5%;text-align:center;float:left;padding-top: 5px;"><img src="{$_tpl}misc/quote.png" alt="\"" /></div>
</td>
</tr></table>
{/foreach}