///////////////////////////////////////////////////////////////////////////////
//弹出层
function pupManageSpell(){
	$("#popMaskManageSpell").css({"display":"","height":document.documentElement.scrollHeight+"px"});
	$("#popBoxBodyManageSpell").css("display","");
	$("#popboxManageSpell").css("display","");
}
//关闭弹出层
function closeLayerManageSpell(){
document.getElementById("popMaskManageSpell").style.display = "none";
document.getElementById("popBoxBodyManageSpell").style.display = "none";
return false;
}

function initdoManageSpell(){
	// 关闭层
	closeLayerManageSpell();
}