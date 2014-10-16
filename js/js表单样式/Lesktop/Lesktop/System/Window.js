var Control = null;
var AnchorStyle=null;
var Controls=null;

function init(completeCallback,errorCallback)
{
	System.LoadModules(
		function()
		{				
			Controls=System.GetModule("Controls.js");
			
			Control=System.GetModule("Controls.js").Control;
			AnchorStyle=System.GetModule("Controls.js").AnchorStyle;
			completeCallback();
		},
		errorCallback,
		["Controls.js"]
	);
}

function WindowList_Ctor()
{
	var This=this;
	
	var _all=[];
	
	This.Add=function(wnd)
	{
		var maxIndex=parseInt(_all.length==0?2000:_all[_all.length-1].GetZIndex());
		wnd.SetZIndex(maxIndex+1);
		_all.push(wnd);
	}
	
	This.Remove=function(wnd)
	{
		for(var i in _all)
		{
			if(_all[i]==wnd) break;
		}
		if(i<_all.length) _all.splice(i,1);
	}
	
	This.BringToTop=function(wnd)
	{
		This.Remove(wnd);
		This.Add(wnd);
		//wnd.Focus();
	}
	
	This.IsTop=function(wnd)
	{
		return _all[_all.length-1]==wnd;
	}
}

var WindowList=new WindowList_Ctor();

var moveVar=null;
var resizeVar=null;

function body_onmousemove(evt)
{	
	if(moveVar!=null)
	{
		if(evt.clientX < 0 || evt.clientX > Desktop.GetWidth() || evt.clientY < 0 || evt.clientY > Desktop.GetHeight()) return;
		
		var newLeft = moveVar.Left+(evt.clientX-moveVar.MouseLeft);
		var newTop = moveVar.Top+(evt.clientY-moveVar.MouseTop);
		moveVar.NewLeft = newLeft;
		moveVar.NewTop = newTop;
		displayWindowBorder(moveVar.NewLeft,moveVar.NewTop);
	}
	else if(resizeVar!=null)
	{
		if(evt.clientX < 0 || evt.clientX > Desktop.GetWidth() || evt.clientY < 0 || evt.clientY > Desktop.GetHeight()) return;
		
		var newLeft = resizeVar.NewLeft;
		var newTop = resizeVar.NewTop;
		var newWidth = resizeVar.NewWidth;
		var newHeight = resizeVar.NewHeight;
		
		var diffX=evt.clientX-resizeVar.MouseLeft
		var diffY=evt.clientY-resizeVar.MouseTop
		switch(resizeVar.Type)
		{
		case 0:
			newWidth=resizeVar.Width-diffX;
			newHeight=resizeVar.Height-diffY;
			newLeft=resizeVar.Left+diffX;
			newTop=resizeVar.Top+diffY;
			break;
		case 1:
			newHeight=resizeVar.Height-diffY;
			newTop=resizeVar.Top+diffY;
			break;
		case 2:
			newWidth=resizeVar.Width+diffX;
			newHeight=resizeVar.Height-diffY;
			newTop=resizeVar.Top+diffY;
			break;
		case 3:
			newWidth=resizeVar.Width-diffX;
			newLeft=resizeVar.Left+diffX;
			break;
		case 5:
			newWidth=resizeVar.Width+diffX;
			break;
		case 6:
			newWidth=resizeVar.Width-diffX;
			newHeight=resizeVar.Height+diffY;
			newLeft=resizeVar.Left+diffX;
			break;
		case 7:
			newHeight=resizeVar.Height+diffY;
			break;
		case 8:
			newHeight=resizeVar.Height+diffY;
			newWidth=resizeVar.Width+diffX;
			break;
		}
		
		
		if(newWidth>=resizeVar.MinWidth)
		{
			resizeVar.NewLeft = newLeft;
			resizeVar.NewWidth = newWidth;
		}
		
		if(newHeight>=resizeVar.MinHeight)
		{
			resizeVar.NewTop = newTop;
			resizeVar.NewHeight = newHeight;
		}
		
		displayWindowBorder(resizeVar.NewLeft,resizeVar.NewTop,resizeVar.NewWidth,resizeVar.NewHeight);
	}
}

function body_onmouseup(evt)
{
	if(moveVar!=null)
	{
		hideWindowBorder();
		moveVar.Window.MoveEx('',moveVar.NewLeft,moveVar.NewTop);
		delete moveVar;
		moveVar=null;
	}
	else if(resizeVar!=null)
	{
		hideWindowBorder();
		resizeVar.Window.MoveEx('',resizeVar.NewLeft,resizeVar.NewTop);
		resizeVar.Window.Resize(resizeVar.NewWidth,resizeVar.NewHeight);
		delete resizeVar;
		resizeVar=null;
	}
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

	
var windowBorder=document.createElement("DIV");
var appendWindowBorder=false;
windowBorder.style.position="absolute";
windowBorder.style.display='none';
windowBorder.style.zIndex='10000';
windowBorder.style.borderStyle="solid";
windowBorder.style.borderColor="#666666";
windowBorder.style.borderWidth='4px';

var dropDiv=document.createElement("DIV");
dropDiv.style.position="absolute";
dropDiv.style.display='none';
dropDiv.style.zIndex='9999';
dropDiv.style.left='0px';
dropDiv.style.top='0px';
dropDiv.className='dropDiv';
dropDiv.setAttribute("unselectable","on");

function displayWindowBorder(left,top,width,height)
{
	if(left!=undefined && top!=undefined)
	{
		var scrollLeft=document.body.scrollLeft+document.documentElement.scrollLeft;
		var scrollTop=document.body.scrollTop+document.documentElement.scrollTop;
		windowBorder.style.left=(scrollLeft+left)+"px";
		windowBorder.style.top=(scrollTop+top)+"px";
	}
	if(width!=undefined) windowBorder.style.width=(width-8)+"px";
	if(height!=undefined) windowBorder.style.height=(height-8)+"px";
	windowBorder.style.display='block';
	
	dropDiv.style.width=document.documentElement.clientWidth+'px';
	dropDiv.style.height=document.documentElement.clientHeight+'px';
	dropDiv.style.display='block';
}

function hideWindowBorder()
{
	windowBorder.style.display='none'
	dropDiv.style.display='none';
}

/*
config={
	...:继承Control(BorderWidth重写为0)
	Resizable:是否可调整大小,
	Title:{
		Height:高度
		InnerHTML:内容
	}
}
*/

function Window(config)
{
	if(!appendWindowBorder)
	{
		appendWindowBorder=true;
		document.body.appendChild(windowBorder);
		document.body.appendChild(dropDiv);
	}
	
	var This=this;
	
	var baseConfig=System.Clone(config);
	
	baseConfig.BorderWidth=0;

	Control.call(This,baseConfig);
	
	var Base={
		GetType:This.GetType,
		GetClientWidth:This.GetClientWidth,
		GetClientHeight:This.GetClientHeight,
		Resize:This.Resize,
		AddControl:This.AddControl,
		RemoveControl:This.RemoveControl,
		Move:This.Move,
		is:This.is
	}
	
	This.is=function(type){return type==this.GetType()?true:Base.is(type);}
	This.GetType=function(){return "Window";}
	
	This.OnClosed=new Delegate();
	This.OnHided=new Delegate();
	This.onclosing=new Delegate();
	
	var _children=[];
	
	This.AddWindow=function(wnd)
	{
		_children.push(wnd);
	}
	This.RemoveWindow=function(wnd)
	{
		for(var i in _children)
		{
			if(_children[i]==wnd) break;
		}
		if(i<_children.length) _children.splice(i,1);
	}
	This.Recursion={
		GetTopParent:function()
		{
			return _parent==null?This:_parent.Recursion.GetTopParent();
		},
		BringToTop:function()
		{
			WindowList.BringToTop(This);
			for(var i in _children)
			{
				_children[i].Recursion.BringToTop(false,true);
			}
		},
		StatusBeforeHide:true,
		HideSelfAndChildren:function()
		{
			This.Recursion.StatusBeforeHide=This.IsVisible();
			This.GetDom().style.display='none';
			for(var i in _children)
			{
				_children[i].Recursion.HideSelfAndChildren();
			}
			if(!_disableEvent) This.OnHided.Call(This);
		},
		RestoreSelfAndChildren:function()
		{
			This.GetDom().style.display=This.Recursion.StatusBeforeHide?"block":"none";
			for(var i in _children)
			{
				_children[i].Recursion.RestoreSelfAndChildren();
			}
		},
		ShowSelfAndParent:function()
		{
			This.GetDom().style.display="block";
			if(_parent!=null) _parent.Recursion.ShowSelfAndParent(true,false);
		}
	}
	This.Show=function(isTop)
	{
		This.Recursion.ShowSelfAndParent();
		This.SwitchState(_state);
		for(var i in _children)
		{
			_children[i].Recursion.RestoreSelfAndChildren();
		}
		if(isTop) This.BringToTop();
	}
	This.Hide=function()
	{
		This.Recursion.HideSelfAndChildren();
	}
	This.Close=function()
	{
		Desktop.RemoveWindow(This);
		
		for(var i in _children)
		{
			_children[i].Close();
		}
		if(_parent!=null) _parent.RemoveWindow(This);
		This.Dispose();
		This.OnClosed.Call(This);
	}
	This.IsVisible=function()
	{
		return This.GetDom().style.display!='none';
	}
	This.BringToTop=function()
	{
		var topParent=This.Recursion.GetTopParent();
		topParent.Recursion.BringToTop();
	}
	This.IsTop=function()
	{
		for(var i in _children)
		{
			if(_children[i].IsTop()) return true;
		}
		if(WindowList.IsTop(This)) return true;
		return false;
	}	
	This.SetParent=function(newParent)
	{
		if(_parent!=null) _parent.RemoveWindow(This);
		if(newParent!=null) newParent.AddWindow(This);
		_parent=newParent;
	}
	This.GetParent=function()
	{
		return _parent;
	}
	
	var _disableEvent=false;
	
	This.DisableEvent=function(newValue)
	{
		if(newValue!=undefined) _disableEvent=newValue;
	}
	This.GetZIndex=function()
	{
		return This.GetDom().style.zIndex; 
	}	
	This.SetZIndex=function(newIndex)
	{
		This.GetDom().style.zIndex=newIndex;
	}
	This.GetTitle=function()
	{
		return domTitle.childNodes[1].innerHTML;
	}
	This.SetTitle=function(newTitle)
	{
		domTitle.childNodes[1].innerHTML=newTitle;
	}
	This.Disable=function()
	{
		disableLayer.style.width=This.GetDom().style.width;
		disableLayer.style.height=This.GetDom().style.height;
		disableLayer.style.left='0px';
		disableLayer.style.top='0px';
		disableLayer.style.display='block';
	}
	This.Enable=function()
	{
		disableLayer.style.display='none';
	}
	This.IsDisabled=function()
	{
		return disableLayer.style.display=='block';
	}
	
	var m_WaitingClock=null;
	var m_WaitingCount=0;
	
	This.Waiting=function(text)
	{
		/*if(time!=undefined)
		{
			m_WaitingClock=setTimeout(
				function()
				{
					This.SwitchState("waiting");
				},
				time
			);
		}
		else
		{
			m_WaitingClock=null;
			This.SwitchState("waiting");
		}*/
		if(m_WaitingCount==0)
		{
			This.SwitchState("waiting");
		}
		if(text!=undefined) m_WaitingText.GetDom().innerHTML=text;
		m_WaitingCount++;
		return _client;
	}
	This.Completed=function()
	{
		//if(m_WaitingClock!=null) clearTimeout(m_WaitingClock);
		if(m_WaitingCount>0)
		{
			m_WaitingCount--;
			if(m_WaitingCount==0) This.SwitchState("normal");
		}
	}
	This.ShowDialog=function(parent,pos,left,top,callback)
	{
		if(parent!=undefined && parent!=null && parent.is!=undefined && parent.is("Window"))
		{
			This.SetParent(parent);
			parent.Disable();
		}
		if(pos!=undefined) This.MoveEx(pos,left,top,true);
		This.OnClosed.Attach(
			function(wnd)
			{
				var parent=This.GetParent();
				if(parent!=null) parent.Enable();
				if(callback!=undefined) callback(This);
			}
		);
		This.Show(true);
	}
	
	This.GetClientWidth=function(){return This.GetWidth()-_borderWidth*2;}
	This.GetClientHeight=function(){return This.GetHeight()-_title.Height-_borderWidth*2;}
	//移动窗口
	
	function move(position,x,y,relativeParent)
	{
		var left,top;
		
		var width=This.GetWidth();
		var height=This.GetHeight();
		
		if(x==undefined || x==null) x=0;
		if(y==undefined || y==null) y=0;
		
		if(_parent==undefined || _parent==null) relativeParent=false;
		
		var rect=null;
		if(relativeParent && _parent!=null)
			rect={Width:_parent.GetWidth(),Height:_parent.GetHeight(),Top:_parent.GetTop(),Left:_parent.GetLeft()};
		else
			rect={Width:Desktop.GetWidth(),Height:Desktop.GetHeight(),Top:0,Left:0};
			
		position=position.toUpperCase();
		
		var align;
		var verticalAlign;
		
		if(position=='CENTER')
		{
			align="MIDDLE";
			verticalAlign="MIDDLE";
		}
		else
		{
			var ps=position.split("|");
			align=ps.length>0?ps[0]:"NULL";
			verticalAlign=ps.length>1?ps[1]:"NULL";
		}
		
		switch(align)
		{
		case "LEFT":
			left=0;
			break;
		case "RIGHT":
			left=rect.Width-width;
			break;
		case "MIDDLE":
			left=Math.round((rect.Width-width)/2);
			break;
		default:
			left=0;
		}
		left+=rect.Left+x;
		
		switch(verticalAlign)
		{
		case "TOP":
			top=0;
			break;
		case "BOTTOM":
			top=rect.Height-height;
			break;
		case "MIDDLE":
			top=Math.round((rect.Height-height)/2);
			break;
		default:
			top=0;
		}
		top+=rect.Top+y;
		
		if(left<0) left=0;
		if(top<0) top=0;
		Base.Move(left,top);
	}
	
	This.Move=function(x,y)
	{
		move("",x,y,true);
	}
	
	This.MoveEx=function(position,x,y,relativeParent)
	{
		move(position,x,y,relativeParent);
	}
	
	function resize(newWidth,newHeight)
	{
		Base.Resize(newWidth,newHeight);
		
		m_BkImage.Resize(newWidth,newHeight);
		
		var ws=[_borderWidth,newWidth-_borderWidth*2,_borderWidth]
		var hs=[_borderWidth,newHeight-_borderWidth*2,_borderWidth]
		
		for(var y=0;y<=2;y++)
		{
			for(var x=0;x<=2;x++)
			{
				var i=y*3+x;
				This.GetDom().firstChild.childNodes[i].style.width=ws[x]+'px';
				This.GetDom().firstChild.childNodes[i].style.height=hs[y]+'px';
				This.GetDom().firstChild.childNodes[i].style.margin="0px";
				This.GetDom().firstChild.childNodes[i].style.padding="0px";
				if(i!=4)
				{
					This.GetDom().firstChild.childNodes[i].style.fontSize="2px";
				}
			}
		}
		
		m_DomBackground.style.width=newWidth+'px';
		m_DomBackground.style.height=newHeight+'px';
		m_DomBackground.style.margin="0px";
		m_DomBackground.style.padding="0px"; 
		m_DomBackground.style.borderWidth="0px";
		
		domTitle.style.width=ws[1]+'px';
		domTitle.style.height=_title.Height+'px';
		domTitle.style.margin="0px";
		domTitle.style.padding="0px"; 
		domTitle.style.borderWidth="0px";
					
		domClient.style.width=(ws[1])+'px';
		domClient.style.height=(hs[1]-_title.Height)+'px';
		domClient.style.margin="0px";
		domClient.style.padding="0px";
		domClient.style.borderWidth="0px";
		
		disableLayer.style.width=This.GetDom().style.width;
		disableLayer.style.height=This.GetDom().style.height;
		disableLayer.style.left='0px';
		disableLayer.style.top='0px';
	}
	
	This.Resize=function(newWidth,newHeight)
	{
		resize(newWidth,newHeight);
	}
	
	//======================================================================
	//初始化
	//读取配置
	var _css='',_borderWidth=6,_resizable=true,_parent,_hasMinButton=true;
	var _title={Height:18,InnerHTML:""};
	
	if(config.Css!=undefined) _css=config.Css;
	if(config.BorderWidth!=undefined) _borderWidth=config.BorderWidth;
	if(config.Resizable!=undefined) _resizable=config.Resizable;
	if(config.HasMinButton!=undefined) _hasMinButton=config.HasMinButton;
	if(config.Title!=undefined)
	{
		if(config.Title.Height!=undefined) _title.Height=config.Title.Height;
		if(config.Title.InnerHTML!=undefined) _title.InnerHTML=System.ReplaceHtml(config.Title.InnerHTML);
	}

	var _id=System.GenerateUniqueId();
	var dom=This.GetDom();
	dom.tabIndex=-1;
	dom.style.outline='none';
	dom.id=_id;
	dom.innerHTML=(
		"<div style='position:absolute; z-Index:1;'>"+
			"<div class='border_nw' style='float:left; cursor:nw-resize; z-index:0;'></div>"+
			"<div class='border_n' style='float:left; cursor:n-resize; z-index:0;'></div>"+
			"<div class='border_ne' style='float:left; cursor:ne-resize; z-index:0;'></div>"+
			"<div class='border_w' style='float:left; cursor:w-resize; z-index:0;'></div>"+
			"<div style='float:left; cursor:-resize; z-index:0; overflow:hidden;'>"+
				"<div class='title'>"+
					"<div class='icon' style='float:left;'></div>"+
					"<div class='text' style='float:left;'></div>"+
					"<div class='closeButton' style='float:right;'></div>"+
					"<div class='maxButton' style='float:right;'></div>"+
					"<div class='restoreButton' style='float:right;'></div>"+
					"<div class='minButton' style='float:right;'></div>"+
					"<div class='custom' id='{ID}_Custom'></div>"+
				"</div>"+
				"<div class='content' style='overflow:hidden;' ></div>"+
			"</div>"+
			"<div class='border_e' style='float:left; cursor:e-resize; z-index:0;'></div>"+
			"<div class='border_sw' style='float:left; cursor:sw-resize; z-index:0;'></div>"+
			"<div class='border_s' style='float:left; cursor:s-resize; z-index:0;'></div>"+
			"<div class='border_se' style='float:left; cursor:se-resize; z-index:0;'></div>"+
		"</div>"+
		"<div style='position:absolute;display:none;' class='disabled'></div>"
	).replace(/{ID}/g, _id);

	dom.style.overflow = "hidden";
	
	var m_DomBackground=dom.firstChild;
	var domTitle=dom.firstChild.childNodes[4].childNodes[0];
	var domClient=dom.firstChild.childNodes[4].childNodes[1];
	var closeBtn=domTitle.childNodes[2];
	var maxBtn=domTitle.childNodes[3];
	var restoreBtn=domTitle.childNodes[4];
	var minBtn=domTitle.childNodes[5];
	var disableLayer=dom.childNodes[1];
	
	var m_MinHeight=IsNull(config.MinHeight,300);
	var m_MinWidth=IsNull(config.MinWidth,400);
	
	minBtn.style.display=_hasMinButton?"block":"none";
	maxBtn.style.display=(_resizable && _hasMinButton)?"block":"none";
	restoreBtn.style.display="none";

	var m_BkImage = new Controls.HtmlControlBkImage(
		IsNull(config.BkImage,{ Horiz: [6, 100, 6], Vertical: [24, 100, 6], Css: "window_bk" })
	);
	
	m_BkImage.GetDom().style.position="absolute";
	m_BkImage.GetDom().style.zIndex="0";
	
	dom.appendChild(m_BkImage.GetDom());
	
	dom.onkeydown=function(evt)
	{
		if(evt==undefined) evt=event;
		if(!This.IsDisabled())
		{
			if(evt.keyCode==13)
			{
				if(m_AcceptButton!=null) m_AcceptButton.Click();
			}
			else if(evt.keyCode==27)
			{
				if(m_CancelButton!=null) m_CancelButton.Click();
			}
		}
	}
	
	dom.onmousedown=function()
	{
		This.BringToTop();
	}
	
	domTitle.onmousedown=function(evt)
	{
		if(m_IsMaxinum) return;
		
		if(evt==undefined) evt=event;
		var target=null;
		if(evt.srcElement!=undefined) target=evt.srcElement;
		if(evt.target!=undefined) target=evt.target;
		if(target!=closeBtn && target!=minBtn && target!=maxBtn && target!=restoreBtn)
		{
			moveVar={
				Window:This,
				MouseLeft:evt.clientX,
				MouseTop:evt.clientY,
				ScrollLeft:document.documentElement.scrollLeft,
				ScrollTop:document.documentElement.scrollTop,
				Left:This.GetLeft(),
				Top:This.GetTop(),
				NewLeft:This.GetLeft(),
				NewTop:This.GetTop()
			}
			
			displayWindowBorder(This.GetLeft(),This.GetTop(),This.GetWidth(),This.GetHeight());
			This.BringToTop();
		}
	}
					
	for(var i=0;i<=8;i++)
	{
		if(i!=4)
		{
			(function(rbs_type)
			{
				This.GetDom().firstChild.childNodes[i].onmousedown=function(evt)
				{
					if(m_IsMaxinum) return;
					if(_resizable)
					{
						if(evt==null) evt=window.event;
						resizeVar={
							Left:This.GetLeft(),
							Top:This.GetTop(),
							NewLeft:This.GetLeft(),
							NewTop:This.GetTop(),
							Width:This.GetWidth(),
							Height:This.GetHeight(),
							NewWidth:This.GetWidth(),
							NewHeight:This.GetHeight(),
							MouseLeft:evt.clientX,
							MouseTop:evt.clientY,
							Type:rbs_type,
							MinWidth:m_MinWidth,
							MinHeight:m_MinHeight,
							Window:This
						}
						displayWindowBorder(This.GetLeft(),This.GetTop(),This.GetWidth(),This.GetHeight());
						This.BringToTop();
					}
				};
			})(i);
		}
	}
	closeBtn.onclick=function(evt)
	{
		if(evt==undefined) evt=event;
		if(config.OnClose==undefined)
			This.Close();
		else
			config.OnClose();
		return true;
	}
	minBtn.onclick=function(evt)
	{
		if(evt==undefined) evt=event;
		This.Hide();
		return true;
	}
	
	var m_Restore={
		Left:0,Top:0,Width:100,Height:100,AnchorStyle:0
	};
	var m_IsMaxinum=false;
	
	restoreBtn.onclick=function(evt)
	{
		This.MoveEx("Left|Top",m_Restore.Left,m_Restore.Top);
		This.Resize(m_Restore.Width,m_Restore.Height);
		This.SetAnchorStyle(m_Restore.AnchorStyle);
		
		m_IsMaxinum=false;
		
		restoreBtn.style.display='none';
		maxBtn.style.display='block';
		return true;
	}

	This.Maximun = function()
	{
		maxinum();
	}

	function maxinum()
	{
		m_Restore.Left = This.GetLeft();
		m_Restore.Top = This.GetTop();
		m_Restore.Width = This.GetWidth();
		m_Restore.Height = This.GetHeight();
		m_Restore.AnchorStyle = This.GetAnchorStyle();
		restoreBtn.style.display = 'block';
		maxBtn.style.display = 'none';

		This.MoveEx("Left|Top", 0, 0);
		This.Resize(Desktop.GetClientWidth(), Desktop.GetClientHeight());
		This.SetAnchorStyle(AnchorStyle.All);

		m_IsMaxinum = true;
	}

	maxBtn.onclick = function(evt)
	{
		maxinum();
		return true;
	}
	domTitle.childNodes[1].innerHTML = System.ReplaceHtml(_title.InnerHTML);
	
	var _state="normal";
	This.SwitchState=function(state)
	{
		if(state==undefined) state=_state;
		if(This.IsDisabled())
		{
			This.Disable();
		}
		else
		{
			switch(state)
			{
			case 'normal':
				{
					This.Enable();
					//IE在父DIV隐藏状态下无法隐藏子DIV ，因此如果窗口此时是隐藏的，延迟到显示窗口时在隐藏
					if(This.IsVisible()) _waiting.SetVisible(false);
					break;
				}
			case 'waiting':
				{
					This.Enable();
					_waiting.SetVisible(true);
					break;
				}
			}
		}
		_state=state;
	}
	
	var _client=new Control(
		{
			Left:_borderWidth,
			Top:_borderWidth+_title.Height,
			Width:This.GetClientWidth(),
			Height:This.GetClientHeight(),
			AnchorStyle:AnchorStyle.All,
			BorderWidth:0,
			Parent:This,
			Css:IsNull(config.ClientCss,"")
		}
	);

	_client.GetDom().style.overflow = "hidden";
	_client.GetDom().style.zIndex = "2";
	
	var _waiting=new Control(
		{
			Left:_borderWidth+1,
			Top:_borderWidth+_title.Height+1,
			Width:This.GetClientWidth(),
			Height:This.GetClientHeight(),
			AnchorStyle:AnchorStyle.All,
			BorderWidth:0,
			Parent:This,
			Css:IsNull(config.Waiting,"waiting")
		}
	);
	
	var m_WaitingText=new Control(
		{
			Left:0,Top:0,Width:_waiting.GetClientWidth(),Height:16,
			Parent:_waiting,
			AnchorStyle:AnchorStyle.Left | AnchorStyle.Top,
			BorderWidth:0,
			Css:"waitingText"
		}
	);
	
	_waiting.OnResized.Attach(
		function()
		{
			m_WaitingText.Move(0,_waiting.GetClientHeight()/2+30);
			m_WaitingText.Resize(_waiting.GetClientWidth(),16);
		}
	);
	
	_waiting.SetVisible(false);
	
	This.AddControl=function(ctl)
	{
		_client.AddControl(ctl);
	}
	
	This.RemoveControl=function(ctl)
	{
		_client.RemoveControl(ctl);
	}
	
	var m_AcceptButton=null;
	var m_CancelButton=null;
	
	This.SetAcceptButton=function(button)
	{
		if(button.is!=undefined && button.is("Button"))
		{
			m_AcceptButton=button;
		}
	}
	
	This.SetCancelButton=function(button)
	{
		if(button.is!=undefined && button.is("Button"))
		{
			m_CancelButton=button;
		}
	}
	This.Focus=function()
	{
		This.GetDom().focus();
	}

	System.AttachEvent(
		This.GetDom(), "mouseup",
		function(evt)
		{
			if (evt == undefined) evt = window.event;
			if (System.GetButton(evt) == "Right")
			{
				System.CancelBubble(evt);
			}
		}
	);
	
	Desktop.AddWindow(This);
	dom=null;
	
	WindowList.Add(This);
	This.GetDom().style.display='none';
	This.SetParent(IsNull(config.Parent,null));
	This.Move("",This.GetLeft(),This.GetTop())
	This.Resize(IsNull(config.Width,600),IsNull(config.Height,450));
	
}

Module.Window=Window;