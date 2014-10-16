<?php
class Top extends CI_Controller {

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
	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
		,'purviewCodes'	=> $this->GetLoginPurviewCodes()
	);

	$this->load->view('kadmin/top.php', $data);
 }
 
 function GetLoginPurviewCodes()
 {
 	$purviewCodes = array();
 	
  	// 获取session中的会员ID
 	$purviewCodes = WebAdminSession::GetSessionPurviewCode($this);
 	
 	return $purviewCodes;
 }
}
?>