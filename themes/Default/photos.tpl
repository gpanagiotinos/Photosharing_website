<h1>Οι φωτογραφίες μου</h1>
<div class="content">
{include file="includes/message.tpl"}
<a href="photos.php?action=upload" class="button Mpez fright" title="Μεταφόρτωση φωτογραφίας"><img src="{#images_path#}icons/plus.png" />Μεταφόρτωση νέας φωτογραφίας</a>
<div class="gallery-seperator">&nbsp;</div>
{foreach from=$photos item=photo}
	<!-- <div class="fleft"> -->
		<div class="imgGrid fleft">
			<a href="photo.php?pid={$photo->id}" alt="{$photo->title|default:'Χωρίς τίτλο'}" class='imageArcher' id="{$photo->id}"><img src="thumbs.php?id={$photo->id}" alt="{$photo->title}"/></a>
			<div class="bottomRight toolbar toolbarMpez">
				<a href='photos.php?action=edit&pid={$photo->id}'  class="tooltip" rel="Επεξεργασία"><img src="{#images_path#}icons/edit.png" alt=""></a>&nbsp;&nbsp;
				<a href='photos.php?action=delete&pid={$photo->id}'class="tooltip" rel="Διαγραφή" onclick='return confirm("Είστε σίγουρος για την διαγραφή της φωτογραφίας {$photo->title|default:'Χωρίς τίτλο'}");'><img src="{#images_path#}icons/delete.png" alt=""></a>
			</div>
		</div>
		
{foreachelse}

<h3>Δεν υπάρχουν φωτογραφίες</h3>

{/foreach}
<div class="clear"></div>
<div id="pagination">
	<ul>
	{if isset($prevPageQuery)}
	<li>
		<a href="photos.php?{$prevPageQuery}" class="tooltip" rel="Προηγούμενη"/>&laquo;</a>
	</li>
	{/if}
	{if isset($list)}
		{$list}
	{/if}
	{if isset($nextPageQuery)}
	<li>
		<a href="photos.php?{$nextPageQuery}" class="tooltip" rel="Επόμενη"/>&raquo;</a>
	</li>
	{/if}
	</ul>
</div>
</div>