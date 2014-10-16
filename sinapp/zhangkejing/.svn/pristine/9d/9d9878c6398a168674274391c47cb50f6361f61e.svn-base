var Scene = function(objects){
	this.objects = objects;
}

Scene.prototype = {
	add : function(object){
		this.objects.push(object);
	},

	intersect : function(ray){
		var i, result, nearestResult = IntersectResult.noHit, minDistance = Infinity;
		for(i in this.objects){
			result = this.objects[i].intersect(ray);
			if(result.geometry && result.distance < minDistance){
				minDistance = result.distance;
				nearestResult = result;
			}
		}

		return nearestResult;
	}
};