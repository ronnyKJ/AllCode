V = {
	_: function(id)
	{
		return document.getElementById(id);
	},
	usernameReg: /^[a-zA-Z0-9_]{6,30}$/i,
	passwordReg: /^[a-zA-Z0-9]{6,20}$/i,
	emailReg: /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/i,
	errorMsg: function(msg, ele)
	{
		var e = document.createElement('span');
		e.innerText = msg;
		e.className = "validateError";
		ele.parentNode.appendChild(e);	
	},
	validate: function(ele, reg)
	{
		ele.onblur = function()
		{
			if(!reg.test(ele.value))//error
			{
				V.errorMsg("Format not correct.", ele);
				V.result[ele.id] = false;
			}
			else
			{
				V.result[ele.id] = true;
				if(ele.id == "username")
				{
					V.checkName(ele);
				}
			}
		};
		
		ele.onfocus = function()
		{
			var p = ele.parentNode;
			if(p.childNodes.length > 1)
			{
				p.removeChild(p.lastChild);
			}
		}
	},
	confirm: function(p, c)
	{
		c.onblur = function()
		{
			if(p.value != c.value)// different
			{
				V.errorMsg("Confirm password is different.", c);
				V.result[c.id] = false;
			}
			else
			{
				V.result[c.id] = true;
			}			
		};
		
		c.onfocus = function()
		{
			var p = c.parentNode;
			if(p.childNodes.length > 1)
			{
				p.removeChild(p.lastChild);
			}
		}
	},
	result: {},
	submit: function(form)
	{
		form.onsubmit = function()
		{
			var r = true;
			for(var i in V.result)
			{
				if(!(r = V.result[i]))
				{
					alert("Fill the form correctly.");
					break;
				}
			}
			return r;
		};
	},
	ajax: function(para)
	{
		var request = null;
		if(window.XMLHttpRequest)
		{
			request = new XMLHttpRequest();
		}
		else
		{
			request = new ActiveXObject("Microsoft.XMLHttp");
		}
		
		if(request)
		{
			request.open(para.type, para.url, para.asyn||false);
			if(para.type == "POST")
			{
				request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");//post提交，这个语句一定要有,否则客户端就有可能出现乱码的情况
			}
			request.send(para.data);
			setTimeout(function(){//设置超时
				if(!(request.readyState == 4 && request.status == 200))
				{
					para.fail(request.readyState, request.status);
				}
			}, para.timeout||500);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200)
				{
					para.callback(request.responseText);
				}
			}
		}
	},
	checkName: function(ele)
	{
		V.ajax({
			type: "POST",
			url: web_action + "/checkNameAjax",
			asyn: true,
			data: "username="+ele.value,
			callback: function(msg)
			{
				if(msg == 1)
				{
					V.errorMsg("User name exists.", ele);
					V.result['username'] = false;
				}
			}
		});	
	}
};

(function()
{
	if(user_action == "register")
	{
		var name = V._('username');
		V.validate(name, V.usernameReg);
	}
	var pswd = V._('password');
	var cnfm = V._('confirm');
	var email = V._('email');
	var form = V._('userForm');
	
	V.result = 
	{
		username: false, password: false, confirm:false, email: false
	};
	
	V.validate(pswd, V.passwordReg);
	V.confirm(pswd, cnfm);
	V.validate(email, V.emailReg);
	V.submit(form);
})();