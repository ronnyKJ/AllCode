<script src="<?php echo base_url();?>kweb/js/jquery.timer.js" type="text/javascript"></script>
<script type="text/javascript">
var uid = "<?php echo $userId;?>";

function doRegCard(){
	if(!confirm("确定要参加吗？"))
	{
		return;
	}

	//表单参数
	param = "";
	url = "<?php echo site_url('spell/doreg/'.$id);?>";
	$.ajax({ 
		type: "POST",
		url: url, 
		data: "dataType=json",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				//alert(obj.info);
				$("#msg").html(obj.info);
				$("#msg").oneTime(2000,"hide", function() {
					$("#msg").html("");
					location.reload();
				});
			}
			else
			{
				alert(obj.info);
				$("#msg").html(obj.info);
			}
		}
	});
}

function doExitRegCard(){
	if(!confirm("确定要退出吗？"))
	{
		return;
	}

	//表单参数
	param = "";
	url = "<?php echo site_url('spell/doexitreg/'.$id);?>";
	$.ajax({ 
		type: "POST",
		url: url, 
		data: "dataType=json",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				//alert(obj.info);
				$("#msg2").html(obj.info);
				$("#msg2").oneTime(2000,"hide", function() {
					$("#msg2").html("");
					location.reload();
				});
			}
			else
			{
				alert(obj.info);
				$("#msg2").html(obj.info);
			}
		}
	});
}

function dosendfriends(){
	if(!confirm("确定要把拼卡活动分享给全部好友吗？"))
	{
		return;
	}

	//表单参数
	param = "";
	url = "<?php echo site_url('spell/dosendfriends/'.$id);?>";
	$.ajax({ 
		type: "POST",
		url: url, 
		data: "dataType=json",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				alert(obj.info);
				$("#msg2").html(obj.info);
				$("#msg2").oneTime(2000,"hide", function() {
					$("#msg2").html("");
				});
			}
			else
			{
				alert(obj.info);
				$("#msg2").html(obj.info);
			}
		}
	});
}

function MyPupInit(){
	var url = "<?php echo current_url();?>";
	$("#umSystemAdd").val(" <a href=\""+url+"\" target=\"_blank\">点击查看拼卡</a>");
	pupInit('UserMsg');
}

$(document).ready(function(){
	//绑定提交按钮
	$("#formFriends").attr("action", "<?php echo site_url('spell/dosendfriend/'.$id);?>");
});
</script>
<!-- first start -->
<div class="bigcont">
	<div class="spexltab1">
		<ul class="kaul5">
		<li>
			<div class="lpic2"><img title="" src="<?php echo $cardData['cardImagePath'];?>" /></a></div>
			<div class="rtxt2">
				<p>发起人： <?php echo $cardData['nickname'];?></p>
				<p>意向人数： <font class="redf24"><?php echo $cardData['regCount'];?></font></p>
				<p>活动参与人数限制：<?php echo $cardData['limitUser'];?> 人： </p>
				<p>发起时间： <?php echo $cardData['startDate'];?></p>
				<p>结束时间： <?php echo $cardData['endDate'];?></p>			
				<p>发起事项：<font class="grayf"><?php echo $cardData['matter'];?></font></p>
			</div>
			<div class="botxt"><h4>活动特点：</h4><?php echo $cardData['characteristic'];?></div>
			<div class="botxt">
				<?php 
					$endDate = $cardData['endDate'];
					$endDate = str_replace("年","-",$endDate);
					$endDate = str_replace("月","-",$endDate);
					$endDate = str_replace("日","",$endDate);
				?>
				<?php if(Tools::IsOld($endDate) || $cardData['state']=='2'){?>
				<input class="seabut" type="button" value="活动结束" disabled="disabled"/>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php } else if($cardData['state']=='1'){?>
				<input class="seabut" type="button" value="已 满 员" disabled="disabled"/>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php } else {?>
				<?php 	if($IsMyRegedCard == 1){?>
				<input class="seabut" type="button" value="已 参 加" disabled="disabled"/>　&nbsp;&nbsp;&nbsp;&nbsp;
				<?php 	}else if($loginUserId != $cardData['userId']){ ?>
				<input class="seabut" type="button" value="我要参加" <?php if($userId!=''){echo 'onclick="doRegCard()"';	}else{ echo 'onclick="pupInit()"'; } ?> />&nbsp;&nbsp;&nbsp;&nbsp;
				<?php 	} ?>
				<?php } ?>
				<input class="seabut" type="button" value="发给好友" onclick="pupInit('Friends')" />
				<span id="msg"></span>
			</div>
		</li>
		</ul>
	<div class="clear"></div>
	</div>
	<div class="spexlrtab">
		<div class="memberphoto"><img src="<?php echo $userInfoData['kAvatarImage'];?>" /></div>
        <div class="kalist4 pdtop20"><strong>发起人信息</strong></div>
		<div class="kalist4 pdtop20">昵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称： <a href="<?php echo site_url('member/other/'.$userInfoData['id']);?>" target="_blank"><?php echo $userInfoData['nickname'];?></a></div>
		<div class="kalist4">等&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;级： <?php echo $userInfoData['gradeName'];?> </div>
		<div class="kalist4">积分ks币： <?php echo $userInfoData['kPoints'];?> </div>
		<div class="kalist4">联系方式： <?php echo $cardData['tel'];?> </div>
		<div class="kalist4">联系&nbsp;&nbsp;QQ： <?php echo $cardData['QQ'];?></div>
	</div><div class="clear"></div>	
	<div class="spexltab2">
		<h4>活动参与具体细则及注意事项：</h4>
		<p><?php echo $cardData['detail'];?></p>
		<p class="pdtop20">截止时间：  <strong class="redf"> <?php echo $cardData['endDate'];?></strong></p>
		<h4 class="pdtop10">报名名单如下：</h4>
		<p><?php if(count($regUserInfoData) != 0){?>
		<ul class="karul4" style="padding-left:30px;">
		<?php if($regUserInfoData!=null){foreach ($regUserInfoData as $row):?>
		<li><a href="<?php echo site_url('member/other/'.$row['regUserId']);?>"><img src="<?php echo $row['kAvatarImage'];?>" /></a><div><a href="<?php echo site_url('member/other/'.$row['regUserId']);?>"><?php echo $row['nickname'];?></a></div></li>
		<?php endforeach;}?>
		</ul>
		
		<?php }else{ ?>
		
			无 
		<?php } ?>
		</p>
		<p class="pdtop10">
		  <?php if($loginUserId != $cardData['userId']){?>
		  <input class="loginbut" type="button" value="私信发起人" onclick="MyPupInit()" />　
		  <?php } ?>
		  <?php if($IsMyRegedCard == '1'){?>
		  <input class="seabut" type="button" value="我要退出" onclick="doExitRegCard()" />　
		  <?php }?>
		  <input class="seabut" name="" type="button" value="分享好友" <?php if($userId!=''){echo 'onclick="dosendfriends()"';	}else{ echo 'onclick="pupInit()"'; } ?> />
		  <span id="msg2"></span>
		</p>
	</div>
<div class="clear"></div>
</div>
<!-- first end -->
