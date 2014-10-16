
function init(completeCallback, errorCallback)
{
	completeCallback();
}

function GetButton(evt)
{
	if ((evt.which != undefined && evt.which == 1) || evt.button == 1)
		return "Left";
	else if ((evt.which != undefined && evt.which == 3) || evt.button == 2)
		return "Right"
}
/*
config={
	Horiz:[],Vertical:[],
	Css:
}
*/
function HtmlControlBkImage(config)
{
	var m_Config=System.Clone(config);
	
	var m_Dom=document.createElement("DIV");
	
	m_Dom.innerHTML=
	"<table cellspacing='0' cellpadding='0'>"+
		"<tbody>"+
			"<tr><td></td><td></td><td></td></tr>"+
			"<tr><td></td><td></td><td></td></tr>"+
			"<tr><td></td><td></td><td></td></tr>"+
		"</tbody>"+
	"</table>";
	
	m_Dom.className = m_Config.Css;
	
	m_Dom.style.left="0px";
	m_Dom.style.top="0px";
	
	function resize(width,height)
	{
		var xs = [m_Config.Horiz[0], width - (m_Config.Horiz[0] + m_Config.Horiz[2]), m_Config.Horiz[2]];
		var ys = [m_Config.Vertical[0], height - (m_Config.Vertical[0] + m_Config.Vertical[2]), m_Config.Vertical[2]];

		for (var x = 0; x < 3; x++)
		{
			for (var y = 0; y < 3; y++)
			{
				var cell = m_Dom.firstChild.rows[y].cells[x];
				cell.style.width = xs[x] + 'px';
				cell.style.height = ys[y] + 'px';
			}
		}
	}
	
	this.Resize=resize;

	this.GetDom = function() { return m_Dom; };
	
	for (var x = 0; x < 3; x++)
	{
		for (var y = 0; y < 3; y++)
		{
			var cell = m_Dom.firstChild.rows[y].cells[x];
			cell.className = m_Config.Css + "_block_" + (y * 3 + x);
			cell.style.padding = '0px';
			cell.style.margin = '0px';
		}
	}
	
	resize(m_Config.Horiz[0] + m_Config.Horiz[1] + m_Config.Horiz[2],m_Config.Vertical[0] + m_Config.Vertical[1] + m_Config.Vertical[2]);
}

Module.HtmlControlBkImage=HtmlControlBkImage;

(function()
{

	function AnchorStyle() { }

	AnchorStyle.Left = 1;
	AnchorStyle.Top = 1 << 1;
	AnchorStyle.Right = 1 << 2;
	AnchorStyle.Bottom = 1 << 3;
	AnchorStyle.All = AnchorStyle.Left | AnchorStyle.Right | AnchorStyle.Top | AnchorStyle.Bottom;

	/*
	config={
	Parent:父控件
    
	Left:左上角x坐标
	Top:右上角y坐标
	Width:宽度
	Height:高度
	AnchorStyle:只能在初始化时赋值
    
	BorderWidth:边框宽度
	Padding:
	Css:样式
	}
	*/
	function Control(config)
	{
		var This = this;
		This.ControlPrivate = {};

		if (config == undefined || config == null) config = {};

		//继承Object
		System.Object.call(This);

		var Base = {
			GetType: This.GetType,
			is: This.is
		}

		This.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
		This.GetType = function() { return "Control"; }

		if (config.Parent != undefined && config.Parent != null)
		{
			if (config.Parent.is == undefined || !config.Parent.is("Control"))
				throw "父控件必须为Control对象";
		}

		var _borderWidth = IsNull(config.BorderWidth, 0);
		This.GetBorderWidth = function() { return _borderWidth; }

		var _padding = IsNull(config.Padding, 0);
		This.GetPadding = function() { return _padding; }

		//框架
		var _dom = document.createElement("DIV");
		_dom.style.overflow = "hidden";
		_dom.style.position = "absolute";
		_dom.style.margin = '0px';
		_dom.style.padding = _padding + 'px';
		_dom.style.borderWidth = _borderWidth + 'px';
		This.GetDom = function() { return _dom; }

		This.GetContextMenu = function() { return null; }

		//位置大小
		var _left = 0, _top = 0, _width = 0, _height = 0;

		This.OnResized = new Delegate();

		This.GetWidth = function() { return _width; }
		This.GetHeight = function() { return _height; }
		This.GetLeft = function() { return _left; }
		This.GetTop = function() { return _top; }

		This.GetClientWidth = function() { return _width - _borderWidth * 2 - _padding * 2; }
		This.GetClientHeight = function() { return _height - _borderWidth * 2 - _padding * 2; }


		This.Move = function(left, top)
		{
			_left = left;
			_top = top;
			_dom.style.left = _left + "px";
			_dom.style.top = _top + "px";
		}

		This.Resize = function(width, height)
		{
			var preWidth = This.GetWidth();
			var preHeight = This.GetHeight();

			for (var index in _controls)
			{
				try
				{
					var ctl = _controls[index];

					var ctlLeft = ctl.GetLeft();
					var ctlTop = ctl.GetTop();
					var ctlWidth = ctl.GetWidth();
					var ctlHeight = ctl.GetHeight();

					var move = false, resize = false;

					switch (ctl.GetAnchorStyle() & (AnchorStyle.Left | AnchorStyle.Right))
					{
					case AnchorStyle.Left | AnchorStyle.Right:
						{
							ctlWidth = ctl.GetWidth() + (width - preWidth);
							resize = true;
							break;
						}
					case AnchorStyle.Right:
						{
							ctlLeft = ctl.GetLeft() + (width - preWidth);
							move = true;
							break;
						}
					case AnchorStyle.Left:
					case 0:
						{
							break;
						}
					}

					switch (ctl.GetAnchorStyle() & (AnchorStyle.Top | AnchorStyle.Bottom))
					{
					case AnchorStyle.Top | AnchorStyle.Bottom:
						{
							ctlHeight = ctl.GetHeight() + (height - preHeight);
							resize = true;
							break;
						}
					case AnchorStyle.Bottom:
						{
							ctlTop = ctl.GetTop() + (height - preHeight);
							move = true;
							break;
						}
					case AnchorStyle.Top:
					case 0:
						{
							break;
						}
					}

					if (move) ctl.Move(ctlLeft, ctlTop);
					if (resize) ctl.Resize(ctlWidth, ctlHeight);
				}
				catch(ex)
				{
					if(DEBUG) alert(ex);
				}
			}

			_width = width;
			_height = height;
			_dom.style.width = (This.GetWidth() - _borderWidth * 2 - _padding * 2) + "px";
			_dom.style.height = (This.GetHeight() - _borderWidth * 2 - _padding * 2) + "px";

			This.OnResized.Call(This);
		}

		//AnchorStyle
		var _anchorStyle = IsNull(config.AnchorStyle, AnchorStyle.Left | AnchorStyle.Top);
		This.GetAnchorStyle = function() { return _anchorStyle; }
		This.SetAnchorStyle = function(val) { _anchorStyle = val; }

		//样式
		This.GetCss = function()
		{
			return _dom.className;
		}
		This.SetCss = function(value)
		{
			_dom.className = value;
		}


		//子控件
		var _controls = new Array();

		This.Foreach = function(handler)
		{
			for (var i in _controls)
			{
				handler(_controls[i]);
			}
		}
		
		This.Clear = function()
		{
			for (var i in _controls)
			{
				var ctl = _controls[i];
				_dom.removeChild(ctl.GetDom());
				ctl.Dispose();
			}
			_controls = [];
		}

		function IndexOf(ctl)
		{
			var i = 0;
			while (i < _controls.length && _controls[i] != ctl) i++;
			return i < _controls.length ? i : -1;
		}

		This.ControlPrivate.SetParent = function(parent)
		{
			_parent = parent;
		}

		//操作
		This.AddControl = function(ctl)
		{
			_controls.push(ctl);
			_dom.appendChild(ctl.GetDom());
			ctl.ControlPrivate.SetParent(This);
		}
		This.RemoveControl = function(ctl)
		{
			var index = IndexOf(ctl);
			_controls.splice(index, 1);
			_dom.removeChild(ctl.GetDom());
			//ctl.ControlPrivate.SetParent(null);
		}
		
		This.GetControlsCount=function()
		{
			return _controls.length;
		}

		var _parent = null;

		This.GetTopContainer = function()
		{
			return (_parent == null || This.is('Window')) ? This : _parent.GetTopContainer();
		}

		This.GetParent = function()
		{
			return _parent;
		}
		This.SetParent = function(value)
		{
			if (_parent != value)
			{
				//从原父控件中移除该控件
				if (_parent != null) _parent.RemoveControl(This);
				_parent = value;
				//在新父控件中插入该控件
				if (_parent != null) _parent.AddControl(This);
			}
		}

		var _visible = true;

		//显示控制
		This.GetVisible = function()
		{
			return _visible;
		}
		This.SetVisible = function(value)
		{
			_dom.style.display = value ? 'block' : 'none';
			_visible = value;
		}

		var _text = "";
		This.GetText = function() { return _text; }
		This.SetText = function(value) { _text = value; }

		This.ContextMenu = null;

		This.OnDispose = new Delegate();
		This.Dispose = function()
		{
			for (var i in _controls)
			{
				_controls[i].Dispose();
			}
			if (This.ContextMenu != null) This.ContextMenu.Dispose();
			This.OnDispose.Call(This);
		}

		System.AttachEvent(
			_dom, "mouseup",
			function(evt)
			{
				if (evt == undefined) evt = window.event;
				if (GetButton(evt) == "Right")
				{
					var menu = This.GetContextMenu();
					if (menu == null) menu = This.ContextMenu;
					if (menu != null)
					{
						menu.Popup(evt.clientX, evt.clientY);
					}
				}
			}
		);

		//初始化位置和大小
		This.Move(IsNull(config.Left, 0), IsNull(config.Top, 0));
		This.Resize(IsNull(config.Width, 200), IsNull(config.Height, 150));
		This.SetCss(IsNull(config.Css, "control"));
		This.SetParent(IsNull(config.Parent, null));
		This.SetVisible(IsNull(config.Visible, true));
	}

	function Label(config)
	{
		var This = this;

		if (config.Css == undefined || config.Css == null)
		{
			config.BorderWidth = 0;
		}

		Control.call(This, config);

		var Base = {
			GetType: This.GetType,
			is: This.is
		}

		This.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
		This.GetType = function() { return "Label"; }

		This.GetDom().style.overflow = "hidden";

		This.SetText = function(value)
		{
			This.GetDom().innerHTML = System.ReplaceHtml(value);
		}

		This.GetText = function(value)
		{
			return This.GetDom().innerHTML;
		}

		This.SetText(IsNull(config.Text, ""));
		This.SetCss(IsNull(config.Css, "label"));
	}

	function Button(config)
	{
		var This = this;

		Control.call(This, config);

		var Base = {
			GetType: This.GetType,
			SetText: This.SetText,
			is: This.is,
			Resize: This.Resize
		}

		This.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
		This.GetType = function() { return "Button"; }

		This.OnClick = new Delegate();

		var _dom = This.GetDom();
		_dom.className = 'buttonContainer';
		_dom.innerHTML = '<table cellpadding="0" cellspacing="0">'+
		'<tr>'+
		'<td class="btn_left">'+
		'</td>'+
		'<td class="btn_center">'+
		'</td>'+
		'<td class="btn_right">'+
		'</td>'+
		'</tr>'+
		'</table>'
		_dom.tabIndex = IsNull(config.TabIndex, -1);

		_dom.onkeydown = function(evt)
		{
			if (evt == undefined) evt = event;
			if (evt.keyCode == 13) This.Click();
			if (evt.cancelBubble != undefined) evt.cancelBubble = true;
			if (evt.stopPropagation != undefined) evt.stopPropagation();
		}
		_dom.onclick = function(evt)
		{
			This.Focus();
			This.OnClick.Call(This);
			
			if (evt == undefined) evt = event;
		}
		
		System.AttachEvent(
			_dom,"mousedown",
			function(evt)
			{
				if(evt==undefined) evt=window.event;
				if(System.GetButton(evt)=="Left")
				{
					This.GetDom().firstChild.rows[0].cells[0].className="btn_left_press";
					This.GetDom().firstChild.rows[0].cells[1].className="btn_center_press";
					This.GetDom().firstChild.rows[0].cells[2].className="btn_right_press";
				}
			}
		);
		System.AttachEvent(
			_dom,"mousemove",
			function(evt)
			{
				if(evt==undefined) evt=window.event;
				if(System.GetButton(evt)=="")
				{
					This.GetDom().firstChild.rows[0].cells[0].className="btn_left";
					This.GetDom().firstChild.rows[0].cells[1].className="btn_center";
					This.GetDom().firstChild.rows[0].cells[2].className="btn_right";
				}
			}
		);
		System.AttachEvent(
			_dom,"mouseup",
			function()
			{
				This.GetDom().firstChild.rows[0].cells[0].className="btn_left";
				This.GetDom().firstChild.rows[0].cells[1].className="btn_center";
				This.GetDom().firstChild.rows[0].cells[2].className="btn_right";
			}
		);
		System.AttachEvent(
			_dom,"mouseout",
			function()
			{
				This.GetDom().firstChild.rows[0].cells[0].className="btn_left";
				This.GetDom().firstChild.rows[0].cells[1].className="btn_center";
				This.GetDom().firstChild.rows[0].cells[2].className="btn_right";
			}
		);

		This.Click = function()
		{
			This.OnClick.Call(This);
		}

		This.SetText = function(value)
		{
			This.GetDom().firstChild.rows[0].cells[1].innerHTML = System.ReplaceHtml(value);
			Base.SetText(value);
		}

		This.Focus = function()
		{
			This.GetDom().focus();
		}

		This.Resize = function(newWidth, newHeight)
		{
			Base.Resize(newWidth, newHeight);
			
			var _dom = This.GetDom();
			var clientHeight = This.GetClientHeight();
			var clientWidth = This.GetClientWidth();

			_dom.firstChild.style.width = clientWidth + 'px';

			_dom.firstChild.rows[0].cells[0].style.width = '8px';
			_dom.firstChild.rows[0].cells[0].style.height = 26 + 'px';

			_dom.firstChild.rows[0].cells[1].style.width = (clientWidth - 16) + 'px';
			_dom.firstChild.rows[0].cells[1].style.height = 26 + 'px';

			_dom.firstChild.rows[0].cells[2].style.width = '8px';
			_dom.firstChild.rows[0].cells[2].style.height = 26 + 'px';
		}
		
		System.DisableSelect(_dom,true);

		_dom = null;

		This.SetText(IsNull(config.Text, ""));
		This.SetCss(IsNull(config.Css, "button"));
		This.Resize(This.GetWidth(), This.GetHeight());
	}

	Button.Height = 26;

	function TextBox(config)
	{
		var This = this;

		if (config.BorderWidth == undefined || config.BorderWidth == null) config.BorderWidth = 1;
		if (config.Padding == undefined || config.Padding == null) config.Padding = 3;

		Control.call(This, config);

		var Base = {
			GetType: This.GetType,
			SetText: This.SetText,
			GetText: This.GetText,
			is: This.is
		}

		This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
		This.GetType = function() { return "TextBox"; }

		var _dom = This.GetDom();
		_dom.innerHTML = '<input type="text" style="padding:0px; margin:0px; border-width:0px; width:100%; height:100%;"/>';

		_dom = null;

		This.SetText = function(value)
		{
			This.GetDom().firstChild.value = value;
			Base.SetText(value);
		}

		This.GetText = function(value)
		{
			return This.GetDom().firstChild.value;
		}

		This.OnResized.Attach(
			function()
			{
        		var textbox = This.GetDom().firstChild;
        		textbox.style.width = (This.GetClientWidth()) + "px";
        		textbox.style.height = (This.GetClientHeight()) + "px";
        		textbox = null;
			}
		);

		This.Focus = function()
		{
			This.GetDom().firstChild.focus();
		}

		This.GetTextBoxDom = function() { return This.GetDom().firstChild; }

		This.SetText(IsNull(config.Text, ""));
		This.Resize(This.GetWidth(), This.GetHeight());
		This.SetCss(IsNull(config.Css, "textbox"));
	}

	function PasswordBox(config)
	{
		var This = this;

		if (config.BorderWidth == undefined || config.BorderWidth == null) config.BorderWidth = 1;
		if (config.Padding == undefined || config.Padding == null) config.Padding = 3;

		Control.call(This, config);

		var Base = {
			GetType: This.GetType,
			SetText: This.SetText,
			GetText: This.GetText,
			is: This.is
		}

		This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
		This.GetType = function() { return "PasswordBox"; }

		var _dom = This.GetDom();
		_dom.innerHTML = '<input type="password" style="padding:0px; margin:0px; border-width:0px; width:100%; height:100%;"/>';

		_dom = null;

		This.SetText = function(value)
		{
			This.GetDom().firstChild.value = value;
			Base.SetText(value);
		}

		This.GetText = function(value)
		{
			return This.GetDom().firstChild.value;
		}

		This.OnResized.Attach(
			function()
			{
        		var textbox = This.GetDom().firstChild;
        		textbox.style.width = (This.GetClientWidth()) + "px";
        		textbox.style.height = (This.GetClientHeight()) + "px";
        		textbox = null;
			}
		);

		This.Focus = function()
		{
			This.GetDom().firstChild.focus();
		}

		This.GetPasswordDom = function() { return This.GetDom().firstChild; }

		This.SetText(IsNull(config.Text, ""));
		This.Resize(This.GetWidth(), This.GetHeight());
		This.SetCss(IsNull(config.Css, "textbox"));
	}

	function TextArea(config)
	{
		var This = this;

		Control.call(This, config);

		var Base = {
			GetType: This.GetType,
			SetText: This.SetText,
			GetText: This.GetText,
			is: This.is
		}

		This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
		This.GetType = function() { return "TextArea"; }

		var _dom = This.GetDom();
		_dom.innerHTML = '<textarea style="padding:0px; border-width:0px; margin:0px;" ></textarea>';
		_dom.style.overflow = 'hidden';
		_dom = null;

		This.SetText = function(value)
		{
			This.GetDom().firstChild.value = value;
			Base.SetText(value);
		}

		This.GetText = function(value)
		{
			return This.GetDom().firstChild.value;
		}

		This.OnResized.Attach(
			function()
			{
        		var ta = This.GetDom().firstChild;
        		ta.style.width = This.GetClientWidth() + "px";
        		ta.style.height = This.GetClientHeight() + "px";
        		ta = null;
			}
		);

		This.GetTextAreaDom = function() { return This.GetDom().firstChild; }

		This.GetCss = function() { return This.GetTextAreaDom().className; }
		This.SetCss = function(value) { This.GetTextAreaDom().className = value; }

		This.SetText(IsNull(config.Text, ""));
		This.Resize(This.GetWidth(), This.GetHeight());
		This.SetCss(IsNull(config.Css, "textarea"));
	}

	function CheckBox(config)
	{
		var This = this;

		if (config.BorderWidth == undefined || config.BorderWidth == null) config.BorderWidth = 0;
		if (config.Padding == undefined || config.Padding == null) config.Padding = 0;

		Control.call(This, config);

		var Base = {
			GetType: This.GetType,
			SetText: This.SetText,
			GetText: This.GetText,
			is: This.is
		}

		This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
		This.GetType = function() { return "CheckBox"; }

		var _dom = This.GetDom();
		_dom.innerHTML = '<table cellpadding="0" cellspacing="0"><tbody><tr><td><input type="checkbox"/></td><td><span></span></td></tr></tbody></table>';
		
		var _checkbox = _dom.firstChild.rows[0].cells[0].firstChild;
		var _textdom = _dom.firstChild.rows[0].cells[1].firstChild;

		This.SetText = function(value)
		{
			_textdom.innerHTML = System.ReplaceHtml(value);
		}

		This.GetText = function(value)
		{
			return _textdom.innerHTML;
		}

		This.OnResized.Attach(
			function()
			{
				_dom.firstChild.rows[0].cells[0].style.height=This.GetClientHeight()+"px";
				_dom.firstChild.rows[0].cells[1].style.height=This.GetClientHeight()+"px";
			}
		);

		This.Focus = function()
		{
			_checkbox.focus();
		}

		This.GetCheckBoxDom = function() { return _checkbox; }

		This.SetText(IsNull(config.Text, ""));
		This.Resize(This.GetWidth(), This.GetHeight());
		This.SetCss(IsNull(config.Css, "checkbox"));
	}

	function RadioButton(config)
	{
		var This = this;

		if (config.BorderWidth == undefined || config.BorderWidth == null) config.BorderWidth = 0;
		if (config.Padding == undefined || config.Padding == null) config.Padding = 0;

		Control.call(This, config);

		var Base = {
			GetType: This.GetType,
			SetText: This.SetText,
			GetText: This.GetText,
			is: This.is
		}

		This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
		This.GetType = function() { return "RadioButton"; }

		var _dom = This.GetDom();
		_dom.innerHTML = '<table cellpadding="0" cellspacing="0"><tbody><tr><td><input type="radio"/></td><td><span></span></td></tr></tbody></table>';
		
		var _radio = _dom.firstChild.rows[0].cells[0].firstChild;
		var _textdom = _dom.firstChild.rows[0].cells[1].firstChild;

		This.SetText = function(value)
		{
			_textdom.innerHTML = System.ReplaceHtml(value);
		}

		This.GetText = function(value)
		{
			return _textdom.innerHTML;
		}

		This.OnResized.Attach(
			function()
			{
				_dom.firstChild.rows[0].cells[0].style.height=This.GetClientHeight()+"px";
				_dom.firstChild.rows[0].cells[1].style.height=This.GetClientHeight()+"px";
			}
		);

		This.Focus = function()
		{
			_radio.focus();
		}

		This.GetRadioButtonDom = function() { return radio; }

		This.SetText(IsNull(config.Text, ""));
		This.Resize(This.GetWidth(), This.GetHeight());
		This.SetCss(IsNull(config.Css, "radio"));
	}

	function DropDownList(config)
	{
		var This = this;

		Control.call(This, config);

		var Base = {
			GetType: This.GetType,
			SetText: This.SetText,
			GetText: This.GetText,
			is: This.is
		}

		This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
		This.GetType = function() { return "DropDownList"; }

		var _dom = This.GetDom();
		_dom.innerHTML = '<select style="padding:0px; margin:0px;" ></select>';

		_dom = null;

		This.SetText = function(value)
		{
			if (_options[value] != undefined && _options[value] != null)
				This.GetDropDownListDom().value = _options[value].value;
		}
		This.GetText = function(value)
		{
			var ddl = This.GetDropDownListDom();
			return ddl.options[ddl.selectedIndex].innerHTML;
		}
		This.GetValue = function(value)
		{
			var ddl = This.GetDropDownListDom();
			return ddl.options[ddl.selectedIndex].value;
		}
		This.SetValue = function(value)
		{
			This.GetDropDownListDom().value = value;
		}

		This.OnResized.Attach(
			function()
			{
        		var ddl = This.GetDropDownListDom();
        		ddl.style.width = (This.GetWidth()) + "px";
        		ddl.style.height = (This.GetHeight()) + "px";
        		ddl = null;
			}
		);

		This.GetDropDownListDom = function() { return This.GetDom().firstChild; }

		This.GetCss = function() { return This.GetDropDownListDom().className; }
		This.SetCss = function(value) { This.GetDropDownListDom().className = value; }

		var _options = {};

		This.AddItem = function(item)
		{
			var ddl = This.GetDropDownListDom();

			var text, value;
			text = item.GetText != undefined ? item.GetText() : item.toString();
			value = item.GetValue != undefined ? item.GetValue() : text;

			var opt = new Option(text, value);

			_options[text] = opt;

			ddl.options.add(opt);
			ddl = null;
		}

		This.SetText(IsNull(config.Text, ""));
		This.Resize(This.GetWidth(), This.GetHeight());
		This.SetCss(IsNull(config.Css, "select"));
	}

	function ListBox(config)
	{
		var This = this;

		DropDownList.call(This, config);

		var Base = {
			GetType: This.GetType,
			is: This.is
		}

		This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
		This.GetType = function() { return "ListBox"; }

		This.GetDropDownListDom().size = IsNull(config.Size, 4);

		This.GetListBoxDom = This.GetDropDownListDom;
	}

	Module.Control = Control;
	Module.CheckBox = CheckBox;
	Module.RadioButton = RadioButton;
	Module.Label = Label;
	Module.Button = Button;
	Module.TextBox = TextBox;
	Module.PasswordBox = PasswordBox;
	Module.TextArea = TextArea;
	Module.DropDownList = DropDownList;
	Module.ListBox = ListBox;
	Module.AnchorStyle = AnchorStyle;

	(function()
	{

		function TreeView(config)
		{
			var This = this;

			Control.call(This, config);

			var Base = {
				GetType: This.GetType,
				is: This.is
			}

			This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
			This.GetType = function() { return "TreeView"; }

			This.GetDom().style.overflow = "auto";
			
			This.Private = {};

			var rootNodes = null;
			var nodeIndex = null;
			var selectedNode = null;

			var dataSource = config.DataSource;
			var nodeHeight = IsNull(config.NodeHeight, 20);
			var hasImage = IsNull(config.HasImage, false);

			var dom = This.GetDom();
			dom.innerHTML = "<div style='overflow:visible;'></div>";

			This.OnDblClick = new Delegate();
			This.OnClick = new Delegate();
			This.OnExpand = new Delegate();
			This.OnCollapse = new Delegate();
			This.OnBeginRequest = new Delegate();
			This.OnEndRequest = new Delegate();

			/*
			获取子节点
			name:节点名称
			callback(node,error):回调函数，用于处理返回结果
			node - 如果操作成功node为目标节点，否则node==null，error包含错误信息
			*/
			This.GetNode = function(callback, name)
			{
				if (rootNodes == null)
				{
					This.Refresh(
						function(nodes, error)
						{
							if (nodes != null) callback(nodeIndex[name]);
							else callback(null, error);
						}
					);
				}
				else
				{
					callback(nodeIndex[name]);
				}
			}

			This.GetExistingNode = function(path)
			{
				var pathNodes = path.split('/');
				if (pathNodes.length > 1 && pathNodes[0] == "")
				{
					if (nodeIndex == null) return null;
					if (nodeIndex[pathNodes[1]] == undefined) return null;
					return nodeIndex[pathNodes[1]].Private.GetExistingNode(pathNodes, 2);
				}
				else
				{
					return null;
				}
			}

			This.Clear = function()
			{
				dom.firstChild.innerHTML = "";
			}
			/*
			刷新子节点
			callback(nodes,error):回调函数，用于处理返回结果
			nodes - 如果操作成功nodes包含所有子节点，否则nodes==null，error包含错误信息
			*/
			This.Refresh = function(callback)
			{
				try
				{
					dataSource.GetSubNodes(
						function(subNodeData, error)
						{
							if (subNodeData != null)
							{
								dom.firstChild.innerHTML = "";
								rootNodes = [];
								nodeIndex = {};
								for (var i in subNodeData)
								{
									var nd = subNodeData[i];
									var node = new TreeNode(This, null, nd.Name, nd.Text, nd.ImageCss, nd.Tag, dom.firstChild, dataSource, nodeHeight, i == subNodeData.length - 1, nd.HasChildren);
									rootNodes.push(node);
									nodeIndex[nd.Name] = node;
								}
								callback(rootNodes);
							}
							else
							{
								callback(null, error);
							}
						},
						null
					);
				}
				catch (ex)
				{
					callback(null, new Exception(ex.name, ex.message));
				}
			}

			This.Load=This.Refresh;

			/*
			根据路径查找子节点
			name:节点名称
			callback(node,error):回调函数，用于处理返回结果
			node - 如果操作成功node为目标节点，否则node==null，error包含错误信息
			*/
			This.Find = function(callback, path)
			{
				var pathNodes = path.split('/');
				if (pathNodes.length > 1 && pathNodes[0] == "")
				{
					This.GetNode(
						function(node, error)
						{
							if (node != null) node.Private.Find(callback, pathNodes, 2);
							else callback(null, error);
						},
						pathNodes[1]
					);
				}
				else
				{
					callback(null, new Exception("Error", "路径格式不正确!"));
				}
			}

			This.GetSelectedNode = function()
			{
				return selectedNode;
			}

			This.Private.Select = function(callback, node)
			{
				if (selectedNode != null) selectedNode.Private.Deselect();
				node.Private.Select(
					function(result, error)
					{
						if (result)
						{
							selectedNode = node;
							callback(node);
						}
						else
							callback(null, error);
					}
				);
			}

			/*
			选择指定路径的节点
			callback(node,error):回调函数，用于处理返回结果
			node - 如成功，node为目标节点;否则node=null,error包含错误信息
			*/
			This.Select = function(callback, path)
			{
				This.Find(
					function(node, error)
					{
						if (node != null) This.Private.Select(callback, node);
						else callback(node, error);
					},
					path
				);
			}

			/*
			展开指定路径的节点
			callback(node,error):回调函数，用于处理返回结果
			node - 如成功，node为目标节点;否则node=null,error包含错误信息
			*/
			This.Expand = function(callback, path)
			{
				This.Find(
					function(node)
					{
						node.Expand(
							function(result, error)
							{
								if (result) callback(node);
								else callback(null, error);
							}
						);
					},
					path
				);
			}

			This.SetCss("treeview");
		}


		function TreeNode(treeView, parentNode, name, text, imgSrc, tag, container, dataSource, height, isLast, hasChildren)
		{
			if (hasChildren == undefined || hasChildren == null) hasChildren = true;

			var This = this;
			var subNodes = null;
			var nodeIndex = null;

			This.Private = {};

			//获取全路径
			This.GetFullPath = function()
			{
				return (parentNode == null ? "/" + name : parentNode.GetFullPath() + "/" + name);
			}

			//获取父节点
			This.GetParent = function()
			{
				return parentNode;
			}

			//是否为父节点的最后一个子节点
			This.IsLast = function()
			{
				return isLast;
			}

			//是否已经展开
			This.IsExpand = function()
			{
				return isExpand;
			}

			//获取节点名称
			This.GetName = function()
			{
				return name;
			}

			//获取节点的文本
			This.GetText = function()
			{
				return text;
			}

			This.SetText = function(val)
			{
				text = val;
				textDiv.innerHTML = System.ReplaceHtml(val);
			}

			//获取附加数据
			This.GetTag = function()
			{
				return tag;
			}

			/*
			获取子节点
			name:节点名称
			callback(node,error):回调函数，用于处理返回结果
			node - 如果操作成功node为目标节点，否则node==null，error包含错误信息
			*/
			This.GetNode = function(callback, name)
			{
				if (subNodes == null)
				{
					This.Refresh(
						function(nodes, error)
						{
							if (nodeIndex != null) callback(nodeIndex[name]);
							else callback(null, error);
						}
					);
				}
				else
				{
					callback(nodeIndex[name]);
				}
			}

			This.Private.GetExistingNode = function(pathNodes, s)
			{
				if (s >= pathNodes.length)
				{
					return This;
				}
				else
				{
					if (nodeIndex == null) return null;
					if (nodeIndex[pathNodes[s]] == undefined) return null;
					return nodeIndex[pathNodes[s]].Private.GetExistingNode(pathNodes, s + 1);
				}
			}


			/*
			获取所有子节点
			callback(nodes,error):回调函数，用于处理返回结果
			nodes - 如果操作成功nodes包含所有子节点，否则nodes==null，error包含错误信息
			*/
			This.GetSubNodes = function(callback)
			{
				if (subNodes == null)
				{
					This.Refresh(callback);
				}
				else
				{
					callback(subNodes);
				}
			}

			/*
			刷新子节点
			callback(nodes,error):回调函数，用于处理返回结果
			nodes - 如果操作成功nodes包含所有子节点，否则nodes==null，error包含错误信息
			*/
			This.Refresh = function(callback)
			{
				try
				{
					treeView.OnBeginRequest.Call(This);
					dataSource.GetSubNodes(
				function(subNodeData, error)
				{
					if (subNodeData != null)
					{
						subNodes = [];
						nodeIndex = {};
						subNodesContainer.innerHTML = "";
						for (var i in subNodeData)
						{
							var nd = subNodeData[i];
							var node = new TreeNode(treeView, This, nd.Name, nd.Text, nd.ImageCss, nd.Tag, subNodesContainer, dataSource, height, i == subNodeData.length - 1, nd.HasChildren);
							subNodes.push(node);
							nodeIndex[nd.Name] = node;
						}
						if (This.IsExpand())
						{
							subNodesContainer.style.display = (subNodes.length > 0 ? 'block' : 'none');
						}
						buttonDiv.className = GenerateBtnCss();
						callback(subNodes);
					}
					else
					{
						callback(null, error);
					}
					treeView.OnEndRequest.Call(This);
				},
				This
			);
				}
				catch (ex)
				{
					callback(null, new Exception(ex.name, ex.message));
				}
			}

			/*
			展开节点
			callback(result,error):回调函数，用于处理返回结果
			result - 如果展开成功，result=true;否则result=false,error包含错误信息
			*/
			This.Expand = function(callback)
			{
				function expand()
				{
					if (hasChildren && !isExpand)
					{
						This.GetSubNodes(
							function(nodes, error)
							{
								if (nodes != null)
								{
									if (nodes.length > 0) subNodesContainer.style.display = 'block';
									isExpand = true;
									buttonDiv.className = GenerateBtnCss();
									treeView.OnExpand.Call(This);
									callback(true);
								}
								else
								{
									callback(false, error);
								}
							}
						);
					}
					else
					{
						callback(true);
					}
				}
				if (parentNode != null)
				{
					parentNode.Expand(
						function(result, error)
						{
							if (result) expand();
							else callback(false, error);
						}
					);
				}
				else
				{
					expand();
				}

			}

			//闭合节点
			This.Collapse = function()
			{
				if (hasChildren)
				{
					subNodesContainer.style.display = 'none';
					isExpand = false;
					buttonDiv.className = GenerateBtnCss();
					treeView.OnCollapse.Call(This);
				}
				return true;
			}

			/*
			根据路径查找子节点(内部函数)
			name:节点名称
			callback(node,error):回调函数，用于处理返回结果
			node - 如果操作成功node为目标节点，否则node==null，error包含错误信息
			*/
			This.Private.Find = function(callback, nodes, s)
			{
				if (s >= nodes.length)
				{
					callback(This);
				}
				else
				{
					This.GetNode(
						function(node, error)
						{
							if (node == null) callback(null, error);
							else node.Private.Find(callback, nodes, s + 1);
						},
						nodes[s]
					);
				}
			}

			/*
			使节点换到选中状态
			callback(result,error):回调函数，用于处理返回结果
			result - 如果展开成功，result=true;否则result=false,error包含错误信息
			*/
			This.Private.Select = function(callback)
			{
				textDiv.className = 'nodeText_Selected'
				if (parentNode != null)
				{
					parentNode.Expand(
						function(result, error)
						{
							callback(result, error);
						}
					);
				}
				else
				{
					callback(true);
				}
			}


			/*
			使节点换到非选中状态
			*/
			This.Private.Deselect = function()
			{
				textDiv.className = 'nodeText';
				return true;
			}

			function GenerateBtnCss()
			{
				var css = "";
				if (!hasChildren) css += "line";
				else if (subNodes == null) css += "collapse";
				else if (subNodes.length == 0) css += "line";
				else if (isExpand) css += "expand";
				else css += "collapse";

				if (isLast) css += "_ne"
				else css += '_nes';

				return css;
			}

			var isExpand = false;

			var dom = document.createElement("DIV");
			dom.innerHTML = "<div><table cellspacing='0'><tr></tr></table></div><div></div>";
			var nodeContainer = dom.childNodes[0];
			nodeContainer.style.height = height + 'px';
			var nodeRow = nodeContainer.firstChild.rows[0];
			var subNodesContainer = dom.childNodes[1];
			subNodesContainer.style.display = 'none';

			var p = parentNode;

			while (p != null)
			{
				var cell = nodeRow.insertCell(0);
				cell.innerHTML = String.format("<div class='{0}'></div>", p.IsLast() ? "line_none" : "line_ns");
				p = p.GetParent();
			}

			var buttonCell = nodeRow.insertCell(-1);
			buttonCell.innerHTML = String.format("<div class='{0}'></div>", GenerateBtnCss());
			var buttonDiv = buttonCell.firstChild;
			buttonDiv.onclick = function()
			{
				if (This.IsExpand()) This.Collapse(); else This.Expand(function(result, error) { if (!result) System.HandleException(error) });
			}

			var imgCell = nodeRow.insertCell(-1);
			imgCell.innerHTML = String.format("<div class='{0}' style='width:16px; height:16px;' />", imgSrc);

			var textCell = nodeRow.insertCell(-1);
			textCell.innerHTML = String.format("<div class='nodeText'>{0}</div>", System.ReplaceHtml(text));
			var textDiv = textCell.firstChild;
			
			imgCell.firstChild.onclick=function()
			{
				treeView.OnClick.Call(This);
			}

			textDiv.onclick = function()
			{
				treeView.OnClick.Call(This);
			}
			
			imgCell.firstChild.onmousedown=function()
			{
				treeView.Private.Select(function() { }, This);
			}

			textDiv.onmousedown = function()
			{
				treeView.Private.Select(function() { }, This);
			}

			textDiv.ondblclick = function()
			{
				treeView.OnDblClick.Call(This);
			}

			imgCell.firstChild.ondblclick = function()
			{
				treeView.OnDblClick.Call(This);
			}

			container.appendChild(dom);
		}

		Module.TreeView = TreeView;

	})();


	(function()
	{

		/*
		config={
		...:继承Control属性,
		Columns:{
		{Name:名称,Text:文本,Css:样式,Width:,RowCss:}
		},
		ListMode:{
		TitleHeight
		}
		}
		*/
		function ListView(config)
		{
			var This = this;
			var listview = this;

			Control.call(This, config);

			var Base = {
				GetType: This.GetType,
				is: This.is
			}

			This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
			This.GetType = function() { return "ListView"; }

			This.OnItemDblClick = new Delegate();

			var _columns = [];
			
			var _enableMultiSelect = IsNull(config.EnableMultiSelect, false);
			var _viewMode = IsNull(config.ViewMode, "List");
			var _list = null;

			switch (_viewMode)
			{
				case "List":
					{
						_list = {
							Config: {
								HeaderHeight: IsNull(config.ListMode.HeaderHeight, 28),
								RowHeight: IsNull(config.ListMode.RowHeight, 24)
							}
						};
						_list.Header = new ListHeader();
						_list.Panel = new ItemPanel();
						_list.Panel.OnScroll.Attach(
							function(panel)
							{
                				_list.Header.GetDom().scrollLeft = panel.GetDom().scrollLeft;
							}
						);
						This.OnColumnClick = _list.Header.OnColumnClick;
						break;
					}
			}

			var _items = [];

			This.AppendItem = function(listItem)
			{
				var item = new ListViewItem(listItem, (_items.length % 2 == 0 ? "tr_even" : "tr_odd"))
				_items.push(item);
				item.GetDom().ondblclick = function()
				{
					This.OnItemDblClick.Call(item.GetItem());
				}
				_list.Panel.GetDom().appendChild(item.GetDom());
				return item;
			}
			
			This.GetColumns = function() { return _columns; }
			
			This.Reset=function(cols)
			{
				_columns = [];
				for (var i in cols)
				{
					var col = cols[i];
					_columns.push(new ListColumn(col.Name, col.Text, col.Css, col.Width, col.RowCss));
				}
				This.Clear();
				_list.Header.Create();
			}

			This.ClearSelect = function()
			{
				for (var i in _items)
				{
					if (_items[i].IsSelected()) _items[i].Deselect();
				}
			}

			This.Clear = function()
			{
				_items = [];
				_list.Panel.Clear();
			}

			This.SelectAll = function()
			{
				for (var i in _items)
				{
					_items[i].Select();
				}
			}

			This.SelectRange = function(start, end)
			{
				if (start > end) { var temp = start; start = end; end = temp; }

				for (var i = start; i <= end; i++)
				{
					_items[i].Select();
				}
			}

			This.GetAllItems = function()
			{
				var items = [];
				for (var i in _items)
				{
					items.push(_items[i].GetItem());
				}
				return items;
			}
			
			This.GetCell = function(row,col)
			{
				return _list.Panel.GetDom().childNodes[row].childNodes[col];
			}

			This.GetSelectedItems = function()
			{
				var items = [];
				for (var i in _items)
				{
					if (_items[i].IsSelected()) items.push(_items[i].GetItem());
				}
				return items;
			}

			This.CompareItem = null;

			This.Sort = function(param)
			{
				if (This.CompareItem != null)
				{
					for (var i = 0; i < _items.length; i++)
					{
						for (var j = i; j < _items.length; j++)
						{
							if (This.CompareItem(_items[i].GetItem(), _items[j].GetItem(), param) == 1)
							{
								var temp = _items[i];
								_items[i] = _items[j];
								_items[j] = temp;
							}
						}
					}
					_list.Panel.Clear();
					for (var i in _items)
					{
						if (!_items[i].IsSelected())
							_items[i].SetNormalCss(i % 2 == 0 ? "tr_even" : "tr_odd");
						_list.Panel.GetDom().appendChild(_items[i].GetDom());
					}
				}
			}

			This.IndexOf = function(item)
			{
				for (var i = 0; i < _items.length; i++)
				{
					if (_items[i].GetItem() == item) return i;
				}
				return -1;
			}

			This.SetCss("listview");

			var _latestItem = null;
			
			This.Reset(IsNull(config.Columns,[]));

			function ListViewItem(values, css)
			{
				var This = this;

				var dom = document.createElement("DIV");
				dom.className = css;
				this.GetDom = function() { return dom; }

				if (_viewMode == "List")
				{
					dom.style.height = _list.Config.RowHeight + 'px';
					var width = 0;
					for (var i in _columns)
					{
						var col = _columns[i];
						var colDom = document.createElement("DIV");
						colDom.style.width = col.GetWidth() + 'px';
						width += col.GetWidth();
						colDom.className = col.GetRowCss();
						var val = (values.GetText == undefined ? values[col.GetName()] : values.GetText(col.GetName()));
						colDom.innerHTML = System.ReplaceHtml(val);
						dom.appendChild(colDom);
					}
					dom.style.width = width + "px";
					_list.Panel.GetDom().appendChild(dom);
				}

				var _isSelected = false;

				this.Select = function()
				{
					if (!_enableMultiSelect)
					{
						listview.ClearSelect();
					}
					dom.className = "tr_selected";
					_isSelected = true;
				}

				this.Deselect = function()
				{
					_isSelected = false;
					dom.className = css;
				}

				this.IsSelected = function()
				{
					return _isSelected;
				}

				this.GetItem = function()
				{
					return values;
				}

				this.SetNormalCss = function(newCss)
				{
					css = newCss;
					if (_isSelected) dom.className = css;
				}

				dom.onclick = function(evt)
				{
					if (evt == undefined) evt = event;
					if (_enableMultiSelect)
					{
						if (!evt.ctrlKey && !evt.shiftKey)
						{
							listview.ClearSelect();
							This.Select();
							_latestItem = This;
						}
					}
				}

				dom.onmousedown = function(evt)
				{
					if (evt == undefined) evt = event;

					if (GetButton(evt) == "Right")
					{
						if (!This.IsSelected())
						{
							if (_enableMultiSelect) listview.ClearSelect();
							This.Select();
						}
						_latestItem = This;
					}
					else if (GetButton(evt) == "Left")
					{
						if (_enableMultiSelect)
						{
							if (evt.ctrlKey)
							{
								if (evt.shiftKey)
								{
									if (_latestItem != null)
									{
										listview.SelectRange(listview.IndexOf(This.GetItem()), listview.IndexOf(_latestItem.GetItem()));
									}
									_latestItem = This;
								}
								else
								{
									if (This.IsSelected())
									{
										This.Deselect();
										_latestItem = null;
									}
									else
									{
										This.Select();
										_latestItem = This;
									}
								}
							}
							else
							{
								if (evt.shiftKey)
								{
									if (_latestItem != null)
									{
										listview.ClearSelect();
										listview.SelectRange(listview.IndexOf(This.GetItem()), listview.IndexOf(_latestItem.GetItem()));
									}
								}
							}
						}
						else
						{
							This.Select();
							_latestItem = This;
						}
					}
				}
			}

			function ListColumn(name, text, css, width, rowCss)
			{
				if (rowCss == undefined || rowCss == null) rowCss = 'col_default';

				this.GetCss = function() { return css; }
				this.GetRowCss = function() { return rowCss; }
				this.GetName = function() { return name; }
				this.GetText = function() { return text; }
				this.GetWidth = function() { return width; }
			}

			function ListHeader()
			{
				var _headerHeight = _list.Config.HeaderHeight;

				var This = this;

				var config = {
					Left: 0,
					Top: 0,
					Width: listview.GetClientWidth(),
					Height: _headerHeight,
					AnchorStyle: AnchorStyle.Left | AnchorStyle.Right | AnchorStyle.Top,
					Parent: listview
				}

				Control.call(This, config);

				var Base = {
					GetType: This.GetType,
					is: This.is
				}

				This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
				This.GetType = function() { return "ListHeader"; }

				This.GetDom().style.overflow = "hidden";

				This.OnColumnClick = new Delegate();

				This.Create=function()
				{
					if(This.GetDom().firstChild!=null) This.GetDom().removeChild(This.GetDom().firstChild);
					
					var dom = document.createElement("DIV");
					dom.style.height = _headerHeight;
					var width = 0;
					for (var i in _columns)
					{
						var col = _columns[i];
						var colDom = document.createElement("DIV");
						colDom.style.width = col.GetWidth() + 'px';
						width += col.GetWidth();
						colDom.className = IsNull(col.GetCss(),"td_header_default");
						colDom.innerHTML = String.format("<span>{0}</span>", System.ReplaceHtml(col.GetText()));
						(function(index)
						{
							colDom.onclick = function() { This.OnColumnClick.Call(index); }
						})(i);
						dom.appendChild(colDom);
					}
					dom.style.width = width + "px";
					This.GetDom().appendChild(dom);
					dom = null;
				}

				This.SetCss("tr_header");
			}

			function ItemPanel()
			{
				var This = this;

				var config = {
					Left: 0,
					Top: _list.Config.HeaderHeight,
					Width: listview.GetClientWidth(),
					Height: listview.GetClientHeight() - _list.Config.HeaderHeight,
					AnchorStyle: AnchorStyle.All,
					Parent: listview
				}

				Control.call(This, config);

				var Base = {
					GetType: This.GetType,
					is: This.is
				}

				This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
				This.GetType = function() { return "ItemPanel"; }

				This.GetDom().style.overflow = "auto";

				This.OnScroll = new Delegate();

				This.GetDom().onscroll = function()
				{
					This.OnScroll.Call(This);
				}

				This.GetDom().onmousedown = function(evt)
				{
					if (evt == undefined) evt = event;
					var target
					if (evt.target != undefined) target = evt.target;
					if (evt.srcElement != undefined) target = evt.srcElement;
					if (target == this)
					{
						listview.ClearSelect();
					}
				}

				This.Clear = function()
				{
					var children = [];
					var nodes = This.GetDom().childNodes;
					for (var i = 0; i < nodes.length; i++) children.push(nodes[i]);
					for (var i in children) This.GetDom().removeChild(children[i]);
				}

				This.SetCss("itemPanel");

			}
		}

		Module.ListView = ListView;

	})();

	(function()
	{

		var MenuManager = new (function()
		{

			var currentMenu = null;

			this.Popup = function(menu, clientX, clientY)
			{
				if (currentMenu != null) currentMenu.Hide();
				menu.Show(clientX, clientY);
				currentMenu = menu;
			}

			this.Hide = function(menu)
			{
				if (menu != undefined)
				{
					menu.Hide();
					if (currentMenu == menu) currentMenu = null;
				}
				else
				{
					if (currentMenu != null) currentMenu.Hide();
					currentMenu = null;
				}
			}

		})();

		if (document.attachEvent)
		{
			document.attachEvent(
				"onmousedown",
				function(evt)
				{
					if (evt == null) evt = window.event;
					MenuManager.Hide();
				}
			);
		}
		else if (document.addEventListener)
		{
			document.addEventListener(
				"mousedown",
				function(evt)
				{
					if (evt == null) evt = window.event;
					MenuManager.Hide();
				},
				false
			)
		}

		var position = "absolute";

		/*
		menuConfig={
		Css:"",
		Items=[
		{Text:文本,ID:Menu Id,Css:样式}
		{
		Text:文本,
		ID:Menu Id,
		SubMenu:menuConfig
		}
		]
		}
		*/
		function Menu(menuConfig)
		{
			var This = this;

			//继承Object
			Control.call(This);

			var Base = {
				GetType: This.GetType,
				is: This.is,
				Dispose: This.Dispose
			}

			This.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
			This.GetType = function() { return "Menu"; }

			This.Popup = function(clientX, clientY)
			{
				MenuManager.Popup(This, clientX, clientY);
			}

			This.Show = function(clientX, clientY)
			{
				This.GetDom().style.display = 'block';
				mainMenu.Show(clientX, clientY);
			}

			This.Hide = function()
			{
				This.GetDom().style.display = 'none';
				mainMenu.Hide();
			}

			This.DoCommand = function(menuId)
			{
				MenuManager.Hide(This);
				if (menuId != null && menuId != "") This.OnCommand.Call(menuId);
			}

			This.AppendChild = function(child)
			{
				This.GetDom().appendChild(child);
			}

			This.Dispose = function()
			{
				document.body.removeChild(This.GetDom());
			}

			This.OnCommand = new Delegate();

			var dom = This.GetDom();
			dom.style.position = position;
			dom.style.left = "0px";
			dom.style.top = "0px";
			dom.style.width = "10px";
			dom.style.height = "10px";
			dom.style.zIndex = "10000";
			dom.style.overflow = "visible";
			document.body.appendChild(dom);

			var mainMenu = new SingleMenu(menuConfig, null, This);
		}

		function SingleMenu(menuConfig, parentItem, mainMenu)
		{

			var This = this;

			var css = (menuConfig.Css == undefined ? "menu" : menuConfig.Css);

			var obj = document.createElement("DIV");
			obj.className = css;
			obj.style.position = position;
			obj.style.display = 'none';

			mainMenu.AppendChild(obj);

			var items = []
			for (var i in menuConfig.Items)
			{
				var menuItem = new MenuItem(menuConfig.Items[i], This, mainMenu)
				items.push(menuItem);
				obj.appendChild(menuItem.GetDom());
			}

			This.GetDom = function() { return obj; }

			This.Show = function(clientX, clientY)
			{
				obj.style.display = "block";
				var x = clientX, y = clientY;
				if (x + obj.offsetWidth > Desktop.GetWidth())
				{
					x -= obj.offsetWidth;
					if (parentItem != null) x -= parentItem.GetDom().offsetWidth;
				}
				if (y + obj.offsetHeight > Desktop.GetHeight())
				{
					y -= obj.offsetHeight;
					if (parentItem != null) y += parentItem.GetDom().offsetHeight;
				}
				obj.style.left = x + "px";
				obj.style.top = y + "px";
			}

			This.Hide = function()
			{
				for (var i in items) items[i].HideSubMenu();
				obj.style.display = "none";
			}

			This.HideSubMenus = function()
			{
				for (var i in items) items[i].HideSubMenu();
			}
		}

		function MenuItem(itemConfig, parent, mainMenu)
		{
			var This = this;

			var css, text, id;
			var subMenu = null;

			id = (itemConfig.ID == undefined ? "" : itemConfig.ID);
			if (id == null || id == "")
			{
				text = "";
				css = (itemConfig.Css == undefined ? "menuSplit" : itemConfig.Css);
			}
			else
			{
				text = (itemConfig.Text == undefined ? "Menu" : itemConfig.Text);
				css = (itemConfig.Css == undefined ? "menuItem" : itemConfig.Css);
			}
			subMenu = (itemConfig.SubMenu == undefined ? null : new SingleMenu(itemConfig.SubMenu, This, mainMenu))

			var obj = document.createElement("DIV");
			obj.innerHTML = System.ReplaceHtml(text);
			obj.className = css;

			This.GetDom = function() { return obj; }

			This.HideSubMenu = function()
			{
				if (subMenu != null) subMenu.Hide();
			}

			This.ShowSubMenu = function()
			{
				var pobj = parent.GetDom();
				if (subMenu != null) subMenu.Show(pobj.offsetLeft + obj.offsetLeft + obj.offsetWidth, pobj.offsetTop + obj.offsetTop);
			}
			if (id != null && id != "")
			{
				obj.onmousemove = function()
				{
					parent.HideSubMenus();
					This.ShowSubMenu();
				}

				obj.onmousedown = function(evt)
				{
					if (evt == undefined) evt = event;
					if (evt.cancelBubble != undefined) evt.cancelBubble = true;
					if (evt.stopPropagation != undefined) evt.stopPropagation();
					return true;
				}

				obj.onclick = function()
				{
					mainMenu.DoCommand(id);
					return true;
				}
			}
		}

		Module.Menu = Menu;

	})();

	function Frame(config)
	{
		var This = this;
		var listview = this;

		Control.call(This, config);

		var Base = {
			GetType: This.GetType,
			is: This.is,
			Resize: This.Resize
		}

		This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
		This.GetType = function() { return "Frame"; }

		This.GetDom().innerHTML = '<iframe frameborder="0"></iframe>';
		This.GetDom().overflow = 'hidden';

		This.Resize = function(newWidth, newHeight)
		{
			Base.Resize(newWidth, newHeight);

			var frame = This.GetDom().firstChild;
			frame.style.width = This.GetClientWidth() + 'px';
			frame.style.height = This.GetClientHeight() + 'px';
		}

		This.GetFrame = function()
		{
			return This.GetDom().firstChild;
		}

		This.Link = function(rel, href, type)
		{
			var frame = This.GetFrame();
			var e = frame.contentWindow.document.createElement("link");
			e.rel = rel;
			e.type = type;
			e.href = href;
			var hs = frame.contentWindow.document.getElementsByTagName("head");
			if (hs.length > 0) hs[0].appendChild(e);
			return e;
		}

		This.GetWindow = function()
		{
			return This.GetFrame().contentWindow;
		}

		This.GetDocument = function()
		{
			return This.GetFrame().contentWindow.document;
		}

		This.GetFrame().contentWindow.document.write(
			"<html><head><script>document.oncontextmenu=function(){return false;}</script></head><body></body></html>"
		);

		This.OnBeforeLoad = new Delegate();
		This.OnAfterLoad = new Delegate();

		System.AttachEvent(
			This.GetFrame(),
			"load",
			function()
			{
				This.OnAfterLoad.Call();
			}
		);

		This.Navigate = function(url)
		{
			This.OnBeforeLoad.Call();
			var frame = This.GetFrame();
			frame.src = url;
		}

		This.SetCss(IsNull(config.Css, "frame"));
		This.Resize(This.GetWidth(), This.GetHeight());

	}

	Module.Frame = Frame;

})();

function HtmlListBox(css, width)
{
	var This=this;
	
	var items=[];
	var selectIndex=-1;

	if (css == undefined || css==null) css = "html_listbox";
	var dom = document.createElement("DIV");
	dom.className = css;
	
	System.AttachEvent(
		dom,"click",
		function(evt)
		{
			if(evt==undefined) evt=window.event;
			System.CancelBubble(evt);
		}
	);
	
	This.OnClick=new Delegate();
	
	this.Resize=function(w)
	{
		dom.style.width=(w-2)+"px";
	}
	
	this.GetDom=function()
	{
		return dom;
	}
	
	this.AddItem=function(text,value)
	{
		if(value==undefined) value=text;
		var item_dom=document.createElement("DIV");
		item_dom.innerHTML = System.ReplaceHtml(text);
		item_dom.className="html_listbox_item";
		dom.appendChild(item_dom);
		
		items.push({Text:text,Value:value});
		
		(function(index)
		{
			item_dom.onclick=function(evt)
			{
				if(evt==undefined) evt=window.event;
				selectIndex=index;
				System.CancelBubble(evt);
				This.OnClick.Call();
			}
		})(items.length-1);
	}
	
	this.Clear = function()
	{
		items = [];
		selectIndex = -1;
		dom.innerHTML = "";
	}
	
	this.GetText=function()
	{
		return selectIndex==-1?null:items[selectIndex].Text;
	}
	
	this.GetValue=function()
	{
		return selectIndex==-1?null:items[selectIndex].Value;
	}
	
	this.GetItems=function()
	{
		return items;
	}
	
	this.Resize(width);
}

function HtmlDropDownList(css,width,height)
{
	var This=this;
	
	if(css==undefined || css==null) css="html_dropdownlist";
	
	var dom=document.createElement("DIV");
	dom.className=IsNull(css,"html_dropdownlist");
	
	dom.innerHTML="<div class='dropdownlist_text'><div></div></div><div class='dropdown_button'></div>";
	
	var m_IsListVisible = false;
	
	System.AttachEvent(
		dom.childNodes[1],"click",
		function(evt)
		{
			if(evt==undefined) evt=window.event;
			This.ShowList();
			System.CancelBubble(evt);
		}
	);
	
	this.OnChanged=new Delegate();
	
	this.Resize=function(w,h)
	{
		dom.style.width=(w-2)+"px";
		dom.style.height=(h-2)+"px";
		
		dom.firstChild.style.width=(w-2-13-4)+"px";
		dom.firstChild.style.height=(h-4)+"px";
		
		dom.childNodes[1].style.width=(11)+"px";
		dom.childNodes[1].style.height=(h-4)+"px";
	}
	
	this.GetDom=function()
	{
		return dom;
	}
	
	this.GetListDom=function()
	{
		return listbox.GetDom();
	}
	
	this.GetText=function()
	{
		return dom.firstChild.firstChild.innerHTML;
	}
	
	this.SetText=function(text)
	{
		var items=listbox.GetItems();
		for(var i in items)
		{
			if(items[i].Text==text)
			{
				if(dom.firstChild.firstChild.innerHTML!=text)
				{
					dom.firstChild.firstChild.innerHTML = System.ReplaceHtml(text);
					This.OnChanged.Call();
				}
			}
		}
	}
	
	this.GetValue=function()
	{
		var text=This.GetText();
		var items=listbox.GetItems();
		for(var i in items)
		{
			if(items[i].Text==text)
			{
				return items[i].Value;
			}
		}
		return null;
	}
	
	this.SetValue=function(value)
	{
		var items=listbox.GetItems();
		for(var i in items)
		{
			if(items[i].Value==value)
			{
				if(dom.firstChild.firstChild.innerHTML!=items[i].Text)
				{
					dom.firstChild.firstChild.innerHTML = System.ReplaceHtml(items[i].Text);
					This.OnChanged.Call();
				}
			}
		}
	}
	
	this.AddItem=function(text,value)
	{
		listbox.AddItem(text,value);
	}
	
	this.Clear=function()
	{
		listbox.Clear();
	}
	
	var listbox=new HtmlListBox(null,width);
	
	listbox.OnClick.Attach(
		function()
		{
			if(m_IsListVisible)
			{
				This.HideList();
				This.SetText(listbox.GetText());
			}
		}
	);

	This.ShowList = function()
	{
		if(!m_IsListVisible)
		{
			var coord = System.GetClientCoord(dom);
			
			document.body.appendChild(listbox.GetDom());
			Desktop.EnterMove();
			
			if(listbox.GetDom().offsetHeight > 400)
			{
				listbox.GetDom().style.height = "400px";
			}
			else
			{
				listbox.GetDom().style.height = "auto";
			}
			
			var top=coord.Y+height;
			if(top + listbox.GetDom().offsetHeight > Desktop.GetHeight())
			{
				top-=(listbox.GetDom().offsetHeight+height);
				top+=1;
			}
			else
			{
				top-=1;
			}
						
			listbox.GetDom().style.left=coord.X+"px";
			listbox.GetDom().style.top=top+"px";
			m_IsListVisible = true;
			System.AttachEvent(document, "click", document_onclick);
		}
	}
	
	This.HideList = function()
	{
		if(m_IsListVisible)
		{
			Desktop.LeaveMove();
			m_IsListVisible = false;
			document.body.removeChild(listbox.GetDom());
			System.DetachEvent(document, "click", document_onclick);
		}
	}
	
	function document_onclick()
	{
		This.HideList();
	}
	
	//document.body.appendChild(listbox.GetDom());
	
	//listbox.GetDom().style.display="none";
	listbox.GetDom().style.position="absolute";
	listbox.GetDom().style.zIndex="2000000";
	
	this.Resize(width,height);
}

Module.HtmlDropDownList = HtmlDropDownList;

/*
config={
Items:[
{BkImageUrl:...,Text:...,Command}
]
}
*/

function Toolbar(config)
{
	var This = this;

	config.Height = Toolbar.PredefineHeight;
	config.BorderWidth = 0;

	Module.Control.call(This, config);

	var Base = {
		GetType: This.GetType,
		is: This.is
	}

	This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
	This.GetType = function() { return "Toolbar"; }

	var m_Btns = [];
	
	This.GetDom().style.overflow = "hidden";
	This.OnCommand = new Delegate();
	
	This.CreateControl=function(item)
	{
		if(item.Type==undefined || item.Type=="Button")
		{
			var dom = document.createElement("DIV");
			dom.className = item.Text == "" ? "toolbar_btn" : "toolbar_text_btn";
			dom.innerHTML = String.format("<div>{0}</div>", System.ReplaceHtml(item.Text), Toolbar.PredefineHeight);
			dom.firstChild.className = item.Css;

			(function(cmd)
			{
				dom.onclick = function()
				{
					This.OnCommand.Call(cmd);
				}
			})(item.Command);
			This.GetDom().appendChild(dom);
			m_Btns.push(dom);
			dom = null;
		}
		else if(item.Type=="HtmlCtrl")
		{
			var dom = document.createElement("DIV");
			dom.innerHTML = item.Html;
			dom.className="toolbar_custom";
			This.GetDom().appendChild(dom);
			m_Btns.push(dom);
		}
		else if(item.Type=="DropDownList")
		{
			var dom = document.createElement("DIV");
			dom.className="toolbar_dropdownlist";
			This.GetDom().appendChild(dom);
			
			var ddl=new HtmlDropDownList(null,item.Width,19);
			dom.appendChild(ddl.GetDom());
			
			m_Btns.push(ddl);
		}
	}

	for (var i = 0; i < config.Items.length; i++)
	{
		var item = config.Items[i];
		This.CreateControl(item);
	}

	if(config.DisableSelect==undefined || config.DisableSelect)
	{
		System.DisableSelect(This.GetDom(), true);
	}
	
	
	This.SetButtonVisible=function(index,visible)
	{
		m_Btns[index].style.display = (visible ? "block" : "none");
	}
	
	This.SetButtonText=function(index,text)
	{
		m_Btns[index].firstChild.innerHTML = System.ReplaceHtml(text);
	}
	
	This.SetElemVisible=This.SetButtonVisible;
	
	This.GetControl=function(index)
	{
		return m_Btns[index];
	}
}

Toolbar.PredefineHeight = 24;

Module.Toolbar = Toolbar;

function GuideLine(total, xs)
{
	var m_Guide = [];
	var temp = 0;
	for (var i in xs) temp += xs[i];
	for (var i in xs)
	{
		if (xs[i] == 0) m_Guide[i] = total - temp; else m_Guide[i] = xs[i];
	}
	temp = 0;
	for (var i = 0; i < m_Guide.length; i++)
	{
		m_Guide[i] += temp;
		temp = m_Guide[i];
	}

	this.Get = function(index, relRight)
	{
		if (relRight == undefined) relRight = false;
		return relRight ? m_Guide[index] - total : m_Guide[index];
	}

	this.GetWidth = function(index)
	{
		return index > 0 ? m_Guide[index] - m_Guide[index - 1] : m_Guide[index];
	}
}

Module.GuideLine = GuideLine;

(function()
{

	var MoveData = null; /*{
	Target:null,
	Placeholder:null,
	Background:null,
	Bound:,
	PreviousTop:0,
	PreviousClientX:0,
	PreviousClientY:0,
	TopControl:
	BottomControl:
};*/

	System.AttachEvent(
		document, "mousemove",
		function(evt)
		{
			if (evt == undefined) evt = event;
			if (MoveData != null)
			{
				var top = MoveData.Target.GetTop();
				var left = MoveData.Placeholder.GetLeft();
				var newTop = top + (evt.clientY - MoveData.PreviousClientY);
				if (newTop >= MoveData.Bound.Top && newTop <= MoveData.Bound.Bottom)
				{
					MoveData.Placeholder.Move(left, newTop);
				}
			}
		}
	);

	System.AttachEvent(
		document, "mouseup",
		function(evt)
		{
			if (MoveData != null)
			{
				var top = MoveData.Placeholder.GetTop();
				var left = MoveData.Placeholder.GetLeft();
				MoveData.TopControl.Resize(
					MoveData.TopControl.GetWidth(),
					MoveData.TopControl.GetHeight() + (top - MoveData.PreviousTop)
				);
				MoveData.BottomControl.Resize(
					MoveData.BottomControl.GetWidth(),
					MoveData.BottomControl.GetHeight() - (top - MoveData.PreviousTop)
				);
				MoveData.BottomControl.Move(
					MoveData.BottomControl.GetLeft(),
					MoveData.BottomControl.GetTop() + (top - MoveData.PreviousTop)
				);
				MoveData.Target.Move(left, top);
				MoveData.Target.GetParent().RemoveControl(MoveData.Placeholder);
				Desktop.LeaveMove();
				MoveData = null;
			}
		}
	);

	/*
	config={
	TopControl:
	BottomControl:
	}
	*/
	function HorizSplit(config)
	{
		var This = this;

		if (config.Css == undefined) config.Css = "horizSplit";

		Module.Control.call(This, config);

		var Base = {
			GetType: This.GetType,
			is: This.is
		}

		This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
		This.GetType = function() { return "HorizSplit"; }

		System.AttachEvent(
			This.GetDom(), "mousedown",
			function(evt)
			{
				if (evt == undefined) evt = event;
				var parent = This.GetParent();

				Desktop.EnterMove("n-resize");

				var placeholder = new Module.Control(
					{
						Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
						Parent: This.GetParent(),
						Css: "moveHorizSplit"
					}
				);

				MoveData = {
					Target: This,
					Placeholder: placeholder,
					Bound: {
						Top: config.TopControl.GetTop() + 50,
						Bottom: config.BottomControl.GetTop() + config.BottomControl.GetHeight() - 50
					},
					PreviousTop: This.GetTop(),
					PreviousClientX: evt.clientX,
					PreviousClientY: evt.clientY,
					TopControl: config.TopControl,
					BottomControl: config.BottomControl
				}
			}
		);
	}

	Module.HorizSplit = HorizSplit;

	return Module.CreateHorizSplit = function(top, bottom, anchorTop)
	{
		if (top.GetParent() == null || top.GetParent() != bottom.GetParent()) return;

		if (anchorTop == undefined) anchorTop = true;

		new Module.HorizSplit(
			{
				Left: top.GetLeft(),
				Top: top.GetTop() + top.GetHeight(),
				Width: top.GetWidth(),
				Height: bottom.GetTop() - (top.GetTop() + top.GetHeight()),
				Parent: top.GetParent(),
				TopControl: top, BottomControl: bottom,
				AnchorStyle: Module.AnchorStyle.Left | Module.AnchorStyle.Right | (anchorTop ? Module.AnchorStyle.Top : Module.AnchorStyle.Bottom)
			}
		);
	}

})();

(function()
{

	var MoveData = null; /*{
		Target:null,
		Placeholder:null,
		Background:null,
		Bound:,
		PreviousLeft:0,
		PreviousClientX:0,
		PreviousClientY:0,
		LeftControl:
		RightControl:
	};*/

	System.AttachEvent(
		document, "mousemove",
		function(evt)
		{
			if (evt == undefined) evt = event;
			if (MoveData != null)
			{
				var newLeft = MoveData.PreviousLeft + (evt.clientX - MoveData.PreviousClientX);
				if (newLeft >= MoveData.Bound.Left && newLeft <= MoveData.Bound.Right)
				{
					MoveData.Placeholder.Move(newLeft, MoveData.Placeholder.GetTop());
				}
			}
		}
	);

	System.AttachEvent(
		document, "mouseup",
		function(evt)
		{
			if (MoveData != null)
			{
				var top = MoveData.Placeholder.GetTop();
				var left = MoveData.Placeholder.GetLeft();
				var difX = left - MoveData.PreviousLeft;
				MoveData.LeftControl.Resize(
					MoveData.LeftControl.GetWidth() + difX,
					MoveData.LeftControl.GetHeight()
				);
				MoveData.RightControl.Resize(
					MoveData.RightControl.GetWidth() - difX,
					MoveData.RightControl.GetHeight()
				);
				MoveData.RightControl.Move(
					MoveData.RightControl.GetLeft() + difX,
					MoveData.RightControl.GetTop()
				);
				MoveData.Target.Move(left, top);
				MoveData.Target.GetParent().RemoveControl(MoveData.Placeholder);
				Desktop.LeaveMove();
				MoveData = null;
			}
		}
	);

	/*
	config={
	LeftControl:
	RightControl:
	}
	*/
	function VerticalSplit(config)
	{
		var This = this;
		if (config.Css == undefined) config.Css = "verticalSplit";

		Module.Control.call(This, config);

		var Base = {
			GetType: This.GetType,
			is: This.is
		}

		This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
		This.GetType = function() { return "HorizSplit"; }

		System.AttachEvent(
			This.GetDom(), "mousedown",
			function(evt)
			{
				if (evt == undefined) evt = event;
				var parent = This.GetParent();

				Desktop.EnterMove("e-resize");

				var placeholder = new Module.Control(
					{
						Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
						Parent: This.GetParent(),
						Css: "moveVerticalSplit"
					}
				);

				MoveData = {
					Target: This,
					Placeholder: placeholder,
					Bound: {
						Left: config.LeftControl.GetLeft() + 50,
						Right: config.RightControl.GetLeft() + config.RightControl.GetWidth() - 50
					},
					PreviousLeft: This.GetLeft(),
					PreviousClientX: evt.clientX,
					PreviousClientY: evt.clientY,
					LeftControl: config.LeftControl,
					RightControl: config.RightControl
				}
			}
		);
	}

	Module.VerticalSplit = VerticalSplit;

	Module.CreateVerticalSplit = function(left, right, anchorLeft)
	{
		if (left.GetParent() == null || left.GetParent() != right.GetParent()) return;

		if (anchorLeft == undefined) anchorLeft = true;

		return new Module.VerticalSplit(
			{
				Left: left.GetLeft() + left.GetWidth(),
				Top: left.GetTop(),
				Width: right.GetLeft() - (left.GetLeft() + left.GetWidth()),
				Height: left.GetHeight(),
				Parent: left.GetParent(),
				LeftControl: left, RightControl: right,
				AnchorStyle: (anchorLeft ? Module.AnchorStyle.Left : Module.AnchorStyle.Right) | Module.AnchorStyle.Top | Module.AnchorStyle.Bottom
			}
		);
	}

})();

(function()
{
	/*
	config={
	NormalCss:
	SelectedCss:
	TabHeight:
	Tabs:[
	{Text:...,Width:,IsSelected:}
	],
	继承Control...
	}
	*/
	function SimpleTabControl(config)
	{
		var This = this;

		if (config.Css == undefined) config.Css = "simple_tab";
		if (config.NormalCss == undefined) config.NormalCss = "tab_normal";
		if (config.SelectedCss == undefined) config.SelectedCss = "tab_selected";
		if (config.TabHeight == undefined) config.TabHeight = 25;

		Module.Control.call(This, config);

		var Base = {
			GetType: This.GetType,
			is: This.is
		}

		This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
		This.GetType = function() { return "SimpleTabControl"; }
		
		This.Private = {};

		var m_Header = new Module.Control(
			{
				Left: 0, Top: 0, Height: config.TabHeight, Width: This.GetClientWidth(),
				AnchorStyle: Module.AnchorStyle.Left | Module.AnchorStyle.Right,
				Parent: This, Css: "header", BorderWidth: 0
			}
		);

		var m_Body = new Module.Control(
			{
				Left: 0, Top: config.TabHeight, Height: This.GetClientHeight() - config.TabHeight, Width: This.GetClientWidth(),
				AnchorStyle: Module.AnchorStyle.All,
				Parent: This, BorderWidth: 0
			}
		);

		var m_Tabs = [];
		var m_SelectedTab = null;
		
		This.Reset=function(tabs)
		{
			m_Header.GetDom().innerHTML="";
			m_Body.GetDom().innerHTML="";
			m_SelectedTab=null;
			m_Tabs=[];
			
			for (var i in tabs)
			{
				var tabConf = tabs[i];
				var tab = new Tab(tabConf.Text, IsNull(tabConf.Width, 0));
				m_Tabs.push(tab);
				if (tabConf.IsSelected != undefined && tabConf.IsSelected) m_SelectedTab = tab;
			}
			This.Private.Select(m_SelectedTab);
		}


		function indexOf(tab)
		{
			for (var i = 0; i < m_Tabs.length; i++)
			{
				if (m_Tabs[i] == tab)
				{
					return i;
				}
			}
		}

		This.Private.Select = function(tab)
		{
			if(tab==null) return;
			var preIndex = indexOf(m_SelectedTab);
			if (m_SelectedTab != null) m_SelectedTab.Deselect();
			m_SelectedTab = tab;
			m_SelectedTab.Select();
			This.OnSelectedTab.Call(indexOf(tab), preIndex);
		}

		This.Select = function(index)
		{
			This.Private.Select(m_Tabs[index]);
		}
		
		This.GetSelectedIndex=function()
		{
			return indexOf(m_SelectedTab);
		}

		This.OnSelectedTab = new Delegate();

		This.GetPanel = function(index)
		{
			return m_Tabs[index].Panel;
		}
		
		This.Reset(IsNull(config.Tabs,[]));
		
		function Tab(text, width)
		{
			var tab = this;

			var dom = document.createElement("DIV");
			dom.innerHTML = System.ReplaceHtml(text);
			if (width > 0) dom.style.width = width + 'px';

			m_Header.GetDom().appendChild(dom);

			this.Panel = new Module.Control(
				{
					Left: 0, Top: 0, Height: m_Body.GetClientHeight(), Width: m_Body.GetClientWidth(),
					AnchorStyle: Module.AnchorStyle.All,
					Parent: m_Body, BorderWidth: 0
				}
			);
			this.Select = function()
			{
				dom.className = config.SelectedCss;
				this.Panel.SetVisible(true);
			}
			this.Deselect = function()
			{
				dom.className = config.NormalCss;
				this.Panel.SetVisible(false);
			}
			dom.onclick = function()
			{
				This.Private.Select(tab);
			}

			this.Deselect();
		}

	}

	Module.SimpleTabControl = SimpleTabControl;
} ());