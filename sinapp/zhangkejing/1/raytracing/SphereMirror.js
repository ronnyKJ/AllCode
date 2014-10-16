var SphereMirror = function(center, radius){
    this.center = center;
    this.radius = radius;
}

SphereMirror.prototype = {
    intersect : function(ray, scene){
        var dist = ray.origin.subtract(this.center);
        var a0 = dist.sqrLength() - this.radius*this.radius;
        
        var DdotV = ray.direction.dot(dist);
        var results = [];
        if(DdotV <= 0) {
            var discr = DdotV * DdotV - a0;
            if(discr >= 0) {
                var result = new IntersectResult();
                result.geometry = this;
                result.distance = -DdotV - Math.sqrt(discr);
                result.position = ray.getPoint(result.distance);
                result.normal = result.position.subtract(this.center).normalize();// 法向量，单位向量
                results.push(result);

                var reflectRay = ray.reflect(result.normal);
                scene.intersect(reflectRay)
            }
        }

        return IntersectResult.noHit; 
    }
}