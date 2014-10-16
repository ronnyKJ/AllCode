<!-- fla start (popMaskUserMsg) -->
<script src="<?php echo base_url();?>kweb/js/popMaskUserMsg.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/checkinput.js" type="text/javascript" charset="UTF-8"></script>
<div id="popMaskUserMsg" style="background:#000; opacity:0.6; filter:alpha(opacity=60); width:100%; height:100%; position:absolute; top:0; left:0; display:none;"></div>
<div id="popBoxBodyUserMsg" style=" position:absolute; top:150px; left:0; width:100%; display:none;">
<div id="popboxUserMsg" class="popbox flacont1" style="display:none;">
 <script type="text/javascript">
	$(document).ready(function(){
		//绑定提交按钮
		$("#btnUserMsg").bind("click",function(){ domsg();});
		$("#closeUserMsg").bind("click",function(){ initdoUserMsg();});
	});
 </script>
<style type="text/css">
.disable{ background-color:#E3E3E3;}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><span class="r"><a onclick="initdoUserMsg()" href="javascript:void(0)"><img src="<?php echo base_url();?>kweb/images/kaicon5.gif" /></a></span>
	</td>
  </tr>
 </table>
 <form id="formUserMsg" action="<?php echo site_url('member/domessage');?>" target="_blank" method="post">
	<!-- <input type="submit" value="test" />  -->
 	<div class="flacont3">
	<h2>来发消息，说说你的卡，说说你想去哪逛</h2>
    <p>
		<textarea class="kainput7" name="c" id="cUserMsg" cols="" rows="" onKeyUp="checkInputLength('cUserMsg',120)"></textarea>
		<input type="hidden" id="umSystemAdd" name="umSystemAdd" value="" />
	</p>
    <p class="bluef">&nbsp;</p>
    <p class="txtrig">
		<span id="StrErr-cUserMsg" class="StrErr">字数超过限制</span>   
		<span id="StrInfo-cUserMsg" class="StrInfo">您还可以输入<span id="StrLength-cUserMsg" class="StrLength">120</span>字 
		<input class="seabut" name="btnUserMsg" id="btnUserMsg" type="button" value="我说了" /></span>
		<span id="msgUserMsg"></span>
		<input class="seabut" name="closeUserMsg" id="closeUserMsg" type="button" value="发布成功" style="display:none" />
		<input type="hidden" id="touid" name="touid" value="<?php echo $toUserId;?>" />
    </p>
	</div>
</form>
  <div class="clear"></div>
</div>
</div>
<!-- fla end -->
