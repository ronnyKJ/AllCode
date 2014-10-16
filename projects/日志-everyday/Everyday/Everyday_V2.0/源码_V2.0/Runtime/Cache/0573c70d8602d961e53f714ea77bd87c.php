<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Everyday</title>
<script type="text/javascript" src="__ROOT__/Everyday/js/jquery-1.3.2.js"></script>
<script type="text/javascript">
function changeCode()
{
	var timenow = new Date().getTime();
	$("#verifyImg").get(0).src= '__URL__/verify/'+timenow;
}
</script>
</head>
<body>
<form method='post' action="__URL__/login">
	<table>
		<tr><td>账号：</td><td><input id="account" type="text" name="account" /></td></tr>
		<tr><td>密码：</td><td><input id="password" type="password" name="password" /></td></tr>
		<tr><td>验证码：</td><td><input id="verify" type="text" name="verify" /><img id="verifyImg" alt="" src="__APP__/Index/verify/" /><a href="javascript:changeCode();">看不清楚，换一张</a></td></tr>
		<tr><td></td><td><input type="submit" value="登陆" /><input type="reset" value="重置" /><a href="__URL__/register">注册</a></td></tr>
	</table>
	<?php echo ($pswdError); ?><?php echo ($verifyError); ?>
</form>
 </body>
</html>