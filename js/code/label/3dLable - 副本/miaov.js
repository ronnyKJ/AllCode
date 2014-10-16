var radius = 120;//半径
var dtr = Math.PI/180;//1角度
var d=300;

var mcList = [];//标签对象数组
var active = false;//标记是否进入容器区域
var lasta = 1;
var lastb = 1;
var distr = true;
var tspeed=10;
var size=250;

var mouseX=0;
var mouseY=0;

var howElliptical=1;

var aA=null;
var oDiv=null;

window.onload=function ()
{
	var i=0;
	var oTag=null;
	
	oDiv=document.getElementById('div1');//容器
	
	aA=oDiv.getElementsByTagName('a');//链接集合
	
	for(i=0;i<aA.length;i++)
	{
		oTag={};
		
		//每个标签都是一样的
		oTag.offsetWidth=aA[i].offsetWidth;//获得原始宽度
		oTag.offsetHeight=aA[i].offsetHeight;//获得原始高度
		
		mcList.push(oTag);
	}
	
	sineCosine(0,0,0);
	
	positionAll();
	
	oDiv.onmouseover=function ()
	{
		active=true;
	};
	
	oDiv.onmouseout=function ()
	{
		active=false;
	};
	
	oDiv.onmousemove=function (ev)
	{
		var oEvent=window.event || ev;
		
		//距离容器中心的距离
		mouseX=oEvent.clientX-(oDiv.offsetLeft+oDiv.offsetWidth/2);
		mouseY=oEvent.clientY-(oDiv.offsetTop+oDiv.offsetHeight/2);
		
		//缩小5倍
		mouseX/=5;
		mouseY/=5;
	};
	
	setInterval(update, 30);//关键动画函数
};

function update()
{
	var a;
	var b;
	
	if(active)//鼠标在容器里，根据鼠标与容器中心距离远近，匀速运动
	{
		a = (-Math.min( Math.max( -mouseY, -size ), size ) / radius ) * tspeed;//Y方向速度
		b = (Math.min( Math.max( -mouseX, -size ), size ) / radius ) * tspeed;//X方向速度
	}
	else//鼠标不在容器中，以最后的速度为初速度，减速运动
	{
		a = lasta * 0.98;
		b = lastb * 0.98;
	}
	
	lasta=a;
	lastb=b;
	
	if(Math.abs(a)<=0.01 && Math.abs(b)<=0.01)//方向速度小于0.01，则处于静止
	{
		return;
	}
	
	var c=0;
	sineCosine(a,b,c);
	for(var j=0;j<mcList.length;j++)
	{
		var rx1=mcList[j].cx;
		var ry1=mcList[j].cy*ca+mcList[j].cz*(-sa);
		var rz1=mcList[j].cy*sa+mcList[j].cz*ca;
		
		var rx2=rx1*cb+rz1*sb;
		var ry2=ry1;
		var rz2=rx1*(-sb)+rz1*cb;
		
		var rx3=rx2*cc+ry2*(-sc);
		var ry3=rx2*sc+ry2*cc;
		var rz3=rz2;
		
		mcList[j].cx=rx3;
		mcList[j].cy=ry3;
		mcList[j].cz=rz3;
		
		per=d/(d+rz3);
		
		mcList[j].x=(howElliptical*rx3*per)-(howElliptical*2);
		mcList[j].y=ry3*per;
		mcList[j].scale=per;
		mcList[j].alpha=per;
		
		mcList[j].alpha=(mcList[j].alpha-0.6)*(10/6);
	}
	
	doPosition();//刷新位置
	depthSort();//图层前后顺序排序
}

function depthSort()
{
	var i=0;
	var aTmp=[];
	
	for(i=0;i<aA.length;i++)
	{
		aTmp.push(aA[i]);
	}
	
	aTmp.sort//根据属性cz排序
	(
		function (vItem1, vItem2)
		{
			if(vItem1.cz>vItem2.cz)
			{
				return -1;
			}
			else if(vItem1.cz<vItem2.cz)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
	);
	
	for(i=0;i<aTmp.length;i++)
	{
		aTmp[i].style.zIndex = i;
	}
}

function positionAll()
{
	var phi=0;
	var theta=0;
	var max=mcList.length;
	var i=0;
	
	var aTmp=[];//a的临时数组
	var oFragment=document.createDocumentFragment();
	
	for(i=0;i<aA.length;i++)
	{
		aTmp.push(aA[i]);
	}
	
	aTmp.sort//乱序排列
	(
		function ()
		{
			return Math.random()<0.5?1:-1;
		}
	);
	
	//先存到一个片段中
	for(i=0;i<aTmp.length;i++)
	{
		oFragment.appendChild(aTmp[i]);
	}
	//再放回容器，这样的话省去刷新的步骤，提高效率
	oDiv.appendChild(oFragment);
	
	for(var i=1; i<=max; i++)
	{
		if(distr)
		{
			phi = Math.acos(-1+(2*i-1)/max);
			theta = Math.sqrt(max*Math.PI)*phi;
		}
		else
		{
			phi = Math.random()*(Math.PI);
			theta = Math.random()*(2*Math.PI);
		}
		//坐标变换
		mcList[i-1].cx = radius * Math.cos(theta)*Math.sin(phi);
		mcList[i-1].cy = radius * Math.sin(theta)*Math.sin(phi);
		mcList[i-1].cz = radius * Math.cos(phi);
		
		aA[i-1].style.left=mcList[i-1].cx+oDiv.offsetWidth/2-mcList[i-1].offsetWidth/2+'px';
		aA[i-1].style.top=mcList[i-1].cy+oDiv.offsetHeight/2-mcList[i-1].offsetHeight/2+'px';
	}
}

//将mcList每个标签对象计算后的属性值，赋值给a标签的css属性，刷新UI显示
function doPosition()
{
	var l=oDiv.offsetWidth/2;
	var t=oDiv.offsetHeight/2;
	for(var i=0;i<mcList.length;i++)
	{
		aA[i].style.left=mcList[i].cx+l-mcList[i].offsetWidth/2+'px';//left
		aA[i].style.top=mcList[i].cy+t-mcList[i].offsetHeight/2+'px';//top
		
		aA[i].style.fontSize=Math.ceil(12*mcList[i].scale/2)+8+'px';//字体大小
		
		//透明度
		aA[i].style.filter="alpha(opacity="+100*mcList[i].alpha+")";//IE
		aA[i].style.opacity=mcList[i].alpha;//其他浏览器
	}
}

function sineCosine(a, b, c)
{
	sa = Math.sin(a * dtr);
	ca = Math.cos(a * dtr);
	sb = Math.sin(b * dtr);
	cb = Math.cos(b * dtr);
	sc = Math.sin(c * dtr);
	cc = Math.cos(c * dtr);
}