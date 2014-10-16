<!-- first start -->
<div class="searcont">
	<h3>共有<strong> <?php echo $total; ?> </strong>条结果</h3>
	<ul class="searul">
	<?php if($cardData==null){?>
		没有附合条件的卡
	<?php } ?>

	<?php if($cardData!=null){foreach ($cardData as $row):?>
	<?php 	if($row['cardSetType'] == '1'){ ?>
	<li><a href="<?php echo site_url('sale/rebatsale/'.$row['id']);?>"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a><div><a href="<?php echo site_url('sale/rebatsale/'. $row['id']);?>" title="<?php echo $row['name'];?>"><?php echo String::cut($row['name'],24);?></a></div><div><em>市场价 ￥<?php echo $row['value1'];?></em></div><div><cite>售价 ￥<?php echo $row['value2'];?></cite></div></li>
	<?php 	} else if($row['cardSetType'] == '2'){ ?>
	<li><a href="<?php echo site_url('sale/rebatshow/'.$row['id']);?>"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a><div><a href="<?php echo site_url('sale/rebatshow/'. $row['id']);?>" title="<?php echo $row['name'];?>"><?php echo String::cut($row['name'],24);?></a></div><div><em>市场价 ￥<?php echo $row['value1'];?></em></div><div><cite>售价 ￥<?php echo $row['value2'];?></cite></div></li>
	<?php 	} else if($row['cardSetType'] == '3'){ ?>
	<li><a href="<?php echo site_url('spell/spellxl/'.$row['id']);?>"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a><div><a href="<?php echo site_url('spell/spellxl/'. $row['id']);?>" title="<?php echo $row['name'];?>"><?php echo String::cut($row['name'],24);?></a></div><div><em>人数限制 <?php echo $row['value1'];?> 人</em></div><div><cite>结束时间 <?php echo $row['value2'];?></cite></div></li>
	<?php 	} else if($row['cardSetType'] == '4'){ ?>
	<li><a href="<?php echo site_url('gift/view/'.$row['id']);?>"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a><div><a href="<?php echo site_url('gift/view/'. $row['id']);?>" title="<?php echo $row['name'];?>"><?php echo String::cut($row['name'],24);?></a></div><div><em>剩余个数 <?php echo $row['value1'];?>个 </em></div><div><cite>消费积分 ￥<?php echo $row['value2'];?> ks币</cite></div></li>
	<?php 	} ?>
	
	<?php endforeach;}?>

	</ul>
	<div class="position3">
	<?php
	#var_dump(array('total'=>$totalForSale,'perpage'=>$perpageForShow));
	$page=new page(array('total'=>$total,'perpage'=>$perpage,'pagebarnum'=>10));
	echo $page->show(1);
	?>
	</div>
<div class="clear"></div>
</div>
<!-- first end -->