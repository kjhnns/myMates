<script type="text/javascript">
var imgs = new Array();
var crypts = new Array();
var i = 0;
var inc = {$smarty.get.id};

{foreach from=$pics item=pic}
imgs[i] = new Image();
imgs[i].src = "./thumb.php?url={$pic.title}&x=700&y=700";
crypts[i] = "{$pic.crypt}";
i++;
{/foreach}
{literal}
function next() {
	inc++;
	if(inc >= i) inc = 0;
	ebi("container").src = imgs[inc].src;
}

function prev() {
	inc--;
	if(inc < 0) inc = i-1;
	ebi("container").src = imgs[inc].src;
}

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
	ebi("crypttxt").value = crypts[inc];
	ebi("crypt").style.display ="inline";
}

function full() {
	location.href=imgs[inc].src;
}
</script>
{/literal}
<h1><img src="{$_tpl}misc/gallery.png" border="0" alt="" /> <a href="./gallery.php?action=view&amp;gid={$smarty.get.gid}" style="text-decoration:none; color: #FFFFFF;">{$gal.title}</a></h1>
<div style="padding-left: 25px;">
	<div style="min-height:700px; width: 700px; text-align:center;">
		<img src="" id="container" />
	</div>
	<div id="boxls" onclick="prev()" onmouseover="show(2,1)" onmouseout="show(2,0)">
		<img id="ppic" src="{$_tpl}misc/lightbox/prev.gif" style="margin-top: 40px; display:none;" border="0" />
	</div>
	<div id="boxrs" onclick="next()" onmouseover="show(1,1)" onmouseout="show(1,0)">
		<img id="npic" src="{$_tpl}misc/lightbox/next.gif" style="margin-top: 40px; display:none;" border="0" />
	</div>
</div>

<script type="text/javascript">
ebi("container").src = imgs[inc].src;
</script>

<div class="box_infoWrapper" id="crypt">
	<h1><img src="{$_tpl}misc/delete.png" onclick="ebi('crypt').style.display='none';" /> {lng k='cryptLink' d='gal'}</h1>
	<div class="box_n">
	{lng k='cryptLinkTxt' d='gal'}<br/>
	<input type="text" id="crypttxt" style="width: 90%; margin: 2%;" readonly="readonly"/>
	</div>
</div>
