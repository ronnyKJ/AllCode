<?php
class Master extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  $this->load->library('session');
  
  require_once 'kadmin/businessentity/websession.php';
  require_once 'kadmin/businessentity/tools/page.class.php';
  require_once 'kadmin/businessentity/tools/string.class.php';
  
  $this->load->model('kadmin/kuser/mainfuserinfo_model','MainFUserInfoModel');
  $this->load->model('kadmin/kuser/tkuserfriends_model','TKUserFriendsModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoheari_model','MainFBaseInfoHearIModel');
  $this->load->model('kadmin/news/mainfshop_model','MainFshopModel');
 }

 function headindex()
 {
	$data = array(
		'title' => $this->config->item('Web_Title')
	);

	$this->load->view('kweb/common/head.php', $data);
 }
 
 function topindex($CI, $currentTitle='index')
 {
	// 检查是否已登录
 	$userId = '';
 	$loginedUserInfo = array(
 		'nickname' =>''
 		,'gradeName' =>''
 		,'kPoints' =>''
 		,'kState' =>''
 	);
 	if(WebSession::IsUserLogined($CI)) // 已登录
 	{
 		// 找到登录 会员信息
	 	$userId = WebSession::GetUserSessionByOne('userId', $CI);
	 	#var_dump($userId);
	 	if($userId!='')
	 	{
		 	$data = $CI->MainFUserInfoModel->GetEntityByIdForView($userId);
		 	if($data != null)
		 	{
		 		$loginedUserInfo['nickname'] = $data['nickname'];
		 		$loginedUserInfo['gradeName'] = $data['gradeName'];
		 		$loginedUserInfo['kPoints'] = $data['kPoints'];
		 		$loginedUserInfo['kState'] = $data['kState'];
		 	}
	 	}
	 	#var_dump($loginedUserInfo);
 	}
 	
	$data = array(
		'title' => $this->config->item('Web_Title')
		,'userId' => $userId
		,'loginedUserInfo' => $loginedUserInfo
		,'currentTitle' => $currentTitle
	);
	
	$this->load->view('kweb/common/top.php', $data);
 }
 
 function footindex()
 {
	$data = array(
		'title' => $this->config->item('Web_Title')
	);

	$this->load->view('kweb/common/foot.php', $data);
 }
 
 ////////////////////////////////////////////////////
 // UserControls - popMaskLogin.php
 function popMaskInit($CI)
 {
	// 检查是否已登录
 	$data = array(
 		'loginUserId' 	=> ''
 		,'kLoginName' 	=> ''
 		,'kPWD' 		=> '1'
 	);
 	
 
 	// 获取登录会员信息
 	if(WebSession::IsUserLogined($CI)) // 已登录
 	{
 		// 找到登录会员信息
	 	$loginUserId = WebSession::GetUserSessionByOne('userId', $CI);
	 	$data['loginUserId'] = $loginUserId;
	 	#var_dump($loginUserId);
 	}
  	
  	// 读取客户端的cookie
 	if( $this->input->cookie('cookie') != false )
 	{
	 	$cookie = $this->input->cookie('cookie');
	 	$data['kLoginName'] = $cookie['l'];
	 	$data['kPWD'] = '';
 	}

	$this->load->view('kweb/common/popMaskLogin.php', $data);

 }
 
 //////////////////////////////////////////////////////
 // UserControls - popMaskUserMsg.php
 function popMaskUserMsg($CI, $toUserId)
 {
 	$data = array(
 		'loginUserId' 	=> ''
 		,'toUserId' 	=> $toUserId
 	);
 	
	$this->load->view('kweb/common/popMaskUserMsg.php', $data);
 }
 
 ////////////////////////////////////////////////////
 // UserControls - popMaskUserMsg.php
 function popMaskBlogMsg($CI)
 {
 	$data = array(
 		'loginUserId' 	=> ''
 	);
 	
	$this->load->view('kweb/common/popMaskBlogMsg.php', $data);
 }
 
 ////////////////////////////////////////////////////
 // UserControls - popMaskStartSpell.php
 function popMaskStartSpell($CI)
 {
 	$data = array(
 		'loginUserId' 	=> ''
 		,'nickname'		=> '' 
 	);
 	
  	// 获取登录会员信息
 	if(WebSession::IsUserLogined($CI)) // 已登录
 	{
 		// 找到登录会员信息
	 	$loginUserId = WebSession::GetUserSessionByOne('userId', $CI);
	 	if($loginUserId != '')
	 	{
 			$loginedUserInfo = $CI->MainFUserInfoModel->GetEntityByIdForView($loginUserId);
		 	if($loginedUserInfo != null)
		 	{
		 		$data['nickname'] = $loginedUserInfo['nickname'];
		 	}
	 	}
 	}
 	

 	
	$this->load->view('kweb/common/popMaskStartSpell.php', $data);
 }
 
 
 ////////////////////////////////////////////////////
 // UserControls - popMaskStartSpell.php
 function popMaskFriends($CI)
 {
 	$data = array(
 		'friendsData'	=> null
 		,'total'		=> 0
 		,'perpage'		=> 0
 	);
 	
  	// 获取登录会员信息
 	if(WebSession::IsUserLogined($CI)) // 已登录
 	{
 		// 找到登录会员信息
	 	$loginUserId = WebSession::GetUserSessionByOne('userId', $CI);
	 	if($loginUserId != '')
	 	{
	 		
		 	/////////////////////////////////////////////////////
			// 全部好友，按分页来
	 		$where = array(
	 			'userId' => $loginUserId
	 		);
	 		$orderby = 'addDateTime desc';
			$totalRowsCount = $this->TKUserFriendsModel->GetEntityCount($where);
			// select db
			$perpage = '20';
		 	$friendsData = $this->TKUserFriendsModel->GetEntityByPage($where, $orderby, $perpage, 1);
		   	if($friendsData != null)
		 	{
			 	for($i=0,$count=count($friendsData); $i<$count; $i++)
			 	{
	 				$friendsData[$i]['kAvatarImage'] = $friendsData[$i]['kAvatarImage'] != '' 
				 		? $this->config->item('UpPathAvatar').'s1/'.$friendsData[$i]['kAvatarImage'] 
						: base_url().'kweb/images/kapic12.jpg';
			 	}
		 	}
		 	$data['friendsData'] 	= $friendsData;
		 	$data['total'] 			= $totalRowsCount;
		 	$data['perpage']		= $perpage;
	 	}
 	}
 	#var_dump($data);
 	
	$this->load->view('kweb/common/popMaskFriends.php', $data);

 }
 
  ////////////////////////////////////////////////////
 // UserControls - popMaskStartSpell.php
 function popMaskManageSpell($CI)
 {
 	$data = array(
 		'cardData'	=> null
 		,'total'		=> 0
 		,'perpage'		=> 0
 	);
 	
 	// 获取登录会员信息
 	if(WebSession::IsUserLogined($CI)) // 已登录
 	{
 		// 找到登录会员信息
	 	$loginUserId = WebSession::GetUserSessionByOne('userId', $CI);
	 	if($loginUserId != '')
	 	{
		 	/////////////////////////////////////////////////////
			// 读取活动卡
			$where = array(
				'userId' 		=> $loginUserId
				,'cardSetType'	=> '3'
			);
			$orderby = 'addDateTime desc';
			$totalRowsCount = $CI->MainFCardIndexModel->GetEntityCountForActivity($where);
			// select db
			$perpage = '1';
		 	$cardData = $CI->MainFCardIndexModel->GetEntityByPageForActivity($where, $orderby, $perpage, 1);
		   	if($cardData != null)
		 	{
			 	for($i=0,$count=count($cardData); $i<$count; $i++)
			 	{
			 		$cardData[$i]['cardImagePath'] = $cardData[$i]['cardImagePath'] != '' 
					 		? $CI->config->item('UpPathCard').'s1/'.$cardData[$i]['cardImagePath'] 
							: base_url().'kweb/images/kapic2.jpg';
					$cardData[$i]['startDate'] = $cardData[$i]['startDate'] != '' 
					 		? date('Y年m月d日', strtotime($cardData[$i]['startDate'])) 
							: '';
					$cardData[$i]['endDate'] = $cardData[$i]['endDate'] != '' 
					 		? date('Y年m月d日', strtotime($cardData[$i]['endDate'])) 
							: '';
			 	}
			 	$data['cardData'] 	= $cardData;
			 	$data['total'] 		= $totalRowsCount;
			 	$data['perpage']	= $perpage;
		 	}
	 	}
 	}
	#var_dump($data);
 	
	$this->load->view('kweb/common/popMaskManageSpell.php', $data);
 }
 
 function popMaskExchange($CI,$cid, $exchangPoint)
 {
 	$data = array(
 		'cid'			=> $cid
 		,'exchangPoint'	=> $exchangPoint
 	);
 	 	
	$this->load->view('kweb/common/popMaskExchange.php', $data);
 }
 
 function popMaskServices($CI)
 {
 	$data = array(
 		
 	);
 	 	
	$this->load->view('kweb/common/popMaskServices.php', $data);
 }
 
 
 
 ############################################################################
 # 新首页-20110919
 ############################################################################
 
 function headv2index($title='')
 {
 	#var_dump($title);
 	$title= $title == '' ? $this->config->item('Web_Title') : $title;
 	
	$data = array(
		'title' => $title
	);

	$this->load->view('kweb/common/headv2.php', $data);
 }
 

 function topv2index($CI, $currentTitle='index')
 {
	// 检查是否已登录
 	$userId = '';
 	$loginedUserInfo = array(
 		'nickname' =>''
 		,'gradeName' =>''
 		,'kPoints' =>''
 		,'kState' =>''
 	);
 	if(WebSession::IsUserLogined($CI)) // 已登录
 	{
 		// 找到登录 会员信息
	 	$userId = WebSession::GetUserSessionByOne('userId', $CI);
	 	#var_dump($userId);
	 	if($userId!='')
	 	{
		 	$data = $CI->MainFUserInfoModel->GetEntityByIdForView($userId);
		 	if($data != null)
		 	{
		 		$loginedUserInfo['nickname'] = $data['nickname'];
		 		$loginedUserInfo['gradeName'] = $data['gradeName'];
		 		$loginedUserInfo['kPoints'] = $data['kPoints'];
		 		$loginedUserInfo['kState'] = $data['kState'];
		 	}
	 	}
	 	#var_dump($loginedUserInfo);
 	}
 	
 	 	
 	/////////////////////////////////////////////////////
	// 听说
	$where = array(
		'infoType' 	=> 'HearInfoIndex'
	);
	$orderby = 'orderNum desc';
 	$heari = $CI->MainFBaseInfoHearIModel->GetEntityAll($where, $orderby);
 	
 	// 读取网站统计信息
 	    #WebTotcalCZ - 储值卡数
		#WebTotcalJF - 积分卡数
		#WebTotcalHY - 会员卡数
		#WebTotcalTY - 体验卡数
		#WebTotcalTH - 提货卡数
		#WebTotcalUser - 网站会员数
	$webStatistics = $CI->MainFBaseInfoModel->GetWebStatistics();
 	
 	/////////////////////////////
 	// 北京商场推荐
	// select db
	$orderby = 'reActivityOrderNum desc';
 	$shopData = $CI->MainFshopModel->GetEntityByPage('', $orderby, 5, 1);
	 		
	$data = array(
		'title' 			=> $this->config->item('Web_Title')
		,'userId' 			=> $userId
		,'loginedUserInfo' 	=> $loginedUserInfo
		,'currentTitle' 	=> $currentTitle
		,'heari'			=> $heari
		,'webStatistics'	=> $webStatistics
		,'shopData'			=> $shopData
	);
	
	
	$this->load->view('kweb/common/topv2.php', $data);
 }
 
 function footv2index()
 {
	$data = array(
		'title' => $this->config->item('Web_Title')
	);

	$this->load->view('kweb/common/footv2.php', $data);
 }
 
 
 
 
 
 
}
?>