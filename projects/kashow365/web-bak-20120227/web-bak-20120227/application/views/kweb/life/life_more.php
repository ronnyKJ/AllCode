<script src="<?php echo base_url();?>kweb/js/jquery.timer.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kweb/js/jquery.slide.js" type="text/javascript" charset="UTF-8"></script>
<script type="text/javascript">
function doFriend(fuid, btnobj){
	//表单参数
	param = "fuid="+fuid;
	url = "<?php echo site_url('member/dofriends');?>";
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			alert(obj.info);
			if(obj.status){
				var id=btnobj.id;
				$("#"+id).val("已关注");
				$("#"+id).attr("disabled","disabled");
			}
			
		}
	});
}
$(function (){
	/* banner图片左右滚动 */
	$(".w_ctr632 .JQ-slide").Slide({
		effect:"scroolX",
		speed:"normal",
		timer:3000
	});
});
</script>
<!-- adv start-->
<div class="bigcont">
	<!-- banner图片左右滚动 -->
	<div class="w_ctr632">
		<div class="JQ-slide">
			<ul class="JQ-slide-content">
			<?php if($adinfo!=null){foreach ($adinfo as $row):?>
			<li><a href="<?php echo $row['value2'];?>" target="_blank"><img src="<?php echo $row['value1'];?>" alt="<?php echo $row['value3'];?>"  width="632px" height="136px"></a></li>
			<?php endforeach;}?>
			</ul>
			<ul class="JQ-slide-nav">
				<?php if($adinfo!=null){for($i=1,$count=count($adinfo); $i<=$count; $i++):?>
				<li <?php if($i==1){echo 'class="on"';}?>><?php echo $i;?></li>
				<?php endfor;}?>
			</ul>
		</div>
	</div>
	<!--banner图片左右滚动 -->
	
	<div class="clear"></div>
</div>
<!-- adv end -->
<!-- first start -->
<div class="bigcont marbot30" style="padding-top:15px;">
	<!-- left -->
	<div class="leftcont2">
		<div class="katit1"><span><a href="<?php echo site_url('member/more/nlu');?>">更多&gt;&gt;</a></span><h3>我在微博</h3></div>
		<ul class="kaul8 marbot10">
		<?php if($newLoginUserInfo!=null){$i=0;foreach ($newLoginUserInfo as $row):$i=$i+1;?>
		  <li><a href="<?php echo site_url('member/other/'.$row['id']);?>" title="<?php echo $row['nickname'];?>"><img src="<?php echo $row['kAvatarImage'];?>" width="50px" height="50px" /></a><div><a href="<?php echo site_url('member/other/'.$row['id']);?>"><?php echo $row['nickname'];?></a></div></li>
		<?php endforeach;}?>
		</ul>
		<div class="katit1"><span><a href="<?php echo site_url('member/more/mbu');?>">更多&gt;&gt;</a></span><h3>有趣的人</h3></div>
		<ul class="kaul8">
		<?php if($maxBlogUserInfo!=null){$i=0;foreach ($maxBlogUserInfo as $row):$i=$i+1;?>
		  <li><a href="<?php echo site_url('member/other/'.$row['userId']);?>" title="<?php echo $row['nickname'];?>"><img src="<?php echo $row['kAvatarImage'];?>" width="50px" height="50px" /></a><div><a href="<?php echo site_url('member/other/'.$row['userId']);?>"><?php echo $row['nickname'];?></a></div></li>
		<?php endforeach;}?>
		</ul>
		<div class="clear"></div>
	</div>
	<!-- middle -->
	<div class="midcont2">
		<div class="katit1"><span><a href="<?php echo site_url('life');?>">正在聊天</a></span> <span><a onclick="pupInit('BlogMsg');" href="javascript:void(0)">我来说两句</a></span><h3>“<?php echo $blogUserInfoData['nickname'];?>”正在说</h3></div>
		<div class="kamtab1" id="con">
			<ul class="kaul9">
	<?php if($blogData!=null){foreach ($blogData as $row):?>
		<li id="b<?php echo $row['id'];?>"><a href='<?php echo site_url('member/other/'.$row['userId']);?>'><img src="<?php echo $row['kAvatarImage'];?>" width="50px" height="50px" /></a>
		<p><span><?php echo $row['nickname'];?></span>：<?php echo $row['content'];?><em><?php echo Tools::FormatTime($row['addDateTime']);?></em></p>
		</li>
	<?php endforeach;}?>
		</ul><div class="clear"></div>
		<div class="position2">
		<?php
		#var_dump(array('total'=>$total,'perpage'=>$perpage));
		$page=new page(array('total'=>$total,'perpage'=>$perpage));
		echo $page->show(3);
		?>
		</div>
		</div>
		<div class="clear"></div>
	</div>
	<!-- right -->
	<div class="rightcont2">
		<div class="katit1"><span><a href="#">热词</a></span><h4>关注度TOP<font class="redf">10</font></h4></div>
		<div class="kartab1">
		<table width="100%" border="0" cellspacing="3" cellpadding="0">
		<?php $i=0;foreach ($statisticsData1 as $row):$i=$i+1;?>
		  <tr>
			<td width="11%"><span class="<?php if($i<=3){echo 'kanumber1';}else{echo 'kanumber2';}?>"><?php echo $i;?></span></td>
			<td width="30%" class="redf"><a href="<?php echo site_url('member/other/'.$row['userId']);?>"><?php echo $row['nickname'];?></a></td>
			<td width="59%" align="right"><?php echo $row['staticValue'];?></td>
		  </tr>
		<?php endforeach;?>
		</table>
		<div class="clear"></div>
	</div>
	<div class="katit1"><span><a href="<?php echo site_url('member/more/mbu');?>">更多&gt;&gt;</a></span><h3>新加入会员</h3></div>
		<div class="kartab1">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<?php foreach ($newUserInfo as $row):?>
			  <tr height="45px">
				<td><a href="<?php echo site_url('member/other/'.$row['id']);?>" title="<?php echo $row['nickname'];?>">
					<img src="<?php echo $row['kAvatarImage'];?>" alt="<?php echo $row['nickname'];?>" width="40px" height="40px" /></a></td>
				<td><label>
				<?php #var_dump($row['kPWD']);?>
				<?php if($row['kPWD']=='0'){?>
				<input class="kabut3" type="button" id="af<?php echo $row['id'];?>" value="加为关注" 
					onclick="javascript:doFriend('<?php echo $row['id'];?>',this);" />
				<?php }else if($row['kPWD']=='1'){?>
				  <input class="kabut3" type="button" id="af<?php echo $row['id'];?>" value="已关注" disabled="disabled" />
				<?php }else if($row['kPWD']=='2'){?>
				  <input class="kabut3" type="button" id="af<?php echo $row['id'];?>" value="我自己" disabled="disabled" />
				<?php } ?>
				</label></td>
				<td>
				<input class="kabut3" type="button" id="sm<?php echo $row['id'];?>" value="发消息" 
					onclick="myPupInit('<?php echo $row['id'];?>')" <?php if($row['id']==$userId){ echo 'disabled="disabled"';} ?> />
				</td>
			  </tr>
			<?php endforeach;?>
		</table>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
<!-- first end -->
