///////////////////////////////////////////////////////////////////////////////
//弹出层
function pupStartSpell(){
	$("#popMaskStartSpell").css({"display":"","height":document.documentElement.scrollHeight+"px"});
	$("#popBoxBodyStartSpell").css("display","");
	$("#popboxStartSpell").css("display","");
}
//关闭弹出层
function closeLayerStartSpell(){
document.getElementById("popMaskStartSpell").style.display = "none";
document.getElementById("popBoxBodyStartSpell").style.display = "none";
return false;
}

function initdoStartSpell(){
	// 关闭层
	closeLayerStartSpell();
}