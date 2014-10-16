var getTimeInput = null;
$(function(){
	$(".timePicker").focus(function(){
		getTimeInput = $(this);
		$("body").append(
			'<div id="timePickerFrame">'+
				'<div class="mask tp"></div>'+
				'<canvas id="timePicker"></canvas>'+
				'<input type="button" value="OK" id="setTime" class="green_btn" />'+
				'<p id="clockTime"><span class="h">- -</span>:<span class="m">- -</span></p>'+
				'<p id="ampm"><span>AM</span><span>PM</span><i></i></p>'+
				'<img id="close" alt="" src="'+ web_root +'/DayPics/img/widget/close.png" />'+
			'</div>');
		c = $("#timePicker").get(0);
		c.width = 1600;
		c.height = 600;
		t = c.getContext("2d");
		h = $("#clockTime .h").get(0);
		m = $("#clockTime .m").get(0);
		var tp = new TimePicker(80,c.width/2,c.height/2,6,{},{},{},{},t,h,m,getTime);
		tp.setHand(c,"STYLE_2",1);
		
		$("#ampm span").eq(0).mouseover(function(){
			$(this).css("color", "#33CFF6");
			$("#ampm span").eq(1).css("color", "#000");
			$("#ampm i").text("am");
		});
		$("#ampm span").eq(1).mouseover(function(){
			$(this).css("color", "#33CFF6");
			$("#ampm span").eq(0).css("color", "#000");
			$("#ampm i").text("pm");
		});
		
		$("#setTime").click(function(){
			window.event.stopPropagation(); 
			txt = $("#ampm i").text();
			if(txt == "")
			{
				alert("必须选择上午或下午。")
			}
			else
			{
				$("#timePickerFrame").remove();
				document.onclick = null;
				document.onmousemove = null;
			}
		});
		
		$("#close").click(function(){
			window.event.stopPropagation();
			$("#timePickerFrame").remove();
			document.onclick = null;
			document.onmousemove = null;
		});
	});
});

function getTime(t)
{
	if(t.split(":")[0]=="undefined")
	{
		t="--:--"
	}
	txt = $("#ampm i").text();
	if(txt == "pm")
	{
		p = (parseInt(t.substring(0,2),10)+12) + t.substring(2);
		getTimeInput.val(p);
	}
	else
	{
		getTimeInput.val(t);
	}
}

function TimePicker(R,oX,oY,d,f,h,m,s,ctx,hourObj, minuteObj,callback)
{
	//成员属性
	this.R = R || 80;
	this.oX = oX || 200;
	this.oY = oY || 200;
	this.dis = d || 6;
	this.face = {lineClr:f.lClr||"#000",dotClr:f.dClr||"#000"};
	this.hourCount = {count:12,len:h.len||45,width:h.width||1,color:h.color||"#000"};
	this.minCount = {count:60,len:m.len||60,width:m.width||1,color:m.color||"#000"};
	this.secCount = {count:60,len:s.len||70,width:s.width||1,color:s.color||"#000"};
	var q = this;//指向当前类
	this.hour;
	this.minute;
	PI=Math.PI;
	context = ctx;
	//成员方法
	//画钟面
	this.drawFace = function(t)
	{
		t.fillStyle="#FFF";
		t.lineWidth=4;
		t.beginPath();
		t.arc(q.oX,q.oY,q.R+3,0,360,true);
		t.fill();
		t.stroke();
		t.beginPath();
		t.closePath();
		t.fillStyle=q.face.lineClr;
		t.arc(q.oX,q.oY,q.R,0,360,true);
		t.stroke();
		t.closePath();				
	}

	//画点
	this.drawDot = function(count,r,ctx)//count为点数，小时为12，分钟为60
	{
		stp = (2*PI)/count;
		dt = q.R-q.dis;
		ctx.strokeStyle=q.face.dotClr;
		for(var i=0; i<count; i++)
		{
			x=q.oX + dt*Math.cos(0 + i*stp);
			y=q.oY + dt*Math.sin(0 + i*stp);
			ctx.beginPath();
			ctx.arc(x,y,r,0,360,true);
			ctx.fill();
			ctx.closePath();
		}
	}
	//画指针
	/*
		count为点数，小时为12，分钟为60
		i为目前指的步数
		r是指针长度
		ctx是画布上下文环境context
		angel是初始角度偏移量，默认0°是水平方向向右
	*/
	this.drawHand = function(count,i,r,ctx,angel)
	{
		stp = (2*PI)/count;
		x=q.oX+r*Math.cos(angel + i*stp);
		y=q.oY+r*Math.sin(angel + i*stp);
		ctx.beginPath();
		ctx.moveTo(q.oX,q.oY);
		ctx.lineTo(x,y);
		ctx.stroke();
		ctx.closePath();				
	}
	
	//指针停靠
	/*
		count为点数，小时为12，分钟为60
		r是指针长度
		angeloffset是初始角度偏移量，默认0°是水平方向向右
		y指的是鼠标的clienY
	*/
	function handStay(count,r,angeloffset,y)
	{
		for(var i=0; i<count; i++)
		{
			if((y-q.oY<0)&&(Math.abs(angeloffset-i*PI*2/count)<PI/count))
			{
				q.drawHand(count,count/2-i,r,t,PI);
				if(count/4-i<0)
				{
					b = count*5/4-i;
				}
				else
				{
					b = count/4-i;
				}
				break;
			}
			if((y-q.oY>=0)&&(Math.abs(angeloffset-i*PI*2/count)<PI/count))
			{
				q.drawHand(count,i,r,t,0);
				b = i+count/4;
				break;
			}
		}
		return b;
	}

	//跟踪线
	/*
		t是画布上下文环境context
		clr是颜色
		width是宽度
		mx是鼠标的clientX
		my是鼠标的clientY
	*/				
	function traceLine(t ,clr, width, mx, my)
	{
		t.beginPath();
		t.strokeStyle="rgba(255,0,0,0.5)";
		t.lineWidth = 1;
		t.moveTo(q.oX,q.oY);
		t.lineTo(mx,my);
		t.stroke();
	}
	function checkNum(num)
	{
		if(num<10)
		{
			num ="0"+num;
		}
		return num;
	}
	
	//指针选定
	/*
		c是画布DOM对象
		style是选择方式，即一次时分一起选，或先选时针再选分针
		operationType操作类型，即进去页面就选择，或先点一下再选择
	*/
	this.setHand = function(c, style, operationType)
	{
		var mx,my;
		t=context;
		q.drawFace(t);
		q.drawDot(12,2,t);
		q.drawDot(60,1,t);
		q.drawHand(12,0,55,t,-PI/2);
		q.drawHand(60,0,70,t,-PI/2);
		var n=operationType;//要先点一下才开始选时间，则设置n=0;若要进入页面直接选时间，设置n=1
		var h=0, m=0;
		var minFirst = true;
		var clickTimes = 3;
		if(style=="STYLE_2")
		{
			clickTimes = 2;
		}
		document.onclick = function(){
			if(n<clickTimes)
			{
				callback(q.hour+":"+q.minute);
				n++;
			}
			else
			{
				n=operationType;//同上面的n，值要相同
				h=0;
				m=0;
				minFirst = true;
				hourObj.innerText = "--";
				minuteObj.innerText = "--";
			}
		}
		document.onmousemove = function(){
			mx=event.clientX;
			my=event.clientY;
			
			t.clearRect(0,0,c.width,c.height);
			t.strokeStyle="#000";
			q.drawFace(t);
			q.drawDot(12,2,t);
			q.drawDot(60,1,t);
			
			dis = Math.sqrt(Math.pow((my-q.oY),2)+Math.pow((mx-q.oX),2));
			var a = Math.acos((mx-q.oX)/dis);

			if(n==0)
			{
				q.drawHand(12,0,55,t,-PI/2);
				q.drawHand(60,0,70,t,-PI/2);						
			}
			switch(style)
			{
				case "STYLE_1":
					switch(n)
					{
						case 1:
							h = handStay(12,55,a,my);
							hourObj.innerText = checkNum(h);
							q.drawHand(60,m,70,t,-PI/2);
							break;
						case 2:
							if(minFirst)
							{
								q.drawHand(60,0,70,t,-PI/2);
								q.drawHand(12,h,55,t,-PI/2);
								minFirst = false;
								break;
							}
							m = handStay(60,70,a,my);
							minuteObj.innerText = checkNum(m);
							q.drawHand(12*60,h*60+m,55,t,-PI/2);
							break;
						case 3:
							q.drawHand(12*60,h*60+m,55,t,-PI/2);
							q.drawHand(60,m,70,t,-PI/2);
							break;
						default:
							break;
					}
					break;
				case "STYLE_2":
					switch(n)
					{
						case 1:
							h = handStay(12*60,55,a,my);
							q.hour = checkNum(parseInt(h/60));
							hourObj.innerText = q.hour;
							q.drawHand(60,h%60,70,t,-PI/2);
							q.minute =  checkNum(h%60);
							minuteObj.innerText = q.minute;
							break;
						case 2:
							q.drawHand(12*60,h,55,t,-PI/2);
							q.drawHand(60,h%60,70,t,-PI/2);
							break;
						default:
							break;
					}
					break;
				default:
					break;
			}
			traceLine(context ,"rgba(255,0,0,0.5)", 1, mx, my);
		}
	}
}