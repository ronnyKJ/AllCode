(function(){
	var form = document.getElementById("bookform");
	var title = document.getElementById("booktitle");
	form.onsubmit = function()
	{
		var reg = /[\\'"<>&\/]/i;
		if(reg.test(title.value) || !title.value)
		{
			alert('Book title connot be empty or contain \'"<>& or slash');
			return false;
		}
	}
})();