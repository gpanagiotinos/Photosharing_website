<h1>Επεξεργασία φωτογραφίας</h1>
<div class="content">
{include file="includes/message.tpl"}
	<div class="half fleft">
		<div class="imgGrid">
			<a href="photo.php?pid={$photo->id}" alt="{$photo->title|default:'Χωρίς τίτλο'}"><img src="thumbs.php?id={$photo->id}" alt="{$photo->title}"/></a>
		</div>
		<form action="{$SCRIPT_NAME}?action=edit&pid={$smarty.get.pid}" method="POST" id="photoEditForm">
			<table class="full">
				<tr>
					<th>Τίτλος:</th>
					<td>
						<input validation="required" type="text" name="title" id="title" class="inputGrey" value="{$photo->title}"/>
					</td>
				</tr>
				<tr>
					<th>Περιγραφή:</th>
					<td>
						<input validation="required" type="text" name="caption" id="caption" class="inputGrey" value="{$photo->caption}"/>
					</td>
				</tr>
				<tr>
					<th>Ετικέτες:</th>
					<td>
						{foreach from=$tags item=tag}
							<a id="{$tag.id}|{$photo->id}" class="tag tooltip deleteTag" href="" rel="Click για διαγραφή της ετικέτας `{$tag.name}`" onclick='return confirm("Είστε σίγουρος για την διαγραφή της ετικέτας {$tag.name}");'>{$tag.name}
							</a>
						{foreachelse}
						<h3>Η φωτογραφία δεν έχει ετικέτες.</h3>
						{/foreach}
					</td>
				</tr>
				<tr>
					<th>Νέα ετικέτα <a class="tooltip" rel="Οι ετικέτες διαχωρίζονται μεταξύ τους με κενό.">(?)</a>:</th>
					<td>
							<input type="text" name="tags" class="inputGrey" id="autocomplete"  rel="editImageInput" autocomplete="off"/>
					</td>
				</tr>
				<tr>
					<th>Δημόσια:</th>
					<td>
						<input type="checkbox" name="public" id="public" 
						{if ($photo->public == 'y')}
							checked='checked'
						{/if}
						/>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" value="Αποθήκευση" class="button Blue fright"/>
						<input type="hidden" name="editImage"/>
					</td>
				</tr>
			</table>
		<input type="hidden" id="lat" name="lat" value="{$photo->lat}"/>
		<input type="hidden" id="lng" name="lng"  value="{$photo->lng}"/>
		<input type="hidden" id="address" name="address"  value="{$photo->address}"/>
		</form>
		<!-- validate -->
		<script type="text/javascript" charset="utf-8">
			//molis forto8ei to DOM bind validation sto login form
			$(function(){
				$('#photoEditForm').validation();
			});		
		</script>
	</div>

	<div class="info fright">
		<h3>Πληροφορίες:</h3>
		<ul>
			<li>
				<q>Ημερ/νία μεταφόρτωσης:</q> {$photo->upload_date|date_format:"%d/%m/%Y"}
			</li>
			<li>
				<q>Μέγεθος:</q> {$photo->size|text_to_size}
			</li><li>
				<q>Προβολές:</q> {$photo->views}
			</li>
		</ul>
		<h3>Τοποθεσία φωτογραφίας:<a class="tooltip" rel="Κάντε `click` ή `drag` στο χάρτη για να ορίσετε την τοποθεσία. Σε περίπτωση που δεν οριστεί τοποθεσία, θα επιλεχθεί η τρέχουσα τοποθεσίας σας.">(?)</a></h3>
		<ul>
		<li><q id="currentAddress">{$photo->address|default:'Δεν υπάρχει διεύθυνση'}</q></li>
		</ul>
		<div id="photoMap">
			Map is here
		</div>

	</div> 


</div>
<script type="text/javascript">
	geoLoc();
</script>