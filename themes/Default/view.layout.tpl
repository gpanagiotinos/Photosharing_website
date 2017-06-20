<!DOCTYPE html>

{include file="includes/header.tpl"}
{include file="includes/navigation.tpl"}
<div id="wrapper" class="fullHeight">
	{include file="includes/message.tpl"}
	<div id="container" class="fleft">
		{$_content}
	</div>
	
	<div id="aside" class="fleft leftBordered">
	<span class="details">
		Φωτογραφίες του  <em>{$photo->username}</em>
		<br/>
		<i>{$photo->upload_date|date_format:"%d/%m/%Y"} {if !empty($photo->address)}&mdash; {$photo->address}{/if}</i>
	</span>

	{foreach from=$comments item=comment}
		<div id="comment-text">

			<q>{$comment->username}</q>
			<p>
				{$comment->comment}<br/>
			</p>

			<i>{$comment->date|date_format:"%I:%M %p %d/%m/%Y"}
			{if isset($member)}
				{if $member->username == $comment->username || $member->username == $photo->username}
			 &bull; <a href="photo.php?delete={$comment->id}&pid={$photo->id}">Διαγραφή</a>
			 	{/if}
			{/if}
			</i>
			
		</div>
	{foreachelse}
		<h3>Δεν υπάρχουν σχόλια</h3>
	{/foreach}
	{if isset($member)}
	<!-- Comment area -->
	<div id="comment-form">
		<form action="{$SCRIPT_NAME}?pid={$photo->id}" method="POST" id="commentForm">
			<table class="full">
				<tr>
					<td>
						<textarea validation="required" name="comment" class="inputGrey" placeholder="Αφήστε το σχόλιό σας..." style="height:50px;"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" value="Σχολίασε" class="button Mpez fright" />
						<input type="hidden" name="newCommentSubmit" value="true"/>
					</td>
				</tr>
			</table>
		</form>
		<!-- validate -->
		<script type="text/javascript" charset="utf-8">
			//molis forto8ei to DOM bind validation sto login form
			$(function(){
				$('#commentForm').validation();
			});		
		</script>
	</div>
	{/if}
</div>
</div>
{include file="includes/footer.tpl"}