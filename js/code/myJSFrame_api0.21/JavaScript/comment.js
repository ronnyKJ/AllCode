// JavaScript Document
var a = "<a href='javascript:void(0)' class='comment' onclick='showCommentBox(this)'>发表评论</a>";
var obj = $("body h1")[0];
obj.innerHTML = a+obj.innerHTML;
function showCommentBox(obj){
	var rv = ""; // returnValue
	if($.Browse.isIE()){
		rv = window.showModalDialog("../comment.html?"+Math.random(),window,"dialogWidth:500px; dialogHeight:400px; help:0")
	}else{
		rv = window.open("../comment.html?"+Math.random(),"window","width=500px,height=400px,location=0,menubar=0,resizable=0,toolbar=0,modal=yes,left="+((window.screen.width/2-250)+"px")+",top="+((window.screen.height/2-200)+"px"));	
	}
}