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
		$twidth = 36; $theight=40;
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
<title><?php echo $title;?> &gt;&gt;<?php echo $title; ?>管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>kadmin/css/style.css" />
<script src="<?php echo base_url();?>kadmin/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kadmin/js/jquery.timer.js" type="text/javascript"></script>
<script type='text/javascript'  src="<?php echo base_url();?>kadmin/public/kindeditor/kindeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>kadmin/js/jquery.bgiframe.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>kadmin/js/jquery.weebox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>kadmin/js/script.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>kadmin/css/weebox.css" />
<script type="text/javascript">
//跳转添加
function gotoAdd(){
	location.href="<?php echo site_url('kadmin/mainfbaseinfoif/add?v='.$infoType);?>";
}
//编辑跳转
function orderTalbe(order,by){
	var root = "<?php echo site_url('kadmin/mainfbaseinfoif');?>";
	location.href = root+"?order="+order+"&by="+by+"<?php echo '&v='.$infoType;?>";
}
//编辑跳转
function edit(id){
	var root = "<?php echo site_url('kadmin/mainfbaseinfoif/edit');?>";
	location.href = root+"/"+id+"<?php echo '?v='.$infoType;?>";
}
function del(id){
	if(window.confirm("确定要删除吗?")){
		var root = "<?php echo site_url('kadmin/mainfbaseinfoif/d');?>";
		location.href = root+"/"+id+"<?php echo '?v='.$infoType;?>";
	}
}

function dels(){
	var ids = GetCheckedItems();
	if(ids == undefined || ids == ""){return;}
	if(window.confirm("确定要删除选中项吗?")){
		var root = "<?php echo site_url('kadmin/mainfbaseinfoif/ds');?>";
		location.href = root+"/"+ids+"<?php echo '?v='.$infoType;?>";
	}
}
</script>
</head>
<body>
<div id="info"></div>
<div class="main">
<div class="main_title"><?php echo $title; ?>图片列表</div>
<div class="blank5"></div>
<?php #var_dump(count($rowsGrade)+2);?>
<?php #var_dump($rowsOperType);?>
<?php #var_dump($rowsGrade);?>
<?php  
$attributes = array('id' => 'form1');
echo form_open('kadmin/mainfbaseinfoif/doupdate?v='.$infoType, $attributes); 
?>
<div class="button_row">
	<input type="button" class="button" value="新增" onClick="gotoAdd()" /> 
	<input type="button" class="button" value="删除" onClick="dels();" /> 
	<input type="submit" class="button" value="保存" />
</div>
<div class="blank5"></div>
<div class="search_row"></div>
<div class="blank5"></div>
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 >
	<tr>
		<td colspan="13" class="topTd" >&nbsp; </td>
	</tr>
	<tr class="row" >
		<th width="8"><input type="checkbox" id="check" onClick="CheckAll('dataTable')"></th>
		<!--
		<th width="50px">
			<a href="javascript:void(0)" onClick="sortBy(this.id,'id','<?php echo $by;?>','编号')" id="t1" 
				title="按照编号<?php echo $by=='a' ? '升' : '降';?>序排列 ">编号
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		-->
		<th><a href="javascript:void(0)" onClick="sortBy(this,'value1','<?php echo $by;?>','图片')" id="t2" 
			title="按照图片<?php echo $by=='a' ? '升' : '降';?>序排列 ">图片
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="100px"><a href="javascript:void(0)" onClick="sortBy(this,'value2','<?php echo $by;?>','跳转URL')" id="t2" 
			title="按照跳转URL<?php echo $by=='a' ? '升' : '降';?>序排列 ">链接
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th><a href="javascript:void(0)" onClick="sortBy(this,'orderNum','<?php echo $by;?>','排序')" id="t2" 
			title="按照排序<?php echo $by=='a' ? '升' : '降';?>序排列 ">排序
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="130px">
			<a href="javascript:void(0)" onClick="sortBy(this,'updateDateTime','<?php echo $by;?>','更新时间')" id="t3" 
			title="按照更新时间<?php echo $by=='a' ? '升' : '降';?>序排列 ">更新时间
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="100px">操作</th>
	</tr>
	<?php #var_dump($rows);?>
	<?php foreach ($rows as $row):?>
	<tr class="row" >
		<td><input type="checkbox" name="key" class="key" value="<?php echo $row['id'];?>"></td>
		<!-- <td>&nbsp;<?php echo $row['id'];?></td> -->
		<td style="text-align:center;">&nbsp;<img src="<?php echo $this->config->item('UpPathFlashIndex').$row['value1'];?>" width="178px" height="95px" /></td>
		<?php if($infoType=='AdIndexSpellCard'){ ?>
		<td style="text-align:center;">[<a href="<?php echo site_url('spell/spellxl/'.$row['value2']); ?>" target="_blank">点击链接</a>]</td>
		<?php } else if($infoType=='AdIndexSaleCard'){ ?>
		<td style="text-align:center;">[<a href="<?php echo site_url('sale/rebatsale/'.$row['value2']); ?>" target="_blank">点击链接</a>]</td>
		<?php } else {?>
		<td style="text-align:center;">[<a href="<?php echo $row['value2']; ?>" target="_blank">点击链接</a>]</td>
		<?php }?>

		<td align="center">&nbsp;
		<?php 
			$inputId = 'p'.$row['id'];
			$input = array(
			  'name'        => $inputId,
			  'id'          => $inputId,
			  'value'       => isset($_POST[$inputId]) ? $_POST[$inputId] : $row['orderNum'],
			  'class'   	=> 'textbox',
			  'maxlength'   => '12',
			  'size'       	=> '3'
			);

			echo form_input($input);
		?>
		<br />
		<div class="message_row"><?php echo form_error($inputId); ?></div>
		</td>
		<td style="text-align:center;">&nbsp;<?php echo $row['updateDateTime'];?></td>
		<td style="text-align:center;">
			<a href="javascript:void(0)" onClick="edit('<?php echo $row['id'];?>')">编辑</a>&nbsp;
			<a href="javascript:void(0)" onClick="del('<?php echo $row['id'];?>')">删除</a>&nbsp;
			<?php 
				if($infoType=='AdIndexSpellCard'){
					if(MainFBaseInfoIF::CheckSpellCardState($row['value2']) == 3){
			?>
			<br /><br /><span style="color:#FF0000">该卡已失效请删除</span>
			<?php 
					}
				}
			?>
			
			<?php 
				if($infoType=='AdIndexSaleCard'){
					if(MainFBaseInfoIF::CheckSaleCardState($row['value2']) == 3){
			?>
			<br /><br /><span style="color:#FF0000">该卡已失效请删除</span>
			<?php 
					}
				}
			?>
		</td>		
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="6">显示文本： &nbsp;<?php echo $row['value3'];?></td>
	</tr>
	<?php endforeach;?>
	<tr><td colspan="13" class="bottomTd">&nbsp; </td></tr>
</table>
<div class="blank5"></div>
</div>
</form>
</body>
</html>