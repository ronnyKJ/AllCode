$(function(){
	//bind drag event
	var dragCon = $('#dragContainer');
	var up = $('#up'), right = $('#right'), down = $('#down'), left = $('#left');
	function bindDragHover(ele, num)
	{
		ele.hover(function(){
			dragCon.css('background-position', '0 -'+num+'px');
		}, function(){
			dragCon.css('background-position', '0 0');
		});	
	}
	function bindDragClick(ele, x, y)
	{
		ele.click(function(){
			Map.move(Map.map.movedX + x/Map.map.zoom ,Map.map.movedY + y/Map.map.zoom);
			Drag.transfer(x, y);
		});
	}
	bindDragHover(up, 44);
	bindDragHover(right, 88);
	bindDragHover(down, 132);
	bindDragHover(left, 176);
	bindDragClick(up, 0, -100);
	bindDragClick(right, 100, 0);
	bindDragClick(down, 0, 100);
	bindDragClick(left, -100, 0);
	
	//bind zoom event
	var zoomIn = $('#zoomIn'), zoomOut = $('#zoomOut');
	function bindZoomClick(ele,level)
	{
		ele.click(function(event){
			var zoom = Map.map.zoom;
			zoom = zoom*level;
			Zoom.zoom(zoom);
		});
	}
	bindZoomClick(zoomIn,2);
	bindZoomClick(zoomOut,0.5);
});