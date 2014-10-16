////<br/>
////<pre class="sh_javascript">
function [[NAME]]()
{
	var This = this;
	var OwnerForm = this;
	
	var config = [[CONFIG]];
////</pre>
////[[CUSTOMCONFIG]]
////<div id="[[NAME]].CustomConfig" style="margin-left:[[ML:1]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">

	Window.call(This, config);

	var Base = {
		GetType: This.GetType,
		is: This.is
	};

	This.GetType = function() { return "[[NAME]]"; }
	This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
////</pre>
////[[CTRLS]]	
////<pre class="sh_javascript">

	var m_Task = null;
	if(config.HasMinButton)
	{
		m_Task=Taskbar.AddTask(This,IsNull(config.Title.InnerHTML,""));
		This.OnClosed.Attach(
			function()
			{
				Taskbar.RemoveTask(m_Task);
			}
		);
	}
////</pre>
////[[MEMBER]]
////<div id="[[NAME]].Member" style="margin-left:[[ML:1]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">
}
////</pre>