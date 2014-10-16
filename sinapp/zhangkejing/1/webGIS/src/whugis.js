/* whugis is a javascript framework rendering map using html5 canvas, which recieves geoJson-like map data */

var Whugis = W.Class.extend({
	options : {
	},
	initialize : function(options){
		W.Utils.setOptions(this, options);
	},
	initMap : function(canvas,point,zoom){
		Map.initialize(canvas,point,zoom);
	},
	initStyle : function(style){
		Style.initialize(style);
	},
	initControl: function(){
		Drag.initialize(Map.map.canvas,Map.map.ctx);
		Zoom.initialize(Map.map.canvas,Map.map.ctx);
	},
	render : function(canvas, centerPoint, style, zoom){
		//初始化数据和地图,地图样式
		this.initMap(canvas,centerPoint,zoom);
		this.initStyle(style);
		this.initControl();
		
		//渲染数据
		Render.initRender();
	}
});

