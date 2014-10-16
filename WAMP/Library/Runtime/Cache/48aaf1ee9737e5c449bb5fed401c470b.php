<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Library</title>
<link rel='stylesheet' type='text/css' href='__ROOT__/css/style.css'>
</head>
<body>
<h1>Library</h1>
<table class="tbl">
<tr><th>Name</th><th>E-mail</th><th>Edit</th><th>Log out</th></tr>
<tr><td><?php echo ($username); ?></td><td><?php echo ($email); ?></td><td>
<form method="POST" action="__URL__/edit">
	<input name="id" value="<?php echo ($id); ?>" type="hidden" /><input value="Edit my data" type="submit" />
</form>
</td><td><a href="__URL__/logout">Logout</a></td></tr>
</table>
<?php if($usertype == 0): ?><div>You have no rights to manage the books now, please wait for the authority from the super administrator.</div>
<?php elseif($usertype == 1): ?>
	<h3>Add a book</h3><a href="__URL__/addBook">Add a book</a><h3>Books info</h3><table class="tbl"><tr><th>ID</th><th>Title</th><th>Borrower ID</th><th>Eidt</th><th>Delete</th></tr><?php if(is_array($bookList)): $i = 0; $__LIST__ = $bookList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$book): ++$i;$mod = ($i % 2 )?><tr><td><?php echo ($book["id"]); ?></td><td><?php echo ($book["booktitle"]); ?></td><td><?php echo ($book["borrowerid"]); ?></td><td><a href="__URL__/editBook/bid/<?php echo ($book["id"]); ?>/booktitle/<?php echo ($book["booktitle"]); ?>">edit</a></td><td><a href="__URL__/delBook/bid/<?php echo ($book["id"]); ?>/borrowerid/<?php echo ($book["borrowerid"]); ?>">delete</a></td></tr><?php endforeach; endif; else: echo "" ;endif; ?></table>
<?php else: ?>
	<h3>Borrowed books info</h3><table class="tbl"><tr><th></th><th>Title</th><th>Return</th></tr><?php if(is_array($borrowList)): $i = 0; $__LIST__ = $borrowList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$borrow): ++$i;$mod = ($i % 2 )?><tr><td><?php echo ($i); ?></td><td><?php echo ($borrow["booktitle"]); ?></td><td><a href="__URL__/returnBook/bid/<?php echo ($borrow["id"]); ?>">return</a></td></tr><?php endforeach; endif; else: echo "" ;endif; ?></table><h3>Other books info</h3><table class="tbl"><tr><th></th><th>Title</th><th>Borrow</th></tr><?php if(is_array($otherBooksList)): $i = 0; $__LIST__ = $otherBooksList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$otherBook): ++$i;$mod = ($i % 2 )?><tr><td><?php echo ($i); ?></td><td><?php echo ($otherBook["booktitle"]); ?></td><td><a href="__URL__/borrowBook/bid/<?php echo ($otherBook["id"]); ?>">borrow</a></td></tr><?php endforeach; endif; else: echo "" ;endif; ?></table><?php endif; ?>
</body>
</html>