var Drag = {
	canvas :{},
	ctx:{},
	initialize : function(canvas,ctx){
		this.canvas = canvas;
		this.ctx = ctx;
		this.add_drag();
	},
	add_drag : function(){
		var x, y, pX, pY, isMouseDown=false;
		var self = this;
		if(W.Utils.isPC())
		{
			//***************** PC **********************
			this.canvas.onmouseup = function(){
				isMouseDown = false;
			}
			this.canvas.onmousedown = function(){
				isMouseDown = true;
				pX = event.clientX, pY = event.clientY;
			}
			this.canvas.onmousemove = function(){
				if(isMouseDown)
				{
					x=event.clientX-pX, y=event.clientY-pY;
					var movedX=Map.map.movedX, movedY=Map.map.movedY;
					movedX+=(x/Map.map.zoom), movedY+=(y/Map.map.zoom);
					pX=event.clientX, pY=event.clientY;
					Map.move(movedX, movedY);
					self.transfer(x, y);
				}
			}
		}
		else
		{
			//***************** phone **********************
			this.canvas['ontouchstart'] = function(){
				var t = event.touches[0];
				pX = t.clientX, pY = t.clientY;
			};
			this.canvas['ontouchend'] = function(){
				event.preventDefault();
				//var t = event.touches[0]; //for ontouchmove
				var t = event.changedTouches[0]; //for ontouchend
				x=t.clientX-pX, y=t.clientY-pY;
				var movedX=Map.map.movedX, movedY=Map.map.movedY;
				movedX+=(x/Map.map.zoom), movedY+=(y/Map.map.zoom);
				pX=t.clientX, pY=t.clientY;
				Map.move(movedX, movedY);
				self.transfer(x, y);
			};
		}		
	},
	transfer : function(x, y){
		x/=Map.map.zoom, y/=Map.map.zoom;
		this.ctx.clearRect(0,0, this.canvas.width, this.canvas.height);
		
		//拖动后移动的经纬度
		var movedLon = GeoDataMapping.getMovedGeoByMovedPixel(0-x,TileManager.tileConfig.tile_scaleX);
		var movedLat = GeoDataMapping.getMovedGeoByMovedPixel(y,TileManager.tileConfig.tile_scaleY);
		
		var newCenterPoint = {
			lon : Map.map.centerPoint.lon + movedLon,
			lat : Map.map.centerPoint.lat + movedLat
		};
		Map.map.centerPoint = newCenterPoint;
		var center = GeoDataMapping.lonlatToPixelXY(newCenterPoint.lon,newCenterPoint.lat,TileManager.tileConfig.tile_scaleX,TileManager.tileConfig.tile_scaleY,Map.map.referPoint);
		
		//得到drag后的bbox
		var newBbox = GeoDataMapping.getBboxAfterDrag(Map.map.bbox,movedLon,movedLat);

		//map当前bbox变换
		Map.relocate(newBbox);
		//render 新的bbox
		TileManager.renderTileArrayFromBbox(newBbox);
	}
}