var Sphere = function(center, radius){
    this.center = center;
    this.radius = radius;
}

Sphere.prototype = {
    intersect : function(ray){
        var or = ray.origin.subtract(this.center);
        var c = or.dot(or)-this.radius*this.radius;

        var orDotL = or.dot(ray.direction);

        if(orDotL > 0)
            return IntersectResult.noHit;

        var delta = Math.pow(orDotL, 2) - c;

        var result = new IntersectResult();
        result.geometry = this;
        result.distance = - orDotL - Math.sqrt(delta);
        result.position = ray.getPoint(result.distance);
        result.normal = result.position.subtract(this.center).normalize();// 法向量，单位向量
        return result;
    },

    material : function(attrs){
        this.material = attrs;
    }
}