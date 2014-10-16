/* 
 * @requires Vector3
 * @requires Color
 */

Ray3 = function(origin, direction) {
	this.origin = origin; // 光源位置
	this.direction = direction; // 光照方向
}

Ray3.prototype = {
	getPoint: function(t) {// 光照射距离t之后的位置
		return this.origin.add(this.direction.multiply(t));
	}
};
