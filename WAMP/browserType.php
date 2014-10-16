<?php
	//echo $_SERVER["HTTP_USER_AGENT"];
	if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 8.0")) 
		echo "Internet Explorer 8.0"; 
	else if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 7.0")) 
		echo "Internet Explorer 7.0"; 
	else if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 6.0")) 
		echo "Internet Explorer 6.0";
	else if(strpos($_SERVER["HTTP_USER_AGENT"],"Firefox/3"))
		echo "Firefox 3";
	else if(strpos($_SERVER["HTTP_USER_AGENT"],"Firefox/2"))
		echo "Firefox 2";
	else if(strpos($_SERVER["HTTP_USER_AGENT"],"Chrome"))
		echo "Google Chrome";
	else if(strpos($_SERVER["HTTP_USER_AGENT"],"Safari"))
		echo "Safari";
	else if(strpos($_SERVER["HTTP_USER_AGENT"],"Opera"))
		echo "Opera";
	else
		echo $_SERVER["HTTP_USER_AGENT"]; 
?>