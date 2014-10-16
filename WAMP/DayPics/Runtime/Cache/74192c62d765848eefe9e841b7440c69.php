<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
<title>DayPics</title>
<link rel='stylesheet' type='text/css' href='__ROOT__/DayPics/css/phone.css'>
<script type="text/javascript">
var cur_url = "__URL__";
var date_list = [
	<?php if(is_array($date_list)): $i = 0; $__LIST__ = $date_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$date_list): ++$i;$mod = ($i % 2 )?>"<?php echo ($date_list["date"]); ?>",<?php endforeach; endif; else: echo "" ;endif; ?>
];
</script>
<script type="text/javascript" src="__ROOT__/DayPics/js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="__ROOT__/DayPics/js/phone.js"></script>
</head>
<body>
<div id="pic_container">
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): ++$i;$mod = ($i % 2 )?><img alt="" src="__ROOT__/DayPics/pics/<?php echo ($list["filename"]); ?>" width="100%" />
	<p class="words" pid="<?php echo ($list["id"]); ?>">
	<?php if(($list["words"] == '')): ?>...
	<?php else: ?><?php echo ($list["words"]); ?><?php endif; ?></p><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
<div id="bottom">
	<p id="left_btn"></p><p id="right_btn"></p>
	<p id="current_date"></p>
</div>
<div id="mask"></div>
<div id="pick_date">
	<?php if(is_array($date)): $i = 0; $__LIST__ = $date;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$date): ++$i;$mod = ($i % 2 )?><a href="__URL__/pick_date/device/phone/date/<?php echo ($date["date"]); ?>"><?php echo ($date["date"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
<div>
</body>
</html>