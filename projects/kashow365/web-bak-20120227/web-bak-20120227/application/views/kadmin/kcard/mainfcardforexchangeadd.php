<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title><?php echo $title;?> &gt;&gt; 编辑兑换卡</title>
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
<div class="main_title">编辑兑换卡</div>
<div class="blank5"></div>
<?php  
$attributes = array('id' => 'form1');
echo form_open_multipart('kadmin/mainfcardforexchange/doadd', $attributes); 
?>
<table class="form" cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=2 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title" valign="top">兑换卡图片:</td>
		<td class="item_input">
			<img src="<?php echo $this->config->item('UpPathCard').'/s1/'.$cardImagePath; ?>" width="568px" height="289px" style="border:thin 1px;" />
			<br />
			<input type="file" name="userfile" size="20" />(请控制像素在：568*289)
			<br />
			<div class="message_row"><?php echo $uploadError;?></div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">兑换卡名称:</td>
		<td class="item_input">
			<?php 
				$inputtext = array(
				  'name'        => 'name',
				  'id'          => 'name',
				  'value'       => $name,
				  'maxlength'   => '200',
				  'size'        => '100',
				  'style'       => '',
				);
	
				echo form_input($inputtext);
			?>
			<br />
			<div class="message_row"><?php echo form_error('name'); ?></div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">兑换卡的种类:</td>
		<td class="item_input">
    <input type="checkbox" name="cbxct[]" id="cbxct1" value="1" <?php if(strpos(','.$cardType.',',',1,')!==false){echo 'checked="checked"';}?> />餐饮　
    <input type="checkbox" name="cbxct[]" id="cbxct2" value="2" <?php if(strpos(','.$cardType.',',',2,')!==false){echo 'checked="checked"';}?> />购物　
    <input type="checkbox" name="cbxct[]" id="cbxct3" value="3" <?php if(strpos(','.$cardType.',',',3,')!==false){echo 'checked="checked"';}?> />丽人　
    <input type="checkbox" name="cbxct[]" id="cbxct4" value="4" <?php if(strpos(','.$cardType.',',',4,')!==false){echo 'checked="checked"';}?> />休闲　
    <input type="checkbox" name="cbxct[]" id="cbxct5" value="5" <?php if(strpos(','.$cardType.',',',5,')!==false){echo 'checked="checked"';}?> />运动
    <input type="checkbox" name="cbxct[]" id="cbxct6" value="6" <?php if(strpos(','.$cardType.',',',6,')!==false){echo 'checked="checked"';}?> />旅游　
			<br />
			<div class="message_row"><?php echo form_error('cbxct[]'); ?>
</div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">兑换卡的用途:</td>
		<td class="item_input">
    <input type="checkbox" name="cbxcu[]" id="cbxcu1" value="1" <?php if(strpos(','.$cardUse.',',',1,')!==false){echo 'checked="checked"';}?> />打折　
    <input type="checkbox" name="cbxcu[]" id="cbxcu2" value="2" <?php if(strpos(','.$cardUse.',',',2,')!==false){echo 'checked="checked"';}?> />会员　
    <input type="checkbox" name="cbxcu[]" id="cbxcu3" value="3" <?php if(strpos(','.$cardUse.',',',3,')!==false){echo 'checked="checked"';}?> />提货卡　
	<input type="checkbox" name="cbxcu[]" id="cbxcu4" value="4" <?php if(strpos(','.$cardUse.',',',4,')!==false){echo 'checked="checked"';}?> />储值　
    <input type="checkbox" name="cbxcu[]" id="cbxcu5" value="5" <?php if(strpos(','.$cardUse.',',',5,')!==false){echo 'checked="checked"';}?> />积分　
    <input type="checkbox" name="cbxcu[]" id="cbxcu6" value="6" <?php if(strpos(','.$cardUse.',',',6,')!==false){echo 'checked="checked"';}?> />体验卡　
    <input type="checkbox" name="cbxcu[]" id="cbxcu7" value="7" <?php if(strpos(','.$cardUse.',',',7,')!==false){echo 'checked="checked"';}?> />VIP会员卡
			<br />
			<div class="message_row"><?php echo form_error('cbxcu[]'); ?>
</div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">兑换卡的交易:</td>
		<td class="item_input">
      	<label><input type="checkbox" name="cbxcts[]" id="cbxcts1" value="1" <?php if(strpos(','.$cardTtransactions.',',',1,')!==false){echo 'checked="checked"';}?> />储值卡</label>
		<label><input type="checkbox" name="cbxcts[]" id="cbxcts2" value="2" <?php if(strpos(','.$cardTtransactions.',',',2,')!==false){echo 'checked="checked"';}?> />提货卡</label>
		<label><input type="checkbox" name="cbxcts[]" id="cbxcts3" value="3" <?php if(strpos(','.$cardTtransactions.',',',3,')!==false){echo 'checked="checked"';}?> />礼品卡
			<br />
			<div class="message_row"><?php echo form_error('cbxcts[]'); ?>
</div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">活动所在区域:</td>
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
    <td class="item_title" valign="top">有 效 期：</td>
    <td class="item_input">
		<?php 
			$inputtext1 = array(
			  'name'        => 'period',
			  'id'          => 'period',
			  'value'       => $period,
			  'maxlength'   => '10',
			  'size'        => '10',
			  'style'       => '',
			  'readonly'	=> 'readonly'
			);

			echo form_input($inputtext1);
		?><script type="text/javascript">ESONCalendar.bind("period");</script></td>
    </tr>
	<tr>
		<td class="item_title" valign="top">兑换积分值:</td>
		<td class="item_input">
			<select id="exchangPoint" name="exchangPoint">
			<option value="" <?php if($exchangPoint==''){echo 'selected="selected"';}?>>请选择</option>
			<option value="100" <?php echo $exchangPoint== '100' ? 'selected="selected"' : '';?>>100ks</option>
			<option value="300" <?php echo $exchangPoint== '300' ? 'selected="selected"' : '';?>>300ks</option>
			<option value="500" <?php echo $exchangPoint== '500' ? 'selected="selected"' : '';?>>500ks</option>
			<option value="1000" <?php echo $exchangPoint== '1000' ? 'selected="selected"' : '';?>>1000ks</option>
			</select>
			<div class="message_row"><?php echo form_error('exchangPoint'); ?></div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">兑换卡剩余个数:</td>
		<td class="item_input">
			<?php 
				$inputtext = array(
				  'name'        => 'surplusCount',
				  'id'          => 'surplusCount',
				  'value'       => $surplusCount,
				  'maxlength'   => '200',
				  'size'        => '100',
				  'style'       => '',
				);
	
				echo form_input($inputtext);
			?>
			<br />
			<div class="message_row"><?php echo form_error('surplusCount'); ?></div>
		</td>
	</tr>

	<tr>
		<td class="item_title" valign="top">备注:</td>
		<td class="item_input">
			<script type='text/javascript'>
				KE.show({
					id : 'remarks',
					imageUploadJson : '<?php echo site_url('news/doupphoto');?>',
					fileManagerJson : '<?php echo site_url('news/dofilemanager');?>',
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
					  'name'        => 'remarks',
					  'id'          => 'remarks',
					  'value'       => $remarks,
					  'class'   	=> 'textarea',
					  'style'       => 'width:750px; height:350px;visibility:hidden;',
					);
		
					echo form_textarea($textarea);
				?>
				<br />
				<div class="message_row"><?php echo form_error('remarks'); ?></div>
			</div>
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
	<tr>
		<td class="item_title" valign="top">赞助商区域排序:</td>
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
		<td class="item_title" valign="top">是否在赞助商区域:</td>
		<td class="item_input">
			<?php 
				$options = array(
				  '0'        => '取消发布到赞助商',
				  '1'        => '发布到赞助商'
				);
				echo form_dropdown('isSponsors', $options, $isSponsors, 'id="isSponsors"');
			?>
			<div class="message_row"><?php echo form_error('isSponsors'); ?></div>
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