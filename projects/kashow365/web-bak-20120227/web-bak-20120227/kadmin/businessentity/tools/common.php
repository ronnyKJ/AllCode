<?php

//JSON
if(!function_exists("json_encode"))
{	
	function json_encode($data)
	{
		require_once 'json.php';
		$JSON = new JSON();
		return $JSON->encode($data);
	}
}


if(!function_exists("json_decode"))
{	
	function json_decode($data)
	{
		require_once 'json.php';
		$JSON = new JSON();
		return $JSON->decode($data,1);
	}
}

if(!function_exists("xml_encode"))
{	
	// xml编码
	function xml_encode($data,$encoding='utf-8',$root="root") {
	    $xml = '<?xml version="1.0" encoding="'.$encoding.'"?>';
	    $xml.= '<'.$root.'>';
	    $xml.= data_to_xml($data);
	    $xml.= '</'.$root.'>';
	    return $xml;
	}
}

?>