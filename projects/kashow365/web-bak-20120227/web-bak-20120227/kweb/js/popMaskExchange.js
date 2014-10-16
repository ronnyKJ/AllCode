///////////////////////////////////////////////////////////////////////////////
//弹出层
function pupExchange(){
	$("#popMaskExchange").css({"display":"","height":document.documentElement.scrollHeight+"px"});
	$("#popBoxBodyExchange").css("display","");
	$("#popboxExchange").css("display","");
}
//关闭弹出层
function closeLayerExchange(){
document.getElementById("popMaskExchange").style.display = "none";
document.getElementById("popBoxBodyExchange").style.display = "none";
return false;
}


///////////////////////////////////////////////////////////////////////////////
//发送站内消息控件
function doExchange(){
	// 锁定表单控件
	$("#btndo").attr("disabled",true);
	$("#btnexit").attr("disabled",true);	

	//表单参数
	param = $("#formExchange").serialize();
	url = $("#formExchange").attr("action");
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			// alert(obj);
			if(obj.status)
			{
				$("#msg").html(obj.data);
				$("#aExchange1").hide();
				$("#aExchange2").show();
				// $("#btndo").removeAttr("disabled");
				document.getElementById("btndo").removeAttribute("disabled"); 
				// $("#btnexit").removeAttr("disabled");
				document.getElementById("btnexit").removeAttribute("disabled"); 
			}
			else
			{
				$("#msg").html(obj.data);
				$("#aExchange1").hide();
				$("#aExchange2").show();
				
				// 解锁定表单控件
				// $("#btndo").removeAttr("disabled");
				document.getElementById("btndo").removeAttribute("disabled"); 
				// $("#btnexit").removeAttr("disabled");
				document.getElementById("btnexit").removeAttribute("disabled"); 
			}
		}
	});
}
function initdoExchange(){
	// 解锁定表单控件
	$("#aExchange1").show();
	$("#aExchange2").hide();
	
	// 关闭层
	closeLayerExchange();
}