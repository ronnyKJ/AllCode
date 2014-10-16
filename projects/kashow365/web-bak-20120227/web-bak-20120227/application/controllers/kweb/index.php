<?php
class Index extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  $this->load->library('session');
  
  require_once 'application/controllers/kweb/master.php';
  require_once 'kadmin/businessentity/websession.php';
  require_once 'kadmin/businessentity/tools.php';
  require_once 'kadmin/businessentity/tools/string.class.php';
  require_once 'kadmin/businessentity/tools/action.php';
  
  $this->load->model('kadmin/kuser/mainfuserinfo_model','MainFUserInfoModel');
  $this->load->model('kadmin/kuser/tkuserstatistics_model','TKUserStatisticsModel');
  $this->load->model('kadmin/kainfo/mainfannount_model','MainFannountModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfo_model','MainFBaseInfoModel');
  $this->load->model('kadmin/news/mainfshopnews_model','MainFshopnewsModel');
  $this->load->model('kadmin/kcard/mainfcardindex_model','MainFCardIndexModel');
  $this->load->model('kadmin/message/mainfblogmessages_model','MainFBlogMessagesModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoheari_model','MainFBaseInfoHearIModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoif_model','MainFBaseInfoIFModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoad_model','MainFBaseInfoAdModel');
  $this->load->model('kadmin/kuser/tkuserfriends_model','TKUserFriendsModel');
  $this->load->model('kadmin/news/mainfshop_model','MainFshopModel');
  $this->load->model('kadmin/kainfo/mainfwjanser_model','MainFWJAnserModel');
  $this->load->model('kadmin/kainfo/mainfwjproblem_model','MainFWJProblemModel');
  $this->load->model('kadmin/kuser/mainfuserinfoindex_model','MainFUserInfoIndexmodel');
  
 }

 function indexv1()
 {
 	// 准备页面所需要的参数
 	$userId = '';
 	$loginedUserInfo = array(
 		'nickname' 			=> ''
 		,'gradeName' 		=> ''
 		,'kPoints' 			=> ''
 		,'kState' 			=> ''
 		,'kCount' 			=> ''
 		,'kLookmeCount'		=> ''
 		,'webStatistics' 	=> null
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
 	
 	// 读取公告
 	$annount = $this->MainFannountModel->GetEntityAnnount();
 	
 	// 读取网站统计信息
 	    #WebTotcalCZ - 储值卡数
		#WebTotcalJF - 积分卡数
		#WebTotcalHY - 会员卡数
		#WebTotcalTY - 体验卡数
		#WebTotcalTH - 提货卡数
		#WebTotcalUser - 网站会员数
	$webStatistics = $this->MainFBaseInfoModel->GetWebStatistics();
 	
	/////////////////////////////////////////////////////
	// 最新活动
	$perpage = '10';
	$where = array(
		'newsType' 	=> 1
		,'state' 	=> 1
	);
	$orderby = 'orderNum desc';
 	$news1 = $this->MainFshopnewsModel->GetEntityByPage($where, $orderby, $perpage, 1);
	
	/////////////////////////////////////////////////////
	// 打折快报
	$perpage = '10';
	$where = array(
		'newsType' 	=> 2
		,'state' 	=> 1
	);
	$orderby = 'orderNum desc';
 	$news2 = $this->MainFshopnewsModel->GetEntityByPage($where, $orderby, $perpage, 1);
	
 	
	/////////////////////////////////////////////////////
	// kashow兑换通知
	$perpage = '10';
	$where = array(
		'newsType' 	=> 3
		,'state' 	=> 1
	);
	$orderby = 'orderNum desc';
 	$news3 = $this->MainFshopnewsModel->GetEntityByPage($where, $orderby, $perpage, 1);
	
 	
  	/////////////////////////////////////////////////////
	// 读取卡 - 买卖卡
	$perpage = '6';
	$where = array(
		'state' 	=> 1
	);
	$orderby = 'addDateTime desc';
 	$cardData = $this->MainFCardIndexModel->GetEntityByPageForSale($where, $orderby, $perpage, 1);
   	if($cardData != null)
 	{
	 	for($i=0,$count=count($cardData); $i<$count; $i++)
	 	{
	 		$cardData[$i]['cardImagePath'] = $cardData[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathCard').'s2/'.$cardData[$i]['cardImagePath'] 
					: base_url().'kweb/images/kapic2.jpg';
	 	}
 	}
 	
 	
	/////////////////////////////////////////////////////
	// 读取活动卡
	$where = array(
		'state !=' 	=> 3
	);
	$orderby = 'addDateTime desc';
	// select db
	$perpage = '6';
 	$cardSpellData = $this->MainFCardIndexModel->GetEntityByPageForActivity($where, $orderby, $perpage, 1);
   	if($cardSpellData != null)
 	{
	 	for($i=0,$count=count($cardSpellData); $i<$count; $i++)
	 	{
	 		$cardSpellData[$i]['cardImagePath'] = $cardSpellData[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathCard').'s2/'.$cardSpellData[$i]['cardImagePath'] 
					: base_url().'kweb/images/kapic2.jpg';
			$cardSpellData[$i]['startDate'] = $cardSpellData[$i]['startDate'] != '' 
			 		? date('Y年m月d日', strtotime($cardSpellData[$i]['startDate'])) 
					: '';
			$cardSpellData[$i]['endDate'] = $cardSpellData[$i]['endDate'] != '' 
			 		? date('Y年m月d日', strtotime($cardSpellData[$i]['endDate'])) 
					: '';
	 	}
 	}
 	
 	
 	/////////////////////////////////////////////////////
	// 读取微博信息
    $where = array(
    	'state' => '1'
    );
    $order = 'addDateTime DESC';
	$perpage = '6';
  	$blogData = $this->MainFBlogMessagesModel->GetEntityViewByPage($where, $order, $perpage, 1);
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
	// 听说
	$where = array(
		'infoType' 	=> 'HearInfoIndex'
	);
	$orderby = 'orderNum desc';
 	$heari = $this->MainFBaseInfoHearIModel->GetEntityAll($where, $orderby);
	
 	
 	/////////////////////////////////////////////////////
	// 首页FLASH广告
	$where = array(
		'infoType' 	=> 'IndexFlashTop1'
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
					: base_url().'kweb/images/kadv9.jpg';
	 	}
 	}
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位1
 	$ad1 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdIndexAd1');
 	if($ad1 != null)
 	{
 		$ad1['value1'] = $ad1['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad1['value1'] : '';
 	}
 	 	
 	///////////////////////////////////////////////////////
 	// 读取广告位2
 	$ad2 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdIndexAd2');
 	if($ad2 != null)
 	{
 		$ad2['value1'] = $ad2['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad2['value1'] : '';
 	}
 	
	///////////////////////////////////////////////////////
 	// 读取广告位3
 	$ad3 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdIndexAd3');
 	if($ad3 != null)
 	{
 		$ad3['value1'] = $ad3['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad3['value1'] : '';
 	}
 	
	///////////////////////////////////////////////////////
 	// 读取广告位4
 	$ad4 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdIndexAd4');
 	if($ad4 != null)
 	{
 		$ad4['value1'] = $ad4['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad4['value1'] : '';
 	}


 	// 准备页面数据
	$data = array(
		'title' 			=> $this->config->item('Web_Title').' - 首页 '
		,'userId' 			=> $userId
		,'kLoginName' 		=> $kLoginName
		,'kPWD' 			=> $kPWD
		,'loginedUserInfo' 	=> $loginedUserInfo 
		,'annount'			=> $annount
		,'webStatistics' 	=> $webStatistics
		,'news1' 			=> $news1
		,'news2' 			=> $news2
		,'news3' 			=> $news3
		,'cardData'			=> $cardData
		,'cardSpellData'	=> $cardSpellData
		,'blogData'			=> $blogData
		,'heari'			=> $heari
		,'adinfo'			=> $adinfo
 		,'ad1'				=> $ad1
 		,'ad2'				=> $ad2
 		,'ad3'				=> $ad3
 		,'ad4'				=> $ad4
	);

	$master = new Master();	
	$master->headv2index();
	$master->topv2index($this, 'index');
	$this->load->view('kweb/index.php', $data);
	$master->footv2index();
 }
 
 function dologout()
 {
	 // 删除session
	 # WebSession::UnsetSession();
	 WebSession::SetUserSessionByOne('userId', '', $this);
	 
	 $this->index();
 } 
 
 ############################################################################
 # 新首页-20110919
 ############################################################################
 
 
 function index()
 {
 	// 准备页面所需要的参数
 	$userId = '';
 	$loginedUserInfo = array(
 		'nickname' 			=> ''
 		,'gradeName' 		=> ''
 		,'kPoints' 			=> ''
 		,'kState' 			=> ''
 		,'kCount' 			=> ''
 		,'kLookmeCount'		=> ''
 		,'webStatistics' 	=> null
 	);
 	
 	// 检查是否已登录
 	#var_dump(WebSession::IsUserLogined($this));
 	if(WebSession::IsUserLogined($this)) // 已登录
 	{
 		// 找到登录 会员信息
	 	$userId = WebSession::GetUserSessionByOne('userId', $this);
 	}
 	
 	/////////////////////////////////////////////////////
 	// 读取公告
 	// 注示原因，改成列表方式，非一条
 	//$annount = $this->MainFannountModel->GetEntityAnnount();
	$perpage = '6';
	$where = array(
		'newsType' 	=> 4
		,'state' 	=> 1
	);
	$orderby = 'orderNum desc';
 	$annount = $this->MainFshopnewsModel->GetEntityByPage($where, $orderby, $perpage, 1);
	

	/////////////////////////////////////////////////////
	// 打折快报
	$perpage = '6';
	$where = array(
		'newsType' 	=> 2
		,'state' 	=> 1
	);
	$orderby = 'orderNum desc';
 	$news2 = $this->MainFshopnewsModel->GetEntityByPage($where, $orderby, $perpage, 1);
	
 	
	/////////////////////////////////////////////////////
	// kashow兑换通知
	$perpage = '6';
	$where = array(
		'newsType' 	=> 3
		,'state' 	=> 1
	);
	$orderby = 'orderNum desc';
 	$news3 = $this->MainFshopnewsModel->GetEntityByPage($where, $orderby, $perpage, 1);
	
 	
  	/////////////////////////////////////////////////////
	// 读取卡 - 买卖卡
	$perpage = '6';
	$where = array(
		'state' 	=> 1
		,'infoType' => 'AdIndexSaleCard'
	);
	$orderby = 'orderNum desc';
 	$cardData = $this->MainFBaseInfoIFModel->GetEntityByPageForView($where, $orderby, $perpage, 1, 'View_WebBaseCardSale');
   	if($cardData != null)
 	{
	 	for($i=0,$count=count($cardData); $i<$count; $i++)
	 	{
	 		$cardData[$i]['cardImagePath'] = $cardData[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathFlashIndex').$cardData[$i]['cardImagePath'] 
					: base_url().'kweb/images/kadv9.jpg';
	 	}
 	}
 	
 	
	/////////////////////////////////////////////////////
	// 读取活动卡
	$where = array(
		'state	!=' 	=> 3
		,'infoType' => 'AdIndexSpellCard'
	);
	$orderby = 'orderNum desc';
	// select db
	$perpage = '6';
 	$cardSpellData = $this->MainFBaseInfoIFModel->GetEntityByPageForView($where, $orderby, $perpage, 1, 'View_WebBaseCardActivity');
   	if($cardSpellData != null)
 	{
	 	for($i=0,$count=count($cardSpellData); $i<$count; $i++)
	 	{
	 		$cardSpellData[$i]['cardImagePath'] = $cardSpellData[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathFlashIndex').$cardSpellData[$i]['cardImagePath'] 
					: base_url().'kweb/images/kadv9.jpg';
			$cardSpellData[$i]['startDate'] = $cardSpellData[$i]['startDate'] != '' 
			 		? date('m月d日', strtotime($cardSpellData[$i]['startDate'])) 
					: '';
			$cardSpellData[$i]['endDate'] = $cardSpellData[$i]['endDate'] != '' 
			 		? date('m月d日', strtotime($cardSpellData[$i]['endDate'])) 
					: '';
	 	}
 	}
 	
 	
 	/////////////////////////////////////////////////////
	// 读取微博信息
    $where = array(
    	'state' => '1'
    );
    $order = 'addDateTime DESC';
	$data['perpage'] = '6';
  	$blogData = $this->MainFBlogMessagesModel->GetEntityViewByPage($where, $order, $data['perpage'], 1);
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
	// 首页FLASH广告
	$where = array(
		'infoType' 	=> 'IndexFlashTop1'
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
					: base_url().'kweb/images/kadv9.jpg';
	 	}
 	}
	
  	///////////////////////////////////////////////////////
 	// 读取广告位1
 	$ad1 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdIndexAd1');
 	if($ad1 != null)
 	{
 		$ad1['value1'] = $ad1['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad1['value1'] : '';
 	}
 	
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位2
 	$ad2 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdIndexAd2');
 	if($ad2 != null)
 	{
 		$ad2['value1'] = $ad2['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad2['value1'] : '';
 	}

	///////////////////////////////////////////////////////
 	// 读取广告位3
 	$ad3 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdIndexAd3');
 	if($ad3 != null)
 	{
 		$ad3['value1'] = $ad3['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad3['value1'] : '';
 	}
 	
	///////////////////////////////////////////////////////
 	// 读取广告位4
 	$ad4 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdIndexAd4');
 	if($ad4 != null)
 	{
 		$ad4['value1'] = $ad4['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad4['value1'] : '';
 	}
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位5
 	$ad5 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdIndexAd5');
 	if($ad5 != null)
 	{
 		$ad5['value1'] = $ad5['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad5['value1'] : '';
 	}
 	
	///////////////////////////////////////////////////////
 	// 读取广告位6
 	$ad6 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdIndexAd6');
 	if($ad6 != null)
 	{
 		$ad6['value1'] = $ad6['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad6['value1'] : '';
 	}
 	
	///////////////////////////////////////////////////////
 	// 读取广告位7
 	$ad7 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdIndexAd7');
 	if($ad7 != null)
 	{
 		$ad7['value1'] = $ad7['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad7['value1'] : '';
 	}
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位8
 	$ad8 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdIndexAd8');
 	if($ad8 != null)
 	{
 		$ad8['value1'] = $ad8['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad8['value1'] : '';
 	}

  	///////////////////////////////////////////////////////
 	// 读取广告位9
 	$ad9 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdIndexAd9');
 	if($ad9 != null)
 	{
 		$ad9['value1'] = $ad9['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad9['value1'] : '';
 	}

  	///////////////////////////////////////////////////////
 	// 读取广告位10
 	$ad10 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdIndexAd10');
 	if($ad10 != null)
 	{
 		$ad10['value1'] = $ad10['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad10['value1'] : '';
 	}
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位11
 	$ad11 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdIndexAd11');
 	if($ad11 != null)
 	{
 		$ad11['value1'] = $ad11['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad11['value1'] : '';
 	}
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位12
 	$ad12 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdIndexAd12');
 	if($ad12 != null)
 	{
 		$ad12['value1'] = $ad12['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad12['value1'] : '';
 	}
 	
  	/////////////////////////////////////////////////////
	// 首页品牌
	$where = array(
		'infoType' 	=> 'AdIndexBrandAd'
	);
	$orderby = 'orderNum desc';
 	$adIndexBrandAd = $this->MainFBaseInfoIFModel->GetEntityByPage($where, $orderby, 20, 1);
 	#var_dump($adinfo);
   	if($adIndexBrandAd != null)
 	{
	 	for($i=0,$count=count($adIndexBrandAd); $i<$count; $i++)
	 	{
	 		$adIndexBrandAd[$i]['value1'] = $adIndexBrandAd[$i]['value1'] != '' 
			 		? $this->config->item('UpPathFlashIndex').$adIndexBrandAd[$i]['value1'] 
					: base_url().'kweb/images/kadv9.jpg';
	 	}
 	}
 	
 	/////////////////////////////////////////////////////
	// 首页合伙拼卡动画管理
	$where = array(
		'infoType' 	=> 'AdIndexSaleAd'
	);
	$orderby = 'orderNum desc';
 	$adIndexSaleAd  = $this->MainFBaseInfoIFModel->GetEntityByPage($where, $orderby, 5, 1);
 	#var_dump($adinfo);
   	if($adIndexSaleAd != null)
 	{
	 	for($i=0,$count=count($adIndexSaleAd); $i<$count; $i++)
	 	{
	 		$adIndexSaleAd[$i]['value1'] = $adIndexSaleAd[$i]['value1'] != '' 
			 		? $this->config->item('UpPathFlashIndex').$adIndexSaleAd[$i]['value1'] 
					: base_url().'kweb/images/kadv9.jpg';
	 	}
 	}
 	
 	/////////////////////////////////////////////////////
	// 首页有买有卖动画管理
	$where = array(
		'infoType' 	=> 'AdIndexSpellAd'
	);
	$orderby = 'orderNum desc';
 	$adIndexSpellAd = $this->MainFBaseInfoIFModel->GetEntityByPage($where, $orderby, 5, 1);
 	#var_dump($adinfo);
   	if($adIndexSpellAd != null)
 	{
	 	for($i=0,$count=count($adIndexSpellAd); $i<$count; $i++)
	 	{
	 		$adIndexSpellAd[$i]['value1'] = $adIndexSpellAd[$i]['value1'] != '' 
			 		? $this->config->item('UpPathFlashIndex').$adIndexSpellAd[$i]['value1'] 
					: base_url().'kweb/images/kadv9.jpg';
	 	}
 	}
 	
  	/////////////////////////////////////////////////////
	// 首页有买有卖卡管理
	$where = array(
		'infoType' 	=> 'AdIndexSaleCard'
	);
	$orderby = 'orderNum desc';
 	$adIndexSaleCard = $this->MainFBaseInfoIFModel->GetEntityByPage($where, $orderby, 6, 1);
 	#var_dump($adinfo);
   	if($adIndexSaleCard != null)
 	{
	 	for($i=0,$count=count($adIndexSaleCard); $i<$count; $i++)
	 	{
	 		$adIndexSaleCard[$i]['value1'] = $adIndexSaleCard[$i]['value1'] != '' 
			 		? $this->config->item('UpPathFlashIndex').$adIndexSaleCard[$i]['value1'] 
					: base_url().'kweb/images/kadv9.jpg';
	 	}
 	}
 	
 	/////////////////////////////////////////////////////
	// 首页合伙拼卡卡管理
	$where = array(
		'infoType' 	=> 'AdIndexSpellCard'
	);
	$orderby = 'orderNum desc';
 	$adIndexSpellCard = $this->MainFBaseInfoIFModel->GetEntityByPage($where, $orderby, 6, 1);
 	#var_dump($adinfo);
   	if($adIndexSpellCard != null)
 	{
	 	for($i=0,$count=count($adIndexSpellCard); $i<$count; $i++)
	 	{
	 		$adIndexSpellCard[$i]['value1'] = $adIndexSpellCard[$i]['value1'] != '' 
			 		? $this->config->item('UpPathFlashIndex').$adIndexSpellCard[$i]['value1'] 
					: base_url().'kweb/images/kadv9.jpg';
	 	}
 	}

 	
 	/////////////////////////////////////////////////////
	// 新加入会员
	$perpage = '7';
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
 	}
 	
  	/////////////////////////////////////////////////////
	// 有趣的人
	$perpage = '5';
	$where = array(
		'wbid !=' => ''
	);
	$orderby = 'orderNum desc';
 	$ppUserInfo = $this->MainFUserInfoIndexmodel->GetEntityByPage($where, $orderby, $perpage, 1);
 	#var_dump($ppUserInfo);
   	if($ppUserInfo != null)
 	{
	 	for($i=0,$count=count($ppUserInfo); $i<$count; $i++)
	 	{
	 		$ppUserInfo[$i]['kAvatarImage'] = $ppUserInfo[$i]['kAvatarImage'] != '' 
		 		? $this->config->item('UpPathAvatar').'s1/'.$ppUserInfo[$i]['kAvatarImage'] 
				: base_url().'kweb/images/kapic11.jpg';
			if($this->TKUserFriendsModel->CheckIsMyFriend($userId, $ppUserInfo[$i]['id']))
			{
				$ppUserInfo[$i]['kPWD'] = '1';
			}
			else 
			{
				$ppUserInfo[$i]['kPWD'] = '0';
			}
	 	}
 	}
 	

  	/////////////////////////////////////////////////////
	// 获取最新问卷
	$where = array(
		'state' 	=> '1'
	);
	$orderby = 'id desc';
 	$wjP = $this->MainFWJProblemModel->GetEntityByPage($where, $orderby, 1, 1);
 	#var_dump(count($wjP));
 	$wjA = null;
 	if($wjP != null && count($wjP)>0)
 	{
		$where = array(
			'problemId' 	=> $wjP[0]['id']
		);
		$orderby = 'orderNum desc';
	 	$wjA = $this->MainFWJAnserModel->GetEntityAll($where, $orderby);
	 	#var_dump($wjA);
 	}
 	
	
 	// 准备页面数据
	$data = array(
		'title' 			=> $this->config->item('Web_Title').' - 首页 '
		,'userId' 			=> $userId
		,'annount'			=> $annount
		,'news3'			=> $news3
		,'news2'			=> $news2
		,'cardSpellData'	=> $cardSpellData
		,'cardData'			=> $cardData
		,'blogData'			=> $blogData
		,'adinfo'			=> $adinfo
		,'ad1'				=> $ad1
		,'ad2'				=> $ad2
		,'ad3'				=> $ad3
		,'ad4'				=> $ad4
		,'ad5'				=> $ad5
		,'ad6'				=> $ad6
		,'ad7'				=> $ad7
		,'ad8'				=> $ad8
		,'ad9'				=> $ad9
		,'ad10'				=> $ad10
		,'ad11'				=> $ad11
		,'ad12'				=> $ad12
		,'adIndexBrandAd'	=> $adIndexBrandAd
		,'adIndexSaleAd'	=> $adIndexSaleAd
		,'adIndexSpellAd'	=> $adIndexSpellAd 
		,'adIndexSaleCard'	=> $adIndexSaleCard 
		,'adIndexSpellCard'	=> $adIndexSpellCard
		,'newUserInfo'		=> $newUserInfo
		,'wjP'				=> $wjP
		,'wjA'				=> $wjA
		,'ppUserInfo'		=> $ppUserInfo
		
	);

	$master = new Master();	
	$master->headv2index();
	$master->topv2index($this, 'index');
	$this->load->view('kweb/indexv2.php', $data);
	
	$master->popMaskInit($this);
	$master->popMaskBlogMsg($this);
	
	$master->footv2index();
	
	
 }
 
 function dowj()
 {
 	 // 恢复form数据
	$formdata = array(
		'anserId'		=> $this->input->post('aid')
		,'problemId' 	=> $this->input->post('pid')
	);
	
	/////////////////////////////////////////////////////
	// 问卷计数
 	$wjanser = $this->MainFWJAnserModel->GetEntityById($formdata['anserId']);
 	#var_dump($wjanser);
   	if($wjanser != null)
 	{
	 	$wjanser['ccount'] = $wjanser['ccount']+1;
 	}
 	$result = $this->MainFWJAnserModel->Update($wjanser);

 	
 	$action = new Action();
	$dataType = '';
	$status = true;
	$message = '保存成功';
	$info = '1';
	$action -> ajaxReturn($info,$message,$status,$dataType);
	#var_dump($message);
	
 } 
 
}
?>