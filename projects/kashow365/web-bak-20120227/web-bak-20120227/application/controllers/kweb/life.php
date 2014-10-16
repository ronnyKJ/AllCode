<?php
class Life extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  $this->load->library('session');
  
  require_once 'application/controllers/kweb/master.php';
  require_once 'kadmin/businessentity/websession.php';
  require_once 'kadmin/businessentity/tools/action.php';
  require_once 'kadmin/businessentity/tools.php';
  require_once 'kadmin/businessentity/tools/page.class.php';
  require_once 'kadmin/businessentity/tools/string.class.php';
  require_once 'register.php';
  require_once 'member.php';
  
  $this->load->model('kadmin/kuser/mainfuserinfo_model','MainFUserInfoModel');
  $this->load->model('kadmin/message/mainfblogmessages_model','MainFBlogMessagesModel');
  $this->load->model('kadmin/kuser/tkuserfriends_model','TKUserFriendsModel');
  $this->load->model('kadmin/kuser/tkuserstatistics_model','TKUserStatisticsModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoif_model','MainFBaseInfoIFModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoheari_model','MainFBaseInfoHearIModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfo_model','MainFBaseInfoModel');
  $this->load->model('kadmin/news/mainfshop_model','MainFshopModel');
  
 }

 function index()
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 生活广场 '
		,'userId' 			=> ''
		,'newUserInfo' 		=> null #新加入会员
		,'blogData' 		=> null #本页微博
		,'lastId' 			=> 0 #当前微博最大ID
		,'pageIndex' 		=> 0
		,'total' 			=> 0
		,'perpage' 			=> 0
		,'statisticsData1' 	=> null #关注度top10
		,'newLoginUserInfo' => null #我在微博
		,'maxBlogUserInfo' 	=> null #有趣的人
		,'adinfo'			=> null #Flash
	);
	
	// 获取session中的会员ID
 	$userId = WebSession::GetUserSessionByOne('userId', $this);
 	$data['userId'] = $userId;


	/////////////////////////////////////////////////////
	// 新加入会员
	$perpage = '5';
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
			if($this->TKUserFriendsModel->CheckIsMyFriend($userId, $newUserInfo[$i]['id']))
			{
				$newUserInfo[$i]['kPWD'] = '1';
			}
			else 
			{
				$newUserInfo[$i]['kPWD'] = '0';
			}
			if($userId==$newUserInfo[$i]['id'])
			{
				$newUserInfo[$i]['kPWD'] = '2';
			}
	 	}
	 	$data['newUserInfo'] = $newUserInfo;
 	}
 	
 	/////////////////////////////////////////////////////
	// 读取微博信息
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 	{
 		$pageIndex = trim($_REQUEST['n']);
 		$data['pageIndex'] = $pageIndex;
 	}
 	else 
 	{
 		$data['pageIndex'] = 0;
 	}
 	#var_dump($pageIndex);
    $where = array(
    	'state' => '1'
    );
    $order = 'addDateTime DESC';
 	$totalRowsCount = $this->MainFBlogMessagesModel->GetEntityCount($where);
	$data['total'] = $totalRowsCount;
	/////////////////////////////////////////////////////
	// select db
	$data['perpage'] = '6';
  	$blogData = $this->MainFBlogMessagesModel->GetEntityViewByPage($where, $order, $perpage, $pageIndex);
 	if($blogData != null)
 	{
 		$lastId = 0;
	 	for($i=0,$count=count($blogData); $i<$count; $i++)
	 	{
	 		$blogData[$i]['kAvatarImage'] = $blogData[$i]['kAvatarImage'] != '' 
		 		? $this->config->item('UpPathAvatar').'s1/'.$blogData[$i]['kAvatarImage'] 
				: base_url().'kweb/images/kapic12.jpg';
			$lastId =  $lastId < $blogData[$i]['id'] 
							? $blogData[$i]['id'] :  $lastId;
	 	}
	 	$data['lastId'] = $lastId;
	 	$data['blogData'] = $blogData;
 	}

 	
 	
 	/////////////////////////////////////////////////////
	// 读取关注度TOP10(读取会员统计表中5-关注我)
	$perpage = '10';
    $where = array(
    	'statisticType' => '5'
    );
    $order = 'staticValue DESC';
  	$statisticsData1 = $this->TKUserStatisticsModel->GetEntityViewByPage($where, $order, $perpage, 1);
  	$data['statisticsData1'] = $statisticsData1;
  	
  	

 	/////////////////////////////////////////////////////
	// 我在微博
	$perpage = '12';
 	$where = array(
		'kState !=' => 2
	);
	$orderby = 'loginDateTime desc, verifyDateTime desc';
	/////////////////////////////////////////////////////
	// select db
  	$newLoginUserInfo = $this->MainFUserInfoModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
 	if($newLoginUserInfo != null)
 	{
	 	for($i=0,$count=count($newLoginUserInfo); $i<$count; $i++)
	 	{
	 		$newLoginUserInfo[$i]['kAvatarImage'] = $newLoginUserInfo[$i]['kAvatarImage'] != '' 
		 		? $this->config->item('UpPathAvatar').'s1/'.$newLoginUserInfo[$i]['kAvatarImage'] 
				: base_url().'kweb/images/kapic12.jpg';
	 	}
 	}
	$data['newLoginUserInfo'] = $newLoginUserInfo;
	 	
	
 	/////////////////////////////////////////////////////
	// 读取有趣的人(读取会员统计表中9 - 微博数)
	$perpage = '10';
    $where = array(
    	'statisticType' => '9'
    );
    $order = 'staticValue DESC';
  	$maxBlogUserInfo = $this->TKUserStatisticsModel->GetEntityViewByPage($where, $order, $perpage, $pageIndex);
 	if($maxBlogUserInfo != null)
 	{
	 	for($i=0,$count=count($maxBlogUserInfo); $i<$count; $i++)
	 	{
	 		$maxBlogUserInfo[$i]['kAvatarImage'] = $maxBlogUserInfo[$i]['kAvatarImage'] != '' 
		 		? $this->config->item('UpPathAvatar').'s1/'.$maxBlogUserInfo[$i]['kAvatarImage'] 
				: base_url().'kweb/images/kapic12.jpg';
	 	}
 	}
	$data['maxBlogUserInfo'] = $maxBlogUserInfo;


  	/////////////////////////////////////////////////////
	// FLASH广告
	$where = array(
		'infoType' 	=> 'IndexFlashTop2'
	);
	$orderby = 'orderNum desc';
 	$adinfo = $this->MainFBaseInfoIFModel->GetEntityAll($where, $orderby);
 	#var_dump($adinfo);
   	if($adinfo != null)
 	{
	 	for($i=0,$count=count($adinfo); $i<$count; $i++)
	 	{
	 		$adinfo[$i]['value1'] = $adinfo[$i]['value1'] != '' 
			 		? $this->config->item('UpPathFlashIndex').$adinfo[$i]['value1'] 
					: base_url().'kweb/images/kadv5.jpg';
	 	}
 	}
 	$data['adinfo'] = $adinfo;
 	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this, 'life');
	$this->load->view('kweb/life/index.php', $data);
	$master->popMaskInit($this);
	$master->popMaskUserMsg($this, '');
	$master->popMaskBlogMsg($this);
	
	$master->footv2index();
 }
 
 function more($blogUserId)
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 生活广场 '
		,'userId' 			=> ''
		,'newUserInfo' 		=> null #新加入会员
		,'blogData' 		=> null #本页微博
		,'lastId' 			=> 0 #当前微博最大ID
		,'pageIndex' 		=> 0
		,'total' 			=> 0
		,'perpage' 			=> 0
		,'statisticsData1' 	=> null #关注度top10
		,'newLoginUserInfo' => null #我在微博
		,'maxBlogUserInfo' 	=> null #有趣的人
		,'blogUserId' 		=> $blogUserId #仅浏览一个人的博客
		,'blogUserInfoData' => null  #博客人的会员信息
		,'adinfo'			=> null #Flash
	);
	
	// 获取session中的会员ID
 	$userId = WebSession::GetUserSessionByOne('userId', $this);
 	$data['userId'] = $userId;

 	// DB-获取当前微博人的会员信息 
 	#var_dump( $blogUserId);
 	$blogUserInfoData = $this->MainFUserInfoModel->GetEntityByIdForView($blogUserId);
 	$data['blogUserInfoData'] = $blogUserInfoData;
 	if($blogUserInfoData == null)
 	{
 		$register = new Register();
 		$register->_PublicError($this, '会员不存在',site_url('index'));
 		return;
 	}
 	

 	/////////////////////////////////////////////////////
	// 新加入会员
	$perpage = '5';
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
				: base_url().'kweb/images/kapic12.jpg';
			if($this->TKUserFriendsModel->CheckIsMyFriend($userId, $newUserInfo[$i]['id']))
			{
				$newUserInfo[$i]['kPWD'] = '1';
			}
			else 
			{
				$newUserInfo[$i]['kPWD'] = '0';
			}
	 		if($userId==$newUserInfo[$i]['id'])
			{
				$newUserInfo[$i]['kPWD'] = '2';
			}
	 	}
	 	$data['newUserInfo'] = $newUserInfo;
 	}
 	
 	/////////////////////////////////////////////////////
	// 读取微博信息
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 	{
 		$pageIndex = trim($_REQUEST['n']);
 		$data['pageIndex'] = $pageIndex;
 	}
 	else 
 	{
 		$data['pageIndex'] = 0;
 	}
 	#var_dump($pageIndex);
    $where = array(
    	'state' => '1'
    	,'userId =' => $blogUserId
    );
    $order = 'addDateTime DESC';
 	$totalRowsCount = $this->MainFBlogMessagesModel->GetEntityCount($where);
	$data['total'] = $totalRowsCount;
	/////////////////////////////////////////////////////
	// select db
	$data['perpage'] = '6';
  	$blogData = $this->MainFBlogMessagesModel->GetEntityViewByPage($where, $order, $perpage, $pageIndex);
 	if($blogData != null)
 	{
 		$lastId = 0;
	 	for($i=0,$count=count($blogData); $i<$count; $i++)
	 	{
	 		$blogData[$i]['kAvatarImage'] = $blogData[$i]['kAvatarImage'] != '' 
		 		? $this->config->item('UpPathAvatar').'s1/'.$blogData[$i]['kAvatarImage'] 
				: base_url().'kweb/images/kapic12.jpg';
			$lastId =  $lastId < $blogData[$i]['id'] 
							? $blogData[$i]['id'] :  $lastId;
	 	}
	 	$data['lastId'] = $lastId;
	 	$data['blogData'] = $blogData;
 	}

 	 	
 	/////////////////////////////////////////////////////
	// 读取关注度TOP10(读取会员统计表中5-关注我)
	$perpage = '10';
    $where = array(
    	'statisticType' => '5'
    );
    $order = 'staticValue DESC';
  	$statisticsData1 = $this->TKUserStatisticsModel->GetEntityViewByPage($where, $order, $perpage, 1);
  	$data['statisticsData1'] = $statisticsData1;
  	
  	
 	/////////////////////////////////////////////////////
	// 我在微博
	$perpage = '6';
 	$where = array(
		'kState !=' => 2
	);
	$orderby = 'loginDateTime desc, verifyDateTime desc';
	/////////////////////////////////////////////////////
	// select db
  	$newLoginUserInfo = $this->MainFUserInfoModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
 	if($newLoginUserInfo != null)
 	{
	 	for($i=0,$count=count($newLoginUserInfo); $i<$count; $i++)
	 	{
	 		$newLoginUserInfo[$i]['kAvatarImage'] = $newLoginUserInfo[$i]['kAvatarImage'] != '' 
		 		? $this->config->item('UpPathAvatar').'s1/'.$newLoginUserInfo[$i]['kAvatarImage'] 
				: base_url().'kweb/images/kapic12.jpg';
	 	}
 	}
	$data['newLoginUserInfo'] = $newLoginUserInfo;
	
 	/////////////////////////////////////////////////////
	// 读取有趣的人(读取会员统计表中9 - 微博数)
	$perpage = '10';
    $where = array(
    	'statisticType' => '9'
    );
    $order = 'staticValue DESC';
  	$maxBlogUserInfo = $this->TKUserStatisticsModel->GetEntityViewByPage($where, $order, $perpage, $pageIndex);
 	if($maxBlogUserInfo != null)
 	{
	 	for($i=0,$count=count($maxBlogUserInfo); $i<$count; $i++)
	 	{
	 		$maxBlogUserInfo[$i]['kAvatarImage'] = $maxBlogUserInfo[$i]['kAvatarImage'] != '' 
		 		? $this->config->item('UpPathAvatar').'s1/'.$maxBlogUserInfo[$i]['kAvatarImage'] 
				: base_url().'kweb/images/kapic12.jpg';
	 	}
 	}
	$data['maxBlogUserInfo'] = $maxBlogUserInfo;
 	
	/////////////////////////////////////////////////////
	// FLASH广告
	$where = array(
		'infoType' 	=> 'IndexFlashTop2'
	);
	$orderby = 'orderNum desc';
 	$adinfo = $this->MainFBaseInfoIFModel->GetEntityAll($where, $orderby);
 	#var_dump($adinfo);
   	if($adinfo != null)
 	{
	 	for($i=0,$count=count($adinfo); $i<$count; $i++)
	 	{
	 		$adinfo[$i]['value1'] = $adinfo[$i]['value1'] != '' 
			 		? $this->config->item('UpPathFlashIndex').$adinfo[$i]['value1'] 
					: base_url().'kweb/images/kadv5.jpg';
	 	}
 	}
 	$data['adinfo'] = $adinfo;
 	

	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this, 'life');
	$this->load->view('kweb/life/life_more.php', $data);
	$master->popMaskInit($this);
	$master->popMaskUserMsg($this, '');
	$master->popMaskBlogMsg($this);
	
	$master->footv2index();
 }
 
 function doblog()
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
		'userId' => $userId
		,'content' => $this->input->post('c')
	);
	#var_dump($formdata);
	
	// 保存到数据库
	$this->MainFBlogMessagesModel->DoAddUserBlogMessages($formdata);
	
	// 返回ajax应答
	$status = true;
	$message = '保存成功';
	$action -> ajaxReturn('',$message,$status,$dataType);
	#var_dump($config);
 }
 
 function getblog()
 {
 	$html = '';
 
 	// page pramas
 	#parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$lastId = '';
 	if( isset($_REQUEST['lastId']) )
 		$lastId = trim($_REQUEST['lastId']);
 	#var_dump($lastId);
 	$blogUserId = '';
 	if( isset($_REQUEST['buserId']) )
 		$blogUserId = trim($_REQUEST['buserId']);
 		
 	// 获取微博信息
 	if($blogUserId == '')
 	{
	    $where = array(
	    	'state' => '1'
	    	,'id >' => $lastId
	    );
 	}
 	else 
 	{
 		$where = array(
	    	'state' => '1'
	    	,'id >' => $lastId
	    	,'userId' => $blogUserId
    	);
 	}
    $order = 'id ASC';
	$perpage = '5';
  	$blogData = $this->MainFBlogMessagesModel->GetEntityViewByPage($where, $order, $perpage, 1);
 	if($blogData != null)
 	{
	 	 foreach ($blogData as $row)
	 	 {
	 	 	$lastId = $row['id'];
	 	 	$kAvatarImage = $row['kAvatarImage'] != '' 
		 		? $this->config->item('UpPathAvatar').'s1/'.$row['kAvatarImage'] 
				: base_url().'kweb/images/kapic11.jpg';
			$html .='<li id="b'.$row['id'].'"><a href='.site_url('member/other/'.$row['id']).'>'.
					'<img src="'.$kAvatarImage.'" width="50px" height="50px" /></a>'.
					'<p><span>'.$row['nickname'].'</span>：'.$row['content'].
					'<em>'.Tools::FormatTime($row['addDateTime']).
					' <a href="'.site_url('life/more'.$row['id']).'">'.
					'<span>看他都说过什么&gt;&gt;&gt;</span></a></em></p></li>';
	 	}
 	}
 		
  	#var_dump($html);

  	$action = new Action();
	$dataType = '';
	$status = true;
	$message = $lastId;
	$data = $html;
	$action -> ajaxReturn($data,$message,$status,$dataType);
 }
 
// 查某最新登录过的会员
 function _moreNewLoginUserInfo($perpage, $pageIndex, $totalRowsCount=0)
 {
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
	
	return $usersData;
 }
  
 // 查某有趣的人
 function _moreMaxBlogUserInfo($perpage, $pageIndex, $totalRowsCount=0)
 {
 	// 获取数据
    $where = array(
    	'statisticType' => '9'
    );
    $order = 'staticValue DESC';
 	$totalRowsCount = $this->TKUserStatisticsModel->GetEntityCount($where);

	/////////////////////////////////////////////////////
	// select db
  	$usersData = $this->TKUserStatisticsModel->GetEntityViewByPage($where, $order, $perpage, $pageIndex);
  	var_dump($usersData);
 	if($usersData != null)
 	{
	 	for($i=0,$count=count($usersData); $i<$count; $i++)
	 	{
	 		$usersData[$i]['kAvatarImage'] = $usersData[$i]['kAvatarImage'] != '' 
		 		? $this->config->item('UpPathAvatar').'s1/'.$usersData[$i]['kAvatarImage'] 
				: base_url().'kweb/images/kapic12.jpg';
	 	}
 	}

	return $usersData;
 }
 
 
 
 ////////////////////////////////
 // test
 function test()
 {
 	#echo gettimeofday('sec');
 	#echo '<br />';
 	#echo time();
 	#echo '<br />';
 	#echo strtotime('2011-7-25 21:29:00');
 	
 	$result = '';
 	$dateTime = '2011-7-21 19:39:00';
 	
 	echo Tools::FormatTime($dateTime);
 	
 }

}
?> 