GeoRender = {
	renderFeature: function(ctx, feature, geocss)
	{
		//if(!geocss)
		//{
			var style = {
				fillStyle: 'rgba(255, 0, 0, 0.5)',
				strokeStyle: 'rgba(0, 0, 0, 0.5)',
				lineWidth: 1,
				radius: 3,
				type: 'stroke'
			};
		//}
		
		var type = feature.geometry.type;
		var coords = feature.geometry.coordinates;
		var makeStyle = function(s)
		{
			U.extend(ctx, s);
			if(s.type == 'fill')
			{
				ctx.fill();
			}
			else if(s.type == 'stroke')
			{
				ctx.stroke();
			}
			else
			{
				ctx.fill();
				ctx.stroke();
			}
		}
		ctx.save();
		Canvas.path(ctx, type, coords, style.radius);
		makeStyle(style);
		ctx.closePath();
		ctx.restore();
	},
	
	traverseGeoData: function(geoData, ctx)
	{
		var features = geoData.features, feature;
		for(var i=0;i<features.length;i++)
		{
			feature = features[i];
			this.renderFeature(ctx, feature);// no geocss parameter
		}
	},
	
	renderMap: function(geoData, ctx)
	{
		this.traverseGeoData(geoData, ctx);
	}
}
