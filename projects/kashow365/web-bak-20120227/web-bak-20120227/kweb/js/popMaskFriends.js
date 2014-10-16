///////////////////////////////////////////////////////////////////////////////
//弹出层
function pupFriends(){
	$("#popMaskFriends").css({"display":"","height":document.documentElement.scrollHeight+"px"});
	$("#popBoxBodyFriends").css("display","");
	$("#popboxFriends").css("display","");
}
//关闭弹出层
function closeLayerFriends(){
document.getElementById("popMaskFriends").style.display = "none";
document.getElementById("popBoxBodyFriends").style.display = "none";
return false;
}

function initdoFriends(){
	// 关闭层
	closeLayerFriends();
}