{assign var='start' value=$profs|@count}
<script type="text/javascript">
var uid= {$smarty.get.uid};
var vshow = "{$smarty.get.show}";

var delID = 0;

var incInt = {$start};
{literal}
function show(id) {
	if(id == 'info') {
		ebi("infos").style.display="inline";
		ebi("profs").style.display="none";
		ebi("favs").style.display="none";
	}
	if(id == 'profs') {
		ebi("infos").style.display="none";
		ebi("profs").style.display="inline";
		ebi("favs").style.display="none";
	}
	if(id == 'favs') {
		ebi("infos").style.display="none";
		ebi("profs").style.display="none";
		ebi("favs").style.display="inline";
	}
}

function ddel(id, stat) {
	if(stat == '0') {
		ebi("del"+id).style.display="none";
		ebi("ln"+id).style.background="#EEEEEE";
	} else {
		ebi("del"+id).style.display="inline";
		ebi("ln"+id).style.background="#DDDDDD";
	}
}

function dispPrompt(id) {
$("#bdel").show("slow");
delID= id;
}

function csw(i, s) {
	if(s=='1')
	ebi("tab"+i).style.background="#6782BB";
	else
	ebi("tab"+i).style.background="#5772AB";
}

function goDel() {
location.href="./profile.php?uid="+uid+"&show=profs&delete="+delID;
}

function pPost() {
	var inputObj = ebi("post");
	if(inputObj.value != "") {
		var text = inputObj.value;
		$.post("./ajax.response.php?section=profile", {text: text, user: uid});
		inputObj.value = "";
	} else {
		return false;
	}
	var box = ebi("charac");
	incInt++;
	box.innerHTML = "<table cellpadding=2 cellspacing=0 border=0 style='width: 100%'><tr><td style='width: 10%; font-weight: bold;'>"+incInt+".</td><td>"+text+"</td></tr></table>"+box.innerHTML;
}
{/literal}</script>

{if $deleted == true}
<div class="box_info">
	<h2><img src="{$_tpl}misc/delete.png" onclick="ebi('bdel').style.display='none';" /> {lng k='delProfTitle' d='profile'}</h2>
	{lng k='deletedProfTxt' d='profile'}
</div>
{/if}

<div class="box_infoWrapper" id="bdel">
	<h1><img src="{$_tpl}misc/delete.png" onclick="ebi('bdel').style.display='none';" /> {lng k='delProfTitle' d='profile'}</h1>
	<div class="box_n">
	{lng k='delProfTxt' d='profile'}<br/><br/>
	<input type="button" onclick="goDel()" value="{lng k='delete'}"/>
	<input type="button" onclick="ebi('bdel').style.display='none';" value="{lng k='cancel'}" />
	</div>
</div>


<table cellpadding=0 cellspacing=0 border=0 style="width: 100%; margin:5px;margin-bottom: 10px;"><tr>
<td class="pline"><div id="tab1" class="ptab" onmouseover="csw(1,1)" onmouseout="csw(1,0)"><a href="#" style="text-decoration: none;color: #FFFFFF;" onclick="show('info')">{lng k='tabInformations' d='profile'}</a></div></td>
<td class="pline"><div id="tab2" class="ptab" onmouseover="csw(2,1)" onmouseout="csw(2,0)"><a href="#" style="text-decoration: none;color: #FFFFFF;" onclick="show('profs')">{lng k='tabProfile' d='profile'}</a></div></td>
<td class="pline"><div id="tab3" class="ptab" onmouseover="csw(3,1)" onmouseout="csw(3,0)"><a href="#" style="text-decoration: none;color: #FFFFFF;" onclick="show('favs')">{lng k='tabFavorites' d='profile'}</a></div></td>
<td class="pline" style="width: 50%;"></td>
</tr></table>


<div style="float:left;margin-left: 5px;margin-right: 5px; position: static; border: 1px #555555 solid;">
<a href="thumb.php?url={avatar k=$user.ID}&amp;x=500&amp;y=500" class="lightbox">
<img src="thumb.php?url={avatar k=$user.ID}&x=130&y=200" border="0"/></a></div>

<div  id="infos">
<div class="box_n" style="width: 535px;margin-left: 195px;">
<h2><img src="{$_tpl}misc/infos.png" alt="" border=0 /> {lng k='information' d='profile'}</h2>
<table cellpadding=2 cellspacing=1 border=0 style="width: 100%;">
<tr><td class="ltbl">{lng k='name' d='profile'}:</td><td>{$user.name}</td></tr>
<tr><td class="ltbl">{lng k='nick' d='profile'}:</td><td>{$user.displayName}</td></tr>
<tr><td class="ltbl">{lng k='bday' d='profile'}:</td><td>{bday date=$user.bday}</td></tr>
<tr><td class="ltbl">{lng k='posts' d='profile'}:</td><td>{$posts}</td></tr>
<tr><td class="ltbl">{lng k='lastupdate' d='profile'}:</td><td>{lng d='userEdit' k=$user.lastEditCat} ({$user.lastEdit|date_format:"%d.%m.%y - %H:%I"})</td></tr>
<tr><td class="ltbl">{lng k='status' d='profile'}</td><td>{$user.status}</td></tr>
</table>
</div>

<div class="box_n" style="width: 535px;margin-left: 195px;">
<h2><img src="{$_tpl}misc/contact.png" alt="" border=0 /> {lng k='contact' d='profile'}</h2>
<table cellpadding=2 cellspacing=1 border=0 style="width: 100%;">
<tr><td class="ltbl">{lng k='icq' d='profile'}:</td><td>{$user.icq}</td></tr>
<tr><td class="ltbl">{lng k='mail' d='profile'}:</td><td><a href="mailto:{$user.email}">{$user.email}</a></td></tr>
<tr><td class="ltbl">{lng k='skype' d='profile'}:</td><td>{$user.skype}</td></tr>
<tr><td class="ltbl">{lng k='msn' d='profile'}:</td><td>{$user.msn}</td></tr>
<tr><td class="ltbl">{lng k='mobile' d='profile'}:</td><td>{$user.mobile}</td></tr>
</table>
</div>
</div>

<div id="profs" style="display:none;">
{if $_uid != $smarty.get.uid}
<div class="box_n" style="width: 535px;margin-left: 195px;">
<h2><img src="{$_tpl}misc/postProf.png" alt="" border=0 /> {lng k='creProf' d='profile'}</h2>
<div style="margin: 20px;">
<input type="text" id="post" style="width: 300px;" /> <input type="button" onclick="pPost()" value="{lng k='submit'}" />
</div>
</div>
{/if}

<div class="box_n" id="charac" style="width: 535px;margin-left: 195px;">
{if $_uid == $smarty.get.uid}
<h2><img src="{$_tpl}misc/postProf.png" alt="" border=0 /> {lng k='profs' d='profile'}</h2>
{/if}
<table cellpadding={if $_uid == $smarty.get.uid}"2"{else}"0"{/if} cellspacing=0 border=0 style="width: 100%">
{counter start=$start+1 skip=-1 print=false}
{foreach from=$profs item=res}
{if $res.text != ''}
{if $_uid == $smarty.get.uid}
<tr><td style="width: 10%;font-weight: bold;">{counter}.</td><td>{$res.text}</td></tr>
{else}
<tr><td style="width: 10%;font-weight: bold;">{counter}.</td><td>
<div id="ln{$res.ID}" style="padding:4px;" onmouseover="ddel({$res.ID},1)" onmouseout="ddel({$res.ID},0)">
<div style="display:none;float:right;" id="del{$res.ID}">
<a href="#" onclick="dispPrompt({$res.ID})"><img src="{$_tpl}misc/del.gif" alt="" border=0 /></a></div>{$res.text}</div></td></tr>
{/if}
{else}
<tr><td colspan="2">{lng k='noItems'}</td></tr>
{/if}
{/foreach}
</table>
</div>
</div>

<div  id="favs" style="display:none;">
<div class="box_n" style="width: 535px;margin-left: 195px;">
<h2><img src="{$_tpl}misc/favorites.png" alt="" border=0 /> {lng k='favorites' d='profile'}</h2>
<table cellpadding=2 cellspacing=1 border=0>
<tr><td class="ltbl">{lng k='movie' d='profile'}:</td><td>{$user.favMovie}</td></tr>
<tr><td class="ltbl">{lng k='music' d='profile'}:</td><td>{$user.favMusic}</td></tr>
<tr><td class="ltbl">{lng k='car' d='profile'}:</td><td>{$user.favCar}</td></tr>
<tr><td class="ltbl">{lng k='place' d='profile'}:</td><td>{$user.favPlace}</td></tr>
<tr><td class="ltbl">{lng k='food' d='profile'}:</td><td>{$user.favFood}</td></tr>
<tr><td class="ltbl">{lng k='sports' d='profile'}:</td><td>{$user.favSports}</td></tr>
<tr><td class="ltbl">{lng k='sportsclub' d='profile'}:</td><td>{$user.favSportsclub}</td></tr>
<tr><td class="ltbl">{lng k='hp1' d='profile'}:</td><td><a href="{http url=$user.favHp1}" target="_blank">{$user.favHp1}</a></td></tr>
<tr><td class="ltbl">{lng k='hp2' d='profile'}:</td><td><a href="{http url=$user.favHp2}" target="_blank">{$user.favHp2}</a></td></tr>
<tr><td class="ltbl">{lng k='hp3' d='profile'}:</td><td><a href="{http url=$user.favHp3}" target="_blank">{$user.favHp3}</a></td></tr>
</table>
</div>
</div>


<script type="text/javascript">show(vshow);</script>