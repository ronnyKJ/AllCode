
var Desktop=null;
var Taskbar=null;

function Write(msg)
{
	OutputPanel.Write(msg);
}

function IsNull(val,alt)
{
	return (val == undefined || val == null) ? alt : val;
}

function Exception(name,msg)
{
	this.Name=name;
	this.Message=msg;
	
	this.toString=function()
	{
		return name+":"+msg;
	}
}

function System_Ctor() 
{
	this.OnOutput=new Delegate();
	this.OnLoad=new Delegate();
	this.OnUnload=new Delegate();
	this.OnServerError=new Delegate();
	this.OnSessionRecover=new Delegate();

	var ua = navigator.userAgent.toLowerCase();

	var m_Browser = "";
	if ((/msie ([\d.]+)/).test(ua)) m_Browser = "IE";
	else if ((/firefox\/([\d.]+)/).test(ua)) m_Browser = "Firefox";
	else if ((/chrome\/([\d.]+)/).test(ua)) m_Browser = "Chrome";

	var Debug=false;
	this.IsDebug=function(){return Debug;}

	var This=this;
	
	var BaseUrl = "";

	var m_Modules={};
	var m_ModulesArray=[];
	var m_Count=0;
	var m_BaseDate=new Date()
	var m_Applications=[];
	var m_Global={};
	
	var m_Log=[];

	var m_SpecialDirectory={
		Application:"",
		Library:"",
		Home:"",
		Config:"",
		Root:""
	};

	var m_User="";
	var m_UserInfo={};
	var m_SessionID="";

	var m_Language="zh-CHS";

	var m_ModuleCtorFormat=
		"\r\n"+
		"var Module=this;\r\n"+
		"var TESTING={3};\r\n"+
		"Module.DirectoryName='{0}';\r\n"+
		"Module.FileName='{1}';\r\n"+
		"Module.GetResourceUrl=function(relativePath)\r\n"+
		"{\r\n"+
		"	return System.GetUrl(Module.DirectoryName+'/'+relativePath);\r\n"+
		"};\r\n"+
		"\r\n"+
		"{2}\r\n"+
		"Module.Initialize=(typeof(init)=='undefined'?null:init);\r\n"+
		"Module.Dispose=(typeof(dispose)=='undefined'?null:dispose);\r\n"+
		"Module.Application=(typeof(Application)=='undefined'?null:Application);\r\n";

	function TimeToString(date)
	{
		return String.format(
			"{0}:{1}:{2}",
			FormatNumber(date.getHours(),2),
			FormatNumber(date.getMinutes(),2),
			FormatNumber(date.getSeconds(),2)
		);
	}
	
	function DateToString(date)
	{
		return String.format(
			"{0}-{1}-{2} {3}:{4}:{5}",
			FormatNumber(date.getFullYear(),4),
			FormatNumber(date.getMonth()+1,2),
			FormatNumber(date.getDate(),2),
			FormatNumber(date.getHours(),2),
			FormatNumber(date.getMinutes(),2),
			FormatNumber(date.getSeconds(),2)
		);
	}
	
	function IsInternetExplorer6()
	{
		return (/MSIE\x206\.0/ig).test(navigator.appVersion.toUpperCase());
	}

	function CreateHttpRequest()
	{
		var request=null;
		if(window.XMLHttpRequest) 
		{
			request=new XMLHttpRequest();
		}
		else if(window.ActiveXObject) 
		{
			request=new ActiveXObject("Microsoft.XMLHttp");
		}
		return request;
	}

	function FormatNumber(num,length)
	{
		var s=num.toString();
		var zero="";
		for(var i=0;i<length-s.length;i++) zero+="0";
		return zero+s;
	}

	function GenerateUniqueId()
	{
		var dt=new Date()
		m_Count++;
		return 'ID'+FormatNumber(m_Count,6);
	}

	function RequestText(callback,errorCallback,xmlUrl)
	{
		var request=CreateHttpRequest();
		if(request)
		{
			var url=xmlUrl;
			request.open("GET",url,true); 
			request.onreadystatechange=function()
			{
				if(request.readyState==4)
				{
					try
					{
						switch(request.status)
						{
						case 200:
							callback(request.responseText);
							break;
						default:
							if(errorCallback) errorCallback(new Exception("Server Error",request.statusText));
						}
					}
					catch(ex)
					{
						errorCallback(new Exception(ex.name,ex.message));
					}
					finally
					{
						request=null;
					}
				}
			}
			request.send(null);
		}
	}

	function Post(callback,errorCallback,url,data)
	{
		var request=CreateHttpRequest();
		if(request)
		{
			var dataStr='';
			if(data.constructor==Object)
			{
				for(var k in data)
				{
					if(dataStr!="") dataStr+="&";
					dataStr+=(k+"="+escape(data[k]));
				}
			}
			else
			{
				dataStr=data.toString();
			}
			request.open("POST",url,true); 
			request.setRequestHeader('Content-Type','application/x-www-form-urlencoded')
			request.setRequestHeader("Cache-Control","no-cache") 
			request.onreadystatechange=function()
			{
				if(request.readyState==4)
				{
					try
					{
						switch(request.status)
						{
						case 200:
							callback(request.responseXML);
							break;
						default:
							if(errorCallback) errorCallback({status:request.status,statusText:request.statusText});
						}
					}
					finally
					{
						request=null;
					}
				}
			}
			request.send(dataStr);
		}
		return request;
	}

	function Link(rel,href,type)
	{
		var e=document.createElement("link");
		e.rel=rel
		e.type=type
		e.href=href;
		var hs=document.getElementsByTagName("head");
		if(hs.length>0) hs[0].appendChild(e);
		return e;
	}
	
	function StyleTag(e)
	{
		this.SetCss=function(css)
		{
			if(System.GetBrowser()=="IE")
			{
				e.cssText=css;
			}
			else
			{
				e.textContent=css;
			}
		}
	}

	function CreateStyle(css)
	{
		var e=null;
		if(System.GetBrowser()=="IE")
		{
			e=document.createStyleSheet();
			e.cssText=css;
		}
		else
		{
			e=document.createElement("style");
			e.type="text/css"
			e.textContent =css;
			var hs=document.getElementsByTagName("head");
			if(hs.length>0) hs[0].appendChild(e);
		}
		return new StyleTag(e);
	}

	function GetServiceUrl(service)
	{
		return "Services/"+service;
	}

	function GetUrl(path)
	{
		return encodeURI(BaseUrl + "/" + path);
	}
	
	function GetFullPath(path)
	{
		if(path=="") return String.format("/{0}",m_User);
		if(path.substr(0,1)!='/') path=String.format("/{0}/{1}",m_User,path);
		return path;
	}

	function GetDirectoryName(path)
	{
		var split=path.lastIndexOf("/");
		if(split==-1) split=0;
		return path.substring(0,split);
	}
		
	function LoadModules(completeCallback,errorCallback,paths,index)
	{
		function fail(ex)
		{
			System.OnOutput.Call(
				String.format(
					"<table style='width:100%;'>"+
						"<tr><td class='text'>Load \"{0}\"</td><td class='fail'>[FAIL]</div></td></tr>"+
						"<tr><td class='fail_msg' colspan='2'>{1}:{2}</td></tr>"+
					"</table>",
					path,ex.Name,ex.Message
				)
			);
			errorCallback(ex);
		}

		if (index == undefined) index = 0;

		var path = "System/" + paths[index];

		var moduleId = path.toUpperCase();
		if (m_Modules[moduleId] == null)
		{
			RequestText(load, fail, GetUrl(path));
		}
		else
		{
			loadComplete();
		}
		
		function load(text)
		{
			var moudle_ctor = new Function(
				String.format(m_ModuleCtorFormat, GetDirectoryName(path), path, text, false)
			);
			var moudle = new moudle_ctor();
			if (moudle.Initialize != null)
				moudle.Initialize(complete, fail);
			else
				complete();
			function complete()
			{
				if (m_Modules[moduleId] == null)
				{
					m_Modules[moduleId] = moudle;
					m_ModulesArray.push(moudle);
				}
				System.OnOutput.Call(String.format("<table cellspacing='0' style='width:100%;'><tr><td class='text'>Load \"{0}\"</td><td class='success'>[ OK ]</td></tr></table>", path));
				loadComplete();
			}
		}

		function loadComplete()
		{
			if (index == paths.length - 1)
				completeCallback();
			else
				LoadModules(completeCallback, errorCallback, paths, index + 1);
		}
	}

	function GetModule(path)
	{
		var moduleId = "SYSTEM/" + path.toUpperCase();
		return m_Modules[moduleId];
	}

	var m_TestCss = {};

	function Test(file, code, css)
	{
		var base = System.Path.GetDirectoryName(file);
		
		if(css!=undefined)
		{
			if (m_TestCss[file.toUpperCase()] != undefined)
			{
				m_TestCss[file.toUpperCase()].SetCss(css);
			}
			else
			{
				m_TestCss[file.toUpperCase()] = CreateStyle(css);
			}
		}

		var args = []

		args.push(base);
		for (var index = 3; index < arguments.length; index++)
		{
			args.push(arguments[index])
		}
		
		var task=Taskbar.AddTask(null,"正在加载...");
		task.Shine(false);

		var moudle_ctor = new Function(
			String.format(m_ModuleCtorFormat, base, file, code, true)
		);

		var moudle = new moudle_ctor();

		if (moudle.Initialize != null)
			moudle.Initialize(complete, error);
		else
			complete();

		function complete()
		{
			Taskbar.RemoveTask(task);
			if (moudle.Application != null)
			{
				var instance = new Application(moudle.Application, file, moudle);
				try
				{
					instance.Start.apply(instance, args);
				}
				catch (ex)
				{
					alert(ex);
				}
			}
		}

		function error(msg)
		{
			Taskbar.RemoveTask(task);
			alert(msg);
		}
	}

	function Exec(callback,errorCallback,path)
	{
		var args=[]
		var split=path.lastIndexOf("/");
		if(split==-1) split=0;
		args.push(path.substring(0,split));
		for(var index=3;index<arguments.length;index++)
		{
			args.push(arguments[index])
		}
		
		var task=null;
		if(GetModule(path)==null)
		{
			task=Taskbar.AddTask(null,"正在加载...");
			task.Shine(false);
		}
		
		try
		{
			LoadModules(complete,error,[path])
		}
		catch(ex)
		{
			if(task!=null) Taskbar.RemoveTask(task);
			errorCallback(ex);
		}
		
		function complete()
		{
			if(task!=null) Taskbar.RemoveTask(task);
			
			if(callback!=null) callback();
			var app=GetModule(path);
			if(app.Application!=null)
			{
				var instance=new Application(app.Application,path);
				try
				{
					instance.Start.apply(instance,args);
				}
				catch(ex)
				{
					alert(ex);
				}
			}
		}
		
		function error(msg)
		{
			if(task!=null) Taskbar.RemoveTask(task);
			errorCallback(msg);
		}
	}

	function Exec2(callback,errorCallback,path,params)
	{
		var args=[]
		var split=path.lastIndexOf("/");
		if(split==-1) split=0;
		args.push(path.substring(0,split));
		for(var index=0;index<params.length;index++)
		{
			args.push(params[index])
		}
		
		var task=null;
		if(GetModule(path)==null)
		{
			task=Taskbar.AddTask(null,"正在加载...");
			task.Shine(false);
		}
		
		LoadModules(complete,error,[path])
		
		function complete()
		{
			if(task!=null) Taskbar.RemoveTask(task);
			
			if(callback!=null) callback();
			var app=GetModule(path);
			if(app.Application!=null)
			{
				var instance=new Application(app.Application,path);
				try
				{
					instance.Start.apply(instance,args);
				}
				catch(ex)
				{
					alert(ex);
				}
			}
		}
		
		function error(msg)
		{
			if(task!=null) Taskbar.RemoveTask(task);
			errorCallback(msg);
		}
	}
	
	function IsManager()
	{
		for(var k in m_UserInfo.Roles)
		{
			if(m_UserInfo.Roles[k] == "管理员") return true;
		}
		return false;
	}

	function Initialize(config)
	{
		if(m_Browser=="IE")
		{
			try
			{
				document.execCommand("BackgroundImageCache", false, true);
			}
			catch(ex)
			{
			}
		}
		document.oncontextmenu = function(evt)
		{
			if (evt == undefined) evt = event;
			var target = null;
			if (evt.target != undefined) target = evt.target;
			else if (evt.srcElement != undefined) target = evt.srcElement;
			if (target.tagName != undefined && (target.tagName.toUpperCase() == 'INPUT' || target.tagName.toUpperCase() == 'TEXTAREA'))
			{
				return true;
			}
			else
			{
				return DEBUG ? evt.ctrlKey : false;				
			}
		}
		document.onselectstart=function(evt)
		{
			if(evt==undefined) evt=event;
			var target=null;
			if(evt.target!=undefined) target=evt.target;
			else if(evt.srcElement!=undefined) target=evt.srcElement;
			if(target.tagName!=undefined && target.tagName.toUpperCase()!='DIV')
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		if(config.UserInfo!=undefined) m_User=config.UserInfo.Name;
		if(config.UserInfo!=undefined) m_UserInfo=config.UserInfo;
		if(config.Language!=undefined) m_Language=config.Language;
		if(config.Debug!=undefined) Debug=config.Debug;
		if(config.SessionID!=undefined) m_SessionID=config.SessionID;
		
		var host = window.location.host;
		var path = System.Path.GetDirectoryName(window.location.pathname);
		
		BaseUrl = String.format(
			"http://{0}{1}", 
			host.charAt(host.length - 1) == '/' ? host.substr(0, host.length - 1) : host, 
			path.charAt(path.length - 1) == '/' ? path.substr(0, path.length - 1) : path
		);
		
		This.OnOutput.Attach(Write);
		
		This.LoadModules(
			function()
			{
				Desktop = System.GetModule("Desktop.js").Desktop;
				Taskbar = System.GetModule("Desktop.js").Taskbar;
				
				OutputPanel.Hide();
				
				This.OnLoad.Call();
			},
			function(){},
			["Controls.js","Window.js","Desktop.js"]
		);
	}

	function GetSpecialDirectory(name)
	{
		return m_SpecialDirectory[name];
	}

	function RegisterGlobal(func)
	{
		var uniqueId=GenerateUniqueId();
		m_Global[uniqueId]=func;
		return uniqueId;
	}

	function RemoveGlobal(uniqueId)
	{
		delete m_Global[uniqueId];
	}

	function Application(base_ctor,fileName,disposeModlue)
	{
		base_ctor.call(this);
			
		var id=m_Applications.length;
		m_Applications.push(this);
		
		this.Dispose=function()
		{
			m_Applications[id]=null;
			if(disposeModlue!=undefined) disposeModlue.Dispose(function(){},alert);
		}
		
		this.GetResourceUrl=function(relativePath)
		{
			return Module.GetResourceUrl(relativePath);
		}
	}

	function Invoke(completeCallback,errorCallback,objs,asynMethod,continueIfError,completeOneCallback)
	{	
		function callOne(index)
		{
			var obj=objs[index];
			if(obj[asynMethod]!=null)
			{
				try
				{
					obj[asynMethod].call(obj,complete,function(ex){error(ex,obj);});
				}
				catch(ex)
				{
					error(ex,obj);
				}
			}
			else
				complete();
			function complete()
			{
				if(completeOneCallback!=undefined) completeOneCallback(obj);
				if(index==objs.length-1) completeCallback();else callOne(index+1);
			}
			function error(msg,o)
			{
				errorCallback(msg,o);
				if(!continueIfError || index==objs.length-1) completeCallback();else callOne(index+1);
			}
		}
		if(objs.length>0) callOne(0);else completeCallback();
	}

	function Call(completeCallback,errorCallback,funcs,caller,continueIfError,completeOneCallback)
	{
		function callOne(index)
		{
			var func=funcs[index];
			if(func!=null)
			{
				try
				{
					func.call(caller,complete,error);
				}
				catch(ex)
				{
					error(ex);
				}
			}
			else
				complete();
			function complete()
			{
				if(completeOneCallback!=undefined) completeOneCallback(obj);
				if(index==funcs.length-1) completeCallback();else callOne(index+1);
			}
			function error(msg)
			{
				errorCallback(msg);
				if(!continueIfError || index==funcs.length-1) completeCallback();else callOne(index+1);
			}
		}
		if(objs.length>0) callOne(0);else completeCallback();
	}

	function GetUser()
	{
		return m_User;
	}

	function GetLanguage()
	{
		return m_Language;
	}

	function GetGlobal(id)
	{
		return m_Global[id];
	}
	
	function GetBrowser()
	{
		return m_Browser;
	}
	
	function GetSessionID()
	{
		return m_SessionID;
	}
	
	function HandleException(ex)
	{
		alert(ex.Message);
	}

	function Dispose(completeCallback,errorCallback)
	{
		function fail(ex,m)
		{
			System.OnOutput.Call(
				String.format(
					"<table style='width:100%;'>"+
						"<tr><td class='text'>Dispose \"{0}\"</td><td class='fail'>[FAIL]</div></td></tr>"+
						"<tr><td class='fail_msg' colspan='2'>{1}:{2}</td></tr>"+
					"</table>",
					m.FileName,ex.Name,ex.Message
				)
			);
			errorCallback(ex);
		}
		
		var as=[];
		for(var i in m_Applications)
		{
			if(m_Applications[i]!=null) as.push(m_Applications[i]);
		}
		as.reverse();
		Invoke(completeDisposeApps,fail,as,"Terminate",true);
		
		function completeDisposeApps()
		{
			m_ModulesArray.reverse();
			Invoke(completeCallback,fail,m_ModulesArray,"Dispose",true,completeOneCallback);
			function completeOneCallback(m)
			{
				System.OnOutput.Call(String.format("<table cellspacing='0' style='width:100%;'><tr><td class='text'>Dispose \"{0}\"</td><td class='success'>[ OK ]</td></tr></table>",m.FileName));
			}
		}
	}
	
	function Logout(completeCallback)
	{
		Post(completeCallback,completeCallback,"System.los",{Command:"Logout"});
	}
	
	function Shutdown()
	{
		System.OnUnload.Call();
		OutputPanel.Clear();
		OutputPanel.Show();
		Desktop.SetVisible(false);
		Taskbar.SetVisible(false);
		System.Dispose(Dispose_Complete,function(){});
	}
	
	function Dispose_Complete()
	{
		SaveLog_Complete();
	}
	
	function SaveLog_Complete()
	{
		This.Logout(Logout_Complete);
	}
	
	function Logout_Complete()
	{
		System.OnOutput.Detach(Write);
		window.onbeforeunload=null;
	}
	
	function LoadImage(src)
	{
		var img=new Image();
		img.src=src;
		return img;
	}
	
	function RaisException(type)
	{
		window.onbeforeunload=null;
		window.location="Exception/"+type+".htm";
	}
	
	function GetUserInfo()
	{
		return System.Clone(m_UserInfo);
	}

	var AllowHtmlTag = {
		"A": "A",
		"I": "I",
		"B": "B",
		"U": "U",
		"P": "P",
		"TH": "TH",
		"TD": "TD",
		"TR": "TR",
		"OL": "OL",
		"UL": "UL",
		"LI": "LI",
		"BR": "BR",
		"H1": "H1",
		"H2": "H2",
		"H3": "H3",
		"H4": "H4",
		"H5": "H5",
		"H6": "H6",
		"H7": "H7",
		"EM": "EM",
		"PRE": "PRE",
		"DIV": "DIV",
		"IMG": "IMG",
		"CITE": "CITE",
		"SPAN": "SPAN",
		"FONT": "FONT",
		"CODE": "CODE",
		"TABLE": "TABLE",
		"TBODY": "TBODY",
		"SMALL": "SMALL",
		"THEAD": "THEAD",
		"CENTER": "CENTER",
		"STRONG": "STRONG",
		"BLOCKQUOTE": "BLOCKQUOTE"
	};

	var HtmlBeginTagRegex = /<[^<>\/]+>/ig;
	var HtmlEndTagRegex = /<\/[^\s<>\/]+>/ig;

	function ReplaceHtml(text)
	{
		var newText = text.toString().replace(
			HtmlBeginTagRegex,
			function(html)
			{
				return html.replace(
					/[^\s<>\/]+/i,
					function(tag)
					{
						if (AllowHtmlTag[tag.toUpperCase()] == undefined) return "_tag";
						else return tag;
					}
				)
				.replace(
					/[^a-zA-Z]expression|[^a-zA-Z]on|[^a-zA-Z]javascript/ig,
					function(str)
					{
						return str.substr(0, 1) + "_" + str.substr(1, str.length - 1);
					}
				);
			}
		)
		.replace(
			HtmlEndTagRegex,
			function(html)
			{
				return html.replace(
					/[^\s<>\/]+/i,
					function(tag)
					{
						if (AllowHtmlTag[tag.toUpperCase()] == undefined) return "_tag";
						else return tag;
					}
				)
			}
		);
		return newText;
	}

	this.RaisException = RaisException;
	this.Logout = Logout;
	this.Shutdown = Shutdown;

	this.GetBrowser = GetBrowser;
	this.GetSessionID = GetSessionID;
	this.HandleException = HandleException

	this.RegisterGlobal = RegisterGlobal;
	this.RemoveGlobal = RemoveGlobal;
	this.GetGlobal = GetGlobal;

	this.CreateHttpRequest = CreateHttpRequest;
	this.RequestText = RequestText;
	this.Post = Post;

	this.GenerateUniqueId = GenerateUniqueId;
	this.GetUser = GetUser;
	this.GetUserInfo = GetUserInfo;
	this.GetLanguage = GetLanguage;
	this.GetUrl = GetUrl;
	this.GetFullPath = GetFullPath;
	this.GetSpecialDirectory = GetSpecialDirectory;
	this.Link = Link;
	this.Initialize = Initialize;

	this.IsManager = IsManager;

	this.Exec = Exec;
	this.Exec2 = Exec2;
	this.Test = Test;

	this.LoadModules = LoadModules;
	this.GetModule = GetModule;
	this.Dispose = Dispose;

	this.Invoke = Invoke;
	this.Call = Call;

	this.LoadImage = LoadImage;

	this.ReplaceHtml = ReplaceHtml;
}

function Delegate()
{
	var all=[];
	
	var This=this;
	
	This.Call=function()
	{
		var ret=null;
		for(var index in all)
		{
			ret=all[index].apply(This,arguments);
		}
		return ret;
	}
	
	This.Attach=function(func)
	{
		all.push(func);
	}
	
	This.Detach=function(func)
	{
		var index=0;
		for(index in all) 
		{
			if(all[index]==func) break;
		}
		if(index<all.length)
		{
			delete all[index];
			all.splice(index,1);
		}
	}
}

String.format=function(fmt)
{
	var params=arguments;
	var pattern=/{{|{[1-9][0-9]*}|\x7B0\x7D/g;
	return fmt.replace(
		pattern,
		function(p)
		{
			if(p=="{{") return "{";
			return params[parseInt(p.substr(1,p.length-2),10)+1]
		}
	);
}

var System = new System_Ctor();

System.Object=function()
{
    this.GetType=function()
    {
        return "System.Object";
    }
    
    this.is=function(typeName)
    {
        return typeName==this.GetType();
    }
}

System.Clone=function(val)
{
	if(val==null)
	{
		return null
	}
	else if(val.constructor==Array)
	{
		var a=new Array()
		for(i in val)
		{
			a[i]=System.Clone(val[i])
		}
		return a
	}
	else if(val.constructor==Object)
	{
		var a=new Object()
		for(c in val)
		{
			a[c]=System.Clone(val[c])
		}
		return a
	}
	else if(val.constructor==Number)
	{
		return val
	}
	else if(val.constructor==String)
	{
		return val
	}
	else if(val.constructor==Date)
	{
		return val
	}
	else
	    return val;
}

System.TransferCharForXML=function (str)
{
	var res=str.replace(
		/&|\x3E|\x3C|\x5E|\x22|\x27|[\x00-\x1F]|\t/g,
		function(s)
		{
			var ascii=s.charCodeAt(0)
			return "&#"+ascii.toString(10)+";";
		}
	)
	return res;
}

System.TransferCharForJavascript=function(s)
{
	var newStr=s.replace(
		/[\x26\x27\x3C\x3E\x0D\x0A\x22\x2C\x5C\x00]/g,
		function(c)
		{
			ascii=c.charCodeAt(0)
			return '\\u00'+(ascii<16?'0'+ascii.toString(16):ascii.toString(16))
		}
	);
	return newStr;
}

System.BaseDate = new Date(1970,0,1,0,0,0);

var ParseContructors = {
	Date: function(value)
	{
		var val = new Date();
		val.setTime(value + System.BaseDate.getTime());
		return val;
	},
	Exception: function(value)
	{
		return new Exception(value.Name, value.Message);
	}
};

System.ParseJson = function(str,contructors)
{
	try
	{
		var val = JSON.parse(
			str,
			function(key, value)
			{
				if(value != null && typeof value == "object" && value.__DataType!=undefined)
				{
					if(ParseContructors[value.__DataType]!=undefined)
					{
						return ParseContructors[value.__DataType](value.__Value);
					}
					else if(contructors !=undefined && contructors[value.__DataType]!=undefined)
					{
						return contructors[value.__DataType](value.__Value);
					}
					else
					{
						return value;
					}
				}
				else
				{
					return value;
				}
			}
		);
	}
	catch(ex)
	{
		throw ex;
	}
	return val;
}

System.RenderJson = function(val)
{
	if (val == null)
	{
		return null
	}
	else if (val.constructor == Array)
	{
		var builder = [];
		builder.push("[");
		for (var index in val)
		{
			if (index > 0) builder.push(",");
			builder.push(System.RenderJson(val[index]));
		}
		builder.push("]");
		return builder.join("");
	}
	else if (val.constructor == Object)
	{
		var builder = [];
		builder.push("{");
		var index = 0;
		for (var key in val)
		{
			if (index > 0) builder.push(",");
			builder.push(String.format("\"{0}\":{1}", key, System.RenderJson(val[key])));
			index++;
		}
		builder.push("}");
		return builder.join("");
	}
	else if (val.constructor == Boolean)
	{
		return val.toString();
	}
	else if (val.constructor == Number)
	{
		return val.toString();
	}
	else if (val.constructor == String)
	{
		return String.format('"{0}"', System.TransferCharForJavascript(val));
	}
	else if(val.constructor == Date)
	{
		return String.format('{"__DataType":"Date","__Value":{0}}', val.getTime() - System.BaseDate.getTime());
	}
	else if (val.RenderJson != undefined)
	{
		return val.RenderJson();
	}
}

System.DisableSelect=function(elem,disableChildren)
{
	if(disableChildren==undefined) disableChildren=false;
	
	if(System.GetBrowser()=="IE")
	{
		if(elem.setAttribute!=undefined) elem.setAttribute("unselectable","on");
		
		if(disableChildren)
		{
			for(var i=0;i<elem.childNodes.length;i++)
			{
				System.DisableSelect(elem.childNodes[i],true);
			}
		}
	}
}

System.GetButton=function(evt)
{
	if ((evt.which != undefined && evt.which == 1) || evt.button == 1)
		return "Left";
	else if ((evt.which != undefined && evt.which == 3) || evt.button == 2)
		return "Right"
	else 
		return "";
}

System.DetachChildNodes=function(node)
{
	var nodes=[];
	if(!System.IsTextNode(node))
	{
		for(var i = 0;i<node.childNodes.length;i++)
		{
			nodes.push(node.childNodes[i]);
		}
		
		for(var i=0;i<nodes.length;i++)
		{
			node.removeChild(nodes[i]);
		}
		
	}
	return nodes;
}

System.IsTextNode=function(node)
{
	return node.innerHTML==undefined;
}

function _ClearHtml(builder,node)
{
	for(var i = 0;i<node.childNodes.length;i++)
	{
		var n=node.childNodes[i];
		if(System.IsTextNode(n))
		{
			if (n.textContent) builder.push(n.textContent);
			else if (n.nodeValue) builder.push(n.nodeValue);
		}
		else
		{
			_ClearHtml(builder,n);
		}
	}
}

System.ClearHtml=function(node)
{
	var builder=[];
	_ClearHtml(builder,node);
	return builder.join("");
}

System.GetInnerHTML=function(nodes)
{
	var builder=[];
	for(var i =0;i<nodes.length;i++)
	{
		if (!System.IsTextNode(nodes[i]))
		{
			builder.push(nodes[i].innerHTML);
		}
		else
		{
			if (nodes[i].textContent) builder.push(nodes[i].textContent.replace(/\</ig, function() { return "&lt;"; }));
			else if (nodes[i].nodeValue) builder.push(nodes[i].nodeValue.replace(/\</ig, function() { return "&lt;"; }));
		}
	}
	return builder.join("");
}

System.EncodeUrl=function(url)
{
	var temp=[];
	for(var i = 0 ;i<url.length;i++)
	{
		var ascii=url.charCodeAt(i);
		temp.push("%");
		temp.push(acrii.toString(16));
	}
	return temp.join("");
}

System.AttachEvent=function(elem,evtName,handler)
{

	if(elem.attachEvent)
	{
		elem.attachEvent("on"+evtName,handler);
	}
	else if(elem.addEventListener)
	{
		elem.addEventListener(evtName,handler,false);
	}
}

System.DetachEvent=function(elem,evtName,handler)
{

	if(elem.detachEvent)
	{
		elem.detachEvent("on"+evtName,handler);
	}
	else if(elem.addEventListener)
	{
		elem.removeEventListener(evtName,handler,false);
	}
}

System.GetClientCoord = function(obj)
{
	if(obj.getBoundingClientRect!=undefined)
	{
		var bodyRect = document.body.getBoundingClientRect();
		var rect = obj.getBoundingClientRect();
		return { X: rect.left - bodyRect.left, Y: rect.top - bodyRect.top };
	}
	else
	{
		if(System.GetBrowser()=="IE")
		{
			var offsetParent = obj.offsetParent;
			if (offsetParent == null)
			{
				return { X: obj.offsetLeft, Y: obj.offsetTop };
			}
			else
			{
				var offset = System.GetClientCoord(offsetParent);
				return { X: obj.offsetLeft + offset.X, Y: obj.offsetTop + offset.Y };
			}
		}
		else
		{
			var offsetParent = obj.offsetParent;
			if (offsetParent == null)
			{
				return { X: obj.offsetLeft, Y: obj.offsetTop };
			}
			else
			{
				var offset = System.GetClientCoord(offsetParent);
				var coord = { X: offsetParent.clientLeft + obj.offsetLeft + offset.X, Y: offsetParent.clientTop + obj.offsetTop + offset.Y };
				return coord;
			}
		}
	}
}

System.PreventDefault = function(evt)
{
	if (evt.preventDefault != undefined)
	{
		evt.preventDefault();
	}
	else
	{
		evt.returnValue = false;
	}
}

System.CancelBubble = function(evt)
{
	if (evt && evt.stopPropagation) evt.stopPropagation();
	else evt.cancelBubble = true;
}

System.GetTarget=function(evt)
{
	if (evt.target != undefined) return evt.target;
	if (evt.srcElement != undefined) return evt.srcElement;
	return null;
}

System.Path=function()
{
}

System.Path.GetRelativePath=function(parent,sub)
{
	if(parent.length>sub.length) return null;
	
	parentPath=parent.toUpperCase();
	subPath=sub.toUpperCase();
	
	if(parentPath==subPath) return "";
	var index = subPath.indexOf(parentPath);
	if(index==0 && subPath.charAt(parentPath.length)=='/')
	{
		return sub.substr(parentPath.length+1,subPath.length-parentPath.length);			
	}
	else
	{
		return null;
	}
	
}

System.Path.GetFileName=function(fullName)
{
	var index=fullName.lastIndexOf("/")
	var name=(index==-1?fullName:fullName.substring(index+1,fullName.length));
	return name;
}

System.Path.GetFileExtension=function(fullName)
{
	var index=fullName.lastIndexOf(".")
	var ext=(index==-1?"":fullName.substring(index,fullName.length));
	return ext;
}

System.Path.GetDirectoryName=function(fullName)
{
	var index=fullName.lastIndexOf("/")
	switch(index)
	{
	case -1:
	    return null;
	case 0:
	    return "/";
	default:
	    return fullName.substring(0,index);
	}
}

System.Path.GetFileNameNoExtention=function(fullName)
{
	var index=fullName.lastIndexOf("/")
	var name=(index==-1?fullName:fullName.substring(index+1,fullName.length));
	index=name.lastIndexOf(".");
	return index==-1?name:name.substring(0,index);
}

System.Path.Join=function()
{
	var path="";
	for(var i=0;i<arguments.length;i++)
	{
		if(arguments[i]!=undefined && arguments[i]!=null && arguments[i]!="")
		{
			if(arguments[i].charAt(arguments[i].length-1)!='/') path+='/';
			path+=arguments[i];
		}
	}
	return path;
}