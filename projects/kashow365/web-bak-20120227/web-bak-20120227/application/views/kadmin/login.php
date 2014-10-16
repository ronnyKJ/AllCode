<!DOCTYPE html PUBLIC "-//W3C//Dtd XHTML 1.0 Transitional//EN" "http://www.w3.org/tr/xhtml1/Dtd/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title;?> &gt;&gt; 管理员登陆</title>
<script type="text/javascript">
	//定义JS语言
	var ADM_NAME_EMPTY = '管理员帐号不能为空';
	var ADM_PASSWORD_EMPTY = '管理员密码不能为空';
	var ADM_VERIFY_EMPTY = '验证码不能为空';
	function resetwindow()
	{
		if(top.location != self.location)
		{
			//top.location.href = self.location.href;
			//return 
		}
	}
	resetwindow();
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>kadmin/css/login.css" />
<script type="text/javascript" src="<?php echo base_url();?>kadmin/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>kadmin/js/jquery.timer.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>kadmin/js/login.js"></script>
</head>
<body class="body" bgColor="#ffffff">
<form id="formlogin" name="formlogin" action="<?php echo site_url("kadmin/login/dologin");?>" >
<!--<input type="submit" value="asdfasfasdf" />  target="_blank"-->
<table style="MARGIN: 0px auto" border="0" cellSpacing="0" cellPadding="0" width="695"><tbody>
  <tr>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="28" height="1" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="300" height="1" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="71" height="1" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="103" height="1" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="6" height="1" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="5" height="1" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="45" height="1" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="2" height="1" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="135" height="1" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="1" height="1" /></td></tr>
  <tr>
    <td colSpan=9><img id="login_r1_c1" border="0" name=login_r1_c1 alt="" src="<?php echo base_url();?>kadmin/images/login_r1_c1.png" width="695" height="40" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="1" height="40" /></td></tr>
  <tr>
    <td rowSpan="11"><img id="login_r2_c1" border="0" name=login_r2_c1 alt="" src="<?php echo base_url();?>kadmin/images/login_r2_c1.png" width="28" height="229" /></td>
    <td rowSpan="11"><img id="logo" border="0" name=login_r2_c2 alt="" src="<?php echo base_url();?>kadmin/images/kalogo.gif" width="300" height="229"></td>
    <td rowSpan="11"><img id="login_r2_c3" border="0" name=login_r2_c3 alt="" src="<?php echo base_url();?>kadmin/images/login_r2_c3.png" width="71" height="229"></td>
    <td colSpan="5" class="wd">
      <DIV id=login_msg></DIV></td>
    <td rowSpan="11"><img id="login_r2_c9" border="0" name=login_r2_c9 alt="" src="<?php echo base_url();?>kadmin/images/login_r2_c9.png" width="135" height="229"></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="1" height="45"></td></tr>
  <tr>
    <td class="wd3" colSpan="5">
		<input class="adm_name inputtext" name="adm_name"> </td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="1" height="27"></td></tr>
  <tr>
    <td colSpan="5"><img id="login_r4_c4" border="0" name=login_r4_c4 alt="" src="<?php echo base_url();?>kadmin/images/login_r4_c4.png" width="161" height="5" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="1" height="5" /></td></tr>
  <tr>
    <td class="wd2" colSpan="5">
		<input class="adm_password inputtext" type="password" name="adm_password"> </td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="1" height="27" /></td></tr>
  <tr>
    <td colSpan="5"><img id="login_r6_c4" border="0" name=login_r6_c4 alt="" src="<?php echo base_url();?>kadmin/images/login_r6_c4.png" width="161" height="5" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="1" height="5" /></td></tr>
  <tr>
    <td class="wd1" rowSpan="3"><input class="login_input adm_verify inputtext1" name="adm_verify"> </td>
    <td colSpan=4><img id="login_r7_c5" border="0" name=login_r7_c5 alt="" src="<?php echo base_url();?>kadmin/images/login_r7_c5.png" width="58" height="4" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="1" height="4" /></td></tr>
  <tr>
    <td rowSpan="3"><img id="login_r8_c5" border="0" name=login_r8_c5 alt="" src="<?php echo base_url();?>kadmin/images/login_r8_c5.png" width="6" height="31" /></td>
    <td colSpan="2"><img id="verify" align="absMiddle" src="<?php echo base_url();?>kadmin/businessentity/verify.php" /></td>
    <td rowSpan=5><img id="login_r8_c8" border="0" name=login_r8_c8 alt="" src="<?php echo base_url();?>kadmin/images/login_r8_c8.png" width="2" height="116"></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="1" height="22"></td></tr>
  <tr>
    <td rowSpan="2" colSpan="2"><img id="login_r9_c6" border="0" name=login_r9_c6 alt="" src="<?php echo base_url();?>kadmin/images/login_r9_c6.png" width="50" height="9"></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="1" height="1"></td></tr>
  <tr>
    <td><img id="login_r10_c4" border="0" name=login_r10_c4 alt="" src="<?php echo base_url();?>kadmin/images/login_r10_c4.png" width="103" height="8" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="1" height="8" /></td></tr>
  <tr>
    <td colSpan=3><img id="login_btn" class="login_button submit" border="0" name="login_r11_c4" alt="" src="<?php echo base_url();?>kadmin/images/login_r11_c4.png" width="114" height="31" /></td>
    <td rowSpan="2"><img id="login_r11_c7" border="0" name=login_r11_c7 alt="" src="<?php echo base_url();?>kadmin/images/login_r11_c7.png" width="45" height="85" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="1" height="31" /></td></tr>
  <tr>
    <td colSpan=3><img id="login_r12_c4" border="0" name=login_r12_c4 alt="" src="<?php echo base_url();?>kadmin/images/login_r12_c4.png" width="114" height="54" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="1" height="54" /></td></tr>
  <tr>
    <td colSpan=9><img id="login_r13_c1" border="0" name=login_r13_c1 alt="" src="<?php echo base_url();?>kadmin/images/login_r13_c1.png" width="695" height="66" /></td>
    <td><img border="0" alt="" src="<?php echo base_url();?>kadmin/images/spacer.gif" width="1" height="66" /></td></tr></tbody></table>
</form>
</body>
</html>
