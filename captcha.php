<?php
session_start();

$ranStr = md5(microtime());
$ranStr = substr($ranStr, 0, 6);
//add random string to session var
$_SESSION['captcha'] = $ranStr;
//Create captcha image
$newImage = imagecreatefromjpeg("themes/Default/images/captcha.jpg");
$txtColor = imagecolorallocate($newImage, 101, 159, 170);
imagestring($newImage, 5, 50, 5, $ranStr, $txtColor);
header("Content-type: image/jpeg");
imagejpeg($newImage);
