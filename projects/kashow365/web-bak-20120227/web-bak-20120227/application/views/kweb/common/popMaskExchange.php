<!-- fla start (popMaskExchange) -->
<script src="<?php echo base_url();?>kweb/js/popMaskExchange.js" type="text/javascript" charset="UTF-8"></script>
<div id="popMaskExchange" style="background:#000; opacity:0.6; filter:alpha(opacity=60); width:100%; height:100%; position:absolute; top:0; left:0; display:none;"></div>
<div id="popBoxBodyExchange" style=" position:absolute; top:150px; left:0; width:100%; display:none;">
<div id="popboxExchange" class="popbox flacont1" style="display:none;">
<style type="text/css">
.disable{ background-color:#E3E3E3;}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><span class="r"><a onclick="initdoExchange()" href="javascript:void(0)"><img src="<?php echo base_url();?>kweb/images/kaicon5.gif" /></a></span>
	</td>
  </tr>
 </table>
 <form id="formExchange" action="<?php echo site_url('gift/doexchange');?>" target="_blank" method="post">
	<!-- <input type="submit" value="test" />  -->
	<table id="aExchange1" width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><font class="f14 redf">温馨提示：您是否确认要消耗 <?php echo $exchangPoint; ?> 个Ks兑换该礼品，此兑换一旦生效将不退还Ks币</font></td>
	  </tr>
	  <tr>
		<td class="pdtop60" align="center"><label>
		  <input type="hidden" id="cid" name="cid" value="<?php echo $id;?>" />
		  <input onclick="doExchange()" class="seabut" type="button" name="btndo" id="btndo" value="绝不后悔" />　
		  <input onClick='initdoExchange()' class="loginbut"  type="button" name="btnexit" id="btnexit" value="在考虑一下" />
		</label></td>
	  </tr>
	</table>

	<table id="aExchange2" width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none">
	  <tr>
		<td align="left"><font class="f14 redf" id="msg">恭喜您兑换成功，您的账户余额为xxx Ks，您兑换的礼品将由客服人员在一周之内
	与您取得联系或邮件发送给您领取办法，请及时查收邮件。</font></td>
	  </tr>
	  <tr>
		<td class="pdtop60" align="center"><label>
		  <input onclick="javascript:window.location.href='<?php echo site_url('gift');?>'" class="but10" type="button" name="button" id="button" value="返回礼尚往来" />　
		  <input onClick="javascript:window.location.href='<?php echo site_url('member');?>'" class="but10"  type="button" name="button2" id="button2" value="查看我的账户" />
		</label></td>
	  </tr>
	</table>
</form>
  <div class="clear"></div>
</div>
</div>
<!-- fla end -->
