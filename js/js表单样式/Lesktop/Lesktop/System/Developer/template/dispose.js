////<br/>
////<pre class="sh_javascript">
function dispose(completeCallback, errorCallback)
{
	_dispose(completeCallback, errorCallback);
}

function _dispose(completeCallback, errorCallback)
{
	try
	{
		//卸载代码，卸载完成后必须调用completeCallback;
////[[CODE]]
////</pre>
////<div id="dispose" style="margin-left:[[ML:2]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">
	}
	catch (ex)
	{
		errorCallback(new Exception(ex.mame, ex.message));
	}
}
////</pre>