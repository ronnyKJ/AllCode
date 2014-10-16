<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 frameset//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title><?php echo $title;?> &gt;&gt; 首页</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8" />
</head>
<frameset border="0" frameSpacing="0" rows="100, *,32" frameborder="10">
<frame name="top" marginwidth="0" marginheight="0" src="<?php echo site_url("kadmin/top");?>" frameborder="0" noresize="noresize" scrolling="no"></frame>
<frameset id="frame-body" border="0" frameSpacing="0" frameborder="0" cols="200,7, *">
<frame id="menu-frame" name="menu" src="<?php echo site_url("kadmin/menuframe/index");?>" frameborder="0"></frame>
<frame id="drag-frame" name="drag" src="<?php echo site_url("kadmin/dragframe");?>" frameborder="0" scrolling="no" /></frame>
<frame id="main-frame" name="main" src="<?php echo site_url("kadmin/mainframe");?>" frameborder="0" /></frame>
</frameset>
<frame name="footer" marginwidth="0" marginheight="0" src="<?php echo site_url("kadmin/footer");?>" frameborder="0" noresize="noresize" scrolling="no" /></frame>
</frameset>
</HTML>
