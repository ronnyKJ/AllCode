W = {};

W.Utils = {
	setOptions: function (obj, options) {
		obj.options = W.Utils.extend({}, obj.options, options);
	},    

	extend: function (/*Object*/ dest) /*-> Object*/ {	// merge src properties into dest
		var sources = Array.prototype.slice.call(arguments, 1), len = sources.length, 
            i, j, src;
		for (j = 0; j < len; j++) {
			src = sources[j] || {};
			for (i in src) {
				if (src.hasOwnProperty(i)) {
					dest[i] = src[i];
				}
			}
		}
		return dest;
	},
    copyJSON: function(json)
	{
		var tmp = JSON.stringify(json);
		return JSON.parse(tmp);
	},
    isEmpty: function (obj) {
        var key;
        for (key in obj) {
            if (obj.hasOwnProperty(key)) {
                return false;
            }
        }

        return true;        
    },
	sleep : function(numberMillis){
		var now = new Date();    
		var exitTime = now.getTime() + numberMillis;   
		while (true) { 
			now = new Date();       
			if (now.getTime() > exitTime) 
			return;    
		}
	},
	isPC : function()
	{
		return !('ontouchstart' in window);
	},
	hexToRgba : function(hex , a )
	{
		var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		return result ? 
			["rgba(",
			parseInt(result[1], 16),",",
			parseInt(result[2], 16),",",
			parseInt(result[3], 16),",",
			a,")"].join("")
		: "";
	},
	run : function(){
		for(var obj in normal_geoCss){
			for(var key in normal_geoCss[obj]){
				if(key =="fillStyle" || key=="strokeStyle"){
					normal_geoCss[obj][key] = this.hexToRgba(normal_geoCss[obj][key],0.5); 
				}
			}
		}
		console.log(JSON.stringify(normal_geoCss));
	}
};
