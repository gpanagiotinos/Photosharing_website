<?php

require_once('lib/initialize.php');

$session->require_logged_in();

//member vars init
$member = new Member();
$tpl = new Template();
member_init(&$member, &$quota, &$photosNum);
$tpl->assign('member',$member);
$tpl->assign('photosNum',$photosNum);
$tpl->assign('quota',$quota);

//Send logged data to template




if(isset($_POST['saveSubmit']))
{
	$errors = false;
	if( empty($_POST['oldpass']) )
	{
		$errors = true;
		$message = 'Παρακαλώ συμπληρώστε τον παλαιό σας κωδικό.';
	}else{
		//old pass is filled
		//hash pass
		$_POST['oldpass'] = hash512( trim($_POST['oldpass']) );
		if( Member::authenticate($member->username, $_POST['oldpass']) )
		{
			//old pass is correct!
			$member->password = $_POST['oldpass'];
			if( !empty($_POST['pass']) )
			{
				if( $_POST['pass'] == $_POST['pass2'] ) //check if passes are a match
				{
					$member->password = hash512( trim($_POST['pass']) );
				}else{
					$errors = true;
					$message = 'Οι κωδικοί δεν ταιριάζουν.';
				}
			}
			if( !empty($_POST['email']) )
			{
				$member->email = $_POST['email'];
			}

			if( $member->update() )
			{
				$session->message('Η αποθήκευση έγινε με επιτυχία.',false);
				$session->messageType("success",false);
			}else{
				$errors = true;
				$message = 'Κατι πήγε στραβά.';
			}

		}else{
			$errors = true;
			$message = 'Ο κωδικός σας είναι λανθασμένος.';
		}
	}
	if($errors)
	{
		$session->message($message,false);
		$session->messageType("error",false);
	}
}



$tpl->assign('member',$member);
$tpl->render('profile', 'Λογαριαμός');