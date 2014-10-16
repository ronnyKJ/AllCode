<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title><?php echo $title;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="5;URL=<?php echo $nexturl;?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>kadmin/css/style.css" />
</head>
<body>
<div class="message">
<table cellpadding=0 cellspacing=0 class="form" >
	<tr>
		<td class="topTd"></td>
	</tr>
	<tr class="row" >
		<th class="title_row"><?php echo $title;?></th>
	</tr>
	

	<tr class="row">
		<td class="message_row"><?php echo $message;?></td>
	</tr>

	<tr class="row">
		<td  class="jump)row">
			页面将在5秒后自动跳转，或直接点击 <a href='<?php echo $nexturl;?>' target="_self" style="color:#0090eb">这里</a> 手动跳转		</td>
	</tr>

	<tr>
		 <td class="bottomTd"></td>
	</tr>
	</table>
</div>
</body>
</html>