<?php
require_once('lib/functions.php');
require_once('lib/session.class.php');

$theme = isset($_GET['theme']) ? $_GET['theme'] : 'Default';

$session->theme($theme);
redirect('/photosharing/index.php');
exit;