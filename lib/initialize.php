<?php

//Debug
error_reporting(E_ALL & ~E_NOTICE);
ini_set("memory_limit","80M");

//user
!defined('QUOTA') ? define('QUOTA','52428800') : NULL;
!defined('TIMEOUT') ? define('TIMEOUT',30*60) : NULL;
//Paths
!defined('SITE_PATH') ? define('SITE_PATH','/photosharing/') : NULL;
!defined('THUMBS_PATH') ? define('THUMBS_PATH','thumbs/') : NULL;

!defined('MAP_OFFSET') ? define('MAP_OFFSET',1) : NULL;
!defined('PER_PAGE') ? define('PER_PAGE',12) : NULL;
!defined('MAX_WIDTH') ? define('MAX_WIDTH',1280) : NULL;
!defined('MAX_HEIGHT') ? define('MAX_HEIGHT',1024) : NULL;
!defined('DEBUG') ? define('DEBUG',false) : NULL;
!defined('COMPRESSION') ? define('COMPRESSION',80) : NULL;
//Important files

require_once('lib/functions.php');

//require_once('data/config.php');
require_once('data/database.php');
require_once('lib/session.class.php');
require_once('lib/pagination.class.php');
require_once('lib/smarty/Smarty.class.php');
require_once('lib/template.config.php');
require_once('lib/template.class.php');
require_once('lib/image.class.php');

require_once('data/database_object.class.php');
require_once('data/member.class.php');
require_once('data/photo.class.php');
require_once('data/search.class.php');
require_once('data/tag.class.php');
require_once('data/comment.class.php');

