<?php
	$s = 'a=1;';
	$fun = $_GET["callback"];
	echo $s . $fun. "('你好世界')"; 
?>