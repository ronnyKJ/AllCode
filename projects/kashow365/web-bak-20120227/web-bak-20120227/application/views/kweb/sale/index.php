<!-- first start -->
<div class="bigcont">
	<div class="topadv2">
	<h3>有买有卖</h3><?php if($saleInfoIndex !=null){echo $saleInfoIndex;}?>
	<div class="clear"></div>
	</div>
	<div class="radv1">
		<?php if($ad2!=null && $ad2['value1']!=''){?>
		<?php 		if($ad2['count']==0){?>
			<a href="<?php echo $ad2['value2'];?>" target="_blank">
				<img src="<?php echo $ad2['value1'];?>" width="324" height="115" /></a>
		<?php 		}else{ echo $ad2['value2']; }?>
		<?php }else{?>
			广告位-2 ( 324 * 115 )
		<?php } ?>
	</div>
<div class="clear"></div>
</div>
<!-- first end -->
<!-- second start -->
<div class="bigcont">
	<!-- left -->
	<div class="leftcont1 martop25">
		<div class="clear0"></div>
		<div class="katit1 marbot10"><span><a href="<?php echo site_url('sale/more/sale');?>">更多&gt;&gt;</a></span><h3>有买有卖</h3><div class="clear"></div></div>
		<ul class="kaul1">
		<?php if($cardData!=null){foreach ($cardData as $row):?>
		<li><a href="<?php echo site_url('sale/rebatsale/'.$row['id']);?>"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a><div><a href="<?php echo site_url('sale/rebatsale/'. $row['id']);?>" title="<?php echo $row['name'];?>"><?php echo String::cut($row['name'],24);?></a></div><div><em>市场价 ￥<?php echo $row['price'];?></em></div><div><cite>售价 ￥<?php echo $row['sellingPrice'];?></cite></div></li>
		<?php endforeach;}?>
		</ul>
		
		<div class="katit1 marbot10"><span><a href="<?php echo site_url('sale/more/show');?>">更多&gt;&gt;</a></span><h3>卡展示</h3><div class="clear"></div></div>
		<ul class="kaul1">
		<?php if($cardDataShow!=null){foreach ($cardDataShow as $row):?>
		<li><a href="<?php echo site_url('sale/rebatshow/'.$row['id']);?>"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a><div><a href="<?php echo site_url('sale/rebatshow/'. $row['id']);?>" title="<?php echo $row['name'];?>"><?php echo String::cut($row['name'],24);?></a></div><div><em>有效期 <?php echo $row['period'];?></em></div><div><cite>用途 <?php echo $row['cardUse'];?></cite></div></li>
		<?php endforeach;}?>
		</ul>
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
		<?php if($ad1!=null && $ad1['value1']!=''){?>
		<?php 		if($ad1['count']==0){?>
			<a href="<?php echo $ad1['value2'];?>" target="_blank" title="<?php echo $ad1['value3'];?>">
				<img src="<?php echo $ad1['value1'];?>" width="331" height="60" /></a>
		<?php 		}else{ echo $ad1['value2']; }?>
		<?php }else{?>
			广告位-1 ( 331 * 60 )
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