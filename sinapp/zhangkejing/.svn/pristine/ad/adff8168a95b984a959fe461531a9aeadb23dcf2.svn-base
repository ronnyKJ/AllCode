var TileManager = {
	tileConfig : {
		tileSize_lon : 0.02,
		tileSize_lat : 0.02,
		tileSize_pixelWidth : 1024,
		tileSize_pixelHeight : 1024,
		tile_scaleX : 51200,
		tile_scaleY : 51200
	},
	tileMap : {
	},
	initialize : function(){
	},
	cacheTile : function(tileID,tile){
		this.tileMap[tileID] = tile;
	},
	//得到某个矩形框占据的切片数组,并绘在canvas里面
	renderTileArrayFromBbox : function(bbox){
		var tileIDArray = this.getTileIDArrayFromBbox(bbox);
		var self = this;
		//--------------- zkj 20120414--------------------
		FeaturesCacheManager.renderedTileCount = 0;
		var l = tileIDArray.length;
		for(var i =0;i<l;i++){
			var tileID = tileIDArray[i];
			var tileMap = this.tileMap[tileID];
			if(tileMap)//数据已缓存
			{
				//绘图
				if(tileMap != 'requesting')
				{
					Map.checkTranslate(function(){
						Render.renderFeatures(tileMap.getGeoData());
						// Render.renderTileProfile(tileID);
					});
		
					//--------------- zkj 20120414--------------------
					FeaturesCacheManager.onRenderTileOver(l);
				}
			}else{
				//根据切片id向服务器请求数据
				self.cacheTile(tileID, 'requesting');
				Data.fetchData(tileID,true,function(data,tID){
					var geoData = {};
					
					if(!data.error){
						geoData = data;
						//第一次绘图,需要处理数据投影和style组装
						Map.checkTranslate(function(){
							Render.processAndRenderFeature(geoData);
							//*****************************
							// Render.renderTileProfile(tID);
							//*****************************
						});
					}
					//地图没数据 no_map_data
					else{
					}
					 
					//缓存tile
					var tile = new Tile({
						bbox : bbox,
						geoData : geoData 
					});
					self.cacheTile(tID, tile);
					//--------------- zkj 20120414--------------------
					FeaturesCacheManager.onRenderTileOver(l);
				});
			}
		}
	},
	//得到某个矩形框占据的切片的id数组
	getTileIDArrayFromBbox : function(bbox){
		var tileIDArray = [];
		var offsetLeft = Math.floor(bbox[0]/this.tileConfig.tileSize_lon),
			offsetBottom = Math.floor(bbox[1]/this.tileConfig.tileSize_lat),
			offsetRight = Math.floor(bbox[2]/this.tileConfig.tileSize_lon),
			offsetTop = Math.floor(bbox[3]/this.tileConfig.tileSize_lat);

		for(var i = offsetLeft-1; i<=offsetRight; i++)
		{
			for(var j = offsetBottom; j<=offsetTop+1; j++)
			{
				tileIDArray.push([i,"_",j].join(""));
			}		
		}
		
		return tileIDArray;
	}
};