

var Control=null;
var Controls=null;

var PageTemp=
	"<html>\r\n"+
		"<head>\r\n"+
		"</head>\r\n"+
		"<body>\r\n"+
		"</body>\r\n"+
	"</html>\r\n";

var Fonts=[
	"宋体",
	"雅黑",
	"Arial",
	"Courier New",
	"Times New Roman",
	"Verdana"
];

function init(completeCallback,errorCallback)
{
	System.LoadModules(
		function()
		{			
			Control=System.GetModule("Controls.js").Control;
			
			Controls=System.GetModule("Controls.js");
			
			completeCallback();
		},
		errorCallback,
		["Controls.js"]
	);
}

function SetNodeStyle(doc,node,name,value)
{
	if(System.IsTextNode(node))
	{
		return node;
	}
	else
	{
		node.style[name]=value;
		
		for(var i=0;i<node.childNodes.length;i++)
		{
			var cn=node.childNodes[i];
			if(!System.IsTextNode(node))
			{
				SetNodeStyle(doc,cn,name,value);
			}
		}
	
		return node;
	}
}

function SetStyle(doc,html,name,value)
{
	var dom=doc.createElement("DIV");
	dom.innerHTML=html;
		
	for(var i=0;i<dom.childNodes.length;i++)
	{
		var node=dom.childNodes[i];
		
		if(System.IsTextNode(node))
		{
			var span=doc.createElement("SPAN");
			span.style[name] = value;
			if (node.nodeValue != undefined) span.innerHTML = node.nodeValue.replace(/\</ig, function() { return "&lt;"; });
			else if (node.textContent != undefined) span.innetHTML = node.textContent.replace(/\</ig, function() { return "&lt;"; });
			dom.replaceChild(span,node);
		}
		else
		{
			SetNodeStyle(doc,node,name,value);
		}
	}
	
	return dom.innerHTML;
}


/*
config={
	...：继承Controls
}
*/

function RichEditor(config)
{
    var This=this;

    Control.call(This,config);
    
    var Base={
        GetType:This.GetType,
        is:This.is
    }
    
    This.is=function(type){return type==This.GetType()?true:Base.is(type);}
    This.GetType=function(){return "RichEditor";}
    
	var m_Toolbar=new Controls.Toolbar(
		{
			Left:0,Top:0,Width:This.GetClientWidth(),Height:24,
			BorderWidth:0,Css:'toolbar',
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Top,
			Text:"",
            Items:[
				{Css:"Image22_B",Text:"",Command:"B"},
				{Css:"Image22_I",Text:"",Command:"I"},
				{Css:"Image22_U",Text:"",Command:"U"},
				{Type:"DropDownList",Width:120},
				{Type:"DropDownList",Width:50},
				{Css:"Image22_Clear",Text:"清除格式",Command:"Clear"},
				{Css:"Image22_Emotion",Text:"表情",Command:"AddEmotion"},
				{Css:"Image22_Picture",Text:"图片",Command:"AddImage"},
				{Css:"Image22_Acc",Text:"文件",Command:"AddFile"}
			]
		}
	);
	
	for(var i in Fonts)
	{
		m_Toolbar.GetControl(3).AddItem(Fonts[i]);
	}
	m_Toolbar.GetControl(3).SetValue(Fonts[0]);
	System.DisableSelect(m_Toolbar.GetControl(3).GetDom(),true);
	System.DisableSelect(m_Toolbar.GetControl(3).GetListDom(),true);
	
	m_Toolbar.GetControl(3).OnChanged.Attach(
		function()
		{
			m_EditorDoc.execCommand("FontName",false,m_Toolbar.GetControl(3).GetValue());
		}
	);
	
	for (var i = 12; i <= 24; i += 2)
	{
		m_Toolbar.GetControl(4).AddItem(i);
	}
	for (var i = 36; i <= 72; i += 12)
	{
		m_Toolbar.GetControl(4).AddItem(i);
	}
	m_Toolbar.GetControl(4).SetValue(12);
	System.DisableSelect(m_Toolbar.GetControl(4).GetDom(),true);
	System.DisableSelect(m_Toolbar.GetControl(4).GetListDom(),true);
	
	m_Toolbar.GetControl(4).OnChanged.Attach(
		function()
		{
			var html=This.GetSelectionHtml();
			This.SaveSelection();
			This.ReplaceSaveSelection(SetStyle(m_EditorDoc,html,"fontSize",m_Toolbar.GetControl(4).GetText()+"px"));
		}
	);
	
	var m_LastImagePath=System.GetFullPath("Home");
	
	m_Toolbar.OnCommand.Attach(
		function(command)
		{
			switch(command)
			{
			case "B":
				{
					m_EditorDoc.execCommand("Bold",false,null);
					m_EditorWindow.focus();
					break;
				}
			case "I":
				{
					m_EditorDoc.execCommand("Italic",false,null);
					m_EditorWindow.focus();
					break;
				}
			case "U":
				{
					m_EditorDoc.execCommand("Underline",false,null);
					m_EditorWindow.focus();
					break;
				}
			case "A":
				{
					m_EditorDoc.execCommand("CreateLink",false);
					m_EditorWindow.focus();
					break;
				}
			case "Clear":
				{
					var html=This.GetSelectionHtml();
					This.SaveSelection();
					var temp=m_EditorDoc.createElement("DIV");
					temp.innerHTML=html;
					This.ReplaceSaveSelection(System.ClearHtml(temp));
					break;
				}
			case "AddEmotion":
				{
					/*System.LoadModules(
						function()
						{
							var CommonDialog=System.GetModule("CommonDialog.js");
							This.SaveSelection();
							CommonDialog.OpenImage(
								{
									InitPath:System.GetSpecialDirectory("PublicImages")+"/表情/QFACE"
								},
								m_Toolbar.GetTopContainer(),
								addImage
							);
			    			
							function addImage(path)
							{
								var imgHTML=String.format(
									"<img src='download.los?FileName={0}'/>",
									escape(path)
								);
								if(!This.ReplaceSaveSelection(imgHTML))
								{
									This.Append(imgHTML);
								}
							}
						},
						alert,
						["CommonDialog.js"]
					);*/
					break;
				}
			case "AddImage":
				{
					/*System.LoadModules(
						function()
						{
							var CommonDialog=System.GetModule("CommonDialog.js");
							This.SaveSelection();
							CommonDialog.OpenImage(
								{
									InitPath:m_LastImagePath
								},
								m_Toolbar.GetTopContainer(),
								addImage
							);
			    			
							function addImage(path)
							{
								m_LastImagePath=System.Path.GetDirectoryName(path);
								var imgHTML=String.format(
									"<img src='download.los?FileName={0}'/>",
									escape(path)
								);
								if(!This.ReplaceSaveSelection(imgHTML))
								{
									This.Append(imgHTML);
								}
							}
						},
						alert,
						["CommonDialog.js"]
					);*/
					break;
				}
			case "AddFile":
				{
					/*System.LoadModules(
						function()
						{
							var CommonDialog=System.GetModule("CommonDialog.js");
							This.SaveSelection();
							CommonDialog.OpenFile(
								{InitPath:"/"+System.GetUser()+"/Home"},
								m_Toolbar.GetTopContainer(),
								addFiles
							);
			    			
							function addFiles(paths)
							{
								var html = This.CreateFileHtml(paths);
								if(!This.ReplaceSaveSelection(html))
								{
									This.Append(html);
								}
							}
						},
						alert,
						["CommonDialog.js"]
					);*/
					break;
				}
			}
		}
	);
	
	This.CreateFileHtml=function(paths)
	{
		var ret="";
		for(var i in paths)
		{
			var aHTML=String.format(
				"<a href='download.los?FileName={{Accessory {0}}' target='_blank'>{1}</a>",
				escape(String.format("src='{0}'",paths[i])),
				System.IO.Path.GetFileName(escape(paths[i]))
			);
			ret += aHTML;
		}
		return ret;
	}
	
    var m_Editor=new Editor();
    var m_Frame=m_Editor.GetFrame();
    var m_EditorDoc=m_Editor.GetFrame().contentWindow.document;
    var m_EditorWindow=m_Editor.GetFrame().contentWindow;
    
    if(System.GetBrowser()=="Firefox")
    {
		m_Frame.onload=function()
		{
			m_EditorDoc.designMode="on";
		}
	}
	else
	{
		m_EditorDoc.designMode="on";
    }
    m_EditorDoc.open();
    m_EditorDoc.write(PageTemp);
    m_EditorDoc.close();
	
	var range=null;
	
	This.SaveSelection=function()
	{
		if(System.GetBrowser()=="IE")
		{
			range=m_EditorDoc.selection.createRange();
			if(range.parentElement().document!=m_EditorDoc)
			{
				range = null;
			}
		}
		else if(System.GetBrowser()=="Firefox" || System.GetBrowser()=="Chrome")
		{
			var sel=m_EditorWindow.getSelection();
			if(sel.rangeCount>0) range=sel.getRangeAt(0);else range = null;
		}
	}
	
	This.GetSelectionHtml=function()
	{
		if(System.GetBrowser()=="IE")
		{
			var r=m_EditorDoc.selection.createRange();
			if(r.htmlText!=undefined) return r.htmlText;else return "";
		}
		else if(System.GetBrowser()=="Firefox" || System.GetBrowser()=="Chrome")
		{
			var sel = m_EditorWindow.getSelection();
			if (sel.rangeCount > 0)
			{
				var r = null;
				r = sel.getRangeAt(0);
				return System.GetInnerHTML(r.cloneContents().childNodes);
			}
			else
			{
				return "";
			}
		}
		else
		{
			return "";
		}
	}
	
	This.ReplaceSaveSelection=function(html)
	{
		if(range!=null)
		{
			if(System.GetBrowser()=="IE")
			{
				if(range.pasteHTML!=undefined)
				{
					range.select();
					range.pasteHTML(html);
					return true;
				}
			}
			else if(System.GetBrowser()=="Firefox" || System.GetBrowser()=="Chrome")
			{
				if(range.deleteContents != undefined && range.insertNode!=undefined)
				{
					var temp=m_EditorDoc.createElement("DIV");
					temp.innerHTML=html;
					
					var elems=[];
					for(var i = 0 ;i<temp.childNodes.length;i++)
					{
						elems.push(temp.childNodes[i]);
					}
					
					range.deleteContents();
					
					for(var i in elems)
					{
						temp.removeChild(elems[i]);
						range.insertNode(elems[i]);
					}
					return true;
				}
			}
		}
		return false;
	}
    
    this.Blur=function()
    {
		m_Editor.Blur();
    }
		
	this.Append=function(content)
	{
	    m_EditorDoc.body.innerHTML+=content;
	}
	
	this.GetValue=function()
	{
		return m_EditorDoc.body.innerHTML;
	}
	
	this.SetValue=function(newValue)
	{
		if(newValue!=undefined && newValue!=null) 
		{
			m_EditorDoc.body.innerHTML=newValue;
		}
	}
	
	this.Focus=function()
	{
		m_EditorWindow.focus();
	}
	
	this.GetDocument=function()
	{
		return m_EditorDoc;
	}
	
	this.GetFrame=function()
	{
		return m_Frame;
	}
	
	this.GetWindow=function()
	{
		return m_EditorWindow;
	}
	
	this.OnKeyDown=new Delegate();
	
	System.AttachEvent(
		m_EditorDoc,
		"keydown",
		function(evt)
		{
			if(evt==undefined) evt=m_EditorWindow.event;
			This.OnKeyDown.Call(evt);
		}
	);
	
    if(config.StyleSheet)
		m_Editor.Link("StyleSheet",config.StyleSheet,"text/css");
    
    This.SetCss("richEditor");
    
    function Editor()
    {
		var editor=this;
	    
		var editorConfig={
			Left:0,Top:24,Width:This.GetClientWidth(),Height:This.GetClientHeight()-24,
			BorderWidth:0,Css:'editor',
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.All
		};
		
		Controls.Frame.call(this,editorConfig);
	    
		var Base={
			GetType:this.GetType,
			is:this.is
		}
    
		editor.is=function(type){return type==this.GetType()?true:Base.is(type);}
		editor.GetType=function(){return "RichEditor.Editor";}
    }
    
}


Module.RichEditor=RichEditor;
		