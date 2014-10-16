(function() {
	var scripts = [
		'utils/utils.js',
		'utils/class.js',
		'data/data.js',
		'data/tile.js',
		'data/tileManager.js',
		'mapping/map.js',
		'mapping/geoDataMapping.js',
		'layer/layer.js',
		'control/drag.js',
		'control/zoom.js',
		'control/control.js',
		'render/featuresCacheManager.js',
		'render/canvas.js',
		'render/geometryRender.js',
		'render/render.js',
		'style/normal_style.js',
		//'style/stroke_style.js',
		'style/style.js',
		'whugis.js'
	];

	function getSrcUrl() {
		var scripts = document.getElementsByTagName('script');
		for (var i = 0; i < scripts.length; i++) {
			var src = scripts[i].src;
			if (src) {
				var res = src.match(/^(.*)whugis-include\.js$/);
				if (res) {
					return res[1] + 'src/';
				}
			}
		}
	}

	var path = getSrcUrl();
	for (var i = 0; i < scripts.length; i++) {
		document.writeln("<script type=\"text/javascript\" src='" + path + "../src/" + scripts[i] + "'></script>");
	}
})();
