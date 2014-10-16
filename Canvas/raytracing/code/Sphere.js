/* 
 * @requires Vector3, Ray3
 */

Sphere = function(center, radius) {
    this.center = center;
    this.radius = radius;
};

Sphere.prototype = {
    copy: function() {
        return new Sphere(this.center.copy(), this.radius.copy());
    },

    initialize: function() {
        this.sqrRadius = this.radius * this.radius; //半径的平方
    },

    intersect: function(ray) {
        var dist = ray.origin.subtract(this.center);
        var a0 = dist.sqrLength() - this.sqrRadius;
        var DdotV = ray.direction.dot(dist);

        if(DdotV <= 0) {
            var discr = DdotV * DdotV - a0;
            if(discr >= 0) {
                var result = new IntersectResult();
                result.geometry = this;
                result.distance = -DdotV - Math.sqrt(discr);
                result.position = ray.getPoint(result.distance);
                result.normal = result.position.subtract(this.center).normalize();
                return result;
            }
        }

        return IntersectResult.noHit;
    }
};