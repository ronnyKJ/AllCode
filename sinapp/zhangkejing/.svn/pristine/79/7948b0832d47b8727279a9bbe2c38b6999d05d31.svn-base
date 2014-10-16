var DirectionalLight = function(irradiance, direction, shadow){
    this.irradiance = irradiance;
    this.direction = direction;
    this.oppositeDirection = this.direction.normalize().negate();// 光线反方向的单位向量
    this.shadow = shadow;
}

DirectionalLight.prototype = {
    sample: function(position, scene) {
    	// shadow
    	if(this.shadow){
            var shadowRay = new Ray(position, this.oppositeDirection);
            var intersectResult = scene.intersect(shadowRay);
        
        	if(intersectResult.geometry){
        		return new LightSample(this.oppositeDirection, Color.black);
        	}
        }

        return new LightSample(this.oppositeDirection, this.irradiance);
    }
};