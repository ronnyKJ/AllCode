<script src="<?php echo base_url();?>kweb/js/jquery.timer.js" type="text/javascript" ></script>
<script src="<?php echo base_url();?>kweb/js/news.js" type="text/javascript" ></script>
<!-- second start -->
<div class="bigcont">
	<!-- left -->
	<div class="leftcont1 martop25">
		<div class="katit2"><div class="kawid160">网站公告</div><div class="kawid330">公告内容</div><div class="kawid125">公告日期</div></div>
        <ul class="kaul10">
        		<?php foreach ($newsData as $row):?>
		<li><h4><a href="<?php echo site_url('news/annountcontent/'.$row['id']);?>" title="<?php echo $row['newsTitle'];?>"><?php echo String::cut($row['newsTitle'],18);?></a></h4>
		<span><a href="<?php echo site_url('news/annountcontent/'.$row['id']);?>" title="<?php echo $row['newsSummary'];?>"><?php echo String::cut($row['newsSummary'],40);?></a></span>
		<em>
		<?php if($row['startDate'] !='' && $row['endDate'] !=''){?>
		<?php echo date("m月d日", strtotime($row['startDate']));?>-<?php echo date("m月d日", strtotime($row['endDate']));?>
		<?php } ?>
		</em></li>
		<?php endforeach;?>
        </ul><div class="clear"></div>
        <div class="position3">
		<?php
		require_once 'kadmin/businessentity/tools/page.class.php';
		$page=new page(array('total'=>$total,'perpage'=>$perpage));
		echo $page->show(1);
		?>
		</div>
		<div class="clear"></div>
	</div>
	<!-- right -->
	<div class="rightcont1 martop25">
		<div class="katit2">北京商场推荐</div>
        <ul class="kaul11">
        <?php if($shopData1!=null){foreach ($shopData1 as $row):?>
		<li>·<a href="<?php echo site_url('news/discount?shopId='.$row['id']);?>"><?php echo $row['shopName'];?></a></li>
		<?php endforeach;}?>
        </ul>
		<div class="adv">
		<?php if($ad2!=null && $ad2['value1']!=''){?>
		<?php 		if($ad2['count']==0){?>
			<a href="<?php echo $ad2['value2'];?>" target="_blank" title="<?php echo $ad2['value3'];?>">
				<img src="<?php echo $ad2['value1'];?>" width="331" height="60" /></a>
		<?php 		}else{ echo $ad2['value2']; }?>
		<?php }else{?>
			广告位-2 ( 331 * 60 )
		<?php } ?>
		</div>
        <div class="katit2">北京商场(拼音排序)</div>
        <ul class="kaul11">
        <?php if($shopData2!=null){foreach ($shopData2 as $row):?>
		<li>·<a href="<?php echo site_url('news/discount?shopId='.$row['id']);?>"><?php echo $row['shopName'];?></a></li>
		<?php endforeach;}?>
        </ul>
	<div class="clear"></div>
	</div>
<div class="clear"></div>
</div>
<!-- second end -->