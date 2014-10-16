<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title><?php echo $title;?> &gt;&gt; 编辑微博</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>kadmin/css/style.css" />
<script src="<?php echo base_url();?>kadmin/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kadmin/js/jquery.timer.js" type="text/javascript"></script>
</head>
<body>
<div id="info"></div>
<div class="main">
<div class="main_title">编辑微博</div>
<div class="blank5"></div>
<?php  
$attributes = array('id' => 'form1');
echo form_open('kadmin/mainfblogmessages/doadd', $attributes); 
echo form_hidden('id', '');
?>
<table class="form" cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=2 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title" valign="top">发微博会员：</td>
		<td class="item_input">
			（<a herf="#<?php echo $userId;?>" target="_blank"><?php echo $userName;?></a>） &nbsp;&nbsp;&nbsp;&nbsp;
			[点击会员名可查看资料]
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">微博内容:</td>
		<td class="item_input">
			<?php 
				$textarea = array(
				  'name'        => 'content',
				  'id'          => 'content',
				  'value'       => $content,
				  'class'   	=> 'textarea',
				  'style'       => 'width:600px; height:250px;',
				);
	
				echo form_textarea($textarea);
			?>
			<br />
			<div class="message_row"><?php echo form_error('content'); ?></div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">是否发布:</td>
		<td class="item_input">
			<?php 
				$options = array(
				  '0'        => '不发布',
				  '1'        => '已发布'
				);
				echo form_dropdown('state', $options, $state, 'id="state"');
			?>
			<div class="message_row"><?php echo form_error('state'); ?></div>
		</td>
	</tr>
	<tr id="content_tip">
		<td colspan="2">
			
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top"></td>
		<td class="item_input">
			<?php echo form_submit('btnSubmit', '提 交', 'class="button"');?>
			<?php echo form_reset('btnReset', '重 置', 'class="button"');?>
			<input type="button" class="button" value="返 回" onClick="history.go(-1)" />
			<?php echo form_hidden('id', $id, 'id="id"');?>
			<?php echo form_hidden('userId', $userId, 'id="userId"');?>
			<?php echo form_hidden('hiduserName', $userName, 'id="hiduserName"');?>
		</td>
	</tr>
	<tr>
		<td colspan=2 class="bottomTd"></td>
	</tr>
</table>
</form>
</div>
</body>
</html>