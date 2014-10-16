var Layer = {
	mapContainer : $('#mapContainer'),//jQuery
	add: function(width, height)
	{
		var layer = document.createElement('canvas');
		var map = $('#map');
		layer.width = width || map.width();
		layer.height = height || map.height();
		this.mapContainer.append(layer);
		return layer;
	},
	remove: function()
	{
	
	}
};

//test
Layer.add();