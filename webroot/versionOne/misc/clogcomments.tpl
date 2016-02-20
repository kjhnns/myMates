{assign var="limit" value=$ccount-4}
{assign var="incIntComment" value=1}
<script type="text/javascript">var commentSuccessLayout="<div style=\"background: #FFFDBF; min-height: 20px; width: 70%;padding: 5px; margin-bottom: 10px;\"><b>{lng k='commentSuccess'}</b></div>";</script>

<div id="comments{$cat_id}{$cat_item}" style="margin-top: 15px;">
{if $comments != false}
{if $incIntComment <= $limit}
<div id="commentshidderbt{$cat_id}{$cat_item}" style="background: #EDEDED; width: 80%;padding: 5px; margin-bottom: 10px;
	border: 1px #CCCCCC solid;
	border-radius: 8px 8px 8px 8px;
	-moz-border-radius: 8px 8px 8px 8px;">
	<div style="cursor:pointer;" onclick="ebi('commentshidderbt{$cat_id}{$cat_item}').style.display='none'; ebi('commentshidder{$cat_id}{$cat_item}').style.display='inline'">
	{lng k='showcomments'}
	</div>
	</div>
<div style="display:none;" id="commentshidder{$cat_id}{$cat_item}">
{/if}
{foreach item=comrow from=$comments}
<div style="background: #EDEDED; min-height: 42px; width: 80%;padding: 5px; margin-bottom: 10px;
	border: 1px #CCCCCC solid;
	border-radius: 8px 8px 8px 8px;
	-moz-border-radius: 8px 8px 8px 8px;">
	<img class="roundPic" src="thumb.php?url={avatar k=$comrow.by}&amp;x=40&amp;y=40" style="float: left; margin-right: 15px;" />
	{uName id=$comrow.by} {$comrow.text}
	<div style="color: #777777; font-size: 10px;">{$comrow.time|date_format:"%d.%m.%y - %H:%I"}</div>
</div>
{if $incIntComment == $limit}
</div>
{/if}
{assign var="incIntComment" value=$incIntComment+1}
{/foreach}
{/if}
</div>
<a href="javascript:postcomment({$cat_item})"><img src="{$_tpl}misc/clog/clogcomm.png" border=0 /> {lng k='comment'}</a><br/>
<div id="gocomment{$cat_item}" style="display:none;">

<div style="background: #EDEDED; min-height: 65px;
	border: 1px #CCCCCC solid;
	border-radius: 8px 8px 8px 8px;
	-moz-border-radius: 8px 8px 8px 8px; width: 80%;padding: 5px; margin-bottom: 10px;">
	<img class="roundPic" src="thumb.php?url={avatar}&amp;x=40&amp;y=40" style="float: left; margin-right: 15px;" />
	<textarea id="commentText{$cat_id}{$cat_item}" style="float: left; height: 45; width: 60%;"></textarea>
	<input type="button" class="clogCommentPostButton" onclick="commentPost('{$cat_id}',{$cat_item},{$report}); ebi('gocomment{$cat_item}').style.display='none'" value="{lng k='submit'}" />
</div>

</div>