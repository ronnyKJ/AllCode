var c;
function start()
{
	var d = document;
	c = d.getElementById("cube_container");
	var des = d.getElementById("des");
	var flag = false;
	var tx=0, ty=0;
	var tx1=0, ty1=0;
	var tmpx = 0, tmpy = 0;
	var first = true;
	c.style.webkitTransform = "rotateX("+tx+"deg) rotateY("+ty+"deg)";
	d.onmousemove = function(e)
	{
		if(flag)
		{
			tx1 = e.clientX - tx;
			ty1 = e.clientY - ty;
			tmpx += tx1;
			tmpy += ty1;
			c.style.webkitTransform = "rotateX("+(-tmpy)+"deg) rotateY("+tmpx+"deg)";
			tx = e.clientX;
			ty = e.clientY;
		}
	}
	d.onmouseup = function(e)
	{
		flag = false;
	}
	d.onmousedown = function(e)
	{
		flag = true;
		tx = e.clientX;
		ty = e.clientY;
	}
}

function zoom(x, y, z, axix, obj)
{
	setWebkitAnimation(obj, "zoom", "100%{-webkit-transform:rotateX("+x+"deg) rotateY("+y+"deg) translate"+axix+"("+z+"px);}", "1s", "1", "ease");
	setTimeout(function(){c.style.webkitTransform = "rotateX("+x+"deg) rotateY("+y+"deg) translate"+axix+"("+z+"px)";}, 1000);
}

function setWebkitAnimation(obj, name, animation, time, loop, ease)
{
	if(!window._ANIMATION_INDEX)
	{
		window._ANIMATION_INDEX = {};
	}
	if(window._ANIMATION_INDEX[name] == undefined)
		window._ANIMATION_INDEX[name] = 0;
	
	var anim = document.createTextNode("@-webkit-keyframes " + name + "" + window._ANIMATION_INDEX[name] + "{" + animation + "}");
	var style = document.getElementsByTagName("style")[0];
	style.appendChild(anim);
	obj.style.webkitAnimation = name + "" + window._ANIMATION_INDEX[name] +" " + time + " " + loop + " " + ease;
	if(window._ANIMATION_INDEX[name] > 0)
	{
		var l = style.childNodes.length;
		style.removeChild(style.childNodes[l-2]);
	}
	window._ANIMATION_INDEX[name]++;
}