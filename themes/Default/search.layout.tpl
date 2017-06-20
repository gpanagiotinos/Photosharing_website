<!DOCTYPE html>

{include file="includes/header.tpl"}
{include file="includes/navigation.tpl"}
<div id="wrapper" class="fullHeight">
	{include file="includes/message.tpl"}
	<div id="container" class="fleft">
		{$_content}
	</div>
	<div id="aside" class="fleft leftBordered">
		<span class="details">Βρέθηκαν <em>{$total|default:'0'}</em> φωτογραφίες</span>
		{if isset($terms)}
			<h3>Τρέχουσα αναζήτηση:</h3>
			<ul>
				{foreach from=$terms item=term}
					<li>{$term}</li>
				{/foreach}
			</ul>
		{/if}
		<h3>Νέα αναζήτηση:</h3>
		<form action='search.php' method='GET'>
			<table class="full">
				<tr>
					<td>
						<input type="text" name="terms" placeholder="Αναζήτηση" class="inputMpez" id="autocomplete" autocomplete="off" rel="searchInputSide"/>
					</td>
				</tr>
				<tr>
					<td>
						<input type="checkbox" name="fullsearch"/>
						Αναζήτηση σε <q>τίτλο</q> και <q>περιγραφή</q>.
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" value="Αναζήτηση" class="button searchBtn fright"/>
					</td>
				</tr>
			</table>
		</form>
		<h3>Προτεινόμενα:</h3>
		{tagcloud}
	</div>
</div>
{include file="includes/footer.tpl"}