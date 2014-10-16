<?php
// 设置一些基本的变量
date_default_timezone_set("Asia/shanghai");  
$host = "localhost";
$port = 8000;
// 设置超时时间
set_time_limit(0);
// 创建一个server socket
$server = socket_create(AF_INET,SOCK_STREAM,0) or die("Could not create socket\n");
//绑定server到端口
$result = socket_bind($server,$host,$port) or die("Could not bind to socket\n");
// 开始监听链接
$result = socket_listen($server,3) or die("Could not set up socket listener\n");

$users = array();
$sockets = array();
$sockets[] = $server;

while(1)
{
    $changed = $sockets;  
    socket_select($changed,$write=NULL,$except=NULL,NULL);
	foreach($changed as $socket)
	{
		if($socket == $server)//第一次连接
		{
			//connect a new client socket
			$client = socket_accept($server) or die("Could not accept incoming connection\n");
			addUser($client);
		}
		else//已连接
		{
			$bytesLen = socket_recv($socket, $buffer, 1024, 0);
			$user = getUserBySocket($socket);

			if($bytesLen>0)
			{
				$msg = unwrap($buffer);//解码
				execute($socket, $msg);
			}
		}
	}
}

//----------------------------------funcs--------------------------------------
class User
{
	var $id;
	var $name;	
    var $socket;
}

function addUser($socket)
{
	global $users, $sockets, $ids;
	$user = new User();
	$user->id = uniqid();
	$user->socket = $socket;
	shakeHand($socket);
	console($user->id." comes!");
	$users[] = $user;
	$sockets[] = $socket;
	$response = array("id"=>$user->id, "exe"=>"initUser");
	send($socket, json_encode($response));
	//var_dump($users);
}

function getUserBySocket($socket)
{
	global $users;
	for($i=0;$i<count($users);$i++)
	{
		if($users[$i]->socket === $socket)
		{
			return $users[$i];
		}
	}
	return null;
}

function getUserIndexById($id)
{
	global $users;
	for($i=0;$i<count($users);$i++)
	{
		if($users[$i]->id == $id)
		{
			return $i;
		}
	}
	return null;
}

function getKey($protocal)
{
	preg_match("/Sec-WebSocket-Key: (.*)\r\n/",$protocal,$match);
	return $match[1]; 
}

function shakeHand($connection)
{
	// 获得客户端的输入
	$request = socket_read($connection,1024) or die("Could not read request\n");
	//echo $request;
	// echo strlen($request)."\r\n";
	//处理请求
	$key = getKey($request);
	
	$str = $key."258EAFA5-E914-47DA-95CA-C5AB0DC85B11";
	$hash = sha1($str, true);
	$base64 = base64_encode($hash);
	
	$upgrade  = "HTTP/1.1 101 Switching Protocols\r\n" .
				"Upgrade: websocket\r\n" .
				"Connection: Upgrade\r\n" .
				"Sec-WebSocket-Accept: " . $base64 . "\r\n\r\n";
	// echo $upgrade;
	socket_write($connection,$upgrade,strlen($upgrade)) or die("Could not write upgrade\n");
	//console("HandShake Done...");
}

function execute($socket, $msg)
{
	global $users, $sockets;
	$msg = json_decode($msg, true);
	
	switch ($msg["exe"])
	{
		case "name":
			$user = getUserBySocket($socket);
			$user->name = $msg["name"];
		break;
		case "chat":
			$response = json_encode($msg);
			for($i=1;$i<count($sockets);$i++)
			{
				send($sockets[$i], $response);
			}
		break;
		case "quit":
			$index = getUserIndexById($msg["id"]);
			socket_close($sockets[$index+1]);			
			array_splice($users, $index, 1);
			array_splice($sockets, $index+1, 1);
			console(count($users)." -- ".count($sockets));
		break;
		default:;
	}
}

function send($socket, $msg)
{
	//console("> ".$msg); //server log
	$msg = wrap($msg);
	socket_write($socket,$msg,strlen($msg));
}

function unwrap($msg="") {  
    $mask = array();  
    $data = "";  
    $msg = unpack("H*",$msg);  
    $head = substr($msg[1],0,2);
    if (hexdec($head{1}) === 8) {  
        $data = false;  
    } else if (hexdec($head{1}) === 1) {  
        $mask[] = hexdec(substr($msg[1],4,2));  
        $mask[] = hexdec(substr($msg[1],6,2));  
        $mask[] = hexdec(substr($msg[1],8,2));  
        $mask[] = hexdec(substr($msg[1],10,2));  
      
        $s = 12;  
        $e = strlen($msg[1])-2;  
        $n = 0;  
        for ($i= $s; $i<= $e; $i+= 2) {  
            $data .= chr($mask[$n%4]^hexdec(substr($msg[1],$i,2)));  
            $n++;  
        }  
    }  
      
    return $data; 
}

function wrap($msg="") {  
    $frame = array();  
    $frame[0] = "81";
    $len = strlen($msg);  
    $frame[1] = $len<16?"0".dechex($len):dechex($len);  
    $frame[2] = ord_hex($msg);  
    $data = implode("",$frame);  
    return pack("H*", $data);  
}

function ord_hex($data)  
{  
    $msg = "";  
    $l = strlen($data);  
  
    for ($i= 0; $i< $l; $i++) {  
        $msg .= dechex(ord($data{$i}));  
    }  
  
    return $msg;  
}

function console($msg)
{
	echo $msg."\r\n";
}
?>