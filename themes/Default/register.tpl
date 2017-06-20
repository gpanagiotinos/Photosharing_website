<h1>Εγγραφή νέου μέλους</h1>
<div class="content">
{include file="includes/message.tpl"}
<form action="{$SCRIPT_NAME}" method="POST" id="registerForm">
	<table class="half fleft">
		<tr>
			<th>*Όνομα μέλους:</th>
			<td>
				<input validation="required" type="text" class="inputGrey" name="username" id="username" {if $smarty.post.username}value="{$smarty.post.username}"{/if}/> 
			</td>
		</tr>
		<tr>
			<th>*Κωδικός:</th>
			<td>
				<input validation="required" type="password" class="inputGrey" name="pass" id="pass"/> 
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>
				<div id="passstrength" class="message error">Αδύναμος</div>
			</td>
		</tr>
		<tr>
			<th>*Επαλήθευση κωδικού:</th>
			<td>
				<input validation="required" type="password" class="inputGrey" name="pass2" id="pass2"/> 
			</td>
		</tr>
		<tr>
			<th>*Email:</th>
			<td>
				<input validation="required email" type="text" class="inputGrey" name="email" id="email" {if $smarty.post.email}value="{$smarty.post.email}"{/if}/> 
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>
				<center><img src="captcha.php" /></center>
			</td>
		</tr>
		<tr>
			<th>*Captcha:</th>
			<td>
				<input validation="required" type="text" class="inputGrey" name="captcha" id="captcha"/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="Εγγραφή" class="button Blue fright"/>
				<input type="hidden" name="registerSubmit"/>
			</td>
		</tr>
	</table>
</form>
<!-- validate -->
<script type="text/javascript" charset="utf-8">
	//molis forto8ei to DOM bind validation sto login form
	$(function(){
		$('#registerForm').validation();
	});		
</script>
<div class="info fright">
	<p>
	Με την εγγραφή σας θα έχετε την δυνατότητα <q>μεταφόρτωσης</q> φωτογραφιών σε δικό σας προσωπικό album μεγέθους <q>50mb</q>.
	<br/><br/>
	Επισης την δυνατότητα να αφήνετε τα <q>σχόλια</q> και της <q>εντυπώσεις</q> σας σε υπάρχουσες φωτογραφίες. 
	</p>
	<ul>
		<li>Το όνομα μέλους θα πρέπει να είναι <q>τουλάχιστον 4</q> χαρακτήρες</li>
		<li>Ο κωδικός θα πρέπει να είναι <q>τουλάχιστον 6</q> χαρακτήρες</li>
	</ul>
</div>
</div>