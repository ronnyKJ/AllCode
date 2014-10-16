jQuery.fn.extend({
schema:function(data){
	container = $(this);
	if(container.size()==0)
	{
		return;
	}
	$(this).css({
		"position": "relative",
		"font-family": "Tahoma, '微软雅黑'"
	});
	var c = container.append('<canvas>浏览器不支持Canvas...</canvas>').find("canvas").get(0);
	/**************************************************************************数据数组******************************/
	event = data.event||[];
	items = data.items||[];
	histogram = {
		/**************************************************************************图标类型*****************************/
		type : data.type||'hitso',
		maxOutline : data.maxOutline||false,//是否分组边框描绘
		/**************************************************************************柱状图*****************************/
		bgColor : data.bgColor||"#fffefa",//柱状图背景色
		borderColor : data.borderColor||"#888",//柱状图边框颜色
		borderWidth : data.borderWidth||1,//柱状图边框大小
		marginLeft : data.marginLeft||60,//柱状图左边距
		marginRight : data.marginRight||60,//柱状图右边距
		marginBottom : data.marginBottom||40,//柱状图底边距
		marginTop : data.marginTop||40,//柱状图顶边距
		width : data.width||540,//柱状图宽度
		height : data.height||240,//柱状图高度
		/***************************************************************************画布******************************/
		canvasBgColor : data.canvasBgColor||"#DDD",//画布背景颜色
		/****************************************************************************分组*****************************/
		groupSum : event.length,//分组总数
		groupBorderColor : data.groupBorderColor||'red',//分组边框颜色
		groupBorderWidth : data.groupBorderWidth||0.1,//分组边框宽度
		groupWidth : data.groupWidth||50,//组宽度
		histoSum : event[0].length-1,//组内柱总数
		/****************************************************************************刻度标尺梯度****************************/
		maxGraduation : data.maxGraduation||10,//最大刻度
		graduationLevel : data.graduationLevel||5,//梯度
		graduationColor : data.graduationColor||'#BBB',//等高线颜色
		graduationWidth : data.graduationWidth||0.2,//等高线粗细

		/*****************************************************************************柱****************************/
		histoWidth : data.histoWidth||10,//柱宽度
		histoColor : data.histoColor||['#ff4848', '#fff04a', '#49ffdf', '#4c48ff'],//柱颜色
		/*****************************************************************************曲线图***************************/
		diagramColor : data.diagramColor||"blue",//曲线图曲线颜色
		diagramWidth : data.diagramWidth||3,//曲线图曲线宽度
		diagramNodeColor : data.diagramNodeColor||"blue",//曲线节点颜色
		diagramNodeRadium : data.diagramNodeRadium||3,
		/*****************************************************************************坐标定位***************************/
		groupX : [],
		groupY : [],//已经定义为二维数组，存储所有高度
		histoX : [],
		/*****************************************************************************色块标记***************************/
		histoNoteWidth : data.histoNoteWidth||12,//色块标记宽度
		histoNoteHeight : data.histoNoteHeight||10,//色块标记高度
		histoNoteMarginLeft : data.histoNoteMarginLeft||6,//色块标记左边距
		histoNoteMarginRight : data.histoNoteMarginRight||8,//色块标记右边距
		histoNoteMarginTop : data.histoNoteMarginTop||8,//色块标记顶边距
		histoNoteMarginBottom : data.histoNoteMarginBottom||8,//色块标记底边距
		/*****************************************************************************文字说明***************************/
		leftCharNum : data.leftCharNum||4,//左侧文字字符个数
		bottomCharWidth : data.bottomCharWidth||'auto',//底侧文字字符宽度
		leftWord : data.leftWord||"(单位)",//左侧文字说明
		bottomWord : data.bottomWord||"(阶段)",//底侧文字说明
		leftWordMarginRight : data.leftWordMarginRight||6,//左侧文字右边距
		bottomWordMarginTopSpace : data.bottomWordMarginTopSpace||10,//底侧文字顶边距
		bottomWordMarginRight : data.bottomWordMarginRight||40,//底侧文字右边距
		/*****************************************************************************其它依赖属性***************************/
		otherAttr : function(){
			this.canvasWidth = this.width+this.marginLeft+this.marginRight;//画布宽度
			this.canvasHeight = this.height+this.marginTop+this.marginBottom;//画布高度
			this.Xaxle = this.canvasHeight-this.marginBottom;//柱状图X轴位置
			this.unit = this.height/this.maxGraduation;//单位高度
			this.groupSpace = this.width/this.groupSum;
			this.histoSpace = this.groupWidth/this.histoSum;
			this.leftWordMarginLeft = this.canvasWidth-this.marginLeft+this.leftWordMarginRight;//左侧文字左边距
			this.leftWordMarginTop = this.marginTop-30;//左侧文字顶边距
			this.bottomWordMarginTop = this.bottomWordMarginTopSpace+this.Xaxle;//底侧文字底边距
		}
	}
	//画布属性
	function setCanvasAttr(c, bgColor, width, height)
	{
		c.style.background = bgColor;//画布背景颜色
		c.width = width;//画布宽度
		c.height = height;//画布高度
	}
		
	function draw(canvasDOM)
	{
		ctx=canvasDOM.getContext("2d");
		with(ctx){
			//图背景
			fillStyle = histogram.bgColor;
			fillRect(histogram.marginLeft, histogram.marginTop,  histogram.width, histogram.height);
			//等高线
			heightStep = histogram.height/histogram.graduationLevel;
			beginPath();
			strokeStyle = histogram.graduationColor;
			lineWidth = histogram.graduationWidth;
			for(var i=1; i<histogram.graduationLevel; i++){
				a = heightStep*i+histogram.marginTop;
				moveTo(histogram.marginLeft,a);
				lineTo(histogram.marginLeft + histogram.width,a);
			}
			stroke();
			//等高线左侧数字
			var w = container.width($(canvas).width()).width();
			positionStep = histogram.height/histogram.graduationLevel;
			graduationStep = histogram.maxGraduation/histogram.graduationLevel
			for(var k=0; k<=histogram.graduationLevel; k++)
			{
				var tmp_l = (k*graduationStep).toString();
				container.prepend('<span>' + tmp_l.substring(0,histogram.leftCharNum) + '</span>');
				var l = container.find("span").eq(0).height()/2;
				container.find("span").eq(0).css({
					right:(w-histogram.marginLeft+histogram.leftWordMarginRight)+"px",
					top:(histogram.Xaxle-k*positionStep-l)+"px"
				});
			}

			//柱状描绘
			for(var g=0; g<histogram.groupSum; g++)
			{
				if(g==0)
				{
					histogram.groupX[g] = histogram.groupSpace/2-histogram.groupWidth/2+histogram.marginLeft;
				}
				else
				{
					histogram.groupX[g] = histogram.groupX[g-1]+histogram.groupSpace;
				}
				
				histogram.groupY[g] = [];
				
				maxStr="";
				for(var h=0; h<histogram.histoSum; h++)
				{
					if(h==0)
					{
						histogram.histoX[h] = histogram.histoSpace/2-histogram.histoWidth/2+histogram.groupX[g];
					}
					else
					{
						histogram.histoX[h] = histogram.histoX[h-1]+histogram.histoSpace;
					}

					histoHeight=event[g][h+1]*histogram.unit;
					//柱状图
					if(histogram.type=='histo'||histogram.type=='both')
					{
						fillStyle = histogram.histoColor[h];
						fillRect(histogram.histoX[h], histogram.Xaxle-histoHeight, histogram.histoWidth, histoHeight);
					}
					//曲线图
					if(histogram.type=='diagram'||histogram.type=='both')
					{
						histogram.groupY[g][h] = histoHeight;//将高度全部保存在二维数组
						if(g>0)
						{
							//画线
							beginPath();
							strokeStyle = histogram.histoColor[h];
							lineWidth = histogram.diagramWidth;
							moveTo(histogram.groupX[g-1]+histogram.groupWidth/2,histogram.Xaxle-histogram.groupY[g-1][h]);
							lineTo(histogram.groupX[g]+histogram.groupWidth/2,histogram.Xaxle-histogram.groupY[g][h]);
							stroke();
							//节点
							fillStyle = histogram.histoColor[h];
							beginPath();
							arc(histogram.groupX[g]+histogram.groupWidth/2, histogram.Xaxle-histogram.groupY[g][h], histogram.diagramNodeRadium, 0, 360, false); 
							fill();	
							maxStr += histogram.groupY[g][h] + ",";							
						}
						else
						{
							fillStyle = histogram.histoColor[h];
							beginPath();
							arc(histogram.groupX[0]+histogram.groupWidth/2, histogram.Xaxle-histogram.groupY[0][h], histogram.diagramNodeRadium, 0, 360, false);
							fill();
							maxStr += histogram.groupY[0][h] + ",";
						}
					}
				}
				
				//下侧文字描述
				container.prepend('<span>' + event[g][0] + '</span>');
				var e = container.find("span").eq(0);
				e.css({
					left:(histogram.groupX[g]-e.width()/2+histogram.groupWidth/2)+"px",
					top:(histogram.Xaxle+histogram.bottomWordMarginTopSpace)+"px",
					width:histogram.bottomCharWidth
				});
				//分组边框描绘
				if(histogram.maxOutline == true)
				{
					strokeStyle = histogram.groupBorderColor;
					lineWidth = histogram.groupBorderWidth;
					maxHeight = eval("Math.max(" + maxStr + "0)");
					strokeRect(histogram.groupX[g], histogram.Xaxle-maxHeight, histogram.groupWidth, maxHeight);
				}
			}
			//图外边框
			strokeStyle = histogram.borderColor;
			lineWidth = histogram.borderWidth;
			strokeRect(histogram.marginLeft, histogram.marginTop,  histogram.width, histogram.height);
			
			//色块标记柱状图
			for(var it=0; it<histogram.histoSum; it++)
			{
				fillStyle = histogram.histoColor[it];
				var t_x = histogram.canvasWidth-histogram.histoNoteMarginRight-histogram.histoNoteWidth;
				var t_y = histogram.marginTop+it*(histogram.histoNoteHeight+histogram.histoNoteMarginBottom);
				fillRect(t_x, t_y, histogram.histoNoteWidth, histogram.histoNoteHeight);
				container.prepend('<span>' + items[it] + '</span>');
				var n = container.find("span").eq(0);
				n.css({
					right:(histogram.histoNoteMarginLeft+histogram.histoNoteWidth+histogram.histoNoteMarginRight)+"px",
					top:(t_y+histogram.histoNoteHeight/2-n.height()/2)+"px"
				});
			}
			container.prepend('<span style="right:' + histogram.leftWordMarginLeft + 'px; top:' + histogram.leftWordMarginTop + 'px;">' + histogram.leftWord + '</span>');
			container.prepend('<span style="right:' + histogram.bottomWordMarginRight + 'px; top:' + histogram.bottomWordMarginTop + 'px;">' + histogram.bottomWord + '</span>');
			}
	}
	histogram.otherAttr();
	setCanvasAttr(c, histogram.canvasBgColor, histogram.width+histogram.marginLeft+histogram.marginRight, histogram.height+histogram.marginTop+histogram.marginBottom);
	draw(c);

	$(this).find("span").css({
		"position": "absolute", 
		"font-size": "12px",
		"color": "#555"
	});
}
})
