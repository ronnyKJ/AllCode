var GeometryRender = {
	renderFeature: function(feature , ctx)
	{
		//--------------- zkj 20120414--------------------
		if(FeaturesCacheManager.cache[feature.id])
		{
			return;
		}
		else
			FeaturesCacheManager.cache[feature.id] = feature;
		//--------------- zkj 20120414--------------------
		var geometry = feature.geometry;
		var zoomLevel = geometry.zoom;
		if(zoomLevel > Map.map.zoom){
			return;
		}
		var style = W.Utils.extend({
			fillStyle: 'rgba(200, 200, 200, 0.5)',
			strokeStyle: 'rgba(0, 0, 0, 0.5)',
			lineWidth: 0.2,
			radius: 1,	
		}, feature.style);
		
		var type = geometry.type;
		var coords = geometry.axeXY;

		ctx.save();
		ctx.beginPath();
		Canvas.path(ctx, type, coords, style.radius);//路径
		Render.renderGeometryStyle(ctx, style, type);//样式
		ctx.closePath();
		
		// render text
		//if(zoomLevel <= Map.map.zoom/4)//控制注记的显示级别
		(location.search.indexOf('notext') == -1 && style.text)? Render.renderText(style.text, geometry, type, ctx):0;
		ctx.restore();
	},
	
	traverseGeoData: function(geoData, ctx)
	{
		var features = geoData.features, feature;
		for(var i=0;i<features.length;i++)
		{
			feature = features[i];
			this.renderFeature(feature ,ctx);
		}
	},
	
	renderTile: function(geoData, ctx)
	{
		this.traverseGeoData(geoData, ctx);
	}
}
