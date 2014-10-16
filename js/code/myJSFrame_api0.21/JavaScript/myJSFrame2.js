/*
*	My JavaScript Framework
*	Version	:	0.2.1.2
*	Author	:	misshjn
*	Email	:	misshjn@163.com
*	Home	:	http://www.happyshow.org/
*/
function $(){
	var elem = null;
	if(typeof arguments[0] !="string"){
		if(!arguments[0]){return null;}
		elem = arguments[0];
		if(!elem["version"]){
			$._Method.Element.apply(elem);
			if($._appendMethod){
				$._appendMethod.apply(elem);
			}
		}
		return elem;
	}
	var argID = arguments[0].trim();

	if(argID.indexOf(" ")==-1 && argID.indexOf(",")==-1 && argID.indexOf(".")==-1 && argID.indexOf("[")==-1 && argID.indexOf(">")==-1){
		elem = document.getElementById(argID.replace("#","")); 
		if(!elem){return null;}
		if(!elem["version"]){
			$._Method.Element.apply(elem);
			if($._appendMethod){
				$._appendMethod.apply(elem);
			}
		}
		return elem;
	}
	var path = argID.replace(/(^,*)|(,*$)/g,"").split(",");
	var allelem = [];
	for(var a=0,b; b=path[a]; a++){
		var p = b=path[a].trim().replace(/ +/g," ").split(" ");
		for (var i=0,q; q=p[i]; i++){
			if (q.indexOf("#")==0){
				elem = $(q.substring(1)); 
				continue;
			}
			var attsel = [];
			var elem_temp=[];
			if (q.indexOf(".")!=-1){
				var tags = q.replace(/\[.*?\]/gi,function($1){attsel.push($1.replace(/\[|\]/g,""));return "";});
				var tag = tags.split(".")[0];
				var cn = tags.split(".")[1];
				if (elem == null){
					elem_temp = $._find(tag,cn,arguments[1] || document);
				}else{
					if (elem instanceof Array){
						var arr = [];
						elem.each(function(obj){$._find(tag,cn,obj).each(function(){arr.push(arguments[0])});});						
						elem_temp = arr;
					}else{
						elem_temp = $._find(tag,cn,elem);
					}
				}
				elem = $._attributeSelector(attsel,elem_temp);
				continue;
			}else{
				var tag = q.replace(/\[.*?\]/gi,function($1){attsel.push($1.replace(/\[|\]/g,""));return "";});
				if(elem == null){
					elem_temp = $A((arguments[1] || document).getElementsByTagName(tag)).each(function(obj){$(obj)});
				}else{
					if (elem instanceof Array){
						var arr = [];
						elem.each(function(obj){$A(obj.getElementsByTagName(tag)).each(function(obj){arr.push($(obj))})});
						elem_temp = arr;
					}else{
						elem_temp = $A(elem.getElementsByTagName(tag)).each(function(obj){$(obj)});
					}
				}
				elem = $._attributeSelector(attsel,elem_temp);
			}
		}
		if(elem.constructor==Array){
			elem.each(function(obj){allelem.push(obj)});
		}else{
			allelem.push(elem);
		}
		elem = null;
	}
	return allelem;
};
$.Version = "0.2.1.2";
$._find = function(tag,cn,par){
	var arr = par.getElementsByTagName(tag||"*");
	var elem = [];
	for(var i=0,j; j=arr[i]; i++){
		if(j.className.hasSubString(cn," ")){elem.push($(j));}
	}
	return elem;
};
$._attributeSelector = function(attsel,elem_temp){
	for (var j=0; j<attsel.length; j++){
		var elemArr = [];
		var k=attsel[j].split(/=|!=/g);
		if(k.length==1){
			elem_temp.each(function(n){
				if(n.getAttribute(k[0].trim())){
					elemArr.push(n);
				}
			});
		}else if(k.length>1){
			elem_temp.each(function(n){
				if(attsel[j].indexOf("!=")!=-1){
					if(n.getAttribute(k[0].trim())!=k[1].trim()){
						elemArr.push(n);
					}
				}else{
					if(n.getAttribute(k[0].trim())==k[1].trim()){
						elemArr.push(n);
					}
				}
			});						
		}						
		elem_temp.length = 0;
		elem_temp = elemArr;
	}
	return elem_temp; 
};
function NameSpace(){};
function StringBuffer(){this.data = []};
$._Method = {
	Element	: function(){
		this.version = $.Version;
		this.hide = function(){this.style.display="none"; return this};
		this.show = function(){this.style.display=""; return this};
		this.getStyle = function(s){
			var value = this.style[s=="float"?($.Browse.isIE()?"styleFloat":"cssFloat"):s.camelize()];
			if (!value){
				if (this.currentStyle){
					value = this.currentStyle[s.camelize()];
				}else if (document.defaultView && document.defaultView.getComputedStyle){
					var css = document.defaultView.getComputedStyle(this, null);
					value = css ? css.getPropertyValue(s) : null;
				}
			}
			return value;
		};
		this.setStyle = function(s){
			var sList = s.split(";");
			for (var i=0,j; j=sList[i]; i++){
				var k = j.split(/:(?!\/\/)/g);
				var key = k[0].trim();
				key=key=="float"?($.Browse.isIE()?"styleFloat":"cssFloat"):key.camelize();
				this.style[key] = k[1].trim();
			}
			return this;
		};
		this.toggle = function(){this.getStyle("display")=="none"?this.show():this.hide(); return this};
		this.hasClassName = function(c){return this.className.hasSubString(c," ");};
		this.addClassName = function(c){if(!this.hasClassName(c)){this.className+=" "+c};return this};
		this.removeClassName = function(c){if(this.hasClassName(c)){this.className = (" "+this.className+" ").replace(" "+c+" "," ").trim(); return this}};
		this.toggleClassName = function(c){if(this.hasClassName(c)){this.removeClassName(c);}else{this.addClassName(c);};return this;};
		this.getElementsByClassName = function(c){return this.getElementsByAttribute("className",c)};
		this.getElementsByAttribute = function(n,v){
			var elems = this.getElementsByTagName("*");
			var elemList = [];
			for (var i=0,j; j=elems[i]; i++){
				var att = j[n] || j.getAttribute(n);
				if (att==v){
					elemList.push(j);
				}
			}
			return elemList;
		};
		this.subTag = function(){return $A(this.getElementsByTagName(arguments[0])).each(function(n){$(n);});};
		this.parentIndex = function(p){
			if (this==p){return 0}			
			for (var i=1,n=this; n=n.parentNode; i++){
				if(n==p){return i;}
				if(n==document.documentElement) return -1;
			}
		};
		this.remove = function(){
			return this.parentNode.removeChild(this);
		};
		this.nextElement = function(){
			var n = this;
			for (var i=0,n; n = n.nextSibling; i++){
				if(n.nodeType==1) return $(n);
			}
			return null;
		};
		this.previousElement = function(){
			var n = this;
			for (var i=0,n; n = n.previousSibling; i++){
				if(n.nodeType==1) return $(n);
			}
			return null;
		};
		this.subElem = function(css){
			return $(css,this);
		};
		this.findParent = function(p){
			for(var i=0,n=this; n=n.parentNode; i++){
				if(n==document.documentElement) break;
				var t = 0;
				for(var key in p){
					var m = n.key || n[key] || n.getAttribute(key);
					if(m!=p[key]){t++;break;}
				}
				if(t==0) return n;
			}
			return null;
		};
	},
	Array :	function(){
		this.indexOf = function(){
			for (i=0; i<this.length; i++){
				if (this[i]==arguments[0])
					return i;
			}
			return -1;
 	    };
		this.each = function(fn){
			for (var i=0,len=this.length; i<len; i++){
				fn(this[i],i);
			}
			return this;
		};
	},
	String : function(){
		this.trim = function(){
			var _re,_argument = arguments[0] || " ";
			typeof(_argument)=="string"?(_argument == " "?_re = /(^\s*)|(\s*$)/g : _re = new RegExp("(^"+_argument+"*)|("+_argument+"*$)","g")) : _re = _argument;
			return this.replace(_re,"");
		};
		this.stripTags = function(){
			return this.replace(/<\/?[^>]+>/gi, '');
		};
		this.cint = function(){
		    return this.replace(/\D/g,"")*1;
		};
		this.camelize = function(){
			return this.replace(/(-\S)/g,function($1){return $1.toUpperCase().substring(1,2)});
		};
		this.hasSubString = function(s,f){
			if(!f) f="";
			return (f+this+f).indexOf(f+s+f)==-1?false:true;
	    };
		this.hasSubStrInArr = function(){
			for(var i=0; i<arguments[0].length; i++){
				if(this.hasSubString(arguments[0][i])){return true;}
			}
			return false;
		};
		this.toXMLString = function(){
			var arr = this.split("&");
			var str = new StringBuffer();
			for (var i=0,len=arr.length; i<len; i++){
				var item = arr[i].split("=");
				str.append("<"+item[0]+"><![CDATA["+item[1]+"]]></"+item[0]+">");
			}
			var rootStr = arguments[0]?arguments[0]:"root";
			return "<"+rootStr+">"+str.toString()+"</"+rootStr+">";
		};
		this.format = function(){
			var p = arguments;
			return this.replace(/(\{\d+\})/g,function(){
				return p[arguments[0].replace(/\D/g,"")];
			});		
		};
		this.uniq = function(){			
			var arr = this.split("");
			var obj = {};
			for(var i=0,j; j=arr[i]; i++){
				obj[j] = i;
			}
			var s = [];
			for(var key in obj){
				s[obj[key]]=key;
			}
			return s.join("");
		};
	},
	Function : function(){
		this.bind = function() {
  			var __method = this, args = $A(arguments), object = args.shift();
  			return function() {
    			return __method.apply(object, args.concat($A(arguments)));
  			}
		};
	},
	StringBuffer : function(){
		this.append = function(){this.data.push(arguments[0]);return this};
		this.toString = function(){return this.data.join(arguments[0]||"")};
		this.length = function(){return this.data.length};
		this.clear = function(){this.data.length=0; return this;}
	},
	NameSpace : function(){
		this.copyChild = function(ns){
			for (var key in ns){
				this[key] = ns[key];
			}
			return this;
		};
	}
};

$._Method.Array.apply(Array.prototype);
$._Method.String.apply(String.prototype);
$._Method.Function.apply(Function.prototype);
$._Method.StringBuffer.apply(StringBuffer.prototype);
$._Method.NameSpace.apply(NameSpace.prototype);

$.Browse = {
	isIE : function(){return navigator.userAgent.hasSubString("MSIE");},
	isFF : function(){return navigator.userAgent.hasSubString("Firefox");},
	isOpera : function(){return navigator.userAgent.hasSubString("Opera")},
	isSafari : function(){return navigator.userAgent.hasSubString("Safari");},
	isGecko : function(){return navigator.userAgent.hasSubString("Gecko");},
	IEVer : function(){return $.Browse.isIE() ? parseInt(navigator.userAgent.split(";")[1].trim().split(" ")[1]) : 0;}
};
$(document);

var Ajax={
	xmlhttp:function (){
		var obj = null;	
		try{
			obj = new ActiveXObject('Msxml2.XMLHTTP');
		}catch(e){
			try{
				obj = new ActiveXObject('Microsoft.XMLHTTP');
			}catch(e){
				obj = new XMLHttpRequest();
			}
		}
		return Ajax.xmlObjCache = obj;
	},xmlObjCache:null
};
Ajax.Request=function (){
	if(arguments.length<2)return ;
	var para = {asynchronous:true,method:"GET",parameters:""};
	for (var key in arguments[1]){
		para[key] = arguments[1][key];
	}
	var _x= Ajax.xmlhttp(); //Ajax.xmlObjCache || 
	var _url=arguments[0];
	if(para["parameters"].length>0) para["parameters"]+='&_=';
	if(para["method"].toUpperCase()=="GET") _url+=(_url.match(/\?/)?'&':'?')+para["parameters"];
	_x.open(para["method"].toUpperCase(),_url,para["asynchronous"]);
	_x.onreadystatechange=Ajax.onStateChange.bind(_x,para);
	if(para["method"].toUpperCase()=="POST")_x.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	for (var ReqHeader in para["setRequestHeader"]){
		_x.setRequestHeader(ReqHeader,para["setRequestHeader"][ReqHeader]);
	}
	_x.send(para["method"].toUpperCase()=="POST"?(para["postBody"]?para["postBody"]:para["parameters"]):null);
	return _x;
};
Ajax.onStateChange = function(para){
	if(this.readyState==4){
		if(this.status==200)
			para["onComplete"]?para["onComplete"](this):"";
		else{
			para["onError"]?para["onError"](this):"";
		}
	}
};
$.Ajax = {
	Request : function(url,_method,para,complete,error){return Ajax.Request(url,{method:_method||"get",parameters:para||"",onComplete:complete,onError:error});},
	get	: function(url,complete,error){ return $.Ajax.Request(url+(url.indexOf("?")==-1?"?":"&")+Math.random(),"get","",complete,error); },
	post : function(url,para,complete,error){ return $.Ajax.Request(url,"post",para,complete,error);},
	update : function(url,id){ return $.Ajax.Request(url,(arguments[2]?"post":"get"),(arguments[2]?arguments[2]:Math.random()),function(x){if("INPUT,SELECT,BUTTON,TEXTAREA".hasSubString($(id).tagName,",")){$(id).value=x.responseText;}else{$(id).innerHTML=x.responseText;}});}
};
$.Cookies = {
    get : function(n){
	    var dc = "; "+document.cookie+"; ";
	    var coo = dc.indexOf("; "+n+"=");
	    if (coo!=-1){
		    var s = dc.substring(coo+n.length+3,dc.length);
		    return unescape(s.substring(0, s.indexOf("; ")));
	    }else{
		    return null;
	    }
    },
    set : function(name,value,expires,path,domain,secure){
        var expDays = expires*24*60*60*1000;
        var expDate = new Date();
        expDate.setTime(expDate.getTime()+expDays);
        var expString = expires ? "; expires="+expDate.toGMTString() : "";
        var pathString = "; path="+(path||"/");
		var domain = domain ? "; domain="+domain : "";
        document.cookie = name + "=" + escape(value) + expString + domain + pathString + (secure?"; secure":"");
    },
    del : function(n){
	    var exp = new Date();
	    exp.setTime(exp.getTime() - 1);
	    var cval=this.get(n);
	    if(cval!=null) document.cookie= n + "="+cval+";expires="+exp.toGMTString();
    }
};
$.Form = function(n){
	var f = typeof n =="string" ? document.forms[n] : n;
	$.Form._Method.apply(f);
	return f;
};
$.Form._Method = function(){
	this.serialize = function(obj){
			var arr = this.elements;
			var elem = {};
			for(var i=0,j; j=arr[i]; i++){
				if(j.disabled || !j.name){continue;}
				if(j.type && j.type.toLowerCase().hasSubStrInArr(["radio","checkbox"]) && !j.checked){continue;}
				var na = j.name.toLowerCase();
				if(typeof elem[na] == "undefined"){
					elem[na] = [];
				}
				elem[na].push($E(j.value));
			}
			return $.Form.serialize(obj,elem);
		};
};
$.Form.serialize = function(obj){
	var elem = arguments[1] || {};
	for(var key in obj){
		var na = key.toLowerCase();
		if(typeof elem[na] == "undefined"){
			elem[na] = [];
		}
		elem[na].push($E(obj[key]));
	}
	var para = new StringBuffer();
	for(var name in elem){
		for(var i=0; i<elem[name].length; i++){
			para.append(name+"="+elem[name][i]);
		}
	}
	return para.toString("&");
};

$.Request = function(paras){
	var url = location.search;
	if(!url.hasSubString("?")){return "";}else{url=url.substring(1);};
	var obj = {};
	url.split("&").each(function(p){
		var k = p.split("=");
		var n = k[0].toLowerCase();		
		obj[n] = k[1] || "";
	});
	return obj[paras.toLowerCase()];
};
$.Redirect = function(url,paraStr){
	if(!paraStr){
		location.href=url;
		return;
	}
	var obj = {};
	if(url.indexOf("?")!=-1){
		var s = url.substring(url.indexOf("?")+1).split("&");
		for(var i=0; i<s.length; i++){
			var j=s[i].split("=");
			obj[j[0].toString().toLowerCase()]=j[1]||"";
		}		
	}
	var t = paraStr.split("&");
	for(var i=0; i<t.length; i++){
		var j = t[i].split("=");
		obj[j[0].toString().toLowerCase()]=j[1]||"";
	}
	location.href=url.substring(0,url.indexOf("?"))+"?"+$.Form.serialize(obj);
};
$.Import = function(url){
	var myAjax = new Ajax.Request(
		url,
		{
			asynchronous:false,
			onComplete:function(x){
				var js = document.createElement("script");
				js.type = "text/javascript";
				js.defer = "defer";
				js.text = x.responseText;
				document.getElementsByTagName("head")[0].appendChild(js);			
			},
			onError:function(x){
				alert("loading script file occur an error:"+x.statusText);
			}
		}
	);
};
function $A(list){
	var arr = [];
	for (var i=0,len=list.length; i<len; i++){
		arr[i] = list[i];
	}
	return arr;
};
function $D(str){return decodeURIComponent(str);};
function $E(str){return encodeURIComponent(str);};
function $V(id){return $(id)?($(id).tagName.hasSubStrInArr(["INPUT","TEXTAREA","SELECT","BUTTON"])?$(id).value : $(id).innerHTML):"";};