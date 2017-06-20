<?php

class Session
{
	private $logged_in = false;
	public $username;
	public $message;
	public $type;

	function __construct()
	{
		//Start the session
		session_start();
		$this->check_login();
		$this->check_message();
	}

	public function is_logged_in() //Getter Function
	{
		return $this->logged_in;
	}

	public function require_logged_in()
	{
		global $session;
		if(!self::is_logged_in()){
			$session->message('Παρακαλώ συνδεθείτε στο σύστημα.');
			$session->messageType('error');
			redirect(SITE_PATH.'login.php');
		}
	}

	public function login($member)
	{
		session_regenerate_id();
		$this->username = $_SESSION['username'] = $member->username;
		$this->logged_in = true;
	}

	public function message($msg="", $global = true) {
	  if(!empty($msg)) {
	  	if($global){
	    	$_SESSION['message'] = $msg;
		}else{
	    	$this->message = $msg;
		}
	  } else {
			return $this->message;
	  }
	}
	public function messageType($type="", $global = true) {
	  if(!empty($type)) {
	  	if($global){
	    	$_SESSION['type'] = $type;
		}else{
	    	$this->type = $type;
		}
	  } else {
			return $this->type;
	  }
	}

	public function logout()
	{
		unset($_SESSION['username']);
		unset($this->username);
		//Destroy session
		session_destroy();
		$this->logged_in = false;
	}

	//Initialize class attributes
	private function check_login()
	{
		if(isset($_SESSION['username']))
		{
			$this->logged_in = true;
			$this->username = $_SESSION['username'];
		}
		else
		{
			$this->logged_in = false;
			unset($this->username);
		}
	}
	private function check_message() {
	// Is there a message stored in the session?
	if(isset($_SESSION['message'])) {
			// Add it as an attribute and erase the stored version
      $this->message = $_SESSION['message'];
      $this->type = $_SESSION['type'];
      unset($_SESSION['message']);
      unset($_SESSION['type']);
    } else {
      $this->message = "";
    }
	}

}
$session = new Session();
