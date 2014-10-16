<?php
require 'Core/functions.php';
require 'Core/define.php';
require 'Core/Factory.class.php';
require 'Action/Model.class.php';
require 'Action/Action.class.php';
require 'Action/Cache.class.php';
require 'Action/View.class.php';
require __AC_PATH__;

$tmp_uri = parseUrl();
$method = getMethodName($tmp_uri);

$action = Factory::getInstance('ActionController');
call_user_func_array(array($action, $method), array());
?>