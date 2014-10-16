<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Ta Say</title>
<link href="__ROOT__/Everyday/css/layout.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
var cur_url = "__URL__";
</script>
<script type="text/javascript" src="__ROOT__/Everyday/js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="__ROOT__/Everyday/js/userAction.js"></script>
</head>
<body>
<div>
<?php if(is_array($talk)): $i = 0; $__LIST__ = $talk;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): ++$i;$mod = ($i % 2 )?><?php echo ($t["MESSAGE_CONTENT"]); ?><br><?php endforeach; endif; else: echo "" ;endif; ?>
-=-==-==
</div>
 </body>
</html>