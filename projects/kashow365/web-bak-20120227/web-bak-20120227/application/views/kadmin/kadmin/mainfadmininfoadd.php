<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title><?php echo $title;?> &gt;&gt; 编辑管理限</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>kadmin/css/style.css" />
<script src="<?php echo base_url();?>kadmin/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kadmin/js/jquery.timer.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>kadmin/public/kindeditor-3.5.5-zh_CN/kindeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>kadmin/js/script.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>kweb/js/ESONCalendar.js"></script>
<style type="text/css">
.item_input h4 { line-height:40px; color:#333333;}
#pvrem div { width:300px; height:100px; float:left;}
.item_input input { padding-right:10px;}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("#checkall").click(function() { 
		//alert($("#checkall").attr("checked"));
		if($("#checkall").attr("checked") == true) { // 全选 
			$("input[name='pv[]']").each(function(i) { 
				$(this).attr("checked", true); 
			}); 
		}else{
			$("input[name='pv[]']").each(function(i) { 
				$(this).attr("checked", false); 
			});
		}
	}); 
}); 
</script>
</head>
<body>
<div id="info"></div>
<div class="main">
<div class="main_title">编辑管理员</div>
<div class="blank5"></div>
<?php  
$attributes = array('id' => 'form1');
echo form_open('kadmin/mainfadmininfo/doadd', $attributes); 
?>
<table class="form" cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=2 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title" valign="top">管理员登录名称:</td>
		<td class="item_input">
			<?php 
				$inputtext = array(
				  'name'        => 'loginName',
				  'id'          => 'loginName',
				  'value'       => $loginName,
				  'maxlength'   => '200',
				  'size'        => '100',
				  'style'       => '',
				);
	
				echo form_input($inputtext);
			?>(新创建管理员默认密码为  kashow365.com)
			<br />
			<div class="message_row"><?php echo form_error('loginName'); ?></div>
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top">权限:</td>
		<td id="pvrem" class="item_input">
			<div>
			<h4>会员管理</h4>
			<input name="pv[]" type="checkbox" value="mainfuserinfo" <?php if(strpos(','.$purviewCode.',',',mainfuserinfo,')!==false){echo 'checked="checked"';}?>>会员审核管理</a><br />
			<input name="pv[]" type="checkbox" value="mainfusergrade" <?php if(strpos(','.$purviewCode.',',',mainfusergrade,')!==false){echo 'checked="checked"';}?>>会员等级划分</a><br />
			<input name="pv[]" type="checkbox" value="mainfuseropertype" <?php if(strpos(','.$purviewCode.',',',mainfuseropertype,')!==false){echo 'checked="checked"';}?>>积分奖励管理</a>
			</div>
			<div>
			<h4>积分管理</h4>
			<input name="pv[]" type="checkbox" value="mainfuserpointschanges" <?php if(strpos(','.$purviewCode.',',',mainfuserpointschanges,')!==false){echo 'checked="checked"';}?>>积分变更日志</a>
			</div>
			<div>
			<h4>系统管理员管理</h4>
			<input name="pv[]" type="checkbox" value="mainfadmininfo" <?php if(strpos(','.$purviewCode.',',',mainfadmininfo,')!==false){echo 'checked="checked"';}?>>管理员审核管理</a>
			</div>
			<div>
			<h4>站内消息管理</h4>
			<input name="pv[]" type="checkbox" value="mainfusermessages" <?php if(strpos(','.$purviewCode.',',',mainfusermessages,')!==false){echo 'checked="checked"';}?>>会员站内消息审核</a>
			</div>
			<div>
			<h4>微博管理</h4>
			<input name="pv[]" type="checkbox" value="mainfblogmessages" <?php if(strpos(','.$purviewCode.',',',mainfblogmessages,')!==false){echo 'checked="checked"';}?>>微博消息审核</a>
			</div>
			<div>
			<h4>卡留言管理</h4>
			<input name="pv[]" type="checkbox" value="mainfcardmessages" <?php if(strpos(','.$purviewCode.',',',mainfcardmessages,')!==false){echo 'checked="checked"';}?>>卡留言审核</a>
			</div>
			<div>
			<h4>信息发布管理</h4>
			<input name="pv[]" type="checkbox" value="mainfannount" <?php if(strpos(','.$purviewCode.',',',mainfannount,')!==false){echo 'checked="checked"';}?>>kashow公告管理</a>
			</div>
			<div>
			<h4>商场管理</h4>
			<input name="pv[]" type="checkbox" value="mainfshop" <?php if(strpos(','.$purviewCode.',',',mainfshop,')!==false){echo 'checked="checked"';}?>>商场管理</a>
			</div>
			<div>
			<h4>最新活动</h4>
			<input name="pv[]" type="checkbox" value="mainfshopnews" <?php if(strpos(','.$purviewCode.',',',mainfshopnews,')!==false){echo 'checked="checked"';}?>>最新活动管理</a>
			</div>
			<div>
			<h4>打折快报</h4>
			<input name="pv[]" type="checkbox" value="mainfshopnews2" <?php if(strpos(','.$purviewCode.',',',mainfshopnews2,')!==false){echo 'checked="checked"';}?>>打折快报管理</a>
			</div>
			<div>
			<h4>kashow兑换通知</h4>
			<input name="pv[]" type="checkbox" value="mainfshopnews3" <?php if(strpos(','.$purviewCode.',',',mainfshopnews3,')!==false){echo 'checked="checked"';}?>>兑换通知管理</a>
			</div>
			<div>
			<h4>卡管理</h4>
			<input name="pv[]" type="checkbox" value="mainfcardforexchange" <?php if(strpos(','.$purviewCode.',',',mainfcardforexchange,')!==false){echo 'checked="checked"';}?>>卡管理</a>
			</div>
			<div>
			<h4>网站首页管理</h4>
			<input name="pv[]" type="checkbox" value="mainfindex" <?php if(strpos(','.$purviewCode.',',',mainfindex,')!==false){echo 'checked="checked"';}?>>首页听说管理</a>
			</div>
			<div>
			<h4>生活广场页管理</h4>
			<input name="pv[]" type="checkbox" value="IndexFlashTop2" <?php if(strpos(','.$purviewCode.',',',IndexFlashTop2,')!==false){echo 'checked="checked"';}?>>生活广场页管理</a>
			</div>
			<div>
			<h4>有买有卖页管理</h4>
			<input name="pv[]" type="checkbox" value="AdSaleAd" <?php if(strpos(','.$purviewCode.',',',AdSaleAd,')!==false){echo 'checked="checked"';}?>>有买有卖页管理</a>
			</div>
			<div>
			<h4>合伙拼卡页管理</h4>
			<input name="pv[]" type="checkbox" value="AdSpellAd" <?php if(strpos(','.$purviewCode.',',',AdSpellAd,')!==false){echo 'checked="checked"';}?>>合伙拼卡页管理</a>
			</div>
			<div>
			<h4>礼尚往来页管理</h4>
			<input name="pv[]" type="checkbox" value="AdGiftAd" <?php if(strpos(','.$purviewCode.',',',AdGiftAd,')!==false){echo 'checked="checked"';}?>>礼尚往来广告管理</a>
			</div>
			<div>
			<h4>最新活动页管理</h4>
			<input name="pv[]" type="checkbox" value="AdActivityAd" <?php if(strpos(','.$purviewCode.',',',AdActivityAd,')!==false){echo 'checked="checked"';}?>>最新活动页管理</a>
			</div>
			<div>
			<h4>打折快报页管理</h4>
			<input name="pv[]" type="checkbox" value="AdDiscountAd" <?php if(strpos(','.$purviewCode.',',',AdDiscountAd,')!==false){echo 'checked="checked"';}?>>打折快报页管理</a>
			</div>
			<div>
			<h4>积分对换页管理</h4>
			<input name="pv[]" type="checkbox" value="AdConversionAd" <?php if(strpos(','.$purviewCode.',',',AdConversionAd,')!==false){echo 'checked="checked"';}?>>积分对换页管理</a>
			</div>
			<div>
			<h4>新闻类广告管理</h4>
			<input name="pv[]" type="checkbox" value="mainfshopAd" <?php if(strpos(','.$purviewCode.',',',mainfshopAd,')!==false){echo 'checked="checked"';}?>>新闻类广告管理</a>
			</div>
		</td>
	</tr>
	<tr id="content_tip">
		<td colspan="2">
			
		</td>
	</tr>
	<tr>
		<td class="item_title" valign="top"></td>
		<td class="item_input">(修改权限后，需要重新登录才能看到权限变化）
			<?php echo form_submit('btnSubmit', '提 交', 'class="button"');?>
			<?php echo form_reset('btnReset', '重 置', 'class="button"');?>
			<input type="button" class="button" value="返 回" onClick="history.go(-1)" />
			<?php echo form_hidden('id', $id, 'id="id"');?>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox"  id="checkall" name="checkall" /> 全选
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