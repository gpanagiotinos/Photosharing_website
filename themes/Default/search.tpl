<h1>Αναζήτηση</h1>

<div class="content">

	{foreach from=$results item=photo}
		<div class="imgGrid fleft">
			<a href="photo.php?pid={$photo->id}" alt="{$photo->title|default:'Χωρίς τίτλο'}"><img src="thumbs.php?id={$photo->id}" alt="{$photo->title}"/></a>
			<div class="topLeft toolbar toolbarMpez">{$photo->views|number_format}&nbsp;<img src="{#images_path#}icons/views.png" alt="Προβολές" />
				<br/>
			<i>{$photo->username}</i>
			</div>
			<div class="bottomRight toolbar toolbarBlue">
				{$photo->title}
			</div>
		</div>
	{foreachelse}

	<h3>Δεν υπάρχουν αποτελέσματα</h3>

	{/foreach}
	<div class="clear"></div>
	<div id="pagination">
		{if isset($prevPageQuery)}
			<a href="search.php?{$prevPageQuery}" class="tooltip" rel="Προηγούμενη"/>&laquo;</a>
		{/if}
		{if isset($list)}
			{$list}
		{/if}
		{if isset($nextPageQuery)}
			<a href="search.php?{$nextPageQuery}" class="tooltip" rel="Επόμενη"/>&raquo;</a>
		{/if}
	</div>
</div>