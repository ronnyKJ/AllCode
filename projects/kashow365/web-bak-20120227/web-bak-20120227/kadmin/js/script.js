//全选
function CheckAll(tableID){
	$("#"+tableID).find(".key").attr("checked",$("#check").attr("checked"));
}
//排序
function sortBy(obja,order,by,tname){
	if(by=="a"){
		by="d";
	}else{
		by="a";
	}
	orderTalbe(order,by);
}
//得到多选项ID
function GetCheckedItems(){
	var idBox = $(".key:checked");
	if(idBox.length == 0)
	{
		alert("没有选中任何项!");
		return;
	}
 	var	idArray = new Array();
	$.each( idBox, function(i, n){
		idArray.push($(n).val());
	});
	return idArray.join("-");
}
//地区连动
function areaSelect(url,urbanId){
	//表单参数
	param = ""
	url = url+"/"+$("#district").val();
	$("#district").attr("disabled",true);
	$("#urban").attr("disabled",true);
	$("#urban").empty(); 
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
				$("#district").removeAttr("disabled");
				$("#urban").removeAttr("disabled");
			}
			
		},
		error: function(){
				$("#urban").append("<option value=''>请选择</option>"); 
				$("#district").removeAttr("disabled");
				$("#urban").removeAttr("disabled");
		}
	});
}