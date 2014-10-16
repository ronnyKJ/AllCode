<script src="<?php echo base_url();?>kweb/js/jquery.timer.js" type="text/javascript" ></script>
<script src="<?php echo base_url();?>kweb/js/news.js" type="text/javascript" ></script>
<script type="text/javascript">
window.onload=function(){
	var districtId = "<?php echo $districtId;?>";
	var urbanId = "<?php echo $urbanId;?>";
	var shopId = "<?php echo $shopId;?>";
	if(districtId!=""){
		areaSelect('<?php echo site_url('kadmin/mainfurban/getparent');?>', districtId, urbanId);
	}
	urbanSelect('<?php echo site_url('kadmin/mainfshop/getparent');?>', urbanId, shopId);
}

</script>
<!-- first start -->
<div class="bigcont">
	<div class="topadv2">
	<form action="<?php echo site_url('news/conversion');?>" method="get">
	<h3>新闻联播</h3><p>没准最好、最快、最强的资讯就在这里....</p><p><select class="kainput3">
	  <option>北京</option>
	</select>
	 <label>
	  <select id="district" name="districtId" class="kainput4" onChange="areaSelect('<?php echo site_url('kadmin/mainfurban/getparent');?>',this.value, '')">
		<option value="" <?php if($districtId==''){echo 'selected="selected"';}?>>请选择</option>
		<?php foreach ($districtRows as $row):?>
		<option value="<?php echo $row['id'];?>" <?php echo $row['id']== $districtId ? 'selected="selected"' : '';?>><?php echo $row['name'];?></option>
		<?php endforeach;?>
		</select>
	  </label>
	  <label>
		<select id="urban" name="urbanId" class="kainput4" onChange="urbanSelect('<?php echo site_url('kadmin/mainfshop/getparent');?>',this.value,'')">
		<option value="" selected="selected">请选择</option>
		</select>&nbsp;&nbsp;
	  </label>
	  <label>
	  <select id="shop" name="shopId" class="kainput4">
	    <option value="" selected="selected">请选择</option>
      </select>
	  </label>
	  <label>
	  <input class="seabut" type="submit" name="button" id="button" value="查 询" />
	  </label>
	</p>
	</form>
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
		<div class="katit2"><div class="kawid160">kashow兑换通知</div><div class="kawid330">活动内容</div><div class="kawid125">活动日期</div></div>
        <ul class="kaul10">
		<?php foreach ($newsData as $row):?>
		<li><h4><a href="<?php echo site_url('news/conversioncontent/'.$row['id']);?>" title="<?php echo $row['newsTitle'];?>"><?php echo String::cut($row['newsTitle'],18);?></a></h4>
		<span><a href="<?php echo site_url('news/conversioncontent/'.$row['id']);?>" title="<?php echo $row['newsSummary'];?>"><?php echo String::cut($row['newsSummary'],40);?></a></span>
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
		<li>·<a href="<?php echo site_url('news/conversion?shopId='.$row['id']);?>"><?php echo $row['shopName'];?></a></li>
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
        <div class="katit2">北京商场</div>
        <ul class="kaul11">
        <?php if($shopData2!=null){foreach ($shopData2 as $row):?>
		<li>·<a href="<?php echo site_url('news/conversion?shopId='.$row['id']);?>"><?php echo $row['shopName'];?></a></li>
		<?php endforeach;}?>
        </ul>
	<div class="clear"></div>
	</div>
<div class="clear"></div>
</div>
<!-- second end -->