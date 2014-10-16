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
});