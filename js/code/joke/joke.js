(function(){
	var $J = window.$J = document.$J = function(selector){
		return new JokeObj(selector);
	};
	
	function JokeObj(sel)
	{
		var eles = document.querySelectorAll(sel);
		var i=0, l=eles.length;
		for(;i<l;i++)
		{
			this[i]=eles[i];
		}
		this.length = l;
	}
	
	JokeObj.prototype = {
		each : function(func, callback)
		{
			var i=0, l=this.length;
			for(;i<l;i++)
			{
				func(this[i]);
			}
			return callback?callback():this;
		},
		text : function(val)
		{
			var hasVal = function(ele){
				ele.innerText = val;
			};
			var str=[];
			var noVal = function(ele){
				str.push(ele.innerText);
			}; 
			if(val){
				return this.each(hasVal);
			}
			else{
				return this.each(noVal, function(){
					return str.join('\n');
				});
			}
		},
		css : function()
		{
			
		}
	};
})();

function init()
{
	alert($J("#list li").text('kkk'));
}
