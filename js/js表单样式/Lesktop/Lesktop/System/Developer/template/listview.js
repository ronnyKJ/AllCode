////<pre class="sh_javascript">

var [[NAME]]_Config=[[CONFIG]];

[[NAME]]_Config.Columns=[[COLUMNS]];

function [[NAME]]_ListItem()
{
	var This=this;

////</pre>
////[[LIST_MEMBER]]
////<div id="[[FULLNAME]].ListItem.Member" style="margin-left:[[ML:1]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">
	
	this.GetText=function(columnName)
	{
////</pre>
////[[LIST_GETTEXT]]
////<div id="[[FULLNAME]].ListItem.GetText" style="margin-left:[[ML:2]]px; margin-top:0px; margin-bottom:0px;"></div>
////<pre class="sh_javascript">
	}
}

var [[NAME]] = new Controls.ListView([[NAME]]_Config);

////</pre>
////[[INIT]]
////<div id="[[FULLNAME]].Init" style="margin-left:[[ML:0]]px; margin-top:0px; margin-bottom:0px;"></div>