<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
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
<div id="content">
	<div id="chart">
		<h1>图表查询</h1>
		<div id="histogramContainer"></div>
	</div>
	<h1>事项列表</h1>
	<!--<table>
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
			<th>控件类型</th>
			<th>标签</th>
			<th></th>
			<th></th>
		</tr>-->
		<!--<td><?php echo ($i); ?>.</td>-->
		<!--<td><?php echo ($vo["id"]); ?></td>-->
		<!--<td><?php echo ($vo["uid"]); ?></td>-->
	<?php if((count($list) != 0)): ?><ul id="eventList">	
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><?php if(($list[$i]['eventid'] != $list[$i-1]['eventid']) OR ($i == 1)): ?><li>
			<span class="_attrCtId hidden"><?php echo ($vo["aid"]); ?></span>
			<span class="_evtId hidden"><?php echo ($vo["eventid"]); ?></span>
			<span class="_attrId hidden"><?php echo ($vo["attributeid"]); ?></span>
			<span class="_uid hidden"><?php echo ($vo["userid"]); ?></span>
			<span class="_ctgrId hidden"><?php echo ($vo["cid"]); ?></span>
			<span class="_ctgr hidden"><?php echo ($vo["categoryid"]); ?></span>
			<span class="_cnt hidden"><?php echo ($vo["count"]); ?></span>
			<span class="_ctrl hidden"><?php echo ($vo["ctrl_type"]); ?></span>
			<span class="_lbl hidden"><?php echo ($vo["label"]); ?></span>
			<span class="_date hidden"><?php echo ($vo["date"]); ?></span>
			<span class="_stTime hidden"><?php echo ($vo["starttime"]); ?></span>
			<span class="_edTime hidden"><?php echo ($vo["endtime"]); ?></span>
			<span class="_ctgrNm hidden"><?php echo ($vo["categoryname"]); ?></span>
			<span class="_attrNm hidden"><?php echo ($vo["name"]); ?></span>
			<span class="_attrCt hidden"><?php echo ($vo["content"]); ?></span>
			
			<div class="datePad">
				<div class="dateD"><?php echo substr($list[$i-1]['date'],8); ?></div>
				<div class="dateYM"><?php echo substr($list[$i-1]['date'],0,7); ?></div>
			</div>
			<span class="right operation"><a title="删除" class="delete" href="__URL__/deleteEvt/id/<?php echo ($vo["id"]); ?>"><i>删除</i></a></span>
			<span class="right operation"><a title="编辑" class="edit" href="javascript:;" onclick="edit(this,<?php echo ($vo["eventid"]); ?>)"><i>编辑</i></a></span>
			<h3 class="_title setMrgnLft evtTitle"><?php echo ($vo["title"]); ?></h3>
			<p class="setMrgnLft evtTime">起始时间: <?php echo ($vo["starttime"]); ?>-<?php echo ($vo["endtime"]); ?><span><?php echo ($vo["categoryname"]); ?>(<?php echo ($vo["count"]); ?>)</span></p>
			<p class="setMrgnLft"><span class="attrName"><?php echo ($vo["name"]); ?>: </span><span class="attrContent"><?php echo ($vo["content"]); ?></span></p>
		<?php else: ?><p class="setMrgnLft"><span class="attrName"><?php echo ($vo["name"]); ?>: </span><span class="attrContent"><?php echo ($vo["content"]); ?></span></p><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
	<?php else: ?>还没添加事件......<?php endif; ?>
</div>
<div id="rightsidebar">
	<div id="categoryDiv">
		<?php if((count($cate) != 0)): ?><h1>分类</h1>
		<table>
			<?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate_count): ++$i;$mod = ($i % 2 )?><tr><td><span class="hidden"><?php echo ($cate_count["cid"]); ?></span><?php echo ($cate_count["categoryname"]); ?></td><td class="categoryCount">(<?php echo ($cate_count["count"]); ?>)</td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
		<?php else: ?>暂无分类...<?php endif; ?>
	</div>
	<div id="addEvent">
		<h1>新增事项</h1>
		<?php if((count($cate) != 0)): ?><form method='post' action="__URL__/insert">
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
					<td><input id="starttime" type="text" name="starttime" /> - <input id="endtime" type="text" name="endtime" /></td>
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
					<td><input type="submit" value="确 定"> <input type="reset" value="清 空"> <a class="addEvt" href="javascript:addEvent();">新增事项</a></td>
				</tr>
			</table>
		</form>
		<?php else: ?><a href="__URL__/addCategory">添加分类</a><?php endif; ?>
	</div>
</div>
</div>
<div id="footer">Copyright 2010 Ronnyzhang</div>
</div>
</body>
</html>