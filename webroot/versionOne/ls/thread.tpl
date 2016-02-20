<script type="text/javascript">
var delID = 0;
var tid={$smarty.get.tid};
var page={if $smarty.get.page == ''}0{else}{$smarty.get.page}{/if};
var changedStatus='{lng k='changedStatus' d='board'}';
{literal}
function bdel(id) {
	$("#bdel").show("slow");
	delID = id;
}

function pAttendStatus(status) {
	$.post("./ajax.response.php?section=attStatus", {stat: status, threadID: tid});
	ebi("changedStatus").innerHTML =changedStatus;
}

function showTxt(id) {
	ebi(id).style.display ="inline";
}

function hidTxt(id) {
	ebi(id).style.display ="none";
}

function goDel() {
location.href="./board.php?action=thread&delete="+delID+"&tid="+tid+"&page="+page;
}
</script>
{/literal}
<h1><img src="{$_tpl}misc/board.png" border="0" alt="" /> {lng k='board' d='board'}</h1>
{if $deleted=='1'}
<div class="box_info" id="bdeled">
<h2><img src="{$_tpl}misc/delete.png" onclick="ebi('bdeled').style.display='none';" /> {lng k='delTitle' d='board'}</h2>
{lng k='deledText' d='board'}
</div>
{/if}
<div class="box_infoWrapper" id="bdel">
	<h1><img src="{$_tpl}misc/delete.png" onclick="ebi('bdel').style.display='none';" /> {lng k='delTitle' d='board'}</h1>
	<div class="box_n">
	{lng k='delText' d='board'}<br/><br/>
	<input type="button" onclick="goDel()" value="{lng k='delete'}"/>
	<input type="button" onclick="ebi('bdel').style.display='none';" value="{lng k='cancel'}" />
	</div>
</div>

<div class="box_n" style="min-height: 30px;">
<h2>{$info.title}</h2><br/>
Beitraege: {$info.posts}<br/>
Author: {uName id=$info.user}
</div>

{if $info.attends != '0'}
<div class="box_n">
<h2>{lng k='attendancePoll' d='board'}</h2>
<div id="changedStatus">
<table cellpadding=0 cellspacing=2 border=0 style="width: 100%"><tr><td style="width: 50%;vertical-align: top;">
<center><table cellpadding=2 cellspacing=0 border=0 style="width: 82%;"><tr>
<th><div style="float:left;cursor: pointer;" onclick="pAttendStatus(1)" onmouseover="showTxt('a')" onmouseout="hidTxt('a')"><img src="{$_tpl}misc/attend1.png" border=0 alt="" /> {lng k='attYes' d='board'}</div>
<div id='a' style="padding-left: 5px;float:left;color: #888888;font-size: 10px; padding-top:5px; display:none;"> ({lng k='attYesDesc' d='board'})</div></th></tr>
{foreach from=$info.attends item=att}
{if $att.status =='1'}
<tr><td>{uName id=$att.user}</td></tr>
{/if}
{/foreach}
</table></center></td>
<td style="width: 50%;vertical-align: top;"><center>
<table cellpadding=2 cellspacing=0 border=0 style="width: 82%;"><tr>
<th><div style="float:left;cursor: pointer;" onclick="pAttendStatus(0)" onmouseover="showTxt('b')" onmouseout="hidTxt('b')"><img src="{$_tpl}misc/attend0.png" border=0 alt="" /> {lng k='attNo' d='board'}</div>
<div id='b' style="padding-left: 5px;float:left;color: #888888;font-size: 10px; padding-top:5px; display:none;"> ({lng k='attNoDesc' d='board'})</div></th></tr>
{foreach from=$info.attends item=att}
{if $att.status =='0'}
<tr><td>{uName id=$att.user}</td></tr>
{/if}
{/foreach}
</table></center></td></tr></table>
</div>
</div>
{/if}

<table cellpadding=0 cellspacing=0 border=0 style="width: 96%;margin: 2%;">
<tr><td class="btitle">{lng k='author' d='board'}</td>
<td class="btitle">{lng k='post' d='board'}</td></tr>
{counter start=$counter skip=1 print=false}
{foreach from=$res item=row name=posts}
<tr>
<td class="brow3">{if $smarty.foreach.posts.last}<a name="last">{/if}{uName id=$row.user}{if $smarty.foreach.posts.last}</a>{/if}</td>
<td class="brow3" style="font-size: 10px;padding-top:5px;">#{counter} {lng k='at'} {$row.stp|date_format:"%d.%m.%y - %H:%I"}</td>
</tr>
<tr><td style="background: url('{$_tpl}misc/dotted.png'); height: 1px;" colspan="2"></td></tr>
<tr>
<td class="brow" style="vertical-align: top;font-size: 10px;">
<div style="text-align: center;">
<a class="lightbox" href="./thumb.php?url={avatar k=$row.user}&amp;y=400&amp;x=400">
<img style="border-right: 1px #AAAAAA solid;border-bottom: 1px #AAAAAA solid;" src="./thumb.php?url={avatar k=$row.user}&amp;x=90&amp;y=90" border="0" alt="Avatar"/></a>
</div>
<br/><br/>
{if $row.user==$info.user}{lng k='threadauthor' d='board'}{/if}<br/>
<div style="margin-bottom: 2px;">Beitraege: {uposts id=$row.user}</div>
<a href="./board.php?action=post&do=post&tid={$smarty.get.tid}&quote={$row.ID}" title="zitieren"><img src="{$_tpl}misc/bquote.png" border=0 /></a>
<a href="./board.php?action=post&do=edit&pid={$row.ID}&tid={$smarty.get.tid}" title="bearbeiten"><img src="{$_tpl}misc/bedit.png" border=0 /></a>
<a href="#" onclick="bdel({$row.ID})" title="loeschen"><img src="{$_tpl}misc/bdel.png" border=0 /></a>
</td>
<td class="brow4">{$row.text|nl2br}{uSignature id=$row.user divide="<hr>"}</td>
</tr>
<tr><td class="btitle" style="height: 5px; padding:0px;" colspan="2"></td></tr>
{foreachelse}
<tr><td colspan="2">{lng k='noItems'}</td></tr>
{/foreach}
</table>
<script>setTimeout('$("#bdeled").fadeOut("slow")',2000);</script>
<p align="center">{pagination url=$p_url act_page=$p_act per_page=$p_epp count=$p_cou var="page"}</p>