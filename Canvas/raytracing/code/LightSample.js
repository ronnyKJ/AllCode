/* 
 * @requires Vector3, Color
 */

LightSample = function(L, EL) {
	this.L = L;//光源反方向
	this.EL = EL;//光的颜色
};

LightSample.zero = new LightSample(Vector3.zero, Color.black);