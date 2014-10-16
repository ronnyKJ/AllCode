$(function(){
	$(".words").click(function(){
		var id = $(this).attr('pid');
		$(this).after("<input id='edit' type='text' value='" + $(this).text() + "'>").hide();
		var p = $(this);
		$("#edit").focus().blur(function(){
			var ipt = $(this);
			$.ajax({
			   type: "POST",
			   url: cur_url + "/update_words",
			   data: "id=" + id + "&words=" + $("#edit").val(),
			   dataType: "text",
			   success: function(msg){
				 	p.text($("#edit").val()).show();
					ipt.remove();
			   }
			});
		});
	});
	
	$("#current_date").text(get_date());
	
	$("#left_btn").click(function(){
		set_url("left", date_list);
	});
	
	$("#right_btn").click(function(){
		set_url("right", date_list);
	});
	
	$("#current_date").toggle(
		function(){
			$("#mask, #pick_date").fadeIn();
			window.scrollTo(0,0);
		},
		function(){
			$("#mask, #pick_date").fadeOut();
		}
	);
});

//获取日期对应在数组的下标
function get_index(element, arr)
{
	for(var i=0; i<arr.length; i++)
	{
		if(element == arr[i])
		{
			return i;
		}
	}
	return -1;
}

//获取日期
function get_date()
{
	var arr = location.href.split("/");
	if(arr[arr.length-1] == "phone")
	{
		return date_list[0];
	}
	return arr[arr.length-1];
}

//跳转url
function set_url(direction, arr)
{
	var pre = get_index(get_date(), arr);
	if(direction == "left")
	{
		var post = Math.min(++pre, arr.length-1);
	}
	else
	{
		var post = Math.max(--pre, 0);
	}
	self.location = cur_url + "/pick_date/device/phone/date/" + arr[post];	
}