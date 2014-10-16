////<br/>
////<pre class="sh_javascript">
function Application()
{
	var CurrentApplication = this;
	var m_MainForm = null;
	
	//应用程序全局对象;
////[[GLOBAL]]	
////</pre>
////<div id="AppGlobal" style="margin-left:[[ML:1]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">

	this.Start = function(baseUrl)
	{
		//应用程序入口;
////[[START]]
////</pre>
////<div id="AppStart" style="margin-left:[[ML:2]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">
	}

	this.Terminate = function(completeCallback, errorCallback)
	{
		try
		{
			//应用程序终止，退出系统时用系统调用;
////[[TERMINATE]]
////</pre>
////<div id="AppTerminate" style="margin-left:[[ML:3]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">
		}
		catch (ex)
		{
			errorCallback(new Exception(ex.mame, ex.message));
		}
	}
////</pre>
////[[FORMS]]
////<pre class="sh_javascript">
}
////</pre>
////[[CUSTOMCTRLS]]