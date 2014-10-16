<?php
	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	socket_connect($socket,'localhost', 8000);
	//socket_write($socket, "Hello from client\r\n");
	$content = socket_read($socket,1024);
	echo $content;
	$content = socket_read($socket,1024);
	echo $content;
	socket_write($socket, "Hello from client\r\n");
?>