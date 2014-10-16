javascript:
function addS(src, callback){
	var oHead = document.getElementsByTagName('HEAD').item(0); 
	var oScript= document.createElement("script"); 
	oScript.type = "text/javascript"; 
	oScript.src = src; 
	oHead.appendChild(oScript);
	oScript.onload = function(){
		callback&&callback();
	};
}

addS('https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js', function(){
	addS('http://1.zhangkejing.sinaapp.com/test/jquery.qrcode.min.js', function(){
		jQuery(function(){
			var container = document.createElement('div');
			jQuery(container).qrcode(window.location.href);
			container.style.cssText = 'position:absolute;right:50px;top:20px;box-shadow: 4px 4px 20px #000;border: #FFF 9px solid;z-index:10000;';
			document.body.appendChild(container);
		})
	});
});
