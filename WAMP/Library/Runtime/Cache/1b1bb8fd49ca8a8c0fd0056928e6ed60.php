<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Library</title>
<link rel='stylesheet' type='text/css' href='__ROOT__/css/style.css'>
</head>
<body>
<h1>Edit a book</h1>
<form id="bookform" method="POST" action="__URL__/updateBook">
<input type="hidden" name="id" value="<?php echo ($id); ?>" />
<table>
<tr><td>Title:</td><td><input id="booktitle" type="text" name="title" value="<?php echo ($booktitle); ?>" /></td></tr>
<tr><td></td><td><input type="submit" value="Submit" /><a href="__URL__/main">Go back</a></td></tr>
</table>
</form>
</body>
<script type="text/javascript" src="__ROOT__/js/validateBooktitle.js"></script>
</html>