<?php
	$str = "dGhlIHNhbXBsZSBub25jZQ=="."258EAFA5-E914-47DA-95CA-C5AB0DC85B11";
	$hash = sha1($str, true);
	echo base64_encode($hash);
	echo "<br>";
echo chr(0); 
echo chr(255); 
$arr = array();
$arr[]=0;
$arr[]=1;
$arr[]=2;
$arr[]="dsdd";
var_dump($arr);
?>