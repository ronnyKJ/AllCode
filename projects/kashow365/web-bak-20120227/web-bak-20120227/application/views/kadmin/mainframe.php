<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title;?> &gt;&gt; 首页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url();?>kadmin/css/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url();?>kadmin/css/main.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div class="main">
<div class="main_title"><?php echo $title;?> - 首页 </div>
<div class="blank5"></div>
<table class="form" cellspacing="0" cellpadding="0">
  <tbody>
  <tr>
    <td class="topTd" colspan="2"></td></tr>
  <tr>
    <td class="item_title" style="width: 200px">当前版本 </td>
    <td class="item_input">系统版本:1.1 <span id="version_tip"></span></td></tr>
  <tr>
    <td class=item_title style="width: 200px">系统当前时间 </td>
    <td class=item_input><?php echo $nowdate;?> </td></tr>
  <tr>
    <td class=item_title style="width: 200px">总注册会员数 </td>
    <td class=item_input><?php echo $userCount;?> 人, 其中：<br />
						<?php echo $userCount0;?> 人 - 已注册未验证<br />
						<?php echo $userCount1;?> 人 - 已注册已验证<br />
						<?php echo $userCount2;?> 人 - 注销 
	</td></tr>
  <tr>
    <td class=item_title style="width: 200px">卡统计 </td>
    <td class=item_input>买卖卡（<?php echo $cardForSale;?> 张）， 展示卡（<?php echo $cardForShow;?> 张）， 活动卡（<?php echo $cardForActivity;?> 张） </td></tr>
  <tr>
    <td class=item_title style="width: 200px">微博留言数 </td>
    <td class=item_input>共有 <?php echo $blogCountForUsers;?> 人发布，微博总量:<?php echo $blogCount;?> 篇 </td></tr>
  <tr>
    <td class=bottomTd colspan=2></td></tr></tbody></table></div></body></html>
