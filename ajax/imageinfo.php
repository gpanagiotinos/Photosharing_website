<?php

session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));
header('Content-type: text/html; charset=utf-8');

require_once('../data/database.php');
require_once('../data/database_object.class.php');
require_once('../data/photo.class.php');

if(!$photo = Photo::find($_GET['id'], 'id')) die('empty');

$privacy = ($photo->public == 'n')?'Ιδιωτική' : 'Δημόσια';
$title = empty($photo->title) ? 'Χωρίς τίτλο' : $photo->title;
$caption = empty($photo->caption) ? 'Χωρίς περιγραφή' : $photo->caption;
$data = '<table cellpadding="5px" cellspacing="0">';
$data .= "<tr><td><q>Τίτλος:</q></td><td>".$title.'</td></tr>';
$data .= "<tr><td><q>Περιγραφή:</q></td><td>".$caption.'</td></tr>';
$data .= "<tr><td><q>Ασφάλεια:</q></td><td>".$privacy.'</td></tr>';
$data .= '</table>';
echo $data;