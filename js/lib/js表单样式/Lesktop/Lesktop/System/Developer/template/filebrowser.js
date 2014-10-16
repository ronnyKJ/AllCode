////<pre class="sh_javascript">

var [[NAME]]_Config=[[CONFIG]];
////</pre>
////[[CUSTOMCONFIG]]
////<div id="[[FULLNAME]].CustomConfig" style="margin-left:[[ML:0]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">

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
////<br/>
////<pre class="sh_javascript">

var [[NAME]] = new CommonDialog.FileBrowser([[NAME]]_Config);

////</pre>
////[[INIT]]
////<div id="[[FULLNAME]].Init" style="margin-left:[[ML:0]]px; margin-top:0px; margin-bottom:0px;"></div>