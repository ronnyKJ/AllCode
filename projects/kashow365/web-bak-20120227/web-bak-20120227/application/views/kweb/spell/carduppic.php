<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="<?php echo base_url();?>kweb/js/jquery.js"></script>
<script src="<?php echo base_url();?>kweb/js/ImageCopper.js" type="text/javascript"></script>
<style type="text/css">
@charset "utf-8";
/*公共样式*/
body,div,ul,ol,li,form,p,h1,h2,h3,h4,h5,h6,img{margin:0;padding:0;}
</style>
<script type="text/javascript">
function ShowValue(x,y,h,w,i){
	// document.getElementById("Demo" + i + "_Left").innerHTML = x;
	// document.getElementById("Demo" + i + "_Top").innerHTML = y;
	// document.getElementById("Demo" + i + "_Width").innerHTML = w;
	// document.getElementById("Demo" + i + "_Height").innerHTML = h;
	$("#x").val(x);$("#y").val(y);
	$("#w").val(w);$("#h").val(h);
}
</script>
</head>
<body>
<form id="test" action="<?php echo site_url("spell/dopreview");?>" method="post" target="_blank">
<!-- <input type="submit" value="test" /> -->
<input type="hidden" id="tempimage" name="tempimage" value="<?php echo $uploadedImage;?>" />
<input type="hidden" id="x" name="x" value="0" />
<input type="hidden" id="y" name="y" value="0" />
<input type="hidden" id="w" name="w" value="180" />
<input type="hidden" id="h" name="h" value="180" />
</form>
<!--
Left:<span id="Demo2_Left">0</span> 
Top:<span id="Demo2_Top">0</span> 
Width:<span id="Demo2_Width">0</span> 
Height:<span id="Demo2_Height">0</span><br />
-->
<div class="midbut" style="overflow:hidden; width:600px;height:326; ">
	<img alt="Demo2" src="<?php echo $this->config->item('UpPathCard').'temp/'.$uploadedImage;?>"
	 onload="$('#master').remove();$('#c').remove(); new ImageCopper(this,{MaxWidth: 227, MaxHeight: 83, Width: 372, Height:243, Locked : true,Left : 0, Top : 0},{Width:700,Height:700},function(x,y,w,h){ShowValue(x,y,w,h,2)});" 
	 style="border:thick #000000;" />
</div>
</body>
</html>
