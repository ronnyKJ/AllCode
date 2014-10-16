<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title><?php echo $title;?> &gt;&gt; 编辑兑换通知
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>kadmin/css/style.css" />
<script src="<?php echo base_url();?>kadmin/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kadmin/js/jquery.timer.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>kadmin/public/kindeditor-3.5.5-zh_CN/kindeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>kadmin/js/script.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>kweb/js/ESONCalendar.js"></script>
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
<div class="main_title">编辑兑换通知</div>
<div class="blank5"></div>
<?php  
$attributes = array('id' => 'form1');
echo form_open('kadmin/mainfshopnews3/doadd', $attributes); 
?>
<table class="form" cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=2 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title" valign="top">兑换通知标题:</td>
		<td class="item_input">
			<?php 
				$inputtext = array(
				  'name'        => 'newsTitle',
				  'id'          => 'newsTitle',
				  'value'       => $newsTitle,
				  'maxlength'   => '100',
				  'size'        => '80',
				  'style'       => '',
				);
	
				echo form_input($inputtext);
			?>
			<br />
			<div class="message_row"><?php echo form_error('newsTitle'); ?></div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">兑换通知摘要:</td>
		<td class="item_input">
			<?php 
				$inputtext = array(
				  'name'        => 'newsSummary',
				  'id'          => 'newsSummary',
				  'value'       => $newsSummary,
				  'maxlength'   => '500',
				  'size'        => '100',
				  'style'       => '',
				);
	
				echo form_input($inputtext);
			?>
			<br />
			<div class="message_row"><?php echo form_error('newsTitle'); ?></div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">兑换通知内容:</td>
		<td class="item_input">
			<p style="color:red">(图片不能超过580px，否则超出部分将会被遮挡)</p>
			<script type='text/javascript'>
				KE.show({
					id : 'newsContent',
					imageUploadJson : '<?php echo site_url('news/doupphoto');?>',
					fileManagerJson : '<?php echo $this->config->item('AdminSystem_Title');?>kadmin/public/kindeditor-3.5.5-zh_CN/php/file_manager_json.php',
					allowFileManager : true,
					afterCreate : function(id) {
						KE.event.ctrl(document, 13, function() {
							KE.util.setData(id);
							document.forms['form1'].submit();
						});
						KE.event.ctrl(KE.g[id].iframeDoc, 13, function() {
							KE.util.setData(id);
							document.forms['form1'].submit();
						});
					}
				});
			</script>
			<div  style='margin-bottom:5px; '>
				<?php 
					$textarea = array(
					  'name'        => 'newsContent',
					  'id'          => 'newsContent',
					  'value'       => $newsContent,
					  'class'   	=> 'textarea',
					  'style'       => 'width:750px; height:350px;visibility:hidden;',
					);
		
					echo form_textarea($textarea);
				?>
				<br />
				<div class="message_row"><?php echo form_error('newsContent'); ?></div>
			</div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">兑换所在区域:</td>
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
		<td class="item_title" valign="top">兑换通知主办商场:</td>
		<td class="item_input">
			<select id="shopId" name="shopId">
			<option value="" <?php if($shopId==''){echo 'selected="selected"';}?>>请选择</option>
			<?php foreach ($shopRows as $row):?>
			<option value="<?php echo $row['id'];?>" <?php echo $row['id']== $shopId ? 'selected="selected"' : '';?>><?php echo $row['shopName'];?></option>
			<?php endforeach;?>
			</select>
			<div class="message_row"><?php echo form_error('shopId'); ?></div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">活动排序:</td>
		<td class="item_input">
			<?php 
				$inputtext = array(
				  'name'        => 'orderNum',
				  'id'          => 'orderNum',
				  'value'       => $orderNum,
				  'maxlength'   => '6',
				  'size'        => '10',
				  'style'       => '',
				);
	
				echo form_input($inputtext);
			?>
			<br />
			<div class="message_row"><?php echo form_error('orderNum'); ?></div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">活动时间:</td>
		<td class="item_input">
			开始：<?php 
				$inputtext1 = array(
				  'name'        => 'startDate',
				  'id'          => 'startDate',
				  'value'       =>  date('Y-m-d', strtotime($startDate)),
				  'maxlength'   => '10',
				  'size'        => '10',
				  'style'       => '',
				  'readonly'	=> 'readonly'
				);
	
				echo form_input($inputtext1);
			?><script type="text/javascript">ESONCalendar.bind("startDate");</script>
			结束：<?php 
				$inputtext2 = array(
				  'name'        => 'endDate',
				  'id'          => 'endDate',
				  'value'       => date('Y-m-d', strtotime($endDate)),
				  'maxlength'   => '10',
				  'size'        => '10',
				  'style'       => '',
				  'readonly'	=> 'readonly'
				);
	
				echo form_input($inputtext2);
			?><script type="text/javascript">ESONCalendar.bind("endDate");</script>
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