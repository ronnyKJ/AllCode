jQuery.fn.extend({
	pickDate:function(data){
		if(data==null)
		{
			data = {};
		}
		var fd = data.firstday || 0;//星期的第一天
		var sd = data.showDuration || 1;
		var rd = data.removeDuration || 1;
		var ac = true;//自动关闭
		if(data.autoClose == false)
		{
			ac = false;
		}
		/************以上为配置参数设置**************/
		var date = new Date();
		var y = date.getFullYear();
		var m = date.getMonth();
		var d = date.getDate();
		var dpStr = '<div class="mask dp"></div><div class="datePicker"></div>';
		var inStr =	'<div class="back"></div>'+
			'<p class="head"><span class="prevY"></span><span class="prevM"></span><span class="YM">' + y + '年'+(m+1)+'月</span><span class="nextM"></span><span class="nextY"></span></p>'+
			'<p class="week"></p>'+
			'<p class="date"></p>';
		var dp = $(this).after(dpStr).next().next();
		dp.prepend(inStr);
		dp.find(".week").prepend(setWeek(fd));
		dp.find(".week b:last").css("margin-right","-3px");
		
		//刷新显示日期
		function showDate(d, f, t, fun)
		{
			var p = new Date(d);
			dp.find(".date").empty();
			drawDate(d, f, t);
			dp.find(".date").append(dateStr);
			dp.find(".back").height(dp.height()+1);
			dp.find(".date span").click(function(){
				var para = new Date(p);
				para.setMonth(para.getMonth()+1);
				if($(this).attr("class")=="lastM")
				{
					para.setMonth(para.getMonth()-1);
				}
				if($(this).attr("class")=="followM")
				{
					para.setMonth(para.getMonth()+1);
				}
				para.setDate(parseInt($(this).text(),10));
				fun(para);
			});
		}

		showDate(date, fd, date.getDate(), returnDate);
		date = new Date();//date被改变了，重新定义一次
		dp.find(".prevY").click(function(){
			pY = setYM(date, "year", -1);
			dp.find(".YM").text(date.getFullYear()+"年"+(date.getMonth()+1)+"月");
			showDate(new Date(pY), fd, ifThisMonth(pY, new Date()), returnDate);
		});
		dp.find(".nextY").click(function(){
			nY = setYM(date, "year", 1);
			dp.find(".YM").text(date.getFullYear()+"年"+(date.getMonth()+1)+"月");
			showDate(new Date(nY), fd, ifThisMonth(nY, new Date()), returnDate);
		});
		dp.find(".prevM").click(function(){
			pM = setYM(date, "month", -1);
			dp.find(".YM").text(date.getFullYear()+"年"+(date.getMonth()+1)+"月");
			showDate(new Date(pM), fd, ifThisMonth(pM, new Date()), returnDate);
		});
		dp.find(".nextM").click(function(){
			nM = setYM(date, "month", 1);
			dp.find(".YM").text(date.getFullYear()+"年"+(date.getMonth()+1)+"月");
			showDate(new Date(nM), fd, ifThisMonth(nM, new Date()), returnDate);
		});
		dp.fadeIn(sd);
		
		//鼠标点击在日历之外的时候，remove日历
		if(ac)
		{
			var t = $(this);
			$(document).click(function(e){
				var event = window.event || e;
				var ele = event.srcElement || event.target;
				if(ele.className == "mask dp")
				{
					t.removeDate(rd);
				}
			});
		}
		
		//功能函数
		function setYM(date, YM, add)
		{
			if(YM=="year")
			{
				date.setYear(date.getFullYear()+add);
			}
			if(YM=="month")
			{
				date.setMonth(date.getMonth()+add);
			}
			return date;
		}

		function drawDate(date, startday, today)
		{
			var monthDays=["31","28","31","30","31","30","31","31","30","31","30","31"];
			dateStr = "";
			m = date.getMonth();
			if(m==1)//二月
			{
				if(ifLeapYear(y))
				{
					m=29;
				}			
			}
			date.setDate(1);
			var firstDay = date.getDay();//一个星期的第一天是周几
			var lastMonthDays = firstDay-startday;
			if(lastMonthDays<0)
			{
				lastMonthDays+=7;
			}
			for(var i=0; i<lastMonthDays; i++)//上个月
			{
				date.setDate(date.getDate()-1);
				dateStr = '<span class="lastM">'+date.getDate()+'</span>'+dateStr;
			}
			for(i=0; i<monthDays[m]; i++)//本月
			{
				if(i!=today-1)
				{
					dateStr += '<span>'+(i+1)+'</span>';
				}
				else
				{
					dateStr += '<span class="today">'+(i+1)+'</span>';
				}
			}
			var nextMonthDays = 7-(parseInt(monthDays[m],10)+lastMonthDays)%7;
			for(i=0; i<nextMonthDays; i++)//下个月
			{
				dateStr += '<span class="followM">'+(i+1)+'</span>';
			}
		}

		//判断闰年
		function ifLeapYear(y)
		{
			if(y%100==0 && y%400==0)
			{
				return true;
			}
			else if(y%4==0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		//判断是否本月
		function ifThisMonth(other, now)
		{
			if(other.getFullYear()==now.getFullYear() && other.getMonth()==now.getMonth())
			{
				return now.getDate();
			}
			return -1;
		}

		//设置星期排序
		function setWeek(firstday)
		{
			var week = ["日","一","二","三","四","五","六"];
			s = "";
			f = firstday || 0;
			for(var j=0; j<7; j++)
			{
				if(f>=7)f-=7;
				s += "<b>"+week[f++]+"</b>";
			}
			return s;
		}
	},
	
	removeDate:function(duration){
		if($(this).next().next().attr("class") == "datePicker")
		{
			d = duration || 1;
			mask = $(this).next();
			mask.next().fadeOut(d,function(){
				mask.next().remove();
				mask.remove();
			});
		}
		else
		{
			alert("还没添加datePicker");
		}
	}
})