var Render = {
	processAndRenderFeature : function(data,tileID){
		var features = data.features;
		//没有数据，提示没数据（待处理）
		if(!features){
			return;
		}
		for(var i=0;i<features.length;i++)
		{
			//地理数据坐标地图化
			GeoDataMapping.geoToMap(features[i]);
			//feature style组装(只组装一次)
			if(!features[i].style){
				Style.restyle(features[i]);
			}
			//render feature
			GeometryRender.renderFeature(features[i],Map.map.ctx,tileID);
		}
	},
	renderFeatures : function(data,tileID){
		var features = data.features;
		//没有数据，提示没数据（待处理）
		if(!features){
			return;
		}
		for(var i=0;i<features.length;i++)
		{
			//render feature
			GeometryRender.renderFeature(features[i],Map.map.ctx,tileID);
		}
	},
	initRender : function(){
		TileManager.renderTileArrayFromBbox(Map.map.bbox);
	},
	renderTileProfile : function(tileID)
	{
		var rect = GeoDataMapping.getTileRectFromID(tileID);
		var ctx = Map.map.ctx;
		ctx.save();
		ctx.strokeStyle = "rgba(10, 0, 250, 0.5)";
		ctx.lineWidth = 1;
		ctx.strokeRect(rect.p1.x, rect.p1.y, (rect.p2.x - rect.p1.x), (rect.p2.y - rect.p1.y));
		//ctx.fillStyle = 'rgba(10, 100, 0, 0.1)';
		//ctx.fillRect(rect.p1.x, rect.p1.y, (rect.p2.x - rect.p1.x), (rect.p2.y - rect.p1.y));
		ctx.font = "60px Arial";
		ctx.textAlign = 'left';
		ctx.fillStyle = '#00F';
		ctx.fillText(tileID, rect.p1.x+50, rect.p1.y+50, 400);
		ctx.restore();
	},
	markPoint: function(ctx, x, y, style)
	{
		var t = ctx;
		t.beginPath();
		t.fillStyle = style || 'rgba(0,0,0,0.4)';
		t.arc(x, y, 15, 0, 360, true);
		t.closePath();
		t.fill();	
	},
	renderGeometryStyle: function(ctx, style, type)//type = Polygon || LineString
	{
		W.Utils.extend(ctx, style);
		if(type == 'LineString')
			ctx.stroke();
		else
		{
			ctx.stroke();
			ctx.fill();
		}
	},
	renderTextStyle: function(txt, fontHeight, x, y, angle, ctx)// 以x, y为中心写文本
	{
		ctx.save();
		ctx.beginPath();
		ctx.font = fontHeight+"px 微软雅黑";
		
		ctx.textAlign = 'center';
		ctx.translate(x, y);
		ctx.rotate(angle);
		ctx.scale(1/Map.map.zoom,1/Map.map.zoom);
		ctx.scale(0.9, 0.9);
		//shadow
		ctx.shadowOffsetX = 2;    
		ctx.shadowOffsetY = 2;    
		//hadowBlur：设置阴影模糊程度。此值越大，阴影越模糊。其效果和 Photoshop 的高斯模糊滤镜相同。
		ctx.shadowBlur = 10;    
		//shadowColor：阴影颜色。其值和 CSS 颜色值一致。
		ctx.shadowColor   = 'rgba(0, 0, 0, 0.5)';
		//ctx.shadowColor   = 'rgba(255, 255, 255, 1)';		
		ctx.fillStyle = 'rgba(255,255,255,1)';
		var l = txt.length*fontHeight+4;
		ctx.fillRect(-l/2, -fontHeight/2, l, fontHeight+2);
		ctx.fillStyle = 'rgba(30,30,30,1)';
		ctx.fillText(txt, 0, fontHeight/2, 1000);
		ctx.closePath();
		ctx.restore();
	},
	
	renderText: function(txt, geometry, type, ctx)
	{
		var tp = geometry.textPosition, i, font;
		if(type == 'LineString')
		{
			for(i in tp)
			{
				font = tp[i];
				this.renderTextStyle(txt, 12, font.x, font.y, font.angle, ctx);//字体最小是12
			}
		}
		else if(type == 'Polygon')
			this.renderTextStyle(txt, 12, tp.x, tp.y, 0, ctx);
		else//Point
		{
			var coord = geometry.axeXY;
			this.renderTextStyle(txt, 12, coord[0], coord[1], 0, ctx);
		}
	}
};