<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title><?php echo $title;?> &gt;&gt; 合伙拼卡管理</title>
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
	location.href="<?php echo site_url('kadmin/mainfcardforactivity/add');?>";
}
//编辑跳转
function orderTalbe(order,by){
	var root = "<?php echo site_url('kadmin/mainfcardforactivity');?>";
	var name = "<?php echo $name; ?>";
	location.href = root+"?name="+name+"&order="+order+"&by="+by+"&n=1";
}
//编辑跳转
function edit(id){
	var root = "<?php echo site_url('kadmin/mainfcardforactivity/edit');?>";
	location.href = root+"/"+id;
}
function del(id){
	if(window.confirm("确定要删除吗?")){
		var root = "<?php echo site_url('kadmin/mainfcardforactivity/d');?>";
		location.href = root+"/"+id;
	}
}
function dels(){
	var ids = GetCheckedItems();
	if(ids == undefined || ids == ""){return;}
	if(window.confirm("确定要删除选中项吗?")){
		var root = "<?php echo site_url('kadmin/mainfcardforactivity/ds');?>";
		location.href = root+"/"+ids;
	}
}
</script>

</head>
<body>
<div id="info"></div>
<div class="main">
<div class="main_title">合伙拼卡列表</div>
<div class="blank5"></div>
<div class="button_row">
	<!-- <input type="button" class="button" value="新增" onClick="gotoAdd()" /> -->
	<input type="submit" class="button" value="删除" onClick="dels();" />
</div>
<div class="blank5"></div>
<div class="search_row">
	<form name="search" action="<?php echo site_url('kadmin/mainfcardforactivity');?>" method="get">
		卡名称：<input type="text" class="textbox" name="name" value="<?php echo $name; ?>" /> &nbsp;&nbsp;
		<input type="submit" class="button" value="搜索" />
</form>
</div>
<div class="blank5"></div>
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 >
	<tr>
		<td colspan="13" class="topTd" >&nbsp; </td>
	</tr>
	<tr class="row" >
		<th width="8"><input type="checkbox" id="check" onClick="CheckAll('dataTable')"></th>
		<th width="50px">
			<a href="javascript:void(0)" onClick="sortBy(this.id,'id','<?php echo $by;?>','编号')" id="t1" 
				title="按照编号<?php echo $by=='a' ? '升' : '降';?>序排列 ">编号
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="200px"><a href="javascript:void(0)" onClick="sortBy(this,'cardImagePath','<?php echo $by;?>','卡图片')" id="t2" 
			title="按照卡图片<?php echo $by=='a' ? '升' : '降';?>序排列 ">卡图片
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th><a href="javascript:void(0)" onClick="sortBy(this,'name','<?php echo $by;?>','卡名称')" id="t2" 
			title="按照卡名称<?php echo $by=='a' ? '升' : '降';?>序排列 ">卡名称
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th><a href="javascript:void(0)" onClick="sortBy(this,'startDate','<?php echo $by;?>','市场价')" id="t2" 
			title="按照市场价<?php echo $by=='a' ? '升' : '降';?>序排列 ">发起时间
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th><a href="javascript:void(0)" onClick="sortBy(this,'endDate','<?php echo $by;?>','市场价')" id="t2" 
			title="按照市场价<?php echo $by=='a' ? '升' : '降';?>序排列 ">结束时间
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th><a href="javascript:void(0)" onClick="sortBy(this,'limitUser','<?php echo $by;?>','市场价')" id="t2" 
			title="按照市场价<?php echo $by=='a' ? '升' : '降';?>序排列 ">人数限制
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="70px"><a href="javascript:void(0)" onClick="sortBy(this,'userId','<?php echo $by;?>','发布会员')" id="t2" 
			title="按照发布会员<?php echo $by=='a' ? '升' : '降';?>序排列 ">发布会员
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="70px">
			<a href="javascript:void(0)" onClick="sortBy(this,'state','<?php echo $by;?>','是否发布')" id="t3" 
			title="按照是否发布<?php echo $by=='a' ? '升' : '降';?>序排列 ">是否发布
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="100px">
			<a href="javascript:void(0)" onClick="sortBy(this,'addDateTime','<?php echo $by;?>','创建时间')" id="t4" 
			title="按照创建时间<?php echo $by=='a' ? '升' : '降';?>序排列 ">创建时间
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="70px">操作</th>
	</tr>
	<?php #var_dump($rows);?>
	<?php foreach ($rows as $row):?>
	<tr class="row" >
		<td><input type="checkbox" name="key" class="key" value="<?php echo $row['id'];?>"></td>
		<td>&nbsp;<?php echo $row['id'];?></td>
		<td>&nbsp;<img src="<?php echo $this->config->item('UpPathCard').'/s2/'.$row['cardImagePath'];?>" width="178" height="91" /></td>
		<td>&nbsp;<a href="javascript:void(0)" onClick="edit('<?php echo $row['id'];?>')"><?php echo $row['name'];?></a></td>
		<td>&nbsp;<?php echo $row['startDate'];?></td>
		<td>&nbsp;<?php echo $row['endDate'];?></td>
		<td>&nbsp;<?php echo $row['limitUser'];?></td>
		<td style="text-align:center;">&nbsp;<a href="<?php echo $row['userId'];?>" target="_blank">点击查看会员资料</a></td>
		<td style="text-align:center;">&nbsp;[ <a href='<?php echo site_url('kadmin/mainfcardforactivity/doUpState/'.$row['id'].'/'.$row['state']);?>' <?php echo $row['state']=='3' ? "style='color:red;'" : "";?>><?php echo DBtranslate::IsPublishActivityCard($row['state']);?></a> ]</td>
		<td style="text-align:center;">&nbsp;<?php echo $row['addDateTime'];?></td>
		<td style="text-align:center;">
			<a href="javascript:void(0)" onClick="del('<?php echo $row['id'];?>')">删除</a>&nbsp;</td>
	</tr>
	<?php endforeach;?>
	<tr><td colspan="13" class="bottomTd">&nbsp; </td></tr>
</table>
<div class="blank5"></div>
<div class="page">
<?php
$page=new page(array('total'=>$total,'perpage'=>$perpage));
echo $page->show(1);
?>
</div>
</div>
</body>
</html>