var RayTracingRender = function(camera, screen, scene, lights, canvas){
	this.camera = camera;
	this.screen = screen;
	this.scene = scene;
	this.lights = lights;
	this.canvas = canvas;

	this.initialize();
}

RayTracingRender.prototype = {
	initCanvas : function(){
		var width = this.canvas.width = this.canvas.width;
		var height = this.canvas.height = this.canvas.height;
		var ctx = this.context = canvas.getContext("2d");
		ctx.fillStyle = this.canvas.getAttribute('bgColor');
		ctx.fillRect(0, 0, width, height);
		this.imgdata = ctx.getImageData(0, 0, width, height);
		this.pixels = this.imgdata.data;
	},

	initialize : function(){
		this.initCanvas();

		var i = 0, width = this.canvas.width, height = this.canvas.height, pixels = this.pixels;
		for(var y = 0; y < height; y++){  
		    var sy = y / height;
		    for(var x = 0; x < width; x++){
		        var sx = x / width;

		        var ray = camera.emit(sx, sy, screen);
		        var intersectResult = this.scene.intersect(ray);
		            
		        if(intersectResult.geometry){
		            var color = Color.black;
		            
		            var lightSamples = lights.sample(intersectResult.position, this.scene);

		            for(var k in lightSamples){
			            var lightStrength = intersectResult.normal.dot(lightSamples[k].oppositeDirection);

			            // 夹角小于90度，即光源在平面的正方向上，光可以照射到，不是黑的
			            if (lightStrength >= 0)
		            	    color = color.add(lightSamples[k].irradiance.multiply(lightStrength));
		        	}

		            pixels[i    ] = color.r * 255;
		            pixels[i + 1] = color.g * 255;
		            pixels[i + 2] = color.b * 255;
		            pixels[i + 3] = 255;
		        }
		        
		        i += 4;
		    }

		}

		this.context.putImageData(this.imgdata, 0, 0);
	}
};