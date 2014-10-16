$(document).ready(function(){
	//绑定提交按钮
	$("#button").bind("click",function(){ doAction();});
	
	// verify
	$("#verify").bind("click",function(){
		timenow = new Date().getTime();
		$(this).attr("src",$(this).attr("src")+"?rand="+timenow);
	});
	$("#verify").bind("keypress",function(event){if(event.keyCode==13){doAction();}});
});

function doAction(){

	$("#idProcess").show();
	
	// 检查表单
	if(!$.formValidator.pageIsValid())
	{
		$("#idProcess").hide();
		return;
	}

	$(this).attr("disabled",true);
	$(".l").attr("disabled",true);
	$(".p").attr("disabled",true);
	$(".p2").attr("disabled",true);
	$(".e").attr("disabled",true);
	$(".v").attr("disabled",true);
	
	// set value
	if($("#t").val() == "手机、公司电话、住宅电话"){
		$("#t").val("");
	}
	if($("#r").val() == "可不填"){
		$("#r").val("");
	}
	
	//表单参数
	param = $("form").serialize();
	url = $("#form1").attr("action");
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				$("#msg").html(obj.info);
				$("#msg").oneTime(1000, function() {
				    $(this).html("");
				    location.href = obj.data;
				});
				$("#idProcess").hide();
			}
			else
			{
				$("#msg").html(obj.info);
				$("#msg").oneTime(500, function() {
				    // $("#button").removeAttr("disabled");
					document.getElementById("button").removeAttribute("disabled"); 
					$("#verify").click();
				});
				$("#idProcess").hide();
			}
		}
	});
}