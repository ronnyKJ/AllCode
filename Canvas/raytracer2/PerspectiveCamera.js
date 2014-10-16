/* 
 * @requires Vector3
 */

PerspectiveCamera = function(eye, front, up, fov) {
    this.eye = eye;
    this.front = front;
    this.refUp = up;
    this.fov = fov; // field of view
};

PerspectiveCamera.prototype = {
    initialize: function() {
        this.right = this.front.cross(this.refUp);
        this.up = this.right.cross(this.front);
        this.fovScale = Math.tan(this.fov * 0.5 * Math.PI / 180) * 2;
    },

    generateRay: function(x, y) {
        var right = this.right.multiply((x - 0.5) * this.fovScale);
        var up = this.up.multiply((y - 0.5) * this.fovScale);
        return new Ray3(this.eye, this.front.add(right).add(up).normalize());
    }
};