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
});
function set(t){
	if(t==2){
		$("#pan1").html("<div class=\"h3\"><a href=\"javascript:void(0)\" onclick=\"set(1)\">按卡名称搜索</a></div>");
		$("#pan1").removeClass("clik");
		$("#pan1").addClass("seanavr");
		
		$("#pan2").html("<div class=\"tta\"><div class=\"h3\">按地区搜索</div></div>");	
		$("#pan2").removeClass("seanavr");
		$("#pan2").addClass("clik");
		
		$("#ft").val(2);
		fv="请输入城市区域的名称";
		$("#fv").val(fv);
		
	}
	
	if(t==1){
		$("#pan1").html("<div class=\"tta\"><div class=\"h3\">按卡名称搜索</div></div>");
		$("#pan1").removeClass("seanavr");
		$("#pan1").addClass("clik");

		$("#pan2").html("<a href=\"javascript:void(0)\" onclick=\"set(2)\">按地区搜索</a>");
		$("#pan2").removeClass("clik");
		$("#pan2").addClass("seanavr");
		$("#ft").val(1);
		fv="请输入卡的名称";
		$("#fv").val(fv);
	}
}
</script>
<!-- top start -->
<div class="bigcont">
	<div class="topcont1">
		<?php if($userId==''){ ?>
		<a href="<?php echo site_url('login');?>">登录</a> | 
		<a href="<?php echo site_url('register');?>">注册</a> | 
		<?php }else{ ?>
		欢迎您：<a href="<?php echo site_url('member');?>"><?php echo $loginedUserInfo['nickname'];?></a> 
		( 
		<?php if($loginedUserInfo['kState']=='0'){?> <img src="<?php echo base_url();?>kweb/images/nook.png" alt="未验证" /> <span style="color:#9d9d9d" >未验证</span> <?php }?> 
		<?php if($loginedUserInfo['kState']=='1'){?> <img src="<?php echo base_url();?>kweb/images/ok.png" alt="已验证" /> <span>已验证</span> <?php }?> 
		<?php if($loginedUserInfo['kState']=='2'){?> <img src="<?php echo base_url();?>kweb/images/nook.png" alt="禁止登录" /> <?php }?> 
		)
		<a href="<?php echo site_url("index/dologout");?>">退出</a>
		会员等级: <?php echo $loginedUserInfo['gradeName'];?>
		会员积分: <?php echo $loginedUserInfo['kPoints'];?> ks币 | 
		<?php } ?>
		<a href="#">帮助</a>　
		<img src="<?php echo base_url();?>kweb/images/kaicon1.gif" /> <a href="javascript:void(0)" onClick="javascript:addCookie()">收藏本站</a>　
		<img src="<?php echo base_url();?>kweb/images/kaicon2.gif" /> <a href="javascript:void(0)" onclick="javascript:setHomepage();">设为首页</a></div>
	<div class="logo"><img title="卡秀网" src="<?php echo base_url();?>kweb/images/kalogo.gif" onclick="location.href='<?php echo site_url('/');?>'"/></div>
	<div class="search">
		<form action="<?php echo site_url('card/search');?>" method="get" target="_self">
		<div class="clik" id="pan1">
			<div class="tta"><div class="h3">按卡名称搜索</div></div>
		</div>
		<div class="seanavr" id="pan2"><a href="javascript:void(0)" onclick="set(2)">按地区搜索</a></div>
		<div class="botab">
		<input type="text" class="seainput" id="fv" name="fv" value="请输入卡的名称" /> 
		<input type="submit" class="seabut" value="搜 索" />
		<input type="hidden" id="ft" name="ft" value="1" />
		</div>
		</form>
	</div>
	<div class="topnav">
	<ul>
	<?php if($currentTitle == 'index'){?>
	<li class="curnav" onclick="location.href='<?php echo site_url('index');?>'"><a href="<?php echo site_url('index');?>">首页</a></li>
	<?php }else{ ?>
	<li><a href="<?php echo site_url('index');?>"><font class="redf">首</font><font class="yelf">页</font></a></li>
	<?php }?>
	
	<?php if($currentTitle == 'sale'){?>
	<li class="curnav" onclick="location.href='<?php echo site_url('sale');?>'"><a href="<?php echo site_url('sale');?>">有买有卖</a></li>
	<?php }else{ ?>
	<li><a href="<?php echo site_url('sale');?>"><font class="redf">有买</font><font class="yelf">有卖</font></a></li>
	<?php }?>
	
	<?php if($currentTitle == 'spell'){?>
	<li class="curnav" onclick="location.href='<?php echo site_url('spell');?>'"><a href="<?php echo site_url('spell');?>">合伙拼卡</a></li>
	<?php }else{ ?>
	<li><a href="<?php echo site_url('spell');?>"><font class="redf">合伙</font><font class="bluef">拼卡</font></a></li>
	<?php }?>
	
	<?php if($currentTitle == 'gift'){?>
	<li class="curnav" onclick="location.href='<?php echo site_url('gift');?>'"><a href="<?php echo site_url('gift');?>">礼尚往来</a></li>
	<?php }else{ ?>
	<li><a href="<?php echo site_url('gift');?>"><font class="redf">礼尚</font><font class="greenf">往来</font></a></li>
	<?php }?>
	
	<?php if($currentTitle == 'life'){?>
	<li class="curnav" onclick="location.href='<?php echo site_url('life');?>'"><a href="<?php echo site_url('life');?>">生活广场</a></li>
	<?php }else{ ?>
	<li><a href="<?php echo site_url('life');?>"><font class="redf">生活</font><font class="grayf">广场</font></a></li>
	<?php }?>
	</ul>
	</div>
<div class="clear"></div>
</div>
<!-- top end -->