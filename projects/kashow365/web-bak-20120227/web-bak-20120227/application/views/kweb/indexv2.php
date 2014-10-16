<script src="<?php echo base_url();?>kweb/js/jquery.timer.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kweb/js/jquery.slide.js" type="text/javascript" charset="UTF-8"></script>
<script type="text/javascript">
$(function (){
	// banner图片左右滚动
	$(".w_ctr .JQ-slide").Slide({
		effect:"scroolX",
		speed:"normal",
		timer:3000
	});
	
	$("#slider1 li").children(".a-img").hide();
	$("#slider1 li").children(".a-img").first().show();
	$("#slider2 li").children(".a-img").hide();
	$("#slider2 li").children(".a-img").first().show();

	$(".product li").hover(function(){
		$(this).children(".a-img").show().end().siblings().children(".a-img").hide();
	});
});

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
				$("#"+id).text("已关注");
				$("#"+id).attr("onclick","");
			}
			
		}
	});
}

function doAjax(){
	//表单参数
	var param = $("#formwj").serialize();
	var url = $("#formwj").attr("action");
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				alert("谢谢参与");
			}
			else
			{
				alert(obj.info);
			}
		}
	});
}

function MyBlogPupInit(re){
	if(re!=""){
		$("#cBlogMsg").val("回复@" + re + ":");
	}else{
		$("#cBlogMsg").val("");
	}

	pupInit('BlogMsg');
}


function ___getPageSize() {   
	var xScroll, yScroll;   
	if (window.innerHeight && window.scrollMaxY) {     
		xScroll = window.innerWidth + window.scrollMaxX;   
		yScroll = window.innerHeight + window.scrollMaxY;   
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac   
		xScroll = document.body.scrollWidth;   
		yScroll = document.body.scrollHeight;   
	} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari   
		xScroll = document.body.offsetWidth;   
		yScroll = document.body.offsetHeight;   
	}   
	var windowWidth, windowHeight;   
	if (self.innerHeight) { // all except Explorer   
		if(document.documentElement.clientWidth){   
			windowWidth = document.documentElement.clientWidth;    
		} else {   
			windowWidth = self.innerWidth;   
		}   
		windowHeight = self.innerHeight;   
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode   
		windowWidth = document.documentElement.clientWidth;   
		windowHeight = document.documentElement.clientHeight;   
	} else if (document.body) { // other Explorers   
		windowWidth = document.body.clientWidth;   
		windowHeight = document.body.clientHeight;   
	}      
	// for small pages with total height less then height of the viewport   
	if(yScroll < windowHeight){   
		pageHeight = windowHeight;   
	} else {    
		pageHeight = yScroll;   
	}   
	// for small pages with total width less then width of the viewport   
	if(xScroll < windowWidth){      
		pageWidth = xScroll;           
	} else {   
		pageWidth = windowWidth;   
	}   
	arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight);   
	return arrayPageSize;   
};  
function setTop(){
	var ie=___getPageSize();
	//alert(ie[0]-1040);
	if(ie[0]>1040){
		$("#top").attr("style","position:fixed;top:15em;right:"+(ie[0]-1040)/2+"px");
	}else{
		$("#top").attr("style","position:fixed;top:15em;right:0px");
	}
}

$(function(){
	setTop();
    $(window).resize(function(){
		window.setTimeout("setTop()",0);
	});
});

</script>
<!-- first start -->
<div class="bigcont1">
	<div class="advnew1">
		<?php if($ad1!=null && $ad1['value1']!=''){?>
		<?php 		if($ad1['count']==0){?>
			<a href="<?php echo $ad1['value2'];?>" target="_blank" title="<?php echo $ad1['value3'];?>">
				<img src="<?php echo $ad1['value1'];?>" width="980" height="70" /></a>
		<?php 		}else{ echo $ad1['value2']; }?>
		<?php }else{?>
			广告位-1 ( 980 * 70 )
		<?php } ?>
	</div>

		<!-- banner图片左右滚动 -->
		<div class="w_ctr">
			<div class="JQ-slide">
				<ul class="JQ-slide-content">
				<?php if($adinfo!=null){foreach ($adinfo as $row):?>
				<li><a href="<?php echo $row['value2'];?>" target="_blank"><img src="<?php echo $row['value1'];?>" alt="<?php echo $row['value3'];?>"  width="740px" height="380px"></a></li>
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
	  <div class="rcontnew1">
	  	<div class="rtabnew1">
		<h3>本周<font class="redf">最火爆活动</font></h3>
		<div class="rtabns1">
			<?php if($ad2!=null && $ad2['value1']!=''){?>
			<?php 		if($ad2['count']==0){?>
				<a href="<?php echo $ad2['value2'];?>" target="_blank">
					<img src="<?php echo $ad2['value1'];?>" width="201" height="67" /></a>
			<p><?php echo $ad2['value3'];?></p>
			<?php 		}else{ echo $ad2['value2']; }?>
			<?php }else{?>
				广告位-2 ( 201 * 67 )
			<?php } ?>
			<div class="clear"></div>
		</div>
		</div>
		<div class="advnew2">
			<?php if($ad3!=null && $ad3['value1']!=''){?>
			<?php 		if($ad3['count']==0){?>
				<a href="<?php echo $ad3['value2'];?>" target="_blank" title="<?php echo $ad3['value3'];?>">
					<img src="<?php echo $ad3['value1'];?>" width="226" height="100" /></a>
			<?php 		}else{ echo $ad3['value2']; }?>
			<?php }else{?>
				广告位-3 ( 226 * 100 )
			<?php } ?>
		</div>
		<div class="advnew2">
			<?php if($ad4!=null && $ad4['value1']!=''){?>
			<?php 		if($ad4['count']==0){?>
				<a href="<?php echo $ad4['value2'];?>" target="_blank" title="<?php echo $ad4['value3'];?>">
					<img src="<?php echo $ad4['value1'];?>" width="226" height="100" /></a>
			<?php 		}else{ echo $ad4['value2']; }?>
			<?php }else{?>
				广告位-4 ( 226 * 100 )
			<?php } ?>
		</div>
		<div class="clear"></div>
	  </div>
<div class="clear"></div>
</div>
<!-- first end -->
<!-- second start -->
<div class="bigcont1">
	<!-- left -->
	<div class="leftcontnew1">
		<div class="ltitnew1"><h3><font class="redf">品牌</font>商场<em>Brand</em></h3></div>
		<ul class="lulnew1">
			<?php $adIndexBrandAdi=0;if($adIndexBrandAd!=null){foreach ($adIndexBrandAd as $row):$adIndexBrandAdi++;?>
			<li <?php if($adIndexBrandAdi%10==0){ echo 'class="nopd"';} ?>><a href="<?php echo $row['value2'];?>" target="_blank"><img src="<?php echo $row['value1'];?>" alt="<?php echo $row['value3'];?>"  ></a></li>
			<?php endforeach;}?><!-- width="36" height="40" -->
		</ul><div class="clear"></div>
		<div class="advnew3">
			<?php if($ad5!=null && $ad5['value1']!=''){?>
			<?php 		if($ad5['count']==0){?>
				<a href="<?php echo $ad5['value2'];?>" target="_blank" title="<?php echo $ad5['value3'];?>">
					<img src="<?php echo $ad5['value1'];?>" width="739" height="70" /></a>
			<?php 		}else{ echo $ad5['value2']; }?>
			<?php }else{?>
				广告位-5 ( 739 * 70 )
			<?php } ?>
		</div>
		<div class="ltitnew2"><span><a href="<?php echo site_url('spell');?>" target="_blank">更多&gt;&gt;</a></span><h3><font class="redf">合伙</font>拼卡<em>Fight card</em></h3></div>
		<div class="ltabnew3">
			<?php if($ad11!=null && $ad11['value1']!=''){?>
			<?php 		if($ad11['count']==0){?>
				<a href="<?php echo $ad11['value2'];?>" target="_blank" title="<?php echo $ad11['value3'];?>" target="_blank">
					<img src="<?php echo $ad11['value1'];?>" width="456" height="273" /></a>
			<?php 		}else{ echo $ad11['value2']; }?>
			<?php }else{?>
				广告位-11 ( 456 * 273 )
			<?php } ?>
		</div>
		<div class="product" id="slider1">
			<ul>
				<?php if($adIndexSpellAd!=null){foreach ($adIndexSpellAd as $row):?>
				<li>
				<h5><a href="<?php echo $row['value2'];?>" title="<?php echo $row['value3'];?>" target="_blank"><?php echo String::cut($row['value3'],36);?></a></h5>
				<div class="a-img"><a href="<?php echo $row['value2'];?>" title="<?php echo $row['value3'];?>"
				target="_blank"><img alt="" src="<?php echo $row['value1'];?>" width="266px" height="115px"></a></div></li>
				<?php endforeach;}?>
			</ul>
          </div><div class="clear"></div>
		  <ul class="lulnew2">
			  <?php if($cardSpellData!=null){foreach ($cardSpellData as $row):?>
			  <li><a href="<?php echo site_url('spell/spellxl/'.$row['id']);?>" title="<?php echo $row['name'];?>" target="_blank"><img src="<?php echo $row['cardImagePath'];?>" width="106px" height="106px" /></a><div><a href="<?php echo site_url('spell/spellxl'.$row['id']);?>" title="<?php echo $row['name'];?>" target="_blank"><?php echo String::cut($row['name'],15);?></a></div><div>报名人数：<?php echo $row['regCount'];?></div><div><em>有效日期：<?php echo $row['endDate'];?></em></div></li>
			  <?php endforeach;}?>
		  </ul><div class="clear"></div>
		  <div class="advnew3">
				<?php if($ad6!=null && $ad6['value1']!=''){?>
				<?php 		if($ad6['count']==0){?>
					<a href="<?php echo $ad6['value2'];?>" target="_blank" title="<?php echo $ad6['value3'];?>" target="_blank">
						<img src="<?php echo $ad6['value1'];?>" width="739" height="70" /></a>
				<?php 		}else{ echo $ad6['value2']; }?>
				<?php }else{?>
					广告位-6 ( 739 * 70 )
				<?php } ?>
		  </div>
		  <div class="ltitnew2"><span><a href="<?php echo site_url('sale');?>" target="_blank">更多&gt;&gt;</a></span><h3><font class="redf">有买</font>有卖<em>Sale</em></h3></div>
		<div class="ltabnew3">
			<?php if($ad12!=null && $ad12['value1']!=''){?>
			<?php 		if($ad12['count']==0){?>
				<a href="<?php echo $ad12['value2'];?>" target="_blank" title="<?php echo $ad12['value3'];?>" target="_blank">
					<img src="<?php echo $ad12['value1'];?>" width="456" height="273" /></a>
			<?php 		}else{ echo $ad12['value2']; }?>
			<?php }else{?>
				广告位-12 ( 456 * 273 )
			<?php } ?>
		</div>
		<div class="product" id="slider2">
			<ul>
			  	<?php if($adIndexSaleAd!=null){foreach ($adIndexSaleAd as $row):?>
				<li>
				<h5><a href="<?php echo $row['value2'];?>" title="<?php echo $row['value3'];?>" target="_blank"><?php echo String::cut($row['value3'],36);?></a></h5>
				<div class="a-img"><a href="<?php echo $row['value2'];?>" title="<?php echo $row['value3'];?>"
				target="_blank"><img alt="" src="<?php echo $row['value1'];?>" width="266px" height="115px"></a></div></li>
				<?php endforeach;}?>
			  </ul>
          </div><div class="clear"></div>
		  <ul class="lulnew2">
			<?php if($cardData!=null){foreach ($cardData as $row):?>
			<?php if($row['cardSetType'] == 1){ ?>
			<li><a href="<?php echo site_url('sale/rebatsale/'.$row['id']);?>"  title="<?php echo $row['name'];?>" target="_blank"><img src="<?php echo $row['cardImagePath'];?>" width="106px" height="106px" /></a><div><a href="<?php echo site_url('sale/rebatsale/'. $row['id']);?>" title="<?php echo $row['name'];?>" target="_blank"><?php echo String::cut($row['name'],15);?></a></div><div>市场价 ￥<?php echo $row['price'];?></div><div><em>售价 ￥<?php echo $row['sellingPrice'];?></em></div></li>
			<?php } else { ?>
			<li><a href="<?php echo site_url('sale/rebatshow/'.$row['id']);?>"  title="<?php echo $row['name'];?>" target="_blank"><img src="<?php echo $row['cardImagePath'];?>" width="106px" height="106px" /></a><div><a href="<?php echo site_url('sale/rebatshow/'. $row['id']);?>" title="<?php echo $row['name'];?>" target="_blank"><?php echo String::cut($row['name'],15);?></a></div><div>有效期 <?php echo date('Y-m-d', strtotime($row['period']));?></div><div><em>用途 <?php echo String::cut(Tools::GetCardUse($row['cardUse']),12);?></em></div></li>
			<?php } ?>
			<?php endforeach;}?>
		  </ul><div class="clear"></div>
		  <div class="advnew3">
				<?php if($ad7!=null && $ad7['value1']!=''){?>
				<?php 		if($ad7['count']==0){?>
					<a href="<?php echo $ad7['value2'];?>" target="_blank" title="<?php echo $ad7['value3'];?>">
						<img src="<?php echo $ad7['value1'];?>" width="739" height="70" /></a>
				<?php 		}else{ echo $ad7['value2']; }?>
				<?php }else{?>
					广告位-7 ( 739 * 70 )
				<?php } ?>
		  </div>
		  <div class="ltitnew2"><span><a href="<?php echo site_url('life');?>" target="_blank">更多&gt;&gt;</a></span><span><a onclick="MyBlogPupInit('')" href="javascript:void(0)">我来说两句</a></span><h3><font class="redf">生活</font>广场<em>Life</em></h3></div>
		  <ul class="lulnew3">
			<?php 
				$menberCss="";$check=0;
				if($blogData!=null){foreach ($blogData as $row):
					$check++;
					switch($check)
					{
						case 1:
							$menberCss="greenf";
							break;
						case 2:
							$menberCss="yelf";
							break;
						case 3:
							$menberCss="bluef";
							break;
						case 4:
							$menberCss="bluef2";
							break;
						case 5:
							$menberCss="redf2";
							break;
						case 6:
							$menberCss="bluef3";
							break;
					}
			?>
			<?php if($check%2==1){?>
			<li id="b<?php echo $row['id'];?>"><div class="lulmember"><a href="<?php echo site_url('member/other/'.$row['userId']);?>" target="_blank"><img src="<?php echo $row['kAvatarImage'];?>" /></a></div><div class="lulpltab margl10"><h4><strong class="<?php echo $menberCss; ?>"><?php echo $row['nickname'];?>：</strong><?php echo String::cut($row['content'],56);?></h4><div class="bot"><?php echo Tools::FormatTime($row['addDateTime']);?> <a href="<?php echo site_url('life/more/'.$row['userId']);?>">看他都说过什么&gt;&gt;&gt;</a></div></div></li>
			<?php }else{ ?>
			<li id="b<?php echo $row['id'];?>" class="ru3"><div class="lulpltab2 margr10"><h4><strong class="<?php echo $menberCss; ?>"><?php echo $row['nickname'];?>：</strong><?php echo String::cut($row['content'],56);?></h4><div class="bot"><?php echo Tools::FormatTime($row['addDateTime']);?> <a href="<?php echo site_url('life/more/'.$row['userId']);?>">看他都说过什么&gt;&gt;&gt;</a></div></div><div class="lulmember"><a href="<?php echo site_url('member/other/'.$row['userId']);?>" target="_blank"><img src="<?php echo $row['kAvatarImage'];?>" /></a></div></li>
			<?php } ?>
			<?php endforeach;}?>
		  </ul>
	</div>
	<!-- right -->
	<div class="rcontnew1">

		 <div class="rtitnew1 martop15"><span><a href="<?php echo site_url('news/annount');?>" target="_blank">更多&gt;&gt;</a></span>
		  <h3><font class="redf">最新</font>公告<em>news</em></h3></div>
		 <div class="rtabnew2">
		 <ul>
		 <?php if($annount!=null){foreach ($annount as $row):?>
		 <li><a href="<?php echo site_url('news/annountcontent/'. $row['id']);?>" target="_blank" title="<?php echo $row['newsSummary'];?>"><?php echo String::cut($row['newsSummary'],28);?></a></li>
		 <?php endforeach;}?>
		 </ul>
		 </div>
		 <div class="advnew2">
			<?php if($ad8!=null && $ad8['value1']!=''){?>
			<?php 		if($ad8['count']==0){?>
				<a href="<?php echo $ad8['value2'];?>" target="_blank" title="<?php echo $ad8['value3'];?>">
					<img src="<?php echo $ad8['value1'];?>" width="226" height="70" /></a>
			<?php 		}else{ echo $ad8['value2']; }?>
			<?php }else{?>
				广告位8 ( 226 * 70 )
			<?php } ?>
		 </div>
		 <div class="rtitnew1 martop15"><span><a href="<?php echo site_url('news/conversion');?>" target="_blank">更多&gt;&gt;</a></span>
		  <h3><font class="redf">积分</font>兑换<em>Exchange</em></h3></div>
		 <div class="rtabnew2">
		 <ul>
		 <?php if($news3!=null){foreach ($news3 as $row):?>
		 <li><a href="<?php echo site_url('news/conversioncontent/'. $row['id']);?>" target="_blank" title="<?php echo $row['newsSummary'];?>"><?php echo String::cut($row['newsSummary'],28);?></a></li>
		 <?php endforeach;}?>
		 </ul>
		 </div>
		 <div class="advnew2">
			<?php if($ad9!=null && $ad9['value1']!=''){?>
			<?php 		if($ad9['count']==0){?>
				<a href="<?php echo $ad9['value2'];?>" target="_blank" title="<?php echo $ad9['value3'];?>">
					<img src="<?php echo $ad9['value1'];?>" width="226" height="70" /></a>
			<?php 		}else{ echo $ad9['value2']; }?>
			<?php }else{?>
				广告位9 ( 226 * 70 )
			<?php } ?>
		</div>
		 <div class="rtitnew1 martop15"><span><a href="<?php echo site_url('news/discount');?>" target="_blank">更多&gt;&gt;</a></span>
		  <h3><font class="redf">打折</font>快报<em>SALE</em></h3></div>
		 <div class="rtabnew2">
		 <ul>
		 <?php if($news2!=null){foreach ($news2 as $row):?>
		 <li><a href="<?php echo site_url('news/discountcontent/'. $row['id']);?>" target="_blank" title="<?php echo $row['newsSummary'];?>"><?php echo String::cut($row['newsSummary'],28);?></a></li>
		 <?php endforeach;}?>
		 </ul>
		 </div>
		 <div class="advnew2">
			<?php if($ad10!=null && $ad10['value1']!=''){?>
			<?php 		if($ad10['count']==0){?>
				<a href="<?php echo $ad10['value2'];?>" target="_blank" title="<?php echo $ad10['value3'];?>">
					<img src="<?php echo $ad10['value1'];?>" width="226" height="70" /></a>
			<?php 		}else{ echo $ad10['value2']; }?>
			<?php }else{?>
				广告位10 ( 226 * 70 )
			<?php } ?>
		 </div>
		 <div class="rtitnew1 martop15"><span><a href="<?php echo site_url('life');?>">更多&gt;&gt;</a></span>
		  <h3><font class="redf">会员</font>专区<em>menber</em></h3></div>
		 <div class="rtabnew3">
		 <ul>
			<?php if($newUserInfo!=null){$cp=0;foreach ($newUserInfo as $row):$cp++?>
			<li <?php if($cp!=count($newUserInfo)){echo 'class="li"';} ?>><div class="lpic3"><a href="<?php echo site_url('member/other/'.$row['id']);?>" target="_blank" title="<?php echo $row['nickname'];?>"><img src="<?php echo $row['kAvatarImage'];?>" width="50" height="50" /></a></div><div class="lrtxt3"><h4><a href="<?php echo site_url('member/other/'.$row['id']);?>" target="_blank" title="<?php echo $row['nickname'];?>"><?php echo $row['nickname'];?></a></h4><p title="<?php echo $row['Signature'];?>"><?php echo String::cut($row['Signature'],22);?></p>
			<p>
			<?php if($row['kPWD']=='0'){?>
			<a href="javascript:void(0)" id="af<?php echo $row['id'];?>" onclick="javascript:doFriend('<?php echo $row['id'];?>',this);"><img src="<?php echo base_url();?>kweb/imagesv2/icon_add.gif" /> 关注我</a>
			<?php }else if($row['kPWD']=='1'){?>
			<a href="javascript:void(0)" id="af<?php echo $row['id'];?>"><img src="<?php echo base_url();?>kweb/imagesv2/icon_add.gif" /> 已关注</a>
			<?php }else if($row['kPWD']=='2'){?>
			<a href="javascript:void(0)" id="af<?php echo $row['id'];?>"><img src="<?php echo base_url();?>kweb/imagesv2/icon_add.gif" /> 我自己</a>
			<?php } ?>
			</p></div></li>
			<?php endforeach;}?>
		 </ul>
		 <div class="clear"></div>
		 </div>
		 <div class="rtitnew1 martop15"><span><a href="<?php echo site_url('life');?>">更多&gt;&gt;</a></span>
		  <h3><font class="redf">有趣</font>的人<em>interesting</em></h3></div>
		 <div class="rtabnew3">
		 <ul>
			<?php if($ppUserInfo!=null){$cp=0;foreach ($ppUserInfo as $row):$cp++;?>
			<li <?php if($cp!=count($ppUserInfo)){echo 'class="li"';} ?> ><div class="lpic3"><a href="<?php echo site_url('member/other/'.$row['id']);?>" target="_blank" title="<?php echo $row['nickname'];?>"><img src="<?php echo $row['kAvatarImage'];?>" width="50" height="50" /></a></div><div class="lrtxt3"><h4><a href="<?php echo site_url('member/other/'.$row['id']);?>" target="_blank" title="<?php echo $row['nickname'];?>"><?php echo $row['nickname'];?></a></h4><p title="<?php echo $row['Signature'];?>"><?php echo String::cut($row['Signature'],22);?></p>
			<p>
			<?php if($row['kPWD']=='0'){?>
			<a href="javascript:void(0)" id="af<?php echo $row['id'];?>" onclick="javascript:doFriend('<?php echo $row['id'];?>',this);"><img src="<?php echo base_url();?>kweb/imagesv2/icon_add.gif" /> 关注我</a>
			<?php }else if($row['kPWD']=='1'){?>
			<a href="javascript:void(0)" id="af<?php echo $row['id'];?>"><img src="<?php echo base_url();?>kweb/imagesv2/icon_add.gif" /> 已关注</a>
			<?php }else if($row['kPWD']=='2'){?>
			<a href="javascript:void(0)" id="af<?php echo $row['id'];?>"><img src="<?php echo base_url();?>kweb/imagesv2/icon_add.gif" /> 我自己</a>
			<?php } ?>
			</p></div></li>
			<?php endforeach;}?>
		 </ul>
		 <div class="clear"></div>
		 </div>
		 <div class="rtitnew1 martop15"><!--<span><a href="#">更多&gt;&gt;</a>--></span>
		  <h3><font class="redf">问卷</font>调查<em>Survey</em></h3></div>
		  <div class="rtabnew2">
		  	<?php if($wjP != null && count($wjP)>0){ ?>
			 <form id="formwj" name="formwj" action="<?php echo site_url("index/dowj");?>" method="post" target="_blank">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td><?php echo $wjP[0]['problem']; ?></td>
				  </tr>
				  <?php $isfirest = true;if($wjA!=null){foreach ($wjA as $row):?>
				  <tr>
					<td><input name="aid" type="radio" value="<?php echo $row['id'];?>" <?php if($isfirest){ echo 'checked="checked"'; $isfirest=false;} ?> /> 
					<?php echo $row['anser'];?></td>
				  </tr>
				  <?php endforeach;}?>
				  <tr>
					<td align="center" style="height:28px">
						<!--<input type="submit" value="go" />-->
						<input type="hidden" id="pid" name="pid" value="<?php echo $wjP[0]['id']; ?>" />
						<a href="javascript:void(0)" onclick="doAjax()"><img alt="确定" src="<?php echo base_url();?>kweb/imagesv2/kabut15.jpg"  /></a>　
					</td>
				  </tr>
				</table>
			 </form>
			<?php } ?>
		  </div>
	</div>
	<div class="clear"></div>
</div>
<!-- second end -->
<div id="top" class="returtop"><a href="javascript:void(0)" onclick="goTop()"><img src="<?php echo base_url();?>kweb/imagesv2/top.gif" /></a></div>