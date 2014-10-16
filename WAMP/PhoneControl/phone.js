/***************Phone******************/
$(function(){
	$(".button").click(function(){
		$.ajax({
		   type: "POST",
		   url: "server.php",
		   data: "p=phone",
		   dataType: "text",
		   success: function(msg){
				alert(msg);
		   }
		});
	});
})