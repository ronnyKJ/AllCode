var Ray = function(origin, direction){
    this.origin = origin;
    this.direction = direction;
}

Ray.prototype.getPoint = function(distance){
    return this.origin.add(this.direction.multiply(distance));
}