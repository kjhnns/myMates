<script>changelogRefreshStatus();
var id = 0;

{literal}
function ddel(pid) {
id = pid;
$("#bdel").show("slow");
}

function goDel() {
location.href="./ajax.response.php?section=clog&action=delete&id="+id;
}
{/literal}
</script>
<div class="box_infoWrapper" id="bdel">
	<h1><img src="{$_tpl}misc/delete.png" onclick="ebi('bdel').style.display='none';" /> {lng k='rdelete'}</h1>
	<div class="box_n">
	{lng k="rrdelete"}<br/><br/>
	<input type="button" onclick="goDel()" value="{lng k='delete'}"/>
	<input type="button" onclick="ebi('bdel').style.display='none';" value="{lng k='cancel'}" />
	</div>
</div>
{if $delresult=='1'}
<div id="box_warning"><h1>{lng k="error"}</h1>{lng k="ecantdelete"}</div>
{elseif $delresult=='2'}
<div class="box_info" id="info"><h2><img src="{$_tpl}misc/success.png" alt="" border="0" /> {lng k='success'}</h2>{lng k='sdelete'}</div>
{/if}
<h1><img src="{$_tpl}misc/index.png" alt="" border="0" /> {lng k="wellcome"} {uInfo f='name'}</h1>
<div align="center" style="margin-left: 5%;min-height: 130px;">
	<a class="lightbox" href="thumb.php?url={avatar}&amp;y=400&amp;x=400">
	<img class="avatar" src="thumb.php?url={avatar}&amp;y=80&amp;x=100" style="float: left; margin: 20px; margin-left: 5px;" /></a>
	<div class="box" style="width: 70%; min-height: 80px; float:left; margin: 7px;">
		<div id="tabClog"><label id="tabClogSelected" for="clogPost"><b>{lng k='postStatus'}</b></label> | <a href="javascript:switchclogPost('cloglink')">{lng k='postLink'}</a></div>
		<input type="text" id="clogPost" onkeyup="statusTyping()" onFocus="if(value=='{lng k='clogPostText'}' || value=='http://') {literal}{value=''}{/literal}statusTyping();" value="{lng k='clogPostText'}" />
		<input type="button" id="clogPostButton" onclick="clogPost();statusTyping();" value="{lng k='post'}" />
		<div style=" color: #666666; font-size: 10px;"><div id="clogPostLengthDiv" style="float:left;">140</div>&nbsp;{lng k='charsremaining'}</div>
	</div>
</div><br/>
<h1><img src="{$_tpl}misc/clog.png" border=0 alt=""/> {lng k='changelog'}</h1>
<center>
<div id="changeLogBox">{lng k='loading'}<blink>...</blink></div>
</center>
<script>setTimeout('$("#info").hide("slow")',3000);</script>