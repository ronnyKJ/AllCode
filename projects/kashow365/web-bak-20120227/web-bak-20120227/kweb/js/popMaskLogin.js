///////////////////////////////////////////////////////////////////////////////
//弹出层
function pupLogin(){
	$("#popMaskLogin").css({"display":"","height":document.documentElement.scrollHeight+"px"});
	$("#popBoxBodyLogin").css("display","");
	$("#popboxLogin").css("display","");
}
//关闭弹出层
function closeLayerLogin(){
document.getElementById("popMaskLogin").style.display = "none";
document.getElementById("popBoxBodyLogin").style.display = "none";
return false;
}


///////////////////////////////////////////////////////////////////////////////
//登录控件

function doActionLogin(){
	// set value
	if($("#lLogin").val() == "登录邮箱"){
		$("#lLogin").val("");
	}
	if($("#pLogin").val() == "**********"){
		$("#pLogin").val("");
	}
		
	// 检查表单
	if(!$.formValidator.pageIsValid())
	{
		alert(2);
		return;
	}

	$("#btnloginLogin").attr("disabled",true);
	
	//表单参数
	param = $("#formloginLogin").serialize();
	url = $("#formloginLogin").attr("action");
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			//alert(obj.status);
			if(obj.status)
			{
				$("#msgLogin").html(obj.info);
				$("#msgLogin").oneTime(1000, function() {
				    $("#msgLogin").html("");
					// $("#btnloginLogin").removeAttr("disabled");
					document.getElementById("btnloginLogin").removeAttribute("disabled"); 				
				    location.href = obj.data;
				 });
			}
			else
			{
				$("#msgLogin").html(obj.info);
				// $("#btnloginLogin").removeAttr("disabled");
				document.getElementById("btnloginLogin").removeAttribute("disabled"); 
			}
		}
	});
}
