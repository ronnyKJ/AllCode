<!-- first start -->
<br />
<div class="searcont">
	<h3>共有<strong>520</strong>条结果</h3>
	<ul class="searul">
	<?php 	if($cardSetType == 'sale'){?>
	
	<?php if($cardData!=null){foreach ($cardData as $row):?>
		<li><a href="<?php echo site_url('sale/rebatsale/'.$row['id']);?>"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a><div><a href="<?php echo site_url('sale/rebatsale/'. $row['id']);?>" title="<?php echo $row['name'];?>"><?php echo String::cut($row['name'],24);?></a></div><div><em>市场价 ￥<?php echo $row['price'];?></em></div><div><cite>售价 ￥<?php echo $row['sellingPrice'];?></cite></div></li>
	<?php endforeach;}?>
	
	<?php }else{ ?>
		
	<?php if($cardData!=null){foreach ($cardData as $row):?>
		<li><a href="<?php echo site_url('sale/rebatshow/'.$row['id']);?>"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a><div><a href="<?php echo site_url('sale/rebatshow/'. $row['id']);?>" title="<?php echo $row['name'];?>"><?php echo String::cut($row['name'],24);?></a></div><div><em>市场价 ￥<?php echo $row['price'];?></em></div><div><cite>售价 ￥<?php echo $row['sellingPrice'];?></cite></div></li>
	<?php endforeach;}?>
	
	<?php } ?>
	
	</ul>
	<div class="clear"></div>
	<div class="position3">
	<?php
	#var_dump(array('total'=>$totalForSale,'perpage'=>$perpageForShow));
	$pageForSale=new page(array('total'=>$total,'perpage'=>$perpage,'pagebarnum'=>10));
	echo $pageForSale->show(1);
	?>
	</div>
</div>
<!-- first end -->