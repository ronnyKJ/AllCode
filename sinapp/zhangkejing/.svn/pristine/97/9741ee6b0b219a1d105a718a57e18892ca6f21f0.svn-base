<?php
include('util.php');
include('polygonLineStringFuncs.php');

//*****************************************************************
$geoW=0.02;
$geoH=0.02;
$pW=1024;
$pH=1024;
$critPxLen = 20;//px
$critPxArea = 400;//px
$critGeoLen = $geoW*$critPxLen/$pW;
$critGeoArea = $geoW*$geoH*$critPxArea/($pW*$pH);

$zoomStep = array(0.0625, 0.125, 0.25, 0.5, 1, 2, 4, 8);
$lineZoomValue = array();
$areaZoomValue = array();
for($i=0;$i<count($zoomStep);$i++)
{
	array_push($lineZoomValue, $critGeoLen/$zoomStep[$i]);
	array_push($areaZoomValue, $critGeoArea/pow($zoomStep[$i], 2));
}

function addGeometryProperties($file) // zoom level, center point
{
	global $lineZoomValue, $areaZoomValue;
	$tile = json_decode(file_get_contents($file), true);
	$features = $tile['features'];
	for($i=0;$i<count($features);$i++)
	{
		$feature = $features[$i];
		$geometry = $feature['geometry'];
		if($geometry['type'] == 'Polygon')
		{
			$coords = $geometry['coordinates'][0];
			$rect = getPolygonOuterRect($coords);
			$textPosition = getCenterPoint($rect[0], $rect[1], $rect[2], $rect[3]); //centerPoint
			$area = getRectArea($rect); //area
			$zoom = getZoomLevel($area, $areaZoomValue); //zoom
			$tile['features'][$i]['geometry']['zoom'] = $zoom; //add zoom level
			$tile['features'][$i]['geometry']['textPosition'] = $textPosition; //add center point geo
		}
		else if($geometry['type'] == 'LineString')
		{
			$coords = $geometry['coordinates'];
			$result = getLineStringLengthAndTextPoints($coords, 0.01); //0.001 lontitude width = 50px in map
			$zoom = getZoomLevel($result['total'], $lineZoomValue);
			$tile['features'][$i]['geometry']['zoom'] = $zoom;
			$tile['features'][$i]['geometry']['textPosition'] = $result['positions'];
		}
		else //Point
		{
		
		}
	}
	file_put_contents($file, json_encode($tile));
}

function openDataDir($dir) //"../data"
{
	$folder = $dir;
	//打开目录
	$fp=opendir($folder);
	//阅读目录
	while(false!=$file=readdir($fp))
	{
		//列出所有文件并去掉'.'和'..'
		if($file!='.' &&$file!='..')
		{
			//赋值给数组
			$arr_file[] = $file;
		}
	}
	//输出结果
	if(is_array($arr_file))
	{
		echo count($arr_file);
		while(list($key,$value)=each($arr_file))
		{
			$path = "../data/$value";
			addGeometryProperties($path);
			echo "$path   -----------  OK<br>";
		}
	}
	//关闭目录
	closedir($fp);
}

openDataDir("../data");
?>