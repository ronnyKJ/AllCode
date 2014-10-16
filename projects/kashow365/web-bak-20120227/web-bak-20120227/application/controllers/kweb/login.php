<?php
class Login extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  $this->load->library('session');
  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
	
  require_once 'application/controllers/kweb/master.php';
  require_once 'kadmin/businessentity/tools/action.php';
  require_once 'kadmin/businessentity/websession.php';
  require_once 'kadmin/businessentity/tools/string.class.php';
  
  $this->load->model('kadmin/kuser/mainfuserinfo_model','MainFUserInfoModel');
  $this->load->model('kadmin/kuser/tkuserstatistics_model','TKUserStatisticsModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoheari_model','MainFBaseInfoHearIModel');
    $this->load->model('kadmin/kainfo/mainfbaseinfo_model','MainFBaseInfoModel');
  $this->load->model('kadmin/news/mainfshop_model','MainFshopModel');
  
 }

 function index()
 {
	// 准备页面所需要的参数
 	$userId = '';
 	$loginedUserInfo = array(
 		'nickname' => ''
 		,'gradeName' => ''
 		,'kPoints' => ''
 		,'kState' => ''
 		,'kCount' => ''
 		,'kLookmeCount' => ''
 	);
 	
 	// 检查是否已登录
 	#var_dump(WebSession::IsUserLogined($this));
 	if(WebSession::IsUserLogined($this)) // 已登录
 	{
 		// 找到登录 会员信息
	 	$userId = WebSession::GetUserSessionByOne('userId', $this);
	 	#var_dump($userId);
	 	if($userId!='')
	 	{
		 	$data = $this->MainFUserInfoModel->GetEntityByIdForView($userId);
		 	if($data != null)
		 	{
		 		$loginedUserInfo['nickname'] = $data['nickname'];
		 		$loginedUserInfo['gradeName'] = $data['gradeName'];
		 		$loginedUserInfo['kPoints'] = $data['kPoints'];
		 		$loginedUserInfo['kState'] = $data['kState'];
		 	}
	 	}
	 	#var_dump($loginedUserInfo);

	 	// 找到登录 会员的统计数据
 		if($userId!='')
	 	{
	 		// 0 - 拥有卡的数量
		 	$kcount = $this->TKUserStatisticsModel->GetEntityForType($userId, '0');
		 	if($data != null)
		 	{
		 		$loginedUserInfo['kCount'] = $kcount;
		 	}
		 	
	 		// 5 - 关注我
		 	$kcount = $this->TKUserStatisticsModel->GetEntityForType($userId, '5');
		 	if($data != null)
		 	{
		 		$loginedUserInfo['kLookmeCount'] = $kcount;
		 	}
	 	}
	 	#var_dump($loginedUserInfo);
 	}

 	// 读取客户端的cookie
 	$kLoginName = '';
 	$kPWD = '1';
 	if( $this->input->cookie('cookie') != false )
 	{
	 	$cookie = $this->input->cookie('cookie');
	 	$kLoginName = $cookie['l'];
	 	$kPWD = '';
 	}
 	
 	// 准备页面数据
	$data = array(
		'title' => $this->config->item('Web_Title').' - 会员登录'
		,'userId' => $userId
		,'kLoginName' => $kLoginName
		,'kPWD' => $kPWD
		,'loginedUserInfo' => $loginedUserInfo 
		,'url' => ''
	);

	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	$this->load->view('kweb/member/login.php', $data);
	$master->footv2index();

 }
 
 function noLoginIndex()
 {
	// 准备页面所需要的参数
 	$userId = '';
 	$loginedUserInfo = array(
 		'nickname' => ''
 		,'gradeName' => ''
 		,'kPoints' => ''
 		,'kState' => ''
 		,'kCount' => ''
 		,'kLookmeCount' => ''
 	);

 	// 读取客户端的cookie
 	$kLoginName = '';
 	$kPWD = '1';
 	if( $this->input->cookie('cookie') != false )
 	{
	 	$cookie = $this->input->cookie('cookie');
	 	$kLoginName = $cookie['l'];
	 	$kPWD = '';
 	}
 	
 	// 准备页面数据
	$data = array(
		'title' => $this->config->item('Web_Title').' - 会员登录'
		,'userId' => ''
		,'kLoginName' => $kLoginName
		,'kPWD' => ''
		,'loginedUserInfo' => $loginedUserInfo 
		,'url' => isset($_REQUEST['u']) ? trim($_REQUEST['u']) : ''
	);

	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	$this->load->view('kweb/member/login.php', $data);
	$master->footv2index();
 }

 function dologin()
 {
 	 $action = new Action();
	 $dataType = '';

 	 $formdata = array(
		'kLoginName' => trim($_REQUEST['l'])
		,'kPWD' => trim($_REQUEST['p'])
		,'isRemember' => isset($_REQUEST['r']) ? trim($_REQUEST['r']) : ''
		,'url' => isset($_REQUEST['u']) ? trim($_REQUEST['u']) : ''
	 );
	 #var_dump($formdata);
	 
	 // 验证数据
	 if ($formdata['kLoginName'] == '')
	 { 
		$status = false;
		$message = '通行证帐号输入不正确，请输入';
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
	 }
	 
 	if ($formdata['kPWD'] == '')
	 { 
		$status = false;
		$message = '密码输入不正确，请输入';
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
	 }

	 // 插入会员
	 #var_dump($formdata);
	 $result = $this->MainFUserInfoModel->CheckUserLogin($formdata['kLoginName'], $formdata['kPWD']);
	 #var_dump($result);
	 if($result == 0)
	 {
	 	$status = false;
		$message = '该卡秀会员不存在，请注册后登录 ';
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
	 }
	 else if($result == -1)
	 {
	 	$status = false;
		$message = '密码输入不正确';
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
	 }
 	 else if($result == -2)
	 {
	 	$status = false;
		$message = '帐号已锁定不能登录';
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
	 }
	 
 	 // 取出登录会员的编号
	 $userId = $result;
	 #var_dump($result);

	 $date = $this->MainFUserInfoModel->GetEntityById($userId);
	 WebSession::SetUserSessionByDBInfo($date, $this);
 	 
 	 // 置会员登录成功Cookie
 	 if($formdata['isRemember'] == '1')
 	 {
 	 	$cookie = array(
                   'name'   => 'cookie[l]',
                   'value'  => $date['kLoginName'],
                   'expire' => '86500',
                   'domain' => $this->config->item('cookie_domain'),
                   'path'   => $this->config->item('cookie_path'),
                   'prefix' =>  $this->config->item('cookie_prefix'),
               );
		 $this->input->set_cookie($cookie); 
 	 }

 	$status = true;
	$message = '登录成功 ';
	$url = $formdata['url'] == '' ? site_url('index') : $formdata['url'];
	$action -> ajaxReturn($url,$message,$status,$dataType);
	return;
	

 }
 
}
?>