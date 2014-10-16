<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Everyday</title>
<link href="__ROOT__/Everyday/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="__ROOT__/Everyday/css/theme_1_blue.css" rel="stylesheet" type="text/css"/>
<link href="__ROOT__/Everyday/css/histogram.css" rel="stylesheet" type="text/css"/>
<link href="__ROOT__/Everyday/css/timePicker.css" rel="stylesheet" type="text/css"/>
<link href="__ROOT__/Everyday/css/tips.css" rel="stylesheet" type="text/css"/>
<link href="__ROOT__/Everyday/css/datePicker.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
var cur_url = "__URL__";
var cur_root = "__ROOT__/Everyday";
</script>
<script type="text/javascript" src="__ROOT__/Everyday/js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="__ROOT__/Everyday/js/statics.js"></script>
<script type="text/javascript" src="__ROOT__/Everyday/js/userAction.js"></script>
<script type="text/javascript" src="__ROOT__/Everyday/js/timePicker.js"></script>
<script type="text/javascript" src="__ROOT__/Everyday/js/tips.js"></script>
<script type="text/javascript" src="__ROOT__/Everyday/js/datePicker.js"></script>
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
	<?php if((count($list) != 0)): ?><ul id="eventList">	
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><?php if($i == 1): ?>﻿<li>
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
	<p class="overflow-auto setMrgnLft evtTime">起始时间: <?php echo ($vo["starttime"]); ?>-<?php echo ($vo["endtime"]); ?><span><?php echo ($vo["categoryname"]); ?>(<?php echo ($vo["count"]); ?>)</span></p>
	<p class="overflow-auto setMrgnLft"><span class="attrName"><?php echo ($vo["name"]); ?>: </span><span class="attrContent">﻿<?php
	if($list[$i-1]['ctrl_type']=="radiobutton")
	{
		$l = split(" ",$list[$i-1]['label']);
		$j = intval($list[$i-1]['content']); 
		for($q=0; $q<count($l); $q++)
		{
			if($j == $q)
			{
				echo '<input type="radio" disabled="true" checked="true" /><span class="rdSel">'.$l[$q]."</span>";
			}
			else
			{
				echo '<input type="radio" disabled="true" /><span class="rdunSel">'.$l[$q]."</span>";
			}
		}
	}
	else if($list[$i-1]['ctrl_type']=="checkbox")
	{
		$l2 = split(" ",$list[$i-1]['label']);
		$j2 = split(";",$list[$i-1]['content']);
		$flag = true;
		for($q2=0; $q2<count($l2); $q2++)
		{
			for($p2=0; $p2<count($j2)-1; $p2++)
			{
				if(intval($j2[$p2]) == $q2)
				{
					echo '<input type="checkbox" disabled="true" checked="true" /><span class="rdSel">'.$l2[$q2]."</span>";
					$flag = false;
					break;
				}
			}
			if($flag)
			{
				echo '<input type="checkbox" disabled="true" /><span class="rdunSel">'.$l2[$q2]."</span>";
			}
			$flag = true;
		}
	}
	else if($list[$i-1]['ctrl_type']=="select")
	{
		$l3 = split(" ",$list[$i-1]['label']);
		$j3 = intval($list[$i-1]['content']);
		echo $l3[$j3];
	}
	else if($list[$i-1]['ctrl_type']=="link")
	{
		echo '<a target="_blank" href="'.$list[$i-1]['content'].'">'.$list[$i-1]['content'].'</a>';
	}
	else
	{
		echo nl2br($list[$i-1]['content']);
	}
?></span></p>
		<?php elseif(($list[$i-1]['eventid'] != $list[$i-2]['eventid'])): ?>
		﻿<li>
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
	<p class="overflow-auto setMrgnLft evtTime">起始时间: <?php echo ($vo["starttime"]); ?>-<?php echo ($vo["endtime"]); ?><span><?php echo ($vo["categoryname"]); ?>(<?php echo ($vo["count"]); ?>)</span></p>
	<p class="overflow-auto setMrgnLft"><span class="attrName"><?php echo ($vo["name"]); ?>: </span><span class="attrContent">﻿<?php
	if($list[$i-1]['ctrl_type']=="radiobutton")
	{
		$l = split(" ",$list[$i-1]['label']);
		$j = intval($list[$i-1]['content']); 
		for($q=0; $q<count($l); $q++)
		{
			if($j == $q)
			{
				echo '<input type="radio" disabled="true" checked="true" /><span class="rdSel">'.$l[$q]."</span>";
			}
			else
			{
				echo '<input type="radio" disabled="true" /><span class="rdunSel">'.$l[$q]."</span>";
			}
		}
	}
	else if($list[$i-1]['ctrl_type']=="checkbox")
	{
		$l2 = split(" ",$list[$i-1]['label']);
		$j2 = split(";",$list[$i-1]['content']);
		$flag = true;
		for($q2=0; $q2<count($l2); $q2++)
		{
			for($p2=0; $p2<count($j2)-1; $p2++)
			{
				if(intval($j2[$p2]) == $q2)
				{
					echo '<input type="checkbox" disabled="true" checked="true" /><span class="rdSel">'.$l2[$q2]."</span>";
					$flag = false;
					break;
				}
			}
			if($flag)
			{
				echo '<input type="checkbox" disabled="true" /><span class="rdunSel">'.$l2[$q2]."</span>";
			}
			$flag = true;
		}
	}
	else if($list[$i-1]['ctrl_type']=="select")
	{
		$l3 = split(" ",$list[$i-1]['label']);
		$j3 = intval($list[$i-1]['content']);
		echo $l3[$j3];
	}
	else if($list[$i-1]['ctrl_type']=="link")
	{
		echo '<a target="_blank" href="'.$list[$i-1]['content'].'">'.$list[$i-1]['content'].'</a>';
	}
	else
	{
		echo nl2br($list[$i-1]['content']);
	}
?></span></p>
		<?php else: ?><p class="overflow-auto setMrgnLft"><span class="attrName"><?php echo ($vo["name"]); ?>: </span><span class="attrContent">﻿<?php
	if($list[$i-1]['ctrl_type']=="radiobutton")
	{
		$l = split(" ",$list[$i-1]['label']);
		$j = intval($list[$i-1]['content']); 
		for($q=0; $q<count($l); $q++)
		{
			if($j == $q)
			{
				echo '<input type="radio" disabled="true" checked="true" /><span class="rdSel">'.$l[$q]."</span>";
			}
			else
			{
				echo '<input type="radio" disabled="true" /><span class="rdunSel">'.$l[$q]."</span>";
			}
		}
	}
	else if($list[$i-1]['ctrl_type']=="checkbox")
	{
		$l2 = split(" ",$list[$i-1]['label']);
		$j2 = split(";",$list[$i-1]['content']);
		$flag = true;
		for($q2=0; $q2<count($l2); $q2++)
		{
			for($p2=0; $p2<count($j2)-1; $p2++)
			{
				if(intval($j2[$p2]) == $q2)
				{
					echo '<input type="checkbox" disabled="true" checked="true" /><span class="rdSel">'.$l2[$q2]."</span>";
					$flag = false;
					break;
				}
			}
			if($flag)
			{
				echo '<input type="checkbox" disabled="true" /><span class="rdunSel">'.$l2[$q2]."</span>";
			}
			$flag = true;
		}
	}
	else if($list[$i-1]['ctrl_type']=="select")
	{
		$l3 = split(" ",$list[$i-1]['label']);
		$j3 = intval($list[$i-1]['content']);
		echo $l3[$j3];
	}
	else if($list[$i-1]['ctrl_type']=="link")
	{
		echo '<a target="_blank" href="'.$list[$i-1]['content'].'">'.$list[$i-1]['content'].'</a>';
	}
	else
	{
		echo nl2br($list[$i-1]['content']);
	}
?></span></p><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
	<?php else: ?>还没添加事项...<?php endif; ?>
</div>
<div id="rightsidebar">
	<div id="categoryDiv">
		<h1>分类</h1>
		<?php if((count($cate) != 0)): ?><table>
			<?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate_count): ++$i;$mod = ($i % 2 )?><tr><td><span class="hidden"><?php echo ($cate_count["cid"]); ?></span><?php echo ($cate_count["categoryname"]); ?></td><td class="categoryCount">(<?php echo ($cate_count["count"]); ?>)</td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
		<?php else: ?><a href="__URL__/addCategory">添加分类</a><?php endif; ?>
	</div>
	<div id="addEvent">
		<h1>新增事项</h1>
		<?php if((count($cate) != 0)): ?><form id="eventForm" method='post' action="__URL__/insert">
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
					<td><input id="starttime" class="timePicker" type="text" name="starttime" autocomplete="off" /> - <input id="endtime" type="text" class="timePicker" name="endtime" autocomplete="off" /></td>
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
		<?php else: ?><?php endif; ?>
	</div>
</div>
</div>
<div id="footer">Copyright 2010 Ronnyzhang</div>
</div>
</body>
</html>