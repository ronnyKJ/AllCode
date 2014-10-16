<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title><?php echo $title;?> &gt;&gt; 卡秀积分管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>kadmin/css/style.css" />
<script src="<?php echo base_url();?>kadmin/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kadmin/js/jquery.timer.js" type="text/javascript"></script>
<script type='text/javascript'  src="<?php echo base_url();?>kadmin/public/kindeditor/kindeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>kadmin/js/jquery.bgiframe.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>kadmin/js/jquery.weebox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>kadmin/js/script.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>kadmin/css/weebox.css" />
</head>
<body>
<div id="info"></div>
<div class="main">
<div class="main_title">卡秀积分管理</div>
<div class="blank5"></div>
<?php #var_dump(count($rowsGrade)+2);?>
<?php #var_dump($rowsOperType);?>
<?php #var_dump($rowsGrade);?>
<?php  
$attributes = array('id' => 'form1');
echo form_open('kadmin/mainfuseropertype/doupdate', $attributes); 
?>
<div class="search_row">
		<input type="submit" class="button" value="保 存" />
</div>
<div class="blank5"></div>
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 >
	<tr>
		<td colspan="<?php echo count($rowsGrade)+2?>" class="topTd" >&nbsp; </td>
	</tr>
	<tr class="row" >
		<th width="40px">编号</th>
		<th width="100px">会员操作</th>
		<?php foreach ($rowsGrade as $rowg):?>
		<th>
			&nbsp;<?php echo $rowg['name'];?>
		</th>
		<?php endforeach;?>
	</tr>
	
	<?php $i=0;?>
	<?php foreach (array_keys($userOperTypeItems) as $okey):?>
	<?php $i=$i+1;?>
	<tr class="row" >
		<td valign="top">&nbsp;<?php echo $i;?></td>
		<td valign="top">&nbsp;<?php echo $userOperTypeItems[$okey];?></td>
		<?php foreach ($rowsGrade as $rowg):
				$isHave=false;
				$inputId = 'pv-'.$rowg['id'].'-'.$okey;
				foreach ($rowsOperType as $rowo):
					if($rowg['id']==$rowo['gradeId'] && $okey==$rowo['operType'] ){
		?>
		<td valign="top">奖励积分：
		<?php #var_dump( $_POST[$inputId] );?>
		<?php #var_dump( $rowo['plannedPoints'] );?>
		<?php 
			$input = array(
			  'name'        => $inputId,
			  'id'          => $inputId,
			  'value'       => isset($_POST[$inputId]) ? $_POST[$inputId] : $rowo['plannedPoints'],
			  'class'   	=> 'textbox',
			  'maxlength'   => '12',
			  'size'       	=> '10'
			);

			echo form_input($input);
		?>
		<br />
		<div class="message_row"><?php echo form_error($inputId); ?></div>
		</td>
		<?php 
					$isHave = true;
					break;
				}
		?>
		<?php 	
				endforeach;
				if(!$isHave){
		?>
		<td valign="top">奖励积分：
		<?php 
			$input = array(
			  'name'        => $inputId,
			  'id'          => $inputId,
			  'value'       => isset($_POST[$inputId]) ? $_POST[$inputId] : '0',
			  'class'   	=> 'textbox',
			  'maxlength'   => '12',
			  'size'       	=> '10'
			);

			echo form_input($input);
		?>
		<br />
		<div class="message_row"><?php echo form_error($inputId); ?></div>
		</td>
		<?php 	}?>
		<?php endforeach;?>
	</tr>
	<?php endforeach;?>
	<tr><td colspan="<?php echo count($rowsGrade)+2?>" class="bottomTd">&nbsp; </td></tr>
</table>
<div class="blank5"></div>
<div class="search_row">
		<input type="submit" class="button" value="保 存" />
</div>
</form>
</div>
</body>
</html>