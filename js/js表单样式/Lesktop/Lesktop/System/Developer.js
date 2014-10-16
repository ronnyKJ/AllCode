
System.Link("StyleSheet", Module.GetResourceUrl("Developer/StyleSheet.css"), "text/css");

var TAB = "    ", TABEM = 4, EM = 7;
var Controls = null;
var Window = null, Control = null;
var Contructors = null;

var HtmlFormat = {};

HtmlFormat.Form=
'<br/>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}function {NAME}()\r\n'+
'{PAD}{{\r\n'+
'{PAD}{TAB}var This = this;\r\n'+
'{PAD}{TAB}var OwnerForm = this;\r\n'+
'{PAD}{TAB}\r\n'+
'{PAD}{TAB}var config = {CONFIG};\r\n'+
'</pre>\r\n'+
'{CUSTOMCONFIG}\r\n'+
'<div id="{NAME}.CustomConfig" style="margin-left:{ML:1}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}{TAB}Window.call(This, config);\r\n'+
'{PAD}\r\n'+
'{PAD}{TAB}var Base = {{\r\n'+
'{PAD}{TAB}{TAB}GetType: This.GetType,\r\n'+
'{PAD}{TAB}{TAB}is: This.is\r\n'+
'{PAD}{TAB}};\r\n'+
'{PAD}\r\n'+
'{PAD}{TAB}This.GetType = function() {{ return "{NAME}"; }\r\n'+
'{PAD}{TAB}This.is = function(type) {{ return type == This.GetType() ? true : Base.is(type); }\r\n'+
'</pre>\r\n'+
'{CTRLS}{TAB}\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}{TAB}var m_Task = null;\r\n'+
'{PAD}{TAB}if(config.HasMinButton)\r\n'+
'{PAD}{TAB}{{\r\n'+
'{PAD}{TAB}{TAB}m_Task=Taskbar.AddTask(This,IsNull(config.Title.InnerHTML,""));\r\n'+
'{PAD}{TAB}{TAB}This.OnClosed.Attach(\r\n'+
'{PAD}{TAB}{TAB}{TAB}function()\r\n'+
'{PAD}{TAB}{TAB}{TAB}{{\r\n'+
'{PAD}{TAB}{TAB}{TAB}{TAB}Taskbar.RemoveTask(m_Task);\r\n'+
'{PAD}{TAB}{TAB}{TAB}}\r\n'+
'{PAD}{TAB}{TAB});\r\n'+
'{PAD}{TAB}}\r\n'+
'</pre>\r\n'+
'{MEMBER}\r\n'+
'<div id="{NAME}.Member" style="margin-left:{ML:1}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}}\r\n'+
'</pre>\r\n';

HtmlFormat.CustomControl=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{GLOBAL}\r\n'+
'<div id="{NAME}.Global" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}function {NAME}(config)\r\n'+
'{PAD}{{\r\n'+
'{PAD}{TAB}var This = this;\r\n'+
'{PAD}{TAB}var OwnerForm = this;\r\n'+
'{PAD}{TAB}\r\n'+
'</pre>\r\n'+
'{CUSTOMCONFIG}\r\n'+
'<div id="{NAME}.CustomConfig" style="margin-left:{ML:1}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}{TAB}\r\n'+
'{PAD}{TAB}var width = config.Width, height = config.Height;\r\n'+
'{PAD}{TAB}config.Width={WIDTH};\r\n'+
'{PAD}{TAB}config.Height={HEIGHT};\r\n'+
'{PAD}\r\n'+
'{PAD}{TAB}{BASE}.call(This, config);\r\n'+
'{PAD}\r\n'+
'{PAD}{TAB}var Base = {{\r\n'+
'{PAD}{TAB}{TAB}GetType: This.GetType,\r\n'+
'{PAD}{TAB}{TAB}is: This.is\r\n'+
'{PAD}{TAB}};\r\n'+
'{PAD}\r\n'+
'{PAD}{TAB}This.GetType = function() {{ return "{NAME}"; }\r\n'+
'{PAD}{TAB}This.is = function(type) {{ return type == This.GetType() ? true : Base.is(type); }\r\n'+
'</pre>\r\n'+
'{CTRLS}{TAB}\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{MEMBER}\r\n'+
'<div id="{NAME}.Member" style="margin-left:{ML:1}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}{TAB}This.Resize(width,height);\r\n'+
'{PAD}}\r\n'+
'</pre>\r\n';

HtmlFormat.Control=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new Controls.Control({CONFIG});\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}{NAME}.OnResized.Attach(\r\n'+
'{PAD}{TAB}function(btn)\r\n'+
'{PAD}{TAB}{{\r\n'+
'</pre>\r\n'+
'{ONRESIZED_EVENT}\r\n'+
'<div id="{FULLNAME}.OnResized" style="margin-left:{ML:2}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}{TAB}}\r\n'+
'{PAD})\r\n'+
'</pre>\r\n';

HtmlFormat.SimpleTabControl=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new Controls.SimpleTabControl({CONFIG});\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}{NAME}.OnSelectedTab.Attach(\r\n'+
'{PAD}{TAB}function(index,preIndex)\r\n'+
'{PAD}{TAB}{{\r\n'+
'</pre>\r\n'+
'{ONRESIZED_EVENT}\r\n'+
'<div id="{FULLNAME}.OnSelectedTab" style="margin-left:{ML:2}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}{TAB}}\r\n'+
'{PAD})\r\n'+
'</pre>\r\n';

HtmlFormat.RichEditor=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new RichEditor({CONFIG});\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n';

HtmlFormat.RadioButton=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new Controls.RadioButton({CONFIG});\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n';

HtmlFormat.CheckBox=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new Controls.CheckBox({CONFIG});\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n';


HtmlFormat.CustomControlObject=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME}_Config={CONFIG};\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{ONRESIZED_EVENT}\r\n'+
'<div id="{FULLNAME}.Config" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new {CLASS}({NAME}_Config);\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n';

HtmlFormat.Label=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new Controls.Label({CONFIG});\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n';

HtmlFormat.Button=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new Controls.Button({CONFIG});\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}{NAME}.OnClick.Attach(\r\n'+
'{PAD}{TAB}function(btn)\r\n'+
'{PAD}{TAB}{{\r\n'+
'</pre>\r\n'+
'{ONCLICK}\r\n'+
'<div id="{FULLNAME}.OnClick" style="margin-left:{ML:2}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}{TAB}}\r\n'+
'{PAD})\r\n'+
'</pre>\r\n';

HtmlFormat.TextBox=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new Controls.TextBox({CONFIG});\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n';

HtmlFormat.Password=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new Controls.PasswordBox({CONFIG});\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n';


HtmlFormat.TextArea=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new Controls.TextArea({CONFIG});\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n';

HtmlFormat.DropDownList=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new Controls.DropDownList({CONFIG});\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n';

HtmlFormat.ListBox=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new Controls.ListBox({CONFIG});\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n';

HtmlFormat.ListView=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME}_Config={CONFIG};\r\n'+
'{PAD}\r\n'+
'{PAD}{NAME}_Config.Columns={COLUMNS};\r\n'+
'{PAD}\r\n'+
'{PAD}function {NAME}_ListItem()\r\n'+
'{PAD}{{\r\n'+
'{PAD}{TAB}var This=this;\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{LIST_MEMBER}\r\n'+
'<div id="{FULLNAME}.ListItem.Member" style="margin-left:{ML:1}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}{TAB}\r\n'+
'{PAD}{TAB}this.GetText=function(columnName)\r\n'+
'{PAD}{TAB}{{\r\n'+
'</pre>\r\n'+
'{LIST_GETTEXT}\r\n'+
'<div id="{FULLNAME}.ListItem.GetText" style="margin-left:{ML:2}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}{TAB}}\r\n'+
'{PAD}}\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new Controls.ListView({NAME}_Config);\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n';

HtmlFormat.TreeView=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME}_DS=function()\r\n'+
'{PAD}{{\r\n'+
'</pre>\r\n'+
'{DSMEMBER}\r\n'+
'<div id="{FULLNAME}.DataSource.Member" style="margin-left:{ML:1}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}{TAB}this.GetSubNodes=function(callback,item)\r\n'+
'{PAD}{TAB}{{\r\n'+
'</pre>\r\n'+
'{GETSUBNODES}\r\n'+
'<div id="{FULLNAME}.DataSource.GetSubNodes" style="margin-left:{ML:2}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}{TAB}}\r\n'+
'{PAD}}\r\n'+
'</pre>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new Controls.TreeView({CONFIG});\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}{NAME}.OnClick.Attach(\r\n'+
'{PAD}{TAB}function(btn)\r\n'+
'{PAD}{TAB}{{\r\n'+
'</pre>\r\n'+
'{ONCLICK_CODE}\r\n'+
'<div id="{FULLNAME}.OnClick" style="margin-left:{ML:2}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}{TAB}}\r\n'+
'{PAD})\r\n'+
'</pre>\r\n';

HtmlFormat.FileBrowser=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME}_Config={CONFIG};\r\n'+
'</pre>\r\n'+
'{CUSTOMCONFIG}\r\n'+
'<div id="{FULLNAME}.CustomConfig" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}{NAME}_Config.OnBeginRequest=function()\r\n'+
'{PAD}{{\r\n'+
'</pre>\r\n'+
'{BEGINREQUEST}\r\n'+
'<div id="{FULLNAME}.OnBeginRequest" style="margin-left:{ML:1}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}}\r\n'+
'{PAD}\r\n'+
'{PAD}{NAME}_Config.OnEndRequest=function()\r\n'+
'{PAD}{{\r\n'+
'</pre>\r\n'+
'{ENDREQUEST}\r\n'+
'<div id="{FULLNAME}.OnEndRequest" style="margin-left:{ML:1}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}}\r\n'+
'</pre>\r\n'+
'<br/>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new CommonDialog.FileBrowser({NAME}_Config);\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n';

HtmlFormat.FolderBrowser=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME}_Config={CONFIG};\r\n'+
'{PAD}\r\n'+
'{PAD}{NAME}_Config.OnBeginRequest=function()\r\n'+
'{PAD}{{\r\n'+
'</pre>\r\n'+
'{BEGINREQUEST}\r\n'+
'<div id="{FULLNAME}.OnBeginRequest" style="margin-left:{ML:1}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}}\r\n'+
'{PAD}\r\n'+
'{PAD}{NAME}_Config.OnEndRequest=function()\r\n'+
'{PAD}{{\r\n'+
'</pre>\r\n'+
'{ENDREQUEST}\r\n'+
'<div id="{FULLNAME}.OnEndRequest" style="margin-left:{ML:1}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}}\r\n'+
'</pre>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new CommonDialog.FolderBrowser({NAME}_Config);\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}{NAME}.OnClick.Attach(\r\n'+
'{PAD}{TAB}function(btn)\r\n'+
'{PAD}{TAB}{{\r\n'+
'</pre>\r\n'+
'{ONCLICK_CODE}\r\n'+
'<div id="{FULLNAME}.OnClick" style="margin-left:{ML:2}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}{TAB}}\r\n'+
'{PAD})\r\n'+
'</pre>\r\n';

HtmlFormat.ImageBrowser=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME}_Config={CONFIG};\r\n'+
'{PAD}\r\n'+
'{PAD}{NAME}_Config.OnBeginRequest=function()\r\n'+
'{PAD}{{\r\n'+
'</pre>\r\n'+
'{BEGINREQUEST}\r\n'+
'<div id="{FULLNAME}.OnBeginRequest" style="margin-left:{ML:1}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}}\r\n'+
'{PAD}\r\n'+
'{PAD}{NAME}_Config.OnEndRequest=function()\r\n'+
'{PAD}{{\r\n'+
'</pre>\r\n'+
'{ENDREQUEST}\r\n'+
'<div id="{FULLNAME}.OnEndRequest" style="margin-left:{ML:1}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}}\r\n'+
'</pre>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new CommonDialog.ImageBrowser({NAME}_Config);\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}{NAME}.OnClick.Attach(\r\n'+
'{PAD}{TAB}function(btn)\r\n'+
'{PAD}{TAB}{{\r\n'+
'</pre>\r\n'+
'{ONCLICK_CODE}\r\n'+
'<div id="{FULLNAME}.OnClick" style="margin-left:{ML:2}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}{TAB}}\r\n'+
'{PAD})\r\n'+
'</pre>\r\n';

HtmlFormat.Toolbar=
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}var {NAME} = new Controls.Toolbar({CONFIG});\r\n'+
'{PAD}\r\n'+
'</pre>\r\n'+
'{INIT}\r\n'+
'<div id="{FULLNAME}.Init" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}\r\n'+
'{PAD}{NAME}.OnCommand.Attach(\r\n'+
'{PAD}{TAB}function(command)\r\n'+
'{PAD}{TAB}{{\r\n'+
'</pre>\r\n'+
'{ONCOMMAND}\r\n'+
'<div id="{FULLNAME}.OnCommand" style="margin-left:{ML:2}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
'<pre class="sh_javascript">\r\n'+
'{PAD}{TAB}}\r\n'+
'{PAD})\r\n'+
'</pre>\r\n';

function init(completeCallback, errorCallback)
{
	function LoadModulesComplete()
	{
		Controls = System.GetModule("Controls.js");

		Window = System.GetModule("Window.js").Window;
		Control = System.GetModule("Controls.js").Control;

		ButtonPH.Default = {
			Width: 64, Height: Controls.Button.Height, Name: "button", Text: "", BorderWidth:0
		};

		ControlPH.Default = {
			Width: 120, Height: 120, Name: "control", Text: ""
		};

		LabelPH.Default = {
			Width: 60, Height: 14, Name: "label", Text: ""
		};

		TextBoxPH.Default = {
			Width: 100, Height: 22, Name: "textbox", Text: ""
		};

		PasswordPH.Default = {
			Width: 100, Height: 22, Name: "textbox", Text: ""
		};

		TextAreaPH.Default = {
			Width: 100, Height: 100, Name: "textarea", Text: ""
		};

		RadioButtonPH.Default = {
			Width: 60, Height: 20, Name: "radio", Text: ""
		};

		CheckBoxPH.Default = {
			Width: 60, Height: 20, Name: "checkbox", Text: ""
		};

		ListBoxPH.Default = {
			Width: 100, Height: 100, Name: "listbox", Text: ""
		};

		DropDownListPH.Default = {
			Width: 100, Height: 22, Name: "dropdownlist", Text: ""
		};

		ListViewPH.Default = {
			Width: 200, Height: 200, Name: "listview", Text: ""
		};

		TreeViewPH.Default = {
			Width: 100, Height: 100, Name: "treeview", Text: ""
		};

		FolderBrowserPH.Default = {
			Width: 200, Height: 200, Name: "folderbrowser", Text: ""
		};

		FileBrowserPH.Default = {
			Width: 300, Height: 200, Name: "filebrowser", Text: ""
		};

		ImageBrowserPH.Default = {
			Width: 300, Height: 200, Name: "imagebrowser", Text: ""
		};

		CustomControlObjectPH.Default = {
			Width: 100, Height: 100, Name: "customcontrol", Text: ""
		};

		RichEditorPH.Default = {
			Width: 100, Height: 100, Name: "richeditor", Text: ""
		};
		
		SimpleTabControlPH.Default={
			Width: 200, Height: 200, Name: "tab", Text: ""
		};
		
		ToolbarPH.Default={
			Width: 200, Height: Controls.Toolbar.PredefineHeight, Name: "toolbar", Text: ""
		};

		Contructors = {
			"FormPH": FormPH,
			"CustomControlDesignPH": CustomControlDesignPH,
			"ControlPH": ControlPH,
			"ButtonPH": ButtonPH,
			"LabelPH": LabelPH,
			"TextBoxPH": TextBoxPH,
			"PasswordPH": PasswordPH,
			"CheckBoxPH": CheckBoxPH,
			"RadioButtonPH": RadioButtonPH,
			"TextAreaPH": TextAreaPH,
			"ListBoxPH": ListBoxPH,
			"DropDownListPH": DropDownListPH,
			"ListViewPH": ListViewPH,
			"TreeViewPH": TreeViewPH,
			"FolderBrowserPH": FolderBrowserPH,
			"FileBrowserPH": FileBrowserPH,
			"ImageBrowserPH": ImageBrowserPH,
			"CustomControlObjectPH": CustomControlObjectPH,
			"RichEditorPH":RichEditorPH,
			"SimpleTabControlPH":SimpleTabControlPH,
			"PlaceHolderBase":PlaceHolderBase,
			"SimplePlaceHolder":SimplePlaceHolder,
			"ToolbarPH":ToolbarPH
		};
		
		completeCallback();	
	}

	System.LoadModules(
		LoadModulesComplete,
		errorCallback,
		["Window.js", "Controls.js", "RichEditor.js"]
	);

}

function dispose(completeCallback, errorCallback)
{
	completeCallback();
}

function IE6_TIP_Form()
{
	function IE6_TIP(config)
	{
		var This = this;
	    
		config.Css = "DEVELOPER_IE6_TIP_BK";
	    
		var width = config.Width, height = config.Height;
		config.Width=450;
		config.Height=250;

		Control.call(This, config);

		var Base = {
			GetType: This.GetType,
			is: This.is
		};

		This.GetType = function() { return "IE6_TIP"; }
		This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
	    

		this.GetDom().innerHTML = "<a class ='link_chrome' target='_blank' href='http://www.google.cn/chrome'></a><a class ='link_firefox' target='_blank' href='http://download.mozilla.org/?product=firefox-3.6&os=win&lang=zh-CN'></a><a class ='link_ie8' target='_blank' href='http://download.microsoft.com/download/1/6/1/16174D37-73C1-4F76-A305-902E9D32BAC9/IE8-WindowsXP-x86-CHS.exe'></a>";

		This.Resize(width,height);
	}
	
    var This = this;
    var OwnerForm = this;
    
    var config = {"Left":95,"Top":25,"Width":464,"Height":282,"AnchorStyle":Controls.AnchorStyle.Left | Controls.AnchorStyle.Top,"Parent":null,"Css":"window","BorderWidth":6,"HasMinButton":false,"HasMaxButton":false,"Resizable":false,"Title":{"InnerHTML":"提示"}};
    
    Window.call(This, config);

    var Base = {
        GetType: This.GetType,
        is: This.is
    };

    This.GetType = function() { return "MainForm"; }
    This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
    
    var customcontrol5_Config={"Left":1,"Top":1,"Width":450,"Height":250,"AnchorStyle":Controls.AnchorStyle.Left|Controls.AnchorStyle.Top,"Parent":This,"Text":"","Css":"control"};

	var customcontrol5 = new IE6_TIP(customcontrol5_Config);
}

var IE6_TIP = null;

function RedirectCssUrl(dir, css)
{
	return css.replace(
		/url\(\s*\x22([1-9a-zA-Z_\-\.\/\%\?]+)\x22\s*\)/ig,
		function(u, url)
		{
			return String.format("url(\"{2}/{0}?UID={1}\")", url, System.GenerateUniqueId(), dir);
		}
	);
}

function GetCursorExt()
{
	return System.GetBrowser()=="IE"?"cur":"gif";
}

function GetOffset(evt, obj)
{
	if (evt.offsetX != undefined)
	{
		return { X: evt.offsetX, Y: evt.offsetY };
	}
	else
	{
		var client = System.GetClientCoord(obj);
		return { X: evt.clientX - client.X, Y: evt.clientY - client.Y };
	}
}

function Merge(v1, v2)
{
	var res={};
	for (var key in v1) res[key] = v1[key];
	for (var key in v2) res[key] = v2[key];
	return res;
}

function CreatePH(data)
{
	var ctor = Contructors[data.Constructor];
	var ctrl = {};
	ctor.call(ctrl, data.Config);
	return ctrl;
}

function Format(fmt, paddingString, paddingCount, values)
{
	var pattern = /{{|{[0-9a-zA-Z_:]*}/g;
	return fmt.replace(
		pattern,
		function(p)
		{
			if (p == "{{") return "{";
			var key = p.substr(1, p.length - 2);
			if (key == 'PAD') return paddingString;
			if (key == "TAB") return TAB;
			if (key.substr(0, 3) == "ML:")
				return ((paddingCount + parseInt(key.substr(3, key.length - 3))) * TABEM * EM).toString();
			return values == undefined || values == null || values[key] == undefined ? "" : values[key];
		}
	);
}

function IndentCode(code, paddingString)
{
	var builder = [];
	var lines = code.split("\r\n");
	for (var i in lines)
	{
		var lines2 = lines[i].split("\n");
		for (var j in lines2)
		{
			builder.push(paddingString + lines2[j]);
		}
	}
	return builder.join("\r\n");
}

function VarName(name)
{
	this.RenderJson = function()
	{
		return name;
	}
}

function ClearHtmlTag(html)
{
	var lines = html.split("\r\n");
	var builder = [];
	for (var i in lines)
	{
		if (lines[i].substr(0, 1) != "<")
			builder.push(lines[i]);
	}
	return builder.join("\r\n");
}

function GetAnchorStyleString(anchorStyle)
{
	var ass = "";
	if ((anchorStyle & Controls.AnchorStyle.Left) != 0) ass += ("|" + "Controls.AnchorStyle.Left");
	if ((anchorStyle & Controls.AnchorStyle.Right) != 0) ass += ("|" + "Controls.AnchorStyle.Right");
	if ((anchorStyle & Controls.AnchorStyle.Top) != 0) ass += ("|" + "Controls.AnchorStyle.Top");
	if ((anchorStyle & Controls.AnchorStyle.Bottom) != 0) ass += ("|" + "Controls.AnchorStyle.Bottom");
	return ass == "" ? "Controls.AnchorStyle.Left | Controls.AnchorStyle.Top" : ass.substr(1, ass.length - 1);
}

function BoolToString(val)
{
	return val ? "True" : "False";
}


function CodeBuilder(application) //CodeBuilder
{
	var This = this;
	var ModuleGlobalHtmlFormat =
	'<pre class="sh_javascript">\r\n' +
	'{PAD}//共享全局变量和函数，在此定义的变量和函数将由该应用程序的所有实例共享\r\n' +
	'{CODE}\r\n' +
	'</pre>\r\n' +
	'<div id="global" style="margin-left:{ML:0}px; margin-top:0px; margin-bottom:0px;"></div>\r\n';

	var ModuleGlobalFormat = ClearHtmlTag(ModuleGlobalHtmlFormat);

	var InitCodeHtmlFormat =
	'<br/>\r\n'+
	'<pre class="sh_javascript">\r\n'+
	'{PAD}if(!TESTING)\r\n'+
	'{PAD}{{\r\n'+
	'{PAD}{TAB}System.Link("StyleSheet", "{CSS}", "text/css");\r\n'+
	'{PAD}}\r\n'+
	'{PAD}\r\n'+
	'{PAD}var Controls = null;\r\n'+
	'{PAD}var Window = null, Control = null, RichEditor = null;\r\n'+
	'{PAD}\r\n'+
	'{PAD}function init(completeCallback, errorCallback)\r\n'+
	'{PAD}{{\r\n'+
	'{PAD}{TAB}function LoadModulesComplete()\r\n'+
	'{PAD}{TAB}{{\r\n'+
	'{PAD}{TAB}{TAB}Controls = System.GetModule("Controls.js");\r\n'+
	'{PAD}{TAB}{TAB}CommonDialog = System.GetModule("CommonDialog.js");\r\n'+
	'{PAD}\r\n'+
	'{PAD}{TAB}{TAB}Window = System.GetModule("Window.js").Window;\r\n'+
	'{PAD}{TAB}{TAB}Control = System.GetModule("Controls.js").Control;\r\n'+
	'{PAD}{TAB}{TAB}\r\n'+
	'{PAD}{TAB}{TAB}RichEditor = System.GetModule("RichEditor.js").RichEditor;\r\n'+
	'{PAD}\r\n'+
	'{PAD}{TAB}{TAB}_init(completeCallback, errorCallback);\r\n'+
	'{PAD}{TAB}}\r\n'+
	'{PAD}\r\n'+
	'{PAD}{TAB}System.LoadModules(\r\n'+
	'{PAD}{TAB}{TAB}LoadModulesComplete,\r\n'+
	'{PAD}{TAB}{TAB}errorCallback,\r\n'+
	'{PAD}{TAB}{TAB}["Window.js", "Controls.js", "RichEditor.js"]\r\n'+
	'{PAD}{TAB});\r\n'+
	'{PAD}}\r\n'+
	'{PAD}\r\n'+
	'{PAD}function _init(completeCallback, errorCallback)\r\n'+
	'{PAD}{{\r\n'+
	'{PAD}{TAB}try\r\n'+
	'{PAD}{TAB}{{\r\n'+
	'{PAD}{TAB}{TAB}//初始化代码，初始化完成后必须调用completeCallback;\r\n'+
	'{CODE}\r\n'+
	'</pre>\r\n'+
	'<div id="init" style="margin-left:{ML:2}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
	'<pre class="sh_javascript">\r\n'+
	'{PAD}{TAB}}\r\n'+
	'{PAD}{TAB}catch (ex)\r\n'+
	'{PAD}{TAB}{{\r\n'+
	'{PAD}{TAB}{TAB}errorCallback(new Exception(ex.mame, ex.message));\r\n'+
	'{PAD}{TAB}}\r\n'+
	'{PAD}}\r\n'+
	'</pre>\r\n'+
	'{PAD}\r\n'+
	'{PAD}\r\n';

	var InitCodeFormat = ClearHtmlTag(InitCodeHtmlFormat);

	var DisposeCodeHtmlFormat =
	'<br/>\r\n' +
	'<pre class="sh_javascript">\r\n' +
	'{PAD}function dispose(completeCallback, errorCallback)\r\n' +
	'{PAD}{{\r\n' +
	'{PAD}{TAB}_dispose(completeCallback, errorCallback);\r\n' +
	'{PAD}}\r\n' +
	'{PAD}\r\n' +
	'{PAD}function _dispose(completeCallback, errorCallback)\r\n' +
	'{PAD}{{\r\n' +
	'{PAD}{TAB}try\r\n' +
	'{PAD}{TAB}{{\r\n' +
	'{PAD}{TAB}{TAB}//卸载代码，卸载完成后必须调用completeCallback;\r\n' +
	'{CODE}\r\n' +
	'</pre>\r\n' +
	'<div id="dispose" style="margin-left:{ML:2}px; margin-top:0px; margin-bottom:0px;"></div>\r\n' +
	'<pre class="sh_javascript">\r\n' +
	'{PAD}{TAB}}\r\n' +
	'{PAD}{TAB}catch (ex)\r\n' +
	'{PAD}{TAB}{{\r\n' +
	'{PAD}{TAB}{TAB}errorCallback(new Exception(ex.mame, ex.message));\r\n' +
	'{PAD}{TAB}}\r\n' +
	'{PAD}}\r\n' +
	'</pre>\r\n';

	var DisposeCodeFormat = ClearHtmlTag(DisposeCodeHtmlFormat);

	var AppCodeHtmlFormat =
	'<br/>\r\n'+
	'<pre class="sh_javascript">\r\n'+
	'{PAD}function Application()\r\n'+
	'{PAD}{{\r\n'+
	'{PAD}{TAB}var CurrentApplication = this;\r\n'+
	'{PAD}{TAB}var m_MainForm = null;\r\n'+
	'{PAD}{TAB}\r\n'+
	'{PAD}{TAB}//应用程序全局对象;\r\n'+
	'{GLOBAL}{TAB}\r\n'+
	'</pre>\r\n'+
	'<div id="AppGlobal" style="margin-left:{ML:1}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
	'<pre class="sh_javascript">\r\n'+
	'{PAD}\r\n'+
	'{PAD}{TAB}this.Start = function(baseUrl)\r\n'+
	'{PAD}{TAB}{{\r\n'+
	'{PAD}{TAB}{TAB}//应用程序入口;\r\n'+
	'{START}\r\n'+
	'</pre>\r\n'+
	'<div id="AppStart" style="margin-left:{ML:2}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
	'<pre class="sh_javascript">\r\n'+
	'{PAD}{TAB}}\r\n'+
	'{PAD}\r\n'+
	'{PAD}{TAB}this.Terminate = function(completeCallback, errorCallback)\r\n'+
	'{PAD}{TAB}{{\r\n'+
	'{PAD}{TAB}{TAB}try\r\n'+
	'{PAD}{TAB}{TAB}{{\r\n'+
	'{PAD}{TAB}{TAB}{TAB}//应用程序终止，退出系统时用系统调用;\r\n'+
	'{TERMINATE}\r\n'+
	'</pre>\r\n'+
	'<div id="AppTerminate" style="margin-left:{ML:3}px; margin-top:0px; margin-bottom:0px;"></div>\r\n'+
	'<pre class="sh_javascript">\r\n'+
	'{PAD}{TAB}{TAB}}\r\n'+
	'{PAD}{TAB}{TAB}catch (ex)\r\n'+
	'{PAD}{TAB}{TAB}{{\r\n'+
	'{PAD}{TAB}{TAB}{TAB}errorCallback(new Exception(ex.mame, ex.message));\r\n'+
	'{PAD}{TAB}{TAB}}\r\n'+
	'{PAD}{TAB}}\r\n'+
	'</pre>\r\n'+
	'{FORMS}\r\n'+
	'<pre class="sh_javascript">\r\n'+
	'{PAD}}\r\n'+
	'</pre>\r\n'+
	'{CUSTOMCTRLS}\r\n';

	var AppCodeFormat = ClearHtmlTag(AppCodeHtmlFormat);

	var Default = {
		InitCode: "completeCallback();",
		DisposeCode: "completeCallback();",
		ModuleGlobalCode: "",
		ApplicationGlobalCode: "",

		AppGlobal: "",
		AppStartCode: 'm_MainForm = new MainForm();\r\n' +
			'm_MainForm.OnClosed.Attach(\r\n' +
			'    function()\r\n' +
			'    {\r\n' +
			'        CurrentApplication.Dispose();\r\n' +
			'    }\r\n' +
			');\r\n' +
			'm_MainForm.MoveEx("center", 0, 0);\r\n' +
			'm_MainForm.Show(true);\r\n',
		AppTerminateCode: "completeCallback();"
	};

	this.InitCode = "completeCallback();";
	this.DisposeCode = "completeCallback();";
	this.FormPHs = [];
	this.ModuleGlobalCode = "";
	this.ApplicationGlobalCode = "";

	this.AppGlobal = "";
	this.AppStartCode =
	'm_MainForm = new MainForm();\r\n' +
	'm_MainForm.OnClosed.Attach(\r\n' +
	'    function()\r\n' +
	'    {\r\n' +
	'        CurrentApplication.Dispose();\r\n' +
	'    }\r\n' +
	');\r\n' +
	'm_MainForm.MoveEx("center", 0, 0);\r\n' +
	'm_MainForm.Show(true);\r\n';
	This.AppTerminateCode = "completeCallback();";

	This.IndexOf = function(ph)
	{
		var i = 0;
		for (i = 0; i < This.FormPHs.length; i++)
		{
			if (This.FormPHs[i] == ph) return i;
		}
		return -1;
	}

	This.GetForm = function(name)
	{
		for (var i in This.FormPHs)
		{
			if (This.FormPHs[i].GetName() == name) return This.FormPHs[i];
		}
		return null;
	}

	This.RemoveForm = function(ph)
	{
		var i = 0;
		for (i = 0; i < This.FormPHs.length; i++)
		{
			if (This.FormPHs[i] == ph) break;
		}
		This.FormPHs.splice(i, 1);
	}

	This.Load = function(data)
	{
		this.InitCode = IsNull(data.InitCode, Default.InitCode);
		this.DisposeCode = IsNull(data.DisposeCode, Default.DisposeCode);
		this.ModuleGlobalCode = IsNull(data.ModuleGlobalCode, Default.ModuleGlobalCode);
		this.ApplicationGlobalCode = IsNull(data.ApplicationGlobalCode, Default.ApplicationGlobalCode);
		this.AppGlobal = IsNull(data.AppGlobal, Default.AppGlobal);
		this.AppStartCode = IsNull(data.AppStartCode, Default.AppStartCode);
		this.AppTerminateCode = IsNull(data.AppTerminateCode, Default.AppTerminateCode);

		for (var i in data.Forms)
		{
			this.FormPHs.push(CreatePH(data.Forms[i]));
		}

	}

	This.RenderCodeHtml = function()
	{
		var forms = [];
		This.FormPHs[0].RenderCodeHtml(forms, TAB, 1);
		
		var ctrls = [];
		for (var i = 1; i < This.FormPHs.length; i++)
		{
			This.FormPHs[i].RenderCodeHtml(ctrls, "", 0);
		}

		var builder = [];

		builder.push(Format(InitCodeHtmlFormat, "", 0, {PRJNAME:application.GetProjectName()}));
		builder.push(Format(DisposeCodeHtmlFormat, "", 0));
		builder.push(Format(ModuleGlobalHtmlFormat, "", 0));
		builder.push(Format(AppCodeHtmlFormat, "", 0, { FORMS: forms.join("\r\n") ,CUSTOMCTRLS:ctrls.join("\r\n")}));
		return builder.join("\r\n");
	}

	This.RenderEditor = function(editor)
	{
		for (var i in This.FormPHs)
		{
			This.FormPHs[i].RenderEditor(editor);
		}

		editor.AddEditor("global", "共享全局变量和函数", This.ModuleGlobalCode);
		editor.AddEditor("init", "初始化代码", This.InitCode);
		editor.AddEditor("dispose", "卸载代码", This.DisposeCode);
		editor.AddEditor("AppGlobal", "应用程序全局对象", This.AppGlobal);
		editor.AddEditor("AppStart", "应用程序入口", This.AppStartCode);
		editor.AddEditor("AppTerminate", "应用程序终止", This.AppTerminateCode);
	}

	This.RenderCode = function()
	{
		var forms = [];
		This.FormPHs[0].RenderCode(forms, TAB, 1);

		var ctrls = [];
		for (var i = 1; i < This.FormPHs.length; i++)
		{
			This.FormPHs[i].RenderCode(ctrls, "", 0);
		}
		
		var builder = [];

		builder.push(Format(InitCodeFormat, "", 0, { CODE: IndentCode(This.InitCode, TAB + TAB) ,CSS:application.GetCssUrl()}));
		builder.push(Format(DisposeCodeFormat, "", 0, { CODE: IndentCode(This.DisposeCode, TAB + TAB) }));
		builder.push(Format(ModuleGlobalFormat, "", 0, { CODE: IndentCode(This.ModuleGlobalCode, "") }));
		builder.push(Format(AppCodeFormat, "", 0,
			{
				START: IndentCode(This.AppStartCode, TAB + TAB),
				GLOBAL: IndentCode(This.AppGlobal, TAB),
				TERMINATE: IndentCode(This.AppTerminateCode, TAB + TAB + TAB),
				FORMS: forms.join('\r\n'),
				CUSTOMCTRLS:ctrls.join("\r\n")
			}
		));
		return builder.join("\r\n");
	}

	This.ReadCode = function(editor)
	{
		this.InitCode = editor.Read("init");
		this.DisposeCode = editor.Read("dispose");
		this.ModuleGlobalCode = editor.Read("global");
		this.AppGlobal = editor.Read("AppGlobal");
		this.AppStartCode = editor.Read("AppStart");
		this.AppTerminateCode = editor.Read("AppTerminate");

		for (var i in this.FormPHs)
		{
			This.FormPHs[i].ReadCode(editor);
		}
	}

	This.GetSaveData = function()
	{
		var forms = [];
		for (var i in This.FormPHs)
		{
			forms.push(This.FormPHs[i].GetSaveData());
		}
		var config = {
			Forms:forms,
			InitCode: This.InitCode,
			DisposeCode: This.DisposeCode,
			ModuleGlobalCode: This.ModuleGlobalCode,
			AppStartCode: This.AppStartCode,
			AppGlobal: This.AppGlobal,
			AppTerminateCode: This.AppTerminateCode
		};
		return config;
	}

	This.GetAnchors = function()
	{
		return [
			{ Name: "init", Text: "初始化代码", ID: "init" },
			{ Name: "dispose", Text: "卸载代码", ID: "dispose" },
			{ Name: "global", Text: "共享全局变量和函数", ID: "global" },
			{ Name: "AppGlobal", Text: "应用程序全局对象", ID: "AppGlobal" },
			{ Name: "AppStart", Text: "应用程序入口", ID: "AppStart" },
			{ Name: "AppTerminate", Text: "应用程序终止", ID: "AppTerminate" }
		];
	}

} //CodeBuilder end

var MoveVar = null;
var ResizeVar = null;
var DragCtrolVar = null;

System.AttachEvent(
	document, "mousemove",
	function(evt)
	{
		if (DragCtrolVar != null)
		{
		}
		else if (MoveVar != null)
		{
			var newLeft = MoveVar.Left + (evt.clientX - MoveVar.MouseLeft);
			var newTop = MoveVar.Top + (evt.clientY - MoveVar.MouseTop);
			if (newLeft + MoveVar.Window.GetWidth() > 0 && newLeft < MoveVar.Window.GetParent().GetWidth() &&
				newTop + MoveVar.Window.GetHeight() > 0 && newTop < MoveVar.Window.GetParent().GetHeight())
			{
				MoveVar.NewLeft = newLeft;
				MoveVar.NewTop = newTop;

				MoveVar.Window.Move(MoveVar.NewLeft, MoveVar.NewTop);
			}
		}
		else if (ResizeVar != null)
		{
			var newLeft = ResizeVar.NewLeft;
			var newTop = ResizeVar.NewTop;
			var newWidth = ResizeVar.NewWidth;
			var newHeight = ResizeVar.NewHeight;
			/*
			if (newLeft + MoveVar.Window.GetWidth() > 0 && newLeft < MoveVar.Window.GetWidth() && 
			newTop + MoveVar.Window.GetHeight() > 0 && newTop < MoveVar.Window.GetHeight())
			{
			MoveVar.NewLeft = newLeft;
			MoveVar.NewTop = newTop;

				MoveVar.Window.Move(MoveVar.NewLeft, MoveVar.NewTop);
			}
			*/
			var diffX = evt.clientX - ResizeVar.MouseLeft
			var diffY = evt.clientY - ResizeVar.MouseTop
			switch (ResizeVar.Type)
			{
			case 0:
				newWidth = ResizeVar.Width - diffX;
				newHeight = ResizeVar.Height - diffY;
				newLeft = ResizeVar.Left + diffX;
				newTop = ResizeVar.Top + diffY;
				break;
			case 1:
				newHeight = ResizeVar.Height - diffY;
				newTop = ResizeVar.Top + diffY;
				break;
			case 2:
				newWidth = ResizeVar.Width + diffX;
				newHeight = ResizeVar.Height - diffY;
				newTop = ResizeVar.Top + diffY;
				break;
			case 3:
				newWidth = ResizeVar.Width - diffX;
				newLeft = ResizeVar.Left + diffX;
				break;
			case 5:
				newWidth = ResizeVar.Width + diffX;
				break;
			case 6:
				newWidth = ResizeVar.Width - diffX;
				newHeight = ResizeVar.Height + diffY;
				newLeft = ResizeVar.Left + diffX;
				break;
			case 7:
				newHeight = ResizeVar.Height + diffY;
				break;
			case 8:
				newHeight = ResizeVar.Height + diffY;
				newWidth = ResizeVar.Width + diffX;
				break;
			}


			if (newWidth >= ResizeVar.MinWidth)
			{
				ResizeVar.NewLeft = newLeft;
				ResizeVar.NewWidth = newWidth;
			}

			if (newHeight >= ResizeVar.MinHeight)
			{
				ResizeVar.NewTop = newTop;
				ResizeVar.NewHeight = newHeight;
			}

			ResizeVar.Window.Move(ResizeVar.NewLeft, ResizeVar.NewTop);
			ResizeVar.Window.Resize(ResizeVar.NewWidth, ResizeVar.NewHeight);
		}
	}
);

System.AttachEvent(
	document, "mouseup",
	function(evt)
	{
		if (MoveVar != null)
		{
			MoveVar.Window.GetTopPlaceHolder().OnPropertyChanged.Call(MoveVar.Window);
			MoveVar = null;
		}
		else if (ResizeVar != null)
		{
			ResizeVar.Window.GetTopPlaceHolder().OnPropertyChanged.Call(ResizeVar.Window);
			ResizeVar = null;
		}
		else if (DragCtrolVar != null)
		{
			DragCtrolVar = null;
		}
	}
);

var FocusPlaceHolder = null;

function SetTop(ph)
{
	if (ph.GetParentPH() != null)
	{
		ph.GetDom().style.zIndex = ++ph.GetParentPH().MaxIndex;
		SetTop(ph.GetParentPH());
	}
}

function SetFocusPlaceHolder(ph)
{
	if(ph==null) return;
	if(!ph.is("PlaceHolder")) ph=ph.GetParentPH();
	//if (ph == FocusPlaceHolder) return;
	FocusPlaceHolder=ph;
	FocusPlaceHolder.GetDom().focus();
	ph.GetTopPlaceHolder().OnFocus.Call(ph);
	SetTop(FocusPlaceHolder);
}

function PlaceHolderBase(config)
{
	var This = this;

	config.BorderWidth = 0;
	Control.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize
	};

	this.GetType = function() { return "PlaceHolderBase"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
	
	This.GetDom().style.overflow = "hidden";

	This.Count = IsNull(config.Count, 0);
	This.MaxIndex = 10;
	This.OnChanged = new Delegate();
	This.OnFocus = new Delegate();
	This.OnPropertyChanged = new Delegate();

	This.HasSubControls = false;

	This.OnPHDblClick = new Delegate();

	System.AttachEvent(
		This.GetDom(), "scroll",
		function()
		{
			var dom = This.GetDom();
			if (dom.scrollLeft > 0 || dom.scrollTop > 0)
			{
				dom.scrollLeft = 0;
				dom.scrollTop = 0;
			}
		}
	);
	
	This.IsClass=function(){return false};

	var m_Text = "";
	This.GetText = function()
	{
		return m_Text;
	}

	This.SetText = function(text)
	{
		m_Text = text;
	}
	
	var m_Name="";

	This.GetName = function()
	{
		return m_Name;
	}
	This.SetName = function(value)
	{
		m_Name = value;
	}

	This.GetFullName = function()
	{
		var parent = This.GetParentPH();
		if (parent != null)
		{
			return parent.GetFullName() + "." + This.GetName();
		}
		else
		{
			return This.GetName();
		}
	}

	This.GetTopPlaceHolder = function()
	{
		var parent = This.GetParentPH();
		if (parent != null)
		{
			return parent.GetTopPlaceHolder();
		}
		else
		{
			return This;
		}
	}

	This.GetParentVarName = function()
	{
		var parent = FindParent("PlaceHolderBase");
		if (parent == null) return "null";
		if (parent != null && parent.IsClass()) return "This";
		return parent.GetName();
	}
	
	function FindParent(className)
	{
		var ph=This.GetParent();
		while(ph!=null && (ph.is==undefined || !ph.is(className))) ph=ph.GetParent();
		return ph;
	}
	
	This.GetParentPH=function()
	{
		return FindParent("PlaceHolder");
	}
	
	This.ForeachPH=function(callback)
	{
		This.Foreach(
			function(ctrl)
			{
				if(ctrl.is("PlaceHolderBase"))
				{
					callback(ctrl);
				}
			}
		);
	}

	System.AttachEvent(
		This.GetDom(), "mousemove",
		function(evt)
		{
			if (evt == undefined) evt = event;
			if (DragCtrolVar != null)
			{
				if (This.HasSubControls)
				{
					SetFocusPlaceHolder(This);
					This.GetDom().style.cursor = DragCtrolVar.Cursor;
				}
				else
				{
					This.GetDom().style.cursor = String.format("url(\"{0}.{1}\"), wait", Module.GetResourceUrl("Developer/cursor/forbidden"),GetCursorExt());
				}
				System.CancelBubble(evt);
			}
			else
			{
				This.GetDom().style.cursor = "default";
			}
		}
	);

	System.AttachEvent(
		This.GetDom(), "mouseup",
		function(evt)
		{
			if (evt == undefined) evt = event;
			if (DragCtrolVar != null)
			{
				if (This.HasSubControls)
				{
					var offset = GetOffset(evt, This.GetDom());

					++This.GetTopPlaceHolder().Count;
					
					var config = {
						Left: offset.X,
						Top: offset.Y,
						Width: DragCtrolVar.PHCtor.Default.Width, Height: DragCtrolVar.PHCtor.Default.Height,
						Parent: This,
						Css: "placeHolder",
						Text: DragCtrolVar.PHCtor.Default.Text,
						Name: DragCtrolVar.PHCtor.Default.Name + This.GetTopPlaceHolder().Count.toString()
					};
					
					if(DragCtrolVar.PHCtor == CustomControlObjectPH)
					{
						config.ClassName = DragCtrolVar.Tag.Name;
						config.Width = DragCtrolVar.Tag.Width;
						config.Height = DragCtrolVar.Tag.Height
					}
						
					var ctrl = new DragCtrolVar.PHCtor(config);

					This.GetTopPlaceHolder().OnChanged.Call(This);

					SetFocusPlaceHolder(ctrl);
				}

				This.GetDom().style.cursor = "defalut";
				DragCtrolVar = null;
				if (evt && evt.stopPropagation) evt.stopPropagation();
				else evt.cancelBubble = true;
			}
		}
	);

	This.Delete = function()
	{
	}

	This.GetSaveData = function()
	{
		var config = {
			Count: This.Count,
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			Name: This.GetName(), Text: This.GetText(),
			AnchorStyle: This.GetAnchorStyle()
		};

		var data = {
			Constructor: This.GetType(),
			Config: Merge(This.GetCustomConfig(), config)
		};

		return data;
	}

	This.GetCustomConfig = function() { return {}; };

	This.SetText(IsNull(config.Text, ""));
	This.SetName(config.Name);
}

function PlaceHolder(config)
{
	var This = this;

	PlaceHolderBase.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize
	};

	this.GetType = function() { return "PlaceHolder"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
	
	This.HasSubControls = false;

	var dom = This.GetDom();
	dom.tabIndex = 0;
	dom.innerHTML =
	"<div class='ph_border_nw' style='position:absolute; cursor:nw-resize; z-index:10000'></div>" +
	"<div class='ph_border_n' style='position:absolute; cursor:n-resize; z-index:10000'></div>" +
	"<div class='ph_border_ne' style='position:absolute; cursor:ne-resize; z-index:10000'></div>" +
	"<div class='ph_border_w' style='position:absolute; cursor:w-resize; z-index:10000'></div>" +
	"<div style='cursor:default; overflow:hidden; '></div>" +
	"<div class='ph_border_e' style='position:absolute; cursor:e-resize; z-index:10000'></div>" +
	"<div class='ph_border_sw' style='position:absolute; cursor:sw-resize; z-index:10000'></div>" +
	"<div class='ph_border_s' style='position:absolute; cursor:s-resize; z-index:10000'></div>" +
	"<div class='ph_border_se' style='position:absolute; cursor:se-resize; z-index:10000'></div>";

	var m_BorderWidth = IsNull(config.ResizeBorderWidth,4);
	
	if(config.Color!=undefined)
	{
		This.GetDom().style.backgroundColor = config.Color;
	}
					
	function resize(newWidth, newHeight)
	{
		Base.Resize(newWidth, newHeight);
		
		var ws = [m_BorderWidth, newWidth - m_BorderWidth * 2, m_BorderWidth];
		var hs = [m_BorderWidth, newHeight - m_BorderWidth * 2, m_BorderWidth];
		
		var ls = [0, m_BorderWidth, newWidth - m_BorderWidth];
		var ts = [0, m_BorderWidth, newHeight - m_BorderWidth];

		for (var y = 0; y <= 2; y++)
		{
			for (var x = 0; x <= 2; x++)
			{
				var i = y * 3 + x;
				if (i != 4)
				{
					This.GetDom().childNodes[i].style.width = ws[x] + 'px';
					This.GetDom().childNodes[i].style.height = hs[y] + 'px';
					This.GetDom().childNodes[i].style.left = ls[x] + 'px';
					This.GetDom().childNodes[i].style.top = ts[y] + 'px';
					
					This.GetDom().childNodes[i].style.margin = "0px";
					This.GetDom().childNodes[i].style.padding = "0px";
					This.GetDom().childNodes[i].style.fontSize = "2px";
				}
			}
		}
	}

	This.Resize = resize;

	System.AttachEvent(
		This.GetDom(), "dblclick",
		function(evt)
		{
			if (evt == undefined) evt = window.event;
			This.GetTopPlaceHolder().OnPHDblClick.Call(This);
			if (evt && evt.stopPropagation) evt.stopPropagation();
			else evt.cancelBubble = true;
		}
	);

	System.AttachEvent(
		This.GetDom(), "click",
		function(evt)
		{
			if (evt == undefined) evt = event;
			SetFocusPlaceHolder(This);
			System.CancelBubble(evt);
		}
	);

	System.AttachEvent(
		This.GetDom(),"mousedown",
		function(evt)
		{
			if (evt == undefined) evt = event;
			var target = null;
			if (evt.srcElement != undefined) target = evt.srcElement;
			if (evt.target != undefined) target = evt.target;

			MoveVar = {
				Window: This,
				MouseLeft: evt.clientX,
				MouseTop: evt.clientY,
				ScrollLeft: document.documentElement.scrollLeft,
				ScrollTop: document.documentElement.scrollTop,
				Left: This.GetLeft(),
				Top: This.GetTop(),
				NewLeft: This.GetLeft(),
				NewTop: This.GetTop()
			};
			SetTop(This);
			System.CancelBubble(evt);
		}
	);

	System.AttachEvent(
		This.GetDom(), "keydown",
		function(evt)
		{
			if (evt == undefined) evt = event;

			if (evt.keyCode == 46)
			{
				if(!This.IsClass()) This.Delete();
			}
			else if (evt.keyCode == 37 && !evt.shiftKey && !evt.ctrlKey && !evt.altKey)
			{
				This.Move(This.GetLeft() - 1, This.GetTop());
				This.GetTopPlaceHolder().OnPropertyChanged.Call(This);
			}
			else if (evt.keyCode == 38 && !evt.shiftKey && !evt.ctrlKey && !evt.altKey)
			{
				This.Move(This.GetLeft(), This.GetTop() - 1);
				This.GetTopPlaceHolder().OnPropertyChanged.Call(This);
			}
			else if (evt.keyCode == 39 && !evt.shiftKey && !evt.ctrlKey && !evt.altKey)
			{
				This.Move(This.GetLeft() + 1, This.GetTop());
				This.GetTopPlaceHolder().OnPropertyChanged.Call(This);
			}
			else if (evt.keyCode == 40 && !evt.shiftKey && !evt.ctrlKey && !evt.altKey)
			{
				This.Move(This.GetLeft(), This.GetTop() + 1);
				This.GetTopPlaceHolder().OnPropertyChanged.Call(This);
			}
			else if (evt.keyCode == 37 && !evt.shiftKey && evt.ctrlKey && !evt.altKey)
			{
				This.Resize(This.GetWidth() - 1, This.GetHeight());
				This.GetTopPlaceHolder().OnPropertyChanged.Call(This);
			}
			else if (evt.keyCode == 38 && !evt.shiftKey && evt.ctrlKey && !evt.altKey)
			{
				This.Resize(This.GetWidth(), This.GetHeight() - 1);
				This.GetTopPlaceHolder().OnPropertyChanged.Call(This);
			}
			else if (evt.keyCode == 39 && !evt.shiftKey && evt.ctrlKey && !evt.altKey)
			{
				This.Resize(This.GetWidth() + 1, This.GetHeight());
				This.GetTopPlaceHolder().OnPropertyChanged.Call(This);
			}
			else if (evt.keyCode == 40 && !evt.shiftKey && evt.ctrlKey && !evt.altKey)
			{
				This.Resize(This.GetWidth(), This.GetHeight() + 1);
				This.GetTopPlaceHolder().OnPropertyChanged.Call(This);
			}
			System.CancelBubble(evt);
		}
	);
	
	System.AttachEvent(
		This.GetDom(),"focus",
		function()
		{
			for (var i = 0; i <= 8; i++)
			{
				if (i != 4)
				{
					This.GetDom().childNodes[i].style.display="block";
				}
			}
			This.GetDom().style.outline = "dotted 1px black";
		}
	);
	
	System.AttachEvent(
		This.GetDom(),"blur",
		function()
		{
			for (var i = 0; i <= 8; i++)
			{
				if (i != 4)
				{
					This.GetDom().childNodes[i].style.display="none";
				}
			}
			This.GetDom().style.outline = "dotted 0px black";
		}
	);

	for (var i = 0; i <= 8; i++)
	{
		if (i != 4)
		{
			(function(rbs_type)
			{
				This.GetDom().childNodes[i].onmousedown = function(evt)
				{
					if (evt == null) evt = window.event;
					ResizeVar = {
						Left: This.GetLeft(),
						Top: This.GetTop(),
						NewLeft: This.GetLeft(),
						NewTop: This.GetTop(),
						Width: This.GetWidth(),
						Height: This.GetHeight(),
						NewWidth: This.GetWidth(),
						NewHeight: This.GetHeight(),
						MouseLeft: evt.clientX,
						MouseTop: evt.clientY,
						Type: rbs_type,
						MinWidth: 6,
						MinHeight: 6,
						Window: This
					};
					System.CancelBubble(evt);
				};
			})(i);
		}
	}

	This.Delete = function()
	{
		var parent = This.GetParent();
		if (parent != null)
		{
			parent.RemoveControl(This);
			SetFocusPlaceHolder(This.GetParentPH());
			This.GetTopPlaceHolder().OnChanged.Call(This.GetParentPH());
		}
	}

	This.Resize(config.Width, config.Height);
}

function FormPreview(config)
{
	var This = this;

	Control.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is
	};

	this.GetType = function() { return "FormPreview"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
	
	this.GetDom().innerHTML=
	"<div style='position:absolute; z-Index:1;'>"+
		"<div class='border_nw' style='float:left; z-index:0;'></div>"+
		"<div class='border_n' style='float:left; z-index:0;'></div>"+
		"<div class='border_ne' style='float:left; z-index:0;'></div>"+
		"<div class='border_w' style='float:left; z-index:0;'></div>"+
		"<div style='float:left; z-index:0; overflow:hidden;'>"+
			"<div class='title'>"+
				"<div class='icon' style='float:left;'></div>"+
				"<div class='text' style='float:left;'></div>"+
				"<div class='closeButton' style='float:right;'></div>"+
				"<div class='maxButton' style='float:right;'></div>"+
//				"<div class='restoreButton' style='float:right;'></div>"+
				"<div class='minButton' style='float:right;'></div>"+
			"</div>"+
			"<div class='content' style='overflow:hidden;' ></div>"+
		"</div>"+
		"<div class='border_e' style='float:left; z-index:0;'></div>"+
		"<div class='border_sw' style='float:left; z-index:0;'></div>"+
		"<div class='border_s' style='float:left; z-index:0;'></div>"+
		"<div class='border_se' style='float:left; z-index:0;'></div>"+
	"</div>";
	
	var _bkdom=this.GetDom().firstChild;
	var _titledom=this.GetDom().firstChild.childNodes[4].childNodes[0];
	var _clientdom=this.GetDom().firstChild.childNodes[4].childNodes[1];
	var _mindom=_titledom.childNodes[4];
	var _maxdom=_titledom.childNodes[3];
	var _textdom=_titledom.childNodes[1];
	
	var _borderWidth = 6, _titleHeight = 18;

	var m_BkImage = new Controls.HtmlControlBkImage(
		{ Horiz: [6, 100, 6], Vertical: [24, 100, 6], Css: "window_bk" }
	);
	
	m_BkImage.GetDom().style.position="absolute";
	m_BkImage.GetDom().style.zIndex="0";
	
	this.GetDom().appendChild(m_BkImage.GetDom());
	
	function resizeDom()
	{
		var clientWidth=This.GetClientWidth();
		var clientHeight=This.GetClientHeight();
		
		m_BkImage.Resize(clientWidth,clientHeight);
		
		_bkdom.style.width=clientWidth+'px';
		_bkdom.style.height=clientWidth+'px';
		_bkdom.style.margin="0px";
		_bkdom.style.padding="0px"; 
		_bkdom.style.borderWidth="0px";
		
		var ws=[_borderWidth,clientWidth-_borderWidth*2,_borderWidth]
		var hs=[_borderWidth,clientHeight-_borderWidth*2,_borderWidth]
		
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
		
		_titledom.style.width=ws[1]+'px';
		_titledom.style.height=_titleHeight + 'px';
		_titledom.style.margin="0px";
		_titledom.style.padding="0px"; 
		_titledom.style.borderWidth="0px";
					
		_clientdom.style.width=(ws[1])+'px';
		_clientdom.style.height=(hs[1]-_titleHeight)+'px';
		_clientdom.style.margin="0px";
		_clientdom.style.padding="0px";
		_clientdom.style.borderWidth="0px";
	}
		
	This.OnResized.Attach(
		function()
		{
			resizeDom();
		}
	);

	var _client = new Control(
		{
			Left: _borderWidth, Top: _borderWidth + _titleHeight,
			Width: This.GetWidth()-_borderWidth*2, Height: This.GetHeight()-_titleHeight-_borderWidth*2,
			AnchorStyle: Controls.AnchorStyle.All,
			BorderWidth: 0,
			Parent: This
		}
	);
	
	_client.GetDom().style.zIndex = 2;
	
	This.GetClient=function()
	{
		return _client;
	}
	
	This.Preview=function(title,hasMin,hasMax)
	{
		_textdom.innerHTML = title;
		_mindom.style.display = (hasMin ? "block" : "none");
		_maxdom.style.display = (hasMax ? "block" : "none");
	}
	
	resizeDom();
}

function FormPH(config)
{
	var This = this;
	var PH = this;

	config.Color = "#EFF0F2";
	config.ResizeBorderWidth=6;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize
	};

	this.GetType = function() { return "FormPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
	
	This.IsClass=function(){return true};

	This.HasSubControls = false;
	
	var FormCodeHtmlFormat = HtmlFormat.Form;

	var FormCodeFormat = ClearHtmlTag(FormCodeHtmlFormat);

	This.MemberCode = IsNull(config.MemberCode, "");
	This.CustomConfigCode = IsNull(config.CustomConfigCode, "");
	
	var m_Css = IsNull(config._Css, "window");
	var m_HasMinBtn = IsNull(config.HasMinButton, true);
	var m_HasMaxBtn = IsNull(config.HasMaxButton, true);
	var m_Resizable = IsNull(config.Resizable, true);
	
	var m_Preview=new FormPreview(
		{
			Left:0,Top:0,Width:This.GetClientWidth(),Height:This.GetClientHeight(),
			AnchorStyle:Controls.AnchorStyle.All,
			Parent:This,
			Css:"window"
		}
	);
	
	var m_SubCtrlContainer=new SimplePlaceHolder(
		{
			Left:0,Top:0,Width:m_Preview.GetClient().GetClientWidth(),Height:m_Preview.GetClient().GetClientHeight(),
			AnchorStyle:Controls.AnchorStyle.All,
			Parent:m_Preview.GetClient()
		}
	);
	m_SubCtrlContainer.GetName=function(){return "This";}
	
	m_Preview.Preview(This.GetText(),m_HasMinBtn,m_HasMaxBtn);
	
	This.ForeachPH=function(callback)
	{
		m_SubCtrlContainer.ForeachPH(callback);
	}

	function RenderConfig()
	{
		return {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(PH.GetAnchorStyle())),
			Parent: null,
			Css: m_Css, BorderWidth: 6,
			HasMinButton: m_HasMinBtn, HasMaxButton: m_HasMaxBtn, Resizable: m_Resizable,
			Title: {
				InnerHTML: This.GetText()
			}
		};
	}

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var ctrlHtml = [];

		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderCodeHtml(ctrlHtml, paddingStr + TAB, paddingEM + 1);
				}
			}
		);

		var fconfig = RenderConfig();

		builder.push(
			Format(
				FormCodeHtmlFormat,
				paddingStr, paddingEM,
				{
					NAME: This.GetName(),
					CONFIG: System.RenderJson(fconfig),
					CTRLS: ctrlHtml.join("\r\n")
				}
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Member", This.GetName()),
			String.format("{0}成员变量和方法", This.GetName()),
			this.MemberCode
		);
		
		editor.AddEditor(
			String.format("{0}.CustomConfig", This.GetName()),
			String.format("其它配置", This.GetName()),
			this.CustomConfigCode
		);


		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderEditor(editor);
				}
			}
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingEM)
	{
		var subs = [];
		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderCode(subs, paddingStr + TAB, paddingEM + 1);
				}
			}
		);

		var fconfig = RenderConfig();

		builder.push(Format(
			FormCodeFormat, paddingStr, paddingEM,
			{
				NAME: This.GetName(), CONFIG: System.RenderJson(fconfig), CTRLS: subs.join("\r\n"),
				MEMBER: IndentCode(This.MemberCode, paddingStr + TAB,paddingEM + 1),
				CUSTOMCONFIG: IndentCode(This.CustomConfigCode, paddingStr + TAB,paddingEM + 1)
			}
		));
	}

	this.ReadCode = function(editor)
	{
		This.MemberCode = editor.Read(String.format("{0}.Member", This.GetName()));
		This.CustomConfigCode = editor.Read(String.format("{0}.CustomConfig", This.GetName()));
		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.ReadCode(editor);
				}
			}
		);
	}

	this.GetAnchors = function()
	{
		return [
			{ Name: "Member", Text: "成员变量和方法", ID: String.format("{0}.Member", This.GetName()) },
			{ Name: "CustomConfig", Text: "其它配置", ID: String.format("{0}.CustomConfig", This.GetName()) }
		];
	}

	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		return [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Title", Value: PH.GetText(), CtrlType: "text" },
			//{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "HasMinButton", Value: BoolToString(m_HasMinBtn), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "HasMaxButton", Value: BoolToString(m_HasMaxBtn), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "Resizable", Value: BoolToString(m_Resizable), CtrlType: "combobox", Options: ["True", "False"] }
		];
	};

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Title"));
		PH.SetName(propSheet.GetValue("Name"));
		//m_Css = propSheet.GetValue("Css");

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		PH.SetAnchorStyle(as);

		m_HasMinBtn = (propSheet.GetValue("HasMinButton") == "True");
		m_HasMaxBtn = (propSheet.GetValue("HasMaxButton") == "True");
		m_Resizable = (propSheet.GetValue("Resizable") == "True");
	
		m_Preview.Preview(This.GetText(),m_HasMinBtn,m_HasMaxBtn);
		
		This.OnChanged.Call(This);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Member";
	}

	This.GetCustomConfig = function()
	{
		var controls = [];
		This.ForeachPH(
			function(ctrl)
			{
				controls.push(ctrl.GetSaveData());
			}
		);
		
		var config = {
			_Css: m_Css,
			HasMinButton: m_HasMinBtn, HasMaxButton: m_HasMaxBtn, Resizable: m_Resizable,
			MemberCode: This.MemberCode,
			CustomConfigCode:This.CustomConfigCode,
			Controls:controls
		};

		return config;
	}
	
	if(config.Controls!=undefined)
	{
		for (var i in config.Controls)
		{
			var sub = CreatePH(config.Controls[i]);
			m_SubCtrlContainer.AddControl(sub);
		}
	}
}

function CustomControlDesignPH(config)
{
	var This = this;
	var PH = this;

	config.Color = "#EFF0F2";

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize
	};

	this.GetType = function() { return "CustomControlDesignPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
	
	This.IsClass=function(){return true};

	This.HasSubControls = true;
	
	var FormCodeHtmlFormat = HtmlFormat.CustomControl;
	var FormCodeFormat = ClearHtmlTag(FormCodeHtmlFormat);
	
	var BaseName=IsNull(config.BaseName,"Control");
	
	var CustomConfig=IsNull(config.CustomConfig,"");
	var GlobalCode=IsNull(config.GlobalCode,"");

	This.MemberCode = IsNull(config.MemberCode, "");

	function RenderConfig()
	{
		return {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth() + 14, Height: This.GetHeight() + 32,
			Parent: null,BorderWidth: 6,
			Title: {
				InnerHTML: This.GetText()
			}
		};
	}

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var ctrlHtml = [];

		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderCodeHtml(ctrlHtml, paddingStr + TAB, paddingEM + 1);
				}
			}
		);

		var fconfig = RenderConfig();

		builder.push(
			Format(
				FormCodeHtmlFormat,
				paddingStr, paddingEM,
				{
					NAME: This.GetName(),
					CONFIG: System.RenderJson(fconfig),
					CTRLS: ctrlHtml.join("\r\n"),
					WIDTH: This.GetWidth(),
					HEIGHT: This.GetHeight(),
					BASE: BaseName
				}
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Global", This.GetName()),
			String.format("与{0}相关的类", This.GetName()),
			GlobalCode
		);
		editor.AddEditor(
			String.format("{0}.CustomConfig", This.GetName()),
			String.format("{0} 自定义配置", This.GetName()),
			CustomConfig
		);
		editor.AddEditor(
			String.format("{0}.Member", This.GetName()),
			String.format("{0}成员变量和方法", This.GetName()),
			this.MemberCode
		);

		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderEditor(editor);
				}
			}
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingEM)
	{
		var subs = [];
		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderCode(subs, paddingStr + TAB, paddingEM + 1);
				}
			}
		);

		var fconfig = RenderConfig();

		builder.push(Format(
			FormCodeFormat, paddingStr, paddingEM,
			{
				NAME: This.GetName(), CONFIG: System.RenderJson(fconfig), CTRLS: subs.join("\r\n"),
				WIDTH: This.GetWidth(),
				HEIGHT: This.GetHeight(),
				MEMBER: IndentCode(This.MemberCode, paddingStr + TAB),
				CUSTOMCONFIG: CustomConfig,
				BASE: BaseName,
				GLOBAL: GlobalCode
			}
		));
	}

	this.ReadCode = function(editor)
	{
		This.MemberCode = editor.Read(String.format("{0}.Member", This.GetName()));
		GlobalCode = editor.Read(String.format("{0}.Global", This.GetName()));
		CustomConfig = editor.Read(String.format("{0}.CustomConfig", This.GetName()));
		
		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.ReadCode(editor);
				}
			}
		);
	}

	this.GetAnchors = function()
	{
		return [
			{ Name: "Global", Text: "相关的类", ID: String.format("{0}.Global", This.GetName()) },
			{ Name: "CustomConfig", Text: "自定义配置", ID: String.format("{0}.CustomConfig", This.GetName()) },
			{ Name: "Member", Text: "成员变量和方法", ID: String.format("{0}.Member", This.GetName()) }
		];
	}

	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		return [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "继承于", Value: BaseName, CtrlType: "text" }
		];
	};

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Title"));
		PH.SetName(propSheet.GetValue("Name"));
		BaseName = propSheet.GetValue("继承于");
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));
		This.OnChanged.Call(This);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Member";
	}

	This.GetCustomConfig = function()
	{
		var controls = [];
		This.ForeachPH(
			function(ctrl)
			{
				controls.push(ctrl.GetSaveData());
			}
		);
		
		var config = {
			Controls:controls,
			MemberCode: This.MemberCode,
			CustomConfig: CustomConfig,
			BaseName: BaseName,
			GlobalCode: GlobalCode
		};

		return config;
	}
	
	if(config.Controls!=undefined)
	{
		for (var i in config.Controls)
		{
			var sub = CreatePH(config.Controls[i]);
			This.AddControl(sub);
		}
	}
}

function ControlPH(config)
{
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize,
		SetName:this.SetName
	};

	this.GetType = function() { return "ControlPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	This.HasSubControls = true;
	
	var ControlCodeHtmlFormat = HtmlFormat.Control;

	var ControlCodeFormat = ClearHtmlTag(ControlCodeHtmlFormat);

	This.OnResizedCode = IsNull(config.OnResizedCode, "");
	This.InitCode = IsNull(config.InitCode, "");
	var m_Css = IsNull(config._Css, "control");
	
	var m_Preview=new Controls.Control(
		{
			Left:0,Top:0,Width:This.GetWidth(),Height:This.GetHeight(),
			Css:"placeholder_preview_control",BorderWidth:1,
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.All,
			Text:This.GetName()
		}
	);
	
	This.SetName=function(name)
	{
		m_Preview.GetDom().innerHTML=name;
		Base.SetName(name);
	}
	m_Preview.GetDom().innerHTML=This.GetName();

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent:  new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css
		};

		builder.push(
			Format(
				ControlCodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);

		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderCodeHtml(builder, paddingStr, paddingEM);
				}
			}
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.OnResized", This.GetFullName()),
			String.format("{0} Resized事件", This.GetName()),
			This.OnResizedCode
		);
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0}初始化", This.GetName()),
			This.InitCode
		);

		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderEditor(editor);
				}
			}
		);
	}

	This.RenderCode = function(builder, paddingString, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css
		};
		builder.push(Format(
			ControlCodeFormat, paddingString, paddingEM,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				INIT: IndentCode(This.InitCode, paddingString), ONRESIZED_EVENT: IndentCode(This.OnResizedCode, paddingString + TAB + TAB)
			}
		));

		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderCode(builder, paddingString, paddingEM);
				}
			}
		);
	}

	This.ReadCode = function(editor)
	{
		This.OnResizedCode = editor.Read(String.format("{0}.OnResized", This.GetFullName()));
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.ReadCode(editor);
				}
			}
		);
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) },
			{ Text: "OnResized 事件", Name: "OnResized", ID: String.format("{0}.OnResized", This.GetFullName()) }
		];
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		m_Css = propSheet.GetValue("Css");

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function()
	{
		var controls = [];
		This.ForeachPH(
			function(ctrl)
			{
				controls.push(ctrl.GetSaveData());
			}
		);
		
		var config = {
			_Css: m_Css,OnResizedCode: This.OnResizedCode, InitCode: This.InitCode,
			Controls:controls
		};

		return config;
	}
	
	if(config.Controls!=undefined)
	{
		for (var i in config.Controls)
		{
			var sub = CreatePH(config.Controls[i]);
			This.AddControl(sub);
		}
	}
}

function CustomControlObjectPH(config)
{
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize,
		SetName:this.SetName
	};

	this.GetType = function() { return "CustomControlObjectPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	This.HasSubControls = false;

	var ControlCodeHtmlFormat = HtmlFormat.CustomControlObject;

	var ControlCodeFormat = ClearHtmlTag(ControlCodeHtmlFormat);

	This.ConfigCode = IsNull(config.ConfigCode, "");
	This.InitCode = IsNull(config.InitCode, "");
	var m_Css = IsNull(config._Css, "control");
	var m_ClassName = IsNull(config.ClassName, "Control");
	
	var m_Preview=new Controls.Control(
		{
			Left:0,Top:0,Width:This.GetWidth(),Height:This.GetHeight(),
			Css:"placeholder_preview_common",BorderWidth:1,
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.All,
			Text:This.GetName()
		}
	);
	
	This.SetName=function(name)
	{
		m_Preview.GetDom().innerHTML=name;
		Base.SetName(name);
	}
	This.SetName(This.GetName());

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent:  new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css
		};

		builder.push(
			Format(
				ControlCodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),CLASS:m_ClassName}
			)
		);

		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderCodeHtml(builder, paddingStr, paddingEM);
				}
			}
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Config", This.GetFullName()),
			String.format("{0} 其他配置", This.GetName()),
			This.ConfigCode
		);
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0}初始化", This.GetName()),
			This.InitCode
		);

		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderEditor(editor);
				}
			}
		);
	}

	This.RenderCode = function(builder, paddingString, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css
		};
		builder.push(Format(
			ControlCodeFormat, paddingString, paddingEM,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				INIT: IndentCode(This.InitCode, paddingString), ONRESIZED_EVENT: IndentCode(This.ConfigCode, paddingString + TAB + TAB),
				CLASS:m_ClassName
			}
		));

		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderCode(builder, paddingString, paddingEM);
				}
			}
		);
	}

	This.ReadCode = function(editor)
	{
		This.ConfigCode = editor.Read(String.format("{0}.Config", This.GetFullName()));
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.ReadCode(editor);
				}
			}
		);
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) },
			{ Text: "其他配置", Name: "Config", ID: String.format("{0}.Config", This.GetFullName()) }
		];
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		m_Css = propSheet.GetValue("Css");

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function()
	{
		var config = {
			_Css: m_Css,ConfigCode: This.ConfigCode, InitCode: This.InitCode, ClassName:m_ClassName
		};

		return config;
	}
}

function ButtonPH(config)
{
	var This = this;
	var PH = this;

	config.Height = Controls.Button.Height;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize,
		SetText:this.SetText
	};

	this.GetType = function() { return "ButtonPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	System.AttachEvent(
		This.GetDom(), "dblclick",
		function(evt)
		{
		}
	);

	var ButtonCodeHtmlFormat = HtmlFormat.Button;

	var ButtonCodeFormat = ClearHtmlTag(ButtonCodeHtmlFormat);

	This.OnClickCode = IsNull(config.OnClickCode, "");
	This.InitCode = IsNull(config.InitCode, "");

	var m_Css = IsNull(config._Css, "button");
	
	var m_Preview=new Controls.Button(
		{
			Left:0,Top:0,Width:This.GetClientWidth(),Height:This.GetHeight(),
			AnchorStyle:Controls.AnchorStyle.All,
			Css:m_Css,Parent:This,BorderWidth:0,
			Text:This.GetText()
		}
	);
	
	This.SetText=function(text)
	{
		m_Preview.SetText(text);
		Base.SetText(text);
	}

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css
		};

		builder.push(
			Format(
				ButtonCodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0} 初始化", This.GetName()),
			This.InitCode
		);
		editor.AddEditor(
			String.format("{0}.OnClick", This.GetFullName()),
			String.format("{0} Click事件", This.GetName()),
			This.OnClickCode
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingCount)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css
		};
		builder.push(Format(
			ButtonCodeFormat, paddingStr, paddingCount,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				ONCLICK: IndentCode(This.OnClickCode, paddingStr + TAB + TAB), INIT: IndentCode(This.InitCode, paddingStr)
			}
		));
	}

	This.ReadCode = function(editor)
	{
		This.OnClickCode = editor.Read(String.format("{0}.OnClick", This.GetFullName()));
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) },
			{ Text: "OnClick 事件", Name: "OnClick", ID: String.format("{0}.OnClick", This.GetFullName()) }
		];
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		m_Css = propSheet.GetValue("Css");

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		
		m_Preview.SetCss(m_Css);
		
		
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".OnClick";
	}

	This.GetCustomConfig = function(builder)
	{
		var config = {
			_Css: m_Css,OnClickCode: This.OnClickCode, InitCode: This.InitCode
		};
		return config;
	}
}

function LabelPH(config)
{
	var This = this;
	var PH = this;
	
	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize
	};

	this.GetType = function() { return "LabelPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	System.AttachEvent(
		This.GetDom(), "dblclick",
		function(evt)
		{
		}
	);

	var LabelCodeHtmlFormat = HtmlFormat.Label;

	var LabelCodeFormat = ClearHtmlTag(LabelCodeHtmlFormat);

	This.InitCode = IsNull(config.InitCode, "");

	var m_Css = IsNull(config._Css, "label");
	
	var m_Preview=new Controls.Label(
		{
			Left:0,Top:0,Width:This.GetClientWidth(),Height:This.GetHeight(),
			AnchorStyle:Controls.AnchorStyle.All,
			Css:'placeholder_preview_label',Parent:This,BorderWidth:1,
			Text:This.GetText()
		}
	);

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css
		};

		builder.push(
			Format(
				LabelCodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0} 初始化", This.GetName()),
			This.InitCode
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingCount)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css
		};
		
		builder.push(Format(
			LabelCodeFormat, paddingStr, paddingCount,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				INIT: IndentCode(This.InitCode, paddingStr)
			}
		));
	}

	This.ReadCode = function(editor)
	{
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) }
		];
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		m_Css = propSheet.GetValue("Css");

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		
		m_Preview.SetText(PH.GetText());
		
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function(builder)
	{
		var config = {
			_Css: m_Css,InitCode: This.InitCode
		};
		return config;
	}
}

function TextBoxPH(config)
{
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize
	};

	this.GetType = function() { return "TextBoxPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	var CodeHtmlFormat = HtmlFormat.TextBox;

	var CodeFormat = ClearHtmlTag(CodeHtmlFormat);

	This.InitCode = IsNull(config.InitCode, "");

	var m_Css = IsNull(config._Css, "textbox");
	
	var m_Preview=new Controls.Control(
		{
			Left:0,Top:0,Width:This.GetWidth(),Height:This.GetHeight(),
			Css:"placeholder_preview_common",BorderWidth:1,
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.All,
			Text:This.GetName()
		}
	);
	
	m_Preview.GetDom().innerHTML=This.GetName();

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,BorderWidth:1
		};

		builder.push(
			Format(
				CodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0} 初始化", This.GetName()),
			This.InitCode
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingCount)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,BorderWidth:1
		};
		
		builder.push(Format(
			CodeFormat, paddingStr, paddingCount,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				INIT: IndentCode(This.InitCode, paddingStr)
			}
		));
	}

	This.ReadCode = function(editor)
	{
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) }
		];
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		m_Css = propSheet.GetValue("Css");

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		
		m_Preview.GetDom().innerHTML=This.GetName();
		
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function(builder)
	{
		var config = {
			_Css: m_Css,InitCode: This.InitCode,BorderWidth:1
		};
		return config;
	}
}

function PasswordPH(config)
{
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize
	};

	this.GetType = function() { return "PasswordPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	var CodeHtmlFormat = HtmlFormat.Password;

	var CodeFormat = ClearHtmlTag(CodeHtmlFormat);

	This.InitCode = IsNull(config.InitCode, "");

	var m_Css = IsNull(config._Css, "textbox");
	
	var m_Preview=new Controls.Control(
		{
			Left:0,Top:0,Width:This.GetWidth(),Height:This.GetHeight(),
			Css:"placeholder_preview_common",BorderWidth:1,
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.All,
			Text:This.GetName()
		}
	);
	
	m_Preview.GetDom().innerHTML=This.GetName();

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,BorderWidth:1
		};

		builder.push(
			Format(
				CodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0} 初始化", This.GetName()),
			This.InitCode
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingCount)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,BorderWidth:1
		};
		
		builder.push(Format(
			CodeFormat, paddingStr, paddingCount,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				INIT: IndentCode(This.InitCode, paddingStr)
			}
		));
	}

	This.ReadCode = function(editor)
	{
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) }
		];
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		m_Css = propSheet.GetValue("Css");

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		
		m_Preview.GetDom().innerHTML=This.GetName();
		
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function(builder)
	{
		var config = {
			_Css: m_Css,InitCode: This.InitCode,BorderWidth:1
		};
		return config;
	}
}

function TextAreaPH(config)
{
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize,
		SetName:this.SetName
	};

	this.GetType = function() { return "TextAreaPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	var CodeHtmlFormat = HtmlFormat.TextArea;

	var CodeFormat = ClearHtmlTag(CodeHtmlFormat);

	This.InitCode = IsNull(config.InitCode, "");

	var m_Css = IsNull(config._Css, "textarea");
	
	var m_Preview=new Controls.Control(
		{
			Left:0,Top:0,Width:This.GetWidth(),Height:This.GetHeight(),
			Css:"placeholder_preview_common",BorderWidth:1,
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.All,
			Text:This.GetName()
		}
	);
	
	This.SetName=function(name)
	{
		m_Preview.GetDom().innerHTML=name;
		Base.SetName(name);
	}
	This.SetName(This.GetName());

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,BorderWidth:1
		};

		builder.push(
			Format(
				CodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0} 初始化", This.GetName()),
			This.InitCode
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingCount)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,BorderWidth:1
		};
		
		builder.push(Format(
			CodeFormat, paddingStr, paddingCount,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				INIT: IndentCode(This.InitCode, paddingStr)
			}
		));
	}

	This.ReadCode = function(editor)
	{
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) }
		];
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		m_Css = propSheet.GetValue("Css");

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function(builder)
	{
		var config = {
			_Css: m_Css,InitCode: This.InitCode,BorderWidth:1
		};
		return config;
	}
}

function CheckBoxPH(config)
{
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize,
		SetText:this.SetText
	};

	this.GetType = function() { return "CheckBoxPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	var CodeHtmlFormat = HtmlFormat.CheckBox;

	var CodeFormat = ClearHtmlTag(CodeHtmlFormat);

	This.InitCode = IsNull(config.InitCode, "");

	var m_Css = IsNull(config._Css, "checkbox");
	
	var m_Preview=new Controls.Control(
		{
			Left:0,Top:0,Width:This.GetWidth(),Height:20,
			Css:"placeholder_preview_checkbox",BorderWidth:0,
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Top,
			Text:This.GetText()
		}
	);
	
	This.SetText=function(text)
	{
		m_Preview.GetDom().innerHTML=String.format("<div style='padding-left:16px;'>{0}</div>",text);
		Base.SetText(text);
	}
	m_Preview.GetDom().innerHTML=This.GetText();

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,BorderWidth:1
		};

		builder.push(
			Format(
				CodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0} 初始化", This.GetName()),
			This.InitCode
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingCount)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,BorderWidth:1
		};
		
		builder.push(Format(
			CodeFormat, paddingStr, paddingCount,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				INIT: IndentCode(This.InitCode, paddingStr)
			}
		));
	}

	This.ReadCode = function(editor)
	{
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) }
		];
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		m_Css = propSheet.GetValue("Css");

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function(builder)
	{
		var config = {
			_Css: m_Css,InitCode: This.InitCode,BorderWidth:1
		};
		return config;
	}
}

function RadioButtonPH(config)
{
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize,
		SetText:this.SetText
	};

	this.GetType = function() { return "RadioButtonPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	var CodeHtmlFormat = HtmlFormat.RadioButton;

	var CodeFormat = ClearHtmlTag(CodeHtmlFormat);

	This.InitCode = IsNull(config.InitCode, "");

	var m_Css = IsNull(config._Css, "radio");
	var m_Group=IsNull(config.Group,"");
	
	var m_Preview=new Controls.Control(
		{
			Left:0,Top:0,Width:This.GetWidth(),Height:20,
			Css:"placeholder_preview_radio",BorderWidth:0,
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Top,
			Text:This.GetText()
		}
	);
	
	This.SetText=function(text)
	{
		m_Preview.GetDom().innerHTML=String.format("<div style='padding-left:16px;'>{0}</div>",text);
		Base.SetText(text);
	}
	m_Preview.GetDom().innerHTML=This.GetText();

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,BorderWidth:1,Group:m_Group
		};

		builder.push(
			Format(
				CodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0} 初始化", This.GetName()),
			This.InitCode
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingCount)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,BorderWidth:1,Group:m_Group
		};
		
		builder.push(Format(
			CodeFormat, paddingStr, paddingCount,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				INIT: IndentCode(This.InitCode, paddingStr)
			}
		));
	}

	This.ReadCode = function(editor)
	{
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) }
		];
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "Group", Value: m_Group, CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		m_Css = propSheet.GetValue("Css");
		m_Group = propSheet.GetValue("Group");

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function(builder)
	{
		var config = {
			_Css: m_Css,InitCode: This.InitCode,BorderWidth:1,Group:m_Group
		};
		return config;
	}
}

function ListBoxPH(config)
{
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize,
		SetName:this.SetName
	};

	this.GetType = function() { return "ListBoxPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
 
	var CodeHtmlFormat = HtmlFormat.ListBox;

	var CodeFormat = ClearHtmlTag(CodeHtmlFormat);

	This.InitCode = IsNull(config.InitCode, "");

	var m_Css = IsNull(config._Css, "listbox");
	
	var m_Preview=new Controls.Control(
		{
			Left:0,Top:0,Width:This.GetWidth(),Height:This.GetHeight(),
			Css:"placeholder_preview_common",BorderWidth:1,
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.All,
			Text:This.GetName()
		}
	);
	
	This.SetName=function(name)
	{
		m_Preview.GetDom().innerHTML=name;
		Base.SetName(name);
	}
	m_Preview.GetDom().innerHTML=This.GetName();

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css
		};

		builder.push(
			Format(
				CodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0} 初始化", This.GetName()),
			This.InitCode
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingCount)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css
		};
		
		builder.push(Format(
			CodeFormat, paddingStr, paddingCount,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				INIT: IndentCode(This.InitCode, paddingStr)
			}
		));
	}

	This.ReadCode = function(editor)
	{
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) }
		];
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		m_Css = propSheet.GetValue("Css");

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function(builder)
	{
		var config = {
			_Css: m_Css,InitCode: This.InitCode
		};
		return config;
	}
}

function DropDownListPH(config)
{
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize,
		SetName: this.SetName
	};

	this.GetType = function() { return "DropDownListPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	var CodeHtmlFormat = HtmlFormat.DropDownList;

	var CodeFormat = ClearHtmlTag(CodeHtmlFormat);

	This.InitCode = IsNull(config.InitCode, "");

	var m_Css = IsNull(config._Css, "dropdownlist");
	
	var m_Preview=new Controls.Control(
		{
			Left:0,Top:0,Width:This.GetWidth(),Height:22,
			Css:"placeholder_preview_dropdownlist",BorderWidth:1,
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Top,
			Text:This.GetName()
		}
	);
	
	This.SetName=function(name)
	{
		m_Preview.GetDom().innerHTML=String.format("<div style='padding-top:4px; float:left;'>{0}</div><div class='dropdown_btn'></div>",This.GetName());
		Base.SetName(name);
	}
	
	This.SetName(This.GetName());

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css
		};

		builder.push(
			Format(
				CodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0} 初始化", This.GetName()),
			This.InitCode
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingCount)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css
		};
		
		builder.push(Format(
			CodeFormat, paddingStr, paddingCount,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				INIT: IndentCode(This.InitCode, paddingStr)
			}
		));
	}

	This.ReadCode = function(editor)
	{
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) }
		];
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		m_Css = propSheet.GetValue("Css");

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function(builder)
	{
		var config = {
			_Css: m_Css,InitCode: This.InitCode
		};
		return config;
	}
}

function ListViewPH(config)
{
	function TabsSettingForm()
	{
		var This = this;

		var config = {
			Left: 0, Top: 0, Width: 414, Height: 332,
			Parent: null,
			Css: "window", BorderWidth: 6,
			HasMinButton: false, HasMaxButton: false,Resizable:false,
			Title: {
				InnerHTML: "Tab 设置"
			}
		};

		Window.call(this, config);

		var Base = {
			GetType: this.GetType,
			is: this.is
		};

		this.GetType = function() { return "SimpleTabControlPH.TabsSettingForm"; }
		this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
       
        var m_ListTabs_Config={"Left":8,"Top":11,"Width":384,"Height":250,"AnchorStyle":Controls.AnchorStyle.All,"Parent":This,"Text":"","Css":"listview","BorderWidth":1,ListMode:{HeaderHeight:28,RowHeight:24}};
        
        m_ListTabs_Config.Columns=[
			{Name:"name",Text:"名称",Width:100,Css:"td_header_default"},
			{Name:"text",Text:"标题",Width:100,Css:"td_header_default"},
			{Name:"width",Text:"宽度",Width:70,Css:"td_header_default"},
			{Name:"css",Text:"Css",Width:100,Css:"td_header_default"},
			{Name:"operation",Text:"&nbsp;",Width:100,Css:"td_header_default"}        
		];
        
        function m_ListTabs_ListItem(name,text,width,css)
        {
            var This=this;
            
            This.GetName=function()
            {
				return m_ListTabs.GetCell(indexOf(This),0).firstChild.value;
            }
            
            This.GetTextValue=function()
            {
				return m_ListTabs.GetCell(indexOf(This),1).firstChild.value;
            }
            
            This.GetWidth=function()
            {
				return parseInt(m_ListTabs.GetCell(indexOf(This),2).firstChild.value);
            }
            
            This.GetCss=function()
            {
				return m_ListTabs.GetCell(indexOf(This),3).firstChild.value;
            }
            
            This.ReadValue=function()
            {
				name=This.GetName();
				text=This.GetTextValue();
				width=This.GetWidth();
				css=This.GetCss();
            }
              
            this.GetText=function(columnName)
            {
				switch(columnName)
				{
				case "name":
					{
						return String.format("<input type='text' value='{0}' style='margin-left:6px; width:80px; border:solid 1px #D0D0D0;'/>",name);
					}
				case "width":
					{
						return String.format("<input type='text' value='{0}' style='margin-left:6px; width:50px; border:solid 1px #D0D0D0;'/>",width);
					}
				case "text":
					{
						return String.format("<input type='text' value='{0}' style='margin-left:6px; width:80px; border:solid 1px #D0D0D0;'/>",text);
					}
				case "css":
					{
						return String.format("<input type='text' value='{0}' style='margin-left:6px; width:80px; border:solid 1px #D0D0D0;'/>",css);
					}
				case "operation":
					{
						return String.format("<div class='tab_set_operation' style='margin-left:6px; margin-top:3px;'>删除</div><div class='tab_set_operation' style='margin-left:6px; margin-top:3px;'>上移</div><div class='tab_set_operation' style='margin-left:6px; margin-top:3px;'>下移</div>");
					}
				default:
					{
						return "";
					}
				}
            }
        }
        
        var m_ListTabs = new Controls.ListView(m_ListTabs_Config);
        
        var m_BtnAdd = new Controls.Button({"Left":258,"Top":267,"Width":64,"Height":26,"AnchorStyle":Controls.AnchorStyle.Right|Controls.AnchorStyle.Bottom,"Parent":This,"Text":"添加","Css":"button"});
        
        m_BtnAdd.OnClick.Attach(
            function(btn)
            {
				appendItem(new m_ListTabs_ListItem("newcol","新增列",100,"td_header_default"));
            }
        );
        
        This.DialogResult="Cancel";
        
        var m_BtnOK = new Controls.Button({"Left":328,"Top":267,"Width":64,"Height":26,"AnchorStyle":Controls.AnchorStyle.Right|Controls.AnchorStyle.Bottom,"Parent":This,"Text":"确定","Css":"button_default"});
            
        m_BtnOK.OnClick.Attach(
            function(btn)
            {
				This.DialogResult="OK";
				This.Close();
            }
        );
        
        This.Resize(520,400);
        
        function indexOf(item)
        {
			var items=m_ListTabs.GetAllItems();
			for(var i=0;i<items.length;i++)
			{
				if(items[i]==item) return i;
			}
			return -1;
        }
        
        function appendItem(item)
        {
			m_ListTabs.AppendItem(item);
			
			(function(index){
			
				var cell4=m_ListTabs.GetCell(index,4);
				
				cell4.childNodes[0].onclick=function()
				{
					removeItem(index);
				}
				
				cell4.childNodes[1].onclick=function()
				{
					if(index>0) exchangeItem(index-1,index);
				}
				
				cell4.childNodes[2].onclick=function()
				{
					var items=m_ListTabs.GetAllItems();
					if(index<items.length-1) exchangeItem(index+1,index);
				}
				
			})(m_ListTabs.GetAllItems().length-1);
        }
        
        function removeItem(index)
        {
			var items=m_ListTabs.GetAllItems();
			for(var i in items) items[i].ReadValue();
			items.splice(index,1);
			m_ListTabs.Clear();
			for(var i in items) appendItem(items[i]);
        }
        
        function exchangeItem(index1,index2)
        {
			var items=m_ListTabs.GetAllItems();
			for(var i in items) items[i].ReadValue();
			var temp=items[index1];
			items[index1]=items[index2];
			items[index2]=temp;
			m_ListTabs.Clear();
			for(var i in items) appendItem(items[i]);
        }
        
        This.GetAllItems=function()
        {
			return m_ListTabs.GetAllItems();
        }
        
        for(var i in m_Columns)
        {
			appendItem(new m_ListTabs_ListItem(m_Columns[i].Name,m_Columns[i].Text,m_Columns[i].Width,m_Columns[i].Css));
        }
	}
	
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize
	};

	this.GetType = function() { return "ListViewPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
	
	var DefaultCode={
		ListItem_GetText:'',
		ListItem_Member:"",
		InitCode:''
	};
	
	var CodeHtmlFormat = HtmlFormat.ListView;
	var CodeFormat = ClearHtmlTag(CodeHtmlFormat);

	This.InitCode = IsNull(config.InitCode, String.format(DefaultCode.InitCode,This.GetName()));
	This.ListItem_Member=IsNull(config.ListItem_Member,String.format(DefaultCode.ListItem_Member));
	This.ListItem_GetText=IsNull(config.ListItem_GetText,String.format(DefaultCode.ListItem_GetText));

	var m_Css = IsNull(config._Css, "listview");
	var m_BorderWidth=IsNull(config._BorderWidth,1);
	var m_Columns=IsNull(
		config._Columns,
		[
			{Name:"column1",Text:"示例列1",Width:100,Css:"td_header_default"},
			{Name:"column2",Text:"示例列2",Width:100,Css:"td_header_default"}
		]
	);
	
	var m_Preview=new Controls.ListView(
		{
			Left:0,Top:0,Width:This.GetWidth(),Height:This.GetHeight(),
			Css:"listview",BorderWidth:1,
			Parent:This,
			Columns:m_Columns,
			AnchorStyle:Controls.AnchorStyle.All,
			ListMode:{
				HeaderHeight:28,
				RowHeight:24
			}
		}
	);

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,BorderWidth:m_BorderWidth,
			ListMode:{
				HeaderHeight:28,
				RowHeight:24
			}
		};

		builder.push(
			Format(
				CodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig), COLUMNS:System.RenderJson(m_Columns)}
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0} 初始化", This.GetName()),
			This.InitCode
		);
		editor.AddEditor(
			String.format("{0}.ListItem.Member", This.GetFullName()),
			String.format("列表项类成员", This.GetName()),
			This.ListItem_Member
		);
		editor.AddEditor(
			String.format("{0}.ListItem.GetText", This.GetFullName()),
			String.format("列表项类GetText方法", This.GetName()),
			This.ListItem_GetText
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingCount)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,BorderWidth:m_BorderWidth,
			ListMode:{
				HeaderHeight:28,
				RowHeight:24
			}
		};
		builder.push(Format(
			CodeFormat, paddingStr, paddingCount,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				INIT: IndentCode(This.InitCode, paddingStr),
				LIST_MEMBER:this.ListItem_Member,
				LIST_GETTEXT:this.ListItem_GetText,
				COLUMNS:System.RenderJson(m_Columns)
			}
		));
	}

	This.ReadCode = function(editor)
	{
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
		This.ListItem_GetText = editor.Read(String.format("{0}.ListItem.GetText", This.GetFullName()));
		This.ListItem_Member = editor.Read(String.format("{0}.ListItem.Member", This.GetFullName()));
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) },
			{ Text: "列表项类成员", Name: "ListItem.Member", ID: String.format("{0}.ListItem.Member", This.GetFullName()) },
			{ Text: "列表项类GetText方法", Name: "ListItem.GetText", ID: String.format("{0}.ListItem.GetText", This.GetFullName()) }
		];
	}
	
	function OnSet()
	{
		var form = new TabsSettingForm();
		form.ShowDialog(
			This.GetTopContainer(), 'center', 0, 0,
			function()
			{
				if(form.DialogResult=="OK")
				{
					m_Columns=[];
					var items=form.GetAllItems();
					for(var i=0;i<items.length;i++)
					{
						var item=items[i];
						m_Columns.push({Name:item.GetName(),Text:item.GetTextValue(),Width:item.GetWidth(),Css:item.GetCss()});
					}
					m_Preview.Reset(m_Columns);
				}
			}
		);
	}

	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "Columns", Value: null, CtrlType: "...", OnSet:OnSet },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "BorderWidth", Value: m_BorderWidth, CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		m_Css = propSheet.GetValue("Css");
		
		m_BorderWidth = parseInt(propSheet.GetValue("BorderWidth"));

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function(builder)
	{
		var config = {
			_Css: m_Css,
			_BorderWidth:m_BorderWidth,
			_Columns:m_Columns,
			InitCode: This.InitCode,
			ListItem_Member:This.ListItem_Member,
			ListItem_GetText:This.ListItem_GetText
		};
		return config;
	}
}

function TreeViewPH(config)
{
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize,
		SetName:this.SetName
	};

	this.GetType = function() { return "TreeViewPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
	
	var CodeHtmlFormat = HtmlFormat.TreeView;

	var CodeFormat = ClearHtmlTag(CodeHtmlFormat);

	This.OnClickCode = IsNull(config.OnClickCode, "");
	This.InitCode = IsNull(config.InitCode, String.format("{0}.Refresh(function(){});",This.GetName()));
	This.DSMemberCode=IsNull(config.DSMemberCode,"");
	This.DSGetSubNodesCode=IsNull(config.DSGetSubNodesCode,"callback([]);");

	var m_Css = IsNull(config._Css, "treeview");
	var m_BorderWidth=IsNull(config._BorderWidth,1);
	
	var m_Preview=new Controls.Control(
		{
			Left:0,Top:0,Width:This.GetWidth(),Height:This.GetHeight(),
			Css:"placeholder_preview_common",BorderWidth:1,
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.All,
			Text:This.GetName()
		}
	);
	
	This.SetName=function(name)
	{
		m_Preview.GetDom().innerHTML=name;
		Base.SetName(name);
	}
	m_Preview.GetDom().innerHTML=This.GetName();

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,BorderWidth:m_BorderWidth,
			DataSource:new VarName(String.format("new {0}_DS()",This.GetName()))
		};

		builder.push(
			Format(
				CodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0} 初始化", This.GetName()),
			This.InitCode
		);
		editor.AddEditor(
			String.format("{0}.OnClick", This.GetFullName()),
			String.format("{0} Click事件", This.GetName()),
			This.OnClickCode
		);
		editor.AddEditor(
			String.format("{0}.DataSource.Member", This.GetFullName()),
			String.format("{0} 数据源成员变量和方法", This.GetName()),
			This.DSMemberCode
		);
		editor.AddEditor(
			String.format("{0}.DataSource.GetSubNodes", This.GetFullName()),
			String.format("{0} GetSubNodes 方法", This.GetName()),
			This.DSGetSubNodesCode
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingCount)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,BorderWidth:m_BorderWidth,
			DataSource:new VarName(String.format("new {0}_DS()",This.GetName()))
		};
		builder.push(Format(
			CodeFormat, paddingStr, paddingCount,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				ONCLICK: IndentCode(This.OnClickCode, paddingStr + TAB + TAB), 
				INIT: IndentCode(This.InitCode, paddingStr),
				DSMEMBER:IndentCode(This.DSMemberCode,paddingStr + TAB),
				GETSUBNODES:IndentCode(This.DSGetSubNodesCode,paddingStr + TAB + TAB)
			}
		));
	}

	This.ReadCode = function(editor)
	{
		This.OnClickCode = editor.Read(String.format("{0}.OnClick", This.GetFullName()));
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
		This.DSMemberCode = editor.Read(String.format("{0}.DataSource.Member", This.GetFullName()));
		This.DSGetSubNodesCode = editor.Read(String.format("{0}.DataSource.GetSubNodes", This.GetFullName()));
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) },
			{ Text: "OnClick 事件", Name: "OnClick", ID: String.format("{0}.OnClick", This.GetFullName()) },
			{ Text: "TreeView数据源成员变量和方法", Name: "DataSource.Member", ID: String.format("{0}.DataSource.Member", This.GetFullName()) },
			{ Text: "GetSubNodes 方法", Name: "DataSource.GetSubNodes", ID: String.format("{0}.DataSource.GetSubNodes", This.GetFullName()) }
		];
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "BorderWidth", Value: m_BorderWidth, CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		m_Css = propSheet.GetValue("Css");
		
		m_BorderWidth = parseInt(propSheet.GetValue("BorderWidth"));

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function(builder)
	{
		var config = {
			_Css: m_Css,OnClickCode: This.OnClickCode, InitCode: This.InitCode,DSMemberCode:This.DSMemberCode,DSGetSubNodesCode:This.DSGetSubNodesCode,_BorderWidth:m_BorderWidth
		};
		return config;
	}
}

function FileBrowserPH(config)
{
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize,
		SetName:this.SetName
	};

	this.GetType = function() { return "FileBrowserPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
	
	var CodeHtmlFormat = HtmlFormat.FileBrowser;

	var CodeFormat = ClearHtmlTag(CodeHtmlFormat);
	
	var DefaultCode={
		InitCode:
			'{0}.Expand(\r\n'+
			'    function()\r\n'+
			'    {{\r\n'+
			'        {0}.SetCurrentPath(System.GetFullPath("Home"));\r\n'+
			'    },\r\n'+
			'    System.GetFullPath("Home")\r\n'+
			');\r\n'
	};

	This.InitCode = IsNull(config.InitCode, String.format(DefaultCode.InitCode,This.GetName()));
	This.OnBeginRequestCode=IsNull(config.OnBeginRequestCode,String.format("{0}.GetTopContainer().Waiting();",This.GetName()));
	This.OnEndRequestCode=IsNull(config.OnEndRequestCode,String.format("{0}.GetTopContainer().Completed();",This.GetName()));
	This.CustomConfigCode = IsNull(config.CustomConfig, "");

	var m_BorderWidth=IsNull(config._BorderWidth,0);
	
	var m_Preview=new Controls.Control(
		{
			Left:0,Top:0,Width:This.GetWidth(),Height:This.GetHeight(),
			Css:"placeholder_preview_common",BorderWidth:1,
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.All,
			Text:This.GetName()
		}
	);
	
	This.SetName=function(name)
	{
		m_Preview.GetDom().innerHTML=name;
		Base.SetName(name);
	}
	m_Preview.GetDom().innerHTML=This.GetName();

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			BorderWidth:m_BorderWidth
		};

		builder.push(
			Format(
				CodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0} 初始化", This.GetName()),
			This.InitCode
		);
		editor.AddEditor(
			String.format("{0}.CustomConfig", This.GetFullName()),
			String.format("{0} 配置", This.GetName()),
			This.CustomConfigCode
		);
		editor.AddEditor(
			String.format("{0}.OnBeginRequest", This.GetFullName()),
			String.format("{0} OnBeginRequest", This.GetName()),
			This.OnBeginRequestCode
		);
		editor.AddEditor(
			String.format("{0}.OnEndRequest", This.GetFullName()),
			String.format("{0} OnEndRequest", This.GetName()),
			This.OnEndRequestCode
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingCount)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			BorderWidth:m_BorderWidth
		};
		builder.push(Format(
			CodeFormat, paddingStr, paddingCount,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				INIT: IndentCode(This.InitCode, paddingStr),
				BEGINREQUEST:IndentCode(This.OnBeginRequestCode, paddingStr + TAB),
				ENDREQUEST:IndentCode(This.OnEndRequestCode, paddingStr + TAB),
				CUSTOMCONFIG:IndentCode(This.CustomConfigCode, paddingStr)
			}
		));
	}

	This.ReadCode = function(editor)
	{
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
		This.CustomConfigCode = editor.Read(String.format("{0}.CustomConfig", This.GetFullName()));
		This.OnBeginRequestCode = editor.Read(String.format("{0}.OnBeginRequest", This.GetFullName()));
		This.OnEndRequestCode = editor.Read(String.format("{0}.OnEndRequest", This.GetFullName()));
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) },
			{ Text: "配置", Name: "Init", ID: String.format("{0}.CustomConfig", This.GetFullName()) },
			{ Text: "OnBeginRequest", Name: "OnBeginRequest", ID: String.format("{0}.OnBeginRequest", This.GetFullName()) },
			{ Text: "OnEndRequest", Name: "OnEndRequest", ID: String.format("{0}.OnEndRequest", This.GetFullName()) }
		];
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "BorderWidth", Value: m_BorderWidth, CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		
		m_BorderWidth = parseInt(propSheet.GetValue("BorderWidth"));

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function(builder)
	{
		var config = {
			OnClickCode: This.OnClickCode, InitCode: This.InitCode,
			CustomConfig:This.CustomConfigCode,
			OnBeginRequestCode:This.OnBeginRequestCode,OnEndRequestCode:This.OnEndRequestCode,
			_BorderWidth:m_BorderWidth
		};
		return config;
	}
}

function FolderBrowserPH(config)
{
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize,
		SetName:this.SetName
	};

	this.GetType = function() { return "FolderBrowserPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
	
	var DefaultCode={
		InitCode:
			'{0}.Select(\r\n'+
			'    function()\r\n'+
			'    {{\r\n'+
			'        {0}.Expand(\r\n'+
			'            function()\r\n'+
			'            {{\r\n'+
			'            },\r\n'+
			'            System.GetFullPath("Home")\r\n'+
			'        );\r\n'+
			'    },\r\n'+
			'    System.GetFullPath("Home")\r\n'+
			');\r\n'
	}
	
	var CodeHtmlFormat = HtmlFormat.FolderBrowser;

	var CodeFormat = ClearHtmlTag(CodeHtmlFormat);

	This.OnClickCode = IsNull(config.OnClickCode, "");
	This.InitCode = IsNull(config.InitCode, String.format(DefaultCode.InitCode,This.GetName()));
	This.OnBeginRequestCode=IsNull(config.OnBeginRequestCode,String.format("{0}.GetTopContainer().Waiting();",This.GetName()));
	This.OnEndRequestCode=IsNull(config.OnEndRequestCode,String.format("{0}.GetTopContainer().Completed();",This.GetName()));

	var m_BorderWidth=IsNull(config._BorderWidth,1);
	
	var m_Preview=new Controls.Control(
		{
			Left:0,Top:0,Width:This.GetWidth(),Height:This.GetHeight(),
			Css:"placeholder_preview_common",BorderWidth:1,
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.All,
			Text:This.GetName()
		}
	);
	
	This.SetName=function(name)
	{
		m_Preview.GetDom().innerHTML=name;
		Base.SetName(name);
	}
	m_Preview.GetDom().innerHTML=This.GetName();

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			BorderWidth:m_BorderWidth
		};

		builder.push(
			Format(
				CodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0} 初始化", This.GetName()),
			This.InitCode
		);
		editor.AddEditor(
			String.format("{0}.OnClick", This.GetFullName()),
			String.format("{0} Click事件", This.GetName()),
			This.OnClickCode
		);
		editor.AddEditor(
			String.format("{0}.OnBeginRequest", This.GetFullName()),
			String.format("{0} OnBeginRequest", This.GetName()),
			This.OnBeginRequestCode
		);
		editor.AddEditor(
			String.format("{0}.OnEndRequest", This.GetFullName()),
			String.format("{0} OnEndRequest", This.GetName()),
			This.OnEndRequestCode
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingCount)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			BorderWidth:m_BorderWidth
		};
		builder.push(Format(
			CodeFormat, paddingStr, paddingCount,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				ONCLICK: IndentCode(This.OnClickCode, paddingStr + TAB + TAB), 
				INIT: IndentCode(This.InitCode, paddingStr),
				BEGINREQUEST:IndentCode(This.OnBeginRequestCode, paddingStr + TAB),
				ENDREQUEST:IndentCode(This.OnEndRequestCode, paddingStr + TAB)
			}
		));
	}

	This.ReadCode = function(editor)
	{
		This.OnClickCode = editor.Read(String.format("{0}.OnClick", This.GetFullName()));
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
		This.OnBeginRequestCode = editor.Read(String.format("{0}.OnBeginRequest", This.GetFullName()));
		This.OnEndRequestCode = editor.Read(String.format("{0}.OnEndRequest", This.GetFullName()));
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) },
			{ Text: "OnClick 事件", Name: "OnClick", ID: String.format("{0}.OnClick", This.GetFullName()) },
			{ Text: "OnBeginRequest", Name: "OnBeginRequest", ID: String.format("{0}.OnBeginRequest", This.GetFullName()) },
			{ Text: "OnEndRequest", Name: "OnEndRequest", ID: String.format("{0}.OnEndRequest", This.GetFullName()) }
		];
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "BorderWidth", Value: m_BorderWidth, CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		
		m_BorderWidth = parseInt(propSheet.GetValue("BorderWidth"));

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function(builder)
	{
		var config = {
			OnClickCode: This.OnClickCode, InitCode: This.InitCode,
			OnBeginRequestCode:This.OnBeginRequestCode,OnEndRequestCode:This.OnEndRequestCode,
			_BorderWidth:m_BorderWidth
		};
		return config;
	}
}


function ImageBrowserPH(config)
{
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize,
		SetName:this.SetName
	};

	this.GetType = function() { return "ImageBrowserPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
	
	var DefaultCode={
		InitCode:
			'{0}.Select(\r\n'+
			'    function()\r\n'+
			'    {{\r\n'+
			'        {0}.Expand(\r\n'+
			'            function()\r\n'+
			'            {{\r\n'+
			'            },\r\n'+
			'            System.GetFullPath("Home")\r\n'+
			'        );\r\n'+
			'    },\r\n'+
			'    System.GetFullPath("Home")\r\n'+
			');\r\n'
	}
	
	var CodeHtmlFormat = HtmlFormat.ImageBrowser;

	var CodeFormat = ClearHtmlTag(CodeHtmlFormat);

	This.OnClickCode = IsNull(config.OnClickCode, "");
	This.InitCode = IsNull(config.InitCode, String.format(DefaultCode.InitCode,This.GetName()));
	This.OnBeginRequestCode=IsNull(config.OnBeginRequestCode,String.format("{0}.GetTopContainer().Waiting();",This.GetName()));
	This.OnEndRequestCode=IsNull(config.OnEndRequestCode,String.format("{0}.GetTopContainer().Completed();",This.GetName()));

	var m_BorderWidth=IsNull(config._BorderWidth,0);
	
	var m_Preview=new Controls.Control(
		{
			Left:0,Top:0,Width:This.GetWidth(),Height:This.GetHeight(),
			Css:"placeholder_preview_common",BorderWidth:1,
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.All,
			Text:This.GetName()
		}
	);
	
	This.SetName=function(name)
	{
		m_Preview.GetDom().innerHTML=name;
		Base.SetName(name);
	}
	m_Preview.GetDom().innerHTML=This.GetName();

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			BorderWidth:m_BorderWidth
		};

		builder.push(
			Format(
				CodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0} 初始化", This.GetName()),
			This.InitCode
		);
		editor.AddEditor(
			String.format("{0}.OnClick", This.GetFullName()),
			String.format("{0} Click事件", This.GetName()),
			This.OnClickCode
		);
		editor.AddEditor(
			String.format("{0}.OnBeginRequest", This.GetFullName()),
			String.format("{0} OnBeginRequest", This.GetName()),
			This.OnBeginRequestCode
		);
		editor.AddEditor(
			String.format("{0}.OnEndRequest", This.GetFullName()),
			String.format("{0} OnEndRequest", This.GetName()),
			This.OnEndRequestCode
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingCount)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			BorderWidth:m_BorderWidth
		};
		builder.push(Format(
			CodeFormat, paddingStr, paddingCount,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				ONCLICK: IndentCode(This.OnClickCode, paddingStr + TAB + TAB), 
				INIT: IndentCode(This.InitCode, paddingStr),
				BEGINREQUEST:IndentCode(This.OnBeginRequestCode, paddingStr + TAB),
				ENDREQUEST:IndentCode(This.OnEndRequestCode, paddingStr + TAB)
			}
		));
	}

	This.ReadCode = function(editor)
	{
		This.OnClickCode = editor.Read(String.format("{0}.OnClick", This.GetFullName()));
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
		This.OnBeginRequestCode = editor.Read(String.format("{0}.OnBeginRequest", This.GetFullName()));
		This.OnEndRequestCode = editor.Read(String.format("{0}.OnEndRequest", This.GetFullName()));
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) },
			{ Text: "OnClick 事件", Name: "OnClick", ID: String.format("{0}.OnClick", This.GetFullName()) },
			{ Text: "OnBeginRequest", Name: "OnBeginRequest", ID: String.format("{0}.OnBeginRequest", This.GetFullName()) },
			{ Text: "OnEndRequest", Name: "OnEndRequest", ID: String.format("{0}.OnEndRequest", This.GetFullName()) }
		];
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "BorderWidth", Value: m_BorderWidth, CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		
		m_BorderWidth = parseInt(propSheet.GetValue("BorderWidth"));

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function(builder)
	{
		var config = {
			OnClickCode: This.OnClickCode, InitCode: This.InitCode,
			OnBeginRequestCode:This.OnBeginRequestCode,OnEndRequestCode:This.OnEndRequestCode,
			_BorderWidth:m_BorderWidth
		};
		return config;
	}
}

function RichEditorPH(config)
{
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize,
		SetName:this.SetName
	};

	this.GetType = function() { return "RichEditorPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	var CodeHtmlFormat = HtmlFormat.RichEditor;

	var CodeFormat = ClearHtmlTag(CodeHtmlFormat);

	This.InitCode = IsNull(config.InitCode, "");

	var m_Css = IsNull(config._Css, "richEditor");
	var m_BorderWidth=IsNull(config._BorderWidth,1);
	
	var m_Preview=new Controls.Control(
		{
			Left:0,Top:0,Width:This.GetWidth(),Height:This.GetHeight(),
			Css:"placeholder_preview_common",BorderWidth:1,
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.All,
			Text:This.GetName()
		}
	);
	
	This.SetName=function(name)
	{
		m_Preview.GetDom().innerHTML=name;
		Base.SetName(name);
	}
	m_Preview.GetDom().innerHTML=This.GetName();

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,BorderWidth:m_BorderWidth
		};

		builder.push(
			Format(
				CodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0} 初始化", This.GetName()),
			This.InitCode
		);
	}

	This.RenderCode = function(builder, paddingStr, paddingCount)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,BorderWidth:m_BorderWidth
		};
		
		builder.push(Format(
			CodeFormat, paddingStr, paddingCount,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				INIT: IndentCode(This.InitCode, paddingStr)
			}
		));
	}

	This.ReadCode = function(editor)
	{
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) }
		];
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "BorderWidth", Value: m_BorderWidth, CtrlType: "text" },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		m_Css = propSheet.GetValue("Css");
		m_BorderWidth=parseInt(propSheet.GetValue("BorderWidth"));
		
		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function(builder)
	{
		var config = {
			_Css: m_Css,_BorderWidth:m_BorderWidth,
			InitCode: This.InitCode
		};
		return config;
	}
}

function SimplePlaceHolder(config)
{
	var This = this;

	config.BorderWidth = 0;
	PlaceHolderBase.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize
	};

	this.GetType = function() { return "SimplePlaceHolder"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
	
	this.HasSubControls = true;
	
	This.GetCustomConfig = function()
	{
		var controls = [];
		This.ForeachPH(
			function(ctrl)
			{
				controls.push(ctrl.GetSaveData());
			}
		);
		
		var config = {
			Controls:controls
		};

		return config;
	}
	
	if(config.Controls!=undefined)
	{
		for (var i in config.Controls)
		{
			var sub = CreatePH(config.Controls[i]);
			This.AddControl(sub);
		}
	}
}

function SimpleTabControlPH(config)
{
	function TabsSettingForm()
	{
		var This = this;

		var config = {
			Left: 0, Top: 0, Width: 414, Height: 332,
			Parent: null,
			Css: "window", BorderWidth: 6,
			HasMinButton: false, HasMaxButton: false,Resizable:false,
			Title: {
				InnerHTML: "Tab 设置"
			}
		};

		Window.call(this, config);

		var Base = {
			GetType: this.GetType,
			is: this.is
		};

		this.GetType = function() { return "SimpleTabControlPH.TabsSettingForm"; }
		this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
       
        var m_ListTabs_Config={"Left":8,"Top":11,"Width":384,"Height":250,"AnchorStyle":Controls.AnchorStyle.All,"Parent":This,"Text":"","Css":"listview","BorderWidth":1,ListMode:{HeaderHeight:28,RowHeight:30}};
        
        m_ListTabs_Config.Columns=[
			{Name:"name",Text:"名称",Width:150,Css:"td_header_default"},
			{Name:"width",Text:"宽度",Width:70,Css:"td_header_default"},
			{Name:"operation",Text:"&nbsp;",Width:100,Css:"td_header_default"}        
		];
        
        function m_ListTabs_ListItem(name,width,id)
        {
            var This=this;
            
            This.GetName=function()
            {
				return m_ListTabs.GetCell(indexOf(This),0).firstChild.value;
            }
            
            This.GetWidth=function()
            {
				return parseInt(m_ListTabs.GetCell(indexOf(This),1).firstChild.value);
            }
            
            This.GetID=function()
            {
				return id;
            }
            
            This.ReadValue=function()
            {
				name=This.GetName();
				width=This.GetWidth();
            }
              
            this.GetText=function(columnName)
            {
				switch(columnName)
				{
				case "name":
					{
						return String.format("<input type='text' value='{0}' style='margin-left:6px; width:130px; border:solid 1px #D0D0D0;'/>",name);
					}
				case "width":
					{
						return String.format("<input type='text' value='{0}' style='margin-left:6px; width:50px; border:solid 1px #D0D0D0;'/>",width);
					}
				case "operation":
					{
						return String.format("<div class='tab_set_operation' style='margin-left:6px; margin-top:3px;'>删除</div><div class='tab_set_operation' style='margin-left:6px; margin-top:3px;'>上移</div><div class='tab_set_operation' style='margin-left:6px; margin-top:3px;'>下移</div>");
					}
				default:
					{
						return "";
					}
				}
            }
        }
        
        var m_ListTabs = new Controls.ListView(m_ListTabs_Config);
        
        var m_BtnAdd = new Controls.Button({"Left":258,"Top":267,"Width":64,"Height":26,"AnchorStyle":Controls.AnchorStyle.Right|Controls.AnchorStyle.Bottom,"Parent":This,"Text":"添加","Css":"button"});
        
        m_BtnAdd.OnClick.Attach(
            function(btn)
            {
				appendItem(new m_ListTabs_ListItem("新标签",100,System.GenerateUniqueId()));
            }
        );
        
        This.DialogResult="Cancel";
        
        var m_BtnOK = new Controls.Button({"Left":328,"Top":267,"Width":64,"Height":26,"AnchorStyle":Controls.AnchorStyle.Right|Controls.AnchorStyle.Bottom,"Parent":This,"Text":"确定","Css":"button_default"});
            
        m_BtnOK.OnClick.Attach(
            function(btn)
            {
				This.DialogResult="OK";
				This.Close();
            }
        );
        
        This.Resize(380,270);
        
        function indexOf(item)
        {
			var items=m_ListTabs.GetAllItems();
			for(var i=0;i<items.length;i++)
			{
				if(items[i]==item) return i;
			}
			return -1;
        }
        
        function appendItem(item)
        {
			m_ListTabs.AppendItem(item);
			
			(function(index){
			
				var cell0=m_ListTabs.GetCell(index,0);
				var cell1=m_ListTabs.GetCell(index,1);
				var cell2=m_ListTabs.GetCell(index,2);
				
				cell2.childNodes[0].onclick=function()
				{
					removeItem(index);
				}
				
				cell2.childNodes[1].onclick=function()
				{
					if(index>0) exchangeItem(index-1,index);
				}
				
				cell2.childNodes[2].onclick=function()
				{
					var items=m_ListTabs.GetAllItems();
					if(index<items.length-1) exchangeItem(index+1,index);
				}
				
			})(m_ListTabs.GetAllItems().length-1);
        }
        
        function removeItem(index)
        {
			var items=m_ListTabs.GetAllItems();
			for(var i in items) items[i].ReadValue();
			items.splice(index,1);
			m_ListTabs.Clear();
			for(var i in items) appendItem(items[i]);
        }
        
        function exchangeItem(index1,index2)
        {
			var items=m_ListTabs.GetAllItems();
			for(var i in items) items[i].ReadValue();
			var temp=items[index1];
			items[index1]=items[index2];
			items[index2]=temp;
			m_ListTabs.Clear();
			for(var i in items) appendItem(items[i]);
        }
        
        This.GetAllItems=function()
        {
			return m_ListTabs.GetAllItems();
        }
        
        for(var i in m_Tabs)
        {
			appendItem(new m_ListTabs_ListItem(m_Tabs[i].Text,m_Tabs[i].Width,m_Tabs[i].ID));
        }
	}
	
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize
	};

	this.GetType = function() { return "SimpleTabControlPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	var m_DefaultTabs = [
		{ Text: "标签1", Width: 80, IsSelected: true, ID: System.GenerateUniqueId() },
		{ Text: "标签2", Width: 80, IsSelected: false, ID: System.GenerateUniqueId() }
	];
	
	var m_Tabs=[];
	var m_DesignPHBs=[];
	
	if(config.Tabs==undefined)
	{
		m_Tabs=m_DefaultTabs;

		var m_Tab = new Controls.SimpleTabControl(
			{
				Left: 0, Top: 0, Width: This.GetClientWidth(), Height: This.GetClientHeight(),
				AnchorStyle: Controls.AnchorStyle.All,
				BorderWidth: 1,
				Parent: This,
				Tabs: m_Tabs
			}
		);
		
		var panel0=new SimplePlaceHolder(
			{
				Name:"panel0",
				Left: 0, Top: 0, Width: m_Tab.GetPanel(0).GetClientWidth(), Height: m_Tab.GetPanel(0).GetClientHeight(),
				AnchorStyle: Controls.AnchorStyle.All,
				BorderWidth: 0,
				Parent: m_Tab.GetPanel(0)
			}
		);
		
		panel0.GetName=function()
		{
			return This.GetName()+".GetPanel(0)";
		}
		
		var panel1=new SimplePlaceHolder(
			{
				Name:"panel1",
				Left: 0, Top: 0, Width: m_Tab.GetPanel(1).GetClientWidth(), Height: m_Tab.GetPanel(1).GetClientHeight(),
				AnchorStyle: Controls.AnchorStyle.All,
				BorderWidth: 0,
				Parent: m_Tab.GetPanel(1)
			}
		);
	
		panel1.GetName=function()
		{
			return This.GetName()+".GetPanel(1)";
		}
		
		m_DesignPHBs.push(panel0);
		m_DesignPHBs.push(panel1);
	}
	else
	{
		m_Tabs=config.Tabs;

		var m_Tab = new Controls.SimpleTabControl(
			{
				Left: 0, Top: 0, Width: This.GetClientWidth(), Height: This.GetClientHeight(),
				AnchorStyle: Controls.AnchorStyle.All,
				BorderWidth: 1,
				Parent: This,
				Tabs: m_Tabs
			}
		);
	
		for(var i=0;i<m_Tabs.length;i++)
		{
			m_Tabs[i].ID=System.GenerateUniqueId();
			
			(function(index)
			{
				var panel=CreatePH(config.DesignPHBs[index]);
				
				m_Tab.GetPanel(i).AddControl(panel);
				
				panel.GetName=function()
				{
					return String.format("{0}.GetPanel({1})",This.GetName(),index);
				}
				
				m_DesignPHBs.push(panel);
				
			})(i);
		}
	}

	var ControlCodeHtmlFormat = HtmlFormat.SimpleTabControl;
	var ControlCodeFormat = ClearHtmlTag(ControlCodeHtmlFormat);

	This.OnSelectedTabCode = IsNull(config.OnSelectedTabCode, "");
	This.InitCode = IsNull(config.InitCode, "");
	var m_Css = IsNull(config._Css, "simple_tab");
	var m_BorderWidth=IsNull(config._Broderwidth,1);

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,
			Tabs: m_Tabs, BorderWidth: m_BorderWidth
		};

		builder.push(
			Format(
				ControlCodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);

		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderCodeHtml(builder, paddingStr, paddingEM);
				}
			}
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.OnSelectedTab", This.GetFullName()),
			String.format("{0} OnSelectedTab事件", This.GetName()),
			This.OnSelectedTabCode
		);
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0}初始化", This.GetName()),
			This.InitCode
		);

		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderEditor(editor);
				}
			}
		);
	}

	This.RenderCode = function(builder, paddingString, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,
			Tabs: m_Tabs, BorderWidth: m_BorderWidth
		};
		builder.push(Format(
			ControlCodeFormat, paddingString, paddingEM,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				INIT: IndentCode(This.InitCode, paddingString), ONRESIZED_EVENT: IndentCode(This.OnSelectedTabCode, paddingString + TAB + TAB)
			}
		));

		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderCode(builder, paddingString, paddingEM);
				}
			}
		);
	}

	This.ReadCode = function(editor)
	{
		This.OnSelectedTabCode = editor.Read(String.format("{0}.OnSelectedTab", This.GetFullName()));
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.ReadCode(editor);
				}
			}
		);
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) },
			{ Text: "OnSelectedTab 事件", Name: "OnSelectedTab", ID: String.format("{0}.OnSelectedTab", This.GetFullName()) }
		];
	}

	function OnSet()
	{
		var form = new TabsSettingForm();
		form.ShowDialog(
			This.GetTopContainer(), 'center', 0, 0,
			function()
			{
				if(form.DialogResult=="OK")
				{
					var phs={};
					for(var i=0;i<m_Tabs.length;i++)
					{
						var tab=m_Tabs[i];
						m_Tab.GetPanel(i).RemoveControl(m_DesignPHBs[i]);
						phs[tab.ID]=m_DesignPHBs[i];
					}
					
					m_Tabs=[];
					m_DesignPHBs=[];
					
					var items=form.GetAllItems();
					for(var i=0;i<items.length;i++)
					{
						var item=items[i];
						m_Tabs.push({Text:item.GetName(),Width:item.GetWidth(),ID:item.GetID(),IsSelected:i==0});
					}
					
					m_Tab.Reset(m_Tabs);
	
					for(var i=0;i<m_Tabs.length;i++)
					{
						var tab=m_Tabs[i];
						(function(index)
						{
							var panel=null;
							
							if(phs[tab.ID]!=undefined)
							{
								panel=phs[tab.ID];
								m_Tab.GetPanel(index).AddControl(panel);
							}
							else
							{
								panel = new SimplePlaceHolder(
									{
										Name: "panel1",
										Left: 0, Top: 0, Width: m_Tab.GetPanel(index).GetClientWidth(), Height: m_Tab.GetPanel(index).GetClientHeight(),
										AnchorStyle: Controls.AnchorStyle.All,
										BorderWidth: 0,
										Parent: m_Tab.GetPanel(index)
									}
								);
							}
							
							panel.GetName=function()
							{
								return String.format("{0}.GetPanel({1})",This.GetName(),index);
							}
							
							m_DesignPHBs.push(panel);
							
						})(i);
					}
					PH.GetTopPlaceHolder().OnChanged.Call(PH);
				}
			}
		);
	}

	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "BorderWidth", Value: m_BorderWidth, CtrlType: "text" },
			{ Name: "Tabs", Value: null, CtrlType: "...", OnSet:OnSet },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		m_Css = propSheet.GetValue("Css");
		m_BorderWidth =parseInt(propSheet.GetValue("BorderWidth"));

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function()
	{
		var phbs = [];
		for (var i = 0; i < m_DesignPHBs.length; i++)
		{
			phbs.push(m_DesignPHBs[i].GetSaveData());
		}
		
		var config = {
			_Css: m_Css, _BorderWidth:m_BorderWidth,
			OnSelectedTabCode: This.OnSelectedTabCode, InitCode: This.InitCode, Tabs: m_Tabs, DesignPHBs: phbs
		};

		return config;
	}
	
	This.ForeachPH=function(callback)
	{
		for(var i =0;i<m_DesignPHBs.length;i++)
		{
			m_DesignPHBs[i].Foreach(callback);
		}
	}
}

function ToolbarPH(config)
{
	function ItemsSettingForm()
	{
		var This = this;

		var config = {
			Left: 0, Top: 0, Width: 414, Height: 332,
			Parent: null,
			Css: "window", BorderWidth: 6,
			HasMinButton: false, HasMaxButton: false,Resizable:false,
			Title: {
				InnerHTML: "Tab 设置"
			}
		};

		Window.call(this, config);

		var Base = {
			GetType: this.GetType,
			is: this.is
		};

		this.GetType = function() { return "ToolbarPH.ItemsSettingForm"; }
		this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
       
        var m_ListTabs_Config={"Left":8,"Top":11,"Width":384,"Height":250,"AnchorStyle":Controls.AnchorStyle.All,"Parent":This,"Text":"","Css":"listview","BorderWidth":1,ListMode:{HeaderHeight:28,RowHeight:30}};
        
        m_ListTabs_Config.Columns=[
			{Name:"name",Text:"名称",Width:150,Css:"td_header_default"},
			{Name:"css",Text:"Css",Width:100,Css:"td_header_default"},
			{Name:"cmd",Text:"命令",Width:100,Css:"td_header_default"},
			{Name:"operation",Text:"&nbsp;",Width:100,Css:"td_header_default"}        
		];
        
        function m_ListTabs_ListItem(name,css,cmd)
        {
            var This=this;
            
            This.GetName=function()
            {
				return m_ListTabs.GetCell(indexOf(This),0).firstChild.value;
            }
            
            This.GetCss=function()
            {
				return m_ListTabs.GetCell(indexOf(This),1).firstChild.value;
            }
            
            This.GetCommand=function()
            {
				return m_ListTabs.GetCell(indexOf(This),2).firstChild.value;
            }
            
            This.ReadValue=function()
            {
				name=This.GetName();
				css=This.GetCss();
				cmd=This.GetCommand();
            }
              
            this.GetText=function(columnName)
            {
				switch(columnName)
				{
				case "name":
					{
						return String.format("<input type='text' value='{0}' style='margin-left:6px; width:130px; border:solid 1px #D0D0D0;'/>",name);
					}
				case "css":
					{
						return String.format("<input type='text' value='{0}' style='margin-left:6px; width:80px; border:solid 1px #D0D0D0;'/>",css);
					}
				case "cmd":
					{
						return String.format("<input type='text' value='{0}' style='margin-left:6px; width:80px; border:solid 1px #D0D0D0;'/>",cmd);
					}
				case "operation":
					{
						return String.format("<div class='tab_set_operation' style='margin-left:6px; margin-top:3px;'>删除</div><div class='tab_set_operation' style='margin-left:6px; margin-top:3px;'>上移</div><div class='tab_set_operation' style='margin-left:6px; margin-top:3px;'>下移</div>");
					}
				default:
					{
						return "";
					}
				}
            }
        }
        
        var m_ListTabs = new Controls.ListView(m_ListTabs_Config);
        
        var m_BtnAdd = new Controls.Button({"Left":258,"Top":267,"Width":64,"Height":26,"AnchorStyle":Controls.AnchorStyle.Right|Controls.AnchorStyle.Bottom,"Parent":This,"Text":"添加","Css":"button"});
        
        m_BtnAdd.OnClick.Attach(
            function(btn)
            {
				appendItem(new m_ListTabs_ListItem("Button","",""));
            }
        );
        
        This.DialogResult="Cancel";
        
        var m_BtnOK = new Controls.Button({"Left":328,"Top":267,"Width":64,"Height":26,"AnchorStyle":Controls.AnchorStyle.Right|Controls.AnchorStyle.Bottom,"Parent":This,"Text":"确定","Css":"button_default"});
            
        m_BtnOK.OnClick.Attach(
            function(btn)
            {
				This.DialogResult="OK";
				This.Close();
            }
        );
        
        This.Resize(500,400);
        
        function indexOf(item)
        {
			var items=m_ListTabs.GetAllItems();
			for(var i=0;i<items.length;i++)
			{
				if(items[i]==item) return i;
			}
			return -1;
        }
        
        function appendItem(item)
        {
			m_ListTabs.AppendItem(item);
			
			(function(index){
			
				var cell3=m_ListTabs.GetCell(index,3);
				
				cell3.childNodes[0].onclick=function()
				{
					removeItem(index);
				}
				
				cell3.childNodes[1].onclick=function()
				{
					if(index>0) exchangeItem(index-1,index);
				}
				
				cell3.childNodes[2].onclick=function()
				{
					var items=m_ListTabs.GetAllItems();
					if(index<items.length-1) exchangeItem(index+1,index);
				}
				
			})(m_ListTabs.GetAllItems().length-1);
        }
        
        function removeItem(index)
        {
			var items=m_ListTabs.GetAllItems();
			for(var i in items) items[i].ReadValue();
			items.splice(index,1);
			m_ListTabs.Clear();
			for(var i in items) appendItem(items[i]);
        }
        
        function exchangeItem(index1,index2)
        {
			var items=m_ListTabs.GetAllItems();
			for(var i in items) items[i].ReadValue();
			var temp=items[index1];
			items[index1]=items[index2];
			items[index2]=temp;
			m_ListTabs.Clear();
			for(var i in items) appendItem(items[i]);
        }
        
        This.GetAllItems=function()
        {
			return m_ListTabs.GetAllItems();
        }
        
        for(var i in m_Items)
        {
			appendItem(new m_ListTabs_ListItem(m_Items[i].Text,m_Items[i].Css,m_Items[i].Command));
        }
	}
	
	var This = this;
	var PH = this;

	PlaceHolder.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize,
		SetName:this.SetName
	};

	this.GetType = function() { return "ToolbarPH"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
	
	var ControlCodeHtmlFormat = HtmlFormat.Toolbar;

	var ControlCodeFormat = ClearHtmlTag(ControlCodeHtmlFormat);

	This.OnCommandCode = IsNull(config.OnCommandCode, "");
	This.InitCode = IsNull(config.InitCode, "");
	var m_Css = IsNull(config._Css, "toolbar");
	var m_Items=IsNull(config._Items,[{ Css: "", Text: "Button", Command: "Cmd" }]);
	
	var m_Preview=new Controls.Control(
		{
			Left:0,Top:0,Width:This.GetWidth(),Height:Controls.Toolbar.PredefineHeight,
			Css:"placeholder_preview_control",BorderWidth:1,
			Parent:This,
			AnchorStyle:Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Top,
			Text:This.GetName()
		}
	);
	
	This.SetName=function(name)
	{
		m_Preview.GetDom().innerHTML=name;
		Base.SetName(name);
	}
	m_Preview.GetDom().innerHTML=This.GetName();

	This.RenderCodeHtml = function(builder, paddingStr, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent:  new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,Items:m_Items
		};

		builder.push(
			Format(
				ControlCodeHtmlFormat,
				paddingStr, paddingEM,
				{ NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig) }
			)
		);

		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderCodeHtml(builder, paddingStr, paddingEM);
				}
			}
		);
	}

	This.RenderEditor = function(editor)
	{
		editor.AddEditor(
			String.format("{0}.OnCommand", This.GetFullName()),
			String.format("{0} OnCommand事件", This.GetName()),
			This.OnCommandCode
		);
		editor.AddEditor(
			String.format("{0}.Init", This.GetFullName()),
			String.format("{0}初始化", This.GetName()),
			This.InitCode
		);

		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderEditor(editor);
				}
			}
		);
	}

	This.RenderCode = function(builder, paddingString, paddingEM)
	{
		var fconfig = {
			Left: This.GetLeft(), Top: This.GetTop(), Width: This.GetWidth(), Height: This.GetHeight(),
			AnchorStyle: new VarName(GetAnchorStyleString(This.GetAnchorStyle())),
			Parent: new VarName(This.GetParentVarName()),
			Text: This.GetText(),
			Css: m_Css,Items:m_Items
		};
		builder.push(Format(
			ControlCodeFormat, paddingString, paddingEM,
			{
				NAME: This.GetName(), FULLNAME: This.GetFullName(), CONFIG: System.RenderJson(fconfig),
				INIT: IndentCode(This.InitCode, paddingString), 
				ONCOMMAND: IndentCode(This.OnCommandCode, paddingString + TAB + TAB)
			}
		));

		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.RenderCode(builder, paddingString, paddingEM);
				}
			}
		);
	}

	This.ReadCode = function(editor)
	{
		This.OnCommandCode = editor.Read(String.format("{0}.OnCommand", This.GetFullName()));
		This.InitCode = editor.Read(String.format("{0}.Init", This.GetFullName()));
		This.ForeachPH(
			function(ctrl)
			{
				if (ctrl.is != undefined && ctrl.is("PlaceHolder"))
				{
					ctrl.ReadCode(editor);
				}
			}
		);
	}

	This.GetAnchors = function()
	{
		return [
			{ Text: "初始化", Name: "Init", ID: String.format("{0}.Init", This.GetFullName()) },
			{ Text: "OnCommand 事件", Name: "OnCommand", ID: String.format("{0}.OnCommand", This.GetFullName()) }
		];
	}

	function OnSet()
	{
		var form = new ItemsSettingForm();
		form.ShowDialog(
			This.GetTopContainer(), 'center', 0, 0,
			function()
			{
				if(form.DialogResult=="OK")
				{
					m_Items=[];
					var items=form.GetAllItems();
					for(var i=0;i<items.length;i++)
					{
						var item=items[i];
						m_Items.push({Text:item.GetName(),Css:item.GetCss(),Command:item.GetCommand()});
					}
					PH.GetTopPlaceHolder().OnChanged.Call(PH);
				}
			}
		);
	}


	This.GetProperties = function()
	{
		var anchorStyle = PH.GetAnchorStyle();
		var properties = [
			{ Name: "Name", Value: PH.GetName(), CtrlType: "text" },
			{ Name: "Text", Value: PH.GetText(), CtrlType: "text" },
			{ Name: "Css", Value: m_Css, CtrlType: "text" },
			{ Name: "Items", Value: null, CtrlType: "...", OnSet:OnSet },
			{ Name: "Left", Value: PH.GetLeft(), CtrlType: "text" },
			{ Name: "Top", Value: PH.GetTop(), CtrlType: "text" },
			{ Name: "Width", Value: PH.GetWidth(), CtrlType: "text" },
			{ Name: "Height", Value: PH.GetHeight(), CtrlType: "text" },
			{ Name: "AnchorStyle.Left", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Left) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Right", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Right) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Top", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Top) != 0), CtrlType: "combobox", Options: ["True", "False"] },
			{ Name: "AnchorStyle.Bottom", Value: BoolToString((anchorStyle & Controls.AnchorStyle.Bottom) != 0), CtrlType: "combobox", Options: ["True", "False"] }
		];

		return properties;
	}

	This.ReadProperties = function(propSheet)
	{
		if(propSheet.GetRelPH()!=PH) return;
		
		PH.SetText(propSheet.GetValue("Text"));
		PH.SetName(propSheet.GetValue("Name"));
		m_Css = propSheet.GetValue("Css");

		PH.Move(parseInt(propSheet.GetValue("Left")), parseInt(propSheet.GetValue("Top")));
		PH.Resize(parseInt(propSheet.GetValue("Width")), parseInt(propSheet.GetValue("Height")));

		var as = 0;
		if (propSheet.GetValue("AnchorStyle.Left") == "True") as |= Controls.AnchorStyle.Left;
		if (propSheet.GetValue("AnchorStyle.Top") == "True") as |= Controls.AnchorStyle.Top;
		if (propSheet.GetValue("AnchorStyle.Right") == "True") as |= Controls.AnchorStyle.Right;
		if (propSheet.GetValue("AnchorStyle.Bottom") == "True") as |= Controls.AnchorStyle.Bottom;
		PH.SetAnchorStyle(as);
		PH.GetTopPlaceHolder().OnChanged.Call(PH);
	}

	This.GetDefaultEditId = function()
	{
		return This.GetFullName() + ".Init";
	}

	This.GetCustomConfig = function()
	{
		var controls = [];
		This.ForeachPH(
			function(ctrl)
			{
				controls.push(ctrl.GetSaveData());
			}
		);
		
		var config = {
			_Css: m_Css,OnCommandCode: This.OnCommandCode, InitCode: This.InitCode,
			Controls:controls,_Items:m_Items
		};

		return config;
	}
	
	if(config.Controls!=undefined)
	{
		for (var i in config.Controls)
		{
			var sub = CreatePH(config.Controls[i]);
			This.AddControl(sub);
		}
	}
}

function Designer(config)
{
	var This = this;
	var m_CodeBuilder = config.CodeBuilder;
	var m_LeftPanel = null, m_ControlEditor = null;
	var m_ObjectView = null, m_PropertySheet = null;

	Control.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize
	};

	this.GetType = function() { return "Designer"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	var m_VGuide = new Controls.GuideLine(This.GetClientHeight(), [6, 0, 6]);
	var m_HGuide = new Controls.GuideLine(This.GetClientWidth(), [6, 250, 6, 0, 6]);

	var m_MenuWindows = new Controls.Menu(
		{
			Items: [
				{ Text: "新建窗体", ID: "NewWindow" },
				{ Text: "新建自定义控件", ID: "NewCustonControl" }
			]
		}
	);

	m_MenuWindows.OnCommand.Attach(
		function(cmd)
		{
			if (cmd == "NewWindow")
			{
				var i = 1;

				while (m_CodeBuilder.GetForm("Form" + i) != null) i++;

				var newPH = new FormPH(
					{
						Left: 0, Top: 0, Width: 400, Height: 300,
						Parent: null,
						Css: "placeHolder",
						Text: "Form" + i, Name: "Form" + i
					}
				);

				m_CodeBuilder.FormPHs.push(newPH);

				This.RefreshObjectView();
				m_ObjectView.Expand(function() { }, "/root/forms");

			}
			else if (cmd == "NewCustonControl")
			{
				var i = 1;

				while (m_CodeBuilder.GetForm("CustomControl" + i) != null) i++;

				var newPH = new CustomControlDesignPH(
					{
						Left: 0, Top: 0, Width: 200, Height: 200,
						Parent: null,
						Css: "placeHolder",
						Text: "CustomControl" + i, Name: "CustomControl" + i
					}
				);

				m_CodeBuilder.FormPHs.push(newPH);
				m_ControlEditor.RefreshControlBox();

				This.RefreshObjectView();
				m_ObjectView.Expand(function() { }, "/root/forms");

			}
		}
	);

	var m_MenuControl = new Controls.Menu(
		{
			Items: [
				{ Text: "删除", ID: "Delete" }
			]
		}
	);

	m_MenuControl.OnCommand.Attach(
		function(cmd)
		{
			if (cmd == "Delete")
			{
				var node = m_ObjectView.GetSelectedNode();
				if (node == null) return;
				var tag = node.GetTag();
				if (tag.PlaceHolder.IsClass())
				{
					m_CodeBuilder.RemoveForm(node.GetTag().PlaceHolder);
					This.RefreshObjectView();
					This.Load(m_CodeBuilder.FormPHs[0]);
					m_ControlEditor.RefreshControlBox();
				}
				else
				{
					tag.PlaceHolder.Delete();
				}

			}
		}
	);

	m_ControlEditor = new ControlEditor(
		{
			Left: m_HGuide.Get(2), Top: m_VGuide.Get(0), Width: m_HGuide.GetWidth(3), Height: m_VGuide.GetWidth(1),
			Parent: This,
			Css: "rightPanel", BorderWidth: 1,
			AnchorStyle: Controls.AnchorStyle.All,
			CodeBuilder: m_CodeBuilder
		}
	);

	m_LeftPanel = new Control(
		{
			Left: m_HGuide.Get(0), Top: m_VGuide.Get(0), Width: m_HGuide.GetWidth(1), Height: m_VGuide.GetWidth(1),
			Parent: This,
			Css: "leftPanel", BorderWidth: 0,
			AnchorStyle: Controls.AnchorStyle.Left | Controls.AnchorStyle.Top | Controls.AnchorStyle.Bottom
		}
	);

	new Controls.VerticalSplit(
		{
			Left: m_HGuide.Get(1), Top: m_VGuide.Get(0), Width: m_HGuide.GetWidth(2), Height: m_VGuide.GetWidth(1),
			Parent: This,
			LeftControl: m_LeftPanel, RightControl: m_ControlEditor,
			AnchorStyle: Controls.AnchorStyle.Top | Controls.AnchorStyle.Bottom
		}
	);

	This.OnPHDblClick = new Delegate();

	This.RefreshObjectView = function()
	{
		m_ObjectView.Refresh(function() { });
	}

	This.RefreshControlBox=function()
	{
		m_ControlEditor.RefreshControlBox();
	}
	
	This.Load = function(ph)
	{
		m_ControlEditor.Load(ph);

		m_ControlEditor.GetRootPH().OnPHDblClick.Attach(PH_OnDblClick);
		m_ControlEditor.GetRootPH().OnChanged.Attach(PH_OnChanged);
		m_ControlEditor.GetRootPH().OnFocus.Attach(PHOnFocus);
		m_ControlEditor.GetRootPH().OnPropertyChanged.Attach(PHOnPropertyChanged);
		
		m_ObjectView.Select(function() { }, "/root/forms/" + ph.GetName());

		SetFocusPlaceHolder(m_ControlEditor.GetRootPH());
	}

	This.Clear = function()
	{
		m_ControlEditor.Clear();
		m_PropertySheet.Clear();
		m_ObjectView.Clear();
	}

	function CreateLeftPanle()
	{
		var m_VGuide = new Controls.GuideLine(m_LeftPanel.GetClientHeight(), [0, 6, 300]);
		var m_HGuide = new Controls.GuideLine(m_LeftPanel.GetClientWidth(), [0]);

		m_ObjectView = new Controls.TreeView(
			{
				Left: 0, Top: 0, Width: m_HGuide.GetWidth(0), Height: m_VGuide.GetWidth(0),
				Parent: m_LeftPanel,
				BorderWidth: 1,
				AnchorStyle: Controls.AnchorStyle.All,
				DataSource: {
					GetSubNodes: function(callback, item)
					{
						var tag = item == null ? null : item.GetTag();
						var nodes = [];
						if (item == null)
						{
							nodes.push(
								{
									Name: "root",
									Text: "工程",
									Tag: {
										Type: "Root"
									},
									ImageCss: "Image16_Folder",
									HasChildren: true
								}
							);
						}
						else if (tag.Type == "Root")
						{
							nodes.push(
								{
									Name: "forms",
									Text: "窗口和自定义控件",
									Tag: {
										Type: "Forms"
									},
									ImageCss: "Image16_Folder",
									HasChildren: true
								}
							);
						}
						else if (tag.Type == "Forms")
						{
							for (var i in m_CodeBuilder.FormPHs)
							{
								var ph = m_CodeBuilder.FormPHs[i];
								var node = {
									Name: ph.GetName(),
									Text: ph.GetName(),
									Tag: {
										Type: "PlaceHolder",
										PlaceHolder: ph
									},
									ImageCss: ph.is("FormPH")?"Developer_Tree_Form":"Developer_Tree_CustomControl",
									HasChildren: true
								};
								nodes.push(node);
							}
						}
						else if (tag.Type == "PlaceHolder")
						{
							tag.PlaceHolder.ForeachPH(
								function(ph)
								{
									var node = {
										Name: ph.GetName(),
										Text: ph.GetName(),
										Tag: {
											Type: "PlaceHolder",
											PlaceHolder: ph
										},
										ImageCss: "Developer_Tree_Ctrl",
										HasChildren: true
									};
									nodes.push(node);
								}
							)
						}
						callback(nodes);
					}
				}
			}
		);

		m_ObjectView.GetContextMenu = function()
		{
			var node = m_ObjectView.GetSelectedNode();
			if (node == null) return null;
			if (node.GetTag().Type == "Root" || node.GetTag().Type == "Forms") return m_MenuWindows;
			if (node.GetTag().Type == "PlaceHolder" && !(node.GetTag().PlaceHolder.IsClass()
				&& m_CodeBuilder.IndexOf(node.GetTag().PlaceHolder) == 0)) return m_MenuControl;
			return null;
		}

		m_PropertySheet = new PropertySheet(
			{
				Left: 0, Top: m_VGuide.Get(1), Width: m_HGuide.GetWidth(0), Height: m_VGuide.GetWidth(2),
				Parent: m_LeftPanel,
				Css: "propertySheet", BorderWidth: 1,
				AnchorStyle: Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Bottom
			}
		);

		new Controls.HorizSplit(
			{
				Left: 0, Top: m_VGuide.Get(0), Width: m_HGuide.GetWidth(0), Height: m_VGuide.GetWidth(1),
				Parent: m_LeftPanel,
				TopControl: m_ObjectView, BottomControl: m_PropertySheet,
				AnchorStyle: Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Bottom
			}
		);
	}

	CreateLeftPanle();
	
	function PH_OnDblClick(ph)
	{
		This.OnPHDblClick.Call(ph);
	}
	
	function PH_OnChanged(ph)
	{
		if (ph.IsClass())
		{
			if(ph.is("CustomControlDesignPH"))
			{
				m_ControlEditor.RefreshControlBox();
			}
			m_ObjectView.Find(
				function(node)
				{
					if (node != null)
					{
						node.Refresh(function() { });
					}
				},
				"/root/forms"
			);
		}
		else
		{
			ph = ph.GetParentPH();
			m_ObjectView.Find(
				function(node)
				{
					if (node != null)
					{
						node.SetText(ph.GetName());
						node.Refresh(function() { });
					}
				},
				"/root/forms/" + ph.GetFullName().replace(/\./g, function() { return "/" })
			);
		}
	}
	
	function PHOnFocus(ph)
	{
		if (ph.GetProperties != undefined)
		{
			m_PropertySheet.LoadProperties(ph, ph.GetProperties());
		}
		m_ObjectView.Select(
			function(node)
			{
			},
			"/root/forms/" + ph.GetFullName().replace(/\./g, function() { return "/" })
		);
		}
	
	function PHOnPropertyChanged(ph)
	{
		if(ph.is("CustomControlDesignPH"))
		{
			m_ControlEditor.RefreshControlBox();
		}
		if (ph.GetProperties != undefined)
		{
			if (m_PropertySheet.GetRelPH() == ph)
				m_PropertySheet.LoadProperties(ph, ph.GetProperties());
		}
	}

	m_ObjectView.OnClick.Attach(
		function(node)
		{
			var tag = node.GetTag();
			if (tag.Type == "PlaceHolder")
			{
				if (tag.PlaceHolder.IsClass() && tag.PlaceHolder!=m_ControlEditor.GetRootPH())
				{
					This.Load(tag.PlaceHolder);
				}
				else if (tag.PlaceHolder.GetTopPlaceHolder().IsClass() && tag.PlaceHolder.GetTopPlaceHolder()!=m_ControlEditor.GetRootPH())
				{
					This.Load(tag.PlaceHolder.GetTopPlaceHolder());
				}
				SetFocusPlaceHolder(tag.PlaceHolder);
			}
		}
	);
}

function ControlEditor(config)
{
	var This = this;
	var m_CodeBuilder = config.CodeBuilder;

	Control.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is,
		Resize: this.Resize
	};

	this.GetType = function() { return "Designer"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	var m_PHContainer = new Control(
		{
			Left: 0, Top: 0, Width: This.GetClientWidth() - 150, Height: This.GetClientHeight(),
			Parent: This,
			Css: "phcontainer", BorderWidth: 0,
			AnchorStyle: Controls.AnchorStyle.All
		}
	);

		m_PHContainer.GetDom().style.overflow = "hidden";

	System.AttachEvent(
		m_PHContainer.GetDom(), "scroll",
		function()
		{
			var dom = m_PHContainer.GetDom();
			if (dom.scrollLeft > 0 || dom.scrollTop > 0)
			{
				dom.scrollLeft = 0;
				dom.scrollTop = 0;
			}
		}
	);

	var m_CtrlBox = new ControlBox(
		{
			Left: This.GetClientWidth() - 150, Top: 0, Width: 150, Height: This.GetClientHeight(),
			Parent: This,
			BorderWidth: 0,
			AnchorStyle: Controls.AnchorStyle.Right | Controls.AnchorStyle.Top | Controls.AnchorStyle.Bottom
		}
	);
	
	var m_FormPH = null;
	
	This.RefreshControlBox=function()
	{
		m_CtrlBox.Load();
	}

	This.Clear = function()
	{
		if(m_FormPH!=null)
		{
			m_PHContainer.RemoveControl(m_FormPH);
			m_FormPH = null;
		}
	}

	This.Load = function(ph)
	{
		if (m_FormPH != null) m_PHContainer.RemoveControl(m_FormPH);
		m_FormPH = ph;
		m_PHContainer.AddControl(ph);
	}

	This.GetRootPH = function() 
	{ 
		return m_FormPH; 
	};

	function ControlBox(config)
	{
		var This = this;

		config.Width = 150;
		config.Css = "controlBox";

		Control.call(This, config);

		var Base = {
			GetType: This.GetType,
			is: This.is
		}

		This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
		This.GetType = function() { return "ControlBox"; }

		This.OnCommand = new Delegate();
		
		var m_PredefineItems = [
			{ Type: "Title", Text: "基本控件 " },
			{ Css: "Developer_Control", Type: "Control", Text: "Control ", Ctor: ControlPH },
			{ Type: "Title", Text: "常用控件 " },
			{ Css: "Developer_Control", Type: "Control", Text: "Button ", Ctor: ButtonPH },
			{ Css: "Developer_Control", Type: "Control", Text: "Label ", Ctor: LabelPH },
			{ Css: "Developer_Control", Type: "Control", Text: "TextBox ", Ctor: TextBoxPH },
			{ Css: "Developer_Control", Type: "Control", Text: "Password ", Ctor: PasswordPH },
			{ Css: "Developer_Control", Type: "Control", Text: "TextArea ", Ctor: TextAreaPH },
			{ Css: "Developer_Control", Type: "Control", Text: "RadioButton ", Ctor: RadioButtonPH },
			{ Css: "Developer_Control", Type: "Control", Text: "CheckBox ", Ctor: CheckBoxPH },
			{ Css: "Developer_Control", Type: "Control", Text: "DropDownList ", Ctor: DropDownListPH },
			{ Css: "Developer_Control", Type: "Control", Text: "ListBox ", Ctor: ListBoxPH },
			{ Css: "Developer_Control", Type: "Control", Text: "TreeView ", Ctor: TreeViewPH },
			{ Css: "Developer_Control", Type: "Control", Text: "ListView ", Ctor: ListViewPH },
			{ Css: "Developer_Control", Type: "Control", Text: "Toolbar ", Ctor: ToolbarPH },
			{ Type: "Title", Text: "容器 " },
			{ Css: "Developer_Control", Type: "Control", Text: "Tab ", Ctor: SimpleTabControlPH },
			{ Type: "Title", Text: "通用控件 " },
			{ Css: "Developer_Control", Type: "Control", Text: "HTML在线编辑器 ", Ctor: RichEditorPH },
			{ Type: "Title", Text: "自定义控件 " }
		];
		
		var m_Items=[];

		var m_SelectedIndex = -1;
		
		This.Load = function()
		{
			m_SelectedIndex = -1;
			m_Items=[];
			This.GetDom().innerHTML="";
			
			for (var i = 0; i < m_PredefineItems.length; i++)
			{
				m_Items.push(m_PredefineItems[i]);
			}
			for(var i = 0; i<m_CodeBuilder.FormPHs.length;i++)
			{
				var ph = m_CodeBuilder.FormPHs[i];
				if (ph.is("CustomControlDesignPH"))
				{
					m_Items.push(
						{
							Css: "Developer_Control", Type: "Control", Text: ph.GetName(), Ctor: CustomControlObjectPH,
							Tag: {
								Name: ph.GetName(),
								Width: ph.GetWidth(),
								Height: ph.GetHeight()
							}
						}
					);
				}
			}
			
			for (var i = 0; i < m_Items.length; i++)
			{
				var item = m_Items[i];
				if (item.Type == "Control")
				{
					var dom = document.createElement("DIV");
					dom.className = "controlBoxButton";
					dom.innerHTML = String.format("<div>{0}</div>", item.Text);
					dom.firstChild.className = item.Css;

					(function(index)
					{
						dom.onmousedown = function()
						{
							if (m_SelectedIndex != -1)
							{
								This.GetDom().childNodes[m_SelectedIndex].className = "controlBoxButton";
							}
							m_SelectedIndex = index;
							This.GetDom().childNodes[m_SelectedIndex].className = "controlBoxSelBtn";

							DragCtrolVar = {
								Cursor: String.format("url(\"{0}.{1}\"), wait", Module.GetResourceUrl("Developer/cursor/addctrl"),GetCursorExt()),
								PHCtor: m_Items[m_SelectedIndex].Ctor,
								Tag: m_Items[m_SelectedIndex].Tag
							};
						}

					})(i);

					This.GetDom().appendChild(dom);
					dom = null;
				}
				else if (item.Type == "Title")
				{
					var dom = document.createElement("DIV");
					dom.className = "typeTitle";
					dom.innerHTML = String.format("<div>{0}</div>", item.Text);

					This.GetDom().appendChild(dom);
					dom = null;

				}
			}
		}
		
		This.Load();
	}
}

function ResourceManager(config)
{
	var This = this;
	
	config.Css="resourceManager";

	Control.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is
	};

	this.GetType = function() { return "ResourceManager"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
	
	var m_Browser=null;
	
	This.Reset=function(root)
	{
	}
}

function CssEditor(config)
{
	var This = this;
	
	config.Css="cssEditor";

	Control.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is
	};

	this.GetType = function() { return "CssEditor"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	new Controls.Label(
		{
			Left: 0, Top: 9, Width: 200, Height: 16,
			AnchorStyle: Controls.AnchorStyle.Left | Controls.AnchorStyle.Top,
			Css: "label", BorderWidth: 1,
			Parent: This, Text:"Css路径(该路径相对于Desktop.htm):"
		}
	);

	var m_Path = new Controls.TextBox(
		{
			Left: 200, Top: 4, Width: This.GetClientWidth() - 200, Height: 22,
			AnchorStyle: Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Top,
			Css: "textbox", BorderWidth: 1,
			Parent: This
		}
	);

	var m_Editor = new Controls.TextArea(
		{
			Left: 0, Top: 30, Width: This.GetClientWidth(), Height: This.GetClientHeight() - 30,
			AnchorStyle: Controls.AnchorStyle.All,
			Css: "textarea", BorderWidth: 1,
			Parent: This
		}
	);

	m_Editor.GetTextAreaDom().wrap = "off";
	m_Editor.GetTextAreaDom().style.fontFamily = "Courier New";
	m_Editor.GetTextAreaDom().style.fontSize = "12px";

	m_Editor.GetTextAreaDom().onkeydown = function(evt)
	{
		if (evt == undefined) evt = window.event;
		if (evt.keyCode == 9 && !evt.shiftKey && !evt.ctrlKey && !evt.altKey)
		{
			if (this.setSelectionRange)
			{
				var sS = this.selectionStart;
				var sE = this.selectionEnd;
				this.value = this.value.substring(0, sS) + "    " + this.value.substr(sE);
				this.setSelectionRange(sS + 4, sS + 4);
				this.focus();
				System.PreventDefault(evt);
			}
			else if (this.createTextRange)
			{
				document.selection.createRange().text = "    ";
				this.focus();
				System.PreventDefault(evt);
			}
		}
		else if (evt.keyCode == 13 && !evt.shiftKey && !evt.ctrlKey && !evt.altKey)
		{
			System.CancelBubble(evt);
		}
	}
	
	This.GetCssCode=function()
	{
		return m_Editor.GetText();
	}
	
	This.SetCssCode=function(code)
	{
		m_Editor.SetText(code);
	}
	
	This.SetPath = function(path)
	{
		m_Path.SetText(path);
	}
	
	This.GetPath = function(path)
	{
		return m_Path.GetText();
	}

	This.GetSaveData = function()
	{
		return {
			Path: m_Path.GetText(),
			CssCode: m_Editor.GetText()
		};
	}

	This.Load = function(config)
	{
		if (config == undefined) config = {};
		m_Path.SetText(IsNull(config.Path,  "Themes/Default/Custom.css"));
		m_Editor.SetText(IsNull(config.CssCode, m_DefalutCode));
	}

	var m_DefalutCode = '';
	
	This.Reset=function()
	{
		m_Editor.SetText(m_DefalutCode);
	}
	
	This.SetPath("Themes/Default/Custom.css");
}

function CodeEditor(config)
{
	var This = this;
	var m_CodeBuilder = config.CodeBuilder;
	var m_LastestCode = "";

	Control.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is
	};

	this.GetType = function() { return "CodeEditor"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	var m_VGuide = new Controls.GuideLine(This.GetClientHeight(), [6, 0, 6]);
	var m_HGuide = new Controls.GuideLine(This.GetClientWidth(), [6, 250, 6, 0, 6]);

	var m_ObjectViewDS = {
		GetSubNodes: function(callback, item)
		{
			var nodes = [];
			if (item == null)
			{
				nodes.push(
					{
						Name: "root",
						Text: "工程",
						Tag: {
							Type: "Root"
						},
						ImageCss: "Image16_Folder",
						HasChildren: true
					}
				);
			}
			else if (item.GetName() == "root")
			{
				var es = m_CodeBuilder.GetAnchors();
				for (var i in es)
				{
					nodes.push(
						{
							Name: es[i].Name,
							Text: es[i].Text,
							Tag: {
								Type: "Anchor",
								ID: es[i].ID
							},
							ImageCss: "Image16_File",
							HasChildren: false
						}
					);
				}
				for (var i in m_CodeBuilder.FormPHs)
				{
					var ph = m_CodeBuilder.FormPHs[i];
					nodes.push(
						{
							Name: ph.GetName(),
							Text: ph.GetName(),
							Tag: {
								Type: "PlaceHolder",
								PlaceHolder: ph
							},
							ImageCss: "Image16_Folder",
							HasChildren: true
						}
					);
				}
			}
			else
			{
				var ph = item.GetTag().PlaceHolder;
				var es = ph.GetAnchors();
				for (var i in es)
				{
					nodes.push(
						{
							Name: es[i].Name,
							Text: es[i].Text,
							Tag: {
								Type: "Anchor",
								ID: es[i].ID
							},
							ImageCss: "Image16_File",
							HasChildren: false
						}
					);
				}
				ph.ForeachPH(
					function(sph)
					{
						nodes.push(
							{
								Name: sph.GetName(),
								Text: sph.GetName(),
								Tag: {
									Type: "PlaceHolder",
									PlaceHolder: sph
								},
								ImageCss: "Image16_Folder",
								HasChildren: true
							}
						);
					}
				);

			}
			callback(nodes);

		}
	};

	var m_ObjectView = new ObjectView(
		{
			Left: m_HGuide.Get(0), Top: m_VGuide.Get(0), Width: m_HGuide.GetWidth(1), Height: m_VGuide.GetWidth(1),
			Parent: This,
			Css: "objectView", BorderWidth: 1,
			AnchorStyle: Controls.AnchorStyle.Top | Controls.AnchorStyle.Bottom,
			DataSource: m_ObjectViewDS
		}
	);

	m_ObjectView.OnClick.Attach(
		function(node)
		{
			if (node.GetTag().Type == "Anchor")
			{
				m_CodeEditor.ScrollIntoView(node.GetTag().ID);
			}
		}
	);

	var m_RightPanel = new Control(
		{
			Left: m_HGuide.Get(2), Top: m_VGuide.Get(0), Width: m_HGuide.GetWidth(3), Height: m_VGuide.GetWidth(1),
			Parent: This,
			BorderWidth: 0,
			AnchorStyle: Controls.AnchorStyle.All
		}
	);

	var m_VSplit = new Controls.VerticalSplit(
		{
			Left: m_HGuide.Get(1), Top: m_VGuide.Get(0), Width: m_HGuide.GetWidth(2), Height: m_VGuide.GetWidth(1),
			Parent: This,
			LeftControl: m_ObjectView, RightControl: m_RightPanel,
			AnchorStyle: Controls.AnchorStyle.Top | Controls.AnchorStyle.Bottom
		}
	);

	var m_Editor = new Editor(
		{
			Left: 0, Top: 0, Width: m_RightPanel.GetClientWidth(), Height: m_RightPanel.GetClientHeight(),
			Parent: m_RightPanel,
			Css: "editor", BorderWidth: 1,
			AnchorStyle: Controls.AnchorStyle.All
		}
	);

//	var m_DocPanel = new Control(
//		{
//			Left: 0, Top: m_RightPanel.GetClientHeight() - 200, 
//			Width: m_RightPanel.GetClientWidth(), Height: 200,
//			Parent: m_RightPanel,
//			Css: "defaultControlCss", BorderWidth: 1,
//			AnchorStyle: Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Bottom
//		}
//	);

//	new Controls.HorizSplit(
//		{
//			Left: 0, Top: m_RightPanel.GetClientHeight() - 200-6, 
//			Width: m_RightPanel.GetClientWidth(), Height: 6,
//			Parent: m_RightPanel,
//			TopControl: m_Editor, BottomControl: m_DocPanel,
//			AnchorStyle: Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Bottom
//		}
//	);

	function ObjectView(config)
	{
		var This = this;

		Controls.TreeView.call(this, config);

		var Base = {
			GetType: this.GetType,
			is: this.is
		};

		this.GetType = function() { return "CodeEditor.ObjectView"; }
		this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
	}


	function Editor(config)
	{
		var This = this;

		Controls.Frame.call(this, config);

		var Base = {
			GetType: this.GetType,
			is: this.is
		};

		this.GetType = function() { return "CodeEditor.Editor"; }
		this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }
		
		This.GetDom().style.overflow="hidden";
	}

	This.Load = function()
	{
		var html = m_CodeBuilder.RenderCodeHtml("");
		if (html != m_LastestCode)
		{
			m_ObjectView.Refresh(
				function()
				{
					m_ObjectView.Expand(
						function()
						{
							m_CodeEditor.Load(html);
							m_CodeBuilder.RenderEditor(m_CodeEditor);
							m_LastestCode = html;
						},
						"/root"
					);
				}
			);
		}
	}

	This.Edit = function(id)
	{
		m_ObjectView.Select(
			function()
			{
				m_CodeEditor.ScrollIntoView(id);
			},
			"/root/" + id.replace(/\./g, function() { return "/"; })
		);
	}

	var m_CodeEditor = null;

	This.GetEditor = function() { return m_CodeEditor; }

	m_Editor.OnBeforeLoad.Attach(
		function()
		{
			This.GetTopContainer().Waiting();
		}
	);
	m_Editor.OnAfterLoad.Attach(
		function()
		{
			This.GetTopContainer().Completed();
			m_Editor.GetWindow().Init({ Frame: m_Editor });
			m_CodeEditor = m_Editor.GetWindow().CodeEditor;
			
			if(m_OnInit!=null)
			{
				m_OnInit();
				m_OnInit=null;
			}
		}
	);
	
	var m_OnInit=IsNull(config.OnInit,null);
	
	m_Editor.Navigate(Module.GetResourceUrl("Developer/CodeEditor/editor.html"));
}

function PropertySheet(config)
{
	var This = this;

	Control.call(this, config);

	var Base = {
		GetType: this.GetType,
		is: this.is
	};

	this.GetType = function() { return "PropertySheet"; }
	this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

	var m_Header = new Control(
		{
			Left: 0, Top: 0, Width: This.GetClientWidth(), Height: 24,
			Parent: This,
			Css: "propertySheetHeader", BorderWidth: 0,
			AnchorStyle: Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Top
		}
	);

	var m_Body = new Control(
		{
			Left: 0, Top: 24, Width: This.GetClientWidth(), Height: This.GetClientHeight() - 24,
			Parent: This,
			Css: "propertySheetContent", BorderWidth: 0,
			AnchorStyle: Controls.AnchorStyle.All
		}
	);

	m_Header.GetDom().innerHTML = "<table cellspacing='0'><tr class='tr_header'><td class='td_left'>属性</td><td class='td_right'>值</td></tr></table>";

	var m_Index = {};

	This.OnResized.Attach(
		function()
		{
			m_Header.GetDom().firstChild.style.width = (This.GetClientWidth() - 25) + "px";
			if (m_Body.GetDom().firstChild != null)
				m_Body.GetDom().firstChild.style.width = (This.GetClientWidth() - 25) + "px";
		}
	);

	m_Header.GetDom().firstChild.style.width = (This.GetClientWidth() - 25) + "px";

	var m_PH = null;
	var m_Properties;

	This.LoadProperties = function(ph, properties)
	{
		m_PH = ph;
		m_Properties = properties;
		var builder = [];
		builder.push("<table cellpadding='0' cellspacing='0'>");
		builder.push("<tbody>");

		for (var i = 0; i < properties.length; i++)
		{
			var prop = properties[i];
			m_Index[prop.Name] = i;
			var ctrl = "";
			switch (prop.CtrlType)
			{
			case "text":
				{
					ctrl = String.format("<input type='text' value='{0}'/>", prop.Value);
					break;
				}
			case "combobox":
				{
					ctrl += "<select>";
					for (var j in prop.Options)
					{
						ctrl += String.format("<option {1}>{0}</option>", prop.Options[j], prop.Options[j] == prop.Value ? "selected" : "");
					}
					ctrl += "</select>";
					break;
				}
			case "...":
				{
					ctrl = String.format("<div class='set'>设置...</div>");
					break;
				}
			}
			builder.push(
				String.format(
					"<tr class='tr_property'><td class='td_left'>{0}</td><td class='td_right'>{1}</td></tr>",
					prop.Name, ctrl
				)
			);
		}

		builder.push("</tbody>");
		builder.push("</table>");

		m_Body.GetDom().innerHTML = builder.join("");
		m_Body.GetDom().style.overflow = 'auto';

		for (var i = 0; i < m_Body.GetDom().firstChild.rows.length; i++)
		{
			var elem=m_Body.GetDom().firstChild.rows[i].cells[1].firstChild;
			if(m_Properties[i].CtrlType=="...")
			{
				(function(index){
					elem.onclick=function()
					{
						m_Properties[index].OnSet();
					}
				})(i);
			}
			else
			{
				elem.onchange = function()
				{
					ReadValue();
				}
			}
		}
	}

	function ReadValue()
	{
		m_PH.ReadProperties(This);
	}

	This.GetRelPH = function()
	{
		return m_PH;
	}

	This.GetValue = function(name)
	{
		if (m_Body.GetDom().firstChild != null)
		{
			var index = m_Index[name];
			var ctrl = m_Body.GetDom().firstChild.rows[index].cells[1].firstChild;
			switch (m_Properties[index].CtrlType)
			{
				case "text":
					{
						return ctrl.value;
					}
				case "combobox":
					{
						return ctrl.options[ctrl.selectedIndex].value;
					}
			}
		}
		else
		{
			return "";
		}
	}

	This.Clear = function()
	{
		m_Body.GetDom().innerHTML = "";
	}
}

function ConfirmDialog(callback,tip)
{
	var wndConfig = {
		Left: 0, Top: 0, Width: 360, Height: 125,
		BorderWidth: 6, Css: "window",
		HasMinButton: false, Resizable: false,
		Title: { Height: 18, InnerHTML: "提示" }
	}

	var This = this;

	Window.call(This, wndConfig);

	var Base = {
		GetType: This.GetType,
		is: This.is
	}

	This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
	This.GetType = function() { return "ConfirmDialog"; }

	var m_LabelInfo = new Controls.Label(
		{
			Left: 8, Top: 8, Width: This.GetClientWidth() - 8 * 2, Height: This.GetClientHeight() - 8 * 2 - Controls.Button.Height - 8,
			AnchorStyle: Controls.AnchorStyle.All,
			Text: tip,
			Parent: This
		}
	);

	var m_BtnYes = new Controls.Button(
		{
			Left: This.GetClientWidth() / 2 - 8 - 32 - 64, Top: This.GetClientHeight() - 8 - Controls.Button.Height, Width: 64, Height: Controls.Button.Height,
			AnchorStyle: Controls.AnchorStyle.Bottom | Controls.AnchorStyle.Right,
			Text: "是",
			Css: "button_default",
			Parent: This
		}
	);

	var m_BtnNo = new Controls.Button(
		{
			Left: This.GetClientWidth() / 2 - 32, Top: This.GetClientHeight() - 8 - Controls.Button.Height, Width: 64, Height: Controls.Button.Height,
			AnchorStyle: Controls.AnchorStyle.Bottom | Controls.AnchorStyle.Right,
			Text: "否",
			Css: "button",
			Parent: This
		}
	);

	var m_BtnCancel = new Controls.Button(
		{
			Left: This.GetClientWidth() / 2 + 32 + 8, Top: This.GetClientHeight() - 8 - Controls.Button.Height, Width: 64, Height: Controls.Button.Height,
			AnchorStyle: Controls.AnchorStyle.Bottom | Controls.AnchorStyle.Right,
			Text: "取 消",
			Parent: This
		}
	);

	m_BtnYes.OnClick.Attach(
		function()
		{
			This.Close();
			callback("yes");
		}
	);

	m_BtnNo.OnClick.Attach(
		function()
		{
			This.Close();
			callback("no");
		}
	);

	m_BtnCancel.OnClick.Attach(
		function()
		{
			This.Close();
			callback("cancel");
		}
	);

	This.SetAcceptButton(m_BtnYes);
	This.SetCancelButton(m_BtnCancel);
}

function OpenSolutionForm()
{
    var This = this;
    var OwnerForm = this;

    var config = {
        "Left": 8,
        "Top": 5,
        "Width": 642,
        "Height": 525,
        "AnchorStyle": Controls.AnchorStyle.Left | Controls.AnchorStyle.Top,
        "Parent": null,
        "Css": "window",
        "BorderWidth": 6,
        "HasMinButton": false,
        "HasMaxButton": true,
        "Resizable": true,
        "Title": {
            "InnerHTML": "打开工程"
        }
    };

    Window.call(This, config);

    var Base = {
        GetType: This.GetType,
        is: This.is
    };

    This.GetType = function()
    {
        return "OpenSolutionForm";
    }
    
    This.is = function(type)
    {
        return type == This.GetType() ? true: Base.is(type);
    }

    var m_Content = new Controls.TextArea(
		{
			"Left": 3,
			"Top": 23,
			"Width": 624,
			"Height": 469,
			"AnchorStyle": Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Top | Controls.AnchorStyle.Bottom,
			"Parent": This,
			"Text": "",
			"Css": "textarea",
			"BorderWidth": 1
		}
    );

    var label2 = new Controls.Label(
		{
			"Left": 3,
			"Top": 6,
			"Width": 623,
			"Height": 13,
			"AnchorStyle": Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Top,
			"Parent": This,
			"Text": "请输入工程文件内容...",
			"Css": "label"
		}
    );

    var m_Task = null;
    if (config.HasMinButton)
    {
        m_Task = Taskbar.AddTask(This, IsNull(config.Title.InnerHTML, ""));
        This.OnClosed.Attach(
        function()
        {
            Taskbar.RemoveTask(m_Task);
        });
    }
    
    This.GetContent = function()
    {
		return m_Content.GetText();
    }
}

function GenerationSolutionForm()
{
    var This = this;
    var OwnerForm = this;

    var config = {
        "Left": 8,
        "Top": 5,
        "Width": 642,
        "Height": 525,
        "AnchorStyle": Controls.AnchorStyle.Left | Controls.AnchorStyle.Top,
        "Parent": null,
        "Css": "window",
        "BorderWidth": 6,
        "HasMinButton": false,
        "HasMaxButton": true,
        "Resizable": true,
        "Title": {
            "InnerHTML": "工程文件"
        }
    };

    Window.call(This, config);

    var Base = {
        GetType: This.GetType,
        is: This.is
    };

    This.GetType = function()
    {
        return "GenerationSolutionForm";
    }
    
    This.is = function(type)
    {
        return type == This.GetType() ? true: Base.is(type);
    }

    var m_Content = new Controls.TextArea(
		{
			"Left": 3,
			"Top": 23,
			"Width": 624,
			"Height": 469,
			"AnchorStyle": Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Top | Controls.AnchorStyle.Bottom,
			"Parent": This,
			"Text": "",
			"Css": "textarea",
			"BorderWidth": 1
		}
    );

    var label2 = new Controls.Label(
		{
			"Left": 3,
			"Top": 6,
			"Width": 623,
			"Height": 13,
			"AnchorStyle": Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Top,
			"Parent": This,
			"Text": "请将以下工程文件内容复制到本地计算机上...",
			"Css": "label"
		}
    );

    var m_Task = null;
    if (config.HasMinButton)
    {
        m_Task = Taskbar.AddTask(This, IsNull(config.Title.InnerHTML, ""));
        This.OnClosed.Attach(
			function()
			{
				Taskbar.RemoveTask(m_Task);
			}
        );
    }
    
    This.SetContent = function(text)
    {
		m_Content.SetText(text);
    }

}

function GenerationCodeForm(css)
{
    var This = this;
    var OwnerForm = this;

    var config = {
        "Left": 8,
        "Top": 5,
        "Width": 642,
        "Height": 525,
        "AnchorStyle": Controls.AnchorStyle.Left | Controls.AnchorStyle.Top,
        "Parent": null,
        "Css": "window",
        "BorderWidth": 6,
        "HasMinButton": false,
        "HasMaxButton": true,
        "Resizable": true,
        "Title": {
            "InnerHTML": "工程代码"
        }
    };

    Window.call(This, config);

    var Base = {
        GetType: This.GetType,
        is: This.is
    };

    This.GetType = function()
    {
        return "GenerationCodeForm";
    }
    
    This.is = function(type)
    {
        return type == This.GetType() ? true: Base.is(type);
    }

    var m_Content = new Controls.TextArea(
		{
			"Left": 3,
			"Top": 47,
			"Width": 624,
			"Height": 445,
			"AnchorStyle": Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Top | Controls.AnchorStyle.Bottom,
			"Parent": This,
			"Text": "",
			"Css": "textarea",
			"BorderWidth": 1
		}
    );

    var label2 = new Controls.Label(
		{
			"Left": 3,
			"Top": 6,
			"Width": 623,
			"Height": 36,
			"AnchorStyle": Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Top,
			"Parent": This,
			"Text": String.format("1.将以下代码保存到网站服务器上（请使用UTF-8编码）;<br/>2.将Css保存到\"{0}\";<br/>3.调用System.Exec(function(){},alert,'代码路径.js')运行。", css),
			"Css": "label"
		}
    );
    
    label2.GetDom().style.color = "#CC0000";

    var m_Task = null;
    if (config.HasMinButton)
    {
        m_Task = Taskbar.AddTask(This, IsNull(config.Title.InnerHTML, ""));
        This.OnClosed.Attach(
			function()
			{
				Taskbar.RemoveTask(m_Task);
			}
        );
    }
    
    This.SetContent = function(text)
    {
		m_Content.SetText(text);
    }

}

function Application()
{
	var CurrentApplication = this;
	var m_MainForm = null;
	var m_CodeBuilder = new CodeBuilder(CurrentApplication);
	var m_SolutionFile = "Temp.sln";
		
	function GetProjectName()
	{
		return System.Path.GetFileNameNoExtention(m_SolutionFile);
	}
	
	function GetCssUrl()
	{
		return m_MainForm.GetCssUrl();
	}

	this.GetCssUrl = GetCssUrl;
	
	function GetCssFileName()
	{
		return System.Path.GetDirectoryName(m_SolutionFile) + "/Bin/" + System.Path.GetFileNameNoExtention(m_SolutionFile) + ".css";
	}

	function GetExecFileName()
	{
		return System.Path.GetDirectoryName(m_SolutionFile) + "/Bin/" + System.Path.GetFileNameNoExtention(m_SolutionFile) + ".js";
	}
	
	function GetBinFullPath()
	{
		return System.Path.GetDirectoryName(m_SolutionFile) + "/Bin";
	}

	this.GetProjectName=GetProjectName;

	this.Start = function(baseUrl,file)
	{
		m_MainForm = new MainForm();
		m_MainForm.OnClosed.Attach(
			function()
			{
				m_MainForm = null;
				CurrentApplication.Dispose();
			}
		);
		m_MainForm.MoveEx('center', 0, 0);
		m_MainForm.Show(true);
		m_MainForm.Maximun();
		if (file != undefined)
		{
			m_SolutionFile = file;
		}
	}

	this.Terminate = function(completeCallback, errorCallback)
	{
		completeCallback();
	}

	function MainForm()
	{
		var This = this;
		var m_Toolbar = null, m_Designer = null, m_Tab = null, m_CodeEditor = null, m_CssEditor = null;

		var config = {
			Left: 0, Top: 0, Width: 800, Height: 600,
			Parent: null,
			Css: "window", BorderWidth: 6,
			HasMinButton: true, HasMaxButton: true,
			Title: {
				InnerHTML: "在线开发"
			},
			OnClose:OnClose
		};

		Window.call(this, config);

		var Base = {
			GetType: this.GetType,
			is: this.is
		};

		this.GetType = function() { return "MainForm"; }
		this.is = function(type) { return type == this.GetType() ? true : Base.is(type); }

		var m_Task = null;

		m_Task = Taskbar.AddTask(This, "在线开发");

		This.OnClosed.Attach(
			function()
			{
				Taskbar.RemoveTask(m_Task);
			}
		);
		
		This.GetCssUrl = function()
		{
			return m_CssEditor.GetPath();
		}

		function OnClose()
		{
			if(m_SolutionFile!=null)
			{
				var dlg = new ConfirmDialog(
					function(result)
					{
						if (result == "yes")
						{
							Save(function() { This.Close(); }, function(ex) { alert(ex.Message); });
						}
						else if (result == "no")
						{
							This.Close();
						}
						else
						{
						}
					},
					"退出前是否保存当前工程？"
				);

				dlg.ShowDialog(
					m_MainForm, 'center', 0, 0
				);
			}
			else
			{
				This.Close();
			}
		}
		
		function GetBinPath()
		{
			return System.Path.GetDirectoryName(m_SolutionFile) + "/Bin";
		}
		
		function Close()
		{
			m_Tab.Select(0);
			m_Designer.Clear();
			m_CodeBuilder.FormPHs = [];
		}

		function NewProject()
		{
			if(m_CodeBuilder.FormPHs.length == 0 || confirm("新建工程将覆盖现有工程，是否继续？"))
			{
				var data = {
					Versize: "1.0",
					Data: {
						Forms: [
							{
								Constructor: "FormPH",
								Config: {
									Left: 0, Top: 0, Width: 400, Height: 300,
									Css: "window",
									AnchorStyle: Controls.AnchorStyleLeft | Controls.AnchorStyleTop,
									Name: "MainForm", Text: "主窗口"
								},
								Controls: []
							}
						]
					}
				};
				
				Close();

				m_CodeBuilder.Load(data.Data);
				m_Designer.RefreshObjectView();
				m_Designer.Load(m_CodeBuilder.FormPHs[0]);
				m_Designer.RefreshControlBox();
				m_CodeEditor.Load();
				m_CssEditor.Reset();
				m_ResourceManager.Reset(GetBinFullPath());
				
				m_Toolbar.SetButtonVisible(2,true);
				m_Toolbar.SetButtonVisible(3,true);
				m_Toolbar.SetButtonVisible(4,true);
			}
		}

		function OpenProject(sln)
		{
		}

		This.Open = OpenProject;

		function Open()
		{			
			var dlg = new OpenSolutionForm();

			dlg.ShowDialog(
				m_MainForm, 'center', 0, 0,
				function()
				{
					var content = dlg.GetContent();
					if (content != "")
					{
						try
						{
							var data = System.ParseJson(content);
							m_CodeBuilder.Load(data.Data);
							m_Designer.RefreshObjectView();
							m_Designer.Load(m_CodeBuilder.FormPHs[0]);
							m_Designer.RefreshControlBox();
							m_CodeEditor.Load();
							m_CssEditor.Load(data.Css);

							m_Toolbar.SetButtonVisible(2, true);
							m_Toolbar.SetButtonVisible(3, true);
							m_Toolbar.SetButtonVisible(4, true);
						}
						catch(ex)
						{
						}
					}
				}
			);

		};

		function Save(completedCallback, errorCallback)
		{
			function render()
			{
				var data = {
					Data: m_CodeBuilder.GetSaveData(),
					Css: m_CssEditor.GetSaveData(),
					Version: "1.0"
				};
				var content = System.RenderJson(data);
				return content;
			}
			var content = render();
			var code=m_CodeBuilder.RenderCode();	
			
			var dlg = new GenerationSolutionForm();

			dlg.ShowDialog(m_MainForm, 'center', 0, 0);
			
			dlg.SetContent(content);
		}

		m_Toolbar = new Controls.Toolbar(
			{
				Left: 1, Top: 1, Width: This.GetClientWidth() - 2, Height: Controls.Toolbar.PredefineHeight,
				AnchorStyle: Controls.AnchorStyle.Left | Controls.AnchorStyle.Right | Controls.AnchorStyle.Top,
				BorderWidth: 0, Css: "toolbar",
				Parent: This,
				DisableSelect:false,
				Items: [
					{ Css: "Developer_BtnNew", Text: "新建", Command: "New" },
					{ Css: "Developer_BtnOpen", Text: "打开", Command: "Open" },
					{ Css: "Developer_BtnSave", Text: "保存", Command: "Save" },
					{ Css: "Developer_BtnExec", Text: "运行", Command: "Execute" },
					{ Css: "Developer_BtnSave", Text: "生成工程", Command: "Code" }
				]
			}
		);

		m_Toolbar.SetButtonVisible(2,false);
		m_Toolbar.SetButtonVisible(3,false);
		m_Toolbar.SetButtonVisible(4,false);
		
		m_Tab = new Controls.SimpleTabControl(
			{
				Left: 1, Top: 1 + Controls.Toolbar.PredefineHeight + 2, Width: This.GetClientWidth() - 2, Height: This.GetClientHeight() - Controls.Toolbar.PredefineHeight - 4,
				AnchorStyle: Controls.AnchorStyle.All,
				BorderWidth: 1,
				Parent: This,
				Tabs: [
					{ Text: "UI设计", Width: 80, IsSelected: true },
					{ Text: "代码", Width: 80, IsSelected: false },
					{ Text: "Css", Width: 80, IsSelected: false },
					{ Text: "文件管理", Width: 80, IsSelected: false }
				]
			}
		);

		m_Tab.OnSelectedTab.Attach(
			function(index, preIndex)
			{
				if(m_SolutionFile!=null)
				{
					if (index == 1)
					{
						m_CodeEditor.Load();
					}
					else if (preIndex == 1)
					{
						m_CodeBuilder.ReadCode(m_CodeEditor.GetEditor());
					}
				}
			}
		);

		m_Toolbar.OnCommand.Attach(
			function(cmd)
			{
				switch (cmd)
				{
				case "Code":
					{
						if (m_Tab.GetSelectedIndex() == 1)
						{
							m_CodeBuilder.ReadCode(m_CodeEditor.GetEditor());
						}

						var code = m_CodeBuilder.RenderCode();

						var dlg = new GenerationCodeForm(m_CssEditor.GetPath());
						dlg.ShowDialog(m_MainForm, 'center', 0, 0);
						dlg.SetContent(code);
						
						break;
					}
				case "Execute":
					{
						function exec()
						{
							if(m_Tab.GetSelectedIndex()==1)
							{
								m_CodeBuilder.ReadCode(m_CodeEditor.GetEditor());
							}
							try
							{
								System.Test(GetExecFileName(),m_CodeBuilder.RenderCode(), RedirectCssUrl(System.Path.GetDirectoryName(m_CssEditor.GetPath()),m_CssEditor.GetCssCode()));
							}
							catch(ex)
							{
								alert(ex);
							}
						}
						exec();
						break;
					}
				case "Save":
					{
						if(m_Tab.GetSelectedIndex()==1)
						{
							m_CodeBuilder.ReadCode(m_CodeEditor.GetEditor());
						}
						Save();
						break;
					}
				case "Open":
					{
						Open();
						break;
					}
				case "New":
					{
						NewProject();
						break;
					}
				}
			}
		);

		m_Designer = new Designer(
			{
				Left: 1, Top: 1, Width: m_Tab.GetPanel(0).GetClientWidth() - 2, Height: m_Tab.GetPanel(0).GetClientHeight() - 2,
				Parent: m_Tab.GetPanel(0),
				Css: 'designerPanel', BorderWidth: 0,
				AnchorStyle: Controls.AnchorStyle.All,
				CodeBuilder: m_CodeBuilder
			}
		);

		m_Designer.OnPHDblClick.Attach(
			function(ph)
			{
				m_Tab.Select(1);
				if (ph.GetDefaultEditId != undefined) m_CodeEditor.Edit(ph.GetDefaultEditId());
			}
		);

		m_CodeEditor = new CodeEditor(
			{
				Left: 1, Top: 1, Width: m_Tab.GetPanel(1).GetClientWidth() - 2, Height: m_Tab.GetPanel(1).GetClientHeight() - 2,
				Parent: m_Tab.GetPanel(1),
				Css: 'codeEditor', BorderWidth: 0,
				AnchorStyle: Controls.AnchorStyle.All,
				CodeBuilder: m_CodeBuilder,
				OnInit:function()
				{
					if(m_SolutionFile)
					{
						OpenProject(m_SolutionFile);
					}
				}
			}
		);

		m_CssEditor = new CssEditor(
			{
				Left: 3, Top: 3, Width: m_Tab.GetPanel(2).GetClientWidth() - 6, Height: m_Tab.GetPanel(2).GetClientHeight() - 6,
				Parent: m_Tab.GetPanel(2),
				BorderWidth: 0,
				AnchorStyle: Controls.AnchorStyle.All
			}
		);

		m_ResourceManager = new ResourceManager(
			{
				Left: 2, Top: 2, Width: m_Tab.GetPanel(3).GetClientWidth() - 4, Height: m_Tab.GetPanel(3).GetClientHeight() - 4,
				Parent: m_Tab.GetPanel(3),
				BorderWidth: 0,
				AnchorStyle: Controls.AnchorStyle.All
			}
		);
	}
}

