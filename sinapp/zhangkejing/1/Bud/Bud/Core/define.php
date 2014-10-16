<?php
if(!defined('__ROOT__')) define('__ROOT__', $_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['SCRIPT_NAME']));//根目录
define('__URL__', getBaseUrl());
define('__AC_NAME__', 'ActionController');
define('__AC_PATH__', __ROOT__.'/Action/'.__AC_NAME__.'.class.php');
?>