///////////////////////////////////////////////////////////////////////////////
//弹出层
function pup(title){
	$("#popMask").css({"display":"","height":document.documentElement.scrollHeight+"px"});
	$("#popBox").css("display","");
	$("#"+title+"").css("display","");
}
//关闭弹出层
function closeLayer(){
document.getElementById("popMask").style.display = "none";
document.getElementById("popBox").style.display = "none";
return false;
}

///////////////////////////////////////////////////////////////////////////////
//弹出层
function pup2(title){
	$("#popMask2").css({"display":"","height":document.documentElement.scrollHeight+"px"});
	$("#popBox2").css("display","");
	$("#"+title+"").css("display","");
}
//关闭弹出层
function closeLayer2(){
document.getElementById("popMask2").style.display = "none";
document.getElementById("popBox2").style.display = "none";
return false;
}

//搜索下拉列表
$(function(){
	$(".xiala").click(function(){
		$(".pupZ").hide();
		$(".clik").removeClass("clikOver");
		$("iframe.yjb_navMask").remove();
		$(this).parent("div").css("position","relative");
		$(this).parents("div").children(".pupZ").show();
		$(this).parents("div").children(".clik").addClass("clikOver");
		$(this).parent("div").append("<iframe class='yjb_navMask' style='position:absolute;top:22px;left:-1px;z-index:8;' frameborder='0' scrolling='no'></iframe>");
		$(this).parents("div").children("iframe.yjb_navMask").width($(this).parents("div").children(".pupZ").outerWidth()); 
		$(this).parents("div").children("iframe.yjb_navMask").height($(this).parents("div").children(".pupZ").outerHeight());
		return false;
	});
	
	$(".pupZ").click(function(e){
		if(e.preventDefault) {
			e.stopPropagation();
		} else {
			e.cancelBubble=true;
		}
	});
	
	$(".pupZ .close").click(function(){
		$(this).parents(".pupZ").hide();
		$(".clik").removeClass("clikOver");
		$(".xiala").parent("div").css("position","static");
		$("iframe.yjb_navMask").remove();
	});
	
	$("html").click(function(e){
		if(e.target.getAttribute("class")!="pupZ" && e.target.getAttribute("class")!="xiala"){
			$(".pupZ").hide();
			$(".clik").removeClass("clikOver");
			$(".xiala").parent("div").css("position","static");
			$("iframe.yjb_navMask").remove();
		}
	});
	
	$(".memberdialog .text").click(function(){
		$(this).hide();
		$(this).parents(".memberdialog").find("div.operate").hide();
		$(this).parents(".memberdialog").find("textarea").show();
		$(this).parents(".memberdialog").find("p.bann").show();
		$(this).parents(".memberdialog").find("textarea").val($(this).find(".trend").html());
	});
	$(".memberdialog .banner2").click(function(){
		$(this).parents(".memberdialog").find("div.text").show();
		$(this).parents(".memberdialog").find("div.operate").show();
		$(this).parents(".memberdialog").find("textarea").hide();
		$(this).parents(".memberdialog").find("p.bann").hide();
		$(this).parents(".memberdialog").find("div.text span.trend").html($(this).parents(".memberdialog").find("textarea").val());
	});
	$(".memberdialog .banner3").click(function(){
		$(this).parents(".memberdialog").find("div.text").show();
		$(this).parents(".memberdialog").find("div.operate").show();
		$(this).parents(".memberdialog").find("textarea").hide();
		$(this).parents(".memberdialog").find("p.bann").hide();
	});
});

///////////////////////////////////////////////////////////////////////////////
// 加入收藏
function addCookie(){
 if (document.all){
       window.external.addFavorite('http://www.kashow365.com','卡秀网');
 }else if (window.sidebar){
       window.sidebar.addPanel('卡秀网', 'http://www.kashow365.com', "");
 }
}
// 设为首页
function setHomepage(){
 if (document.all){
	document.body.style.behavior='url(#default#homepage)';
	document.body.setHomePage('http://www.kashow365.com');
 }else if (window.sidebar){
    if(window.netscape){
		try{  
           netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");  
        }catch (e){
		    alert( "该操作被浏览器拒绝，如果想启用该功能，请在地址栏内输入 about:config,然后将项 signed.applets.codebase_principal_support 值该为true" ); 
		}
    }
    var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components. interfaces.nsIPrefBranch);
    prefs.setCharPref('browser.startup.homepage','http://www.kashow365.com');
 }
}


/**
* 回到页面顶部
* @param acceleration 加速度
* @param time 时间间隔 (毫秒)
**/
function goTop(acceleration, time) {
	acceleration = acceleration || 0.1;
	time = time || 16;
	var x1 = 0;
	var y1 = 0;
	var x2 = 0;
	var y2 = 0;
	var x3 = 0;
	var y3 = 0;
	if (document.documentElement) {
		x1 = document.documentElement.scrollLeft || 0;
		y1 = document.documentElement.scrollTop || 0;
	}
	if (document.body) {
		x2 = document.body.scrollLeft || 0;
		y2 = document.body.scrollTop || 0;
	}
	var x3 = window.scrollX || 0;
	var y3 = window.scrollY || 0;
	// 滚动条到页面顶部的水平距离
	var x = Math.max(x1, Math.max(x2, x3));
	// 滚动条到页面顶部的垂直距离
	var y = Math.max(y1, Math.max(y2, y3));
	// 滚动距离 = 目前距离 / 速度, 因为距离原来越小, 速度是大于 1 的数, 所以滚动距离会越来越小
	var speed = 1 + acceleration;
	window.scrollTo(Math.floor(x / speed), Math.floor(y / speed));
	// 如果距离不为零, 继续调用迭代本函数
	if(x > 0 || y > 0) {
		var invokeFunction = "goTop(" + acceleration + ", " + time + ")";
		window.setTimeout(invokeFunction, time);
	}
} 