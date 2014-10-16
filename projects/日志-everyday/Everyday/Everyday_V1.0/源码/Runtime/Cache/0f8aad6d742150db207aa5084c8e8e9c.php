<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Everyday</title>
<script type="text/javascript" src="__ROOT__/Everyday/js/jquery-1.3.2.js"></script>
<script type="text/javascript">
	function addAttr()
	{
		$("#add").before(
			'<tr>'+
				'<td><input type="text" name="name[]" /></td>'+
				'<td>'+
					'<select name="type[]">'+
						'<option value="textbox">文本框</option>'+
						'<option value="textarea">文本域</option>'+
						'<option value="radiobutton">单选</option>'+
						'<option value="checkbox">多选</option>'+
						'<option value="select">下拉列表</option>'+
						'<option value="file">文件</option>'+
					'</select>'+
				'</td>'+
				'<td><textarea name="label[]"></textarea></td>'+
				'<td><input type="checkbox" name="fill[]" checked="true" /></td>'+
				'<td><a href="javascript:;" onclick="delAttr(this)">删除</a></td>'+
			'</tr>'
		)
	}
	function delAttr(t)
	{
		$(t).parent().parent().remove()
	}
</script>
</head>
<body>
<?php echo ($username); ?><a href="__URL__/logout/">退出帐户</a><hr>
<h1>添加分类</h1>
<form id="addCategory" method='post' action="__URL__/addCateSubmit">
	<table>
		<tr><td>分类: </td><td><input type="hidden" name="userid" value="<?php echo ($userid); ?>" /><input type="text" name="categoryname" /></td></tr>
	</table>
	<hr>
	<h3>属性</h3>
	<table>
		<tr><td>属性名</td><td>类型</td><td>标签/默认值</td><td>必填项</td><td></td></tr>
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
		<tr id="add"><td><input type="button" value="再添一个" onclick="addAttr()"><input type="submit" value="确定"></td><td></td><td></td><td></td><td></td></tr>
	</table>
</form>
<a href="__URL__/index">返回</a>
 </body>
</html>