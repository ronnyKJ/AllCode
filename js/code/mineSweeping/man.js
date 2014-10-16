//************************************************************************************************************
function Man()
{
	this.clickGrid = function(x, y)
	{
		var grid = getGrid(x, y);
//		doClick(grid)
//		if(doClick(grid) == 0)
//		{
//			var arr = getNabors(x, y, 10, 10)
//			var tmpArr = [];
//			for(var i=0; i<arr.length; i++)
//			{
//				doClick(getGrid(arr[i].X, arr[i].Y));
//			}
//		}
	}
	
	function getGrid(x, y)
	{
		return _("map").childNodes[parseInt(x+""+y)];
	}
	
	function doClick(obj)
	{
 		if (document.createEvent)  
		{
			var evObj = document.createEvent('MouseEvents');
			evObj.initEvent('click', true, false );
			obj.dispatchEvent(evObj);
			return obj.innerText;
		}  
		else if (document.createEventObject)  
		{  
		   obj.fireEvent('onclick');
		   return obj.innerText;
		}
		return null;
	}
}