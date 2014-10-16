<?php
	include_once('simple_html_dom.php');
	$wd = $_GET['wd'];
	$web = file_get_contents('http://www.baidu.com/s?ie=utf-8&bs='.$wd.'&f=8&rsv_bp=1&wd='.$wd.'&inputT=0');
	$html = new simple_html_dom();
	$html->load($web);
	$e = $html->find('table.result');
	
	$i=0;
	foreach($e[0] as $a){
		$i++;
		var_dump($a);
		if($i==3){
			die();
		}
	}
?>