<script src="<?php echo base_url();?>kweb/js/formValidator-4.1.1.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/formValidatorRegex.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/jquery.timer.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kweb/js/login.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/marquee.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/jquery.slide.js" type="text/javascript" charset="UTF-8"></script>
<script type="text/javascript">
$(document).ready(function(){
	$.formValidator.initConfig({theme:"Default",submitOnce:true,formID:"form1",
		onError:function(msg){$("#msg").html(msg);},
		submitAfterAjaxPrompt : '有数据正在异步验证，请稍等...',
		buttons: $("#button"),
		debug:false
	});

	$("#l")
	<?php if($kLoginName == ''){?>
	.formValidator({
		onShowText:"请输入登录邮箱"
		,onShow:""
	})
	<?php }?>
	.inputValidator({
		min:1
		,onError:"账号未输入"
	}).regexValidator({
		regExp:"^([\\w-.]+)@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.)|(([\\w-]+.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(]?)$"
		,onError:"登录邮箱输入不正确"
	});
	
	<?php if($kPWD == '1'){?>
	$("#p").formValidator({
	    onShowText:"**********"
	});
	<?php }?>
});


$(document).ready(function(){
	startmarquee(20,20,2000); 
});

/*
$(function (){
	// banner图片左右滚动
	$(".w_ctr .JQ-slide").Slide({
		effect:"scroolX",
		speed:"normal",
		timer:3000
	});
});
*/
</script>
<!-- first start -->
<div class="bigcont">
	<!-- banner图片左右滚动
	<div class="w_ctr">
		<div class="JQ-slide">
			<ul class="JQ-slide-content">
			<?php if($adinfo!=null){foreach ($adinfo as $row):?>
			<li><a href="<?php echo $row['value2'];?>" target="_blank"><img src="<?php echo $row['value1'];?>" width="632px" height="136px" alt="<?php echo $row['value3'];?>" /><span><?php echo $row['value3'];?></span></a></li>
			<?php endforeach;}?>
			</ul>
			<ul class="JQ-slide-nav">
				<?php if($adinfo!=null){for($i=1,$count=count($adinfo); $i<=$count; $i++):?>
				<li <?php if($i==1){echo 'class="on"';}?>><?php echo $i;?></li>
				<?php endfor;}?>
			</ul>
		</div>
	</div>
	 banner图片左右滚动 -->
	<script src="<?php echo base_url();?>kweb/js/png.js" type="text/javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>kweb/js/loopedslider.min.js" type="text/javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>kweb/js/focus.js" type="text/javascript" charset="UTF-8"></script>
	<!--焦点图-->
	<DIV id="newsSlider">
	<DIV class="container">
	<UL class="slides">
		<?php $i=1; ?>
		<?php if($adinfo!=null){foreach ($adinfo as $row):?>
		<?php if($i==1){?><li><?php }?>
		<a href="<?php echo $row['value2'];?>" target="_blank"><img src="<?php echo $row['value1'];?>" width="178px" height="90px" alt="<?php echo $row['value3'];?>" /></a>
		<?php if($i==3){$i=0;?></li><?php }?>
		<?php $i=$i+1; ?>
		<?php endforeach;}?>
		<?php 
			$i=1;
			$count=3;
			if($adinfo!=null){
				$i = count($adinfo)%3+1;
				$count = ceil(count($adinfo)/3)*3-count($adinfo);
			}
			for($item=1; $item<=$count; $item++):?>
			<?php if($i==1){?><li><?php }?>
			<a href="#" target="_blank"><img src="" width="178px" height="90px" /></a>
			<?php if($i==3){$i=0;?></li><?php }?>
			<?php $i=$i+1; ?>
		<?php endfor;?>
	</UL>
	</DIV>
	<DIV class="validate_Slider"></DIV>
	<UL class="pagination">
		<?php if($adinfo!=null){for($i=1,$count=ceil(count($adinfo)/3); $i<=$count; $i++):?>
		<LI><A href="#">&nbsp;</A> </LI>
		<?php endfor;}else{?>
		<LI><A href="#">&nbsp;</A> </LI>
		<?php } ?>
	</UL><div class="clear"></div></DIV>
	<!--焦点图-->
	
	<div id="nologin" class="login" <?php if($userId!=''){echo 'style="display:none"';} ?>>
	<form id="form1" name="form1" action="<?php echo site_url("login/dologin");?>" method="post">
	  <table width="100%" border="0" cellspacing="3" cellpadding="0">
        <tr>
          <td>Email：</td>
          <td><label>
            <input class="kainput2" id="l" name="l" type="text" <?php if($kLoginName != ''){ echo 'value="'.$kLoginName.'"';}?>  />
          </label></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="pdtop10">密 码：</td>
          <td><label>
            <input class="kainput2" id="p" name="p" type="password" <?php if($kPWD == ''){ echo 'value="'.$kPWD.'"';}?>/>
          </label></td>
          <td class="bluef"><a href="<?php echo site_url("changepwd");?>">忘记密码</a></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2" valign="middle"><label>
          <input type="checkbox" id="r" name="r" value="1" /> 记住我　</label>
		  <span class="bluef"><a href="<?php echo site_url('register');?>">马上注册</a></span>　
          <input class="kabut2" type="button" id="button" name="button" value="登 录" />
          </td>
        </tr>
      </table>
	  <div id="msg" style="width:280px"></div>
	</form>
	</div>
	<div id="logined" class="login" <?php if($userId==''){echo 'style="display:none"';} ?>>
		昵称：<a href="<?php echo site_url('member');?>"><?php echo $loginedUserInfo['nickname'];?></a>  
		( 
		<?php if($loginedUserInfo['kState']=='0'){?> <img src="<?php echo base_url();?>kweb/images/nook.png" alt="未验证" /> <span style="color:#9d9d9d" >未验证</span> <?php }?> 
		<?php if($loginedUserInfo['kState']=='1'){?> <img src="<?php echo base_url();?>kweb/images/ok.png" alt="已验证" /> <span>已验证</span> <?php }?> 
		<?php if($loginedUserInfo['kState']=='2'){?> <img src="<?php echo base_url();?>kweb/images/nook.png" alt="禁止登录" /> <?php }?> 
		) <a href="<?php echo site_url('member');?>">我的主页</a> 
		<a href="<?php echo site_url("index/dologout");?>">退出</a>
		<br />
		会员等级: <?php echo $loginedUserInfo['gradeName'];?> <br />
		会员积分: <?php echo $loginedUserInfo['kPoints'];?> ks币<br />
		拥有卡的数量: <?php echo $loginedUserInfo['kCount'];?> 个<br />
		关注我的好友数： <?php echo $loginedUserInfo['kLookmeCount'];?> 位好友<br />
	</div>
<div class="clear"></div>
</div>
<!-- first end -->
<!-- second start -->
<div class="bigcont">
	<!-- left -->
	<div class="leftcont1 martop25">
		<div class="gongao">
		<h3>听说:</h3>
		<div style="overflow: hidden; height: 23px; margin-left: 5px;"> 
		 	<div id="marqueebox" style="margin-top: -48px; height: 252px;"> 
			<ul>
			<?php if($heari!=null){foreach ($heari as $row):?>
			<li>·<a href="<?php echo $row['value2'];?>"><?php echo $row['value1'];?></a></li>
			<?php endforeach;}?>
			</ul>
			</div> 
		</div> 
		<div class="clear0"></div></div>


		
		<div class="katit1 marbot10"><span><a href="<?php echo site_url('sale');?>">更多&gt;&gt;</a></span><h3>有买有卖</h3><div class="clear"></div></div>
		<ul class="kaul1">
		<?php if($cardData!=null){foreach ($cardData as $row):?>
		<li><a href="<?php echo site_url('sale/rebatsale/'.$row['id']);?>"><img src="<?php echo $row['cardImagePath'];?>" alt="<?php echo $row['name'];?>" /></a><div><a href="<?php echo site_url('sale/rebatsale/'. $row['id']);?>" title="<?php echo $row['name'];?>"><?php echo String::cut($row['name'],24);?></a></div><div><em>市场价 ￥<?php echo $row['price'];?></em></div><div><cite>售价 ￥<?php echo $row['sellingPrice'];?></cite></div></li>
		<?php endforeach;}?>
		</ul>
		<div class="adv">
		<?php if($ad1!=null && $ad1['value1']!=''){?>
			<a href="<?php echo $ad1['value2'];?>" target="_blank" title="<?php echo $ad1['value3'];?>">
				<img src="<?php echo $ad1['value1'];?>" width="632" height="60" /></a>
		<?php }else{?>
			广告位-1 ( 632 * 60 )
		<?php } ?>
		</div>
		<div class="katit1 marbot10"><span><a href="<?php echo site_url('spell');?>">更多&gt;&gt;</a></span><h3>合伙拼卡</h3><div class="clear"></div></div>
		<ul class="kaul1">
		<?php if($cardSpellData!=null){foreach ($cardSpellData as $row):?>
		<li><a href="<?php echo site_url('spell/spellxl/'.$row['id']);?>"><img src="<?php echo $row['cardImagePath'];?>"  alt="<?php echo $row['name'];?>"/></a><div><a href="<?php echo site_url('spell/spellxl'.$row['id']);?>"><?php echo $row['name'];?></a></div><div><em>限制人数 <?php echo $row['limitUser'];?>人</em></div><div><cite>到期日期 <?php echo $row['endDate'];?></cite></div></li>
		<?php endforeach;}?>
		</ul>
		<div class="adv">
		<?php if($ad2!=null && $ad2['value1']!=''){?>
			<a href="<?php echo $ad2['value2'];?>" target="_blank" title="<?php echo $ad2['value3'];?>">
				<img src="<?php echo $ad2['value1'];?>" width="632" height="60" /></a>
		<?php }else{?>
			广告位-2 ( 632 * 60 )
		<?php } ?>
		</div>
		<div class="katit1"><span><a href="<?php echo site_url('life');?>">更多&gt;&gt;</a></span><h3>生活广场</h3><div class="clear"></div></div>
		<ul class="kaul2">
		<?php if($blogData!=null){foreach ($blogData as $row):?>
		<li id="b<?php echo $row['id'];?>" class="noline1"><a href='<?php echo site_url('member/other/'.$row['userId']);?>'><img src="<?php echo $row['kAvatarImage'];?>" width="50px" height="50px" /></a>
		<p><span><?php echo $row['nickname'];?></span>：<?php echo $row['content'];?><em><?php echo Tools::FormatTime($row['addDateTime']);?> <a href="<?php echo site_url('life/more/'.$row['userId']);?>"><span>看他都说过什么&gt;&gt;&gt;</span></a></em></p>
		</li>
		<?php endforeach;}?>
		</ul>
		<div class="clear"></div>
	</div>
	<!-- right -->
	<div class="rightcont1 martop25">
		<div class="katit1"><h3>kashow公告</h3><div class="clear"></div></div>
		<div class="kartab1"><?php echo $annount;?></div>
		<div class="katit1"><h3>会员数字</h3><div class="clear"></div></div>
		<div class="kartab1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>·储值卡：<span class="redf"><?php echo $webStatistics['WebTotcalCZ'];?></span> 张</td>
    <td>·积分卡：<span class="redf"><?php echo $webStatistics['WebTotcalJF'];?></span> 张</td>
    <td>·会员卡：<span class="redf"><?php echo $webStatistics['WebTotcalHY'];?></span> 张</td>
  </tr>
  <tr>
    <td>·体验卡：<span class="redf"><?php echo $webStatistics['WebTotcalTY'];?></span> 张</td>
    <td>·提货卡：<span class="redf"><?php echo $webStatistics['WebTotcalTH'];?></span> 张</td>
    <td>·会员数：<span class="redf"><?php echo $webStatistics['WebTotcalUser'];?></span> 名</td>
  </tr>
</table>
</div>
		<div class="adv">
		<?php if($ad3!=null && $ad3['value1']!=''){?>
			<a href="<?php echo $ad3['value2'];?>" target="_blank" title="<?php echo $ad3['value3'];?>">
				<img src="<?php echo $ad3['value1'];?>" width="331" height="60" /></a>
		<?php }else{?>
			广告位-3 ( 331 * 60 )
		<?php } ?>
		</div>
		<div class="katit1"><span><a href="<?php echo site_url('news/activity');?>">更多&gt;&gt;</a></span><h3>最新活动</h3><div class="clear"></div></div>
		<div class="kaul3"><ul>
		<?php if($news1!=null){foreach ($news1 as $row):?>
		<li><h3><a href="<?php echo site_url('news/activitycontent/'. $row['id']);?>"><?php echo $row['newsTitle'];?></a></h3><?php echo $row['newsSummary'];?></li>
		<?php endforeach;}?>
		</ul></div>
		<div class="katit1"><span><a href="<?php echo site_url('news/discount');?>">更多&gt;&gt;</a></span><h3>打折快报</h3><div class="clear"></div></div>
		<div class="kaul3"><ul>
		<?php if($news2!=null){foreach ($news2 as $row):?>
		<li><h3><a href="<?php echo site_url('news/discountcontent/'. $row['id']);?>"><?php echo $row['newsTitle'];?></a></h3><?php echo $row['newsSummary'];?></li>
		<?php endforeach;}?>
		</ul></div>
		<div class="adv">
		<?php if($ad4!=null && $ad4['value1']!=''){?>
			<a href="<?php echo $ad4['value2'];?>" target="_blank" title="<?php echo $ad4['value3'];?>">
				<img src="<?php echo $ad4['value1'];?>" width="331" height="60" /></a>
		<?php }else{?>
			广告位-4 ( 331 * 60 )
		<?php } ?>
		</div>
		<div class="katit1"><span><a href="<?php echo site_url('news/conversion');?>">更多&gt;&gt;</a></span><h3>kashow兑换通知</h3><div class="clear"></div></div>
		<div class="kaul3"><ul>
		<?php if($news3!=null){foreach ($news3 as $row):?>
		<li><h3><a href="<?php echo site_url('news/conversioncontent/'. $row['id']);?>"><?php echo $row['newsTitle'];?></a></h3><?php echo $row['newsSummary'];?></li>
		<?php endforeach;}?>
		</ul></div>
	<div class="clear"></div>
	</div>
<div class="clear"></div>
</div>
<!-- second end -->