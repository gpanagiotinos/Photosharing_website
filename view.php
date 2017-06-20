<?php
require_once('lib/initialize.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : false;
if(!$id)
{
	//No photo selected to edit.
	$session->message('Κάτι πηγε στραβά. Η φωτογραφία δεν βρέθηκε.');
	$session->messageType("alert");
	redirect(SITE_PATH.'index.php');
	exit;
}
//get photo object
if(!$photo = Photo::find($id,'id'))
{
	$session->message('Δεν είναι δυνατή η προβολή της φωτογραφίας.');
	$session->messageType("error");
	redirect(SITE_PATH.'index.php');
	exit;
}

security_check($photo) ? null : exit();

header("Pragma: public"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("Cache-Control: public"); 

header("Content-Length: ".$photo->size);
header('Content-type: '.$photo->type);

@readfile($photo->path); 
unset($photo);


