<?php
class ChangePwd extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  $this->load->library('session');
  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->library('image_lib');
  $this->load->library('encrypt');
	
  require_once 'application/controllers/kweb/master.php';
  require_once 'kadmin/businessentity/websession.php';
  require_once 'kadmin/businessentity/tools/action.php';
  require_once 'kadmin/businessentity/tools/page.class.php';
  require_once 'kadmin/businessentity/tools.php';
  require_once 'login.php';
  require_once 'register.php';
  require_once 'kadmin/businessentity/tools/string.class.php';
  require_once 'kadmin/businessentity/tools/image.class.php';
  require_once 'kadmin/businessentity/tools/encrypt.class.php';
  
  $this->load->model('kadmin/kuser/mainfuserinfo_model',		'MainFUserInfoModel');
  $this->load->model('kadmin/kuser/tkuserstatistics_model',		'TKUserStatisticsModel');
  $this->load->model('kadmin/message/mainfusermessages_model',	'MainFUserMessagesModel');
  $this->load->model('kadmin/kuser/tkuserstatistics_model',		'TKUserStatisticsModel');
  $this->load->model('kadmin/kuser/tkuserfriends_model',		'TKUserFriendsModel');
  $this->load->model('kadmin/kuser/TKUsernews_model',			'TKUsernewsModel');
  $this->load->model('kadmin/kcard/mainfcardindex_model',		'MainFCardIndexModel');
  $this->load->model('kadmin/news/mainfshop_model','MainFshopModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoheari_model','MainFBaseInfoHearIModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfo_model','MainFBaseInfoModel');
  $this->load->model('kadmin/kuser/mainfuserchangepwd_model','MainFUserChangePwdModel');
  
  
 }

 function index()
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 忘记密码修改'
	);
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/member/changepwd.php', $data);
	
	$master->footv2index();

 }
 
    
 //////////////////////////////////////////////////////////////
 // 验证用户名是否可用
 // 返回$result: 1 - 成功; 0 - 用户已存在
 function checkloginname()
 {
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
	$kMail = trim($_REQUEST['e']);
	
	if($kMail == '')
	{
		return 0;
	}
	$result = $this->MainFUserInfoModel->GetEntityCount(array('kMail' => $kMail));
	

	$this->output->set_output($result);
	return;
 }

 function domail()
 {
 	$action = new Action();
	$dataType = '';

 	$formdata = array(
		'kMail' 		=> trim($_REQUEST['e'])
		,'verifyEncode' => String::rand_string(18)
		,'userId'		=> null
		,'state'		=> 1
	 );
	 
	 #var_dump($formdata);
	 
	 // 验证验证码
	 $verify = trim($_REQUEST['v']);
	 session_start();
	 if (md5(strtolower($verify)) != $_SESSION['webverify'])
	 { 
		$status = false;
		$message = '验证码输入不正确'.md5(strtolower($verify)).'-'.$_SESSION['webverify'];
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
	 }
	 

	 // 获取会员信息
	 $entity = $this->MainFUserInfoModel->GetUserByMail($formdata['kMail']);
	 if($entity!=null &&$entity!=0)
	 {
	 	$formdata['userId'] = $entity['id'];
	 }

	 
	 // 插入会员忘记密码
	 #var_dump($formdata);
	 $userChangePwdId = $this->MainFUserChangePwdModel->insert($formdata);
	 #var_dump($result);
	 if($userChangePwdId == '0')
	 {
	 	$status = false;
		$message = '卡秀网站会员注册暂时遇到了问题，请稍后再试。谢谢！';
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
	 }
	 #var_dump($result);
	
	 // 发送验证邮件
	 $this->_sendmail($formdata['kMail']
					 , $entity['kLoginName']
					 , $userChangePwdId
					 , EncryptTranslte::encode($formdata['verifyEncode'], $this)
	 );
		 

	 // 跳转置成功页面
	 $status = true;
	 $message = '';
	 $url = site_url('changepwd/succeed3');
	 $action -> ajaxReturn($url,$message,$status,$dataType);

 }

 function succeed3()
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 忘记密码修改'
	);
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/member/succeed3.php', $data);
	
	$master->footv2index();
 }

 function succeed4()
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 忘记密码修改'
	);
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/member/succeed4.php', $data);
	
	$master->footv2index();
 }

 function _sendmail($to,$loginName,$userChangePwdId,$encode)
 {
	try {
		require_once 'kadmin/businessentity/tools/class.phpmailer.php';
		$mail = new PHPMailer(true); //New instance, with exceptions enabled
		
		$mail->IsSMTP();                           // tell the class to use SMTP
		$mail->SMTPAuth   = true;
		$mail->Port       = $this->config->item('smtp_port');
		$mail->Host       = $this->config->item('smtp_host');
		$mail->Username   = $this->config->item('smtp_user');
		$mail->Password   = $this->config->item('smtp_pass');
			
		
		
		//$mail->IsSendmail();  // tell the class to use Sendmail
		$mail->From       = $this->config->item('mailfrom');;
		$mail->FromName   = "卡秀网";
		$mail->AddAddress($to);
		$mail->CharSet = "utf-8";
		$mail->Encoding = "base64"; 
	
		$mail->Subject  = "欢迎注册卡秀网，这封是您的验证邮件";
		$mail->WordWrap   = 80; // set word wrap
	
		$verifyAddress 	  = site_url('changepwd/doVerify?id='.$userChangePwdId.'&v='.$encode);
		$body             = file_get_contents(base_url().'kweb/contents1.html');
		$body             = preg_replace('/\\%userName\\%/',$loginName, $body); //Strip backslashes
		$body             = preg_replace('/\\%VerifyAddress\\%/',$verifyAddress, $body); //Strip backslashes
		
		$mail->MsgHTML($body);
		$mail->IsHTML(true); // send as HTML
		
		$mail->Send();

	} catch (phpmailerException $e) {
		$this->output->set_output($e->errorMessage());
	}
 }
 
 function doVerify()
 {	
  	parse_str($_SERVER['QUERY_STRING'],$_GET);
	$formdata = array(
		'userChangePwdId' => trim($_REQUEST['id'])
		,'verifyEncode' => trim($_GET['v'])
	);
	#var_dump($formdata);

	if($formdata['userChangePwdId'] == null || $formdata['verifyEncode'] == '')
	{
		$this->error('卡秀网站会员验证失败：您的验证地址不正确。谢谢！');
		return;
	}

	try {
		// 解密验证字串
		$verifyEncode='';
		$verifyEncode = EncryptTranslte::decode($formdata['verifyEncode'], $this);
		$formdata['verifyEncode'] = $verifyEncode;
		#var_dump($verifyEncode);
			
	  	// 验证字串是否合法,执行验证通过后数据更新
		$result = $this->MainFUserChangePwdModel->DoVerifyUserInfo($formdata);
		if($result == '0')
		{
			$this->error('卡秀网站会员验证失败：您的验证字串不正确或已失效。谢谢！');
			return;
		}
				
		// 跳转置修改密码页面
		$this->__dochangepwd($result['userId'], $formdata['userChangePwdId']);
	
	}catch (Exception $e) {
		$this->error('卡秀网站会员验证失败：您的验证字串不正确。谢谢！');
		return;
	}

 }

 function __dochangepwd($userId, $userChangePwdId)
 {
	$data = array(
		'title' 			=> $this->config->item('Web_Title').' - 修改卡秀会员 密码'
		,'userId' 			=> $userId
		,'userChangePwdId'	=> $userChangePwdId
	);
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/member/dochangepwd.php', $data);
	
	$master->footv2index();
 }
 
  

 function dochange()
 {
 	$action = new Action();
	$dataType = '';
	
 	$formdata = array(
		'kPWD' => md5(trim($_REQUEST['p']))
 		,'id' => trim($_REQUEST['uid'])
	 );
	 #var_dump($formdata);

	 // 验证验证码
	 $verify = trim($_REQUEST['v']);
	 session_start();
	 if (md5(strtolower($verify)) != $_SESSION['webverify'])
	 { 
		$status = false;
		$message = '验证码输入不正确'.md5(strtolower($verify)).'-'.$_SESSION['webverify'];
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
	 }
 
 	try {	
		 // 修改会员的密码
		 #var_dump($formdata);
		 $this->MainFUserInfoModel->Update($formdata);
		 
		  // 为修改密码成功发送邮件
		  // DB-获取会员信息 
		  $userInfoData = $this->MainFUserInfoModel->GetEntityByIdForView($formdata['id']);
		  if($userInfoData != null)	// 找到当前会员的头像文件名
		  {
			 $this->_sendOKMail($userInfoData['kMail']
							 , $userInfoData['kLoginName'] 
			 );
		  }

		// 取消密码修改的验证串有效性		 
		$userChangeFormdata = array(
			'state' 			=> '2' //2. - 验证
		 	,'verifyDateTime'	=> date('Y-m-d H:i:s') 
		 	,'kPWD' 			=> md5(trim($_REQUEST['p']))
	 		,'id' 				=> trim($_REQUEST['cid'])
		);
		$result = $this->MainFUserChangePwdModel->Update($userChangeFormdata);
		 
	 	
		// 跳转置成功页面
		$status = true;
		$message = '';
		$url = site_url('changepwd/succeed4');
		$action -> ajaxReturn($url,$message,$status,$dataType);
	 		
	
	}catch (Exception $e) {
		$status = false;
		$message = '密码修改异常';
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
	}
	
 }
 
function _sendOKMail($to,$loginName)
 {
	try {
		require_once 'kadmin/businessentity/tools/class.phpmailer.php';
		$mail = new PHPMailer(true); //New instance, with exceptions enabled
		
		$mail->IsSMTP();                           // tell the class to use SMTP
		$mail->SMTPAuth   = true;
		$mail->Port       = $this->config->item('smtp_port');
		$mail->Host       = $this->config->item('smtp_host');
		$mail->Username   = $this->config->item('smtp_user');
		$mail->Password   = $this->config->item('smtp_pass');
			
		
		//$mail->IsSendmail();  // tell the class to use Sendmail
		$mail->From       = $this->config->item('mailfrom');;
		$mail->FromName   = "卡秀网";
		$mail->AddAddress($to);
		$mail->CharSet = "utf-8";
		$mail->Encoding = "base64"; 
	
		$mail->Subject  = "欢迎来到卡秀网，您的密码修改成功";
		$mail->WordWrap   = 80; // set word wrap
	
		$body             = file_get_contents(base_url().'kweb/contents2.html');
		$body             = preg_replace('/\\%userName\\%/',$loginName, $body); //Strip backslashes
		$body             = preg_replace('/\\%kashowurl\\%/',$this->config->item('base_url'), $body); //Strip backslashes


		$mail->MsgHTML($body);
		$mail->IsHTML(true); // send as HTML
		
		$mail->Send();

	} catch (phpmailerException $e) {
		$this->output->set_output($e->errorMessage());
	}
 }

 function error($Msg,$gotoUrl='')
 {
	$this->_PublicError($this, $Msg, $gotoUrl);
 }
 
 function _PublicError($CI, $Msg,$gotoUrl='')
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 卡秀提示 '
		,'msg' => $Msg
		,'url' => $gotoUrl == '' ? site_url('index') : $gotoUrl
	);
	
	#var_dump($data);
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($CI);
	
	$this->load->view('kweb/member/error.php', $data);
	
	$master->footv2index();
 }
 
}