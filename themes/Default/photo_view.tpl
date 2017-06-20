<h1 style="margin-bottom:5px!important;">{$photo->title|default:'Χωρίς τίτλο'} | <q>{$photo->caption|default:'Χωρίς περιγραφή'}</q></h1>

<div class="content">
	{foreach from=$tags item=tag}
		<a class="tag" href="search.php?terms={$tag.name}">{$tag.name}</a>
	{foreachelse}
		<h3>Η φωτογραφία δεν έχει ετικέτες.</h3>
	{/foreach}

	<div id="imgViewBox">
		<a href='view.php?id={$photo->id}' target="_blank" title='Πλήρες μέγεθος'><img src="view.php?id={$photo->id}" alt="{$photo->title}" /></a>
	</div>
	<div class="viewsCount">{$photo->views|number_format}<img src="{#images_path#}/icons/views.png" alt="Προβολές" /></div>
</div>