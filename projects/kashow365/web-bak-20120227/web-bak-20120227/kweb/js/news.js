//地区连动
function areaSelect(url,districtId, urbanId){
	//表单参数
	param = "";
	url = url+"/"+districtId;
	$("#district").attr("disabled",true);
	$("#urban").attr("disabled",true);
	$("#urban").empty(); 
	$("#shop").attr("disabled",true);
	//$("#shop").empty(); 
	//alert(url);
	$.ajax({ 
		url: url, 
		data: "",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				//alert(obj.data);
				$("#urban").append("<option value=''>请选择</option>"); 
				//循环取json中的数据,并呈现在列表中
				var json = obj.data;
				$.each(json,function(i,n){
					if(urbanId == json[i].id)
						$("#urban").append("<option value='"+json[i].id+"' selected='selected'>"+json[i].name+"</option>");
					else
						$("#urban").append("<option value='"+json[i].id+"'>"+json[i].name+"</option>");
				});
				// $("#district").removeAttr("disabled");
				// $("#urban").removeAttr("disabled");
				// $("#shop").removeAttr("disabled");
				document.getElementById("district").removeAttribute("disabled"); 
				document.getElementById("urban").removeAttribute("disabled"); 
				document.getElementById("shop").removeAttribute("disabled"); 
			}else
			{
				$("#urban").append("<option value=''>请选择</option>"); 
				// $("#district").removeAttr("disabled");
				// $("#urban").removeAttr("disabled");
				// $("#shop").removeAttr("disabled");
				document.getElementById("district").removeAttribute("disabled"); 
				document.getElementById("urban").removeAttribute("disabled"); 
				document.getElementById("shop").removeAttribute("disabled"); 

			}
			
		},
		error: function(){
				$("#urban").append("<option value=''>请选择</option>"); 
				// $("#district").removeAttr("disabled");
				// $("#urban").removeAttr("disabled");
				// $("#shop").removeAttr("disabled");
				document.getElementById("district").removeAttribute("disabled"); 
				document.getElementById("urban").removeAttribute("disabled"); 
				document.getElementById("shop").removeAttribute("disabled"); 
		}
	});
}

//地区连动商店
function urbanSelect(url,urbanId,shopId){
	//表单参数
	param = ""
	url = url+"/"+urbanId;
	$("#district").attr("disabled",true);
	$("#urban").attr("disabled",true);
	$("#shop").attr("disabled",true);
	$("#shop").empty(); 
	//alert(url);
	$.ajax({ 
		url: url, 
		data: "",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				//alert(obj.data);
				$("#shop").append("<option value=''>请选择</option>"); 
				$("#shop").oneTime(1000, function() {
	  				//循环取json中的数据,并呈现在列表中
					var json = obj.data;
					$.each(json,function(i,n){
						if(shopId == json[i].id)
							$("#shop").append("<option value='"+json[i].id+"' selected='selected'>"+json[i].shopName+"</option>");
						else
							$("#shop").append("<option value='"+json[i].id+"'>"+json[i].shopName+"</option>");
					});
					
					// $("#district").removeAttr("disabled");
					// $("#urban").removeAttr("disabled");
					// $("#shop").removeAttr("disabled");
					document.getElementById("district").removeAttribute("disabled"); 
					document.getElementById("urban").removeAttribute("disabled"); 
					document.getElementById("shop").removeAttribute("disabled"); 
				});
			}
			else
			{
				$("#shop").append("<option value=''>请选择</option>"); 
				// $("#district").removeAttr("disabled");
				// $("#urban").removeAttr("disabled");
				// $("#shop").removeAttr("disabled");
				document.getElementById("district").removeAttribute("disabled"); 
				document.getElementById("urban").removeAttribute("disabled"); 
				document.getElementById("shop").removeAttribute("disabled"); 
			}
			
		},
		error: function(){
				// $("#district").removeAttr("disabled");
				// $("#urban").removeAttr("disabled");
				// $("#shop").removeAttr("disabled");
				document.getElementById("district").removeAttribute("disabled"); 
				document.getElementById("urban").removeAttribute("disabled"); 
				document.getElementById("shop").removeAttribute("disabled"); 
		}
	});
}