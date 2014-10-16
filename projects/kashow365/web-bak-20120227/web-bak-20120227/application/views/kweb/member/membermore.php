<br />
<?php if($showType == 'myfriends'){?>
<!-- first start -->
<div class="membore">
	<?php if(count($usersData) == 0){echo '暂无好友';}
		  else{?>
	<ul>
	<?php foreach ($usersData as $row):?>
	<li><a href="<?php echo site_url('member/other/'.$row['friendUserId']);?>"><img src="<?php echo $row['kAvatarImage'];?>" /></a><p><a href="<?php echo site_url('member/other/'.$row['friendUserId']);?>"><?php echo $row['nickname'];?></a></p></li>
	<?php endforeach;?>
	</ul>
	<div class="position3">
	<?php
	$page=new page(array('total'=>$total,'perpage'=>$perpage));
	echo $page->show(1);
	?>
	</div>
	<?php }?>
</div>
<!-- first end -->
<?php }else{ ?>
<!-- first start -->
<div class="membore">
	<?php if(count($usersData) == 0){echo '暂无记录';}
		  else{?>
	<ul>
	<?php foreach ($usersData as $row):?>
	<li><a href="<?php echo site_url('member/other/'.$row['id']);?>"><img src="<?php echo $row['kAvatarImage'];?>" /></a><p><a href="<?php echo site_url('member/other/'.$row['id']);?>"><?php echo $row['nickname'];?></a></p></li>
	<?php endforeach;?>
	</ul>
	<div class="position3">
	<?php
	$page=new page(array('total'=>$total,'perpage'=>$perpage));
	echo $page->show(1);
	?>
	</div>
	<?php }?>
</div>
<!-- first end -->
<?php } ?>