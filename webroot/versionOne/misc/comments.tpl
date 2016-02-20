<script type="text/javascript">var commentSuccessLayout="<div style=\"background: #FFFDBF; min-height: 20px; width: 70%;padding: 5px; margin-bottom: 10px;\"><b>{lng k='commentSuccess'}</b></div>";</script>

<div id="comments{$cat_id}{$cat_item}">
{if $comments != false}
{foreach item=comrow from=$comments}
<div class="commentBox">
	<img class="avatar" src="thumb.php?url={avatar k=$comrow.by}&amp;x=40&amp;y=40" style="float: left; margin-right: 15px;" />
	{uName id=$comrow.by} {$comrow.text}
	<div style="color: #777777; font-size: 10px;">{$comrow.time|date_format:"%d.%m.%y - %H:%I"}</div>
</div>
{/foreach}
{else}
<div class="commentBox">{lng k='noComments'}</div>
{/if}
</div>
<div class="commentPostBox">
	<img class="avatar" src="thumb.php?url={avatar}&amp;x=40&amp;y=40" style="float: left; margin-right: 15px;" />
	<textarea id="commentText{$cat_id}{$cat_item}" style="padding: 3px; float: left; height: 45; width: 69%;"></textarea>
	<input type="button" class="clogCommentPostButton" onclick="commentPost('{$cat_id}',{$cat_item},{$report})" value="{lng k='submit'}" />
</div>