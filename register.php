<?php

require_once('lib/initialize.php');

$tpl = new Template();


if(isset($_POST['registerSubmit']))
{
	$errors = false;
	//init message
	$message = '';
	if( empty($_POST['username']) || empty($_POST['pass']) || empty($_POST['pass2']) || empty($_POST['email']) || empty($_POST['captcha']) ){
		$num = 0;
		$message .= "Παρακαλώ συμπληρώστε όλα τα πεδία.";
		$errors = true;
	}else{
		$num = Member::count($_POST['username']);
	}
	if( $_POST['captcha'] != $_SESSION['captcha'] )
	{
		$errors = true;
		$message .= "Το captcha ειναι λανθασμένο.";
	}
	unset($_SESSION['captcha']);
	if( $num > 0 )
	{
		$message .= "Το όνομα μέλους υπάρχει.";
		$errors = true;
	}
	if($_POST['pass'] != $_POST['pass2'])
	{
		$message .= "Οι κωδικοί δέν ταιριάζουν.";
		$errors = true;
	}

	if(!$errors)
	{
		$time = time();
		$member = new Member();
		$member->username = $_POST['username'];
		$member->password = hash512( trim($_POST['pass']) );
		$member->email = $_POST['email'];
		$member->reg_date = $time;

		if($member->insert())
		{
			$session->message('Η εγγραφή έγινε με επιτυχία.');
			$session->messageType("success");
			$session->login($member);
			redirect(SITE_PATH."index.php");
		}else{
			$errors = true;
			$message = "Κάτι πήγε στραβά.";
		}
	}
	if($errors)
	{
		$session->message($message,false);
		$session->messageType("error",false);
	}
}


$tpl->render('register', 'Εγγραφή', 'simple');
