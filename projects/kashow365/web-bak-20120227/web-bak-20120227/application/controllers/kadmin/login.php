<?php
class Login extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  
  $this->load->library('session');
  
  require_once 'kadmin/businessentity/tools/image.class.php';
  require_once 'kadmin/businessentity/tools/action.php';
  require_once 'kadmin/businessentity/webadminsession.php';
  
  $this->load->model('kadmin/kadmin/mainfadmininfo_model','MainFAdminInfoModel');
 }

 function index()
 {
	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
	);

	$this->load->view('kadmin/login.php', $data);
 }
 
 function verify()
 {	
	Image::buildImageVerify(4,1);
 }
 
 function doLogin()
 {	
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
	
	$status = true;
	$adm_name = trim($_REQUEST['adm_name']);
	$adm_password = trim($_REQUEST['adm_password']);
	$adm_verify = $_REQUEST['adm_verify'];
	$action = new Action();
	$dataType = '';
	if ($adm_name == '')
	{
		$status = false;
		$message = '管理员帐号不能为空';
		$action -> ajaxReturn('', $message, $status, $dataType);
	}
	
	if ($adm_password == '')
	{
		$status = false;
		$message = '管理员密码不能为空';
		$action -> ajaxReturn('',$message,$status,$dataType);
	}
	
	if ($adm_verify == '')
	{
		$status = false;
		$message = "验证码不能为空";
		$action -> ajaxReturn('',$message,$status,$dataType);
	}
	
	session_start();
 	if (md5($adm_verify) != $_SESSION['verify'])
	{
		$status = false;
		$message = '验证码输入不正确';
		$action -> ajaxReturn('',$message,$status,$dataType);
	}
	
	$loginEntriy = array(
		'adm_name' => $adm_name
		,'adm_password' => $adm_password
	);
	
	$this->load->model('kadmin/login_model','Login');
	$message = $this->Login->CheckLogin($loginEntriy);
	
	switch ($message)
	{
		case 1:
			$loginEntriy = $this->Login->GetAdminEntriy($loginEntriy);
			WebAdminSession::SetUserSessionByDBInfo($loginEntriy, $this);
	
			$message = '登录成功';
			$indexURL = site_url("kadmin/index");
			$action -> ajaxReturn($indexURL,$message,$status,$dataType);
	
			break;
		case 0:
			$message = '管理员不存在';
			$indexURL = site_url("kadmin/login");
			$action -> ajaxReturn($indexURL,$message,$status,$dataType);
			break;
		case 2:
			$message = '密码不正确';
			$indexURL = site_url("kadmin/login");
			$action -> ajaxReturn($indexURL,$message,$status,$dataType);
			break;
		case 3:
			$message = '管理员无权限';
			$indexURL = site_url("kadmin/login");
			$action -> ajaxReturn($indexURL,$message,$status,$dataType);
			break;
		case 4:
			$message = '管理员禁止登录';
			$indexURL = site_url("kadmin/login");
			$action -> ajaxReturn($indexURL,$message,$status,$dataType);
			break;
	}
	
 }
}
?>