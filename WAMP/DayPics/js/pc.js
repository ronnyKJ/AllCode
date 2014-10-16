var con = [
	{tab: "Pick date", board: "date"},
	{tab: "Login", board: "login"}
];

$(function(){
	$.clipboard("clipboard", con, "clipboard_board");
	
	$("#getScript").click(function(){
		$.ajax({
			   type: "POST",
			   url: cur_url + "/getScript",
			   data: "command="+$("#command").val(),
			   dataType: "script",
			   success: function(s)
			   {
					$("#clipboard #arrow span").click();
					$("#login").append("<img alt='' src='" + web_root + "/DayPics/img/done-text-20.png' style='margin-top: 80px;' />");
			   }
			});
	});
	
	$("#current_date").text(get_current_date());
});

function get_current_date()
{
	var arr = location.href.split("/");
	if(arr[arr.length-1].indexOf("-") < 0)
	{
		return date_list[0];
	}
	return arr[arr.length-1];	
}


/*----ajax--执行函数在php getScript()函数中，目前的问题是textarea自动多出空格和换行问题--*/
function get_script()
{
	$("#clipboard").addBoard({tab: "Upload", board: "upload"}, "clipboard_board");
	$(".words").click(function(){
		var id = $(this).attr("pid");
		$(this).after("<textarea id='edit' class='green_iptbox' cols='100' rows='3'>" + $.trim($(this).html().replace(/(<br>)/g, "\r\n")) + "</textarea>").hide();
		var p = $(this);
		$("#edit").focus().blur(function(){
			var ipt = $(this);
			$.ajax({
				type: "POST",
				url: cur_url + "/update_words",
				data: "id=" + id + "&words=" + $("#edit").val(),
				dataType: "text",
				success: function(msg){
					var str = $("#edit").val().replace(/\n/g, "<br />");
					if(str == "")
					{
						str = '...';
					}
					p.html($.trim(str)).show();
					ipt.remove();
				}});
			});
	});
	$("#command, #getScript").remove();
}