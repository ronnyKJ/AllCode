<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>DayPics</title>
<link rel='stylesheet' type='text/css' href='__ROOT__/DayPics/css/pc.css'>
<link rel='stylesheet' type='text/css' href='__ROOT__/DayPics/css/clipboard.css'>
<link rel='stylesheet' type='text/css' href='__ROOT__/DayPics/css/clipboard_content.css'>
<script type="text/javascript">
var cur_url = "__URL__";
var web_root = "__ROOT__";
var date_list = [
	<?php if(is_array($date)): $i = 0; $__LIST__ = $date;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$date): ++$i;$mod = ($i % 2 )?>"<?php echo ($date["date"]); ?>",<?php endforeach; endif; else: echo "" ;endif; ?>
];
</script>
<script type="text/javascript" src="__ROOT__/DayPics/js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="__ROOT__/DayPics/js/clipboard_for_jquery.js"></script>
<script type="text/javascript" src="__ROOT__/DayPics/js/pc.js"></script>
</head>
<body>
<div id="header">
	<img id="logo" alt="DayPics" src="__ROOT__/DayPics/img/logo-text-100-1.png" />
	<span id="subheading" class="second_font">Every day is a sweet day.</span>
	<p id="current_date"></p>
	<ul id="menu">
		<li><a href="__ROOT__/DayPics">Home</a></li>
		<li><a href="__APP__/Labs">Labs</a></li>
		<li><a href="__APP__/Drawing">Drawing</a></li>
		<li><a href="__APP__/About">About Me</a></li>
	</ul>
</div>
<div id="main">
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): ++$i;$mod = ($i % 2 )?><img alt="" src="__ROOT__/DayPics/pics/<?php echo ($list["filename"]); ?>" width="1000" />
	<div class="word_container">
	<p class="words" pid="<?php echo ($list["id"]); ?>">
	<?php if(($list["words"] == '')): ?>...
	<?php else: ?><?php echo nl2br($list['words']); ?><?php endif; ?></p>
	</div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>

<div id="bottom" class="second_font">-- By Ronaldinho 2011 --</div>


<!--以下是clipboard的内容-->
<div id="login" class="clipboard_board" style="display: none;">
	<input id="command" type="password" class="green_iptbox" />
	<input id="getScript" class="green_btn" type="button" value="getScript" />
</div>

<div id="date" class="clipboard_board" style="display: none;">
<?php if(is_array($date_list)): $i = 0; $__LIST__ = $date_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$date_list): ++$i;$mod = ($i % 2 )?><a href="__URL__/pick_date/device/index/date/<?php echo ($date_list["date"]); ?>"><?php echo ($date_list["date"]); ?></a><br /><?php endforeach; endif; else: echo "" ;endif; ?>
</div>

<div id="upload" class="clipboard_board" style="display: none;">
	<form id="uploadForm" method="post" enctype="multipart/form-data">
		<input id="file" type="file" name="image" class="green_iptbox" />
		<input type="submit" value="Upload" class="green_btn" />
	</form>
</div>

</body>
</html>