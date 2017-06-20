<div id="aside" class="fleft">
	{if $member}
	<div id="heading">
		<h4><img src='{#images_path#}/icons/hard-disk.png' />Άλμπουμ</h4>
	</div>
	<div class="content">
		<table class="infoTable full">
			<tr>
				<th>
					Αρ.Φωτογραφιών:
				</th>
				<td>
					<a href='photos.php'>{$photosNum}</a>
				</td>
			<tr>
			<tr>
				<th>
					Πλήρες:
				</th>
				<td>
					{$quota.percent}%
				</td>
			<tr>
				<th>
					Χρησιμοποιείτε:
				</th>
				<td> {$quota.size} / 50 MB</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="barContainer">
						<div class="barBlue" style="width:{$quota.percent}%;"></div>
					</div>
				</td>
			</tr>
		</table>
	</div>
	{else}
	<div id="heading">
		<h4><img src='{#images_path#}/icons/lock.png' />Σύνδεση</h4>
	</div>
	<div class="content">

	<form action="login.php" method="POST" id="loginFormSidebar">
		<table class="full">
			<tr><td>
				<input type="text" placeholder="Όνομα μέλους" name="username" id="username" class="inputMpez" validation="required"/>
			</td></tr>
			<tr><td>
				<input type="password" placeholder="Kωδικός" name="pass" id="pass" class="inputMpez" validation="required"/>
			</td></tr> 
			<tr><td>
				<input type="submit" value="Σύνδεση" class="fright button Mpez"/>
				<input type="hidden" name="submitedLogin"/>
			</td></tr>
		</table>
	</form>
	<!-- validate -->
	<script type="text/javascript" charset="utf-8">
		//molis forto8ei to DOM bind validation sto login form
		$(function(){
			$('#loginFormSidebar').validation();
		});		
	</script>
	</div>
	{/if}
	<div id="heading">
		<h4><img src='{#images_path#}/icons/cloud.png' />Tag Cloud</h4>
	</div>
	<div class="content">
		{tagcloud}
	</div>
</div>