Canvas = {
	path: function(ctx, type, coords/*, ..radius if point..*/)
	{
		ctx.beginPath();
		var i, t, exterior, p;
		switch(type){
			case 'Point':{
				ctx.arc(coords[0],coords[1],arguments[3],0,360,true);
				break;
			}
			case 'LineString':{
				ctx.moveTo(coords[0][0],coords[0][1]);
				for(i=0;i<coords.length;i++)
				{
					t=coords[i];
					ctx.lineTo(t[0], t[1]);
				}
				break;
			}
			case 'Polygon':{
				exterior = coords[0];
				ctx.moveTo(exterior[0], exterior[1]);
				for(i=0;i<exterior.length;i++)
				{
					t=exterior[i];
					ctx.lineTo(t[0], t[1]);
				}				
				break;
			}
			case 'MultiPoint':{
				for(i=0;i<coords.length;i++)
				{
					t=coords[i];
					ctx.arc(t[0],t[1],arguments[3],0,360,true);
				}			
				break;
			}
			case 'MultiLineString':{
			
				break;
			}
			case 'MultiPolygon':{
			
				break;
			}
			default:
				break;
		}
	}
}