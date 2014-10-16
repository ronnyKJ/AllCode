<!-- fla start (popMaskBlogMsg) -->
<script src="<?php echo base_url();?>kweb/js/popMaskBlogMsg.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/checkinput.js" type="text/javascript" charset="UTF-8"></script>
<div id="popMaskBlogMsg" style="background:#000; opacity:0.6; filter:alpha(opacity=60); width:100%; height:100%; position:absolute; top:0; left:0; display:none;"></div>
<div id="popBoxBodyBlogMsg" style=" position:absolute; top:150px; left:0; width:100%; display:none;">
<div id="popboxBlogMsg" class="popbox flacont1" style="display:none;">
 <script type="text/javascript">
	$(document).ready(function(){
		//绑定提交按钮
		$("#btnBlogMsg").bind("click",function(){ doblog();});
		$("#closeBlogMsg").bind("click",function(){ initdoblogBlogMsg();});
	});
 </script>
	<style type="text/css">
	.disable{ background-color:#E3E3E3;}
	</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><span class="r"><a onclick="initdoblogBlogMsg()" href="javascript:void(0)"><img src="<?php echo base_url();?>kweb/images/kaicon5.gif" /></a></span>
	</td>
  </tr>
 </table>
 <form id="formBlogMsg" action="<?php echo site_url('life/doblog');?>" target="_blank" method="post">
	<!-- <input type="submit" value="test" />  -->
 	<div class="flacont3">
	<h2>来发微博，说说你的卡，说说你想去哪逛</h2>
    <p><textarea class="kainput7" name="c" id="cBlogMsg" cols="" rows="" onKeyUp="checkInputLength('cBlogMsg',120)"></textarea></p>
    <p class="bluef">&nbsp;</p>
    <p class="txtrig"> 
		<span id="StrErr-cBlogMsg" class="StrErr">字数超过限制</span>   
		<span id="StrInfo-cBlogMsg" class="StrInfo">您还可以输入<span id="StrLength-cBlogMsg" class="StrLength">120</span>字 
		<input class="seabut" name="btnBlogMsg" id="btnBlogMsg" type="button" value="我说了" /></span>
		<span id="msgUserMsg"></span>
		<input class="seabut" name="closeBlogMsg" id="closeBlogMsg" type="button" value="发布成功" style="display:none" />
    </p>
	</div>
</form>
  <div class="clear"></div>
</div>
</div>
<style type="text/css">  
#StrErr{color:#f00;font-size:12px;margin:0;display:none}  
#StrInfo{color:#333;font-size:12px;margin:0}  
#StrLength{color:#00f;font-weight:bold}   
</style> 
<!-- fla end -->
