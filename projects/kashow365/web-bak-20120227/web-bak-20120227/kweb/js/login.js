$(document).ready(function(){
	//绑定提交按钮
	$("#button").bind("click",function(){ doAction();});
});

function doAction(){
	// set value
	if($("#l").val() == "登录邮箱"){
		$("#l").val("");
	}
	if($("#p").val() == "**********"){
		$("#p").val("");
	}
	
	// 检查表单
	if(!$.formValidator.pageIsValid())
	{
		return;
	}

	$(this).attr("disabled",true);
	

	
	//表单参数
	param = $("#form1").serialize();
	url = $("#form1").attr("action");
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			//alert(obj.status);
			if(obj.status)
			{
				$("#msg").html(obj.info);
				$("#msg").oneTime(1000, function() {
				    $(this).html("");
				    location.href = obj.data;
				 });
			}
			else
			{
				$("#msg").html(obj.info);
				$("#msg").oneTime(1000, function() {
				    // $("#button").removeAttr("disabled");
					document.getElementById("button").removeAttribute("disabled"); 
				 });
			}
		}
	});
	 // $("#button").removeAttr("disabled");
	 document.getElementById("button").removeAttribute("disabled"); 
}