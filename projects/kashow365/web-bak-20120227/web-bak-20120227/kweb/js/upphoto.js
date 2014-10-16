$(document).ready(function(){
	$("#userfile").change(function() {
		//var fn = $("#userfile").val();
		//fn = fn.substring(fn.lastIndexOf('\\')+1,fn.length);
		//$("#filename").val(fn);
		
		$("#idProcess").show();
		$("#userfile").hide();
		$("#uploadForm").submit();
	});
	
	$("#save").click(function() {
		dosave();
	});
})