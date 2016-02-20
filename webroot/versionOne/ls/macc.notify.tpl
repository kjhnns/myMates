<h1><img src="{$_tpl}misc/notification.png" alt="" /> {lng k="notification" d="macc"}</h1>
<form action="myAccount.php?action=notification&amp;edit=true" method="post">
<div class="box_n">
	<div class="box_info" id="InfoBox" style="min-height: 5px;">
	<img src="{$_tpl}misc/delete.png" id="cl"  />
	{lng k='notifyInfo' d='macc'}
	</div>

<table cellpadding=2 cellspacing=0 border=0 style="width: 80%;margin-left: 10%;">
<tr><th colspan="2">Bereiche</th></tr>
{foreach from=$nofs item=v key=k}
<tr>
	<td style="width: 20%;"><input type="checkbox" name="not[{$k}]" {if $v == true}checked="checked"{/if} /></td>
	<td>{lng k=$k d='macc'}</td>
</tr>
{/foreach}
<tr><td colspan="2" style="text-align: center;"><br/><br/><input type="submit" value="{lng k='submit'}" />
<input type="reset" value="{lng k='reset'}" /></td></tr>
</table><br/>
</div>
</form>
<script>
{literal}
$("#cl").click(function() {
$("#InfoBox").hide("slow");
});
{/literal}
</script>