<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title><?php echo $title;?> &gt;&gt; 首页有趣的人推荐管理</title>
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
	var root = "<?php echo site_url('kadmin/mainfuserinfoindex');?>";
	var kLoginName = "<?php echo $kLoginName; ?>";
	var nickname = "<?php echo $nickname; ?>";
	location.href = root+"?kLoginName="+kLoginName+"&nickname="+nickname+"&order="+order+"&by="+by+"&n=1";
}
function sets(s){
	var ids = GetCheckedItems();
	if(ids == undefined || ids == ""){return;}
	if(s==0){
		if(window.confirm("确定要设置会员吗?")){
			var root = "<?php echo site_url('kadmin/mainfuserinfoindex/s0');?>";
			location.href = root+"/"+ids;
		}
	}
	if(s==1){
		if(window.confirm("确定要设置会员吗?")){
			var root = "<?php echo site_url('kadmin/mainfuserinfoindex/s1');?>";
			location.href = root+"/"+ids;
		}
	}
}
</script>
</head>
<body>
<div id="info"></div>
<div class="main">
<div class="main_title">会员审核列表</div>
<div class="blank5"></div>
<div class="search_row">
	<form name="search" action="<?php echo site_url('kadmin/mainfuserinfoindex');?>" method="get">	
		登录名：<input type="text" class="textbox" name="kLoginName" value="<?php echo $kLoginName; ?>" /> 
		昵称：<input type="text" class="textbox" name="nickname" value="<?php echo $nickname; ?>" /> 
		<input type="submit" class="button" value="搜索" />
</form>
</div>

<div class="blank5"></div>
<?php  
$attributes = array('id' => 'form1');
echo form_open('kadmin/mainfuserinfoindex/doupdate', $attributes); 
?>
<div class="button_row">
	<input type="button" class="button" value="批量推荐" onClick="sets(1);" />
	<input type="button" class="button" value="批量取消推荐" onClick="sets(0);" />
	<input type="submit" class="button" value="保存排序值 " onClick="save();" />
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
		<th><a href="javascript:void(0)" onClick="sortBy(this,'nickname','<?php echo $by;?>','昵称')" id="t2" 
			title="按照昵称<?php echo $by=='a' ? '升' : '降';?>序排列 ">昵称
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="180px">
			<a href="javascript:void(0)" onClick="sortBy(this,'kState','<?php echo $by;?>','会员状态')" id="t3" 
			title="按照会员状态<?php echo $by=='a' ? '升' : '降';?>序排列 ">会员状态
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="100px">
			<a href="javascript:void(0)" onClick="sortBy(this,'gradeName','<?php echo $by;?>','会员等级')" id="t3" 
			title="按照会员等级<?php echo $by=='a' ? '升' : '降';?>序排列 ">会员等级
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="90px">
			<a href="javascript:void(0)" onClick="sortBy(this,'kPoints','<?php echo $by;?>','当前积分')" id="t3" 
			title="按照当前积分<?php echo $by=='a' ? '升' : '降';?>序排列 ">当前积分
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="90px">
			<a href="javascript:void(0)" onClick="sortBy(this,'kPointsAccumulative','<?php echo $by;?>','累计积分')" id="t3" 
			title="按照累计积分<?php echo $by=='a' ? '升' : '降';?>序排列 ">累计积分
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="100px">
			<a href="javascript:void(0)" onClick="sortBy(this,'kMail','<?php echo $by;?>','Mail')" id="t3" 
			title="按照Mail<?php echo $by=='a' ? '升' : '降';?>序排列 ">Mail
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="100px">
			<a href="javascript:void(0)" onClick="sortBy(this,'wbid','<?php echo $by;?>','wbid')" id="t3" 
			title="按照推荐操作<?php echo $by=='a' ? '升' : '降';?>序排列 ">推荐操作
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="180px">
			<a href="javascript:void(0)" onClick="sortBy(this,'loginDateTime','<?php echo $by;?>','最后一次登')" id="t3" 
			title="按照推荐时间<?php echo $by=='a' ? '升' : '降';?>序排列 ">推荐时间
			<img src="<?php echo base_url();?>kadmin/images/<?php echo $by=='a' ? 'asc.gif' : 'desc.gif';?>" width="12" height="17" border="0" align="absmiddle" /></a>
		</th>
		<th width="90px">操作</th>
	</tr>
	<?php #var_dump($rows);?>
	<?php foreach ($rows as $row):?>
	<tr class="row" >
		<td><input type="checkbox" name="key" class="key" value="<?php echo $row['id'];?>"></td>
		<td>&nbsp;<?php echo $row['id'];?></td>
		<td>&nbsp;<a href="javascript:void(0)" onClick="edit('<?php echo $row['id'];?>')"><?php echo $row['nickname'];?></a></td>
		<td style="text-align:center;">&nbsp;
			[ <span <?php echo $row['kState']=='0' ? "style='color:red;'" : "";?>><?php echo DBtranslate::IsRegOK($row['kState']);?></span> ] 
			[ <a  <?php echo $row['kState']=='2' ? "style='color:red;'" : "";?>><?php echo DBtranslate::IsCanLogin($row['kState']);?></a> ]</td>
		<td style="text-align:center;">&nbsp;<?php echo $row['gradeName'];?></td>
		<td style="text-align:center;">&nbsp;<?php echo $row['kPoints'];?></td>
		<td style="text-align:center;">&nbsp;<?php echo $row['kPointsAccumulative'];?></td>
		<td style="text-align:center;">&nbsp;<?php echo $row['kMail'];?></td>
		<td style="text-align:center;">&nbsp;
			[ <a href='<?php if($row['wbid']!=''){echo site_url('kadmin/mainfuserinfoindex/doUpState/'.$row['id'].'/0');}else{echo site_url('kadmin/mainfuserinfoindex/doUpState/'.$row['id'].'/1');}?>' <?php echo $row['wbid']!='' ? "style='color:red;'" : "";?>><?php echo DBtranslate::IsCanAdIndexUserInfo($row['wbid']);?></a> ]
			<?php if($row['wbid']!=''){ ?>
			<?php 
				$inputId = 'p'.$row['wbid'];
				$input = array(
				  'name'        => $inputId,
				  'id'          => $inputId,
				  'value'       => isset($_POST[$inputId]) ? $_POST[$inputId] : $row['orderNum'],
				  'class'   	=> 'textbox',
				  'maxlength'   => '12',
				  'size'       	=> '10'
				);
	
				echo form_input($input);
			?>
			<br />
			<div class="message_row"><?php echo form_error($inputId); ?></div>
			<?php } ?>
		</td>
		<td style="text-align:center;">&nbsp;<?php echo $row['wbupdateDateTime'];?></td>
		<td style="text-align:center;">
			<a href="<?php echo site_url('member/other/'.$row['id']);?>" target="_blank">查看会员页</a></td>
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