<?php
	$data = file_get_contents(base64_decode($_POST['data']));
	$handle = fopen($_SERVER['DOCUMENT_ROOT'].'/base.jpg', 'w');
	if ($handle)
	{
		fwrite($handle,$data);
		fclose($handle);
					
		echo "All done";
	}
?>