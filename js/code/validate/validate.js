//ajax yet, password confirm
Validate = 
{
items: [],
setItems: function(items)
{
	Validate.items = items;
	Validate.bindEvent();
},

check: function()
{
	var items = Validate.items;
	var i=0, l=items.length, bit = true;
	for(;i<l;i++)
	{
		var ele = items[i]["element"], reg = items[i]["pattern"];
		if(!reg.test(ele.value))
		{
			Validate.error(items[i]);
			bit = false;
		}
	}
	
	return bit;
},

error: function(item)
{
	// need to overwrite yourself
	var ele = item["element"];
	if(!(ele.nextSibling && ele.nextSibling.getAttribute("validateerror")))//has msg
	{
		var n = document.createElement("span");
		n.innerText = item["msg"];
		n.setAttribute("validateerror", true);
		n.className = "validateError";
		n.style.color = "#F00";
		Validate.utility.after(ele, n);
	}
},

submit: function()
{
	Validate.utility.removeErrorMsg();
	var r = Validate.check();
	return false;
},

bindEvent: function()
{
	var items = Validate.items;
	var i=0, l=items.length;
	for(;i<l;i++)
	{
		var ele = items[i]["element"];
		ele.addEventListener(items[i].eventType||"blur", function(){
			Validate.utility.removeErrorMsg();
			Validate.check();
		}, false);
	}	
},

utility: 
{
	_: function(id) //get element by id
	{
		return document.getElementById(id);
	},
	after: function(ele, node) // insert after
	{
		var p = ele.parentNode;
		if(ele === p.lastChild)
		{
			p.appendChild(node);
		}
		else
		{
			p.insertBefore(node, ele.nextSibling);
		}
	},
	removeErrorMsg: function()
	{
		var errs = document.getElementsByClassName("validateError");
		if(!errs.length) return;
		var l = errs.length;
		var child;
		while(l--)
		{
			child = errs[0];
			child.parentNode.removeChild(child);
		}
	}
}
}