<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><title><?php echo $title;?> &gt;&gt; 首页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url();?>kadmin/css/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url();?>kadmin/css/left.css" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url();?>kadmin/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kadmin/js/jquery.timer.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kadmin/js/left.js" type="text/javascript"></script>
</head>
<body>
<dl class="menu">
  <dt>首页
	<dd><a href="<?php echo site_url("kadmin/mainframe");?>" target="main">首页</a></dd> 

<?php if($t=='' || $t=='1'){?>
  <!-- 会员管理 -->
  <?php if(in_array('mainfuserinfo', $purviewCodes) && in_array('mainfusergrade', $purviewCodes) && in_array('mainfuseropertype', $purviewCodes)) { ?>
  <dt>会员管理</dt>
  	<?php if(in_array('mainfuserinfo', $purviewCodes)){ ?>
	<dd><a href="<?php echo site_url("kadmin/mainfuserinfo");?>">会员审核管理</a></dd>
	<?php } ?>
  	<?php if(in_array('mainfusergrade', $purviewCodes)){ ?>
	<dd><a href="<?php echo site_url("kadmin/mainfusergrade");?>">会员等级划分</a></dd>
	<?php } ?>
  	<?php if(in_array('mainfuseropertype', $purviewCodes)){ ?>
	<dd><a href="<?php echo site_url("kadmin/mainfuseropertype");?>">积分奖励管理</a></dd>
	<?php } ?>
  <?php } ?>
  
  <?php if(in_array('mainfuserpointschanges', $purviewCodes)){ ?>
  <dt>积分管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfuserpointschanges");?>">积分变更日志</a></dd>
  <?php } ?>
  
  <?php if(in_array('mainfadmininfo', $purviewCodes)){ ?>
  <dt>系统管理员管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfadmininfo");?>">管理员审核管理</a></dd>
  <?php } ?>
<?php }?>

<?php if($t=='' || $t=='2'){?>
  <!-- 互动信息审核 -->
  <?php if(in_array('mainfusermessages', $purviewCodes)){ ?>
  <dt>站内消息管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfusermessages");?>">会员站内消息审核</a></dd>
  <?php } ?>
  
  <?php if(in_array('mainfblogmessages', $purviewCodes)){ ?>
  <dt>微博管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfblogmessages");?>">微博消息审核</a></dd>
  <?php } ?>
  
  <?php if(in_array('mainfcardmessages', $purviewCodes)){ ?>
  <dt>卡留言管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfcardmessages");?>">卡留言审核</a></dd>
  <?php }?>	
<?php }?>

<?php if($t=='' || $t=='3'){?>
  <!-- 信息发布管理 -->
  <?php if(in_array('mainfannount', $purviewCodes)){ ?>
  <dt>公告管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfshopnews4");?>">kashow公告管理</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfshopnews4/add");?>">添加kashow公告</a></dd>
  <?php } ?>
  
  <?php if(in_array('mainfshop', $purviewCodes)){ ?>
  <dt>商场管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfshop");?>">商场管理</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfshop/add");?>">添加商场</a></dd>
  <?php } ?>
  
  <?php if(in_array('mainfshopnews', $purviewCodes)){ ?>
  <dt>最新活动</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfshopnews");?>">最新活动管理</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfshopnews/add");?>">添加最新活动</a></dd>
  <?php } ?>
  
  <?php if(in_array('mainfshopnews2', $purviewCodes)){ ?>
  <dt>打折快报</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfshopnews2");?>">打折快报管理</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfshopnews2/add");?>">添加打折快报</a></dd>
  <?php } ?>
  
  <?php if(in_array('mainfshopnews3', $purviewCodes)){ ?>
  <dt>kashow兑换通知</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfshopnews3");?>">兑换通知管理</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfshopnews3/add");?>">添加兑换通知</a></dd>
  <?php }?>
  
  <?php if(in_array('mainfshopAd', $purviewCodes)){ ?>
  <dt>广告管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoad?o=in&v=1");?>">最新活动广告管理</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoad?o=in&v=2");?>">打折快报广告管理</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoad?o=in&v=3");?>">兑换通知广告管理</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoad?o=in&v=4");?>">公告广告管理</a></dd>
  <?php }?>
<?php }?>

<?php if($t=='' || $t=='4'){?>
  <!-- 卡管理 -->
  <?php if(in_array('mainfcardforexchange', $purviewCodes)){ ?>
  <dt>兑换卡卡管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfcardforexchange");?>">兑换卡管理</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfcardforexchange/add");?>">添加兑换卡</a></dd>
  <dt>有买有卖卡管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfcardforsale");?>">有买有卖卡管理</a></dd>
  <dt>展示卡管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfcardforshow");?>">展示卡管理</a></dd>
  <dt>合伙拼卡管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfcardforactivity");?>">合伙拼卡管理</a></dd>
  <?php }?>
<?php }?>

<?php if($t=='' || $t=='5'){?>
  <!-- 网站首页管理 -->
  <?php if(in_array('mainfindex', $purviewCodes)){ ?>
  <dt>网站首页管理</dt>
    <dd><a href="<?php echo site_url("kadmin/mainfbaseinfoheari");?>">首页听说管理</a></dd>	
  	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoif?v=IndexFlashTop1");?>">首页FLASH管理</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoad?o=like&v=AdIndexAd");?>">首页广告管理</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoif?v=AdIndexSpellAd");?>">首页合伙拼卡动画管理</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoif?v=AdIndexSpellCard");?>">首页合伙拼卡卡管理</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoif?v=AdIndexSaleAd");?>">首页有买有卖动画管理</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoif?v=AdIndexSaleCard");?>">首页有买有卖卡管理</a></dd>	
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoif?v=AdIndexBrandAd");?>">首页品牌广场管理</a></dd>	
	<dd><a href="<?php echo site_url("kadmin/mainfwj");?>">首页问卷管理</a></dd>	
	<dd><a href="<?php echo site_url("kadmin/mainfuserinfoindex");?>">有趣的人推荐管理</a></dd>	
  <?php }?>
<?php }?>

<?php if($t=='' || $t=='6'){?>
  <!-- 生活广场页管理 -->
  <?php if(in_array('IndexFlashTop2', $purviewCodes)){ ?>
  <dt>生活广场页管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoif?v=IndexFlashTop2");?>">生活广场FLASH管理</a></dd>
  <?php }?>
<?php }?>

<?php if($t=='' || $t=='7'){?>
  <!-- 有买有卖页管理 -->
  <?php if(in_array('AdSaleAd', $purviewCodes)){ ?>
  <dt>有买有卖页管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfosale");?>">有买有卖宣传言管理</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfosale/add");?>">添加宣传言</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoad?o=like&v=AdSaleAd");?>">有买有卖广告管理</a></dd>	
  <?php }?>
<?php }?>

<?php if($t=='' || $t=='8'){?>
  <!-- 合伙拼卡页管理 -->
  <?php if(in_array('AdSpellAd', $purviewCodes)){ ?>
  <dt>合伙拼卡页管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfospell");?>">合伙拼卡宣传言管理</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfospell/add");?>">添加宣传言</a></dd>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoad?o=like&v=AdSpellAd");?>">合伙拼卡广告管理</a></dd>	
  <?php }?>
<?php }?>

<?php if($t=='' || $t=='9'){?>
  <!-- 礼尚往来页管理 -->
  <?php if(in_array('AdGiftAd', $purviewCodes)){ ?>
  <dt>礼尚往来页管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoad?o=like&v=AdGiftAd");?>">礼尚往来广告管理</a></dd>	
  <?php }?>
<?php }?>

<?php if($t=='' || $t=='10'){?>
  <!-- 最新活动页管理 -->
  <?php if(in_array('AdActivityAd', $purviewCodes)){ ?>
  <dt>最新活动页管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoad?o=like&v=AdActivityAd");?>">最新活动广告管理</a></dd>
  <?php }?>
<?php }?>

<?php if($t=='' || $t=='11'){?>
  <!-- 打折快报页管理 -->
  <?php if(in_array('AdDiscountAd', $purviewCodes)){ ?>
  <dt>打折快报页管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoad?o=like&v=AdDiscountAd");?>">打折快报广告管理</a></dd>	
  <?php }?>
<?php }?>

<?php if($t=='' || $t=='12'){?>
  <!-- 积分对换页管理 -->
  <?php if(in_array('AdConversionAd', $purviewCodes)){ ?>
  <dt>积分对换页管理</dt>
	<dd><a href="<?php echo site_url("kadmin/mainfbaseinfoad?o=like&v=AdConversionAd");?>">积分对换广告管理</a></dd>	
  <?php }?>
<?php }?>

</dl></body></html>