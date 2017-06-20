<h1>Ο λογαριασμός μου</h1>
<div class="content">
{include file="includes/message.tpl"}
<form action="{$SCRIPT_NAME}" method="POST" id="profileEditForm">
	<table class="half fleft">
		<tr>
			<th>Όνομα μέλους:</th>
			<td>
				<input validation="required" type="text" class="inputGrey" id="username" value="{$smarty.session.username}" disabled="disabled"/> 
			</td>
		</tr>
		<tr>
			<th>*Παλαιός Κωδικός:</th>
			<td>
				<input validation="required" type="password" class="inputGrey" name="oldpass" id="oldpass"/> 
			</td>
		</tr>
		<tr>
			<th>*Νεός Κωδικός:</th>
			<td>
				<input type="password" class="inputGrey" name="pass" id="pass"/> 
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>
				<div id="passstrength" class="message error">Αδύναμος</div> 
			</td>
		</tr>
		<tr>
			<th>*Επαλήθευση νέου κωδικού:</th>
			<td>
				<input type="password" class="inputGrey" name="pass2" id="pass2"/> 
			</td>
		</tr>
		<tr>
			<th>*Email:</th>
			<td>
				<input validation="required email" type="text" class="inputGrey" name="email" id="email" {if $member}value="{$member->email}"{/if}/> 
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="Αποθήκευση" class="button Blue fright" onclick="return check_update_form();"/>
				<input type="hidden" name="saveSubmit"/>
			</td>
		</tr>
	</table>
</form>
<!-- validate -->
<script type="text/javascript" charset="utf-8">
	//molis forto8ei to DOM bind validation sto login form
	$(function(){
		$('#profileEditForm').validation();
	});		
</script>
<div class="info fright">
	<ul>
		<li>Για οποιαδήποτε αλλαγή στα στοιχεία θα πρέπει να <q>παρέχεται ο παλαιός κωδικός</q> σας</li>
		<li>Ο κωδικός θα πρέπει να είναι <q>τουλάχιστον 6</q> χαρακτήρες</li>
	</ul>
</div>
</div>