///////////////////////////////////////////////////////////////////////////////
//弹出层
function pupUserMsg(){
	$("#popMaskUserMsg").css({"display":"","height":document.documentElement.scrollHeight+"px"});
	$("#popBoxBodyUserMsg").css("display","");
	$("#popboxUserMsg").css("display","");
}
//关闭弹出层
function closeLayerUserMsg(){
document.getElementById("popMaskUserMsg").style.display = "none";
document.getElementById("popBoxBodyUserMsg").style.display = "none";
$("#StrLength-cUserMsg").text(120); 
return false;
}

function myPupInit(touid){
	// 设置收信者ID
	$("#touid").val(touid);
	//弹出窗
	pupInit('UserMsg');
}


///////////////////////////////////////////////////////////////////////////////
//发送站内消息控件
function domsg(){
	if($.trim($("#cUserMsg").val()) == ""){alert("人不能说空话");return;}
	
	// 锁定表单控件
	$("#btnUserMsg").attr("disabled",true);
	$("#cUserMsg").attr("readonly","readonly");
	$("#cUserMsg").addClass("disable");
	

	//表单参数
	param = $("#formUserMsg").serialize();
	url = $("#formUserMsg").attr("action");
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			// alert(obj);
			if(obj.status)
			{
				$("#msgUserMsg").html(obj.info);
				$("#msgUserMsg").oneTime(1000,"hide", function() {
					// 解锁定表单控件
					$("#msgUserMsg").html("");
					// $("#btnUserMsg").removeAttr("disabled");
					document.getElementById("btnUserMsg").removeAttribute("disabled"); 
					$("#btnUserMsg").hide();
					$("#closeUserMsg").show();
				});
				$("#msgUserMsg").oneTime(2000,"hide", function() {
					initdoUserMsg();
				});		
			}
			else
			{
				$("#msgUserMsg").html(obj.info);
				// 解锁定表单控件
				// $("#btnUserMsg").removeAttr("disabled");
				document.getElementById("btnUserMsg").removeAttribute("disabled"); 
				// $("#cUserMsg").removeAttr("disabled");
				document.getElementById("cUserMsg").removeAttribute("disabled"); 
				$("#cUserMsg").removeClass("disable");
			}
		}
	});
}
function initdoUserMsg(){
	// 解锁定表单控件
	$("#closeUserMsg").hide();
	// $("#btnUserMsg").removeAttr("disabled");
	document.getElementById("btnUserMsg").removeAttribute("disabled"); 
	$("#btnUserMsg").show();
	document.getElementById("cUserMsg").removeAttribute("readOnly"); 
	$("#cUserMsg").removeClass("disable");
	$("#cUserMsg").val("");
	
	// 关闭层
	closeLayerUserMsg();
}