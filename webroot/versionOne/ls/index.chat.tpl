<script type="text/javascript">
{literal}
function row(id, stat) {
	if(stat == '0') {
		ebi("ln"+id).style.background="#EEEEEE";
	} else {
		ebi("ln"+id).style.background="#DDDDDD";
	}
}
{/literal}
</script>
<h1><img src="{$_tpl}misc/chat.png" alt="" border=0 /> {lng k='chatArchive'}</h1>
<div class="box_n">
<center>
<table cellpadding=3 cellspacing=0 border=0 style="width: 80%;">
<tr>
<th style="width: 30%;">{lng k='user'}</th>
<th style="width: 70%;">{lng k='wrote'}</th>
</tr>
{foreach from=$res item=row}
<tr>
<td onmouseover="row({$row.ID},1)" onmouseout="row({$row.ID},0)">{uName id=$row.user}</td>
<td id="ln{$row.ID}" onmouseover="row({$row.ID},1)" onmouseout="row({$row.ID},0)">{$row.text|wordwrap:50:" ":true}</td>
</tr>
{/foreach}
</table>
</center>
</div>
<br/>
<p align="center">{pagination url=$p_url act_page=$p_act per_page=$p_epp count=$p_cou var="page"}</p>