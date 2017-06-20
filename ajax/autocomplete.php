<?php
session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));
header('Content-type: text/html; charset=utf-8');

require_once('../lib/functions.php');
require_once('../data/database.php');
require_once('../data/database_object.class.php');
require_once('../data/tag.class.php');
//set encode
mb_internal_encoding('UTF-8');
//Split str to words
$str = isset($_GET['str']) ? $_GET['str']: die('no str');
$rel = isset($_GET['rel']) ? $_GET['rel']: die('no rel');

$words = explode(' ', $str);
$word = strtolower(array_pop($words));


$object_array = Tag::find_suggestions($word);

if(!empty($object_array) && !empty($word))
{
	$response = '<ul>';
	foreach ($object_array as $object) {
		$tag = str_replace($word, '<em>'.$word.'</em>', $object->name);

		$response .= "<li><a href='#' title='".mb_substr($object->name, count(mb_str_split($word)), mb_strlen($object->name))."' rel='".$rel."'>".$tag."</a></li>";
	}
	$response .= '</ul>';
}else{
	$response = 'empty';
}
echo $response;
exit;