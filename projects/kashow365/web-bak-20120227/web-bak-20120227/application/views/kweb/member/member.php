<script src="<?php echo base_url();?>kweb/js/jquery.timer.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kweb/js/ESONCalendar.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	//绑定提交按钮
	$("#btnaf").bind("click",function(){ doFriend(this);});
});

function doFriend(btnobj){
	$("#button").attr("disabled",true);

	//表单参数
	param = "fuid=<?php echo $userId;?>";
	url = "<?php echo site_url('member/dofriends');?>";
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				alert(obj.info);
				$("#msg").html(obj.info);
				$("#button").oneTime(1000,"hide", function() {
					$("#msg").html("");
					// $("#button").removeAttr("disabled");
					document.getElementById("button").removeAttribute("disabled"); 
					var id=btnobj.id;
					$("#"+id).val("已关注");
					$("#"+id).attr("disabled","disabled");
				});
			}
			else
			{
				alert(obj.info);
				$("#msg").html(obj.info);
				// $("#button").removeAttr("disabled");
				document.getElementById("button").removeAttribute("disabled"); 
			}
		}
	});
}

function doAjaxForSale(url){
	var n=1;
	// 分离页面 '/index.php/member?n=2'
	var regExp = /n=(\d+)/ig;
	if(regExp.test(url)){
		regExp = /n=(\d+)/ig;
		n = regExp.exec(url)[1];
	}

	//表单参数
	var uid="<?php echo $userId;?>";
	param = "n="+n+"&uid="+uid;
	url = "<?php echo site_url("member/doajaxforsale/0");?>";
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			//alert(obj.status);
			if(obj.status)
			{
				$("#panForSale").empty();
				$("#panForSale").append(obj.data);
			}
			else
			{
				alert(obj.info);
			}
		}
	});
}
function doAjaxForShow(url){
	var n=1;
	// 分离页面 '/index.php/member?n=2'
	var regExp = /n=(\d+)/ig;
	if(regExp.test(url)){
		regExp = /n=(\d+)/ig;
		n = regExp.exec(url)[1];
	}

	//表单参数
	var uid="<?php echo $userId;?>";
	param = "n="+n+"&uid="+uid;
	url = "<?php echo site_url("member/doajaxforshow/0");?>";
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			//alert(obj.status);
			if(obj.status)
			{
				$("#panForShow").empty();
				$("#panForShow").append(obj.data);
			}
			else
			{
				alert(obj.info);
			}
		}
	});
}

</script>
<!-- first start -->
<br />
<div class="bigcont">
	<!-- left -->
    <div class="leftcont3">
    	<div class="memberphoto"><img src="<?php echo $userInfoData['kAvatarImage'];?>" /></div>
        <div class="midbut"><input class="seabut" id="btnaf" name="btnaf" type="button" value="加为关注" /></div>
		<div class="midbut2"><input onclick="pupInit('UserMsg')" class="seabut" name="" type="button" value="发消息" /></div>
		<?php if($userInfoData['QQ'] != ''){?>
		<div class="midbut2"><img src="http://wpa.qq.com/pa?p=1:<?php echo $userInfoData['QQ'];?>:1" alt="点击这里给我发消息"><//></div>
		<?php }?>
        <div class="kalist4 pdtop10">昵称：<?php echo $userInfoData['nickname'];?> 
		( 
		<?php if($userInfoData['kState']=='0'){?> <img src="<?php echo base_url();?>kweb/images/nook.png" alt="未验证" /> <?php }?> 
		<?php if($userInfoData['kState']=='1'){?> <img src="<?php echo base_url();?>kweb/images/ok.png" alt="已验证" /> <?php }?> 
		<?php if($userInfoData['kState']=='2'){?> <img src="<?php echo base_url();?>kweb/images/nook.png" alt="禁止登录" /> <?php }?> 
		)</div>
		<div class="kalist4">邮箱：<?php echo $userInfoData['kMail'];?></div>
		<div class="kalist4">生日：<?php echo $userInfoData['birthday'];?></div>
		<div class="kalist4">所在地区：<?php echo $userInfoData['area'];?></div>
		<div class="kalist4">拥有卡的数量：<?php echo $UserStatistics0;?> 张</div>
		<div class="kalist4">拥有卡的种类：<?php echo $UserStatistics1;?> 种</div>
		<div class="kalist4">QQ：<?php echo $userInfoData['QQ'];?></div>
		<div class="kalist4">手机：<?php echo $userInfoData['kTel'];?></div>
		<div class="kalist4">等级：<?php echo $userInfoData['gradeName'];?></div>
		<div class="kalist4">Ks币：<?php echo $userInfoData['kPoints'];?> Ks</div>
    </div>
    <!-- middle -->
    <div class="midcont3">
		<div class="midltab">
		<div class="katit1 marbot10"><!--<span><a href="<?php echo site_url('sale/rebat');?>">添加新卡</a></span>--><h3><a href="<?php echo site_url('sale/rebat');?>">买卖类</a></h3><div class="clear"></div></div>
        <div id="panForSale">
			<ul class="kaul19">
			<?php if($cardDataForSale!=null){foreach ($cardDataForSale as $row):?>
				<li><a href="<?php echo site_url('sale/rebatsale/'.$row['id']);?>" target="_blank"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a><div><a href="<?php echo site_url('sale/rebatsale/'. $row['id']);?>" title="<?php echo $row['name'];?>" target="_blank"><?php echo String::cut($row['name'],24);?></a></div><div><em>市场价 ￥<?php echo $row['price'];?></em></div><div><cite>售价 ￥<?php echo $row['sellingPrice'];?></cite></div><br /></li>
				<?php endforeach;}?>
			</ul><div class="clear"></div>
			<div class="position3">
			<?php
			#var_dump(array('total'=>$totalForSale,'perpage'=>$perpageForShow));
			$pageForSale=new page(array('total'=>$totalForSale,'perpage'=>$perpageForSale,'pagebarnum'=>2));
			$pageForSale->open_ajax('doAjaxForSale');
			echo $pageForSale->show(4);
			?>
			</div>
		</div>
		</div>
		<div class="midrtab">
		<div class="katit1 marbot10"><!--<span><a href="#">添加新卡</a></span>-->
		<h3><a href="#">展示类</a></h3>
		<div class="clear"></div></div>
		<div id="panForShow">
			<ul class="kaul19">
			<?php if($cardDataForShow!=null){foreach ($cardDataForShow as $row):?>
			<li><a href="<?php echo site_url('sale/rebatshow/'.$row['id']);?>" target="_blank"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a><div><a href="<?php echo site_url('sale/rebatshow/'. $row['id']);?>" title="<?php echo $row['name'];?>" target="_blank"><?php echo String::cut($row['name'],24);?></a></div><div><em>市场价 ￥<?php echo $row['price'];?></em></div><div><cite>售价 ￥<?php echo $row['sellingPrice'];?></cite></div><br /></li>
			<?php endforeach;}?>
			</ul><div class="clear"></div>
			<div class="position3">
				<?php
				#var_dump(array('total'=>$totalForSale,'perpage'=>$perpageForShow));
				$pageForShow=new page(array('total'=>$totalForShow,'perpage'=>$perpageForShow,'pagebarnum'=>2));
				$pageForShow->open_ajax('doAjaxForShow');
				echo $pageForShow->show(4);
				?>
			</div>
		</div>
		</div>
    </div>
    <!-- right -->
    <div class="rightcont3">
    	<div class="katit1"><h3>会员最新动态<em class="grayf">（仅显示最近时间的5条）</em></h3><div class="clear"></div></div>
        <div class="kalist4">
		<?php if(count($usernewsData) == 0){echo '暂无最新动态';}
			  else{?>
		<?php 
			foreach ($usernewsData as $row):
		?>
		<p>·<?php echo date("Y-m-d", strtotime($row['addDateTime']));?> <span class="bluef"> 		&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['newsContent'];?></span></p>
		<?php endforeach;?>
		<?php }?>
		</div>
		<div class="katit1 pdtop20"><h3>关注他的人</h3><a href="<?php echo site_url('member/more/mf?uid='.$userId);?>"><span style="padding-right:70px;">更多&gt;&gt;</span></a>
		<div class="clear"></div>
		</div>
		<ul class="kaul18 marbot10">
		<?php if(count($userFriendsData) == 0){echo '暂无好友';}
			  else{?>
		<?php foreach ($userFriendsData as $row):?>
		<li><a href="<?php echo site_url('member/other/'.$row['userId']);?>"><img src="<?php echo $row['mykAvatarImage'];?>" /></a><div><a href="<?php echo site_url('member/other/'.$row['userId']);?>"><?php echo $row['mynickname'];?></a></div></li>
		<?php endforeach;?>
		<?php }?>
		</ul>
		<div class="kalist4 pdtop10">
		<p>交易记录<span class="redf"><?php echo $UserStatistics2;?></span></p>
		<p>拼卡发起记录：<span class="redf"><?php echo $UserStatistics3;?></span></p>
		<p>兑换记录：<span class="redf"><?php echo $UserStatistics4;?> 次</span></p>
		</div>
  </div>
    <div class="clear"></div>
</div>
<!-- first end -->


