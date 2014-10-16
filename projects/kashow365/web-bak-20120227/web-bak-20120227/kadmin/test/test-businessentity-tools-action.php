<?php
include_once 'common.php';

require_once '../businessentity/tools/action.php';

$action = new Action();
	$info = "OK";
	$status = false;
	$data = "管理员帐号不能为空";
	$action -> ajaxReturn($data,$info,$status,$dataType);
?>