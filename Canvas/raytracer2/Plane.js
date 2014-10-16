/* 
 * @requires Vector3
 * @requires IntersectResult
 */

Plane = function(normal, d) {
    this.normal = normal; // 由平面的法向量来定义平面
    this.d = d; // 平面到原点的最短距离
};

Plane.prototype = {
    copy: function() {
        return new plane(this.normal.copy(), this.d);
    },

    initialize: function() {
        this.position = this.normal.multiply(this.d); // 平面上的一点，与原点最近的点
    },

    intersect: function(ray) {
        // 光线是射线，先判断是否和平面相交
        var a = ray.direction.dot(this.normal);
        if(a >= 0) return IntersectResult.noHit;

        var b = this.normal.dot(ray.origin.subtract(this.position));
        var result = new IntersectResult();
        result.geometry = this;
        result.distance = -b / a;
        result.position = ray.getPoint(result.distance);
        result.normal = this.normal;
        return result;
    }
};