<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Everyday</title>
<link href="__ROOT__/Everyday/css/histogram.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
var cur_url = "__URL__";
</script>
<script type="text/javascript" src="__ROOT__/Everyday/js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="__ROOT__/Everyday/js/statics.js"></script>
<script type="text/javascript" src="__ROOT__/Everyday/js/userAction.js"></script>
</head>
<body>
<?php echo ($username); ?><a href="__URL__/logout/">退出帐户</a>
<hr>
<div id="histogramContainer"></div>
<hr>
<form id="eventForm" method='post' action="__URL__/insert">
	<?php if((count($cate) != 0)): ?><a href="javascript:addEvent();">新增事件</a>
	<table cellpadding=2 cellspacing=2>
		<tr>
			<td>日期: </td>
			<td><input id="date" type="text" name="date" /></td>
		</tr>
		<tr>
			<td>标题: </td>
			<td><input id="title" type="text" name="title" /></td>
		</tr>
		<tr>
			<td>时间: </td>
			<td><input id="starttime" type="text" name="starttime" />-<input id="endtime" type="text" name="endtime" /></td>
		</tr>
		<tr id="cRow">
			<td>分类: </td>
			<td>
				<select id="category" name="category">
					<?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["cid"]); ?>"><?php echo ($item["categoryname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
				<a href="__URL__/addCategory">添加分类</a>
			</td>
		</tr>
		<tr><td></td><td id="attributes"></td></tr>
		<tr>
			<td>
				<input type="hidden" name="uid" id="uid" value="<?php echo ($userid); ?>" />
				<input type="hidden" name="eventid" id="eventid" />
			</td>
			<td><input type="submit" value="确 定"> <input type="reset" value="清 空"></td>
		</tr>
	</table>
	<?php else: ?><a href="__URL__/addCategory">添加分类</a><?php endif; ?>
	<hr>
	<table>
	<?php if((count($cate) != 0)): ?><?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate_count): ++$i;$mod = ($i % 2 )?><tr><td><?php echo ($cate_count["cid"]); ?></td><td><?php echo ($cate_count["categoryname"]); ?></td><td><?php echo ($cate_count["count"]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
	<?php else: ?>暂无分类......<?php endif; ?>
	</table>
	<hr>
	<?php if((count($list) != 0)): ?><table>
		<tr>
			<th>序号</th>
			<th>属性内容id</th>
			<th>事件id</th>
			<th>属性内容</th>
			<th>属性id</th>
			<th>事件id</th>
			<th>日期</th>
			<th>标题</th>
			<th>开始时间</th>
			<th>结束时间</th>
			<th>分类id</th>
			<th>用户id</th>
			<th>分类id</th>
			<th>用户id</th>
			<th>分类名</th>
			<th>分类事件数</th>
			<th></th>
			<th></th>
		</tr>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><tr>
				<td><?php echo ($i); ?>.</td>
				<td class="_attrCtId"><?php echo ($vo["aid"]); ?></td>
				<td class="_evtId"><?php echo ($vo["eventid"]); ?></td>
				<td class="_attrCt"><?php echo ($vo["content"]); ?></td>
				<td class="_attrId"><?php echo ($vo["attributeid"]); ?></td>
				<td><?php echo ($vo["id"]); ?></td>
				<td class="_date"><?php echo ($vo["date"]); ?></td>
				<td class="_title"><?php echo ($vo["title"]); ?></td>
				<td class="_stTime"><?php echo ($vo["starttime"]); ?></td>
				<td class="_edTime"><?php echo ($vo["endtime"]); ?></td>
				<td class="_ctgr"><?php echo ($vo["categoryid"]); ?></td>
				<td class="_uid"><?php echo ($vo["userid"]); ?></td>
				<td class="_ctgrId"><?php echo ($vo["cid"]); ?></td>
				<td><?php echo ($vo["uid"]); ?></td>
				<td class="_ctgrNm"><?php echo ($vo["categoryname"]); ?></td>
				<td class="_cnt"><?php echo ($vo["count"]); ?></td>
				<td><a href="javascript:;" onclick="edit(this,<?php echo ($vo["eventid"]); ?>)">编辑</a></td>
				<td><a href="__URL__/deleteEvt/id/<?php echo ($vo["id"]); ?>">删除</a></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	<?php else: ?>还没添加事件......<?php endif; ?>
	</table>
</form>
 </body>
</html>