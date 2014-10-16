var Camera = function(position){
    this.position = position;
}

Camera.prototype.emit = function(x, y, screen){
    var w = screen.width;
    var h = screen.height;

    var direction = new Vector3(0, w*x, -h*y).add(screen.position).subtract(this.position).normalize();
    var position = this.position;
    return new Ray(position, direction);
}