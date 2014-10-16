var Lights = function(lights){
	this.lights = lights;
}

Lights.prototype = {
	add : function(light){
		this.lights.push(light);
	},

	sample : function(position, scene){
		var i, lightSamples = [], sample;
		for(i in this.lights){
			var sample = this.lights[i].sample(position, scene);
			lightSamples.push(sample);
		}
		return lightSamples;
	}
};