function notZero(num)
{
	if(num==0)
	{
		num=1;
	}
	return num;
}

jQuery.fn.extend({
	addTips:function(data){
		if($(this).next().attr("class") == "tips")
		{
			//alert("已存在一个Tip，不能再添加了");
			return;
		}
		var width = data.width || 200;
		var bgLeft = -28;
		var bgTop = data.offset || 5;
		var margin = "0";
		var opacity = data.opacity || 0.8;
		var showDuration = notZero(data.showDuration) || 500;
		var hideDuration = notZero(data.hideDuration) || 500;
		var position = data.position || "right";
		var rmv = true;
		if(data.removeAfterHidden == false)
		{
			rmv = false;
		}
		btm = "";
		nobg = "";
		switch(position)
		{
			case "right":
				bgLeft = -28;
				bgTop = data.offset || 5;
				l = $(this).width()+"px";
				t = "-"+($(this).height()+18)+"px";
				tmp = t + " 0 0 " + l;
				margin = data.margin || tmp;
				break;
			case "left":
				bgLeft = width+12;
				bgTop = data.offset || 5;
				l = "-"+(width+17)+"px";
				t = "-"+($(this).height()+18)+"px";
				tmp = t + " 0 0 " + l;
				margin = data.margin || tmp;
				break;
			case "bottom":
				bgLeft = data.offset;
				bgTop = -24;
				margin = data.margin || "-4px 0 0 -15px";
				break;
			case "top":
				nobg = "background-image:none;"
				btm = '<p style="background:url(' + web_root + '/DayPics/img/widget/tips.png) no-repeat ' + (width-35) + 'px 0px; height:13px"></p>';
				margin = data.margin || "0";				
				break;
			default:
				break;
		}
		var ele = '<div class="tips" style="background-position:' + bgLeft + 'px ' + bgTop + 'px; width:' + width + 'px; ' + 
				nobg + 'margin:' + margin +';opacity: ' + opacity + ';"><p class="word">' + data.word + '</p>' + btm + 
			'</div>';
		//alert(ele);
		tip = $(this).after(ele).next();
		tip.fadeIn(showDuration,function(){
			if(data.stayDuration=="neverHide")
			{
				return;
			}
			else
			{
				d = notZero(data.stayDuration) || 3000;
				setTimeout(function(){
					tip.fadeOut(hideDuration,function(){
						if(rmv)
						{
							tip.remove();
						}
					});
				},d);
			}
		});
	},
	showTips:function(duration){
		if($(this).next().attr("class") == "tips")
		{
			$(this).next().fadeIn(duration);
		}
		else
		{
			alert("还没添加Tips");
		}
	},
	hideTips:function(duration){
		if($(this).next().attr("class") == "tips")
		{
			$(this).next().fadeOut(duration);
		}
		else
		{
			alert("还没添加Tips");
		}
	},
	removeTips:function(duration){
		if($(this).next().attr("class") == "tips")
		{
			d = duration || 1;
			n = $(this).next();
			n.fadeOut(d,function(){
				n.remove();
			});
		}
		else
		{
			alert("还没添加Tips");
		}
	}
});