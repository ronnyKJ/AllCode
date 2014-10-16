<!-- fla start (popMaskServices) -->
<script src="<?php echo base_url();?>kweb/js/popMaskServices.js" type="text/javascript" charset="UTF-8"></script>
<style type="text/css">
.qqbox a:link {
	color: #000;
	text-decoration: none;
}
.qqbox a:visited {
	color: #000;
	text-decoration: none;
}
.qqbox a:hover {
	color: #f80000;
	text-decoration: underline;
}
.qqbox a:active {
	color: #f80000;
	text-decoration: underline;
}

.qqbox{
	width:132px;
	height:auto;
	overflow:hidden;
	position:absolute;
	right:0;
	top:100px;
	color:#000000;
	font-size:12px;
	letter-spacing:0px;
}
.qqlv{
	width:25px;
	height:256px;
	overflow:hidden;
	position:relative;
	float:right;
	z-index:50px;
}
.qqkf{
	width:120px;
	height:auto;
	overflow:hidden;
	right:0;
	top:0;
	z-index:99px;
	border:6px solid #138907;
	background:#fff;
}
.qqkfbt{
	width:118px;
	height:20px;
	overflow:hidden;
	background:#138907;
	line-height:20px;
	font-weight:bold;
	color:#fff;
	position:relative;
	border:1px solid #9CD052;
	cursor:pointer;
	text-align:center;
}
.qqkfhm{
	width:112px;
	height:22px;
	overflow:hidden;
	line-height:22px;
	padding-right:8px;
	position:relative;
	margin:3px 0;
}
.bgdh{
	width:102px;
	padding-left:10px;
}
</style>
<div class="qqbox" id="divQQbox">
  <div class="qqlv" id="meumid" onmouseover="show()"><img src="<?php echo base_url();?>kweb/images/qq.gif"></div>
  <div class="qqkf" style="display:none;" id="contentid" onmouseout="hideMsgBox(event)">
    <div class="qqkfbt" onmouseout="showandhide('qq-','qqkfbt','qqkfbt','K',1,1);" id="qq-1" onfocus="this.blur();">卡秀网站客服</div>
    <div id="K1">
      <div class="qqkfhm bgdh"> <a href="http://wpa.qq.com/msgrd?v=3&uin=2205756010&site=qq&menu=yes" title="客服一" target="_blank" ><img src="http://wpa.qq.com/pa?p=1:2205756010:4" border="0">客服一</a><br/></div>

      <div class="qqkfhm bgdh">QQ：2205756010</div>
    </div>
  </div>
</div>
<!-- fla end (popMaskServices) -->