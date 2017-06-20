<?php
session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));
header('Content-type: text/html; charset=utf-8');
session_start();

require_once('../data/database.php');
require_once('../data/database_object.class.php');
require_once('../data/tag.class.php');
require_once('../data/photo.class.php');
require_once('../lib/functions.php');


$photo_id = isset($_GET['photo_id']) ? $_GET['photo_id']: die('no pid');
$photo = Photo::find($photo_id, 'id');

security_check($photo, true) ? null : exit();

$tag_id = isset($_GET['tag_id']) ? $_GET['tag_id']: die('no id');

if(!$tag = Tag::find($tag_id)) die('no tag');

if($tag->delete())
{
	echo "ok";
}else{
	echo "empty";
}