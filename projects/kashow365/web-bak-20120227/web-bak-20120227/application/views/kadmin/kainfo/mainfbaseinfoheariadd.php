<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title><?php echo $title;?> &gt;&gt; 编辑听说</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>kadmin/css/style.css" />
<script src="<?php echo base_url();?>kadmin/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kadmin/js/jquery.timer.js" type="text/javascript"></script>
</head>
<body>
<div id="info"></div>
<div class="main">
<div class="main_title">编辑听说</div>
<div class="blank5"></div>
<?php  
$attributes = array('id' => 'form1');
echo form_open_multipart('kadmin/mainfbaseinfoheari/doadd', $attributes);
?>
<table class="form" cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=2 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title" valign="top">听说 :</td>
		<td class="item_input">
			<?php 
				$inputId = 'value1';
				$inputtext = array(
				  'name'        => $inputId,
				  'id'          => $inputId,
				  'value'       => isset($_POST[$inputId]) ? $_POST[$inputId] : $value1,
				  'maxlength'   => '100',
				  'size'        => '100',
				  'style'       => '',
				);
	
				echo form_input($inputtext);
			?>
			<br />
			<div class="message_row"><?php echo form_error('value1'); ?></div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">链接:</td>
		<td class="item_input">
			<?php 
				$inputId = 'value2';
				$inputtext = array(
				  'name'        => $inputId,
				  'id'          => $inputId,
				  'value'       => isset($_POST[$inputId]) ? $_POST[$inputId] : $value2,
				  'maxlength'   => '100',
				  'size'        => '100',
				  'style'       => '',
				);
	
				echo form_input($inputtext);
			?>
			<br />
			<div class="message_row"><?php echo form_error('value2'); ?></div>
		</td>
	</tr>	
	<tr>
		<td class="item_title" valign="top">排序:</td>
		<td class="item_input">
			<?php 
				$inputId = 'orderNum';
				$inputtext = array(
				  'name'        => $inputId,
				  'id'          => $inputId,
				  'value'       => isset($_POST[$inputId]) ? $_POST[$inputId] : $orderNum,
				  'maxlength'   => '4',
				  'size'        => '4',
				  'style'       => '',
				);
	
				echo form_input($inputtext);
			?>
			<br />
			<div class="message_row"><?php echo form_error($inputId); ?></div>
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
			<?php echo form_hidden('infoType', 'HearInfoIndex');?>
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