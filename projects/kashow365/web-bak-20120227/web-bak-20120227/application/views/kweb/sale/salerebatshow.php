<script type="text/javascript" src="<?php echo base_url();?>kweb/public/kindeditor-3.5.5-zh_CN/kindeditor.js"></script>
<script src="<?php echo base_url();?>kweb/js/jquery.timer.js" type="text/javascript"></script>
<script type="text/javascript">
function doAjax(url){
	var n=1;
	// 分离页面 '/index.php/member?n=2'
	var regExp = /n=(\d+)/ig;
	if(regExp.test(url)){
		regExp = /n=(\d+)/ig;
		n = regExp.exec(url)[1];
	}

	//表单参数
	var cid="<?php echo $id;?>";
	param = "n="+n+"&cid="+cid;
	url = "<?php echo site_url("sale/doajaxrebat");?>";
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			//alert(obj.status);
			if(obj.status)
			{
				$("#pancm").empty();
				$("#pancm").append(obj.data);
			}
			else
			{
				alert(obj.info);
			}
		}
	});
}
function dosave(){
	$("#button").attr("disabled",true);
	$("#content").attr("readonly","readonly");
	$("#content").addClass("disableText");
	
	//表单参数
	KE.util.setData("content");
	
	// 清空默认值
	if($.trim($("#content").val()) == ""){alert("人不能说空话");return;}

	$("#formcm").submit();
}


function Finish(status, info){
	if(status=="1")
	{
		//alert(obj.info);
		$("#msg").html(info);
		$("#button").oneTime(1000,"hide", function() {
			$("#msg").html("");
			document.getElementById("button").removeAttribute("disabled"); 
			document.getElementById("content").removeAttribute("readOnly"); 
			$("#content").removeClass("disableText");
			KE.util.setFullHtml("content", "");
			var url = "<?php echo site_url("sale/rebat/".$id);?>";
			var cid="<?php echo $id;?>";
			var param = "n=1&cid="+cid;
			doAjax(url+param);
		});
	}
	else
	{
		alert(info);
		$("#msg").html(info);
		// $("#button").removeAttr("disabled");
		document.getElementById("button").removeAttribute("disabled"); 
		document.getElementById("content").removeAttribute("readOnly"); 
		$("#content").removeClass("disableText");
	}
}
function MyPupInit(){
	var url = "<?php echo current_url();?>";
	$("#umSystemAdd").val(" <a href=\""+url+"\" target=\"_blank\">点击查看该卡</a>");
	pupInit('UserMsg');
}
</script>
<style type="text/css">
	.disableText{ background-color:#E3E3E3;}
</style>
<!-- first start -->
<br />
<div class="bigcont">
	<div class="kalpic1"><img src="<?php echo $cardImagePath;?>" /></div>
    <div class="kartab2">
    <div class="kalist2">商品名称： <?php echo $name;?></div>
    <div class="kalist2">卡的种类：
		<span class="<?php if(strpos(','.$cardType.',',',1,')!==false){echo 'selected';}else{echo 'disabled';}?>">餐饮</span>&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="<?php if(strpos(','.$cardType.',',',2,')!==false){echo 'selected';}else{echo 'disabled';}?>">购物</span>&nbsp;&nbsp;&nbsp;&nbsp; 
		<span class="<?php if(strpos(','.$cardType.',',',3,')!==false){echo 'selected';}else{echo 'disabled';}?>">丽人</span>&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="<?php if(strpos(','.$cardType.',',',4,')!==false){echo 'selected';}else{echo 'disabled';}?>">休闲</span></div>
    <div class="kalist2" style="padding-left:75px;">
		<span class="<?php if(strpos(','.$cardType.',',',5,')!==false){echo 'selected';}else{echo 'disabled';}?>">运动</span>&nbsp;&nbsp;&nbsp;&nbsp; 
		<span class="<?php if(strpos(','.$cardType.',',',6,')!==false){echo 'selected';}else{echo 'disabled';}?>">旅游</span> </div>
	<div class="kalist3">拼卡方式： 
		<span class="<?php if(strpos(','.$wayFight.',',',1,')!==false){echo 'selected';}else{echo 'disabled';}?>">打折</span>&nbsp;&nbsp;&nbsp;&nbsp; 
		<span class="<?php if(strpos(','.$wayFight.',',',2,')!==false){echo 'selected';}else{echo 'disabled';}?>">积分</span></div>
    <div class="kalist3"><input class="seabut" name="btnbuy" type="button" value="我要了解" onclick="MyPupInit()" />
      <label>
        <input class="seabut" type="button" name="btnreset" id="btnreset" value="重新挑选" onclick="location.href='<?php echo site_url("sale");?>'" />
      </label>
    </div>
    <div id="demo" class="kaul12">
		<div style="margin:23px 0 0 15px; height:74px;">
			<table>
				<tr>
					<td width="180">地&nbsp;&nbsp;&nbsp;&nbsp;点： 北京 <?php echo $districtName;?> <?php echo $urbanIdName;?></td>
					<td>有&nbsp;&nbsp;效&nbsp;&nbsp;期： <?php echo $period;?></td>
				</tr>
				<tr>
					<td>市场价： <?php echo $price;?> 元</td>
					<td>卡的售价： <?php echo $sellingPrice;?> 元</td>
				</tr>
				<tr>
					<td colspan="2">卡交易： 
					<span class="<?php if(strpos(','.$cardTtransactions.',',',1,')!==false){echo 'selected';}else{echo 'disabled';}?>">储值卡</span> 
					<span class="<?php if(strpos(','.$cardTtransactions.',',',2,')!==false){echo 'selected';}else{echo 'disabled';}?>">提货卡</span> 
					<span class="<?php if(strpos(','.$cardTtransactions.',',',3,')!==false){echo 'selected';}else{echo 'disabled';}?>">礼品卡</span>
					</td>
				</tr>
			</table>
		</div>
	</div>
    </div>
  <div class="clear"></div>
</div>
<!-- first end -->
<!-- second start -->
<div class="bigcont martop25">
	<div class="kaul13">
    <h3>【商品信息】</h3>
    <ul>
    <li>卡的名字：<?php echo $name;?></li>
    <li>卡的种类：
		<span class="<?php if(strpos(','.$cardType.',',',1,')!==false){echo 'selected';}else{echo 'disabled';}?>">餐饮</span>&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="<?php if(strpos(','.$cardType.',',',2,')!==false){echo 'selected';}else{echo 'disabled';}?>">购物</span>&nbsp;&nbsp;&nbsp;&nbsp; 
		<span class="<?php if(strpos(','.$cardType.',',',3,')!==false){echo 'selected';}else{echo 'disabled';}?>">丽人</span>&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="<?php if(strpos(','.$cardType.',',',4,')!==false){echo 'selected';}else{echo 'disabled';}?>">休闲</span>&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="<?php if(strpos(','.$cardType.',',',5,')!==false){echo 'selected';}else{echo 'disabled';}?>">运动</span>&nbsp;&nbsp;&nbsp;&nbsp; 
		<span class="<?php if(strpos(','.$cardType.',',',6,')!==false){echo 'selected';}else{echo 'disabled';}?>">旅游</span>
	</li>
    <li>卡的用途：
		<span class="<?php if(strpos(','.$cardUse.',',',1,')!==false){echo 'selected';}else{echo 'disabled';}?>">打折</span>&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="<?php if(strpos(','.$cardUse.',',',2,')!==false){echo 'selected';}else{echo 'disabled';}?>">会员</span>&nbsp;&nbsp;&nbsp;&nbsp; 
		<span class="<?php if(strpos(','.$cardUse.',',',3,')!==false){echo 'selected';}else{echo 'disabled';}?>">提货卡</span>&nbsp;
		<span class="<?php if(strpos(','.$cardUse.',',',4,')!==false){echo 'selected';}else{echo 'disabled';}?>">储值</span>&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="<?php if(strpos(','.$cardUse.',',',5,')!==false){echo 'selected';}else{echo 'disabled';}?>">积分</span>&nbsp;&nbsp;&nbsp;&nbsp; 
		<span class="<?php if(strpos(','.$cardUse.',',',6,')!==false){echo 'selected';}else{echo 'disabled';}?>">体验卡</span>
&nbsp;&nbsp;&nbsp;&nbsp; 
		<span class="<?php if(strpos(','.$cardUse.',',',7,')!==false){echo 'selected';}else{echo 'disabled';}?>">VIP会员卡</span>
	</li>
    <li>卡的交易：
		<span class="<?php if(strpos(','.$cardTtransactions.',',',1,')!==false){echo 'selected';}else{echo 'disabled';}?>">储值卡</span>&nbsp;
		<span class="<?php if(strpos(','.$cardTtransactions.',',',2,')!==false){echo 'selected';}else{echo 'disabled';}?>">提货卡</span>&nbsp;
		<span class="<?php if(strpos(','.$cardTtransactions.',',',3,')!==false){echo 'selected';}else{echo 'disabled';}?>">礼品卡</span>
	</li>
    <li>地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;点： 北京 <?php echo $districtName;?> <?php echo $urbanIdName;?></li>
    <li>市&nbsp;&nbsp;场&nbsp;&nbsp;价： <?php echo $price;?> 元</li>
    <li>卡的售价： <?php echo $sellingPrice;?> 元</li>
    <li>有&nbsp;&nbsp;效&nbsp;&nbsp;期： <?php echo $period;?></li>
    <li>拼卡方式：
		<span class="<?php if(strpos(','.$wayFight.',',',1,')!==false){echo 'selected';}else{echo 'disabled';}?>">打折</span>&nbsp;&nbsp;&nbsp;&nbsp; 
		<span class="<?php if(strpos(','.$wayFight.',',',2,')!==false){echo 'selected';}else{echo 'disabled';}?>">积分</span>
	</li>
	<li>备　　注：<?php echo $remarks;?></li>
    </ul></div>
    <div class="kaul14">
    	<div class="kareview">
			<h3>用户评论共有<em> <?php echo $total;?> 条评论</em></h3>
			<?php if($userId == ''){?>
			请登录后发表您的留言
			<?php }else{ ?>
			<form id="formcm" action="<?php echo site_url("sale/dosavecardmsg");?>" target="upload_target" method="post">
			<!--<input type="submit" value="asdfsdf" ? /> target="upload_target"-->
			<p><textarea class="kainput6" name="content" id="content" cols="content" rows=""></textarea></p>
			<script type='text/javascript'>
				KE.show({
					id : 'content',
					afterCreate : function(id) {
						KE.event.ctrl(document, 13, function() {
							KE.util.setData(id);
							document.forms['formcm'].submit();
						});
						KE.event.ctrl(KE.g[id].iframeDoc, 13, function() {
							KE.util.setData(id);
							document.forms['formcm'].submit();
						});
					}
				});
			</script>
			<p class="txtrig">
			<span id="msg"></span>
			<input type="hidden" id="cid" name="cid" value="<?php echo $id;?>" />
			<input class="seabut" id="button" name="button" type="button" value="发 布" onclick="dosave()" />
			</p>
			</form>
			<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
			<?php }?>
		</div>
		<div id="pancm">
        	<ul class="kaul15">
			<?php if($cardMessage!=null){$i=0;foreach ($cardMessage as $row):$i++;?>
			<li <?php if($i%2!=0){ echo 'class="grali"';} ?>><h4><a href="<?php echo site_url('member/other/'.$row['userId']);?>"><?php echo $row['nickname'];?> </a><em>发表于<?php echo $row['addDateTime'];?></em></h4><p><?php echo $row['content'];?></p></li>
			<?php endforeach;}?>
			</ul>
			<div class="position4">
			<?php
			#var_dump(array('total'=>$totalForSale,'perpage'=>$perpageForShow));
			$page=new page(array('total'=>$total,'perpage'=>$perpage,'pagebarnum'=>10));
			$page->open_ajax('doAjax');
			echo $page->show(1);
			?>
			</div>
		</div>
    </div>
<div class="clear"></div>
</div>
<!-- second end -->