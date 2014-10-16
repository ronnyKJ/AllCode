///////////////////////////////////////////////////////////////////////////////
//弹出层
function pupBlogMsg(){
	$("#popMaskBlogMsg").css({"display":"","height":document.documentElement.scrollHeight+"px"});
	$("#popBoxBodyBlogMsg").css("display","");
	$("#popboxBlogMsg").css("display","");
}
//关闭弹出层
function closeLayerBlogMsg(){
document.getElementById("popMaskBlogMsg").style.display = "none";
document.getElementById("popBoxBodyBlogMsg").style.display = "none";
$("#StrLength-cBlogMsg").text(120); 
return false;
}
var isflash = false;

///////////////////////////////////////////////////////////////////////////////
//发送站内消息控件
function doblog(){
	if($.trim($("#cBlogMsg").val()) == ""){alert("人不能说空话");return;}
	
	// 锁定表单控件
	$("#btnBlogMsg").attr("disabled",true);
	$("#cBlogMsg").attr("readonly","readonly");
	$("#cBlogMsg").addClass("disable");
	

	//表单参数
	param = $("#formBlogMsg").serialize();
	url = $("#formBlogMsg").attr("action");
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			// alert(obj);
			if(obj.status)
			{
				$("#msgBlogMsg").html(obj.info);
				$("#btnBlogMsg").oneTime(1000,"hide", function() {
					// 解锁定表单控件
					$("#msgBlogMsg").html("");
					document.getElementById("btnBlogMsg").removeAttribute("disabled"); 
					$("#btnBlogMsg").hide();
					$("#closeBlogMsg").show();
				});
				$("#btnBlogMsg").oneTime(2000,"hide", function() {
					initdoblogBlogMsg();
				});										   
				isflash = true;
			}
			else
			{
				$("#msgBlogMsg").html(obj.info);
				// 解锁定表单控件
				document.getElementById("btnBlogMsg").removeAttribute("disabled"); 
				document.getElementById("cBlogMsg").removeAttribute("readOnly"); 
				// $("#cBlogMsg").removeAttr("disabled");
				document.getElementById("cBlogMsg").removeAttribute("disabled"); 
				$("#cBlogMsg").removeClass("disable");
			}
		}
	});
}
function initdoblogBlogMsg(){
	// 解锁定表单控件
	$("#closeBlogMsg").hide();
	// $("#btnBlogMsg").removeAttr("disabled");
	document.getElementById("btnBlogMsg").removeAttribute("disabled"); 
	$("#btnBlogMsg").show();
	document.getElementById("cBlogMsg").removeAttribute("readOnly"); 
	// $("#cBlogMsg").removeAttr("disabled");
	$("#cBlogMsg").removeClass("disable");
	$("#cBlogMsg").val("");
	
	//if(isflash){location.reload();}
	
	// 关闭层
	closeLayerBlogMsg();
}