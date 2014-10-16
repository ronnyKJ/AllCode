if (PageIndex){
	rtnDateString();
}
var chrsz=8;
var mode=32
var hexcase=1;var b64pad=""
function preprocess(A){var B="";B+=A.verifycode.value;B=B.toUpperCase();A.p.value=md5(md5_3(A.p.value)+B);return true}
function md5_3(B){var A=new Array;A=core_md5(str2binl(B),B.length*chrsz);A=core_md5(A,16*chrsz);A=core_md5(A,16*chrsz);return binl2hex(A)}
function core_md5(K,F){K[F>>5]|=128<<((F)%32);K[(((F+64)>>>9)<<4)+14]=F;var J=1732584193;var I=-271733879;var H=-1732584194;var G=271733878;for(var C=0;C<K.length;C+=16){var E=J;var D=I;var B=H;var A=G;J=md5_ff(J,I,H,G,K[C+0],7,-680876936);G=md5_ff(G,J,I,H,K[C+1],12,-389564586);H=md5_ff(H,G,J,I,K[C+2],17,606105819);I=md5_ff(I,H,G,J,K[C+3],22,-1044525330);J=md5_ff(J,I,H,G,K[C+4],7,-176418897);G=md5_ff(G,J,I,H,K[C+5],12,1200080426);H=md5_ff(H,G,J,I,K[C+6],17,-1473231341);I=md5_ff(I,H,G,J,K[C+7],22,-45705983);J=md5_ff(J,I,H,G,K[C+8],7,1770035416);G=md5_ff(G,J,I,H,K[C+9],12,-1958414417);H=md5_ff(H,G,J,I,K[C+10],17,-42063);I=md5_ff(I,H,G,J,K[C+11],22,-1990404162);J=md5_ff(J,I,H,G,K[C+12],7,1804603682);G=md5_ff(G,J,I,H,K[C+13],12,-40341101);H=md5_ff(H,G,J,I,K[C+14],17,-1502002290);I=md5_ff(I,H,G,J,K[C+15],22,1236535329);J=md5_gg(J,I,H,G,K[C+1],5,-165796510);G=md5_gg(G,J,I,H,K[C+6],9,-1069501632);H=md5_gg(H,G,J,I,K[C+11],14,643717713);I=md5_gg(I,H,G,J,K[C+0],20,-373897302);J=md5_gg(J,I,H,G,K[C+5],5,-701558691);G=md5_gg(G,J,I,H,K[C+10],9,38016083);H=md5_gg(H,G,J,I,K[C+15],14,-660478335);I=md5_gg(I,H,G,J,K[C+4],20,-405537848);J=md5_gg(J,I,H,G,K[C+9],5,568446438);G=md5_gg(G,J,I,H,K[C+14],9,-1019803690);H=md5_gg(H,G,J,I,K[C+3],14,-187363961);I=md5_gg(I,H,G,J,K[C+8],20,1163531501);J=md5_gg(J,I,H,G,K[C+13],5,-1444681467);G=md5_gg(G,J,I,H,K[C+2],9,-51403784);H=md5_gg(H,G,J,I,K[C+7],14,1735328473);I=md5_gg(I,H,G,J,K[C+12],20,-1926607734);J=md5_hh(J,I,H,G,K[C+5],4,-378558);G=md5_hh(G,J,I,H,K[C+8],11,-2022574463);H=md5_hh(H,G,J,I,K[C+11],16,1839030562);I=md5_hh(I,H,G,J,K[C+14],23,-35309556);J=md5_hh(J,I,H,G,K[C+1],4,-1530992060);G=md5_hh(G,J,I,H,K[C+4],11,1272893353);H=md5_hh(H,G,J,I,K[C+7],16,-155497632);I=md5_hh(I,H,G,J,K[C+10],23,-1094730640);J=md5_hh(J,I,H,G,K[C+13],4,681279174);G=md5_hh(G,J,I,H,K[C+0],11,-358537222);H=md5_hh(H,G,J,I,K[C+3],16,-722521979);I=md5_hh(I,H,G,J,K[C+6],23,76029189);J=md5_hh(J,I,H,G,K[C+9],4,-640364487);G=md5_hh(G,J,I,H,K[C+12],11,-421815835);H=md5_hh(H,G,J,I,K[C+15],16,530742520);I=md5_hh(I,H,G,J,K[C+2],23,-995338651);J=md5_ii(J,I,H,G,K[C+0],6,-198630844);G=md5_ii(G,J,I,H,K[C+7],10,1126891415);H=md5_ii(H,G,J,I,K[C+14],15,-1416354905);I=md5_ii(I,H,G,J,K[C+5],21,-57434055);J=md5_ii(J,I,H,G,K[C+12],6,1700485571);G=md5_ii(G,J,I,H,K[C+3],10,-1894986606);H=md5_ii(H,G,J,I,K[C+10],15,-1051523);I=md5_ii(I,H,G,J,K[C+1],21,-2054922799);J=md5_ii(J,I,H,G,K[C+8],6,1873313359);G=md5_ii(G,J,I,H,K[C+15],10,-30611744);H=md5_ii(H,G,J,I,K[C+6],15,-1560198380);I=md5_ii(I,H,G,J,K[C+13],21,1309151649);J=md5_ii(J,I,H,G,K[C+4],6,-145523070);G=md5_ii(G,J,I,H,K[C+11],10,-1120210379);H=md5_ii(H,G,J,I,K[C+2],15,718787259);I=md5_ii(I,H,G,J,K[C+9],21,-343485551);J=safe_add(J,E);I=safe_add(I,D);H=safe_add(H,B);G=safe_add(G,A)}if(mode==16){return Array(I,H)}else{return Array(J,I,H,G)}}
function md5(A){return hex_md5(A)}
function hex_md5(A){return binl2hex(core_md5(str2binl(A),A.length*chrsz))}

function md5_cmn(F,C,B,A,E,D){return safe_add(bit_rol(safe_add(safe_add(C,F),safe_add(A,D)),E),B)}
function md5_ff(C,B,G,F,A,E,D){return md5_cmn((B&G)|((~B)&F),C,B,A,E,D)}
function md5_gg(C,B,G,F,A,E,D){return md5_cmn((B&F)|(G&(~F)),C,B,A,E,D)}
function md5_hh(C,B,G,F,A,E,D){return md5_cmn(B^G^F,C,B,A,E,D)}
function md5_ii(C,B,G,F,A,E,D){return md5_cmn(G^(B|(~F)),C,B,A,E,D)}
function core_hmac_md5(C,F){var E=str2binl(C);if(E.length>16){E=core_md5(E,C.length*chrsz)}var A=Array(16),D=Array(16);for(var B=0;B<16;B++){A[B]=E[B]^909522486;D[B]=E[B]^1549556828}var G=core_md5(A.concat(str2binl(F)),512+F.length*chrsz);return core_md5(D.concat(G),512+128)}
function safe_add(A,D){var C=(A&65535)+(D&65535);var B=(A>>16)+(D>>16)+(C>>16);return(B<<16)|(C&65535)}
function bit_rol(A,B){return(A<<B)|(A>>>(32-B))}
function str2binl(D){var C=Array();var A=(1<<chrsz)-1;for(var B=0;B<D.length*chrsz;B+=chrsz){C[B>>5]|=(D.charCodeAt(B/chrsz)&A)<<(B%32)}return C}
function binl2hex(C){var B=hexcase?"0123456789ABCDEF":"0123456789abcdef";var D="";for(var A=0;A<C.length*4;A++){D+=B.charAt((C[A>>2]>>((A%4)*8+4))&15)+B.charAt((C[A>>2]>>((A%4)*8))&15)}return D}



/*站点ID*/

var siteid=1;
var global={
	browers:function(){
		str=navigator.userAgent.toLowerCase();
		if (str.indexOf('msie ')!==-1){
			re = /(msie [\d\.]+)/;
			re.exec(str);
			return RegExp.$1
		}
		if (str.indexOf('firefox/')!==-1){
			re=/(firefox\/[\d\.]+)/;
			re.exec(str);
			return RegExp.$1
		}
		if (str.indexOf('opera/')!==-1){
			re=/(opera\/[\d\.]+)/;
			re.exec(str);
			return RegExp.$1
		}
		return 'other';
	}
	,
	url:function(){
		return self.location.href.replace(self.location.href.split('/')[0]+'//'+self.location.href.split('/')[2],'');
	},
	ref:function(){
		sin='';
		if( document.referrer.split('/')[2]!=document.domain ) sin=document.referrer;
		return sin;
	},
	lg:function(){
		return navigator.systemLanguage;
	}
	,
	SetCookie:function(name, value) { 
		var exp = new Date(); 
		exp.setTime (exp.getTime()+3600000000); 
		document.cookie = name + "=" + value + "; expires=" + exp.toGMTString()+"; path=/"; 
	},
	getCookieVal:function(offset) { 
		var endstr = document.cookie.indexOf (";", offset); 
		if (endstr == -1) endstr = document.cookie.length; 
		return unescape(document.cookie.substring(offset, endstr)); 
	 },
	DelCookie:function(name){
		var exp = new Date();
		exp.setTime (exp.getTime() - 1);
		var cval = this.GetCookie (name);
		document.cookie = name + "=" + cval + "; expires="+ exp.toGMTString();
	},
	GetCookie:function(name) {
		var arg = name + "="; 
		var alen = arg.length; 
		var clen = document.cookie.length; 
		var i = 0; 
		while (i < clen) { 
			var j = i + alen; 
			if (document.cookie.substring(i, j) == arg) return this.getCookieVal (j); 
			i = document.cookie.indexOf(" ", i) + 1; 
			if (i == 0) break; 
		} 
		return null; 
	}
	,
	run:function(){
		b=this.browers();
		u=this.url();
		r=this.ref();
		lg=this.lg();
		//if (this.GetCookie('last'+siteid)!=escape(u)){
		var data='&lg='+escape(lg)+'&u='+escape(u)+'&r='+escape(r)+'&b='+b
		document.writeln('<img src="http://stat.haokan123.com/index.php?action=seTongji&sid='+siteid+data+'&time='+Math.random()+'" border=0 width=0 height=0>');
		//}
		//this.SetCookie('last'+siteid,escape(u));
	}
}
global.run();
