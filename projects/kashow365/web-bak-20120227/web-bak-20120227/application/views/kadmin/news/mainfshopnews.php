<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title><?php echo $title;?> &gt;&gt; 最新活动管理</title>
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
	location.href="<?php echo site_url('kadmin/mainfshopnews/add');?>";
}
//编辑跳转
function orderTalbe(order,by){
	var root = "<?php echo site_url('kadmin/mainfshopnews');?>";
	var newsTitle = "<?php echo $newsTitle; ?>";
	var districtId = "<?php echo $districtId; ?>";
	var urbanId = "<?php echo $urbanId; ?>";
	var shopId = "<?php echo $shopId; ?>";
	location.href = root+"?newsTitle="+newsTitle+"&districIdt="+districtId+"&urbanId="+urbanId+"&shopId="+shopId+"&order="+order+"&by="+by+"&n=1";
}
//编辑跳转
function edit(id){
	var root = "<?php echo site_url('kadmin/mainfshopnews/edit');?>";
	location.href = root+"/"+id;
}
function del(id){
	if(window.confirm("确定要删除吗?")){
		var root = "<?php echo site_url('kadmin/mainfshopnews/d');?>";
		location.href = root+"/"+id;
	}
}
function dels(){
	var ids = GetCheckedItems();
	if(ids == undefined || ids == ""){return;}
	if(window.confirm("确定要删除选中项吗?")){
		var root = "<?php echo site_url('kadmin/mainfshopnews/ds');?>";
		location.href = root+"/"+ids;
	}
}
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
<div class="main_title">最新活动列表</div>
<div class="blank5"></div>
<div class="button_row">
	<input type="button" class="button" value="新增" onClick="gotoAdd()" />
	<input type="submit" class="button" value="删除" onClick="dels();" />
</div>
<div class="blank5"></div>
<div class="search_row">
	<form name="search" action="<?php echo site_url('kadmin/mainfshopnews');?>" method="get">
		活动名称：<input type="text" class="textbox" name="newsTitle" value="<?php echo $newsTitle; ?>" /> &nbsp;&nbsp;
		按地区搜索：
		<select id="district" name="districtId" onChange="areaSelect('<?php echo site_url('kadmin/mainfurban/getparent');?>','')">
		<option value="" <?php if($districtId==''){echo 'selected="selected"';}?>>请选择</option>
		<?php foreach ($districtRows as $row):?>
		<option value="<?php echo $row['id'];?>" <?php echo $row['id']== $districtId ? 'selected="selected"' : '';?>><?php echo $row['name'];?></option>
		<?php endforeach;?>
		</select>
		<select id="urban" name="urbanId">
		<option value="" selected="selected">请选择</option>
		</select>&nbsp;&nbsp;
		<?php #var_dump($shopRows);?>
		按主办商家搜索：<select id="shopId" name="shopId">
		<option value="" <?php if($shopId==''){echo 'selected="selected"';}?>>请选择</option>
		<?php foreach ($shopRows as $row):?>
		<option value="<?php echo $row['id'];?>" <?php echo $row['id']== $shopId ? 'selected="selected"' : '';?>><?php echo $row['shopName'];?></option>
		<?php endforeach;?>
		</select>
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
	<th><a href="javascript:void(0)" onClick="sortBy(this,'newsTitle','<?php echo $by;?>','活动名称')" id="t2" 
			title="按照活动名称<?php echo $by=='a' ? '升' : '降';?>序排列 ">活动名称
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th><a href="javascript:void(0)" onClick="sortBy(this,'shopname','<?php echo $by;?>','商场名称')" id="t2" 
			title="按照商场名称<?php echo $by=='a' ? '升' : '降';?>序排列 ">商场名称
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="100px">
			<a href="javascript:void(0)" onClick="sortBy(this,'districtName','<?php echo $by;?>','所在市区')" id="t3" 
			title="按照所在市区<?php echo $by=='a' ? '升' : '降';?>序排列 ">所在市区
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="170px">
			<a href="javascript:void(0)" onClick="sortBy(this,'urbanName','<?php echo $by;?>','所在区域')" id="t4" 
			title="按照所在区域<?php echo $by=='a' ? '升' : '降';?>序排列 ">所在区域
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th><a href="javascript:void(0)" onClick="sortBy(this,'orderNum','<?php echo $by;?>','排序字段')" id="t2" 
			title="按照排序字段<?php echo $by=='a' ? '升' : '降';?>序排列 ">排序字段
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="100px">
			<a href="javascript:void(0)" onClick="sortBy(this,'state','<?php echo $by;?>','是否发布')" id="t3" 
			title="按照是否发布<?php echo $by=='a' ? '升' : '降';?>序排列 ">是否发布
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="170px">
			<a href="javascript:void(0)" onClick="sortBy(this,'addDateTime','<?php echo $by;?>','创建时间')" id="t4" 
			title="按照创建时间<?php echo $by=='a' ? '升' : '降';?>序排列 ">创建时间
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="170px">操作</th>
	</tr>
	<?php #var_dump($rows);?>
	<?php foreach ($rows as $row):?>
	<tr class="row" >
		<td><input type="checkbox" name="key" class="key" value="<?php echo $row['id'];?>"></td>
		<td>&nbsp;<?php echo $row['id'];?></td>
		<td>&nbsp;<a href="javascript:void(0)" onClick="edit('<?php echo $row['id'];?>')"><?php echo $row['newsTitle'];?></a></td>
		<td>&nbsp;<?php echo $row['shopName'];?></td>
		<td style="text-align:center;">&nbsp;<?php echo $row['districtName'];?></td>
		<td style="text-align:center;">&nbsp;<?php echo $row['urbanName'];?></td>
		<td style="text-align:center;">&nbsp;<?php echo $row['orderNum'];?></td>
		<td style="text-align:center;">&nbsp;[ <a href='<?php echo site_url('kadmin/mainfshopnews/doUpState/'.$row['id'].'/'.$row['state']);?>' <?php echo $row['state']=='1' ? "style='color:red;'" : "";?>><?php echo DBtranslate::IsPublish($row['state']);?></a> ]</td>
		<td style="text-align:center;">&nbsp;<?php echo $row['addDateTime'];?></td>
		<td style="text-align:center;">
			<a href="javascript:void(0)" onClick="edit('<?php echo $row['id'];?>')">编辑</a>&nbsp;
			<a href="javascript:void(0)" onClick="del('<?php echo $row['id'];?>')">删除</a>&nbsp;</td>
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