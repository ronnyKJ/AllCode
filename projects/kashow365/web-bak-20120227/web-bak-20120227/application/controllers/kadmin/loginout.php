<?php
class LoginOut extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  $this->load->library('session');
  
  require_once 'kadmin/businessentity/webadminsession.php';
  
  $this->load->model('kadmin/kadmin/mainfadmininfo_model','MainFAdminInfoModel');
 }

 function index()
 {
 	// 删除session
	WebAdminSession::SetUserSessionByOne('adminId', '', $this);
	
	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
	);

	$this->load->view('kadmin/login.php', $data);
 }

}
?>