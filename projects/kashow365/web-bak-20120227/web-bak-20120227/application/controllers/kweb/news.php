<?php
class News extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  $this->load->library('session');
  
  require_once 'application/controllers/kweb/master.php';
  require_once 'kadmin/businessentity/websession.php';
  require_once 'kadmin/businessentity/tools/string.class.php';
  require_once 'register.php';
  require_once 'kadmin/public/kindeditor-3.5.5-zh_CN/php/JSON.php';
  
  $this->load->model('kadmin/kuser/mainfuserinfo_model','MainFUserInfoModel');
  $this->load->model('kadmin/news/mainfdistrict_model','MainFdistrictModel');
  $this->load->model('kadmin/news/mainfshopnews_model','MainFshopnewsModel');
  $this->load->model('kadmin/news/mainfshop_model','MainFshopModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoad_model','MainFBaseInfoAdModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoheari_model','MainFBaseInfoHearIModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfo_model','MainFBaseInfoModel');
  $this->load->model('kadmin/news/mainfshop_model','MainFshopModel');
  
 }

 function index()
 {

 }
 
 /* 最新活动 */
 function activity()
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 最新活动 '
		,'districtId' 	=> ''
		,'urbanId' 		=> ''
		,'shopId' 		=> ''
		,'districtRows' => null
		,'newsData'		=> null
		,'total'		=> 0
		,'perpage'		=> 1
		,'shopData1' 	=> null
		,'shopData2'	=> null
		,'ad1'			=> null
		,'ad2'			=> null
	);
	
	// 读取市区
	$districtRows = $this->MainFdistrictModel->GetEntityAll();
	$data['districtRows'] = $districtRows;
	
	// 读取新闻
	
	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$districtId = '';
 	if( isset($_REQUEST['districtId']) )
 		$districtId = trim($_REQUEST['districtId']);
 	$urbanId = '';
 	if( isset($_REQUEST['urbanId']) )
 		$urbanId = trim($_REQUEST['urbanId']);
	$shopId = '';
 	if( isset($_REQUEST['shopId']) )
 		$shopId = trim($_REQUEST['shopId']);
 	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);
 	#var_dump($districtId);
 	
 	$data['districtId'] = $districtId;
 	$data['urbanId'] = $urbanId;
 	$data['shopId'] = $shopId;
 	
 	
 	/////////////////////////////////////////////////////
 	// where 
  	$where = 'newsType` = 1 and `state`=1'; // 搜索 - 最新活动
 	if($shopId != '')
	{
		$where .= ' and `shopId`='.$shopId;
	}
	if($districtId != '')
	{
		$where .= ' and `districtId`='.$districtId;
	}
 	if($urbanId != '')
	{
		$where .= ' and `urbanId`='.$urbanId;
	}
	#var_dump($where);
	
	// order by 
 	$orderby = 'orderNum DESC, id DESC ';

 	/////////////////////////////////////////////////////
 	// get DB entity Count
	$totalRowsCount = $this->MainFshopnewsModel->GetEntityCount($where);
	#var_dump($totalRowsCount);
	#var_dump($where);
	#var_dump($orderby);
	/////////////////////////////////////////////////////
	// select db
	$perpage = '40';
 	$newsData = $this->MainFshopnewsModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
 	$data['newsData'] = $newsData;
 	$data['perpage'] = $perpage;
 	$data['total'] = $totalRowsCount;
 	
 	/////////////////////////////
 	// 北京商场推荐
	// select db
	$orderby = 'reActivityOrderNum desc';
 	$shopData = $this->MainFshopModel->GetEntityByPage('', $orderby, 5, 1);
 	$data['shopData1'] = $shopData;
 	#var_dump($shopData);
 	
 	$where = 'id` not in (select id from (select id from `TKShopping` order by reActivityOrderNum desc  limit 5) as t)';
 	$orderby = 'id desc';
 	$shopData = $this->MainFshopModel->GetEntityByPage($where, $orderby, 15, 1);
 	$data['shopData2'] = $shopData;
	
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位1
 	$ad1 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdActivityAd1');
 	if($ad1 != null)
 	{
 		$ad1['value1'] = $ad1['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad1['value1'] : '';
 	}
 	$data['ad1'] = $ad1;
 	
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位2
 	$ad2 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdActivityAd2');
 	if($ad2 != null)
 	{
 		$ad2['value1'] = $ad2['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad2['value1'] : '';
 	}
 	$data['ad2'] = $ad2;
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/news/activity.php', $data);
	
	$master->footv2index();
 }
 
 function activitycontent($id='')
 { 	

	$data = array(
		'title' => $this->config->item('Web_Title').' - 最新活动 '
		,'newsData' 	=> null
		,'newsMoreData'	=> null
		,'newUserInfo'	=> null
		,'ad1'			=> null
	);
	
	// 入口判断
	if($id == '')
	{
		$register = new Register();
 		$register->_PublicError($this, '最新活动不存在',site_url('index'));
 		return;
	}
	
	// 读取当前新闻
	$newsData = $this->MainFshopnewsModel->GetEntityById($id);
 	$data['newsData'] = $newsData;
 	#var_dump($newsData);
 	$data['title'] = $newsData['newsTitle'].' - '.$this->config->item('Web_Title');
 	
 	// 近期活动
	$perpage = '6';
	$where  = array(
		'id !=' 	=> $id
		,'newsType' => 1
		,'state' 	=> 1
	);
	$orderby = 'orderNum desc,id desc';
 	$newsMoreData = $this->MainFshopnewsModel->GetEntityByPage($where, $orderby, $perpage, 1);
 	$data['newsMoreData'] = $newsMoreData;
 	
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
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位3
 	$ad1 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdActivityAd3');
 	if($ad1 != null)
 	{
 		$ad1['value1'] = $ad1['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad1['value1'] : '';
 	}
 	$data['ad1'] = $ad1;
 	

 	
 	// 读取页面
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/news/activitycontent.php', $data);
	
	$master->footv2index();
 }
 
 /* End 最新活动 */
 

 /* 打折快报 */
 function discount()
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 打折快报 '
		,'districtId' 	=> ''
		,'urbanId' 		=> ''
		,'shopId' 		=> ''
		,'districtRows' => null
		,'newsData'		=> null
		,'total'		=> 0
		,'perpage'		=> 1
		,'shopData1' 	=> null
		,'shopData2'	=> null
		,'ad1'			=> null
		,'ad2'			=> null
	);
	
	// 读取市区
	$districtRows = $this->MainFdistrictModel->GetEntityAll();
	$data['districtRows'] = $districtRows;
	
	// 读取新闻
	
	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$districtId = '';
 	if( isset($_REQUEST['districtId']) )
 		$districtId = trim($_REQUEST['districtId']);
 	$urbanId = '';
 	if( isset($_REQUEST['urbanId']) )
 		$urbanId = trim($_REQUEST['urbanId']);
	$shopId = '';
 	if( isset($_REQUEST['shopId']) )
 		$shopId = trim($_REQUEST['shopId']);
 	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);
 	#var_dump($districtId);
 	
 	$data['districtId'] = $districtId;
 	$data['urbanId'] = $urbanId;
 	$data['shopId'] = $shopId;
 	
 	
 	/////////////////////////////////////////////////////
 	// where 
  	$where = 'newsType` = 2 and `state`=1'; // 搜索 - 打折快报
 	if($shopId != '')
	{
		$where .= ' and `shopId`='.$shopId;
	}
	if($districtId != '')
	{
		$where .= ' and `districtId`='.$districtId;
	}
 	if($urbanId != '')
	{
		$where .= ' and `urbanId`='.$urbanId;
	}
	#var_dump($where);
	
	// order by 
 	$orderby = 'orderNum DESC, id DESC ';

 	/////////////////////////////////////////////////////
 	// get DB entity Count
	$totalRowsCount = $this->MainFshopnewsModel->GetEntityCount($where);
	#var_dump($totalRowsCount);
	#var_dump($where);
	#var_dump($orderby);
	/////////////////////////////////////////////////////
	// select db
	$perpage = '40';
 	$newsData = $this->MainFshopnewsModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
 	$data['newsData'] = $newsData;
 	$data['perpage'] = $perpage;
 	$data['total'] = $totalRowsCount;
 	
 	/////////////////////////////
 	// 北京商场推荐
	// select db
	$orderby = 'reActivityOrderNum desc';
 	$shopData = $this->MainFshopModel->GetEntityByPage('', $orderby, 5, 1);
 	$data['shopData1'] = $shopData;
 	#var_dump($shopData);
 	
 	$where = 'id` not in (select id from (select id from `TKShopping` order by reActivityOrderNum desc  limit 5) as t)';
 	$orderby = 'id desc';
 	$shopData = $this->MainFshopModel->GetEntityByPage($where, $orderby, 15, 1);
 	$data['shopData2'] = $shopData;
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位1
 	$ad1 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdDiscountAd1');
 	if($ad1 != null)
 	{
 		$ad1['value1'] = $ad1['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad1['value1'] : '';
 	}
 	$data['ad1'] = $ad1;
 	
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位2
 	$ad2 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdDiscountAd2');
 	if($ad2 != null)
 	{
 		$ad2['value1'] = $ad2['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad2['value1'] : '';
 	}
 	$data['ad2'] = $ad2;
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/news/discount.php', $data);
	
	$master->footv2index();
 }
 
 function discountcontent($id='')
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 打折快报 '
		,'newsData' 	=> null
		,'newsMoreData'	=> null
		,'newUserInfo'	=> null
		,'ad1'			=> null
	);
	
	// 入口判断
	if($id == '')
	{
		$register = new Register();
 		$register->_PublicError($this, '最新活动不存在',site_url('index'));
 		return;
	}
	
	// 读取当前新闻
	$newsData = $this->MainFshopnewsModel->GetEntityById($id);
 	$data['newsData'] = $newsData;
 	#var_dump($newsData);
 	$data['title'] = $newsData['newsTitle'].' - '.$this->config->item('Web_Title');
 	
 	
 	// 近期活动
	$perpage = '6';
	$where  = array(
		'id !=' => $id
		,'newsType' => 2
		,'state' 	=> 1
	);
	$orderby = 'orderNum desc,id desc';
 	$newsMoreData = $this->MainFshopnewsModel->GetEntityByPage($where, $orderby, $perpage, 1);
 	$data['newsMoreData'] = $newsMoreData;
	
 	
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
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位3
 	$ad1 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdDiscountAd3');
 	if($ad1 != null)
 	{
 		$ad1['value1'] = $ad1['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad1['value1'] : '';
 	}
 	$data['ad1'] = $ad1;
 	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/news/discountcontent.php', $data);
	
	$master->footv2index();
 }
 
 /* End 打折快报 */
 
 
 
 
 /* 网站公告 */
 function annount()
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 网站公告 '
		,'newsData'		=> null
		,'total'		=> 0
		,'perpage'		=> 1
		,'shopData1' 	=> null
		,'shopData2'	=> null
		,'ad1'			=> null
		,'ad2'			=> null
	);
		
	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);
 	#var_dump($districtId);
 	
 	
 	
 	/////////////////////////////////////////////////////
 	// where 
  	$where = 'newsType` = 4 and `state`=1'; // 搜索 - 网站公告
	#var_dump($where);
	
	// order by 
 	$orderby = 'orderNum DESC, id DESC ';

 	/////////////////////////////////////////////////////
 	// get DB entity Count
	$totalRowsCount = $this->MainFshopnewsModel->GetEntityCount($where);
	#var_dump($totalRowsCount);
	#var_dump($where);
	#var_dump($orderby);
	/////////////////////////////////////////////////////
	// select db
	$perpage = '40';
 	$newsData = $this->MainFshopnewsModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
 	$data['newsData'] = $newsData;
 	$data['perpage'] = $perpage;
 	$data['total'] = $totalRowsCount;
 	
 	/////////////////////////////
 	// 北京商场推荐
	// select db
	$orderby = 'reActivityOrderNum desc';
 	$shopData = $this->MainFshopModel->GetEntityByPage('', $orderby, 5, 1);
 	$data['shopData1'] = $shopData;
 	#var_dump($shopData);
 	
 	$where = 'id` not in (select id from (select id from `TKShopping` order by reActivityOrderNum desc  limit 5) as t)';
 	$orderby = 'id desc';
 	$shopData = $this->MainFshopModel->GetEntityByPage($where, $orderby, 15, 1);
 	$data['shopData2'] = $shopData;
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位1
 	$ad1 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdDiscountAd1');
 	if($ad1 != null)
 	{
 		$ad1['value1'] = $ad1['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad1['value1'] : '';
 	}
 	$data['ad1'] = $ad1;
 	
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位2
 	$ad2 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdDiscountAd2');
 	if($ad2 != null)
 	{
 		$ad2['value1'] = $ad2['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad2['value1'] : '';
 	}
 	$data['ad2'] = $ad2;
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/news/annount.php', $data);
	
	$master->footv2index();
 }
 
 function annountcontent($id='')
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 网站公告 '
		,'newsData' 	=> null
		,'newsMoreData'	=> null
		,'newUserInfo'	=> null
		,'ad1'			=> null
	);
	
	// 入口判断
	if($id == '')
	{
		$register = new Register();
 		$register->_PublicError($this, '网站公告不存在',site_url('index'));
 		return;
	}
	
	// 读取当前新闻
	$newsData = $this->MainFshopnewsModel->GetEntityById($id);
 	$data['newsData'] = $newsData;
 	#var_dump($newsData);
 	$data['title'] = $newsData['newsTitle'].' - '.$this->config->item('Web_Title');
 	
 	
 	// 近期活动
	$perpage = '6';
	$where  = array(
		'id !=' => $id
		,'newsType' => 4
		,'state' 	=> 1
	);
	$orderby = 'orderNum desc,id desc';
 	$newsMoreData = $this->MainFshopnewsModel->GetEntityByPage($where, $orderby, $perpage, 1);
 	$data['newsMoreData'] = $newsMoreData;
	
 	
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
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位3
 	$ad1 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdDiscountAd3');
 	if($ad1 != null)
 	{
 		$ad1['value1'] = $ad1['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad1['value1'] : '';
 	}
 	$data['ad1'] = $ad1;
 	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/news/annountcontent.php', $data);
	
	$master->footv2index();
 }
 
 /* End 网站公告 */
 
 
 
 /* 兑换通知 */
 function conversion()
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 兑换通知  '
		,'districtId' 	=> ''
		,'urbanId' 		=> ''
		,'shopId' 		=> ''
		,'districtRows' => null
		,'newsData'		=> null
		,'total'		=> 0
		,'perpage'		=> 1
		,'shopData1' 	=> null
		,'shopData2'	=> null
		,'ad1'			=> null
		,'ad2'			=> null
	);
	
	// 读取市区
	$districtRows = $this->MainFdistrictModel->GetEntityAll();
	$data['districtRows'] = $districtRows;
	
	// 读取新闻
	
	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$districtId = '';
 	if( isset($_REQUEST['districtId']) )
 		$districtId = trim($_REQUEST['districtId']);
 	$urbanId = '';
 	if( isset($_REQUEST['urbanId']) )
 		$urbanId = trim($_REQUEST['urbanId']);
	$shopId = '';
 	if( isset($_REQUEST['shopId']) )
 		$shopId = trim($_REQUEST['shopId']);
 	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);
 	#var_dump($districtId);
 	
 	$data['districtId'] = $districtId;
 	$data['urbanId'] = $urbanId;
 	$data['shopId'] = $shopId;
 	
 	
 	/////////////////////////////////////////////////////
 	// where 
  	$where = 'newsType` = 3 and `state`=1'; // 搜索 - 兑换通知
 	if($shopId != '')
	{
		$where .= ' and `shopId`='.$shopId;
	}
	if($districtId != '')
	{
		$where .= ' and `districtId`='.$districtId;
	}
 	if($urbanId != '')
	{
		$where .= ' and `urbanId`='.$urbanId;
	}
	#var_dump($where);
	
	// order by 
 	$orderby = 'orderNum DESC, id DESC ';

 	/////////////////////////////////////////////////////
 	// get DB entity Count
	$totalRowsCount = $this->MainFshopnewsModel->GetEntityCount($where);
	#var_dump($totalRowsCount);
	#var_dump($where);
	#var_dump($orderby);
	/////////////////////////////////////////////////////
	// select db
	$perpage = '40';
 	$newsData = $this->MainFshopnewsModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
 	$data['newsData'] = $newsData;
 	$data['perpage'] = $perpage;
 	$data['total'] = $totalRowsCount;
 	
 	/////////////////////////////
 	// 北京商场推荐
	// select db
	$orderby = 'reActivityOrderNum desc';
 	$shopData = $this->MainFshopModel->GetEntityByPage('', $orderby, 5, 1);
 	$data['shopData1'] = $shopData;
 	#var_dump($shopData);
 	
 	$where = 'id` not in (select id from (select id from `TKShopping` order by reActivityOrderNum desc  limit 5) as t)';
 	$orderby = 'id desc';
 	$shopData = $this->MainFshopModel->GetEntityByPage($where, $orderby, 15, 1);
 	$data['shopData2'] = $shopData;
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位1
 	$ad1 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdConversionAd1');
 	if($ad1 != null)
 	{
 		$ad1['value1'] = $ad1['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad1['value1'] : '';
 	}
 	$data['ad1'] = $ad1;
 	
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位2
 	$ad2 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdConversionAd2');
 	if($ad2 != null)
 	{
 		$ad2['value1'] = $ad2['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad2['value1'] : '';
 	}
 	$data['ad2'] = $ad2;
 	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/news/conversion.php', $data);
	
	$master->footv2index();
 }
 
 function conversioncontent($id='')
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 兑换通知  '
		,'newsData' 	=> null
		,'newsMoreData'	=> null
		,'newUserInfo'	=> null
		,'ad1'			=> null
	);
	
	// 入口判断
	if($id == '')
	{
		$register = new Register();
 		$register->_PublicError($this, '最新活动不存在',site_url('index'));
 		return;
	}
	
	// 读取当前新闻
	$newsData = $this->MainFshopnewsModel->GetEntityById($id);
 	$data['newsData'] = $newsData;
 	#var_dump($newsData);
 	$data['title'] = $newsData['newsTitle'].' - '.$this->config->item('Web_Title');
 	
 	// 近期活动
	$perpage = '6';
	$where  = array(
		'id !=' => $id
		,'newsType'	=> 3
		,'state' 	=> 1
	);
	$orderby = 'orderNum desc,id desc';
 	$newsMoreData = $this->MainFshopnewsModel->GetEntityByPage($where, $orderby, $perpage, 1);
 	$data['newsMoreData'] = $newsMoreData;
	
 	
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
 	
 	///////////////////////////////////////////////////////
 	// 读取广告位3
 	$ad1 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdConversionAd3');
 	if($ad1 != null)
 	{
 		$ad1['value1'] = $ad1['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad1['value1'] : '';
 	}
 	$data['ad1'] = $ad1;
 	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/news/conversioncontent.php', $data);
	
	$master->footv2index();
 }
 
 /* End 兑换通知 */

 function doupphoto()
 {
 	$uploadedImage = '';
 	#var_dump($_FILES);
	/////////////////////////////////////////////////////////////////////////////
	// 上传文件
	// $uploadConfig['upload_path'] = '.'.$this->config->item('UpPathNews');
	$uploadConfig['upload_path'] = $this->config->item('FilePathUpPathNews');
  	$uploadConfig['allowed_types'] = 'gif|jpg|png';
	$uploadConfig['max_size'] = $this->config->item('upload_maxSize');
	$uploadConfig['max_width']  = '1024';
	$uploadConfig['max_height']  = '768';
	$uploadConfig['encrypt_name']  = true;
	
	#$this->alert('1', $uploadConfig);
	#return;
	#var_dump($uploadConfig);
	$this->load->library('upload', $uploadConfig);
	if ( ! $this->upload->do_upload())
	{
	    $uploadError = array('error' => $this->upload->display_errors());
		// 出错恢复form数据并返回
		$uploadError['error'] = str_replace('<p>','', $uploadError['error']);
		$uploadError['error'] = str_replace('</p>','', $uploadError['error']);
		$this->alert(1, $uploadError['error']);
		return;
	} 
	else
	{
	   $uploadedData = array('upload_data' => $this->upload->data());
	   $uploadedImage = $uploadedData["upload_data"]['file_name'];
	} 

	#$this->RestoreFormDate($formdata);
	$this->alert(0, $this->config->item('UpPathNews').$uploadedImage);
 }
 
 function dofilemanager()
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$path = '';
 	if( isset($_REQUEST['path']) )
 		$path = trim($_REQUEST['path']);
 	$order = '';
 	if( isset($_REQUEST['order']) )
 		$order = trim($_REQUEST['order']);
 	#var_dump($pageIndex);
 	
 		
    //根目录路径，可以指定绝对路径，比如 /var/www/attached/
	$root_path = $this->config->item('FilePathUpPathNews');
	//根目录URL，可以指定绝对路径，比如 http://www.yoursite.com/attached/
	$root_url = $this->config->item('HTTPUpPathNews');
	//图片扩展名
	$ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
	
	//根据path参数，设置各路径和URL
	if (empty($path)) {
		$current_path = realpath($root_path) . '/';
		$current_url = $root_url;
		$current_dir_path = '';
		$moveup_dir_path = '';
	} else {
		$current_path = realpath($root_path) . '/' . $path;
		$current_url = $root_url . $path;
		$current_dir_path = $path;
		$moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
	}

	//排序形式，name or size or type
	$order = empty($order) ? 'name' : strtolower($order);
	#var_dump($order);
	
	//不允许使用..移动到上一级目录
	if (preg_match('/\.\./', $current_path)) {
		echo 'Access is not allowed.';
		exit;
	}
	//最后一个字符不是/
	if (!preg_match('/\/$/', $current_path)) {
		echo 'Parameter is not valid.';
		exit;
	}
	//目录不存在或不是目录
	if (!file_exists($current_path) || !is_dir($current_path)) {
		echo 'Directory does not exist.';
		exit;
	}
	
	//遍历目录取得文件信息
	$file_list = array();
	#var_dump($current_path);
	if ($handle = opendir($current_path)) {
		$i = 0;
		while (false !== ($filename = readdir($handle))) {
			#var_dump($filename{0});
			if ($filename{0} == '.') 
				continue;

			$file = $current_path . $filename;
			if (is_dir($file)) {
				$file_list[$i]['is_dir'] = true; //是否文件夹
				$file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
				$file_list[$i]['filesize'] = 0; //文件大小
				$file_list[$i]['is_photo'] = false; //是否图片
				$file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
			} else {
				$file_list[$i]['is_dir'] = false;
				$file_list[$i]['has_file'] = false;
				$file_list[$i]['filesize'] = filesize($file);
				$file_list[$i]['dir_path'] = '';
				$file_ext = strtolower(array_pop(explode('.', trim($file))));
				$file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
				$file_list[$i]['filetype'] = $file_ext;
			}
			$file_list[$i]['filename'] = $filename; //文件名，包含扩展名
			$file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
			$i++;
		}
		closedir($handle);
	}
	#var_dump($file_list);
	
	#usort($file_list, '$this->cmp_func');
	
	$result = array();
	//相对于根目录的上一级目录
	$result['moveup_dir_path'] = $moveup_dir_path;
	//相对于根目录的当前目录
	$result['current_dir_path'] = $current_dir_path;
	//当前目录的URL
	$result['current_url'] = $current_url;
	//文件数
	$result['total_count'] = count($file_list);
	//文件列表数组
	$result['file_list'] = $file_list;
	
	//输出JSON字符串
	header('Content-type: application/json; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode($result);
	
 }
 
 //排序
 function cmp_func($a, $b) {
	global $order;
	if ($a['is_dir'] && !$b['is_dir']) {
		return -1;
	} else if (!$a['is_dir'] && $b['is_dir']) {
		return 1;
	} else {
		if ($order == 'size') {
			if ($a['filesize'] > $b['filesize']) {
				return 1;
			} else if ($a['filesize'] < $b['filesize']) {
				return -1;
			} else {
				return 0;
			}
		} else if ($order == 'type') {
			return strcmp($a['filetype'], $b['filetype']);
		} else {
			return strcmp($a['filename'], $b['filename']);
		}
	}
 }
 
 
 function alert($error, $msg) {
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	if($error==0)
		echo $json->encode(array('error' => $error, 'url' => $msg));
	else
		echo $json->encode(array('error' => $error, 'message' => $msg));
	exit;
 }
 
}
?>