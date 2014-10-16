GeoData = {	
	traversePoint: function(geoData, map)
	{
		var feas = geoData.features, coords, c, geo, fea;
		for(var i=0;i<feas.length;i++)
		{
			fea = feas[i];
			geo = fea.geometry;
			coords = geo.coordinates;
			this.arrayRecursion(coords, map);
		}	
	},

	arrayRecursion: function(arr, map)
	{
		if(!(arr[0] instanceof Array))//is a Point
		{
			arr = GeoData.geoToMap(arr, map);
		}
		else
		{
			for(var i=0;i<arr.length;i++)
			{
				this.arrayRecursion(arr[i], map);
			}
		}
	},
	
	geoToMap: function(p, map)
	{
		p[0] = (p[0]-map.x1)*map.x_scale, p[1] = (map.y2-p[1])*map.y_scale;//这里计算需要更加精确，消除js浮点数的错误
	},
	
	bboxGeoToMap: function(bbox, map)
	{
		var xs = map.x_scale, ys = map.y_scale;
		if(bbox instanceof Array)
		{
			bbox[0] = (bbox[0]-map.x1)*xs;
			bbox[1] = (map.y2-bbox[1])*ys;
			bbox[2] = (bbox[2]-map.x1)*xs;
			bbox[3] = (map.y2-bbox[3])*ys;
		}
		else
		{
			bbox['x1'] = (bbox['x1']-map.x1)*xs;
			bbox['y1'] = (map.y2-bbox['y1'])*ys;
			bbox['x2'] = (bbox['x2']-map.x1)*xs;
			bbox['y2'] = (map.y2-bbox['y2'])*ys;			
		}
	},
	
	geoToMapAll: function(geoData, map)
	{
		this.traversePoint(geoData, map);
	},
	
	retrieveData: function(bbox, async, func)
	{
		var data=null;
		$.ajax({
			async: async,
			type: 'GET',
			url: 'file/getOsm.php?bbox='+bbox.join(','),
			dataType: 'xml',
			success: function(xml)
			{
				data = osm2geo(xml);
				func? func(data): 0;
			}
		});
		return data;
	},
	
	getOuterBbox: function(bbox)
	{
		return outer;
	},
	
	getInnerBbox: function(bbox)
	{
		return inner;
	},
	
	getBboxFromCenter: function(){},
	getSectionFromPoint: function(){},

	getInnerTilesXY: function(num, b, p) //num is lon or lat, b is border width, p is 1 or 2, namely X1, X2...
	{
		var tmp = parseInt(num/b);
		tmp *= b;
		return (p==1)? tmp+b: tmp;
	},
	getouterTilesXY: function(num, b, p) //num is lon or lat, b is border width, p is 1 or 2, namely X1, X2...
	{
		var tmp = parseInt(num/b);
		tmp *= b;
		return (p==1)? tmp: tmp+b;
	},	
	getInnerBbox: function(bbox, tile)
	{
		
	}
}