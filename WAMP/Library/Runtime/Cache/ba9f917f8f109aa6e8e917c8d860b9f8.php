<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Library</title>
<link rel='stylesheet' type='text/css' href='__ROOT__/css/style.css'>
</head>
<body>
<h1>User Info</h1>

<h3>Unauthorized book administrator info</h3>
<table class="tbl">
<tr><th>ID</th><th>Username</th><th>Password</th><th>E-mail</th><th>Type</th><th>Authorize</th></tr>
<?php if(is_array($bookAdminUn)): $i = 0; $__LIST__ = $bookAdminUn;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bau): ++$i;$mod = ($i % 2 )?><tr><td><?php echo ($bau["id"]); ?></td><td><?php echo ($bau["username"]); ?></td><td><?php echo ($bau["password"]); ?></td><td><?php echo ($bau["email"]); ?></td><td><?php echo ($bau["type"]); ?></td>
<td><form method="POST" action="__URL__/authorize"><input name="id" type="hidden" value="<?php echo ($bau["id"]); ?>" /><input type="submit" value="Authorize" /></form></td>
</tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>

<h3>Authorized book administrator info</h3>
<table class="tbl">
<tr><th>ID</th><th>Username</th><th>Password</th><th>E-mail</th><th>Type</th></tr>
<?php if(is_array($bookAdminAu)): $i = 0; $__LIST__ = $bookAdminAu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ba): ++$i;$mod = ($i % 2 )?><tr><td><?php echo ($ba["id"]); ?></td><td><?php echo ($ba["username"]); ?></td><td><?php echo ($ba["password"]); ?></td><td><?php echo ($ba["email"]); ?></td><td><?php echo ($ba["type"]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>

<h3>Book borrower info</h3>
<table class="tbl">
<tr><th>ID</th><th>Username</th><th>Password</th><th>E-mail</th><th>Type</th><th>Books</th></tr>
<?php if(is_array($userList)): $i = 0; $__LIST__ = $userList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ul): ++$i;$mod = ($i % 2 )?><tr><td><?php echo ($ul["id"]); ?></td><td><?php echo ($ul["username"]); ?></td><td><?php echo ($ul["password"]); ?></td><td><?php echo ($ul["email"]); ?></td><td><?php echo ($ul["type"]); ?></td>
<td><a href="__URL__/checkUserBooks/uid/<?php echo ($ul["id"]); ?>">check</a></td>
</tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
</body>
</html>