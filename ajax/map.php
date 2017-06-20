<?php
session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));
header('Content-type: text/html; charset=utf-8');

require_once('../data/database.php');
require_once('../data/database_object.class.php');
require_once('../data/photo.class.php');



$lat = isset($_GET['lat']) ? (float)$_GET['lat'] : (float)38.245445;
$lng = isset($_GET['lng']) ? (float)$_GET['lng'] : (float)21.735046;

$photos = Photo::map($lat,$lng);
foreach ($photos as $photo) {
	if(empty($photo->title)) $photo->title = 'Χωρις τιτλο';
}
echo json_encode($photos);