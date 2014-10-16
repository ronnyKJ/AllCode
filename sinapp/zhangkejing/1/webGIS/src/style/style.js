var Style = {
	initialized :false,
	//样式表名称
	stylesheet_map :{
		"normal_style" : normal_geoCss
	},
	//各种样式object
	styles_object: {
	
	},
	/**	
	 *	从样式表中读取geoCss代码
	 *
	 * @param {string} 样式名称
	 *
	 */
	initialize : function(styleName){
		if(this.stylesheet_map[styleName]){
			this.styles_object = this.stylesheet_map[styleName];
			this.initialized = true;
		}
		else{
			this.initialized = true;
			alert("样式不存在");
		}
	},
	/**	
	 *	给每个feature添加style属性
	 *
	 * @param {object} feature object
	 * @return {object} 返回的feature，其中加入了style属性，用于渲染feature
	 */
	restyle : function(feature){
		if(!this.initialized){
			alert("style属性没初始化");
			return;
		}
		var new_feature = feature,
			feature_style = {},
			tags = feature.properties,
			type ,
			styleKey ="",
			hasStyled = false,
			hasName = false;
			
		//基础类型分类
		if (feature.geometry.type === 'Polygon' || feature.geometry.type === 'MultiPolygon') {
			type = 'area';
		} else if (feature.geometry.type === 'LineString' || feature.geometry.type === 'MultiLineString') {
			type = 'way';
		} else if (feature.geometry.type === 'Point' || feature.geometry.type === 'MultiPoint') {
			type = 'node';
		}
		styleKey =type;
		if(type=="node"){
			feature_style = W.Utils.extend({},feature_style,this.styles_object[styleKey]);
			//细化类型
			for(var key in tags){
				//有name则加上text属性
				if(key == "name"){
					feature_style.text = tags["name"];
					hasName = true;
				}
			}
		}else{
			//细化类型
			for(var key in tags){
				var tmpKey=styleKey;
				if(!tags[key]){
					tmpKey += "["+key+"]";
				}else{
					tmpKey += "["+key+"="+tags[key]+"]";
				}
				
				//有name则加上text属性
				if(key == "name"){
					feature_style.text = tags["name"];
					hasName = true;
					if(hasStyled){
						break;
					}
				}
				//加上style
				if(this.styles_object[tmpKey]){
					feature_style = W.Utils.extend({},feature_style,this.styles_object[tmpKey]);
					styleKey = tmpKey;
					hasStyled = true;
					if(hasName){
						break;
					}
				}
			}
		}
		
		//将feature_style 属性加入feature对象并返回
		new_feature.style = feature_style;
		return new_feature;
	}
}
