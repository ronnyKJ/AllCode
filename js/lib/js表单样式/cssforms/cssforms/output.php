<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>cssForms</title>
<style type="text/css">
<!--
	@import url(cssforms.css);
-->
</style>
<script type="text/javascript" src="cssforms.mini.js"></script>
</head>
<body>
<p>
	<label for="output" style="color:#6D93AB;font-size:14px;">Output:</label><br />
	<textarea id="output" name="output" ><?php print_r($_POST); ?></textarea>
</p>
<p>
	<input type="button" value="Back" onclick="window.location = 'index.html';" />
</p>
</body>
</html>