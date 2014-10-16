<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>DayPics</title>
<link rel='stylesheet' type='text/css' href='__ROOT__/DayPics/css/pc.css'>
<link rel='stylesheet' type='text/css' href='__ROOT__/DayPics/css/widget/tips.css'>
<link rel='stylesheet' type='text/css' href='__ROOT__/DayPics/css/widget/datePicker.css'>
<link rel='stylesheet' type='text/css' href='__ROOT__/DayPics/css/widget/timePicker.css'>
<script type="text/javascript">
var cur_url = "__URL__";
var web_root = "__ROOT__";
</script>
<script type="text/javascript" src="__ROOT__/DayPics/js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="__ROOT__/DayPics/js/widget/tips.js"></script>
<script type="text/javascript" src="__ROOT__/DayPics/js/widget/datePicker.js"></script>
<script type="text/javascript" src="__ROOT__/DayPics/js/widget/timePicker.js"></script>
<script type="text/javascript">
function returnDate(date){
	$("#pickdate").val(date.getFullYear() + "年" + date.getMonth() + "月" + date.getDate() + "日");
	$("#pickdate").removeDate(400);
}

$(function(){
	$("#showTips").hover(function(){
		$(this).addTips({word: "This is the tips demo. I hope you enjoy it.", position: "bottom", margin: "0 0 0 20px"});
	});
	
	$("#pickdate").click(function(){
		$(this).pickDate();
	});
	
	//表格样式
	$(".api_table tr:odd td").css("background", "#F3F3F3");
})
</script>
</head>
<body>
<div id="header">
	<img id="logo" alt="DayPics" src="__ROOT__/DayPics/img/labs-logo-text.png" />
	<span id="subheading" class="second_font">Welcome to my laboratory.</span>
	<p id="current_date"></p>
	<ul id="menu">
		<li><a href="__ROOT__/DayPics">Home</a></li>
		<li><a href="__APP__/Labs">Labs</a></li>
		<li><a href="__APP__/Drawing">Drawing</a></li>
		<li><a href="__APP__/About">About Me</a></li>
	</ul>
</div>
<div id="main">
	<div class="lab_item">
		<img alt="" src="__ROOT__/DayPics/otherPics/lab/joke.jpg" />
		<h1><span class="num">1</span><span class="title">JOKE -- JavaScript Framework</span></h1>
		<div class="content">
			<h2 class="overview"></h2>
			<div class="con"><p class="indent">This is a javascript framework, Joke, shortly, JK. Welcome to use it!</p></div>
			<h2 class="demo"></h2>
			<div class="con"><p><a href="#">Click here</a> to see the demo. </p></div>
			<h2 class="api"></h2>
			<div class="con"></div>
			<h2 class="link"></h2>
			<div class="con"></div>
		</div>
	</div>
	<div class="lab_item">
		<img alt="" src="__ROOT__/DayPics/otherPics/lab/tips.jpg" />
		<h1><span class="num">2</span><span class="title">Tips -- A widget to guide the web user</span></h1>
		<div class="content">
			<h2 class="overview"></h2>
			<div class="con"><p class="indent">We need tips to help user browse the a web site in many cases. Here is a set of tips providing for developers. It
			offers a custom interface for customing the css style. Before using the tip widget, you have to import the jQuery in that this is a jQuery
			widget.</p></div>
			<h2 class="demo"></h2>
			<div class="con"><p><a id="showTips" href="#">Hover here</a> to see the tip under the bottom. </p></div>
			<h2 class="api"></h2>
			<div class="con">
				<p>The first step to get this tip show is to address a jQuery object, that is to locate where we show the tip, like $("#id").</p>
				<p>The way to use it is, i.e.: <b>$("#id").addTips({word: "Hello world!"})</b> .</p><br />
				<p><b>Methods:</b></p>
				<p>
					<table class="api_table" cellspacing="0">
						<tr><th>Name</th><th>Parameter</th><th>Function</th></tr>
						<tr><td>addTips</td><td>Object: specify the attributes<a href="#addTipsPara"><i>(details)</i></a></td><td>Add and show the tip attaching the jQuery object specified</td></tr>
						<tr><td>showTips</td><td>Number: duration</td><td>If the tips are not removed after fading out, this method is useful and to show it again</td></tr>
						<tr><td>hideTips</td><td>Number: duration</td><td>If the tips are not removed after fading out, this method is useful and to hide it when invoked</td></tr>
						<tr><td>removeTips</td><td>Number: duration</td><td>If the tips are not removed after fading out, this method is useful and to remove itself</td></tr>
					</table>
				</p><br /><br />
				<p id="addTipsPara"><b>Parameter of addTips() details:</b></p>
				<p>
					<table class="api_table" cellspacing="0">
						<tr><th>Name</th><th>Type</th><th>Specification</th></tr>
						<tr><td>width</td><td>Number</td><td>The width of the tip</td></tr>
						<tr><td>bgLeft</td><td>Number</td><td>Left location of the triangle's background image</td></tr>
						<tr><td>bgTop</td><td>Number</td><td>Left location of the triangle's background image</td></tr>
						<tr><td>margin</td><td>String</td><td>Adjust the whole tip location</td></tr>
						<tr><td>opacity</td><td>Number</td><td>The alpha of the tip background</td></tr>
						<tr><td>showDuration</td><td>Number</td><td>Time lasting during showing up</td></tr>
						<tr><td>hideDuration</td><td>Number</td><td>Time lasting during hiding off</td></tr>
						<tr><td>position</td><td>String</td><td>"top", "right", "bottom", "left" relative to the object</td></tr>
						<tr><td>rmv</td><td>Boolean</td><td>Remove or not after showing</td></tr>
					</table>
				</p>
			</div>
			<h2 class="link"></h2>
			<div class="con">
				<p><b>Link:</b></p><p class="indent">http://www.ronny-i.com/download/widget/tips.js</p><br />
				<p><b>Download:</b></p><p class="indent"><a href="#">Click here</a> to download it. </p>
			</div>
		</div>
	</div>
	<div class="lab_item">
		<img alt="" src="__ROOT__/DayPics/otherPics/lab/statics.jpg" />
		<h1><span class="num">3</span><span class="title">Statics -- Statics diagram for brilliant brains.</span></h1>
		<div class="content">
			<h2 class="overview"></h2>
			<div class="con"><p class="indent">This widget offer a way of generating statics diagrams or charts. You just initialize a container like 
			"div" or other kind you prefer. Then just invoke the method "schema", pass the parameter as needed. Now you have your own customing diagram
			to static your data. There are two types of mode, "histo" and "diagram". It sounds easy. Just have fun and enjoy it!</p></div>
			<h2 class="demo"></h2>
			<div class="con"><p><a href="__ROOT__/DayPics/demo/statics.html" target="_blank">Click here</a> to see the demo. </p></div>
			<h2 class="api"></h2>
			<div class="con">
				<p>The way to use it is, i.e.:<br /> var axis =[["一月",4,1,2,5], ["二月",1,1,1,9], ["三月",7,2,5,4], ["四月",5,3,4,2], ["五月",8,1,9,5], ["六月",2,5,3,3]];<br />
				$("#s1").schema({<br />
					<span style="margin-left: 30px;">type : 'histo',</span><br />
					<span style="margin-left: 30px;">event : axis,</span><br />
					<span style="margin-left: 30px;">items : ["足球","篮球","排球","冰球"],</span><br />
					<span style="margin-left: 30px;">diagramWidth : 2,</span><br />
					<span style="margin-left: 30px;">histoWidth : 5,</span><br />
					<span style="margin-left: 30px;">groupWidth : 20,</span><br />
					<span style="margin-left: 30px;">histoColor : ['#be1e2d', '#64669c', '#94d6ec', '#ee8310'],</span><br />
					<span style="margin-left: 30px;">canvasBgColor : 'transparent'</span><br />});</p><br />
				<p id="addTipsPara"><b>Parameter's attrbutes:</b></p>
				<p>
					<table class="api_table" cellspacing="0">
						<tr><th>Name</th><th>Type</th><th>Default</th><th>Specification</th></tr>
						<tr><td>event</td><td>Array</td><td>[]</td><td>横坐标数据</td></tr>
						<tr><td>items</td><td>Array</td><td>[]</td><td>分组项</td></tr>
						<tr><td>type</td><td>String</td><td>hitso</td><td>图表类型</td></tr>
						<tr><td>maxOutline</td><td>Boolean</td><td>false</td><td>是否分组边框描绘</td></tr>
						<tr><td>bgColor</td><td>String</td><td>#fffefa</td><td>柱状图背景色</td></tr>
						<tr><td>borderColor</td><td>String</td><td>#888</td><td>柱状图边框颜色</td></tr>
						<tr><td>borderWidth</td><td>Number</td><td>1</td><td>柱状图边框大小</td></tr>
						<tr><td>marginLeft</td><td>Number</td><td>60</td><td>柱状图左边距</td></tr>
						<tr><td>marginRight</td><td>Number</td><td>60</td><td>柱状图右边距</td></tr>
						<tr><td>marginBottom</td><td>Number</td><td>40</td><td>柱状图底边距</td></tr>
						<tr><td>marginTop</td><td>Number</td><td>40</td><td>柱状图顶边距</td></tr>
						<tr><td>width</td><td>Number</td><td>540</td><td>柱状图宽度</td></tr>
						<tr><td>height</td><td>Number</td><td>240</td><td>柱状图高度</td></tr>
						<tr><td>canvasBgColor</td><td>String</td><td>#DDD</td><td>画布背景颜色</td></tr>
						
						<tr><td>groupBorderColor</td><td>String</td><td>red</td><td>分组边框颜色</td></tr>
						<tr><td>groupBorderWidth</td><td>Number</td><td>0.1</td><td>分组边框宽度</td></tr>
						<tr><td>height</td><td>Number</td><td>240</td><td>柱状图高度</td></tr>
						
						<tr><td>maxGraduation</td><td>Number</td><td>10</td><td>最大刻度</td></tr>
						<tr><td>graduationLevel</td><td>Number</td><td>5</td><td>梯度</td></tr>
						<tr><td>graduationColor</td><td>String</td><td>#BBB</td><td>等高线颜色</td></tr>
						<tr><td>graduationWidth</td><td>Number</td><td>0.2</td><td>等高线粗细</td></tr>
						
						<tr><td>histoWidth</td><td>Number</td><td>['#ff4848', '#fff04a', '#49ffdf', '#4c48ff']</td><td>柱宽度</td></tr>
						<tr><td>histoColor</td><td>Array</td><td>10</td><td>柱颜色</td></tr>
						
						<tr><td>histoNoteWidth</td><td>Number</td><td>12</td><td>色块标记宽度</td></tr>
						<tr><td>histoNoteHeight</td><td>Number</td><td>10</td><td>色块标记高度</td></tr>
						<tr><td>histoNoteMarginLeft</td><td>Number</td><td>6</td><td>色块标记左边距</td></tr>
						<tr><td>histoNoteMarginRight</td><td>Number</td><td>8</td><td>色块标记右边距</td></tr>
						<tr><td>histoNoteMarginTop</td><td>Number</td><td>8</td><td>色块标记顶边距</td></tr>
						<tr><td>histoNoteMarginBottom</td><td>Number</td><td>8</td><td>色块标记底边距</td></tr>
						
						<tr><td>leftCharNum</td><td>Number</td><td>4</td><td>左侧文字字符个数</td></tr>
						<tr><td>bottomCharWidth</td><td>String</td><td>auto</td><td>底侧文字字符宽度</td></tr>
						<tr><td>leftWord</td><td>String</td><td>(单位)</td><td>左侧文字说明</td></tr>
						<tr><td>bottomWord</td><td>String</td><td>(阶段)</td><td>底侧文字说明</td></tr>
						<tr><td>leftWordMarginRight</td><td>Number</td><td>6</td><td>左侧文字右边距</td></tr>
						<tr><td>bottomWordMarginTopSpace</td><td>Number</td><td>10</td><td>底侧文字顶边距</td></tr>
						<tr><td>bottomWordMarginRight</td><td>Number</td><td>40</td><td>底侧文字右边距</td></tr>
					</table>
				</p>
			</div>
			<h2 class="link"></h2>
			<div class="con">
				<p><b>Link:</b></p><p class="indent">http://www.ronny-i.com/download/widget/statics.js</p><br />
				<p><b>Download:</b></p><p class="indent"><a href="#">Click here</a> to download it. </p>			
			</div>
		</div>
	</div>
	<div class="lab_item">
		<img alt="" src="__ROOT__/DayPics/otherPics/lab/datePicker.jpg" />
		<h1><span class="num">4</span><span class="title">DatePicker -- A useful date picker with Apple style mixed some of Windows 7.</span></h1>
		<div class="content">
			<h2 class="overview"></h2>
			<div class="con"><p class="indent">As some other date widget, this date picker help you to choose a date with graphical interface. What's more, its visual
			style is mix apple and Windows 7.</p></div>
			<h2 class="demo"></h2>
			<div class="con"><input id="pickdate" type="text" value="pick a date..." style="color: #AAA" class="green_iptbox" /> Click the input box to see the demo.</div>
			<h2 class="api"></h2>
			<div class="con">
				<p class="indent">The first step to get this tip show is to address a jQuery object, that is to locate where to show the date picker, like $("#id").</p>
				<p>The way to use it is, i.e.: <b>$("#id").pickDate()</b> .</p>
				<p>You have to close the date picker after a date is picked, the way like this: <b>$("#id").removeDate()</b> .</p><br />
				<p><b>Methods:</b></p>
				<p>
					<table class="api_table" cellspacing="0">
						<tr><th>Name</th><th>Parameter</th><th>Function</th></tr>
						<tr><td>pickDate</td><td>Object: specify the attributes (default NULL)<a href="#pickDatePara"><i>(details)</i></a></td><td>Show a calendar for choosing a date</td></tr>
						<tr><td>removeDate</td><td>Number: duration</td><td>After picking a date, remove the calendar</td></tr>
					</table>
				</p><br /><br />
				<p id="pickDatePara"><b>Parameter of pickDate() details:</b></p>
				<p>
					<table class="api_table" cellspacing="0">
						<tr><th>Name</th><th>Type</th><th>Default</th><th>Specification</th></tr>
						<tr><td>firstday</td><td>Number</td><td>0</td><td>The day of first day in a week, 0 for Sunday</td></tr>
						<tr><td>showDuration</td><td>Number</td><td>1</td><td>Duration showing up</td></tr>
						<tr><td>removeDuration</td><td>Number</td><td>1</td><td>Duration hiding off when click outside the panel</td></tr>
						<tr><td>autoClose</td><td>Boolean</td><td>true</td><td>Whether or not to close the panel when click outside the panel</td></tr>
					</table>
				</p>
			</div>
			<h2 class="link"></h2>
			<div class="con">
				<p><b>Link:</b></p><p class="indent">http://www.ronny-i.com/download/widget/datePicker.js</p><br />
				<p><b>Download:</b></p><p class="indent"><a href="#">Click here</a> to download it. </p>			
			</div>
		</div>
	</div>
	<div class="lab_item">
		<img alt="" src="__ROOT__/DayPics/otherPics/lab/timePicker.jpg" />
		<h1><span class="num">5</span><span class="title">TimePicker -- Sometimes we need a specify a moment, this is the tool.</span></h1>
		<div class="content">
			<h2 class="overview"></h2>
			<div class="con"><p class="indent">This is a tool that help you set the time when necessary. In some circumstances we need to set the clock when we are making a
			to-do list or something else. The time picker would be a good helper to offer you convenience. Keep this in your mind, time is money.</p></div>
			<h2 class="demo"></h2>
			<div class="con"><input class="timePicker green_iptbox" value="set the time" type="text" style="color: #AAA" /> Click the input box to see the demo.</div>
			<h2 class="api"></h2>
			<div class="con"><p>Comming soon...</p></div>
			<h2 class="link"></h2>
			<div class="con">
				<p><b>Link:</b></p><p class="indent">http://www.ronny-i.com/download/widget/timePicker.js</p><br />
				<p><b>Download:</b></p><p class="indent"><a href="#">Click here</a> to download it. </p>				
			</div>
		</div>
	</div>
</div>

<div id="bottom" class="second_font">-- By Ronaldinho 2011 --</div>

</body>
</html>