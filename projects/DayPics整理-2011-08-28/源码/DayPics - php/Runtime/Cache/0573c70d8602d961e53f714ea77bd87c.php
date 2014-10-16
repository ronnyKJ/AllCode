<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>DayPics</title>
<link rel='stylesheet' type='text/css' href='__ROOT__/css/pc.css'>
<link rel='stylesheet' type='text/css' href='__ROOT__/css/clipboard.css'>
<link rel='stylesheet' type='text/css' href='__ROOT__/css/clipboard_content.css'>
<script type="text/javascript">
var cur_url = "__URL__";
var web_root = "__ROOT__";
var date_list = [
	<?php if(is_array($date)): $i = 0; $__LIST__ = $date;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$date): ++$i;$mod = ($i % 2 )?>"<?php echo ($date["date"]); ?>",<?php endforeach; endif; else: echo "" ;endif; ?>
];
</script>
<script type="text/javascript" src="__ROOT__/js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="__ROOT__/js/clipboard_for_jquery.js"></script>
<script type="text/javascript" src="__ROOT__/js/pc.js"></script>
</head>
<body>
<div id="header">
	<img id="logo" alt="DayPics" src="__ROOT__/img/logo-text-100-1.png" />
	<span id="subheading">Every day is a sweet day.</span>
	<p id="current_date"></p>
</div>
<div id="main">
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): ++$i;$mod = ($i % 2 )?><img alt="" src="__ROOT__/pics/<?php echo ($list["filename"]); ?>" width="1000" />
	<div class="word_container">
	<p class="words" pid="<?php echo ($list["id"]); ?>">
	<?php if(($list["words"] == '')): ?>...
	<?php else: ?><?php echo nl2br($list['words']); ?><?php endif; ?></p>
	</div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>

<div id="bottom">-- By Ronaldinho 2011 --</div>


<!--以下是clipboard的内容-->
<div id="login" class="clipboard_board" style="display: none;">
	<input id="command" type="password" />
	<input id="getScript" type="button" value="getScript" />
</div>

<div id="date" class="clipboard_board" style="display: none;">
<?php if(is_array($date_list)): $i = 0; $__LIST__ = $date_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$date_list): ++$i;$mod = ($i % 2 )?><a href="__URL__/pick_date/device/index/date/<?php echo ($date_list["date"]); ?>"><?php echo ($date_list["date"]); ?></a><br /><?php endforeach; endif; else: echo "" ;endif; ?>
</div>

</body>
</html>