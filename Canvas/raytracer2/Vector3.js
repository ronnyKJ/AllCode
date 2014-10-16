Vector3 = function(x, y, z) {
    this.x = x;
    this.y = y;
    this.z = z;
};

Vector3.prototype = {
    copy: function() {
        return new Vector3(this.x, this.y, this.z);
    },
    length: function() {
        return Math.sqrt(this.x * this.x + this.y * this.y + this.z * this.z);
    },
    sqrLength: function() {
        return this.x * this.x + this.y * this.y + this.z * this.z;
    },
    normalize: function() {
        var inv = 1 / this.length();
        return new Vector3(this.x * inv, this.y * inv, this.z * inv);
    },
    negate: function() {
        return new Vector3(-this.x, -this.y, -this.z);
    },
    add: function(v) {
        return new Vector3(this.x + v.x, this.y + v.y, this.z + v.z);
    },
    subtract: function(v) {
        return new Vector3(this.x - v.x, this.y - v.y, this.z - v.z);
    },
    multiply: function(f) {
        return new Vector3(this.x * f, this.y * f, this.z * f);
    },
    divide: function(f) {
        var invf = 1 / f;
        return new Vector3(this.x * invf, this.y * invf, this.z * invf);
    },
    dot: function(v) {
        return this.x * v.x + this.y * v.y + this.z * v.z;
    },
    cross: function(v) {
        return new Vector3(-this.z * v.y + this.y * v.z, this.z * v.x - this.x * v.z, -this.y * v.x + this.x * v.y);
    }
};

Vector3.zero = new Vector3(0, 0, 0);