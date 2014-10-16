<?php
class Member extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  $this->load->library('session');
  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->library('image_lib');
	
  require_once 'application/controllers/kweb/master.php';
  require_once 'kadmin/businessentity/websession.php';
  require_once 'kadmin/businessentity/tools/action.php';
  require_once 'kadmin/businessentity/tools/page.class.php';
  require_once 'kadmin/businessentity/tools.php';
  require_once 'login.php';
  require_once 'register.php';
  require_once 'kadmin/businessentity/tools/string.class.php';
  
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

 }

 
 function index()
 {
 	// 检查是否已登录
 	#var_dump(WebSession::IsUserLogined($this));
 	if(!WebSession::IsUserLogined($this)) // 未登录
 	{
 		// 进入登录页
 		#echo $this->_jsGOTOLogin(current_url());
 		$this->output->set_output($this->_jsGOTOLogin(current_url()));
 		return;
 	}
 	
 	// 初始化
 	$data = array(
		'title' => $this->config->item('Web_Title').' - 会员主页  '
 		, 'userId' 				=> ''
 		, 'userInfoData' 		=> null
		, 'UserStatistics0' => '0'
		, 'UserStatistics1' => '0'
		, 'UserStatistics2' => '0'
		, 'UserStatistics3' => '0'
		, 'UserStatistics4' => '0'
		, 'UserStatistics5' => '0'
		, 'UserStatistics6' => '0'
		, 'UserStatistics7' => '0'
		, 'UserStatistics8' => '0'
		, 'userStatisticsData' 	=> null
		, 'userMessageData' 	=> null
		, 'userFriendsData' 	=> null
		, 'perpage' 			=> 0
		, 'total' 				=> 0
		, 'cardDataForSale' 	=> null
		, 'perpageForSale' 		=> 0
		, 'totalForSale'	 	=> 0
		, 'cardDataForShow' 	=> null
		, 'perpageForShow' 		=> 0
		, 'totalForShow' 		=> 0
		
	);


 	// 获取session中的会员ID
 	$userId = WebSession::GetUserSessionByOne('userId', $this);
 	$data['userId'] = $userId;
 	#var_dump($userId);
 	if($userId=='')
 	{
 		// 进入登录页
 		#echo $this->_jsGOTOLogin(current_url());
 		$this->output->set_output($this->_jsGOTOLogin(current_url()));
 		return;
 	}
 	
 	// DB-获取会员信息 
 	$userInfoData = $this->MainFUserInfoModel->GetEntityByIdForView($userId);
 	if($userInfoData != null)	// 找到当前会员的头像文件名
 	{
 		$userInfoData['kAvatarImage'] = $userInfoData['kAvatarImage'] != '' 
								? $this->config->item('UpPathAvatar').'b/'.$userInfoData['kAvatarImage'] 
								: base_url().'kweb/images/kapic11.jpg';
 		$userInfoData['loginDateTime'] = $userInfoData['loginDateTime'] != '' 
						 		? date("Y-m-d h:i", strtotime($userInfoData['loginDateTime']))
						 		: '';
 	}
 	$data['userInfoData'] = $userInfoData;
	#var_dump($userInfoData);
 	
  	// DB - 会员数据统计
	//   统计名称类别
	// 0 - 拥有卡的数量
	// 1 - 拥有卡的种类
	// 2 - 交易记录数
	// 3 - 拼卡发起记录
	// 4 - 兑换记录
	// 5 - 关注我
	// 6 - 我关注
	// 7 - 拼卡活动正在进行数
	// 8 - 拼卡活动报名人数
 	$userStatisticsData = $this->TKUserStatisticsModel->GetEntityAll(array('userId' => $userId));
 	if($userStatisticsData != null)
 	{
 		foreach ($userStatisticsData as $row)
 		{
 			switch ($row['statisticType'])
 			{
	 			case '0':
	 				$data['UserStatistics0'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
	 			case '1':
	 				$data['UserStatistics1'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
	 			case '2':
	 				$data['UserStatistics2'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
	 			case '3':
	 				$data['UserStatistics3'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
	 			case '4':
	 				$data['UserStatistics4'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
	 			case '5':
	 				$data['UserStatistics5'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
	 			case '6':
	 				$data['UserStatistics6'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
	 			case '7':
	 				$data['UserStatistics7'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
				case '8':
	 				$data['UserStatistics8'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
 			}
 		}
 	}
 	
 	// DB - 会员站内消息 分页信息
    $where = array(
    	'toUserId' => $userId
    	, 'state' => '1'
    );
    $order = 'addDateTime DESC';
 	$totalRowsCount = $this->MainFUserMessagesModel->GetEntityCount($where);
 	$data['total'] = $totalRowsCount;
 	$data['perpage'] = 10;
 	
 	// DB - 会员站内消息
  	$userMessageData = $this->MainFUserMessagesModel->GetEntityByPagetoUserId($userId, $data['perpage'], 1);
  	$data['userMessageData'] = $userMessageData;
  	#var_dump($data['userMessageData']);
  	  	
  	// DB - 关注我的人
  	#var_dump($userId);
  	$userFriendsData = $this->TKUserFriendsModel->GetEntityByPageMyFriendId($userId, 12, 1);
   	if($userFriendsData != null)
 	{
	 	for($i=0,$count=count($userFriendsData); $i<$count; $i++)
	 	{
	 		$userFriendsData[$i]['mykAvatarImage'] = $userFriendsData[$i]['mykAvatarImage'] != '' 
			 		? $this->config->item('UpPathAvatar').'s1/'.$userFriendsData[$i]['mykAvatarImage'] 
					: base_url().'kweb/images/kapic12.jpg';
	 	}
 	}
  	$data['userFriendsData'] = $userFriendsData;
  	#var_dump($userFriendsData);
  	
  	///////////////////////////////////////////////
  	// 买卖类
  	// get DB entity Count
	$where = array(
		'operatorFrom'	=> 1
		,'userId'		=> $userId
	);
	$orderby = 'addDateTime desc';
	$totalForSaleRowsCount = $this->MainFCardIndexModel->GetEntityCountForSale($where);
	// select db
	$perpage = '3';
 	$cardDataForSale = $this->MainFCardIndexModel->GetEntityByPageForSale($where, $orderby, $perpage, 1);
   	if($cardDataForSale != null)
 	{
	 	for($i=0,$count=count($cardDataForSale); $i<$count; $i++)
	 	{
	 		$cardDataForSale[$i]['cardImagePath'] = $cardDataForSale[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathCard').'s2/'.$cardDataForSale[$i]['cardImagePath'] 
					: base_url().'kweb/images/kapic2.jpg';
	 	}
 	}
 	$data['cardDataForSale'] = $cardDataForSale;
 	$data['perpageForSale'] = $perpage;
 	$data['totalForSale'] = $totalForSaleRowsCount;
 	
 	
 	///////////////////////////////////////////////
  	// 展示类
  	// get DB entity Count
	$where = array(
		'operatorFrom'	=> 1
		,'userId'		=> $userId
	);
	$orderby = 'addDateTime desc';
	$totalForShowRowsCount = $this->MainFCardIndexModel->GetEntityCountForShow($where);
	// select db
	$perpage = '3';
 	$cardDataForShow = $this->MainFCardIndexModel->GetEntityByPageForShow($where, $orderby, $perpage, 1);
   	if($cardDataForShow != null)
 	{
	 	for($i=0,$count=count($cardDataForShow); $i<$count; $i++)
	 	{
	 		$cardDataForShow[$i]['cardImagePath'] = $cardDataForShow[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathCard').'s2/'.$cardDataForShow[$i]['cardImagePath'] 
					: base_url().'kweb/images/kapic2.jpg';
			$cardDataForShow[$i]['period'] = date('Y-m-d', strtotime($cardDataForShow[$i]['period']));
			$cardDataForShow[$i]['cardUse'] = Tools::GetCardUse($cardDataForShow[$i]['cardUse']); 
	 	}
 	}
 	$data['cardDataForShow'] = $cardDataForShow;
 	$data['perpageForShow'] = $perpage;
 	$data['totalForShow'] = $totalForShowRowsCount;
  	
  		
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	$this->load->view('kweb/member/index.php', $data);
	$master->popMaskInit($this);
	$master->popMaskStartSpell($this);
	$master->popMaskManageSpell($this);
	$master->popMaskUserMsg($this, $userId);
	
	$master->footv2index();
 }
 
 function other($userId='')
 {
 	if($userId == '')
 	{
 	 	$register = new Register();
 		$register->_PublicError($this, '会员不存在',site_url('index'));
 		return;
 	}
 	
 	// 判断是否是自己
 	// 获取session中的会员ID
 	$loginUserId = WebSession::GetUserSessionByOne('userId', $this);
 	if($userId == $loginUserId)
 	{
 		$this->index();
 		return;
 	}
 	
 	
	// 初始化
 	$data = array(
		'title' => $this->config->item('Web_Title').' - 会员主页  '
 		, 'userId' => $userId
		, 'userInfoData' => null
		, 'UserStatistics0' => '0'
		, 'UserStatistics1' => '0'
		, 'UserStatistics2' => '0'
		, 'UserStatistics3' => '0'
		, 'UserStatistics4' => '0'
		, 'UserStatistics5' => '0'
		, 'UserStatistics6' => '0'
		, 'UserStatistics7' => '0'
		, 'UserStatistics8' => '0'
		, 'userStatisticsData' => null
		, 'usernewsData' => null
		, 'userFriendsData' => null
		, 'perpage' => 0
		, 'total' => 0
		, 'cardDataForSale' 	=> null
		, 'perpageForSale' 		=> 0
		, 'totalForSale'	 	=> 0
		, 'cardDataForShow' 	=> null
		, 'perpageForShow' 		=> 0
		, 'totalForShow' 		=> 0
	);

	
	 // DB-获取会员信息 
 	$userInfoData = $this->MainFUserInfoModel->GetEntityByIdForView($userId);
 	if($userInfoData == null)	// 找到当前会员的头像文件名
 	{
 		$register = new Register();
 		$register->_PublicError($this, '会员不存在',site_url('index'));
 		return;
 	}
 	else
 	{
 		$userInfoData['kAvatarImage'] = $userInfoData['kAvatarImage'] != '' 
								? $this->config->item('UpPathAvatar').'b/'.$userInfoData['kAvatarImage'] 
								: base_url().'kweb/images/kapic11.jpg';
 		$userInfoData['loginDateTime'] = $userInfoData['loginDateTime'] != '' 
						 		? date("Y-m-d h:i", strtotime($userInfoData['loginDateTime']))
						 		: '';
 	}
 	$data['userInfoData'] = $userInfoData;

  	// DB - 会员数据统计
	//   统计名称类别
	// 0 - 拥有卡的数量
	// 1 - 拥有卡的种类
	// 2 - 交易记录数
	// 3 - 拼卡发起记录
	// 4 - 兑换记录
	// 5 - 关注我
	// 6 - 我关注
	// 7 - 拼卡活动正在进行数
	// 8 - 拼卡活动报名人数
 	$userStatisticsData = $this->TKUserStatisticsModel->GetEntityAll(array('userId' => $userId));
 	if($userStatisticsData != null)
 	{
 		foreach ($userStatisticsData as $row)
 		{
 			switch ($row['statisticType'])
 			{
	 			case '0':
	 				$data['UserStatistics0'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
	 			case '1':
	 				$data['UserStatistics1'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
	 			case '2':
	 				$data['UserStatistics2'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
	 			case '3':
	 				$data['UserStatistics3'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
	 			case '4':
	 				$data['UserStatistics4'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
	 			case '5':
	 				$data['UserStatistics5'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
	 			case '6':
	 				$data['UserStatistics6'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
	 			case '7':
	 				$data['UserStatistics7'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
				case '8':
	 				$data['UserStatistics8'] = $row['staticValue'];
	 				$isbreak = true;
	 				break;
 			}
 		}
 	}
 	
 	// DB - 会员最新动态
 	$usernewsData = $this->TKUsernewsModel->GetEntityByPageUserId($userId, 5, 1);
 	$data['usernewsData'] = $usernewsData;
 	
 	// DB - 关注他的人
 	#var_dump($userId);
  	$userFriendsData = $this->TKUserFriendsModel->GetEntityByPageMyFriendId($userId, 12, 1);
   	if($userFriendsData != null)
 	{
	 	for($i=0,$count=count($userFriendsData); $i<$count; $i++)
	 	{
	 		$userFriendsData[$i]['mykAvatarImage'] = $userFriendsData[$i]['mykAvatarImage'] != '' 
			 		? $this->config->item('UpPathAvatar').'s1/'.$userFriendsData[$i]['mykAvatarImage'] 
					: base_url().'kweb/images/kapic12.jpg';
	 	}
 	}
  	$data['userFriendsData'] = $userFriendsData;
  	

  	///////////////////////////////////////////////
  	// 买卖类
  	// get DB entity Count
	$where = array(
		'state' 	=> 1
		,'operatorFrom'	=> 1
		,'userId'		=> $userId
	);
	$orderby = 'addDateTime desc';
	$totalForSaleRowsCount = $this->MainFCardIndexModel->GetEntityCountForSale($where);
	// select db
	$perpage = '3';
 	$cardDataForSale = $this->MainFCardIndexModel->GetEntityByPageForSale($where, $orderby, $perpage, 1);
   	if($cardDataForSale != null)
 	{
	 	for($i=0,$count=count($cardDataForSale); $i<$count; $i++)
	 	{
	 		$cardDataForSale[$i]['cardImagePath'] = $cardDataForSale[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathCard').'s2/'.$cardDataForSale[$i]['cardImagePath'] 
					: base_url().'kweb/images/kapic2.jpg';
	 	}
 	}
 	$data['cardDataForSale'] = $cardDataForSale;
 	$data['perpageForSale'] = $perpage;
 	$data['totalForSale'] = $totalForSaleRowsCount;
 	
 	
 	///////////////////////////////////////////////
  	// 买卖类
  	// get DB entity Count
	$where = array(
		'state' 	=> 1
		,'operatorFrom'	=> 1
		,'userId'		=> $userId
	);
	$orderby = 'addDateTime desc';
	$totalForShowRowsCount = $this->MainFCardIndexModel->GetEntityCountForShow($where);
	// select db
	$perpage = '3';
 	$cardDataForShow = $this->MainFCardIndexModel->GetEntityByPageForShow($where, $orderby, $perpage, 1);
   	if($cardDataForShow != null)
 	{
	 	for($i=0,$count=count($cardDataForShow); $i<$count; $i++)
	 	{
	 		$cardDataForShow[$i]['cardImagePath'] = $cardDataForShow[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathCard').'s2/'.$cardDataForShow[$i]['cardImagePath'] 
					: base_url().'kweb/images/kapic2.jpg';
	 	}
 	}
 	$data['cardDataForShow'] = $cardDataForShow;
 	$data['perpageForShow'] = $perpage;
 	$data['totalForShow'] = $totalForShowRowsCount;
 	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	$this->load->view('kweb/member/member.php', $data);
	$master->popMaskInit($this);
	$master->popMaskUserMsg($this, $userId);
	
	$master->footv2index();
 }
 
 ///////////////////////////////////////////////////////////////
 // more Start
 // 
 // 查看会员排行，按$showType方式，选择具体的排序方式
 function more($showType)
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);
 	#var_dump($pageIndex);
 	
 	// 每页数量
 	$perpage = '44';
 	$totalRowsCount=0;
 	
 	#var_dump($showType);
 	switch($showType)
 	{
 		case 'mf': // 查某会员的全部好友
 			// 获取会员ID
 		 	$userId = '1';
		 	if( isset($_REQUEST['uid']) )
		 		$userId = trim($_REQUEST['uid']);

		 	// 获取数据
		    $where = array(
		    	'userId' => $userId
		    	,'friendkState !=' => 2 
		    );
		    $order = 'addDateTime DESC';
		 	$totalRowsCount = $this->TKUserFriendsModel->GetEntityCount($where);
			
			/////////////////////////////////////////////////////
			// select db
		  	$usersData = $this->TKUserFriendsModel->GetEntityByPageFriendId($userId, $perpage, $pageIndex);
		  	if($usersData != null)
		 	{
			 	for($i=0,$count=count($usersData); $i<$count; $i++)
			 	{
			 		$usersData[$i]['kAvatarImage'] = $usersData[$i]['kAvatarImage'] != '' 
				 		? $this->config->item('UpPathAvatar').'s1/'.$usersData[$i]['kAvatarImage'] 
						: base_url().'kweb/images/kapic12.jpg';
			 	}
		 	}
			
 			break;
 		case 'nlu': // 查某最新登录过的会员
		 	// 获取数据
			$where = array(
				'kState !=' => 2
			);
			$orderby = 'loginDateTime desc, verifyDateTime desc';
		 	$totalRowsCount = $this->MainFUserInfoModel->GetEntityCount($where);
			
			/////////////////////////////////////////////////////
			// select db
		  	$usersData = $this->MainFUserInfoModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
		 	if($usersData != null)
		 	{
			 	for($i=0,$count=count($usersData); $i<$count; $i++)
			 	{
			 		$usersData[$i]['kAvatarImage'] = $usersData[$i]['kAvatarImage'] != '' 
				 		? $this->config->item('UpPathAvatar').'s1/'.$usersData[$i]['kAvatarImage'] 
						: base_url().'kweb/images/kapic12.jpg';
			 	}
		 	}
 			break;
 		case 'mbu': // 查某有趣的人
		 	// 获取数据
		    $where = array(
		    	'statisticType' => '9'
		    	,'kState !='	=> 2
		    );
		    $order = 'staticValue DESC';
		 	$totalRowsCount = $this->TKUserStatisticsModel->GetEntityCountByView($where);
			
			/////////////////////////////////////////////////////
			// select db
		  	$usersData = $this->TKUserStatisticsModel->GetEntityViewByPage($where, $order, $perpage, $pageIndex);
		 	if($usersData != null)
		 	{
			 	for($i=0,$count=count($usersData); $i<$count; $i++)
			 	{
			 		$usersData[$i]['kAvatarImage'] = $usersData[$i]['kAvatarImage'] != '' 
				 		? $this->config->item('UpPathAvatar').'s1/'.$usersData[$i]['kAvatarImage'] 
						: base_url().'kweb/images/kapic12.jpg';
			 	}
		 	}
 			break;
 	}
 	
 	$data = array(
		'title' => $this->config->item('Web_Title').' - 卡秀会员  '
 		, 'showType' => $showType
 		, 'usersData' => $usersData
 		, 'total' => $totalRowsCount
 		, 'perpage' => $perpage
	);
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	$this->load->view('kweb/member/membermore.php', $data);
	$master->footv2index();
 }
 

 
 //
 // more End
 /////////////////////////////////////////////////////////////////
 
 
 function upphoto()
 {	
	// 检查是否已登录
 	#var_dump(WebSession::IsUserLogined($this));
 	if(!WebSession::IsUserLogined($this)) // 已登录
 	{
 		// 进入登录页
 		return;
 	}
 	
 	// 初始化
 	$kAvatarImage ='';
 	
 	// 获取session中的会员ID
 	$userId = WebSession::GetUserSessionByOne('userId', $this);
 	#var_dump($userId);
 	if($userId!='')
 	{
	 	$data = $this->MainFUserInfoModel->GetEntityByIdForView($userId);
	 	if($data != null)	// 找到当前会员的头像文件名
	 	{
	 		$kAvatarImage = $data['kAvatarImage'];
	 	}
 	}
 	
 	/////////////////////////////////////////////////////
	// 新加入会员
	$perpage = '20';
	$where = array(
		'kState !=' => 2
	);
	$orderby = 'verifyDateTime desc, registrationDateTime DESC';
 	$newUserInfo = $this->MainFUserInfoModel->GetEntityByPage($where, $orderby, $perpage, 1);
 	if($newUserInfo != null)
 	{
	 	for($i=0,$count=count($newUserInfo); $i<$count; $i++)
	 	{
	 		$newUserInfo[$i]['kAvatarImage'] = $newUserInfo[$i]['kAvatarImage'] != '' 
		 		? $this->config->item('UpPathAvatar').'s1/'.$newUserInfo[$i]['kAvatarImage'] 
				: base_url().'kweb/images/kapic11.jpg';
	 	}
	 	$data['newUserInfo'] = $newUserInfo;
 	}
 	
	
	// 准备页面传送数据
	$data = array(
		'userId' 			=> $userId
		,'bkAvatarImage' 	=> $kAvatarImage
		,'s1kAvatarImage' 	=> $kAvatarImage
		,'s2kAvatarImage' 	=> $kAvatarImage
		,'uploadError' 		=> ''
		,'uploadedImage' 	=> ''
		,'newUserInfo' 		=> $newUserInfo
	);
	$this->RestoreFormDate($data);

 }
 
 function doupphoto()
 {
 	// 恢复form数据
	$formdata = array(
		'userId' => $this->input->post('userId')
		,'bkAvatarImage' 	=> ''
		,'s1kAvatarImage' 	=> ''
		,'s2kAvatarImage' 	=> ''
		,'uploadError' 		=> ''
		,'uploadedImage' 	=> ''
	);
	
 	#var_dump($_FILES);
	/////////////////////////////////////////////////////////////////////////////
	// 上传文件
	$uploadConfig['upload_path'] = $this->config->item('FilePathUpPathAvatar').'temp/';
  	$uploadConfig['allowed_types'] = 'gif|jpg|png';
	$uploadConfig['max_size'] = $this->config->item('upload_maxSize');
	$uploadConfig['max_width']  = '2048';
	$uploadConfig['max_height']  = '1536';
	$uploadConfig['encrypt_name']  = true;
	
	$this->load->library('upload', $uploadConfig);
	if ( ! $this->upload->do_upload())
	{
		#var_dump($formdata['uploadError']);
	    $uploadError = array('error' => $this->upload->display_errors());
	    $formdata['uploadError'] = $uploadError['error'];
		// 出错恢复form数据并返回
		#$this->RestoreFormDate($formdata);
		$this->output->set_output($this->_js('',$formdata['uploadError']));
		return;
	} 
	else
	{
	   $uploadedData = array('upload_data' => $this->upload->data());
	   $formdata['uploadedImage'] = $uploadedData["upload_data"]['file_name'];
	} 

	#$this->RestoreFormDate($formdata);
	$this->output->set_output($this->_js('1',$formdata['uploadedImage']));
 }
 
 function dosave()
 {
 	// 恢复form数据
	$formdata = array(
		'userId' => $this->input->post('userId')
		,'x' => $this->input->post('x')
		,'y' => $this->input->post('y')
		,'w' => $this->input->post('w')
		,'h' => $this->input->post('h')
		,'tempimage' => $this->input->post('tempimage')
	);
	#var_dump($formdata);
	
	$config['source_image'] = $this->config->item('FilePathUpPathAvatar').'temp/'.$formdata['tempimage'];
	$config['x_axis'] = $formdata['x'];
	$config['y_axis'] = $formdata['y'];
	$config['width'] = 180;
	$config['height'] = 180;
	$config['new_image'] = $this->config->item('FilePathUpPathAvatar').'b/'.$formdata['tempimage'];
	$this->crop($config);
	#var_dump($config);

	$config['source_image'] = $config['new_image'];
	$config['width'] = 50;
	$config['height'] = 50;
	$config['new_image'] = $this->config->item('FilePathUpPathAvatar').'s1/'.$formdata['tempimage'];
	$this->resize($config);
	
	$config['width'] = 40;
	$config['height'] = 40;
	$config['new_image'] = $this->config->item('FilePathUpPathAvatar').'s2/'.$formdata['tempimage'];
	$this->resize($config);
	
	// 保存到数据库
	$formdate = array(
		'userId' => $formdata['userId']
		, 'kAvatarImage' => $formdata['tempimage']
	);
	$this->MainFUserInfoModel->UpdateAvatarImage($formdate);
	
	$action = new Action();
	$dataType = '';
	$status = true;
	$message = '头像保存成功';
	$info = $formdata['tempimage'];
	$action -> ajaxReturn($info,$message,$status,$dataType);
	#var_dump($config);

 }
 
function dosaveinfo()
 {
 	// 恢复form数据
	$formdata = array(
		'id' => $this->input->post('userId')
		,'nickname' => $this->input->post('nk')
		,'kMail' => $this->input->post('m')
		,'birthday' => $this->input->post('b')=='' ? null : $this->input->post('b')
		,'kTel' => $this->input->post('t')
		,'area' => $this->input->post('a')
		,'QQ' => $this->input->post('qq')
		,'MSN' => $this->input->post('msn')
		,'Signature' => $this->input->post('st')
	);
	#var_dump($formdata);
	
	// 保存到数据库
	$this->MainFUserInfoModel->Update($formdata);
	
	// 返回ajax应答
	$action = new Action();
	$dataType = '';
	$status = true;
	$message = '保存成功';
	$action -> ajaxReturn('',$message,$status,$dataType);
	#var_dump($config);

 }
 
 function dofriends()
 {
  	// 获取session中的会员ID
 	$userId = WebSession::GetUserSessionByOne('userId', $this);
 	#var_dump($userId);
 	if($userId=='')
 	{
 		$action = new Action();
		$dataType = '';
		$status = false;
		$message = '关注失败登录超时';
		$action -> ajaxReturn('',$message,$status,$dataType);
		#var_dump($config);
 		return;
 	}
 	
 	// 恢复form数据
	$formdata = array(
		'userId' => $userId
		,'friendUserId' => $this->input->post('fuid')
	);

	// DB - 加关注
	$result = $this->TKUserFriendsModel->DoAddUserFriend($formdata);
 	
	// 返回ajax应答
	$action = new Action();
	$dataType = '';
	if($result == 1)
	{
		$action = new Action();
		$dataType = '';
		$status = true;
		$message = '关注成功';
		$action -> ajaxReturn('',$message,$status,$dataType);
		#var_dump($config);
	}
	else if($result == 2)
	{
		$status = true;
		$message = '已关注过此会员';
		$action -> ajaxReturn('',$message,$status,$dataType);
		#var_dump($config);
	}
	else 
	{
		$status = false;
		$message = '关注失败';
		$action -> ajaxReturn('',$message,$status,$dataType);
		#var_dump($config);
	}
 }
 
  function domessage()
 {
 	$action = new Action();
	$dataType = '';

  	// 获取session中的会员ID
 	$userId = WebSession::GetUserSessionByOne('userId', $this);
 	#var_dump($userId);
 	if($userId=='')
 	{
		// 进入登录页
 		$status = false;
		$message = '会员登录超时';
		$url = site_url('login');
		$action -> ajaxReturn($url,$message,$status,$dataType);
 		return;
 	}

 	// 恢复form数据
	$formdata = array(
		'userId' 		=> $userId
		, 'content' 	=> $this->input->post('c')
		, 'toUserId' 	=> $this->input->post('touid')
	);
	#var_dump($this->input->post);
	
	// 系统追加信息
	$umSystemAdd = $this->input->post('umSystemAdd');
	$formdata['content'] .= $umSystemAdd != '' ? '&nbsp;&nbsp;[卡秀提示]：'.$umSystemAdd : '';
	
	// 保存到数据库
	$this->MainFUserMessagesModel->DoAddUserMessages($formdata);
	
	// 返回ajax应答
	$status = true;
	$message = '保存成功';
	$action -> ajaxReturn('',$message,$status,$dataType);
	#var_dump($config);
 }
 
 
 /* public */
 function RestoreFormDate($formdata)
 {
 	// 恢复form数据
	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
		,'userId' 			=> $formdata['userId']
		,'bkAvatarImage' 	=> $formdata['bkAvatarImage'] != '' 
			? $this->config->item('UpPathAvatar').'b/'.$formdata['bkAvatarImage'] 
			: base_url().'kweb/images/kapic11.jpg'
		,'s1kAvatarImage' 	=> $formdata['s1kAvatarImage'] != '' 
			? $this->config->item('UpPathAvatar').'s1/'.$formdata['s1kAvatarImage'] 
			: base_url().'kweb/images/kapic12.jpg'
		,'s2kAvatarImage' 	=> $formdata['s2kAvatarImage'] != '' 
			? $this->config->item('UpPathAvatar').'s2/'.$formdata['s2kAvatarImage'] 
			: base_url().'kweb/images/kapic13.jpg'
		,'uploadError' 		=> $formdata['uploadError']
		,'uploadedImage' 	=> $formdata['uploadedImage']
		,'newUserInfo' 		=> $formdata['newUserInfo']
		
	);
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	$this->load->view('kweb/member/upphoto.php', $data);
	$master->footv2index();
	
 }
 /* End public */

 /* test */
 function image1()
 {
 	$this->load->library('image_lib');
 	$config['image_library'] = 'gd';
	$config['source_image'] = $this->config->item('FilePathUpPathAvatar').'temp/a.jpg';
	$config['create_thumb'] = TRUE;
	$config['maintain_ratio'] = TRUE;
	$config['width'] = 180;
	$config['height'] = 180;
	$config['new_image'] = $this->config->item('FilePathUpPathAvatar').'temp/new_image1.jpg';
	$config['x_axis'] = 75;
	$config['y_axis'] = 50;

	#var_dump($config);
	$this->load->library('image_lib', $config); 
	
	if ( ! $this->image_lib->resize())
	{
		echo "failed";
		echo $this->image_lib->display_errors();
	}else{
	    echo 'success!';
	}
	
	$this->crop($config);
	$config['width'] = 80;
	$config['height'] = 80;
	$config['source_image'] = $this->config->item('FilePathUpPathAvatar').'temp/new_image1.jpg';
	$config['new_image'] = $this->config->item('FilePathUpPathAvatar').'temp/new_image2.jpg';
	$this->resize($config);
	
	
 }
 
 function resize($config)
 {
 	$imgage=getimagesize($config['source_image']);//获取大图信息
    switch ($imgage[2]){//判断图像类型
    case 1:
     $im=imagecreatefromgif($config['source_image']);
     break;
    case 2:
     $im=imagecreatefromjpeg($config['source_image']);
     break;
    case 3:
     $im=imagecreatefrompng($config['source_image']);
     break;  
    }
    $src_W=imagesx($im);//获取大图宽
    $src_H=imagesy($im);//获取大图高
    $tn=imagecreatetruecolor($config['width'],$config['height']);//创建小图
    imagecopyresized($tn,$im,0,0,0,0,$config['width'],$config['height'],$src_W,$src_H);//复制图像并改变大小
    imagejpeg($tn, $config['new_image']);//输出图像
 }
 
function crop($config)
 {
 	$imgage=getimagesize($config['source_image']);//获取大图信息
    switch ($imgage[2]){//判断图像类型
    case 1:
     $im=imagecreatefromgif($config['source_image']);
     break;
    case 2:
     $im=imagecreatefromjpeg($config['source_image']);
     break;
    case 3:
     $im=imagecreatefrompng($config['source_image']);
     break;  
    }
    $src_W=imagesx($im);//获取大图宽
    $src_H=imagesy($im);//获取大图高
    $tn=imagecreatetruecolor($config['width'],$config['height']);//创建小图
    imagecopy($tn,$im,0,0,$config['x_axis'],$config['y_axis'],$config['width'],$config['height']);//复制图像并改变大小
    imagejpeg($tn,$config['new_image']);//输出图像
 }
 
 /* doAjax */
 function doajaxumpage()
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$userId = '';
 	if( isset($_REQUEST['uid']) )
 		$userId = trim($_REQUEST['uid']);
 	#var_dump($pageIndex);
 	
 	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);
 	#var_dump($pageIndex);
 	
 	// 返回页面的HTML
 	$html = '';
 		
 	// DB - 获取分页数据
    $where = array(
    	'toUserId' => $userId
    	, 'state' => '1'
    );
    $order = 'addDateTime DESC';
 	$totalRowsCount = $this->MainFUserMessagesModel->GetEntityCount($where);
	#var_dump($totalRowsCount);
	#var_dump($where);
	#var_dump($orderby);
	
	/////////////////////////////////////////////////////
	// select db
	$perpage = 10;
  	$userMessageData = $this->MainFUserMessagesModel->GetEntityByPagetoUserId($userId, $perpage, $pageIndex);
  	
  	// 合关HTML
  	$i=0;
	$count=count($userMessageData);
  	$html ='<table width="100%" border="0" cellspacing="0" cellpadding="0">';
  	
  	// <!-- 今天 -->
  	if( Tools::IsToday($userMessageData[0]['addDateTime'])){
		$html .='  <tr>';
		$html .='	<td>';
		$html .='		<div class="kaletterul"><h4>今天：</h4>';
		$html .='		<ul>';
		for($j=$i;$j<$count;$j++, $i=$j)
		{
			#var_export(Tools::IsToday($userMessageData[$j]['addDateTime']));
			if( !Tools::IsToday($userMessageData[$j]['addDateTime'])){$j=$count+1;break;}
			$html .='	<li>来自<cite>“'.$userMessageData[$j]['nickname'].'”</cite><em>'
					.date("Y-m-d", strtotime($userMessageData[$j]['addDateTime'])).'</em>  ：'
					.$userMessageData[$j]['content']
					.' <div>&lt;<a href="javascript:void(0)" onclick="ReMyupInit(\'1\',\''.$userMessageData[$j]['userId'] .'\')">回复</a>&gt;</div>'
					.'</li>';
		}
		$html .='	</ul></div></td>';
		$html .='  </tr>';
  	}
	// <!-- 今天end -->
	
  	// <!-- 昨天 -->
	if($i<$count){
		if( Tools::IsYesterday($userMessageData[$i]['addDateTime'])){
			$html .='  <tr>';
			$html .='	<td>';
			$html .='		<div class="kaletterul"><h4>昨天：</h4>';
			$html .='		<ul>';
		 	for($j=$i;$j<$count;$j++, $i=$j)
			{
				if( !Tools::IsYesterday($userMessageData[$j]['addDateTime'])){$j=$count+1;break;}
				$html .='	<li>来自<cite>“'.$userMessageData[$j]['nickname'].'”</cite><em>'
						.date("Y-m-d", strtotime($userMessageData[$j]['addDateTime'])).'</em>  ：'
						.$userMessageData[$j]['content']
						.' <div>&lt;<a href="javascript:void(0)" onclick="ReMyupInit(\'1\',\''.$userMessageData[$j]['userId'] .'\')">回复</a>&gt;</div>'
						.'</li>';
			}
			$html .='	</ul></div></td>';
			$html .='  </tr>';
		}
	}
	// <!-- 昨天end -->
  
  	// <!-- 更早 -->
	if($i<$count){
		$html .='  <tr>';
		$html .='	<td>';
		$html .='		<div class="kaletterul"><h4>更早：</h4>';
		$html .='		<ul>';
		
		for($j=$i;$j<$count;$j++)
		{
			$html .='	<li>来自<cite>“'.$userMessageData[$j]['nickname'].'”</cite><em>'
					.date("Y-m-d", strtotime($userMessageData[$j]['addDateTime'])).'</em>  ：'
					.$userMessageData[$j]['content']
					.' <div>&lt;<a href="javascript:void(0)" onclick="ReMyupInit(\'1\',\''.$userMessageData[$j]['userId'] .'\')">回复</a>&gt;</div>'
					.'</li>';
		}
		$html .='	</ul></div></td>';
		$html .='  </tr>';
	}
	// <!-- 更早end -->
	
	
	// 加补翻页HTML
	$page=new page(array('total'=>$totalRowsCount,'perpage'=>$perpage,'nowindex'=>$pageIndex));
	$page->open_ajax('doAjax');
	
	$html .='  <tr>';
	$html .='    <td class="pdtop30 position3" align="center">';
	$html .= $page->show(1);
	$html .='</td>';
	$html .='  </tr>';
	$html .='</table>';

  	#var_dump($html);

  	$action = new Action();
	$dataType = '';
	$status = true;
	$message = '数据获取成功';
	$data = $html;
	$action -> ajaxReturn($data,$message,$status,$dataType);
 }
 
 function doajaxforsale($isMy=1)
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);
 	#var_dump($pageIndex);
 	$userId = '';
 	if( isset($_REQUEST['uid']) )
 		$userId = trim($_REQUEST['uid']);
 	#var_dump($userId);
 	
	// 是否显示全部卡，全部卡包括注销卡
 	$isSelectAll = '';
 	if( isset($_REQUEST['isa']) )
 		$isSelectAll = trim($_REQUEST['isa']);
 	#var_dump($isSelectAll);
 	
 	// DB - 获取分页数据
 	if($isSelectAll==1){
		$where = array(
			'userId'	=> $userId
		);
 	}else {
 		$where = array(
			'state' 	=> 1
			,'userId'	=> $userId
		);
 	}
	$orderby = 'addDateTime desc';
	$totalForSaleRowsCount = $this->MainFCardIndexModel->GetEntityCountForSale($where);
	// select db
	$perpage = '3';
 	$cardDataForSale = $this->MainFCardIndexModel->GetEntityByPageForSale($where, $orderby, $perpage, $pageIndex);
   	if($cardDataForSale != null)
 	{
	 	for($i=0,$count=count($cardDataForSale); $i<$count; $i++)
	 	{
	 		$cardDataForSale[$i]['cardImagePath'] = $cardDataForSale[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathCard').'s2/'.$cardDataForSale[$i]['cardImagePath'] 
					: base_url().'kweb/images/kapic2.jpg';
	 	}
 	}
	
  	
 	// 返回页面的HTML
 	$html = '';
 	
  	// 合关HTML
  	$i=0;
	$count=count($cardDataForSale);
	$html = '<ul class="kaul19">';
	for($j=$i;$j<$count;$j++, $i=$j)
	{
		$row = $cardDataForSale[$i];
		
		if($isMy == 1)
		{
			$html .='<li><a href="'.site_url('sale/editforsale/'.$row['id']).'" target="_blank">'
			.'<img src="'.$row['cardImagePath'].'" alt="'.$row['name'].'" /></a>'
			.'<div><a href="'.site_url('sale/editforsale/'. $row['id']).'" title="'.$row['name'].'" target="_blank">'
			.String::cut($row['name'],24).'</a></div>'
			.'<div><em>市场价 ￥'.$row['price'].'</em></div>'
			.'<div><cite>售价 ￥'.$row['sellingPrice'].'</cite></div>'
			.'<div class="div">';
			if($row['state']!='3'){
				$html .='<input class="seabut" type="button" value="删除该卡" onclick="doDelCard(\''.$row['id'].'\',1)" />';
			} else {
				$html .='<input class="seabut" type="button" value="已删除" disabled="disabled" />'; 
			}
			$html .='</div>';
			$html .='<br /></li>';
		}else{
			$html .='<li><a href="'.site_url('sale/rebatsale/'.$row['id']).'" target="_blank">'
			.'<img src="'.$row['cardImagePath'].'" alt="'.$row['name'].'" /></a>'
			.'<div><a href="'.site_url('sale/rebatsale/'. $row['id']).'" title="'.$row['name'].'" target="_blank">'
			.String::cut($row['name'],24).'</a></div>'
			.'<div><em>市场价 ￥'.$row['price'].'</em></div>'
			.'<div><cite>售价 ￥'.$row['sellingPrice'].'</cite></div><br /></li>';
		}
	}

	// 加补翻页HTML
	$page=new page(array('total'=>$totalForSaleRowsCount
					,'perpage'=>$perpage
					,'nowindex'=>$pageIndex
					,'pagebarnum'=>2));
	$page->open_ajax('doAjaxForSale');
	
	$html .='</ul><div class="clear"></div>';
	$html .='<div class="position3">';
	$html .= $page->show(4);
	$html .='</div>';
			
  	#var_dump($html);

  	$action = new Action();
	$dataType = '';
	$status = true;
	$message = '数据获取成功';
	$data = $html;
	$action -> ajaxReturn($data,$message,$status,$dataType);
 }

function doajaxforshow($isMy=1)
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);
 	#var_dump($pageIndex);
 	$userId = '';
 	if( isset($_REQUEST['uid']) )
 		$userId = trim($_REQUEST['uid']);
 	#var_dump($userId);
 	// 是否显示全部卡，全部卡包括注销卡
 	$isSelectAll = '';
 	if( isset($_REQUEST['isa']) )
 		$isSelectAll = trim($_REQUEST['isa']);
 	#var_dump($isSelectAll);
 	
 	// DB - 获取分页数据
 	if($isSelectAll==1){
		$where = array(
			'userId'	=> $userId
		);
 	}else {
 		$where = array(
			'state' 	=> 1
			,'userId'	=> $userId
		);
 	}
	$orderby = 'addDateTime desc';
	$totalForShowRowsCount = $this->MainFCardIndexModel->GetEntityCountForShow($where);
	// select db
	$perpage = '3';
 	$cardDataForShow = $this->MainFCardIndexModel->GetEntityByPageForShow($where, $orderby, $perpage, $pageIndex);
   	if($cardDataForShow != null)
 	{
	 	for($i=0,$count=count($cardDataForShow); $i<$count; $i++)
	 	{
	 		$cardDataForShow[$i]['cardImagePath'] = $cardDataForShow[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathCard').'s2/'.$cardDataForShow[$i]['cardImagePath'] 
					: base_url().'kweb/images/kapic2.jpg';
			$cardDataForShow[$i]['period'] = date('Y-m-d', strtotime($cardDataForShow[$i]['period']));
			$cardDataForShow[$i]['cardUse'] = Tools::GetCardUse($cardDataForShow[$i]['cardUse']); 
	 	}
 	}
  	
 	// 返回页面的HTML
 	$html = '';
 	
  	// 合关HTML
  	$i=0;
	$count=count($cardDataForShow);
	$html = '<ul class="kaul19">';
	for($j=$i;$j<$count;$j++, $i=$j)
	{
		$row = $cardDataForShow[$i];
		if($isMy == 1)
		{
			$html .='<li><a href="'.site_url('sale/editforshow/'.$row['id']).'" target="_blank">'
			.'<img src="'.$row['cardImagePath'].'" alt="'.$row['name'].'" /></a>'
			.'<div><a href="'.site_url('sale/editforshow/'. $row['id']).'" title="'.$row['name'].'" target="_blank">'
			.String::cut($row['name'],24).'</a></div>'
			.'<div><em>市场价 ￥'.$row['price'].'</em></div>'
			.'<div><cite>售价 ￥'.$row['sellingPrice'].'</cite></div>'
			.'<div class="div">';
			if($row['state']!='3'){
				$html .='<input class="seabut" type="button" value="删除该卡" onclick="doDelCard(\''.$row['id'].'\',2)" />';
			} else {
				$html .='<input class="seabut" type="button" value="已删除" disabled="disabled" />'; 
			}
			$html .='</div>';
			$html .='<br /></li>';
		}else{
			$html .='<li><a href="'.site_url('sale/rebatshow/'.$row['id']).'" target="_blank">'
			.'<img src="'.$row['cardImagePath'].'" alt="'.$row['name'].'" /></a>'
			.'<div><a href="'.site_url('sale/rebatshow/'. $row['id']).'" title="'.$row['name'].'" target="_blank">'
			.String::cut($row['name'],24).'</a></div>'
			.'<div><em>市场价 ￥'.$row['price'].'</em></div>'
			.'<div><cite>售价 ￥'.$row['sellingPrice'].'</cite></div><br /></li>';
		}
	}

	// 加补翻页HTML
	$page=new page(array('total'=>$totalForShowRowsCount
					,'perpage'=>$perpage
					,'nowindex'=>$pageIndex
					,'pagebarnum'=>2));
	$page->open_ajax('doAjaxForSale');
	
	$html .='</ul><div class="clear"></div>';
	$html .='<div class="position3">';
	$html .= $page->show(4);
	$html .='</div>';
			
  	#var_dump($html);

  	$action = new Action();
	$dataType = '';
	$status = true;
	$message = '数据获取成功';
	$data = $html;
	$action -> ajaxReturn($data,$message,$status,$dataType);
 }
 
function doajaxforfriend($userId)
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);
 	#var_dump($pageIndex);
 	
 	// DB - 获取分页数据
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
  	
 	// 返回页面的HTML
 	$html = '';
 	
  	// 合关HTML
  	$i=0;
	$count=count($friendsData);
	$html = '<ul class="kaul19">';
	for($j=$i;$j<$count;$j++, $i=$j)
	{
		$row = $friendsData[$i];
		$html .='<li><a href="'.site_url('member/other/'.$row['friendUserId']).'">'
				.'<img src="'.$row['kAvatarImage'].'" /></a><div>'
				.'<a href="'.site_url('member/other/'.$row['friendUserId']).'">'.$row['nickname'].'</a></div></li>';
	}

	// 加补翻页HTML
	$page=new page(array('total'=>$totalRowsCount
					,'perpage'=>$perpage
					,'nowindex'=>$pageIndex
					,'pagebarnum'=>4));
	$page->open_ajax('doAjaxForFriend');
	
	$html .='</ul><div class="clear"></div>';
	$html .='<div class="position3">';
	$html .= $page->show(4);
	$html .='</div>';
			
  	#var_dump($html);

  	$action = new Action();
	$dataType = '';
	$status = true;
	$message = '数据获取成功';
	$data = $html;
	$action -> ajaxReturn($data,$message,$status,$dataType);
 }
 
 function doajaxformanagespell()
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);
 	#var_dump($pageIndex);
 	

	// 获取登录会员信息
 	if(WebSession::IsUserLogined($this)) // 已登录
 	{
 		// 找到登录会员信息
	 	$loginUserId = WebSession::GetUserSessionByOne('userId', $this);
	 	if($loginUserId != '')
	 	{
	 		// DB - 获取分页数据
		 	/////////////////////////////////////////////////////
			// 读取活动卡
			$where = array(
				'userId' 	=> $loginUserId
				,'cardSetType'	=> '3'
			);
			$orderby = 'addDateTime desc';
			$totalRowsCount = $this->MainFCardIndexModel->GetEntityCountForActivity($where);
			// select db
			$perpage = '1';
		 	$cardData = $this->MainFCardIndexModel->GetEntityByPageForActivity($where, $orderby, $perpage, $pageIndex);
		   	if($cardData != null)
		 	{
			 	for($i=0,$count=count($cardData); $i<$count; $i++)
			 	{
			 		$cardData[$i]['cardImagePath'] = $cardData[$i]['cardImagePath'] != '' 
					 		? $this->config->item('UpPathCard').'s1/'.$cardData[$i]['cardImagePath'] 
							: base_url().'kweb/images/kapic2.jpg';
					$cardData[$i]['startDate'] = $cardData[$i]['startDate'] != '' 
					 		? date('Y年m月d日', strtotime($cardData[$i]['startDate'])) 
							: '';
					$cardData[$i]['endDate'] = $cardData[$i]['endDate'] != '' 
					 		? date('Y年m月d日', strtotime($cardData[$i]['endDate'])) 
							: '';
			 	}
		 	}
	 	}
 	}
  	
 	// 返回页面的HTML
 	$html = '';
 	
  	// 合关HTML
  	$i=0;
	$count=count($cardData);
	$html = '<ul class="kaul5">';
	for($j=$i;$j<$count;$j++, $i=$j)
	{
		$row = $cardData[$i];
		$html .='<li><div class="lpic"><a href="'.site_url('spell/spellxl/'.$row['id']).'" target="_blank">'
				.'<img title="" src="'.$row['cardImagePath'].'" /></a></div>'
				.'<div class="rtxt">'
				.'<p>发起人： '.$row['nickname'].'</p>'
				.'<p>意向人数： <font class="redf24">'.$row['regCount'].'</font></p>'
				.'<p>活动参与人数限制： '.$row['limitUser'].'</p>'
				.'<p>发起时间： '.$row['startDate'].'</p>'
				.'<p>结束时间： '.$row['endDate'].'</p>'
				.'<p>联系方式： '.$row['tel'].' </p>'
				.'<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Q Q： '.$row['QQ'].'</p>';
		if($row['state']!='3'){
			$html .='<input class="seabut" type="button" value="我要修改" onclick="location.href=\''.site_url('spell/spellxl/'.$row['id']).'\'" />&nbsp;&nbsp;';
	
			$endDate = $row['endDate'];
			$endDate = str_replace("年","-",$endDate);
			$endDate = str_replace("月","-",$endDate);
			$endDate = str_replace("日","",$endDate);
			if(Tools::IsOld($endDate) || $row['state']=='2'){
				$html .='<input class="seabut" type="button" value="活动结束" disabled="disabled"/> ';
			} else {
				$html .='<input class="seabut" type="button" value="结束活动" onclick="doCloseManageSpell(\''.$row['id'].'\')" /> ';
			}
			$html .='&nbsp;<input class="seabut1" type="button" value="删除" onclick="doDelManageSpell(\''.$row['id'].'\')" />';

		} else {
			$html .='<input class="seabut" type="button" value="已删除" disabled="disabled" />'; 
		}
		
		$html .='</div>'
				.'</li>';
	}

	// 加补翻页HTML
	$page=new page(array('total'=>$totalRowsCount
					,'perpage'=>$perpage
					,'nowindex'=>$pageIndex
					,'pagebarnum'=>10));
	$page->open_ajax('doAjaxManageSpell');
	
	$html .='</ul><div class="clear"></div>';
	$html .='<div class="position3">';
	$html .= $page->show(4);
	$html .='</div>';
			
  	#var_dump($html);

  	$action = new Action();
	$dataType = '';
	$status = true;
	$message = '数据获取成功';
	$data = $html;
	$action -> ajaxReturn($data,$message,$status,$dataType);
 }
 
 
 /* public js */
 function _js($success, $imagename)
 {
	header("Content-Type:text/html; charset=utf-8");
 	return '<script type="text/javascript">window.parent.Finish("'.$success.'","'.$imagename.'");</script>';
 }
 
 function _jsGOTOLogin($url='')
 {
	header("Content-Type:text/html; charset=utf-8");
 	return '<script type="text/javascript">location.href="'.site_url('login/noLoginIndex?u='.$url).'";</script>';
 }
 
 
 /* photo */
 function useruppic()
 {
 	// 初始化
 	$data = array(
		'title' => $this->config->item('Web_Title')
 		,'uploadedImage' => ''
 		,'userId' => ''
 	);
 	
  	 // page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$uploadedImage = '1';
 	if( isset($_REQUEST['ui']) )
 		$uploadedImage = trim($_REQUEST['ui']);
 	$data['uploadedImage'] = $uploadedImage;
 	#var_dump($pageIndex);
 	
 	// 获取session中的会员ID
 	$userId = WebSession::GetUserSessionByOne('userId', $this);
 	$data['userId'] = $userId;
 	
 	$master = new Master();	
	$this->load->view('kweb/member/useruppic.php', $data);
 }
 
 
 
 /* test */
 function testdate()
 {
 	$d   =   "2011-07-22";   
	echo  date("Y-m-d",strtotime("$d   -1   day"));   //日期天数相加函数
	$now=getdate();
	#var_dump($now);
 	var_dump( Tools::IsToday($d));
 	var_dump( Tools::IsYesterday($d));
	
 }
 

 
}

 
?>