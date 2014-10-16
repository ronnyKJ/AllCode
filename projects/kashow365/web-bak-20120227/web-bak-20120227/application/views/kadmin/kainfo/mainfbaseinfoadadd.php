<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title><?php echo $title;?> &gt;&gt; 编辑公告</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>kadmin/css/style.css" />
<script src="<?php echo base_url();?>kadmin/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kadmin/js/jquery.timer.js" type="text/javascript"></script>
<script type="text/javascript">
function setm(v){
	if(v==0){
		$("#m1").show();$("#m2").hide();
	}
	if(v==1){
		$("#m1").hide();$("#m2").show();
	}
}
$(document).ready(function(){
	<?php if($count == 0){?>
	setm(0);
	<?php }else{ ?>
	setm(1);
	<?php } ?>
})

</script>
</head>
<body>
<div id="info"></div>
<div class="main">
<div class="main_title">编辑网站广告告</div>
<div class="blank5"></div>
<?php  
$attributes = array('id' => 'form1');
echo form_open_multipart('kadmin/mainfbaseinfoad/doadd', $attributes);
?>
<table class="form" cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=2 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title" valign="top">跳转URL :</td>
		<td class="item_input">
			<span>
			<?php 
				$inputId = 'count';
				$radiodata = array(
					'name'        => $inputId,
					'id'          => $inputId+'0',
					'value'       =>  0,
					'checked'     => $count == 0 ? TRUE : false,
					'style'       => 'margin:10px',
					'onclick'     => 'setm(0)'
					);

				echo form_radio($radiodata);
			?>
			模式一（上传图片）</span>
			<span  style="padding-left:30px;">
			<?php 
				$inputId = 'count';
				$radiodata = array(
					'name'        => $inputId,
					'id'          => $inputId+'1',
					'value'       =>  1,
					'checked'     =>  $count == 1 ? TRUE : false,
					'style'       => 'margin:10px',
					'onclick'     => 'setm(1)'
					);
				echo form_radio($radiodata);
			?>
			模式二（整段代码）</span>
		</td>
	</tr>
	<tbody id="m1">
	<tr>
		<td class="item_title" valign="top">flash图片:</td>
		<td class="item_input">
			<img src="<?php echo $this->config->item('UpPathAD').$value1;?>" height="150px" style="border:thin 1px;" />
			<br />
			<input type="file" name="userfile" size="20" />
			<br />
			<div class="message_row"><?php echo $uploadError;?></div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">跳转URL :</td>
		<td class="item_input">
			<?php 
				$inputId = 'value2';
				$inputtext = array(
				  'name'        => $inputId,
				  'id'          => $inputId,
				  'value'       => isset($_POST[$inputId]) ? $_POST[$inputId] : $value2,
				  'maxlength'   => '500',
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
		<td class="item_title" valign="top">显示文本 :</td>
		<td class="item_input">
			<?php 
				$inputId = 'value3';
				$inputtext = array(
				  'name'        => $inputId,
				  'id'          => $inputId,
				  'value'       => isset($_POST[$inputId]) ? $_POST[$inputId] : $value3,
				  'maxlength'   => '500',
				  'size'        => '100',
				  'style'       => '',
				);
	
				echo form_input($inputtext);
			?>
			<br />
			<div class="message_row"><?php echo form_error($inputId); ?></div>
		</td>
	</tr>
	</tbody>
	
	<tbody id="m2" style="display:none">
	<tr>
		<td class="item_title" valign="top">显示文本 :</td>
		<td class="item_input">
			<?php 
				$inputId = 'value2a';
				$inputtext = array(
				  'name'        => $inputId,
				  'id'          => $inputId,
				  'value'       => isset($_POST[$inputId]) ? $_POST[$inputId] : $value2,
				  'maxlength'   => '500',
				  'size'        => '100',
				  'style'       => '',
				);
	
				echo form_textarea($inputtext);
			?>
			<br />
			<div class="message_row"><?php echo form_error($inputId); ?></div>
		</td>
	</tr>
	</tbody>
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
			<?php echo form_hidden('infoType', $infoType);?>
			<?php echo form_hidden('o', $operType);?>
			<?php echo form_hidden('v', $operValue);?>
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