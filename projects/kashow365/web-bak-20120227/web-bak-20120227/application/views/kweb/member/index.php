<script src="<?php echo base_url();?>kweb/js/jquery.timer.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kweb/js/ESONCalendar.js" type="text/javascript"></script>
<script type="text/javascript">
function doAjax(url){
	var n=1;
	// 分离页面 '/index.php/member?n=2'
	var regExp = /n=(\d+)/ig;
	if(regExp.test(url)){
		regExp = /n=(\d+)/ig;
		n = regExp.exec(url)[1];
	}

	//表单参数
	var uid="<?php echo $userId;?>";
	param = "uid="+uid+"&n="+n;
	url = "<?php echo site_url("member/doajaxumpage");?>";
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				$("#umdata").empty();
				$("#umdata").append(obj.data);
			}
			else
			{
				alert(obj.info);
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
	param = "n="+n+"&uid="+uid+"&isa=1";
	url = "<?php echo site_url("member/doajaxforsale/1");?>";
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
	param = "n="+n+"&uid="+uid+"&isa=1";
	url = "<?php echo site_url("member/doajaxforshow/1");?>";
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

$(document).ready(function(){
	//绑定提交按钮
	$("#btnUserInfo").bind("click",function(){ dosaveUserInfo();});
});

function dosaveUserInfo(){
	$("#btnUserInfo").attr("disabled",true);

	//表单参数
	param = $("#formUserInfo").serialize();
	url = $("#formUserInfo").attr("action");
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
				$("#btnUserInfo").oneTime(1000,"hide", function() {
					$("#msg").html("");
					//$("#btnUserInfo").removeAttr("disabled");
					document.getElementById("btnUserInfo").removeAttribute("disabled"); 
				});
				
			}
			else
			{
				alert(obj.info);
				$("#msg").html(obj.info);
				// $("#btnUserInfo").removeAttr("disabled");
				document.getElementById("btnUserInfo").removeAttribute("disabled"); 
			}
		}
	});
}

function ReMyupInit(re,touid){
	if(re!=""){
		$("#cUserMsg").val("回复@");
	}else{
		$("#cUserMsg").val("");
	}

	myPupInit(touid);
}


function doDelCard(cid,t){
	// 确认是否删除
	if(!confirm('确实要删除吗?')){
		return;
	}

	//表单参数
	var param = "cid="+cid+"&t="+t;
	url = "<?php echo site_url("sale/dodelcard");?>";
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				alert(obj.info);
				// 重新加载该分页
				if(t=="1"){
					doAjaxForSale(location.href+"?n=1");
				}
				if(t=="2"){
					doAjaxForShow(location.href+"?n=1");
				}
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
        <div class="midbut"><input onclick='javascript:window.location.href="<?php echo site_url("member/upphoto");?>"' class="seabut" name="" type="button" value="上传头像" /></div>
		<div class="midbut"><input onclick="pup2('popbox02')" class="seabut" name="" type="button" value="个人信息" /></div>
        <div class="kalist4" style="padding-top:5px;">昵 称： <?php echo $userInfoData['nickname'];?> 
		( 
			<?php if($userInfoData['kState']=='0'){?> <img src="<?php echo base_url();?>kweb/images/nook.png" alt="未验证" /> <?php }?> 
			<?php if($userInfoData['kState']=='1'){?> <img src="<?php echo base_url();?>kweb/images/ok.png" alt="已验证" /> <?php }?> 
			<?php if($userInfoData['kState']=='2'){?> <img src="<?php echo base_url();?>kweb/images/nook.png" alt="禁止登录" /> <?php }?> 
		) </div>
		<div class="kalist4" style="margin-top:5px;">等 级： <?php echo $userInfoData['gradeName'];?></div>
		<div class="kalist4" style="margin-top:5px;">ks 币： <?php echo $userInfoData['kPoints'];?></div>
		<div class="kalist4" style="margin-top:5px;">邮 箱： <?php echo $userInfoData['kMail'];?></div>
		<div class="kalist4" style="margin-top:5px;">卡的种类： <?php echo $UserStatistics1;?> 种</div>
		<div class="kalist4" style="margin-top:5px;">卡的数量： <?php echo $UserStatistics0;?> 张</div>
		<div class="kalist4" style="margin-top:5px;">最后登录： <?php echo $userInfoData['loginDateTime'];?></div>
		<br />
		<div class="kalist4" style="margin-top:10px;">
		<script src="<?php echo base_url();?>kweb/js/calendar.js" type="text/javascript"></script>
		<script type="text/javascript">
		calendar();
		startclock();
		</script>
		</div>
	
		<div class="clear" style="color:#000000"></div>
		<!-- <div class="advc">广告位</div> -->
    </div>
	
    <!-- middle -->
    <div class="midcont3">
    	<div class="midltab">
		<div class="katit1 marbot10"><span><a href="<?php echo site_url('card/upsale');?>">添加新卡</a></span><h3><a href="<?php echo site_url('sale');?>">买卖类</a></h3><div class="clear"></div></div>
		<div id="panForSale">
			<ul class="kaul19">
			<?php if($cardDataForSale!=null){foreach ($cardDataForSale as $row):?>
			<li><a href="<?php echo site_url('card/editforsale/'.$row['id']);?>" target="_blank"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a><div><a href="<?php echo site_url('card/editforsale/'. $row['id']);?>" title="<?php echo $row['name'];?>" target="_blank"><?php echo String::cut($row['name'],24);?></a></div><div><em>市场价 ￥<?php echo $row['price'];?></em></div><div><cite>售价 ￥<?php echo $row['sellingPrice'];?></cite></div>
			<div class="div">
			<?php if($row['state']!='3'){ ?>
			<input class="seabut" type="button" value="删除该卡" onclick="doDelCard('<?php echo $row['id']; ?>',1)" />
			<?php } else {?>
			<input class="seabut" type="button" value="已删除" disabled="disabled" /> 
			<?php } ?>
			</div>

			<br /></li>
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
		<div class="katit1 marbot10"><span><a href="<?php echo site_url('card/upshow');?>">添加新卡</a></span>
		<h3><a href="<?php echo site_url('sale');?>">展示类</a></h3>
		<div class="clear"></div></div>
		<div id="panForShow">
			<ul class="kaul19">
			<?php if($cardDataForShow!=null){foreach ($cardDataForShow as $row):?>
			<li><a href="<?php echo site_url('card/editforshow/'.$row['id']);?>" target="_blank"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a><div><a href="<?php echo site_url('card/editforshow/'. $row['id']);?>" title="<?php echo $row['name'];?>" target="_blank"><?php echo String::cut($row['name'],24);?></a></div><div><em>有效期 <?php echo $row['period'];?></em></div><div><cite>用途 <?php echo $row['cardUse'];?></cite></div>
			<div class="div">
			<?php if($row['state']!='3'){ ?>
			<input class="seabut" type="button" value="删除该卡" onclick="doDelCard('<?php echo $row['id']; ?>',2)" />
			<?php } else {?>
			<input class="seabut" type="button" value="已删除" disabled="disabled" /> 
			<?php } ?>
			</div>
			
			<br /></li>
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
    	<div class="katit1"><span><a onclick="pup('popbox01');" href="javascript:void(0)">更多&gt;&gt;</a></span>
    	  <h3>我的私信<em class="grayf">(显示最近5条)</em></h3><div class="clear"></div></div>
        <div class="kalist4 pdtop10">
		<?php if(count($userMessageData) == 0){echo '暂无消息';}
			  else{?>
			  <table style="width:auto;">
		<?php 
			$i=0;
			foreach ($userMessageData as $row):
			$i=$i+1;
			if($i>5){break;}
		?>
		<tr>
		<td style="padding-right:10px;">来自“<?php echo $row['nickname'];?>”</td>
		<td><?php echo date("Y-m-d", strtotime($row['addDateTime']));?> <span class="bluef"> 
		&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="pup('popbox01');">查看</a></span></td>
		</tr>
		<?php endforeach;?>
		</table>
		<?php }?>
		</div>
		<br />
		<!-- 我的活动 -->
		<div class="katit1">
    	  <h3>我的活动<em class="grayf"></em></h3><span><a onclick="pupInit('ManageSpell');" href="javascript:void(0)">更多&gt;&gt;</a></span><div class="clear"></div></div>
		<div class="kalist4 pdtop10">
		<span style="color:#666666">拼卡活动(同一时间内只能发布一个活动，待该活动结束后，可继续发起)</span>
		<p>
			发起活动记录：<span class="redf"><b><?php echo $UserStatistics3;?></b> 次</span>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
			正在进行活动：<span class="redf"><b><?php echo $UserStatistics7;?></b> 个</span>
		</p>
		<p>报名人数：<span class="redf"><b><?php echo $UserStatistics8;?></b> 名</span></p>
		</div>
		<div class="pdtop10">
			<input class="seabut" type="button" value="发起活动" onclick="pupInit('StartSpell');" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input class="seabut" type="button" value="管理活动" onclick="pupInit('ManageSpell');" />
		</div>
		
		
		<!-- 关注我的人 -->
		<div class="katit1 pdtop20">
			<h3>关注我的人</h3>
			<a href="<?php echo site_url('member/more/mf?uid='.$userId);?>"><span style="padding-right:10px;">更多&gt;&gt;</span></a>
			</div>
		<div class="kalist4 pdtop5">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td height="20px">关 注 我：<span class="redf"><b><?php echo $UserStatistics5;?></b></span></td>
			<td height="20px">我 关 注：<span class="redf"><b><?php echo $UserStatistics6;?></b></span></td>
		  </tr>
		  <tr>
			<td height="20px">交易记录：<span class="redf"><b><?php echo $UserStatistics2;?></b> 次</span></td>
			<td height="20px">兑换卡卷：<span class="redf"><b><?php echo $UserStatistics4;?></b> 次</span></td>
		  </tr>
		</table>
		</div>
		<ul class="kaul18 marbot10">
		<?php if(count($userFriendsData) == 0){echo '暂无好友';}
			  else{?>
		<?php foreach ($userFriendsData as $row):?>
		<li><a href="<?php echo site_url('member/other/'.$row['userId']);?>"><img src="<?php echo $row['mykAvatarImage'];?>" /></a><div><a href="<?php echo site_url('member/other/'.$row['userId']);?>"><?php echo $row['mynickname'];?></a></div></li>
		<?php endforeach;?>
		<?php }?>
		</ul>
    </div>
<div class="clear"></div>
</div>
<!-- first end -->

<!-- fla start -->
<div id="popMask" style="background:#000; opacity:0.6; filter:alpha(opacity=60); width:100%; height:100%; position:absolute; top:0; left:0; display:none;"></div>
<div id="popBox" style=" position:absolute; top:150px; left:0; width:100%; display:none;">
<div id="popbox01" class="popbox flacont1" style="display:none;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><span class="r"><a onclick="closeLayer()" href="javascript:void(0)"><img src="<?php echo base_url();?>kweb/images/kaicon5.gif" /></a></span>
	<strong class="blankf">我的私信</strong>　<strong class="redf2"><a onclick="closeLayer()" href="javascript:void(0)">返回首页</a></strong>
	</td>
  </tr>
 </table>
 <div  id="umdata">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?php if(count($userMessageData) == 0){?>
  <tr><td>暂无消息</td></tr>
  <?php 
		}else{
			$i=0;
			$count=count($userMessageData);
  ?>
  <!-- 今天 -->
  <?php if( Tools::IsToday($userMessageData[0]['addDateTime'])){?>
  <tr>
	<td>
		<div class="kaletterul"><h4>今天：</h4>
		<ul>
	<?php 
			for($j=$i;$j<$count;$j++, $i=$j):
				if( !Tools::IsToday($userMessageData[$j]['addDateTime'])){$j=$count;break;}
	?>
	<li>来自<cite>“<?php echo $userMessageData[$j]['nickname'];?>”</cite><em><?php echo date("Y-m-d", strtotime($userMessageData[$j]['addDateTime']));?></em>  ：<?php echo $userMessageData[$j]['content'];?> <div>&lt;<a href="javascript:void(0)" onclick="ReMyupInit('1','<?php echo $userMessageData[$j]['userId'];?>')">回复</a>&gt;</div></li>
	<?php 	endfor;?>
	</ul></div></td>
  </tr>
  <?php }?>
  <!-- 今天end -->
  <!-- 昨天 -->
  <?php if($i<$count){?>
  <?php 	if( Tools::IsYesterday($userMessageData[$i]['addDateTime'])){?>
  <tr>
	<td>
		<div class="kaletterul"><h4>昨天：</h4>
		<ul>
	<?php 
			for($j=$i;$j<$count;$j++,$i=$j):
				if( !Tools::IsYesterday($userMessageData[$j]['addDateTime'])){$j=$count;break;}
	?>
	<li>来自<cite>“<?php echo $userMessageData[$j]['nickname'];?>”</cite><em><?php echo date("Y-m-d", strtotime($userMessageData[$j]['addDateTime']));?></em>  ：<?php echo $userMessageData[$j]['content'];?> <div>&lt;<a href="javascript:void(0)" onclick="ReMyupInit('1','<?php echo $userMessageData[$j]['userId'];?>')">回复</a>&gt;</div></li>
	<?php 	endfor;?>
	</ul></div></td>
  </tr>
  <?php 	}?>
  <?php }?>
  <!-- 昨天end -->
  
  <!-- 更早 -->
  <?php 	if($i<$count){?>
  <tr>
	<td>
		<div class="kaletterul"><h4>更早：</h4>
		<ul>
	<?php 
			for($j=$i;$j<$count;$j++):
	?>
	<li>来自<cite>“<?php echo $userMessageData[$j]['nickname'];?>”</cite><em><?php echo date("Y-m-d", strtotime($userMessageData[$j]['addDateTime']));?></em>  ：<?php echo $userMessageData[$j]['content'];?> <div>&lt;<a href="javascript:void(0)" onclick="ReMyupInit('1','<?php echo $userMessageData[$j]['userId'];?>')">回复</a>&gt;</div></li>
	<?php 	endfor;?>
	</ul></div></td>
  </tr>
  <?php 	}?>
  <!-- 更早End -->
  <?php }?>
  <tr>
    <td class="pdtop30 position3" align="center">
	<?php
	#var_dump(array('total'=>$total,'perpage'=>$perpage));
	$page=new page(array('total'=>$total,'perpage'=>$perpage));
	$page->open_ajax('doAjax');
	echo $page->show(1);
	?></td>
  </tr>
</table>
</div>
  <div class="clear"></div>
</div>
</div>
<!-- fla end -->

<!-- fla2 start -->
<div id="popMask2" style="background:#000; opacity:0.6; filter:alpha(opacity=60); width:100%; height:100%; position:absolute; top:0; left:0; display:none;"></div>
<div id="popBox2" style=" position:absolute; top:30px; left:0; width:100%; display:none;">
<div id="popbox02" class="popbox flacont1" style="display:none;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><span class="r"><a onclick="closeLayer2()" href="javascript:void(0)">
			<img src="<?php echo base_url();?>kweb/images/kaicon5.gif" /></a></span>
			<strong class="blankf">个人信息</strong>　
			<strong class="redf2"><a onclick="closeLayer2()" href="javascript:void(0)">返回首页</a></strong>
		</td>
	  </tr>
	 </table>
	 <form id="formUserInfo" action="<?php echo site_url("member/dosaveinfo");?>" method="post" target="_blank">
	 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fltabc">
	  <tr>
		<td width="200px" valign="top"><div class="defaltpic">
			<img src="<?php echo $userInfoData['kAvatarImage'];?>" />
			<p><input onClick='javascript:window.location.href="<?php echo site_url("member/upphoto");?>"' class="seabut" name="" type="button" value="上传头像" /></p>
			<p></p>
			<p><input class="seabut" id="btnUserInfo" name="btnUserInfo" type="button" value="保   存" /></p>
			<input type="hidden" name="userId" id="userId" value="<?php echo $userId;?>" />
			</div>
			<div id="msg"></div>
		</td>
		<td valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td><h3 class="f14 redf">填写会员资料</h3></td>
			  </tr>
			</table>
		
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td>个性签名：</td>
				<td><label>
				  <input class="kainput12c" type="text" name="st" value="<?php echo $userInfoData['Signature'];?>" />
				  </label></td>
			  </tr>
			  <tr>
				<td>昵　　称：</td>
				<td><label>
				  <input class="kainput12c" type="text" name="nk" value="<?php echo $userInfoData['nickname'];?>" />
				  </label></td>
			  </tr>
			  <tr>
				<td>邮　　箱</td>
				<td><label>
				  <input class="kainput12c" type="text" name="m" value="<?php echo $userInfoData['kMail'];?>" />
				  </label></td>
			  </tr>
			  <tr>
				<td>生　　日：</td>
				<td>
				<style type="text/css">
				.Wdate{
					height:20px;
					background:#fff url(<?php echo base_url();?>kweb/images/datePicker.gif) no-repeat right;
				}
				</style>
				<label>
				  <input class="kainput10 Wdate" type="text" name="b" id="b" value="<?php echo date("Y-m-d", strtotime($userInfoData['birthday']));?>" /></label><script type="text/javascript">ESONCalendar.bind("b");</script>
				  </td>
			  </tr>
			  <tr>
				<td>所在地区：</td>
				<td><label>
				  <input class="kainput12c" type="text" name="a" value="<?php echo $userInfoData['area'];?>" />
				  </label></td>
			  </tr>
			</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td colspan="2" class="pdbt30c f14 grayf">选填项（主要用于买卖卡，拼卡，好友联系等）</td>
			  </tr>
			  <tr>
				<td>电　　话：</td>
				<td><label>
				  <input class="kainput12c" type="text" name="t" value="<?php echo $userInfoData['kTel'];?>" />
				  </label></td>
			  </tr>
			  <tr>
				<td>QQ：</td>
				<td><label>
				  <input class="kainput12c" type="text" name="qq" value="<?php echo $userInfoData['QQ'];?>" />
				  </label></td>
			  </tr>
			  <tr>
				<td>MSN：</td>
				<td><label>
				  <input class="kainput12c" type="text" name="msn" value="<?php echo $userInfoData['MSN'];?>" />
				  </label></td>
			  </tr>
			</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td class="pdtop20 f14 grayf">现在状态</td>
			  </tr>
			  <tr>
				<td>等级：<?php echo $userInfoData['gradeName'];?></td>
			  </tr>
			  <tr>
				<td>Ks币数量：<?php echo $userInfoData['kPoints'];?></td>
			  </tr>
			  <tr>
				<td>卡的种类：<?php echo $UserStatistics1;?> 种</td>
			  </tr>
			  <tr>
				<td>卡的数量：<?php echo $UserStatistics0;?> 张</td>
			  </tr>
			</table>
		</td>
	  </tr>
	</table>
	</form>
	<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
  <div class="clear"></div>
</div>
</div>
<!-- fla2 end -->