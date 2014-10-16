_JSON=function(){
	var traversal = function(obj){
		var arr = [], t;
		if(obj instanceof Array){
			for(var i=0;i<obj.length; i++){			
				t = obj[i];
				if(typeof t != 'object'){
					var s = typeof t == 'string'?'"' + t + '"':t;
					arr.push(s);
				}
				else{
					arr.push(traversal(t));
				}				
			}
			return '['+arr.join(',')+']';
		}
		
		var str = [], tmp;
		for(var i in obj){
			tmp = obj[i];
			if(typeof tmp != 'object'){
				var s = typeof tmp == 'string'?'"' + tmp + '"':tmp;
				str.push('"'+i+'":'+s);
			}
			else{
				str.push('"'+i+'"'+':'+traversal(tmp));
			}
		}
		return '{'+str.join(',')+'}';
	};

	var _stringify = function(obj){
		switch(typeof obj){
			case 'string':
				return '"'+obj+'"';
			case 'number':
				return obj+'';
			case 'object':
				return traversal(obj);;
			default:
				alert('error');
		}
	};
	
	var _parse = function(str){
		eval('j=(' + str + ')');
		return j;
	};
	
	
	return {
		stringify: _stringify,
		parse: _parse
	}
}();