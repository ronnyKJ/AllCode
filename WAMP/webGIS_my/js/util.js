U={
	copyArray: function(arr)
	{
		return Array.prototype.slice.call(arr);
	},
	copyJSON: function(json)
	{
		var tmp = JSON.stringify(json);
		return JSON.parse(tmp);
	},
	extend: function(origin /*...*/)
	{
		var l=arguments.length, j;
		if(l<2) return;
		for(var i=1; i<l;i++)
		{
			for(j in arguments[i])
			{
				origin[j] = arguments[i][j];
			}
		}
	}
};