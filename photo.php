<?php
require_once('lib/initialize.php');
require_once('lib/log.class.php');

$tpl = new Template();



$photo_id = isset($_GET['pid'])?(int)$_GET['pid']:false;
if(!$photo_id)
{
	//No photo selected to edit.
	$session->message('Κάτι πηγε στραβά. Η φωτογραφία δεν βρέθηκε.');
	$session->messageType("alert");
	redirect(SITE_PATH.'index.php');
	exit;
}
//get photo object
if(!$photo = Photo::find($photo_id,'id'))
{
	$session->message('Δεν είναι δυνατή η προβολή της φωτογραφίας.');
	$session->messageType("error");
	redirect(SITE_PATH.'index.php');
	exit;
}


if( $session->is_logged_in() )
{
	$member = Member::find($_SESSION['username']);
	$tpl->assign('member',$member);
	//Insert comment

	if (isset($_POST['newCommentSubmit'])) {
		if(empty($_POST['comment']))
		{
			$session->message('Το σχόλιο είναι κενό.');
			$session->messageType("alert");
			redirect(SITE_PATH.'photo.php?pid='.$_GET['pid']);
			exit;
		}
		$comment = new Comment();
		$comment->pid = $photo->id;
		$comment->username = $member->username;
		$comment->date = time();
		$comment->comment = $_POST['comment'];
		if(!$comment->insert())
		{
			$session->message('Το σχόλιο δεν είναι δυνατό να αποθηκευτεί. Δοκιμάστε ξανά.');
			$session->messageType("error");
		}
		redirect(SITE_PATH.'photo.php?pid='.$photo->id);
		exit;
	}

	if(isset($_GET['delete'])){

		$comment = Comment::find($_GET['delete']);
		if(!$comment){
			$session->message('Κάτι πήγε στραβά. Το σχόλιο δεν βρέθηκε.');
			$session->messageType("error");
			redirect(SITE_PATH.'photo.php?pid='.$photo->id);
			exit;
		}
		if($photo->username == $member->username || $member->username == $comment->username)
		{
			if(!$comment->delete())
			{
				$session->message('Το σχόλιο δεν είναι δυνατό να διαγραφεί. Δοκιμάστε ξανά.');
				$session->messageType("error");
			}
		}else{
			$session->message('Nothing to do here.');
			$session->messageType("error");
		}
		redirect(SITE_PATH.'photo.php?pid='.$photo->id);
		exit;

	}

}//session_logged_in



//check privacy
if( $photo->public == 'n' && ( !isset($member) || (isset($member) && $member->username != $photo->username) ) ){
		$session->message('Δεν έχετε δικαιώματα προβολής αυτης της φωτογραφίας.');
		$session->messageType('alert');
		redirect(SITE_PATH. 'index.php');
		exit;
}
//Find Tags
$tags = Tag::photo_tags($photo->id);
if(!empty($tags)){
	$tpl->assign('tags', $tags);
}
//Find comments
$comments = Comment::findAll($photo->id);
if(!empty($comments))
{
	$tpl->assign('comments', $comments);
}

//Log
$log = new Log($photo->id);
$log->go();



$tpl->assign('photo',$photo);
$title = empty($photo->title) ? 'Χωρίς τίτλο' : $photo->title;
$tpl->render('photo_view', 'Προβολή | '.$title , 'view');