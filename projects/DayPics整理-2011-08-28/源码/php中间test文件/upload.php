<?php
$data = file_get_contents('php://input');
$handle = fopen($_SERVER['DOCUMENT_ROOT'].'/head.jpg', 'w');
/*
if ($handle)
{
	fwrite($handle,$data);
	fclose($handle);
	echo "success";
}
*/
echo $handle;
?>