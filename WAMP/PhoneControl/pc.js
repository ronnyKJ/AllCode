/***************PC******************/
$(function(){
	var com = false;
	//setInterval(function(){
	$(".object").click(function(){
		$.ajax({
		   type: "POST",
		   url: "server.php",
		   data: "com=" + com,
		   dataType: "text",
		   success: function(msg){
				alert(msg);
				if(msg == "do")
				{
					$(".object").width(200);
				}
				else
				{
					$(".object").width(100);
				}
		   }
		});
	});
//	}, 200);
})