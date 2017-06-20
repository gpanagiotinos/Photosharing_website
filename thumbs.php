<?php
require_once('lib/initialize.php');

$image = new Image();
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

$image->load($photo->path);
$image->crop(200, .5, $photo->type);
header("Pragma: public"); 
header("Expires: 0"); 
header('Content-type: '.$photo->type);

$image->output($photo->type);
//free memory
$image->destroy();


