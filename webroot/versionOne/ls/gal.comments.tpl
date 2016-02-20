{literal}
<script type="text/javascript">
function show(box,show) {
	if(box == '1') {
		box = ebi("npic");
	} else {
		box = ebi("ppic");
	}
	if(show == '1') {
		box.style.display = "inline";
	} else {
		box.style.display = "none";
	}
}

function wrapper() {
	ebi("crypt").style.display ="inline";
}
</script>
{/literal}
<h1><img src="{$_tpl}misc/gallery.png" border="0" alt="" /> <a href="./gallery.php?action=view&amp;gid={$smarty.get.gid}" style="text-decoration:none; color: #FFFFFF;">{$gal.title}</a></h1>
<div style="padding-left: 25px;">
	<div style="min-height:400px; width: 700px; text-align:center;">
		<img src="./thumb.php?url={$pic.title}&amp;x=700&amp;y=400" />
	</div>
	<div id="boxl" onclick="location.href='gallery.php?action=comments&id={$ppic.ID}&gid={$smarty.get.gid}'" onmouseover="show(2,1)" onmouseout="show(2,0)">
		<img id="ppic" src="{$_tpl}misc/lightbox/prev.gif" style="margin-top: 40px; display:none;" border="0" />
	</div>
	<div id="boxr" onclick="location.href='gallery.php?action=comments&id={$npic.ID}&gid={$smarty.get.gid}'" onmouseover="show(1,1)" onmouseout="show(1,0)">
		<img id="npic" src="{$_tpl}misc/lightbox/next.gif" style="margin-top: 40px; display:none;" border="0" />
	</div>
</div>
<div class="box_infoWrapper" id="crypt">
	<h1><img src="{$_tpl}misc/delete.png" onclick="ebi('crypt').style.display='none';" /> {lng k='cryptLink' d='gal'}</h1>
	<div class="box_n">
	{lng k='cryptLinkTxt' d='gal'}<br/>
	<input type="text" value="{$cryptLink}" style="width: 90%; margin: 2%;" readonly="readonly"/>
	</div>
</div>
<br/><br/>
<h1><img src="{$_tpl}misc/clog/clogcomm.png" border="0" alt="" /> {lng k='comment'}</h1>
<div style="padding-left: 20px; padding-top: 5px;">
{comments cat="picture" item=$pic.ID}
</div>