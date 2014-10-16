<script type="text/javascript">
function myPupInit(cid){
	//绑定提交按钮
	$("#formFriends").attr("action", "<?php echo site_url('spell/dosendfriend/');?>"+"/"+cid);
	
	// 弹出层
	pupInit('Friends');
}
</script>
<!-- first start -->
<div class="bigcont">
	<div class="topadv2">
	<h3>合伙拼卡</h3><?php if($spellInfoIndex !=null){echo $spellInfoIndex;}?>
	<div class="clear"></div>
	</div>
	<div class="radv1">
	<?php if($ad1!=null && $ad1['value1']!=''){?>
	<?php 		if($ad1['count']==0){?>
		<a href="<?php echo $ad1['value2'];?>" target="_blank" title="<?php echo $ad1['value3'];?>">
			<img src="<?php echo $ad1['value1'];?>" width="324" height="115" /></a>
	<?php 		}else{ echo $ad1['value2']; }?>
	<?php }else{?>
		广告位-1 ( 324 * 115 )
	<?php } ?>
	</div>
<div class="clear"></div>
</div>
<!-- first end -->
<!-- second start -->
<div class="bigcont">
	<!-- left -->
	<div class="leftcont1 martop25">
		<ul class="kaul5">
		<?php if($cardData!=null){foreach ($cardData as $row):?>
		<li><div class="lpic"><a href="<?php echo site_url('spell/spellxl/'.$row['id']);?>"><img title="" src="<?php echo $row['cardImagePath'];?>" /></a></div>
		<div class="rtxt">
			<p>发起人： <?php echo $row['nickname'];?></p>
			<p>意向人数： <font class="redf24"><?php echo $row['regCount'];?></font></p>
			<p>活动参与人数限制： <?php echo $row['limitUser'];?></p>
			<p>发起时间： <?php echo $row['startDate'];?></p>
			<p>结束时间： <?php echo $row['endDate'];?></p>
			<p>联系方式： <?php echo $row['tel'];?> </p>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Q Q： <?php echo $row['QQ'];?></p>
			<p>发起事项：<font class="grayf"><?php echo $row['matter'];?></font></p>
		</div>
		<div class="botxt"><h4>活动特点：</h4><?php echo $row['characteristic'];?></div>
		<div class="botxt">
				<?php 
					$endDate = $row['endDate'];
					$endDate = str_replace("年","-",$endDate);
					$endDate = str_replace("月","-",$endDate);
					$endDate = str_replace("日","",$endDate);
				?>
				<?php if(Tools::IsOld($endDate) || $row['state']=='2'){?>
				<input class="seabut" type="button" value="活动结束" disabled="disabled"/>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php } else if($row['state']=='1'){?>
				<input class="seabut" type="button" value="已 满 员" disabled="disabled"/>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php } else {?>
				<input class="seabut" type="button" value="我要参加" onclick="location.href='<?php echo site_url('spell/spellxl/'.$row['id']);?>'" />&nbsp;&nbsp;&nbsp;&nbsp;
				<?php } ?>
				<input class="seabut" type="button" value="发给好友" onclick="myPupInit('<?php echo $row['id'];?>')" />
		</div></li>
		<?php endforeach;}?>

		</ul>
		<div class="position">
			<?php
			#var_dump(array('total'=>$totalForSale,'perpage'=>$perpageForShow));
			$page=new page(array('total'=>$total,'perpage'=>$perpage,'pagebarnum'=>10));
			echo $page->show(1);
			?>
		</div>
		<div class="clear"></div>
	</div>
	<!-- right -->
	<div class="rightcont1 martop25">
		<div class="katit1"><h3>喜欢该频道的成员 <em>( <?php echo $WebTotcalUser; ?> )</em></h3><div class="clear"></div></div>
		<ul class="karul4">
		<?php if($userDate!=null){foreach ($userDate as $row):?>
		<li><a href="<?php echo site_url('member/other/'.$row['id']);?>"><img src="<?php echo $row['kAvatarImage'];?>" /></a><div><a href="<?php echo site_url('member/other/'.$row['id']);?>"><?php echo $row['nickname'];?></a></div></li>
		<?php endforeach;}?>
		</ul>
		<div class="adv">
		<?php if($ad2!=null && $ad2['value1']!=''){?>
		<?php 		if($ad2['count']==0){?>
			<a href="<?php echo $ad2['value2'];?>" target="_blank"  title="<?php echo $ad2['value3'];?>">
				<img src="<?php echo $ad2['value1'];?>" width="331" height="60" /></a>
		<?php 		}else{ echo $ad2['value2']; }?>
		<?php }else{?>
			广告位-2 ( 331 * 60 )
		<?php } ?>
		</div>
		<div class="katit1"><span><a href="<?php echo site_url('news/activity');?>">更多&gt;&gt;</a></span><h3>最新活动</h3><div class="clear"></div></div>
		<div class="kaul3"><ul>
		<?php if($news1!=null){foreach ($news1 as $row):?>
		<li><h3><a href="<?php echo site_url('news/activity/'. $row['id']);?>"><?php echo $row['newsTitle'];?></a></h3><?php echo $row['newsSummary'];?></li>
		<?php endforeach;}?>
		</ul></div>
	<div class="clear"></div>
	</div>
<div class="clear"></div>
</div>
<!-- second end -->
