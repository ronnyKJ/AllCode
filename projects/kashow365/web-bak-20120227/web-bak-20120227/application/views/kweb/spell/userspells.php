<!-- first start -->
<div class="bigcont">
	<h3>拼卡管理页</h3>
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
			<input class="seabut" type="button" value="我要修改" onclick="location.href='<?php echo site_url('spell/spellxl/'.$row['id']);?>'" />　
			<input class="seabut" type="button" value="结束活动" onclick="pupInit('Friends')" />
		</div>
		</li>
		<?php endforeach;}?>

		</ul>
		<div class="position">
			<?php
			#var_dump(array('total'=>$totalForSale,'perpage'=>$perpageForShow));
			$page=new page(array('total'=>$total,'perpage'=>$perpage,'pagebarnum'=>2));
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
		<div class="adv">广告位-1 ( 331 * 60 )</div>
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
