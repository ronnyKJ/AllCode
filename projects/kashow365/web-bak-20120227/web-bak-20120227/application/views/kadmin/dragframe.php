<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?php echo $title;?> &gt;&gt; 首页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type=text/css>BODY {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BACKGROUND: url(<?php echo base_url();?>kadmin/images/body_bg.gif) #dfdfdf repeat-y; PADDING-BOTTOM: 0px; MARGIN: 0px; CURSOR: e-resize; PADDING-TOP: 0px
}
</style>

<script language="javascript" type="text/javascript">
<!--
var pic = new Image();
pic.src="<?php echo base_url();?>kadmin/images/bar_open.gif";

function toggleMenu()
{
  frmBody = parent.document.getElementById('frame-body');
  imgArrow = document.getElementById('img');

  if (frmBody.cols == "0, 7, *")
  {
    frmBody.cols="200, 7, *";
    imgArrow.src = "<?php echo base_url();?>kadmin/images/bar_close.gif";
  }
  else
  {
    frmBody.cols="0, 7, *";
    imgArrow.src = "<?php echo base_url();?>kadmin/images/bar_open.gif";
  }
}

var orgX = 0;
document.onmousedown = function(e)
{
  var evt = Utils.fixEvent(e);
  orgX = evt.clientX;

  if (Browser.isIE) document.getElementById('tbl').setCapture();
}

document.onmouseup = function(e)
{
  var evt = Utils.fixEvent(e);

  frmBody = parent.document.getElementById('frame-body');
  frmWidth = frmBody.cols.substr(0, frmBody.cols.indexOf(','));
  frmWidth = (parseInt(frmWidth) + (evt.clientX - orgX));

  frmBody.cols = frmWidth + ", 7, *";

  if (Browser.isIE) document.releaseCapture();
}

var Browser = new Object();

Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument != 'undefined');
Browser.isIE = window.ActiveXObject ? true : false;
Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != - 1);
Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != - 1);
Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != - 1);

var Utils = new Object();

Utils.fixEvent = function(e)
{
  var evt = (typeof e == "undefined") ? window.event : e;
  return evt;
}
//-->
</script>

</head>
<body onselect="return false;">
<table id="tbl" style="BORDER-LEFT: #bfbfbf 1px solid" height="100%" cellspacing="0" cellpadding="0">
  <tbody>
  <tr>
    <td><a onfocus="this.blur();" href="javascript:toggleMenu();">
	<img id="img" height="60" src="<?php echo base_url();?>kadmin/images/bar_close.gif" width="6" border="0" /></a>
	</td></tr></tbody></table></body></html>
