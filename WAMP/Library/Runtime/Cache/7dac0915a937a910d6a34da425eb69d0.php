<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Library</title>
<link rel='stylesheet' type='text/css' href='__ROOT__/css/style.css'>
</head>
<body>
<h1>Books borrowed by ID <?php echo ($id); ?>:</h1>
<?php if(count($booksList) == 0): ?>No books...<br><a href="__URL__/main">Go back</a>
<?php else: ?>
<table class="tbl">
<tr><th>ID</th><th>Title</th></tr>
<?php if(is_array($booksList)): $i = 0; $__LIST__ = $booksList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$book): ++$i;$mod = ($i % 2 )?><tr><td><?php echo ($book["id"]); ?></td><td><?php echo ($book["booktitle"]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
<br><a href="__URL__/main">Go back</a><?php endif; ?>
</body>
</html>