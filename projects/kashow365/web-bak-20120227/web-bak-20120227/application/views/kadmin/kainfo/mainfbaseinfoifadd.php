<?php 
	$twidth=0; $theight=0;
	$title = '';
	
	if($infoType=='IndexFlashTop1'){
		$twidth = 740; $theight=380;
		$title = "首页FLASH";
	}
	
	if($infoType=='IndexFlashTop2'){
		$twidth = 740; $theight=380;
		$title = "生活广场-FLASH";
	}
	
	if($infoType=='AdIndexSaleAd'){
		$twidth = 266; $theight=115;
		$title = "首页合伙拼卡动画";
	}
	
	if($infoType=='AdIndexSpellAd'){
		$twidth = 266; $theight=115;
		$title = "首页有买有卖动画";
	}
	
	if($infoType=='AdIndexBrandAd'){
		$twidth = 68; $theight=46;
		$title = "首页品牌广场管理";
	}

	if($infoType=='AdIndexSpellCard'){
		$twidth = 106; $theight=106;
		$title = "首页合伙拼卡卡管理";
	}
	
	if($infoType=='AdIndexSaleCard'){
		$twidth = 106; $theight=106;
		$title = "首页有买有卖卡管理";
	}
?>



<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title><?php echo $title;?> &gt;&gt; 编辑首页-<?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>kadmin/css/style.css" />
<script src="<?php echo base_url();?>kadmin/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kadmin/js/jquery.timer.js" type="text/javascript"></script>
</head>
<body>
<div id="info"></div>
<div class="main">
<div class="main_title">编辑-<?php echo $title; ?></div>
<div class="blank5"></div>
<?php  
$attributes = array('id' => 'form1');
echo form_open_multipart('kadmin/mainfbaseinfoif/doadd?v='.$infoType, $attributes);
?>
<table class="form" cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=2 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title" valign="top">图片:</td>
		<td class="item_input">
			<img src="<?php echo $this->config->item('UpPathFlashIndex').$value1;?>" width="<?php echo $twidth;?>px" height="<?php echo $theight;?>px" style="border:thin 1px;" />
			<br /><br />
			<input type="file" name="userfile" size="40" />
			<br />
			<span style="color:red">(width="<?php echo $twidth;?>px" height="<?php echo $theight;?>px")</span>
			<br />
			<div class="message_row"><?php echo $uploadError;?></div>
		</td>
	</tr>
	<?php if($infoType=='AdIndexSaleCard' || $infoType=='AdIndexSpellCard'){?>
	<tr>
		<td class="item_title" valign="top">卡编号 :</td>
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
	<?php }else{ ?>
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
	<?php } ?>
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