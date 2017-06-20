<div id="navigation">
	<div id="wrapper">
		<ul class="fleft">
			<li><a href="index.php">Αρχική σελίδα</a></li>
			<li>
				<a href="photos.php">Άλμπουμ</a>
			</li>
			{if $member }
			<li><a href="profile.php">Λογαριασμός</a></li>
			<li><a href="login.php?do=logout">Αποσύνδεση</a></li>
			{else}
			<li><a href="login.php">Σύνδεση</a></li>
			<li><a href="register.php">Εγγραφή</a></li>
			{/if}
		</ul>
	</div>
</div>
{if !isset($results)}
<!-- Search engine -->
<div class="search">
	<form class="fright" action='search.php' method='GET'>
		<table>
			<tr>
				<td>
					<input type="text" name="terms" placeholder="Αναζήτηση" class="inputMpez" id="autocomplete" autocomplete="off" rel="searchInput"/>
				</td>
				<td>
					<input type="submit" value="Αναζήτηση" class="button searchBtn"/>
				</td>
			</tr>
		</table>
	</form>

</div>

{/if}