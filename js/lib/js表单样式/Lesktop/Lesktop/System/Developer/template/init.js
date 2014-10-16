////<br/>
////<pre class="sh_javascript">
if(!TESTING)
{
	System.Link("StyleSheet", Module.GetResourceUrl("[[PRJNAME]].css"), "text/css");
}

var Controls = null, CommonDialog = null, IO = null, Communication = null, Management = null;
var Window = null, Control = null, RichEditor = null;

function init(completeCallback, errorCallback)
{
	function LoadModulesComplete()
	{
		IO = System.GetModule("IO.js");
		Communication = System.GetModule("Communication.js");
		Management = System.GetModule("Management.js");
		Controls = System.GetModule("Controls.js");
		CommonDialog = System.GetModule("CommonDialog.js");

		Window = System.GetModule("Window.js").Window;
		Control = System.GetModule("Controls.js").Control;
		
		RichEditor = System.GetModule("RichEditor.js").RichEditor;

		_init(completeCallback, errorCallback);
	}

	System.LoadModules(
		LoadModulesComplete,
		errorCallback,
		["IO.js", "Communication.js", "Management.js", "Window.js", "Controls.js", "CommonDialog.js", "RichEditor.js"]
	);
}

function _init(completeCallback, errorCallback)
{
	try
	{
		//初始化代码，初始化完成后必须调用completeCallback;
////[[CODE]]
////</pre>
////<div id="init" style="margin-left:[[ML:2]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">
	}
	catch (ex)
	{
		errorCallback(new Exception(ex.mame, ex.message));
	}
}
////</pre>

