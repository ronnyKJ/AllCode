<?php
include_once 'common.php';
?>
<h4>kadmin/businessentity/loginbll.php</h4>
<label>
<a href="<?php echo $config['base_url'];?>/index.php/kadmin/login/dologin?adm_name=asfefefee" target="_blank">
	TestLogin - (/index.php/kadmin/login/dologin?adm_name=asfefefee)</a>
</label>
<br />
<label>
<a href="<?php echo $config['base_url'];?>/index.php/kadmin/login/dologin?adm_name=pct&adm_password=123456" target="_blank">
	TestLogin - (/index.php/kadmin/login/dologin?adm_name=pct&adm_password=123456)</a>
</label>
<br />
<label>
<a href="<?php echo $config['base_url'];?>/index.php/kadmin/login/dologin?adm_name=pct&adm_password=123456&adm_verify=123456" target="_blank">
	TestLogin - (/index.php/kadmin/login/dologin?adm_name=pct&adm_password=123456&adm_verify=123456)</a>
</label>
<br />
<label>
<a href="<?php echo $config['base_url'];?>/index.php/kadmin/login/dologin?adm_name=pct&adm_password=123456&adm_verify=123456&dataType=json" target="_blank">
	TestLogin - (/index.php/kadmin/login/dologin?adm_name=pct&adm_password=123456&adm_verify=123456&dataType=json)</a>
</label>
<br />
<hr />
<br />
<?php  echo md5('123456');?>
<br />session:
<?php  
session_start();
echo $_SESSION['verify'];
?>
 
 
 <?php echo $showtime=date("Y-m-d H:i:s");?> 
 