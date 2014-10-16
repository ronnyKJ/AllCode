<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>DayPics</title>
<link rel='stylesheet' type='text/css' href='__ROOT__/DayPics/css/pc.css'>
<script type="text/javascript">
var cur_url = "__URL__";
var web_root = "__ROOT__";
</script>
<script type="text/javascript" src="__ROOT__/DayPics/js/gallery.js"></script>
<script type="text/javascript">
function showImgs(){
	var list = document.getElementsByTagName("li");
	for(var i=0; i<list.length; i++)
	{
		list[i].onclick = function()
		{
			var src = this.firstChild.firstChild.src;
			var arr = src.split("/");
			src = src.replace(arr[arr.length-2], arr[arr.length-2]+"_big");
			playGallery(src);
		}
	}
}
</script>
</head>
<body onload="showImgs()">
<div id="header">
	<img id="logo" alt="DayPics" src="__ROOT__/DayPics/img/drawing-logo-text.png" />
	<span id="subheading" class="second_font">Drawing is nothing but a sprite of imagenation.</span>
	<p id="current_date"></p>
	<ul id="menu">
		<li><a href="__ROOT__/DayPics">Home</a></li>
		<li><a href="__APP__/Labs">Labs</a></li>
		<li><a href="__APP__/Drawing">Drawing</a></li>
		<li><a href="__APP__/About">About Me</a></li>
	</ul>
</div>
<div id="main">
<?php $c=1;?>
<?php if(is_array($img_list)): $i = 0; $__LIST__ = $img_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): ++$i;$mod = ($i % 2 )?><?php if($i == 1): ?><div class="category">
		<h1><span class="num"><?php echo ($c); ?></span><span class="foldername"><?php echo ($img["foldername"]); ?></span></h1>
		<ul>
			<li><span><img alt="" src="__ROOT__/DayPics/otherPics/drawing/<?php echo ($img["folder"]); ?>/<?php echo ($img["imgname"]); ?>" /></span><b class="label"><?php echo ($img["title"]); ?></b></li>
	<?php elseif(($img_list[$i-1]['folder'] == $img_list[$i-2]['folder'])): ?>
			<li><span><img alt="" src="__ROOT__/DayPics/otherPics/drawing/<?php echo ($img["folder"]); ?>/<?php echo ($img["imgname"]); ?>" /></span><b class="label"><?php echo ($img["title"]); ?></b></li>
	<?php elseif(($i > 1) AND ($img_list[$i-1]['folder'] != $img_list[$i-2]['folder'])): ?>
		</ul>
	</div>
	<div class="category">
		<h1><span class="num"><?php echo ++$c;?></span><span class="foldername"><?php echo ($img["foldername"]); ?></span></h1>
		<ul>
			<li><span><img alt="" src="__ROOT__/DayPics/otherPics/drawing/<?php echo ($img["folder"]); ?>/<?php echo ($img["imgname"]); ?>" /></span><b class="label"><?php echo ($img["title"]); ?></b></li>
	<?php elseif($i == count($img_list)): ?>
		</ul>
	</div><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
</div>

<div id="bottom" class="second_font">-- By Ronaldinho 2011 --</div>

</body>
</html>