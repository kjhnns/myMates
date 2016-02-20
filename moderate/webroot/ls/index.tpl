<table cellpadding=0 cellspacing=0 border=0>
<tr>
	<td style="width: 50%">
	<h1><img src="{$_tpl}misc/database.png" /> {lng k='database'}</h1>
		<div class="box">
			<table cellpadding=0 cellspacing=0 border=0>
			<tr><td style="width: 30%;">{lng k='size'}:</td><td>{$size}<td></tr>
			<tr><td>{lng k='rows'}:</td><td>{$rows}<td></tr></table>
		</div>
	</td>
	<td style="width: 50%">
	<h1><img src="{$_tpl}misc/tempdata.png" /> {lng k='tempData'}</h1>
		<div class="box">
			<table cellpadding=0 cellspacing=0 border=0>
			<tr><td style="width: 50%;">{lng k='thumbs'}:</td><td>{$thumbs}<td></tr>
			<tr><td>{lng k='cache'}:</td><td>{$cache}<td></tr>
			<tr><td>{lng k='total'}:</td><td>{$tmp}<td></tr></table>
			<br/>
			<a href="?action=ccache">{lng k='cleancache'}</a><br>
		</div>
	</td>
</tr>
<tr>
	<td>
	<h1><img src="{$_tpl}misc/galleries.png" /> {lng k='gallery'}</h1>
		<div class="box">
		<table cellpadding=0 cellspacing=0 border=0>
			<tr><td style="width: 30%;">{lng k='galleries'}:</td><td>{$galleries}<td></tr>
			<tr><td>{lng k='pictures'}:</td><td>{$pics}<td></tr>
			<tr><td>{lng k='size'}:</td><td>{$gsize}<td></tr></table>
		</div>
	</td>
</tr>
</table>