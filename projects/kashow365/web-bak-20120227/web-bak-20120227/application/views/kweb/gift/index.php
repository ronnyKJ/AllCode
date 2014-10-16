<script type="text/javascript">
function goto(id){
	location.href="<?php echo site_url('gift/view/');?>"+"/"+id;
}
</script>
<!-- first start -->
<div class="kaul7">
	<h3>赞助商区域</h3>
	<ul>
	<?php if($card0!=null){foreach ($card0 as $row):?>
	<li><a href="<?php echo site_url('gift/view/'.$row['id']);?>"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a></li> 
	<?php endforeach;}?>
	</ul>
<div class="clear"></div>
</div>
<!-- first end -->
<!-- second start -->
<div class="kaul7">
	<h3>100KS兑换区</h3>
	<ul>
	<?php if($card1!=null){foreach ($card1 as $row):?>
	<li><a href="<?php echo site_url('gift/view/'.$row['id']);?>"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a>
		<div><?php echo $row['surplusCount'];?> 个 <input onclick="goto('<?php echo $row['id']; ?>');" class="seabut" type="button" value="兑 换" /></div></li>
	<?php endforeach;}?>
	</ul>
	<div class="clear"></div>
</div>
<div class="kaul7">
	<h3>300KS兑换区</h3>
	<ul>
	<?php if($card2!=null){foreach ($card2 as $row):?>
	<li><a href="<?php echo site_url('gift/view/'.$row['id']);?>"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a>
		<div><?php echo $row['surplusCount'];?> 个 <input onclick="goto('<?php echo $row['id']; ?>');" class="seabut" type="button" value="兑 换" /></div></li>
	<?php endforeach;}?>
	</ul>
	<div class="clear"></div>
</div>
	<div class="bigcont">
		<div class="adva">
		<?php if($ad1!=null && $ad1['value1']!=''){?>
		<?php 		if($ad1['count']==0){?>
			<a href="<?php echo $ad1['value2'];?>" target="_blank" title="<?php echo $ad1['value3'];?>">
				<img src="<?php echo $ad1['value1'];?>" width="300" height="60" /></a>
		<?php 		}else{ echo $ad1['value2']; }?>
		<?php }else{?>
			广告位-1 ( 300 * 60 )
		<?php } ?>
		</div>
		<div class="advb">
		<?php if($ad2!=null && $ad2['value1']!=''){?>
			<?php 		if($ad2['count']==0){?>
				<a href="<?php echo $ad2['value2'];?>" target="_blank" title="<?php echo $ad2['value3'];?>">
					<img src="<?php echo $ad2['value1'];?>" width="660" height="60" /></a>
			<p><?php echo $ad2['value3'];?></p>
			<?php 		}else{ echo $ad2['value2']; }?>
			<?php }else{?>
				广告位-2 ( 660 * 60 )
			<?php } ?>
		</div>
	</div>
<div class="kaul7">
	<h3>500KS兑换区</h3>
	<ul>
	<?php if($card3!=null){foreach ($card3 as $row):?>
	<li><a href="<?php echo site_url('gift/view/'.$row['id']);?>"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a>
		<div><?php echo $row['surplusCount'];?> 个 <input onclick="goto('<?php echo $row['id']; ?>');" class="seabut" type="button" value="兑 换" /></div></li>
	<?php endforeach;}?>
	</ul>
	<div class="clear"></div>
</div>
<div class="kaul7">
	<h3>1000KS兑换区</h3>
	<ul>
	<?php if($card4!=null){foreach ($card4 as $row):?>
	<li><a href="<?php echo site_url('gift/view/'.$row['id']);?>"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a>
		<div><?php echo $row['surplusCount'];?> 个 <input onclick="goto('<?php echo $row['id']; ?>');" class="seabut" type="button" value="兑 换" /></div></li>
	<?php endforeach;}?>
	</ul>
	<div class="clear"></div>
</div>
<!-- second end -->
