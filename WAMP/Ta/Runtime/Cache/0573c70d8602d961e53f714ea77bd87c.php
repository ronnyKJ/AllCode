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
<form method="POST" action="__URL__/say">
	<table>
		<tr>
			<td>我的名字 : <input type="text" name="myname" /></td>
			<td>TA的名字 : <input type="text" name="taname" /></td>
		</tr>
		<tr>
			<td>我的生日 : <input type="text" name="mybir" /></td>
			<td>TA的生日 : <input type="text" name="tabir" /></td>
		</tr>
	</table>
	我想对TA他说 :<br>
	<textarea name="content"></textarea>
	<br>
	<input type="submit" value="悄悄告诉TA"/>
</form>
</div>
 </body>
</html>