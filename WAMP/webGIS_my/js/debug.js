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
			debug.content.innerHTML += msg+'<br>';
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
		this.print(msg+': '+l+'ms');
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
	addWatcher: function()
	{
		var watcher = this.createWindow("w_"+new Date()*1, 'Watch:');
		watcher.watch = function(msg)
		{
			this.content.innerHTML = msg;
		}
		return watcher;
	}
}