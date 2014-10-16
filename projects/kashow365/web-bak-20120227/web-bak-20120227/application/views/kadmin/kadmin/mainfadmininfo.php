<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title><?php echo $title;?> &gt;&gt; 管理员审核管理</title>
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
//编辑跳转
function orderTalbe(order,by){
	var root = "<?php echo site_url('kadmin/mainfadmininfo');?>";
	var kLoginName = "<?php echo $kLoginName; ?>";
	location.href = root+"?kLoginName="+kLoginName+"&order="+order+"&by="+by+"&n=1";
}
function sets(s){
	var ids = GetCheckedItems();
	if(ids == undefined || ids == ""){return;}
	if(s==0){
		if(window.confirm("确定要设置管理员不可登录吗?")){
			var root = "<?php echo site_url('kadmin/mainfadmininfo/s0');?>";
			location.href = root+"/"+ids;
		}
	}
	if(s==1){
		if(window.confirm("确定要设置管理员可登录吗?")){
			var root = "<?php echo site_url('kadmin/mainfadmininfo/s2');?>";
			location.href = root+"/"+ids;
		}
	}
}

//跳转添加
function gotoAdd(){
	location.href="<?php echo site_url('kadmin/mainfadmininfo/add');?>";
}
//编辑跳转
function edit(id){
	var root = "<?php echo site_url('kadmin/mainfadmininfo/edit');?>";
	location.href = root+"/"+id;
}
function del(id){
	if(window.confirm("确定要删除吗?")){
		var root = "<?php echo site_url('kadmin/mainfadmininfo/d');?>";
		location.href = root+"/"+id;
	}
}
function dels(){
	var ids = GetCheckedItems();
	if(ids == undefined || ids == ""){return;}
	if(window.confirm("确定要删除选中项吗?")){
		var root = "<?php echo site_url('kadmin/mainfadmininfo/ds');?>";
		location.href = root+"/"+ids;
	}
}
</script>

</head>
<body>
<div id="info"></div>
<div class="main">
<div class="main_title">管理员审核列表</div>
<div class="blank5"></div>
<div class="button_row">
	<input type="submit" class="button" value="批量设置管理员为不可登录" onClick="sets(0);" />
	<input type="submit" class="button" value="批量设置管理员为可登录" onClick="sets(1);" />
	<input type="button" class="button" value="新增" onClick="gotoAdd()" />
	<input type="submit" class="button" value="删除" onClick="dels();" />
</div>
<div class="blank5"></div>
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 >
	<tr>
		<td colspan="13" class="topTd" >&nbsp; </td>
	</tr>
	<tr class="row" >
		<th width="8"><input type="checkbox" id="check" onClick="CheckAll('dataTable')" /></th>
		<th width="50px">
			<a href="javascript:void(0)" onClick="sortBy(this.id,'id','<?php echo $by;?>','编号')" id="t1" 
				title="按照编号<?php echo $by=='a' ? '升' : '降';?>序排列 ">编号
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th><a href="javascript:void(0)" onClick="sortBy(this,'loginName','<?php echo $by;?>','登录名')" id="t2" 
			title="按照登录名<?php echo $by=='a' ? '升' : '降';?>序排列 ">管理员登录名
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th>
			<a href="javascript:void(0)" onClick="sortBy(this,'kState','<?php echo $by;?>','会员状态')" id="t3" 
			title="按照会员状态<?php echo $by=='a' ? '升' : '降';?>序排列 ">会员状态
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th>操作</th>
	</tr>
	<?php #var_dump($rows);?>
	<?php foreach ($rows as $row):?>
	<tr class="row" >
		<td><input type="checkbox" name="key" class="key" value="<?php echo $row['id'];?>"></td>
		<td>&nbsp;<?php echo $row['id'];?></td>
		<td>&nbsp;<?php echo $row['loginName'];?></td>
		<td style="text-align:center;">&nbsp;
			[ <a href='<?php echo site_url('kadmin/mainfadmininfo/doUpState/'.$row['id'].'/'.$row['kState']);?>' <?php echo $row['kState']=='1' ? "style='color:red;'" : "";?>><?php echo DBtranslate::IsAdminCanLogin($row['kState']);?></a> ]</td>
		<td style="text-align:center;">
			<a href="javascript:void(0)" onClick="edit('<?php echo $row['id'];?>')">编辑权限</a>&nbsp;
			<a href="javascript:void(0)" onClick="del('<?php echo $row['id'];?>')">删除</a>&nbsp;
		</td>
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