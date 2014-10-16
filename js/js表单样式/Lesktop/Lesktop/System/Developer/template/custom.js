////<pre class="sh_javascript">

////</pre>
////[[GLOBAL]]
////<div id="[[NAME]].Global" style="margin-left:[[ML:0]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">

function [[NAME]](config)
{
	var This = this;
	var OwnerForm = this;
	
////</pre>
////[[CUSTOMCONFIG]]
////<div id="[[NAME]].CustomConfig" style="margin-left:[[ML:1]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">
	
	var width = config.Width, height = config.Height;
	config.Width=[[WIDTH]];
	config.Height=[[HEIGHT]];

	[[BASE]].call(This, config);

	var Base = {
		GetType: This.GetType,
		is: This.is
	};

	This.GetType = function() { return "[[NAME]]"; }
	This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
////</pre>
////[[CTRLS]]	
////<pre class="sh_javascript">

////</pre>
////[[MEMEBER]]
////<div id="[[NAME]].Member" style="margin-left:[[ML:1]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">

	This.Resize(width,height);
}
////</pre>