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
		if(typeof str != 'string'){
			alert('parameter type error');
			return;
		}
		
		function ltrim(s){
			return s.replace(/^[\s]+/g, '');//trim left
		}
		
		function rtrim(s){
			return s.replace(/[\s]+$/g, '');//trim right
		}
		/* start: parsing function */
		function parseString(str){
			return str.replace(/"/g, '');
		}
		
		function parseObject(str){
			
		}
		
		function parseArray(str){
			str = str.replace(/^[\[]{1}/, '');
			str = str.replace(/[\]]{1}$/, '');
			var eles = str.split(',');//wrong way to split
			
			var arr=[], tmp;
			for(var i=0;i<eles.length;i++){
				tmp = eles[i];
				tmp = ltrim(tmp);
				tmp = rtrim(tmp);
				console.log(processType(tmp));
				arr.push(processType(tmp));
			}
			return arr;
		}
		
		function parseNumber(str){
			var n = Number(str);
			return isNaN(n)? "wrong!!!": n;
		}
		
		/* end: parsing function */
		
		function processType(str){
			var firstChar = str.substr(0,1);
			switch(firstChar){
				case '"':
					return parseString(str);
					break;
				case '{':
					return parseObject(str);
					break;
				case '[':
					return parseArray(str);
					break;
				default:				
					return parseNumber(str);
					break;
			}		
		}

		return processType(str);
	};
	
	
	return {
		stringify: _stringify,
		parse: _parse
	}
}();