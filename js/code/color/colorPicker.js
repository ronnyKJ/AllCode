function ColorFormat(r, g, b)
{
	if(typeof r != "string")
	{
		this.r = r;
		this.g = g;
		this.b = b;
	}
	else
	{
		var tmp = r.split(/[()]/g);
		var rgb = tmp[1].split(",");
		this.r = parseInt(rgb[0]);
		this.g = parseInt(rgb[1]);
		this.b = parseInt(rgb[2]);
	}
	this.toString = function(rad)
	{
		if(rad==16)
		{
			var r = this.r.toString(16);
			if(this.r<10)
				var r = "0"+this.r.toString(16);
			var g = this.g.toString(16);
			if(this.g<10)
				var g = "0"+this.g.toString(16);
			var b = this.b.toString(16);
			if(this.b<10)
				var b = "0"+this.b.toString(16);
			return "#"+r+g+b;
		}
		else
		{
			return "rgb("+this.r+", "+this.g+", "+this.b+")";
		}
	}
}

function RGB()
{
	this.hueArray = [];
	var group = [[2, 1, 0], [-1, 2, 0],[0, 2, 1],[0, -1, 2],[1, 0, 2],[2, 0, -1]];
	for(var i=0; i<group.length; i++)
	{
		for(var j=0; j<256/4; j++)
		{
			var value = {};
			for(var k=0; k<3; k++)
			{
				if(group[i][k]==2)
				{
					value[k] = 255;
				}
				else if(group[i][k]==1)
				{
					value[k] = j*4;
				}
				else if(group[i][k]==-1)
				{
					value[k] = 255 - j*4;
				}
				else
				{
					value[k] = 0;
				}			
			}	
			this.hueArray.push(value);
		}
	}
	
	this.getHueArray = function()
	{
		return this.hueArray;
	}
	
	this.getHueElements = function(func)
	{
		func(this.hueArray);
	}
	
	this.getBright = function(hueRgb, x, y)
	{
		var r = Math.floor(y/255*hueRgb.r);
		var g = Math.floor(y/255*hueRgb.g);
		var b = Math.floor(y/255*hueRgb.b);
		var max = Math.max(r, g, b);
		var r1 = Math.floor(x/255*(max-r)+r);
		var g1 = Math.floor(x/255*(max-g)+g);
		var b1 = Math.floor(x/255*(max-b)+b);
		var rgb = new ColorFormat(r1, g1, b1);
		return rgb;
	}
	
	this.getHueRgb = function(i)
	{
		return new ColorFormat(this.hueArray[i][0], this.hueArray[i][1], this.hueArray[i][2]);
	}
}

function Bright(obj)
{
	this.element = obj;
	this.setColor = function(color)
	{
		obj.style.backgroundColor = color;
	}
	
	this.returnColor = function()
	{
		obj.onmousemove = function()
		{
			var x = (255 - event.clientX + this.offsetLeft);
			var y = (255 - event.clientY + this.offsetTop);
			window.color = rgb.getBright(tmpHue, x, y);
			var colorDiv = _("curColor");
			colorDiv.style.backgroundColor = color.toString();
			hsb.s = Math.floor(100 - x/255*100)+"%";
			hsb.b = Math.floor(y/255*100)+"%";			
			var data = {};
			data.nowColor = {};
			data.nowColor.color = color;
			data.nowColor.color16 = color.toString(16);
			data.nowColor.hsb = hsb;
			data.beforeColor = {};
			data.beforeColor.color = beforeColor;
			data.beforeColor.color16 = beforeColor.toString(16);
			data.beforeColor.hsb = tmpHsb;			
			getColorData(data);
		}
	}
	
	this.clickColor = function()
	{
		obj.onclick = function()
		{
			_("cursor2").style.top = event.clientY - this.offsetTop - 7;
			_("cursor2").style.left = event.clientX - this.offsetLeft - 8;
			window.beforeColor = window.color;
			var colorDiv = _("prevColor");
			colorDiv.style.backgroundColor = color.toString();
			tmpHsb.h = hsb.h;
			tmpHsb.s = hsb.s;
			tmpHsb.b = hsb.b;
			
			var data = {};
			data.nowColor = {};
			data.nowColor.color = color;
			data.nowColor.color16 = color.toString(16);
			data.nowColor.hsb = hsb;
			data.beforeColor = {};
			data.beforeColor.color = beforeColor;
			data.beforeColor.color16 = beforeColor.toString(16);
			data.beforeColor.hsb = tmpHsb;			
			getColorData(data);
		}
	}
}

function HueContainer(obj)
{
	this.element = obj;
	this.returnHue = function(func1, func2)
	{
		obj.onmousemove = function()
		{
			var x = Math.floor((event.clientX - this.offsetLeft)/2);
			var color = rgb.getHueArray()[x];
			var c = new ColorFormat(color[0],color[1],color[2]).toString();
			func1(c);
			func2(c);
		}
	}
	this.clickHue = function()
	{
		obj.onclick = function()
		{
			_("cursor1").style.top = event.clientY - this.offsetTop - 7;
			_("cursor1").style.left = event.clientX - this.offsetLeft - 8;
			_("cursor2").style.top = -7;
			_("cursor2").style.left = -8;
			_("curColor").style.backgroundColor = "#FFF";
			var br = new Bright(_("bright"));
			tmpHue = new ColorFormat(currentHue.toString());
			br.setColor(currentHue.toString());
			hsb.h = Math.floor((event.clientX - this.offsetLeft)/parseInt(obj.clientWidth)*360);
		}
		
		obj.onmouseout = function()
		{
			var br = new Bright(_("bright"));
			br.setColor(tmpHue.toString());
		}
	}
}

function _(id)
{
	return document.getElementById(id);
}

function setText(id, text)
{
	_(id).innerText = text;
}

function getHueSpan(arr)
{
	var currentHue;
	var h = _("hue");
	for(var i=0; i<arr.length; i++)
	{
		var e = document.createElement("span");
		var value = arr[i];
		currentHue = new ColorFormat(value[0], value[1], value[2]);
		e.style.backgroundColor = currentHue.toString();
		h.appendChild(e);
	}
}

function setCurHue(hue)
{
	currentHue = new ColorFormat(hue);
}

function getColorData(data)
{
	//_("des").innerHTML = color;
	setText("n_h", data.nowColor.hsb.h);
	setText("n_s", data.nowColor.hsb.s);
	setText("n_br", data.nowColor.hsb.b);
	setText("n_r", data.nowColor.color.r);
	setText("n_g", data.nowColor.color.g);
	setText("n_b", data.nowColor.color.b);
	setText("n_16", data.nowColor.color16);
	
	setText("b_h", data.beforeColor.hsb.h);
	setText("b_s", data.beforeColor.hsb.s);
	setText("b_br", data.beforeColor.hsb.b);
	setText("b_r", data.beforeColor.color.r);
	setText("b_g", data.beforeColor.color.g);
	setText("b_b", data.beforeColor.color.b);
	setText("b_16", data.beforeColor.color16);
}

function start()
{
	window.beforeColor = new ColorFormat(0,0,0);
	window.tmpHue = new ColorFormat(255,0,0);
	window.currentHue = new ColorFormat(0,0,0);
	window.hsb = {h:0, s:"0%", b:"100%"};
	window.tmpHsb = {h:0, s:"0%", b:"100%"};
	
	window.rgb = new RGB();
	rgb.getHueElements(getHueSpan);
	var bright = new Bright(_("bright"));
	bright.setColor("#F00");
	var hue = new HueContainer(_("hue"));
	hue.clickHue();
	hue.returnHue(bright.setColor, setCurHue);
	bright.returnColor();
	bright.clickColor();

	_("prevColor").style.backgroundColor = "#FFF";
	_("curColor").style.backgroundColor = "#FFF";
}