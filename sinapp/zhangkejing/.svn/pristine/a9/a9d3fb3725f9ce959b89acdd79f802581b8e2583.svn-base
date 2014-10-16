var GeoDataMapping = {
	//将地理坐标转换为图面坐标
	geoToMap : function(feature){
		//feature的坐标投影
		var coords = feature.geometry.coordinates;
		var axeXY = W.Utils.copyJSON(coords);
		this.coordsToXY(axeXY);
		feature.geometry.axeXY = axeXY || [];
		//feature的text坐标投影
		var type = feature.geometry.type;
		var textPosition = feature.geometry.textPosition;
		this.textPositionToXY(textPosition,type);
	},
	coordsToXY: function(arr)
	{
		if(!(arr[0] instanceof Array))//is a Point
		{
			arr = this.pointToMap(arr, Map.map.referPoint, TileManager.tileConfig.tile_scaleX , TileManager.tileConfig.tile_scaleY );
		}
		else
		{
			for(var i=0;i<arr.length;i++)
			{
				this.coordsToXY(arr[i]);
			}
		}
	},
	pointToMap: function(p, referPoint, x_scale, y_scale)
	{
		p[0] = (p[0]-referPoint.lon)*x_scale + referPoint.x;
		p[1] = (referPoint.lat-p[1])*y_scale + referPoint.y;
	},
	textPositionToXY : function(textPosition,type){
		if(type == "Polygon"){
			this.textPositionToMap(textPosition,Map.map.referPoint, TileManager.tileConfig.tile_scaleX , TileManager.tileConfig.tile_scaleY);
		}else if(type == "LineString"){
			for(var i=0;i<textPosition.length;i++){
				this.textPositionToMap(textPosition[i],Map.map.referPoint, TileManager.tileConfig.tile_scaleX , TileManager.tileConfig.tile_scaleY);
			}
		}
	},
	textPositionToMap: function(p, referPoint, x_scale, y_scale)
	{
		p.x = (p.x-referPoint.lon)*x_scale + referPoint.x;
		p.y= (referPoint.lat-p.y)*y_scale + referPoint.y;
	},
	pixelXYToLonlat : function( x , y , x_scale, y_scale, referPoint){
		var lon = referPoint.lon + (x-referPoint.x)/x_scale,
			lat = referPoint.lat - (y-referPoint.y)/y_scale;
		
		return {lon : lon ,lat : lat};
	},
	lonlatToPixelXY : function(lon, lat, x_scale, y_scale, referPoint){
		var x = (lon-referPoint.lon)*x_scale + referPoint.x,
			y = (referPoint.lat-lat)*y_scale + referPoint.y;
		
		return {x : x ,y : y};
	},
	
	getBboxByCenterPoint : function(point,x_scale,y_scale,windowWidth,windowHeight,zoom){
		var left,bottom,right,top;
		
		left = point.lon-0.5*windowWidth/(x_scale*zoom);
		bottom = point.lat-0.5*windowHeight/(y_scale*zoom);
		right = point.lon+0.5*windowWidth/(x_scale*zoom);
		top = point.lat+0.5*windowHeight/(y_scale*zoom);
		
		return [left,bottom,right,top];
	},
	getMovedGeoByMovedPixel : function(movedPixel,scale){
		return movedPixel/scale;
	},
	getBboxAfterDrag : function(bbox,movedLon,movedLat){
		return [
			bbox[0]+movedLon,
			bbox[1]+movedLat,
			bbox[2]+movedLon,
			bbox[3]+movedLat
		];
	},
	getTileBboxFromID : function(id)
	{
		var arr = id.split('_');
		var m=Number(arr[0]), n=Number(arr[1]);
		var bw = TileManager.tileConfig.tileSize_lon, bh = TileManager.tileConfig.tileSize_lat;
		var x1 = m*bw, x2 = (m+1)*bw, y1 = n*bh, y2 = (n+1)*bh;
		return [x1, y1, x2, y2];
	},
	getTileRectFromID : function(id)
	{
		var bbox = this.getTileBboxFromID(id);
		var conf = TileManager.tileConfig;
		var rect = {};
		rect.p1 = this.lonlatToPixelXY(bbox[0], bbox[3], conf.tile_scaleX, conf.tile_scaleY, Map.map.referPoint);
		rect.p2 = this.lonlatToPixelXY(bbox[2], bbox[1], conf.tile_scaleX, conf.tile_scaleY, Map.map.referPoint);
		return rect;
	}
};