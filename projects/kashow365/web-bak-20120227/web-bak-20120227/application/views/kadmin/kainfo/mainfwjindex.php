<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title><?php echo $title;?> &gt;&gt; Kashow公告管理</title>
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
	location.href="<?php echo site_url('kadmin/mainfwj/add');?>";
}
//编辑跳转
function orderTalbe(order,by){
	var root = "<?php echo site_url('kadmin/mainfwj');?>";
	var content = "<?php echo $content; ?>";
	location.href = root+"?content="+content+"&order="+order+"&by="+by+"&n=1";
}
//编辑跳转
function edit(id){
	var root = "<?php echo site_url('kadmin/mainfwj/edit');?>";
	location.href = root+"/"+id;
}
function del(id){
	if(window.confirm("确定要删除吗?")){
		var root = "<?php echo site_url('kadmin/mainfwj/d');?>";
		location.href = root+"/"+id;
	}
}
function dels(){
	var ids = GetCheckedItems();
	if(ids == undefined || ids == ""){return;}
	if(window.confirm("确定要删除选中项吗?")){
		var root = "<?php echo site_url('kadmin/mainfwj/ds');?>";
		location.href = root+"/"+ids;
	}
}
</script>

</head>
<body>
<div id="info"></div>
<div class="main">
<div class="main_title">kashow问卷列表</div>
<div class="blank5"></div>
<div class="button_row">
	<input type="button" class="button" value="新增" onClick="gotoAdd()" disabled="disabled" />
	<input type="submit" class="button" value="删除" onClick="dels();" />
</div>
<div class="blank5"></div>
<div class="search_row">
	<form name="search" action="<?php echo site_url('kadmin/mainfwj');?>" method="get">	
		问卷内容：<input type="text" class="textbox" name="content" value="<?php echo $content; ?>" />
		<input type="submit" class="button" value="搜索" />
</form>
</div>
<div class="blank5"></div>
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 >
	<tr>
		<td colspan="13" class="topTd" >&nbsp; </td>
	</tr>
	<tr class="row" >
		<th width="8px"><input type="checkbox" id="check" onClick="CheckAll('dataTable')"></th>
		<th width="50px">
			<a href="javascript:void(0)" onClick="sortBy(this.id,'id','<?php echo $by;?>','编号')" id="t1" 
				title="按照编号<?php echo $by=='a' ? '升' : '降';?>序排列 ">编号
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th><a href="javascript:void(0)" onClick="sortBy(this,'content','<?php echo $by;?>','公告内容')" id="t2" 
			title="按照公告内容<?php echo $by=='a' ? '升' : '降';?>序排列 ">问卷内容
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="100px">
			<a href="javascript:void(0)" onClick="sortBy(this,'state','<?php echo $by;?>','是否发布')" id="t3" 
			title="按照是否发布<?php echo $by=='a' ? '升' : '降';?>序排列 ">是否发布
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="170px">操作</th>
	</tr>
	<?php #var_dump($rows);?>
	<?php foreach ($rows as $row):?>
	<tr class="row" >
		<td><input type="checkbox" name="key" class="key" value="<?php echo $row['id'];?>"></td>
		<td>&nbsp;<?php echo $row['id'];?></td>
		<td>&nbsp;<a href="javascript:void(0)" onClick="edit('<?php echo $row['id'];?>')"><?php echo $row['problem'];?></a></td>
		<td style="text-align:center;">&nbsp;[ <a href='<?php echo site_url('kadmin/mainfwj/doUpState/'.$row['id'].'/'.$row['state']);?>' <?php echo $row['state']=='1' ? "style='color:red;'" : "";?>><?php echo DBtranslate::IsPublish($row['state']);?></a> ]</td>
		<td style="text-align:center;">
			<!--
			<a href="javascript:void(0)" onClick="edit('<?php echo $row['id'];?>')">编辑</a>&nbsp;
			<a href="javascript:void(0)" onClick="del('<?php echo $row['id'];?>')">删除</a>&nbsp;
			-->
		</td>
	</tr>
	<tr>
		<td colspan="5">
			<?php $wjA = MainFWJ::getansers($row['id']); ?>
			<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 >
			<?php foreach ($wjA as $row1):?>
			<tr>
				<td><?php echo $row1['anser'];?></td>
				<td>共点击：<?php echo $row1['ccount'];?> 次</td>
			</tr>
			<?php endforeach;?>
			</table>
			
		</td>
	</tr>
	<?php endforeach;?>
	<tr><td colspan="13" class="bottomTd">&nbsp; </td></tr>
</table>
<div class="blank5"></div>
<div class="page">
<?php
require_once 'kadmin/businessentity/tools/page.class.php';
$page=new page(array('total'=>$total,'perpage'=>$perpage));
echo $page->show(1);
?>
</div>
</div>
</body>
</html>