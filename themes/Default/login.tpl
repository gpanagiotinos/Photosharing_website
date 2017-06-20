<h1>Σύνδεση</h1>
<div class="content">
{include file="includes/message.tpl"}
<form action="{$SCRIPT_NAME}" method="POST" id="loginFormMain">
	<table class="half fleft">
		<tr>
			<th>Όνομα μέλους:</th>
			<td>
				<input type="text" class="inputGrey" validation="required" name="username" id="username" {if $smarty.post.username}value="{$smarty.post.username}"{/if}/> 
			</td>
		</tr>
		<tr>
			<th>Κωδικός:</th>
			<td>
				<input type="password" class="inputGrey" validation="required" name="pass" id="pass"/> 
			</td>
		</tr>
		<tr><td colspan="2">
				<input type="submit" value="Σύνδεση" class="fright button Mpez" />
				<input type="hidden" name="submitedLogin"/>
			</td></tr>
	</table>
	<!-- validate -->
	<script type="text/javascript" charset="utf-8">
		//molis forto8ei to DOM bind validation sto login form
		$(function(){
			$('#loginFormMain').validation();
		});		
	</script>
</form>
<div class="info fright">
	<p>
	Δεν είστε <q>μέλος;</q>&nbsp;&bull;&nbsp;<a href="register.php">Κάντε εγγραφή εδώ.</a> 
	</p>
</div>
</div>