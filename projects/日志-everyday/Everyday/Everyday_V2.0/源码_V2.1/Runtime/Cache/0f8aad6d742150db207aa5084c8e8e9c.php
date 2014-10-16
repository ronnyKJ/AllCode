<?php if (!defined('THINK_PATH')) exit();?><link href="__ROOT__/Everyday/css/pages.css" rel="stylesheet" type="text/css"/>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Everyday</title>
<link href="__ROOT__/Everyday/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="__ROOT__/Everyday/css/theme_1_blue.css" rel="stylesheet" type="text/css"/>
<link href="__ROOT__/Everyday/css/histogram.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
var cur_url = "__URL__";
</script>
<script type="text/javascript" src="__ROOT__/Everyday/js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="__ROOT__/Everyday/js/statics.js"></script>
<script type="text/javascript" src="__ROOT__/Everyday/js/userAction.js"></script>
</head>
<body>
<div id="container">
<div id="header"><span id="username"><?php echo ($username); ?></span><a href="__URL__/logout/">退出帐户</a></div>
<div id="middle">
<div id="menu">
	<ul>
		<li class="<?php echo ($home); ?>"><a href="__APP__/Event/index">首页</a></li>
		<li class="<?php echo ($requirement); ?>"><a href="__APP__/Pages/requirement">功能需求</a></li>
		<li class="<?php echo ($design); ?>"><a href="__APP__/Pages/design">系统设计</a></li>
		<li class="<?php echo ($teck); ?>"><a href="__APP__/Pages/teck">实现技术</a></li>
		<li class="<?php echo ($interact); ?>"><a href="__APP__/Pages/interact">交互设计</a></li>
		<li class="<?php echo ($visual); ?>"><a href="__APP__/Pages/visual">视觉设计</a></li>
		<li class="<?php echo ($ia); ?>"><a href="__APP__/Pages/ia">信息架构</a></li>
		<li class="<?php echo ($reuse); ?>"><a href="__APP__/Pages/reuse">代码重用</a></li>
		<li class="<?php echo ($detail); ?>"><a href="__APP__/Pages/detail">细节要点</a></li>
		<li class="<?php echo ($material); ?>"><a href="__APP__/Pages/material">参考文献</a></li>
		<li class="<?php echo ($back); ?>"><a href="__APP__/Pages/back">幕后花絮</a></li>
		<li class="<?php echo ($thank); ?>"><a href="__APP__/Pages/thank">鸣谢</a></li>
	</ul>
</div>
<h1>添加分类</h1>
<form id="addCategory" method='post' action="__URL__/addCateSubmit">
	<table id="addCateTbl">
		<tr><td class="tdName">分类名: </td><td><input type="hidden" name="userid" value="<?php echo ($userid); ?>" /><input type="text" name="categoryname" /></td></tr>
		<tr>
			<td class="tdName">属性: </td>
			<td>
				<table>
					<tr><th>属性名</th><th>类型</th><th>标签/默认值</th><th>必填项</th><th></th></tr>
					<tr>
						<td><input type="text" name="name[]" /></td>
						<td>
							<select name="type[]">
								<option value="textbox">文本框</option>
								<option value="textarea">文本域</option>
								<option value="radiobutton">单选</option>
								<option value="checkbox">多选</option>
								<option value="select">下拉列表</option>
								<option value="file">文件</option>
							</select>
						</td>
						<td><textarea name="label[]"></textarea></td>
						<td><input type="checkbox" name="fill[]" checked="true" /></td>
						<td><a href="javascript:;" onclick="delAttr(this)">删除</a></td>
					</tr>
					<tr id="add"><td><input type="button" value="再添一个" onclick="addAttr()" /><input type="submit" value="确定"></td><td></td><td></td><td></td><td></td></tr>
				</table>			
			</td>
		</tr>
	</table>
</form>
</div>
<div id="footer">Copyright 2010 Ronnyzhang</div>
</div>
</body>
</html>