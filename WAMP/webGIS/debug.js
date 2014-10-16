Debug = 
{
	printer: 'doc',
	setPrinter: function(type)//console, alert or doc
	{
		this.printer = type;
	},
	createWindow: function(id, name)
	{
		var div = document.createElement('div');
		div.id=id;
		div.style.cssText = 'background:#EEE;border: 1px #AAA dashed; float: none; clear: both; margin-top: 20px;padding: 0 15px 30px;';
		div.innerHTML = '<h3>'+name+'</h3><div></div>';
		document.body.appendChild(div);
		var c = div.content = div.lastChild;
		return div;
	},
	print: function(msg)
	{
		var p = this.printer;
		if(p == 'doc')
		{
			var id = 'javascript_debugger';
			var debug = document.getElementById(id);
			if(!debug)
			{
				debug = this.createWindow(id, 'Debug log:');
			}
			
			debug.content.innerHTML = msg+ '<br>' + debug.content.innerHTML;
		}
		else if(p == 'console')
		{
			console.log(msg);
		}
		else
		{
			alert(msg);
		}
	},
	trace: function(msg, func)
	{
		var d = new Date()*1;
		func();
		var l = new Date()*1 - d;
		if(l>10)
			this.print(msg+': '+l+'ms');
		return l;
	},
	start: function()
	{
		this.timer = new Date()*1;
	},
	stop: function(msg)
	{
		this.print(msg+': '+(new Date()*1 - this.timer)+'ms');
	},
	log: function(msg)
	{
		this.print(msg);
	},
	timeStamp: function(msg)
	{
		this.print(msg+': ' + new Date()*1+'ms');
	},
	addWatcher: function(id)
	{
		var watcher = this.createWindow(id||"w_"+new Date()*1, 'Watch:');
		watcher.className='javascript_debug_watcher';
		watcher.watch = function(msg)
		{
			this.content.innerHTML = msg;
		}
		return watcher;
	},
	showDebuger: function()
	{
		$('#javascript_debugger').show();
		$('.javascript_debug_watcher').show();
	},
	hideDebuger: function()
	{
		$('#javascript_debugger').hide();
		$('.javascript_debug_watcher').hide();
	},
	addDebugerSwitch: function()
	{
		var ch = document.createElement('div');
		ch.id='debugerSwitch';
		ch.innerHTML = '<input type="checkbox" checked="checked"/> Show debuger';
		ch.style.cssText = 'position: absolute; left: 3px; bottom: 3px;';
		document.body.appendChild(ch);
		var self = this;
		$('#debugerSwitch input').click(function(){
			if($('#debugerSwitch input').attr('checked') == "checked")
				self.showDebuger();
			else
				self.hideDebuger();
		});
	}
}