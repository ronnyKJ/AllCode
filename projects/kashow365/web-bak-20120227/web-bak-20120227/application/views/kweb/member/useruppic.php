<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="<?php echo base_url();?>kweb/js/jquery.js"></script>
<script src="<?php echo base_url();?>kweb/js/ImageCopper.js" type="text/javascript"></script>
<style type="text/css">
@charset "utf-8";
/*公共样式*/
body{margin:0;padding:0;}
.kauptxt1 {width:300px; height:auto;border:1px #b5b6b5 solid;background:#efefef;line-height:20px;color:#666;padding:3px;vertical-align:middle; margin:0;}
</style>
<script type="text/javascript">
function ShowValue(x,y,h,w,i){
	$("#x").val(x);$("#y").val(y);
	$("#w").val(w);$("#h").val(h);
}
</script>
</head>
<body>
<form id="test" action="<?php echo site_url("member/dosave");?>" method="post" target="_blank">
<!-- <input type="submit" value="test" /> -->
<input type="hidden" id="userId" name="userId" value="<?php echo $userId;?>" />
<input type="hidden" id="tempimage" name="tempimage" value="<?php echo $uploadedImage;?>" />
<input type="hidden" id="x" name="x" value="0" />
<input type="hidden" id="y" name="y" value="0" />
<input type="hidden" id="w" name="w" value="180" />
<input type="hidden" id="h" name="h" value="180" />
</form>
<div class="kauptxt1" style="overflow:hidden; width:300px;height:200px; ">
	<img src="<?php echo $this->config->item('UpPathAvatar').'temp/'.$uploadedImage;?>"
	 onload="$('#master').remove();$('#c').remove(); new ImageCopper(this,{MaxWidth: 120, MaxHeight: 27, Width: 180, Height:180, Locked : true,Left : 0, Top : 0},{Width:300,Height:200},function(x,y,w,h){ShowValue(x,y,w,h,2)});" 
	 style="border:thick #000000; margin:0;" />
</div>

</body>
</html>
