<?php
include('polygonLineStringFuncs.php');

function addGeometryProperties($coords, $type)
{
	global $Tile_config;
	$props = array();
	if($type == 'Polygon')
	{
		$rect = getPolygonOuterRect($coords);
		$textPosition = getCenterPoint($rect[0], $rect[1], $rect[2], $rect[3]); //center point
		$area = getRectArea($rect); //area
		$zoom = getZoomLevel($area, $Tile_config['areaZoomValueArray']);// zoom
		//add props
		$props['textPosition'] = $textPosition;
		$props['zoom'] = $zoom;
	}
	else if($type == 'LineString')
	{
		$result = getLineStringLengthAndTextPoints($coords, 0.01); //0.001 lontitude width = 50px in map
		$zoom = getZoomLevel($result, $Tile_config['lineZoomValueArray']);
		//add props
		$props['textPosition'] = $result['positions'];
		$props['zoom'] = $zoom;
	}
	else //Point
	{
		// I don't how to deal with point
	}

	return $props;
}
?>