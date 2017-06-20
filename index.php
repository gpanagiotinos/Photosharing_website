<?php

require_once('lib/initialize.php');

$tpl = new Template();

if( $session->is_logged_in() )
{
	$member = new Member();
	member_init(&$member, &$quota, &$photosNum);
	$tpl->assign('member',$member);
	$tpl->assign('photosNum',$photosNum);

	$tpl->assign('quota',$quota);
}

//find popular images
$popular = Photo::popular(12);

if(empty($popular))
{
	$popular = array();
}

$tpl->assign('popular',$popular);

$tpl->render('home','Αρχική σελίδα');