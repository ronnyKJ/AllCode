var Map = {
	map : {
		width : 0,
		height : 0,
		canvas : {},
		ctx : {},
		movedX : 0,
		movedY : 0,
		zoom : 1,
		initBbox :[],
		bbox :[],
		centerPoint :{
			lon : 0,
			lat : 0
		},
		referPoint :{
			x : 0,
			y : 0 ,
			lon : 0,
			lat : 0
		}
	} ,
	initialize : function(canvas,point,zoom){
		var centerPoint = W.Utils.extend(this.map.centerPoint,point);
		var initBbox = GeoDataMapping.getBboxByCenterPoint(centerPoint , TileManager.tileConfig.tile_scaleX , TileManager.tileConfig.tile_scaleY,canvas.width,canvas.height,zoom);
		this.map = W.Utils.extend(this.map, {
			width: canvas.width,
			height: canvas.height,
			canvas : canvas,
			ctx : canvas.getContext('2d'),
			movedX : 0,
			movedY : 0,
			zoom : zoom,
			initBbox : initBbox,
			bbox : initBbox,
			referPoint : {
				x : canvas.width/2,
				y : canvas.height/2,
				lon : centerPoint.lon,
				lat : centerPoint.lat
			}
		});
	},
	resetReferpoint : function(referPoint){
		this.map = W.Utils.extend(this.map, {
			referPoint : {
				x : referPoint.x,
				y : referPoint.y,
				lon : referPoint.lon,
				lat : referPoint.lat
			}
		});
	},
	relocate : function(bbox){
		this.map = W.Utils.extend(this.map, {
			bbox : bbox
		});
	},
	move : function(movedX ,movedY){
		this.map = W.Utils.extend(this.map, {
			movedX : movedX , 
			movedY : movedY  
		});
	},
	setZoom : function(zoom){
		this.tileConfig = W.Utils.extend(this.map, {
			zoom:zoom
		});
	},
	isInZoomRange : function(zoom){
		if(zoom >=0.0625 && zoom <= 8){
			this.setZoom(zoom);
			return true;
		}else if(zoom < 0.0625 ){
			this.setZoom(0.0625);
			return false;
		}else if(zoom > 8){
			this.setZoom(8);
			return false;
		}
	},
	checkTranslate : function(doAfterCheck){
		var map = this.map;
		var ctx = map.ctx;
		ctx.save();
		var zoom = map.zoom;
		
		ctx.scale(zoom, zoom);
		
		var w = map.canvas.width, h = map.canvas.height;
		ctx.translate(w/2*(1-zoom)/zoom + map.movedX, h/2*(1-zoom)/zoom + map.movedY); // by YGC
		//ctx.translate(0.5*w*(1/zoom-1) + map.movedX, 0.5*h*(1/zoom-1) + map.movedY); //by ZKJ
		doAfterCheck();
		//Render.markPoint(ctx,0, 0, 'rgba(255,0,255,0.4)');
		//Render.markPoint(ctx, w/zoom/2, h/zoom/2, 'rgba(0,0,255,0.4)');
		map.ctx.restore();
		//Render.markPoint(ctx, w/2, h/2, 'rgba(255,0,255,0.4)');
	}
};