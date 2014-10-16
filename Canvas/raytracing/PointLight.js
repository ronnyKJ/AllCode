var PointLight = function(irradiance, origin, shadow){
    this.irradiance = irradiance;
    this.origin = origin;
    this.shadow = shadow;
}

PointLight.prototype = {
    sample: function(position, scene) {
        var oppositeDirection = this.origin.subtract(position).normalize();
    	// shadow
        if(this.shadow){
        	var shadowRay = new Ray(position, oppositeDirection);
        	var intersectResult = scene.intersect(shadowRay);

        	if(intersectResult.geometry){
        		return new LightSample(oppositeDirection, Color.black);
        	}
        }
        return new LightSample(oppositeDirection, this.irradiance);
    }
};