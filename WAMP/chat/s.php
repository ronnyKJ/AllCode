<?php
// 设置一些基本的变量
$host = "localhost";
$port = 8000;
// 设置超时时间
set_time_limit(0);
// 创建一个Socket
$socket = socket_create(AF_INET,SOCK_STREAM,0) or die("Could not create socket\n");
//绑定Socket到端口
$result = socket_bind($socket,$host,$port) or die("Could not bind to socket\n");
// 开始监听链接
$result = socket_listen($socket,3) or die("Could not set up socket listener\n");
// accept incoming connections
if(1)
{
	// 另一个Socket来处理通信
	$connection = socket_accept($socket) or die("Could not accept incoming connection\n");
	// 获得客户端的输入
	//$request = socket_read($connection,1024) or die("Could not read request\n");
	
	//处理请求
	//$output = $request;
	$output = "first message\r\n";
	socket_write($connection,$output,strlen($output)) or die("Could not write output\n");
	
	$str = "I am Ronny from server\r\n";
	socket_write($connection,$str);
	
	$request = socket_read($connection,1024) or die("Could not read request\n");
	echo $request;
	// 关闭sockets
	socket_close($connection);
}
//socket_close($socket);
?>