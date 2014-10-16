var Zoom = {
	canvas : {},
	ctx:{},
	initialize : function(canvas,ctx){
		this.canvas = canvas;
		this.ctx = ctx;
		this.add_zoom();
	},
	add_zoom : function(){
		var self = this;
		this.canvas.onmousewheel = function(event){
			event = event || window.event;
			event.preventDefault();
			var scale;
			//滚轮向上，放大
			if(event.wheelDelta == 120){
				zoom = Map.map.zoom * 2;
			}
			//滚轮向下，缩小
			else if(event.wheelDelta == -120){
				zoom = Map.map.zoom / 2;
			}
			self.zoom(zoom);
			
		};
	},
	zoom : function(zoom){
		var self = this;
		//重新设置map的zoom
		if(!Map.isInZoomRange(zoom)){
			return;
		}
		self.ctx.clearRect(0,0, self.canvas.width, self.canvas.height);
		self.ctx.save();
				
		//得到zoom后的bbox
		var newBbox = GeoDataMapping.getBboxByCenterPoint(Map.map.centerPoint, TileManager.tileConfig.tile_scaleX, TileManager.tileConfig.tile_scaleY, Map.map.canvas.width, Map.map.canvas.height, Map.map.zoom);
		Map.relocate(newBbox);
		//根据bbox绘制图形
		TileManager.renderTileArrayFromBbox(Map.map.bbox);
		self.ctx.restore();
	}
};