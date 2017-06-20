

<h1>Χάρτης Photo Sharing</h1>
<div id="content">
{include file="includes/message.tpl"}

	<div id="map_canvas">Χάρτης</div>
	<script type="text/javascript">
	initHomeMap();
	</script>
</div>
<div class="clear"></div>
<h1>Δημοφιλής Φωτογραφίες</h1>
{foreach from=$popular item=photo}
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

	<h3>Δεν υπάρχουν δημοφιλής φωτογραφίες</h3>

	{/foreach}