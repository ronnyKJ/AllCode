<!-- first start -->
<div class="bigcont2 marbot25">
	<!-- left -->
	<div class="leftcont1" style="background:#f7f7f7;">
		<div class="newxltab">
        <h1><?php echo $newsData['newsTitle'];?></h1>
		<hr />
		<p class="newpic"><?php echo $newsData['newsContent'];?></p>
        </div> 
		<div class="clear"></div>
	</div>
	<!-- right -->
	<div class="rightcont5">
		<div class="katit2">近期活动</div>
        <ul class="kaul11">
        <?php if($newsMoreData!=null){foreach ($newsMoreData as $row):?>
		<li>·<a href="<?php echo site_url('news/discountcontent/'.$row['id']);?>"><?php echo String::cut($row['newsTitle'],30);?></a></li>
		<?php endforeach;}?>
        </ul>
        <div class="katit2">最新会员</div>
        <ul class="karul19">
			<?php if($newUserInfo!=null){foreach ($newUserInfo as $row):?>
			<li><a href="<?php echo site_url('member/other/'.$row['id']);?>"><img src="<?php echo $row['kAvatarImage'];?>" alt="<?php echo $row['nickname'];?>" width="50px" height="50px" /></a></li>
			<?php endforeach;}?>
        </ul><div class="clear"></div>
        <div class="martop25">

		<?php if($ad1!=null && $ad1['value1']!=''){?>
		<?php 		if($ad1['count']==0){?>
			<a href="<?php echo $ad1['value2'];?>" target="_blank" title="<?php echo $ad1['value3'];?>">
				<img src="<?php echo $ad1['value1'];?>" width="331" /></a>
		<?php 		}else{ echo $ad1['value2']; }?>
		<?php }else{?>
			广告位-3 ( 331 * 291 )
		<?php } ?>

		</div>
	<div class="clear"></div>
	</div>
<div class="clear"></div>
</div>
<!-- first end -->