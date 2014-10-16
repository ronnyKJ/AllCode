/* 
 * @requires Vector3
 */

IntersectResult = function() {
    this.geometry = null;
    this.distance = 0;
    this.position = Vector3.zero;//位置
    this.normal = Vector3.zero;//法线
};

IntersectResult.noHit = new IntersectResult();
