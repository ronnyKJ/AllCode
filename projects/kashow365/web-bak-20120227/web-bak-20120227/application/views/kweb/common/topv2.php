<script type="text/javascript" src="<?php echo base_url();?>kweb/js/MSClass.js"></script>
<script type="text/javascript">
var fv = "";
$(document).ready(function(){
	//绑定提交按钮
	$("#fv").focus( function(obj) { 
		fv=$("#fv").val();
		$("#fv").val("");
	}); 
	$("#fv").blur( function(obj) { 
		if($("#fv").val()=="")
			$("#fv").val(fv);
	}); 


	$("#ft").bind("click",function(){ initdoblogBlogMsg();});
	
	var marquee1 = new Marquee("marquee")	//此参数必选
	marquee1.Direction = "left";	//或者	marquee1.Direction = 0;
	marquee1.Step = 1;
	marquee1.Width = 560;
	marquee1.Height = 32;
	marquee1.Timer = 20;
	marquee1.DelayTime = 0;
	marquee1.WaitTime = 0;
	marquee1.ScrollStep = 52;
	marquee1.Start();
	$("#marquee").show();

});
function set(t){
	if(t==2){
		$("#pan1").html("<a href=\"javascript:void(0)\" onclick=\"set(1)\">按卡名称搜索</a>");
		//$("#pan1").removeClass("seanavr");
		//$("#pan1").addClass("seanavr");
		
		$("#pan2").html("<div class=\"tta\"><h3>按地区搜索</h3></div>");	
		//$("#pan2").removeClass("seanavr");
		//$("#pan2").addClass("seanavr");
		
		$("#fts").val(2);
		fv="请输入城市区域的名称";
		$("#fv").val(fv);
		
	}
	
	if(t==1){
		$("#pan1").html("<div class=\"tta\"><h3>按卡名称搜索</h3></div>");
		//$("#pan1").removeClass("seanavr");
		//$("#pan1").addClass("seanavr");

		$("#pan2").html("<a href=\"javascript:void(0)\" onclick=\"set(2)\">按地区搜索</a>");
		//$("#pan2").removeClass("seanavr");
		//$("#pan2").addClass("seanavr");
		$("#fts").val(1);
		fv="请输入卡的名称";
		$("#fv").val(fv);
	}
}
</script>
<!-- top start -->
<div class="bigcont1">
	<div class="topcont1"><span><a href="<?php echo site_url('info/novice');?>">积分兑换</a> | <a href="<?php echo site_url('info/help');?>">帮助中心</a> | <a href="javascript:void(0)" onClick="javascript:addCookie()">收藏卡秀</a> | <a href="javascript:void(0)" onclick="javascript:setHomepage();">设为首页</a></span>
	<?php if($userId==''){ ?>
		<h5>您好， 欢迎光临卡秀网！ <font class="redf"><a href="<?php echo site_url('login');?>">请登录</a></font>　<a href="<?php echo site_url('register');?>">免费注册</a>&nbsp;&nbsp;<a href="<?php echo site_url('login');?>">我的卡秀</a> 
	<?php }else{ ?>
		<h5>欢迎：<a href="<?php echo site_url('member');?>" title="<?php echo $loginedUserInfo['nickname']; ?>"><?php echo String::cut($loginedUserInfo['nickname'],10);?></a> 
		(
		<?php if($loginedUserInfo['kState']=='0'){?> <img src="<?php echo base_url();?>kweb/images/nook.png" alt="未验证" /><?php }?> 
		<?php if($loginedUserInfo['kState']=='1'){?> <img src="<?php echo base_url();?>kweb/images/ok.png" alt="已验证" /><?php }?> 
		<?php if($loginedUserInfo['kState']=='2'){?> <img src="<?php echo base_url();?>kweb/images/nook.png" alt="禁止登录" /><?php }?> 
		) <a href="<?php echo site_url("index/dologout");?>">退出</a> 会员等级：<?php echo $loginedUserInfo['gradeName'];?> 会员积分：<?php echo $loginedUserInfo['kPoints'];?> ks币 &nbsp;&nbsp;<a href="<?php echo site_url('member');?>">我的卡秀</a> 
	<?php } ?>
		　<a href="<?php echo site_url('info/novice');?>">网站导航<img src="<?php echo base_url();?>kweb/imagesv2/arrow2.gif" /></a>　<strong class="redf">在线客服QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=2205756010&site=qq&menu=yes" target="_blank" title="在线客服QQ">2205756010</a> </strong></h5></div>		<div class="clear"></div>
	<div class="logo"><img title="卡秀网" src="<?php echo base_url();?>kweb/imagesv2/kalogo.jpg"  onclick="location.href='<?php echo site_url('/');?>'" /></div>
	<div class="topmid"><ul><li><img src="<?php echo base_url();?>kweb/imagesv2/topr1.gif" /></li><li><img src="<?php echo base_url();?>kweb/imagesv2/topr2.gif" /></li><li class="noline"><img src="<?php echo base_url();?>kweb/imagesv2/topr3.gif" /></li></ul></div>
	<form action="<?php echo site_url('card/search');?>" method="get" target="_self">
	<div class="search">
		<ul>
			<li id="pan1"><div class="tta"><h3>按卡名称搜索</h3></div></li>
			<li id="pan2" class="seanavr"><a href="javascript:void(0)" onclick="set(2)">按地区搜索</a></li>
		</ul>
		<div class="botab">
			<div style="float:left;"><input type="text" class="seainput" id="fv" name="fv" value="请输入卡的名称" /> </div>
			<div style="float:left; padding-left:5px;"><input type="submit" class="seabut" value="搜 索" /></div>
			<input type="hidden" id="fts" name="fts" value="1" />
		</div>
	</div>
	</form>
	<div class="topnav">
	<div class="toprtab"><strong class="redf" style="float:left;">热门：</strong>
		<div>
		<?php if($shopData!=null){foreach ($shopData as $row):?>
		<img src="<?php echo base_url();?>kweb/images/li.gif"  /> <a href="<?php echo site_url('news/activity?shopId='.$row['id']);?>"><?php echo $row['shopName'];?></a>  
		<?php endforeach;}?>
		</div>
	</div>
	<ul>
	<?php if($currentTitle == 'index'){?>
	<li class="curnav" onclick="location.href='<?php echo site_url('index');?>'"><a href="<?php echo site_url('index');?>">首页</a></li>
	<?php }else{ ?>
	<li><a href="<?php echo site_url('index');?>"><font class="blankf2">首</font><font class="redf">页</font></a></li>
	<?php }?>
	
	<?php if($currentTitle == 'sale'){?>
	<li class="curnav" onclick="location.href='<?php echo site_url('sale');?>'"><a href="<?php echo site_url('sale');?>">有买有卖</a></li>
	<?php }else{ ?>
	<li><a href="<?php echo site_url('sale');?>"><font class="blankf2">有买</font><font class="bluef2">有卖</font></a></li>
	<?php }?>
	
	<?php if($currentTitle == 'spell'){?>
	<li class="curnav" onclick="location.href='<?php echo site_url('spell');?>'"><a href="<?php echo site_url('spell');?>">合伙拼卡</a></li>
	<?php }else{ ?>
	<li><a href="<?php echo site_url('spell');?>"><font class="blankf2">合伙</font><font class="bluef">拼卡</font></a></li>
	<?php }?>
	
	<?php if($currentTitle == 'gift'){?>
	<li class="curnav" onclick="location.href='<?php echo site_url('gift');?>'"><a href="<?php echo site_url('gift');?>">礼尚往来</a></li>
	<?php }else{ ?>
	<li><a href="<?php echo site_url('gift');?>"><font class="blankf2">礼尚</font><font class="yelf">往来</font></a></li>
	<?php }?>
	
	<?php if($currentTitle == 'life'){?>
	<li class="curnav" onclick="location.href='<?php echo site_url('life');?>'"><a href="<?php echo site_url('life');?>">生活广场</a></li>
	<?php }else{ ?>
	<li><a href="<?php echo site_url('life');?>"><font class="blankf2">生活</font><font class="greenf">广场</font></a></li>
	<?php }?>

	</ul>
	<div class="clear"></div>
	</div>
	<div class="topnavbot"><div class="ggao"><h4><img src="<?php echo base_url();?>kweb/imagesv2/icon_g.gif" /></h4>
		<div id="marquee" style="display:none;" >
			<?php if($heari!=null){foreach ($heari as $row):?>
			·<a href="<?php echo $row['value2'];?>"><?php echo $row['value1'];?></a>　
			<?php endforeach;}?>
		</div>
</div><h3><img src="<?php echo base_url();?>kweb/imagesv2/arrow3.gif" /> <a href="<?php echo site_url('news/activity');?>" target="">最新活动</a> <img src="<?php echo base_url();?>kweb/imagesv2/hot.gif" />　<img src="<?php echo base_url();?>kweb/imagesv2/arrow3.gif" /> 会员总数：<font class="redf">000<?php echo 18152+$webStatistics['WebTotcalUser'];?></font></h3></div>
<div class="clear"></div>
</div>
<!-- top end -->