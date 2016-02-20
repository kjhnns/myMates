<script type="text/javascript">
var delID = 0;
{literal}
function bdel(id) {
	$("#bdel").show("slow");
	delID = id;
}

function goDel() {
location.href="./quotes.php?action=delete&id="+delID;
}
</script>
{/literal}

<h1><img src="{$_tpl}misc/quote.gif" border="0" alt="" /> {lng k="quotes" d="misc"}</h1>

<div class="box_infoWrapper" id="bdel">
	<h1><img src="{$_tpl}misc/delete.png" onclick="ebi('bdel').style.display='none';" /> {lng k='delqTitle' d='misc'}</h1>
	<div class="box_n">
	{lng k='delqText' d='misc'}<br/><br/>
	<input type="button" onclick="goDel()" value="{lng k='delete'}"/>
	<input type="button" onclick="ebi('bdel').style.display='none';" value="{lng k='cancel'}" />
	</div>
</div>

{foreach from=$quotes item=row}
<table cellpadding=0 cellspacing=0 border=0 style="width:98%;margin-bottom: 15px;margin-left: 1%;">
<tr><td class="btitle" style="height: 5px; padding:0px;"></td></tr>
<tr><td class="box_n" style="overflow: visible;height: 30px;">
	<div style="width: 5%;text-align:center;float:left;padding-top: 5px;"><img src="{$_tpl}misc/quote.png" alt="\"" /></div>
	<div style="width: 90%;float:left;">
		<span style="font-size: 15px;">{$row.quote}</span>
		<div style="color: #888888; font-size: 10px;">
		{if $row.by==$_uid}
		<a href="#" title="{lng k="delete"}" onclick="bdel({$row.ID})"><img style="margin-bottom: -4px;" src="{$_tpl}misc/del.gif" border="0"/></a> -
		{/if}
		{lng k='who'}: {$row.who} - {lng k='where'}: {$row.where} - {$row.added|date_format:"%d.%m.%y"}
		</div>
	</div>
	<div style="width: 5%;text-align:center;float:left;padding-top: 5px;"><img src="{$_tpl}misc/quote.png" alt="\"" /></div>
</td>
</tr></table>
{/foreach}

<br/>
<p align="center">{pagination url=$p_url act_page=$p_act per_page=$p_epp count=$p_cou var="page"}</p>