<style type="text/css">
	.disableText{ background-color:#E3E3E3;}
</style>
<!-- first start -->
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
   	<div class="kalist2">兑换积分： <?php echo $exchangPoint;?> ks币</div>
	<div class="kalist2">剩余个数： <?php echo $surplusCount;?> 个</div>
	<div class="kalist3"><input class="seabut" name="" type="button" value="我要兑换" onclick="pupInit('Exchange')" />
      <label>
        <input class="seabut" type="button" name="button" id="button" value="重新挑选" onclick="location.href='<?php echo site_url("gift");?>'" />
      </label>
    </div>
    <div id="demo" class="kaul16">
		<div style="margin:23px 0 0 15px; height:24px;">
			<table>
				<tr>
					<td width="180">地&nbsp;&nbsp;&nbsp;&nbsp;点： 北京 <?php echo $districtName;?> <?php echo $urbanIdName;?></td>
					<td>有&nbsp;&nbsp;效&nbsp;&nbsp;期： <?php echo $period;?></td>
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
    <li>兑换积分： <?php echo $exchangPoint;?> ks币</li>
    <li>剩余个数： <?php echo $surplusCount;?> 个</li>
    <li>有&nbsp;&nbsp;效&nbsp;&nbsp;期： <?php echo $period;?></li>
   	<li>备　　注： <?php echo $remarks;?></li>
    </ul></div>
<div class="clear"></div>
</div>
<!-- second end -->