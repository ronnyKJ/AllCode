function playGallery(url)
{
	//初始化显示图片
	var loading = document.createElement("img");
	loading.alt = "";
	loading.src = web_root+'/DayPics/img/loading.png';
	loading.style.webkitAnimation = "loading 1s infinite linear";
	loading.style.display = "block";
	loading.style.margin = (document.body.clientHeight/2-14) + "px auto";
	
	var mask = document.createElement("div");
	mask.style.position = "fixed";
	mask.style.top = 0;
	mask.style.bottom = 0;
	mask.style.left = 0;
	mask.style.right = 0;
	mask.style.backgroundColor = "rgba(0, 0, 0, 0.6)";
	document.body.appendChild(mask);
	mask.appendChild(loading);
	
	var img = document.createElement("img");
	img.alt = "";
	img.src = url;
	img.style.position = "fixed";
	//img.style.cursor = "move";
	img.onload = function(){
		document.body.appendChild(img);
		
		var cw = document.body.clientWidth;
		var ch = document.body.clientHeight;
		var initW = cw*0.9;
		var initH = ch*0.9;
		var iw = img.width;
		var ih = img.height;
		var newW = iw, newH = ih;
		if(initW<=iw || initH<=ih)
		{
			if(initW/initH <= iw/ih)
			{
				newW = c = initW;
				newH = img.height;
			}
			else
			{
				newH = img.height = initH;
				newW = img.width;
			}
		}

		img.style.top = (ch-newH)/2;
		img.style.left = (cw-newW)/2;
	}
		
	document.onclick = function()
	{
		if(event.target.tagName == "DIV" && img && mask)
		{
			document.body.removeChild(img);
			document.body.removeChild(mask);
			img = null;
			mask = null;
		}
	}
	/*
	//拖动图片
	var cood = document.createElement("span");
	cood.style.position = "fixed";
	cood.style.top = 10;
	cood.style.left = 10;
	cood.style.color = "#FFF";
	cood.innerHTML = "----"
	document.body.appendChild(cood);
	
	var isMouseDown = false;
	document.onmousedown = function()
	{
		isMouseDown = true;
	}
	
	document.onmouseup = function()
	{
		isMouseDown = false;
	}

	document.onmousemove = function()
	{

		if(isMouseDown)
		{
			//cood.innerHTML = event.clientX + " -- " + event.clientY;
			img.style.top = event.clientY - ih/2;
			img.style.left = event.clientX - iw/2;
		}
	}
	//alert(newW + "  " + newH);
	*/
}