<?php

require_once('lib/initialize.php');

if(isset($_GET['do']) && $_GET['do']=='logout')
{	
	$session->logout();
	redirect(SITE_PATH."index.php");
}

$tpl = new Template();

if(isset($_POST['submitedLogin']))
{
	//hash pass
	$_POST['pass'] = hash512( trim($_POST['pass'])  );

	if( Member::authenticate( $_POST['username'], $_POST['pass']) )
	{
		$member = Member::find($_POST['username']);
		
		$session->login($member);
		$session->message('Επιτυχής σύνδεση.');
		$session->messageType("success");
		redirect(SITE_PATH."index.php");
	}else{
		//error message
		$session->message('Τα στοιχεία είναι λανθασμένα.',false);
		$session->messageType("error",false);
	}

}

$tpl->render('login', 'Σύνδεση', 'simple');