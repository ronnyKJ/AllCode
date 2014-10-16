<?php
class Gift extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  $this->load->library('session');
  
  require_once 'application/controllers/kweb/master.php';
  require_once 'kadmin/businessentity/websession.php';
  require_once 'kadmin/businessentity/tools/action.php';
  require_once 'kadmin/businessentity/tools/string.class.php';
  
  $this->load->model('kadmin/kuser/mainfuserinfo_model','MainFUserInfoModel');
  $this->load->model('kadmin/kcard/MainfCardForExchange_model','MainfCardForExchangeModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoad_model','MainFBaseInfoAdModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoheari_model','MainFBaseInfoHearIModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfo_model','MainFBaseInfoModel');
  $this->load->model('kadmin/news/mainfshop_model','MainFshopModel');
 }

 function index()
 {
	$data = array(
		'title' => $this->config->item('Web_Title').' - 礼尚往来'
		,'card1'	=> null
		,'card2'	=> null
		,'card3'	=> null
		,'card4'	=> null
		,'card0'	=> null
		,'ad1'		=> null
 		,'ad2'		=> null
	);
	
	/////////////////////////////////////////////////////
	// 赞助商区域
	$perpage = '5';
	$where = array(
		'isSponsors' 	=> 1
		,'state' 		=> 1
	);
	$orderby = 'orderNum desc';
 	$card0 = $this->MainfCardForExchangeModel->GetEntityByPage($where, $orderby, $perpage, 1);
    if($card0 != null)
 	{
	 	for($i=0,$count=count($card0); $i<$count; $i++)
	 	{
	 		$card0[$i]['cardImagePath'] = $card0[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathCard').'s2/'.$card0[$i]['cardImagePath'] 
					: base_url().'kweb/images/kapic2.jpg';
	 	}
 	}
 	$data['card0'] = $card0;
 	
 	/////////////////////////////////////////////////////
	// 100KS兑换区
	$perpage = '5';
	$where = array(
		'exchangPoint' 	=> 100
		,'state' 		=> 1
	);
	$orderby = 'addDateTime desc';
 	$card1 = $this->MainfCardForExchangeModel->GetEntityByPage($where, $orderby, $perpage, 1);
    if($card1 != null)
 	{
	 	for($i=0,$count=count($card1); $i<$count; $i++)
	 	{
	 		$card1[$i]['cardImagePath'] = $card1[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathCard').'s2/'.$card1[$i]['cardImagePath'] 
					: base_url().'kweb/images/kapic2.jpg';
	 	}
 	}
 	$data['card1'] = $card1;
 	
	/////////////////////////////////////////////////////
	// 300KS兑换区
	$perpage = '5';
	$where = array(
		'exchangPoint' 	=> 300
		,'state' 		=> 1
	);
	$orderby = 'addDateTime desc';
 	$card2 = $this->MainfCardForExchangeModel->GetEntityByPage($where, $orderby, $perpage, 1);
    if($card2 != null)
 	{
	 	for($i=0,$count=count($card2); $i<$count; $i++)
	 	{
	 		$card2[$i]['cardImagePath'] = $card2[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathCard').'s2/'.$card2[$i]['cardImagePath'] 
					: base_url().'kweb/images/kapic2.jpg';
	 	}
 	}
 	$data['card2'] = $card2;
 	
 	/////////////////////////////////////////////////////
	// 500KS兑换区
	$perpage = '5';
	$where = array(
		'exchangPoint' 	=> 500
		,'state' 		=> 1
	);
	$orderby = 'addDateTime desc';
 	$card3 = $this->MainfCardForExchangeModel->GetEntityByPage($where, $orderby, $perpage, 1);
    if($card3 != null)
 	{
	 	for($i=0,$count=count($card3); $i<$count; $i++)
	 	{
	 		$card3[$i]['cardImagePath'] = $card3[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathCard').'s2/'.$card3[$i]['cardImagePath'] 
					: base_url().'kweb/images/kapic2.jpg';
	 	}
 	}
 	$data['card3'] = $card3;
 	
 	/////////////////////////////////////////////////////
	// 1000KS兑换区
	$perpage = '5';
	$where = array(
		'exchangPoint' 	=> 1000
		,'state' 		=> 1
	);
	$orderby = 'addDateTime desc';
 	$card4 = $this->MainfCardForExchangeModel->GetEntityByPage($where, $orderby, $perpage, 1);
    if($card4 != null)
 	{
	 	for($i=0,$count=count($card4); $i<$count; $i++)
	 	{
	 		$card4[$i]['cardImagePath'] = $card4[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathCard').'s2/'.$card4[$i]['cardImagePath'] 
					: base_url().'kweb/images/kapic8.jpg';
	 	}
 	}
 	$data['card4'] = $card4;
 	
  	///////////////////////////////////////////////////////
 	// 读取广告位1
 	$ad1 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdGiftAd1');
 	if($ad1 != null)
 	{
 		$ad1['value1'] = $ad1['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad1['value1'] : '';
 	}
 	$data['ad1'] = $ad1;
 	
	 ///////////////////////////////////////////////////////
 	// 读取广告位2
 	$ad2 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdGiftAd2');
 	if($ad2 != null)
 	{
 		$ad2['value1'] = $ad2['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad2['value1'] : '';
 	}
 	$data['ad2'] = $ad2;
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this, 'gift');
	$this->load->view('kweb/gift/index.php', $data);

	$master->popMaskServices($this);
	$master->footv2index();
 }
 
 function view($id)
 {
  	// 读取卡信息
 	if($id == '')
 	{
 		$register = new Register();
 		$register->_PublicError($this, '卡不存在',site_url('member'));
 		return;
 	}
 	
 	$data = array(
		'title' => $this->config->item('Web_Title').' - 礼尚往来'
	    ,'id' 					=> $id
	    ,'name' 				=> ''
	 	,'cardType' 			=> ''
	 	,'cardUse' 				=> ''
	 	,'cardTtransactions'	=> ''
	 	,'districtName' 		=> ''
	 	,'urbanIdName' 			=> ''
	 	,'period' 				=> ''
	 	,'exchangPoint' 		=> ''
	 	,'surplusCount' 		=> '0'
	 	,'remarks' 				=> ''
	 	,'state' 				=> '1'
	 	,'orderNum' 			=> '0'
	 	,'isSponsors'			=> '0'
	 	,'cardImagePath'		=> ''
	    ,'userId' 			=> ''  
 	  
	);
	
   	// 获取session中的会员ID
 	$userId = WebSession::GetUserSessionByOne('userId', $this);
 	#var_dump($userId);
 	$data['userId'] = $userId;
 	
 	// DB操作
	$entity = $this->MainfCardForExchangeModel->GetEntityById($id);
	if($entity == null)
	{
		$register = new Register();
 		$register->_PublicError($this, '兑换卡不存在',site_url('member'));
 		return;
	}
	#var_dump($entity);
	$data['name'] 				= $entity['name'];
	$data['cardType'] 			= $entity['cardType'];
	$data['cardUse'] 			= $entity['cardUse'];
	$data['cardTtransactions'] 	= $entity['cardTtransactions'];
	$data['districtName'] 		= $entity['districtName'];
	$data['urbanName'] 			= $entity['urbanName'];
	$data['period'] 			= date('Y年m月d日',strtotime($entity['period']));
	$data['exchangPoint'] 		= $entity['exchangPoint'];
	$data['surplusCount'] 		= $entity['surplusCount'];
	$data['remarks'] 			= $entity['remarks'];
	$data['state'] 				= $entity['state'];
	$data['cardImagePath'] 		= $entity['cardImagePath'] != '' 
							 		? $this->config->item('UpPathCard').'s1/'.$entity['cardImagePath'] 
									: base_url().'kweb/images/kapic9.jpg';

 		
	// 绑定面面	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this, 'gift');
	
	$this->load->view('kweb/gift/view.php', $data);
	$master->popMaskInit($this);
	$master->popMaskExchange($this, $id, $data['exchangPoint']);
	$master->popMaskServices($this);
	
	$master->footv2index();
 }
 
 function doexchange()
 {
 	// 检查是否已登录
 	#var_dump(WebSession::IsUserLogined($this));
 	if(!WebSession::IsUserLogined($this)) // 未登录
 	{
 		// 进入登录页
 		$action = new Action();
		$dataType = '';
		$status = false;
		$message = '兑换卡失败登录超时';
		$info = current_url();
		$action -> ajaxReturn($info, $message,$status,$dataType);
		#var_dump($config);
 		return;
 	}
 	
 	// 获取session中的会员ID
 	$userId = WebSession::GetUserSessionByOne('userId', $this);
 	$data['userId'] = $userId;
 	#var_dump($userId);
 	if($userId=='')
 	{
 		// 进入登录页
 		$action = new Action();
		$dataType = '';
		$status = false;
		$message = '兑换卡失败登录超时';
		$info = current_url();
		$action -> ajaxReturn($info, $message,$status,$dataType);
		#var_dump($config);
 		return;
 	}
	
 	
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$cid = '';
 	if( isset($_REQUEST['cid']) )
 		$cid = trim($_REQUEST['cid']);
 		
 	#$cid = $this->input->post('cid');

 	// 恢复form数据
	$formdata = array(
		'userId' 		=> $userId
		,'cardId'		=> $cid
	);

	// DB - 加关注
	$kPoints = 0;
	$result = $this->MainfCardForExchangeModel->DoUserExchange($formdata, $kPoints);
	switch($result)
	{
		case '-1':
			$action = new Action();
			$dataType = '';
			$status = false;
			$message = '兑换不成功';
			$info = '抱歉您所兑换的卡已不存在，谢谢您的参与。';
			$action -> ajaxReturn($info,$message,$status,$dataType);
			break;
		case '-2':
			$action = new Action();
			$dataType = '';
			$status = false;
			$message = '兑换不成功';
			$info = '抱歉您所兑换的卡剩余为0，谢谢您的参与。';
			$action -> ajaxReturn($info,$message,$status,$dataType);
			break;
		case '-3':
			$action = new Action();
			$dataType = '';
			$status = false;
			$message = '兑换不成功';
			$info = '抱歉您的积分不够，请抓紧增长积分。';
			$action -> ajaxReturn($info,$message,$status,$dataType);
			break;
	}
	if($result != '1'){return;}
	#var_dump($result);
	

	// 得到会员当前积分
	$userInfoData = $this->MainFUserInfoModel->GetEntityByIdForView($userId);
	#var_dump($userInfoData['kPoints']);
 	
	// 返回ajax应答
	$action = new Action();
	$dataType = '';
	if($result != 0)
	{
		$status = true;
		$message = '兑换成功';
		$info = '恭喜您兑换成功，您的账户余额为 '. $userInfoData['kPoints']. ' Ks，'
				.'您兑换的礼品将由客服人员在一周之内	与您取得联系或邮件发送给您领取办法，请及时查收邮件。';
		$action -> ajaxReturn($info,$message,$status,$dataType);
		#var_dump($config);
	}
	else 
	{
		$status = false;
		$message = '兑换失败';
		$action -> ajaxReturn('',$message,$status,$dataType);
		#var_dump($config);
	}
 }
}
?>