var Tile = W.Class.extend({
	options : {
		bbox : [],
		geoData :{}
	},
	initialize : function(options){
		W.Utils.setOptions(this, options);
	},
	getGeoData : function(){
		return this.options.geoData;
	}
	
});