<?php
class Register extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  $this->load->library('encrypt');
  $this->load->library('session');
      
  require_once 'application/controllers/kweb/master.php';
  require_once 'kadmin/businessentity/tools/image.class.php';
  require_once 'kadmin/businessentity/tools/action.php';
  require_once 'kadmin/businessentity/tools/encrypt.class.php';
  require_once 'kadmin/businessentity/tools/string.class.php';
  require_once 'kadmin/businessentity/websession.php';
  require_once 'login.php';
  
  $this->load->model('kadmin/kuser/mainfuserinfo_model','MainFUserInfoModel');
  $this->load->model('kadmin/kuser/mainfusergrade_model','MainFUserGradeModel');
  $this->load->model('kadmin/news/mainfshop_model','MainFshopModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoheari_model','MainFBaseInfoHearIModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfo_model','MainFBaseInfoModel');
 }

 function index()
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 注册卡秀会员 '
	);
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/member/register.php', $data);
	
	$master->footv2index();
 }
  
 function succeed1()
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 注册卡秀会员 '
	);
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/member/succeed1.php', $data);
	
	$master->footv2index();
 }
 
 function succeed2()
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 注册卡秀会员 '
	);
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/member/succeed2.php', $data);
	
	$master->footv2index();
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
 
 function verify()
 {	
	Image::buildImageVerify(4,2,'gif',70,25,'webverify');
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
	if($result == 0)
	{
		$result = 1;
	}else{
		$result = 0;
	}

	$this->output->set_output($result);
	return;
 }
 
 function doreg()
 {
 	$action = new Action();
	$dataType = '';

 	$formdata = array(
		'kLoginName' => trim($_REQUEST['l'])
		,'kPWD' => md5(trim($_REQUEST['p']))
		,'kMail' => trim($_REQUEST['e'])
		,'kTel' => trim($_REQUEST['t'])
		,'reUserLoginName' => trim($_REQUEST['r'])
		,'verifyEncode' => String::rand_string(18)
	 );
	 $dataType = trim($_REQUEST['dataType']);
	 
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
	 
	 // 插入会员
	 #var_dump($formdata);
	 $result = $this->MainFUserInfoModel->DoProAddUserInfo($formdata);
	 #var_dump($result);
	 if($result == '0')
	 {
	 	$status = false;
		$message = '卡秀网站会员注册暂时遇到了问题，请稍后再试。谢谢！';
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
	 }
	 #var_dump($result);

	 // 发送验证邮件
	 $userId = $result;
	 $this->_sendmail($formdata['kMail']
					 , $formdata['kLoginName']
					 , $userId
					 , EncryptTranslte::encode($formdata['verifyEncode'], $this)
	 );

	 // 置会员登录成功Session
	 $data = WebSession::GetSessionDate();
 	 $data['userid'] = $userId;
 	 $data['nickname'] = $formdata['kLoginName'];
 	 $data['logined'] = false;
 	 WebSession::SetUserSession($data, $this);
 	
	 // 跳转置成功页面
	 $status = true;
	 $message = '';
	 $url = site_url('register/succeed2');
	 $action -> ajaxReturn($url,$message,$status,$dataType);
 }
 
 function _sendmail($to,$loginName,$userId,$encode)
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
	
		$verifyAddress 	  = site_url('register/doVerify?id='.$userId.'&v='.$encode);
		$body             = file_get_contents(base_url().'kweb/contents.html');
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
		'userId' => trim($_REQUEST['id'])
		,'verifyEncode' => trim($_GET['v'])
	);
	#var_dump($formdata);
	if($formdata['userId'] == null || $formdata['verifyEncode'] == '')
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
		$result = $this->MainFUserInfoModel->DoVerifyUserInfo($formdata);
		if($result == '0')
		{
			$this->error('卡秀网站会员验证失败：您的验证字串不正确或已失效。谢谢！');
			return;
		}
		
		// 置会员登录成功Session
		$userInfodata = $this->MainFUserInfoModel->GetEntityById($formdata['userId']);
		WebSession::SetUserSessionByDBInfo($userInfodata, $this);
		
		// 跳转置成功页面
		$this->succeed1();
	
	}catch (Exception $e) {
		$this->error('卡秀网站会员验证失败：您的验证字串不正确。谢谢！');
		return;
	}
 }
 
 ////////////////////////////////////////////////////////////
 ////////////////////////////////////////////////////////////
 //
 //	Test
 //
 ////////////////////////////////////////////////////////////
 function test()
 {
  	parse_str($_SERVER['QUERY_STRING'],$_GET);
	$formdata = array(
		'userId' => trim($_REQUEST['id'])
		,'verifyEncode' => trim($_REQUEST['v'])
	);
	var_dump($formdata);
	$verifyEncode = EncryptTranslte::decode($formdata['verifyEncode'], $this);
	var_dump($verifyEncode);
 }
 
 function testfile()
 {
	$body = file_get_contents(base_url().'kweb/contents.html');
	$body             = preg_replace('/\\%userName\\%/','pct', $body); //Strip backslashes
	$body             = preg_replace('/\\%VerifyAddress\\%/','pcturl', $body); //Strip backslashes
	 
	var_dump($body);

 }
 
 function testCode()
 {
 	for($i=0;$i<=20;$i++)
 	{
		$randval = String::rand_string(18);
		var_dump($randval);
		$encode = EncryptTranslte::encode($randval,$this);
		var_dump($encode);
		$decode = EncryptTranslte::decode($encode,$this);
		var_dump($decode);
 	}
 }
 
 function testsession()
 {
	session_start();
	
 	var_dump(WebSession::IsUserLogined($this));
 	var_dump(WebSession::GetUserSessionByOne('userId', $this));
 	#var_dump($this->session->userdata('userid'));
 /*
 	$data = WebSession::GetSessionDate();
 	$data['userid'] = '1';
 	$data['nickname'] = 'pct';
 	$data['logined'] = true;
 	WebSession::SetUserSession($data, $this);
 	
 	var_dump(WebSession::IsUserLogined($this));
 	
 	$data1 = WebSession::GetUserSession($this);
 	#var_dump($data1);
 	
 	#WebSession::UnsetSession($this);

 	
 	
 	#$session_id = $this->session->userdata('session_id');
 	#var_dump($session_id);
*/
 }
 
 function testSetsession()
 {
	session_start();
	$this->session->set_userdata('userId', '4');
	var_dump($this->session->userdata('userId'));
 }
 
 function testSetCookie()
 {
  	 // 置会员登录成功Cookie
	$this->input->cookie();
 	
 	 $cookie = array(
                   'name'   => 'cookie[l]',
                   'value'  => 'pct',
                   'expire' => '86500',
                   'domain' => $this->config->item('cookie_domain'),
                   'path'   => $this->config->item('cookie_path'),
                   'prefix' =>  $this->config->item('cookie_prefix'),
               );
	 $this->input->set_cookie($cookie); 
	 setcookie('cookie[l]','pct', time()+3600, '/', '', 0);
	 setcookie('cookie[p]','123456', time()+3600);

 }
 
 function testGetCookie()
 {
 	$this->input->cookie();
  	#var_dump($_COOKIE['cookie']);
 	$kLoginName = '';
 	if( $this->input->cookie('cookie') )
 	{
	 	$kLoginName = $this->input->cookie('cookie');
	 	var_dump($kLoginName['l']);
 	}
 }
}
?>