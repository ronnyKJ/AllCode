////<pre class="sh_javascript">

var [[NAME]]_Config=[[CONFIG]];

[[NAME]]_Config.OnBeginRequest=function()
{
////</pre>
////[[BEGINREQUEST]]
////<div id="[[FULLNAME]].OnBeginRequest" style="margin-left:[[ML:1]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">
}

[[NAME]]_Config.OnEndRequest=function()
{
////</pre>
////[[ENDREQUEST]]
////<div id="[[FULLNAME]].OnEndRequest" style="margin-left:[[ML:1]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">
}
////</pre>
////<pre class="sh_javascript">

var [[NAME]] = new CommonDialog.ImageBrowser([[NAME]]_Config);

////</pre>
////[[INIT]]
////<div id="[[FULLNAME]].Init" style="margin-left:[[ML:0]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">

[[NAME]].OnClick.Attach(
	function(btn)
	{
////</pre>
////[[ONCLICK_CODE]]
////<div id="[[FULLNAME]].OnClick" style="margin-left:[[ML:2]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">
	}
)
////</pre>