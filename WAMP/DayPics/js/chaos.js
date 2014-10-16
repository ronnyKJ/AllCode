function test()
{
	var d = document;
	var b = d.body;
	var w = b.clientWidth;
	var h = b.clientHeight;
	var r = Math.random;
	var m = d.getElementById("main");
	var ba = d.getElementById("resume");
	
	wrapEachChar(ba);

	var rdmList = d.getElementsByClassName("rdm");
	var l = rdmList.length;
	for(var i=0; i<l; i++)
	{
		rl = rdmList[i];
		rl.style.position = "relative"; // = "absolute";
		rl.style.top = r()*h; //-r.offsetTop;
		rl.style.left = r()*w; //-r.offsetLeft;
		rl.style.fontSize = r()*26 + 10;
	}
	
	move(rdmList, 0.75, 30, recover);
}

function wrapEachChar(ele)
{
	if(ele.childNodes)
	{
		for(var i=0; i<ele.childNodes.length; i++)
		{
			tmp = ele.childNodes[i];
			if(!(tmp.nodeType == 3 && (tmp.innerText == undefined || tmp.innerHTML == undefined)))
			{
				tn = tmp.childNodes[0];
				if(!tmp.value && tn.nodeValue)
				{
					if(tmp.tagName == "UL" || tmp.tagName == "DIV")//这里是因为UL, DIV之类的会产生换行符，所以tn.nodeValue不为空
					{
						arguments.callee(tmp);
					}
					else
					{
						tmp.innerHTML = "<span class='rdm'>" + tmp.innerText.split("").join("</span><span class='rdm'>") + "</span>";
					}
				}
				else
				{
					arguments.callee(tmp);
				}
			}
		}
	}
}

function move(list, speed, time, callback)
{
	var m = setInterval(function(){
		for(var i=0; i<list.length; i++)
		{
			list[i].style.top = parseInt(list[i].style.top)*speed;
			if(parseInt(list[i].style.top)<=0) list[i].style.top = 0;
			list[i].style.left = parseInt(list[i].style.left)*speed;
			if(parseInt(list[i].style.left)<=0) list[i].style.left = 0;
			list[i].style.fontSize = parseInt(list[i].style.fontSize)*speed*1.2;
			if(parseInt(list[i].style.fontSize)<=10) list[i].style.fontSize = 10;
		}		
	},time);
	
	var s = setInterval(function(){
		for(var i=0; i<list.length; i++)
		{
			if(parseInt(list[i].style.top)>0 || parseInt(list[i].style.left)>0 || parseInt(list[i].style.fontSize)>10)
			{
				break;
			}
		}
		
		if(i == list.length)
		{
			clearInterval(m);
			clearInterval(s);
			callback(list);
		}
	},200);
}

function recover(list)
{
	var l = list.length;
	for(var i=0; i<l; i++)
	{
		list[i].style.position = "";
		list[i].style.top = "";
		list[i].style.left = "";
	};
	for(i=0; i<l; i++)
	{
		var r = list[0];
		var t= document.createTextNode(r.innerText);
		r.parentNode.replaceChild(t, r);
	}
}

//与上面函数相同，代码比较简洁，但是效率比较低，为什么呢？
/* function recover(list)
{
	var l = list.length;
	for(var i=0; i<l; i++)
	{
		r = list[0];
		r.style.position = "";
		r.style.top = "";
		r.style.left = "";
		var t= document.createTextNode(r.innerText);
		r.parentNode.replaceChild(t, r);
	};
} */
