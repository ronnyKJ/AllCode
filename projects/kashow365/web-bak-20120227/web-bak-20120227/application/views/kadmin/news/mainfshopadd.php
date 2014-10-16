<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title><?php echo $title;?> &gt;&gt; 编辑商场信息</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>kadmin/css/style.css" />
<script src="<?php echo base_url();?>kadmin/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kadmin/js/jquery.timer.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>kadmin/js/script.js"></script>
<script type="text/javascript">
window.onload=function(){
	var districtId = "<?php echo $districtId;?>";
	var urbanId = "<?php echo $urbanId;?>";
	if(districtId!=""){
		areaSelect('<?php echo site_url('kadmin/mainfurban/getparent');?>/'+districtId, urbanId);
	}
}
</script>
</head>
<body>
<div id="info"></div>
<div class="main">
<div class="main_title">编辑商场信息</div>
<div class="blank5"></div>
<?php  
$attributes = array('id' => 'form1');
echo form_open('kadmin/mainfshop/doadd', $attributes); 
?>
<table class="form" cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=2 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title" valign="top">商场名称:</td>
		<td class="item_input">
			<?php 
				$inputtext = array(
				  'name'        => 'shopname',
				  'id'          => 'shopname',
				  'value'       => $shopname,
				  'maxlength'   => '50',
				  'size'        => '50',
				  'style'       => '',
				);
	
				echo form_input($inputtext);
			?>
			<br />
			<div class="message_row"><?php echo form_error('shopname'); ?></div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">商场所在区域:</td>
		<td class="item_input">
			<select id="district" name="districtId" onChange="areaSelect('<?php echo site_url('kadmin/mainfurban/getparent');?>','')">
			<option value="" <?php if($districtId==''){echo 'selected="selected"';}?>>请选择</option>
			<?php foreach ($districtRows as $row):?>
			<option value="<?php echo $row['id'];?>" <?php echo $row['id']== $districtId ? 'selected="selected"' : '';?>><?php echo $row['name'];?></option>
			<?php endforeach;?>
			</select>
			<select id="urban" name="urbanId">
			<option value="" selected="selected">请选择</option>
			</select>
			<div class="message_row"><?php echo form_error('districtId'); ?></div>
			<div class="message_row"><?php echo form_error('urbanId'); ?></div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">推荐排序:</td>
		<td class="item_input">最新活动中 -> 
			<?php 
				$inputtext = array(
				  'name'        => 'reActivityOrderNum',
				  'id'          => 'reActivityOrderNum',
				  'value'       => $reActivityOrderNum,
				  'maxlength'   => '50',
				  'size'        => '50',
				  'style'       => '',
				);
	
				echo form_input($inputtext);
			?>
			<br />
			<div class="message_row"><?php echo form_error('reActivityOrderNum'); ?></div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">推荐排序:</td>
		<td class="item_input">打折快报中 -> 
			<?php 
				$inputtext = array(
				  'name'        => 'reDiscountOrderNum',
				  'id'          => 'reDiscountOrderNum',
				  'value'       => $reDiscountOrderNum,
				  'maxlength'   => '50',
				  'size'        => '50',
				  'style'       => '',
				);
	
				echo form_input($inputtext);
			?>
			<br />
			<div class="message_row"><?php echo form_error('reDiscountOrderNum'); ?></div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">推荐排序:</td>
		<td class="item_input">兑换通知中 -> 
			<?php 
				$inputtext = array(
				  'name'        => 'reConversionOrderNum',
				  'id'          => 'reConversionOrderNum',
				  'value'       => $reConversionOrderNum,
				  'maxlength'   => '50',
				  'size'        => '50',
				  'style'       => '',
				);
	
				echo form_input($inputtext);
			?>
			<br />
			<div class="message_row"><?php echo form_error('reConversionOrderNum'); ?></div>
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