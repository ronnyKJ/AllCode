<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><title><?php echo $title;?> &gt;&gt; 首页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url();?>kadmin/css/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url();?>kadmin/css/top.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div id="info"></div>
<div id="logo"></div>
<div id="tips"><a href="<?php echo base_url();?>" target="_blank">访问卡秀网首页</a> 
<a href="<?php echo site_url("kadmin/changepassword");?>" target="main">修改密码</a> 
<a href="<?php echo site_url("kadmin/loginout");?>" target="_parent">退出</a> </div>
<div class="blank5"></div>
<div id="navs">
<ul>
  <li><a href="<?php echo site_url("kadmin/index");?>" target="_parent">首页</a></li>
  <?php if(in_array('mainfuserinfo', $purviewCodes) 
		  || in_array('mainfusergrade', $purviewCodes) 
		  || in_array('mainfuseropertype', $purviewCodes)
		  || in_array('mainfuserpointschanges', $purviewCodes)
  		  || in_array('mainfadmininfo', $purviewCodes)
		) { ?>
  <li><a href="<?php echo site_url("kadmin/menuframe/1");?>" target="menu">会员管理</a></li>
  <?php } ?>
  <?php if(in_array('mainfusermessages', $purviewCodes) 
		  || in_array('mainfblogmessages', $purviewCodes) 
		  || in_array('mainfcardmessages', $purviewCodes)
		) { ?>
  <li><a href="<?php echo site_url("kadmin/menuframe/2");?>" target="menu">互动信息审核</a></li>
  <?php } ?>
  <?php if(in_array('mainfannount', $purviewCodes) && in_array('mainfshop', $purviewCodes) 
  			|| in_array('mainfshopnews', $purviewCodes)
			|| in_array('mainfshopnews2', $purviewCodes)
			|| in_array('mainfshopnews3', $purviewCodes)
		) { ?>
  <li><a href="<?php echo site_url("kadmin/menuframe/3");?>" target="menu">信息发布管理</a></li>
  <?php } ?>
  <?php if(in_array('mainfcardforexchange', $purviewCodes)) { ?>
  <li><a href="<?php echo site_url("kadmin/menuframe/4");?>" target="menu">卡管理</a></li>
  <?php } ?>
  <?php if(in_array('mainfindex', $purviewCodes)) { ?>
  <li><a href="<?php echo site_url("kadmin/menuframe/5");?>" target="menu">网站首页管理</a></li>
  <?php } ?>
  <?php if(in_array('IndexFlashTop2', $purviewCodes)) { ?>
  <li><a href="<?php echo site_url("kadmin/menuframe/6");?>" target="menu">生活广场页</a></li>
  <?php } ?>
  <?php if(in_array('AdSaleAd', $purviewCodes)) { ?>
  <li><a href="<?php echo site_url("kadmin/menuframe/7");?>" target="menu">有买有卖页</a></li>
  <?php } ?>
  <?php if(in_array('AdSpellAd', $purviewCodes)) { ?>
  <li><a href="<?php echo site_url("kadmin/menuframe/8");?>" target="menu">合伙拼卡页</a></li>
  <?php } ?>
  <?php if(in_array('AdGiftAd', $purviewCodes)) { ?>
  <li><a href="<?php echo site_url("kadmin/menuframe/9");?>" target="menu">礼尚往来页</a></li>
  <?php } ?>
  <?php if(in_array('AdActivityAd', $purviewCodes)) { ?>
  <li><a href="<?php echo site_url("kadmin/menuframe/10");?>" target="menu">最新活动页</a></li>
  <?php } ?>
  <?php if(in_array('AdDiscountAd', $purviewCodes)) { ?>
  <li><a href="<?php echo site_url("kadmin/menuframe/11");?>" target="menu">打折快报页</a></li>
  <?php } ?>
  <?php if(in_array('AdConversionAd', $purviewCodes)) { ?>
  <li><a href="<?php echo site_url("kadmin/menuframe/12");?>" target="menu">积分对换页</a></li>
  <?php } ?>
  </ul></div>
<div id="deal_msg" style="DISPLAY: none; FONT-SIZE: 12px; RIGHT: 115px; COLOR: #ccc; POSITION: absolute; TOP: 40px">业务队列群发中</div>
<div id="promote_msg" style="DISPLAY: none; FONT-SIZE: 12px; RIGHT: 15px; COLOR: #ccc; POSITION: absolute; TOP: 40px">推广队列群发中</div>
</body></html>
