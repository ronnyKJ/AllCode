<?php
class MenuFrame extends CI_Controller {

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
		,'t' 			=> ''
	);

	$this->load->view('kadmin/menuframe.php', $data);
 }
 
 function indexn($t=1)
 {
	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
 		,'purviewCodes'	=> $this->GetLoginPurviewCodes()
		,'t' => $t
	);

	$this->load->view('kadmin/menuframe.php', $data);
 }
 
 function GetLoginPurviewCodes()
 {
 	$purviewCodes = array();
 	
  	// 获取session中的会员ID
 	$purviewCodes = WebAdminSession::GetSessionPurviewCode($this);
  	
 	return $purviewCodes;
 }
}

	/*
 	$purviewCodes = array(
	    'mainfuserinfo'
 		,'mainfusergrade'
 		,'mainfuseropertype'
 		,'mainfuserpointschanges'
 		,'mainfadmininfo'
 		,'mainfusermessages'
 		,'mainfblogmessages'
 		,'mainfcardmessages'
 		,'mainfannount'		
 		,'mainfshop'
 		,'mainfshopnews'
 		,'mainfshopnews2'
 		,'mainfshopnews3'
 		,'mainfcardforexchange'
 		,'mainfcardforexchange'
 		,'IndexFlashTop2'
 		,'AdSaleAd'
 		,'AdSpellAd'
 		,'AdGiftAd'
 		,'AdActivityAd'
 		,'AdDiscountAd'
 		,'AdConversionAd'
  	);
  	*/
  	
?>

