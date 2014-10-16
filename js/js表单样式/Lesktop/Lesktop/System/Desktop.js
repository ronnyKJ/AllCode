
var Control=null;
var AnchorStyle=null;
var Window = null;
var Controls=null;

var Config = {
	Shortcuts: [
		{ ImageUrl: "System/Developer/icon.png", ID: "Developer", Text: "可视化开发", Path: "Developer.js" }
	]
};

function init(completeCallback,errorCallback)
{
	System.LoadModules(
		function()
		{
			Controls = System.GetModule("Controls.js");

			Window = System.GetModule("Window.js").Window;

			Control = System.GetModule("Controls.js").Control;
			AnchorStyle = System.GetModule("Controls.js").AnchorStyle;

			DocumentPanel = new DocumentPanelCtor();
			Module.Desktop = new DesktopCtor();
			Module.Taskbar = new TaskbarCtor();

			completeCallback();
		},
		errorCallback,
		["Controls.js", "Window.js"]
	);
}

function dispose(competeCallback,errorCallback)
{
	try
	{
		competeCallback();
	}
	catch(ex)
	{
		errorCallback(ex);
	}
}

function TransferCharForJavascript(s)
{
	newStr=s.replace(
		/[\x26\x27\x3C\x3E\x0D\x0A]/g,
		function(c)
		{
			ascii=c.charCodeAt(0);
			return '\\u00'+(ascii<16?'0'+ascii.toString(16):ascii.toString(16));
		}
	);
	return newStr;
}

function DesktopItem(itemConfig)
{
	itemConfig = System.Clone(itemConfig);
	
	var imgUrl = System.GetUrl(itemConfig.ImageUrl);
	
	var isIE6=/MSIE 6.0/ig.test(navigator.appVersion);
	
	this.dom=document.createElement("div");
	this.dom.className='shortcut';
	this.dom.innerHTML = String.format(
		'<div class="icon" style="{0}"></div>'+
		'<div class="text">{1}</div>',
		isIE6?String.format("filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='{0}', sizingMethod='scale');",imgUrl):String.format("background-image:url('{0}')",imgUrl),
		System.ReplaceHtml(itemConfig.Text)
	);
	this.dom.ondblclick=function()
	{
		if (itemConfig.ID == "SHORTCUT001")
		{
			System.Exec(function(){},alert,'FileBrowser.js',System.GetSpecialDirectory('Home'),System.GetSpecialDirectory('Home'));
		}
		else
		{
			if (itemConfig.Handler != undefined) eval(itemConfig.Handler);
			else if (itemConfig.Path != undefined) System.Exec(function() { }, function(ex) { alert(ex); }, itemConfig.Path);
		}
	}
}

function TaskbarItem(dialog,title)
{
	var This=this;
	if(title==undefined) title="";
	this.Item=document.createElement("DIV");
	this.Item.className="item";
	this.Item.innerHTML = System.ReplaceHtml(title);
	this.Item.title=title;

	this.Item.onclick=function()
	{
		if(dialog==null) return;
		if(dialog.IsVisible())
		{
			if(dialog.IsTop())
				dialog.Hide();
			else
				dialog.BringToTop();
		}
		else
			dialog.Show(true);
		if(This.Item.className=="item_shine") This.Item.className="item";
	}
	
	this.Dialog=dialog;
	
	this.title=function(newTitle)
	{
		if(newTitle!=undefined) this.Item.innerHTML = System.ReplaceHtml(newTitle);
		This.Item.title=newTitle;
		return this.Item.innerHTML;
	}
	
	this.SetText=function(text)
	{
		This.Item.innerHTML = System.ReplaceHtml(text);
	}
	
	this.Shine=function(highlight)
	{
		if(highlight==undefined) highlight=false;
		var count=6;
		var interval=setInterval(
			function()
			{
				if(count>0)
				{
					switch(count)
					{
					case 1:
					case 3:
					case 5:
						This.Item.className="item";
						break;
					case 2:
					case 4:
					case 6:
						This.Item.className="item_shine";
						break;
					}
					count--;
				}
				else
				{
					This.Item.className=(highlight?"item_shine":"item");
					clearInterval(interval);
				}
			},
			200
		);
	}
}

function DocumentPanelCtor()
{
    var This=this;
    var config={
        Parent:null,
        Left:0,
        Top:0,
        Width:document.documentElement.clientWidth,
        Height:document.documentElement.clientHeight,
        Css:""
    }
    
    Control.call(This,config);
    
    var Base={
        GetType:This.GetType,
        is:This.is
    }
    
    This.is=function(type){return type==this.GetType()?true:Base.is(type);}
    This.GetType = function() { return "DocumentPanel"; }

    This.GetDom().style.overflow = "hidden";
    
    window.onresize=function()
    {
    	var width = (document.documentElement.clientWidth > 600) ? document.documentElement.clientWidth : 800;
    	var height = (document.documentElement.clientHeight > 450) ? document.documentElement.clientHeight : 600;
    	This.Resize(width, height);
    }
    
    document.body.appendChild(This.GetDom());
}

function DesktopCtor()
{
    var This=this;

    var config={
        Parent:DocumentPanel,
        Left:0,
        Top:0,
        Width:DocumentPanel.GetWidth(),
        Height:DocumentPanel.GetHeight()-28,
        Css:"desktop",
        AnchorStyle:AnchorStyle.All
    }
    Control.call(This,config);
    var Base={
        GetType:This.GetType,
        is:This.is
    }
    This.is=function(type){return type==this.GetType()?true:Base.is(type);}
    This.GetType = function() { return "Desktop"; }

	var m_MoveDiv=document.createElement("DIV");
	m_MoveDiv.style.position="absolute";
	m_MoveDiv.style.display='none';
	m_MoveDiv.style.zIndex='100000';
	m_MoveDiv.style.left='0px';
	m_MoveDiv.style.top='0px';
	m_MoveDiv.className='moveBackground';
	m_MoveDiv.setAttribute("unselectable","on");
	
	This.GetDom().appendChild(m_MoveDiv);
    
	var menuConfig={
		Items:[
			{Text:"添加/删除程序",ID:"Application"},
			{ID:""},
			{Text:"系统设置",ID:"Setting"}
		]
	};
	
	This.ContextMenu = new Controls.Menu(menuConfig);
	
	This.ContextMenu.OnCommand.Attach(
		function(cmd)
		{
			if(cmd == "Setting")
			{
			}
			else if(cmd == "Application")
			{
			}
		}
	);
	
	This.DisplaySetting = function()
	{
		ApplicationMangementForm.GetInstance().Show(true);
		ApplicationMangementForm.GetInstance().Load();
	}

    This.GetDom().style.overflow = "hidden";
   
    This.GetDom().onscroll=function()
    {
		var dom=This.GetDom();
		if(dom.scrollLeft>0 || dom.scrollTop >0)
		{
			dom.scrollLeft=0;
			dom.scrollTop=0;
		}
    }
    
    var m_Items = {};
		
	for(var i in Config.Shortcuts)
	{
		var sc=Config.Shortcuts[i];
		
		var item=new DesktopItem(sc);
		m_Items[sc.ID] = item;
		This.GetDom().appendChild(item.dom);
	}
    
	This.AddShortcut=function(sc)
	{
		var item=new DesktopItem(sc);
		m_Items[sc.ID] = item;
		This.GetDom().appendChild(item.dom);
		
		Config.Shortcuts.push(System.Clone(sc));
	}
	
	This.RemoveShortcut = function(id)
	{
		if(m_Items[id]!=undefined)
		{
			This.GetDom().removeChild(m_Items[id].dom);
			delete m_Items[id];
			
			var index = -1;
			for(var i = 0; i<Config.Shortcuts.length; i++)
			{
				if(Config.Shortcuts[i].ID == id) {index = i; break;}
			}
			
			if(index >= 0) Config.Shortcuts.splice(index, 1);
		}
	}
	
	This.ExistsShortcut=function(id)
	{
		return m_Items[id] != undefined;
	}
	
	This.EnterMove=function(cursor)
	{
		m_MoveDiv.style.width=This.GetWidth()+'px';
		m_MoveDiv.style.height=This.GetHeight()+'px';
		m_MoveDiv.style.display='block';
		System.DisableSelect(m_MoveDiv, true);
		m_MoveDiv.style.cursor = (cursor == undefined ? "default" : cursor);
	}
	
	This.LeaveMove=function()
	{
		m_MoveDiv.style.display='none';
	}
    
    This.AddWindow=function(wnd)
    {
		This.AddControl(wnd);
    }
    
    This.RemoveWindow=function(wnd)
    {
		This.RemoveControl(wnd);
    }
}

 function TaskbarCtor()
{      
    var This=this;
    var config={
        Parent:DocumentPanel,
        Left:0,
        Top:DocumentPanel.GetHeight()-28,
        Width:DocumentPanel.GetWidth(),
        Height:28,
        Css:"taskbar",
        AnchorStyle:AnchorStyle.Bottom|AnchorStyle.Left|AnchorStyle.Right
    }
    Control.call(This,config);
    var Base={
        GetType:This.GetType,
        is:This.is
    }
    This.is=function(type){return type==this.GetType()?true:Base.is(type);}
    This.GetType=function(){return "Taskbar";}
    
    var m_HGuide=new Controls.GuideLine(This.GetClientWidth(),[40,4,13,4,0,4,13,2]);
    
    var m_BtnLogout=new Control(
		{
			Parent:This,
			Left:0,Top:2,Width:m_HGuide.GetWidth(0),Height:26,
			Css:'logoutButton',
			AnchorStyle:AnchorStyle.Left|AnchorStyle.Top
		}
    );
    
    
    m_BtnLogout.GetDom().onclick=function()
    {
		return System.Shutdown();
    }
    
    m_BtnLogout.SetVisible(!System.GetUserInfo().IsTemp);
    
    var m_BtnLeft=new Control(
		{
			Parent:This,
			Left:m_HGuide.Get(1),Top:2,Width:m_HGuide.GetWidth(2),Height:26,
			Css:'btnLeft',
			AnchorStyle:AnchorStyle.Left|AnchorStyle.Top
		}
    );
    
    var m_BtnRight=new Control(
		{
			Parent:This,
			Left:m_HGuide.Get(5),Top:2,Width:m_HGuide.GetWidth(6),Height:26,
			Css:'btnRight',
			AnchorStyle:AnchorStyle.Right|AnchorStyle.Top
		}
    );
    
    var m_ItemPanel=new Control(
		{
			Parent:This,
			Left:m_HGuide.Get(3),Top:2,Width:m_HGuide.GetWidth(4),Height:26,
			Css:'itemPanel',
			AnchorStyle:AnchorStyle.All
		}
    );
    
    m_ItemPanel.GetDom().innerHTML="<div class='itemContainer'></div>";
    
    var m_ItemContainer=m_ItemPanel.GetDom().firstChild;
    
    m_ItemContainer.style.width='10px';
    m_ItemContainer.style.height='26px';
    
    m_BtnLeft.GetDom().onclick=function()
	{
		m_ItemPanel.GetDom().scrollLeft-=m_ScrollUnit;
	}
    
    m_BtnRight.GetDom().onclick=function()
	{
		m_ItemPanel.GetDom().scrollLeft+=m_ScrollUnit;
	}    
	
	m_ItemPanel.OnResized.Attach(
		function()
		{
			ResizeContainer();
			CalcScrollUnit();
		}
	);
	
	m_ItemContainer.onmousedown=function(evt)
	{
		var width=GetContainerWidth();
		m_ItemContainer.style.width=width;
		
		if(m_ItemPanel.GetClientWidth()<width)
		{
			if(evt==undefined) evt=event;
			
			MoveVar={
				PreClientX:evt.clientX,
				PreScrollLeft:m_ItemPanel.GetDom().scrollLeft,
				Object:m_ItemPanel.GetDom()
			}
		}
	}
	
	function GetContainerWidth()
	{
		return m_Count>=0?m_Count*m_ItemWidth+8:10;
	}
	
	function ResizeContainer()
	{
		var width=GetContainerWidth();
		m_ItemContainer.style.width=width+'px';
		
		if(m_ItemPanel.GetClientWidth()<width)
		{
			m_BtnLeft.SetVisible(true);
			m_BtnRight.SetVisible(true);
		}
		else
		{
			m_BtnLeft.SetVisible(false);
			m_BtnRight.SetVisible(false);
		}
		m_ItemPanel.GetDom().scrollLeft=m_ItemPanel.GetDom().scrollLeft;
	}
	
	function CalcScrollUnit()
	{
		var width=m_ItemPanel.GetClientWidth();
		var temp=Math.round(width/m_ItemWidth-0.5);
		m_ScrollUnit=((width % m_ItemWidth==0)?width:(Math.round(width/m_ItemWidth-0.5)*m_ItemWidth));
	}
	
	
	var items={};
	var m_Count=0;
	var m_ItemWidth=150;
	var m_ScrollUnit=0;
	
	this.AddTask=function(dialog,title)
	{
		var item=new TaskbarItem(dialog,title);
		items[System.GenerateUniqueId()]=item;	
		m_ItemContainer.appendChild(item.Item);
		m_Count++;
		ResizeContainer();
		return item;
	}
	
	this.RemoveTask=function(item)
	{
		for(var k in items)
		{
			if(items[k]==item)
			{
				m_ItemContainer.removeChild(items[k].Item);
				delete items[k];
				m_Count--;
				ResizeContainer();
				break;
			}
		}
	}
	
	m_BtnLeft.SetVisible(false);
	m_BtnRight.SetVisible(false);
	CalcScrollUnit();
}
	
var MoveVar=null;

function body_onmousemove(evt)
{
	if(MoveVar!=null)
	{
		if(evt==undefined) evt=event;
		MoveVar.Object.scrollLeft=MoveVar.PreScrollLeft-(evt.clientX-MoveVar.PreClientX);
	}
}

function body_onmouseup(evt)
{
	MoveVar=null;
}

if(document.attachEvent)
{
	document.attachEvent(
		"onmousemove",
		function(evt)
		{
			if(evt==null) evt=window.event;
			body_onmousemove(evt);
		}
	);
	document.attachEvent(
		"onmouseup",
		function(evt)
		{
			if(evt==null) evt=window.event;
			body_onmouseup(evt);
		}
	);
}
else if(document.addEventListener)
{
	document.addEventListener(
		"mousemove",
		function(evt)
		{
			if(evt==null) evt=window.event;
			return body_onmousemove(evt);
		},
		false
	)
	document.addEventListener(
		"mouseup",
		function(evt)
		{
			if(evt==null) evt=window.event;
			return body_onmouseup(evt);
		},
		false
	)
}