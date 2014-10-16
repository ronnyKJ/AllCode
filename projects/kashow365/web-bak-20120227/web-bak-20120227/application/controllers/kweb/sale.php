<?php
class Sale extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  $this->load->library('session');
  
  require_once 'application/controllers/kweb/master.php';
  require_once 'kadmin/businessentity/websession.php';
  require_once 'kadmin/businessentity/tools/string.class.php';
  require_once 'kadmin/businessentity/tools/page.class.php';
  require_once 'kadmin/businessentity/tools/action.php';
  require_once 'register.php';
  require_once 'kadmin/businessentity/tools.php';
  
  $this->load->model('kadmin/kuser/mainfuserinfo_model','MainFUserInfoModel');
  $this->load->model('kadmin/news/mainfshopnews_model','MainFshopnewsModel');
  $this->load->model('kadmin/kcard/mainfcardindex_model','MainFCardIndexModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfo_model','MainFBaseInfoModel');
  $this->load->model('kadmin/kuser/tkuseroperlog_model','TKUserOperLogModel');
  $this->load->model('kadmin/message/mainfcardmessages_model','MainFCardMessagesModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoheari_model','MainFBaseInfoHearIModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfosale_model','MainFBaseInfoSaleModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoad_model','MainFBaseInfoAdModel');
  $this->load->model('kadmin/news/mainfshop_model','MainFshopModel');
 }

 function index()
 {

 	/////////////////////////////////////////////////////
	// 最新活动
	$perpage = '6';
	$where = array(
		'newsType' 	=> 1
		,'state' 	=> 1
	);
	$orderby = 'orderNum desc';
 	$news1 = $this->MainFshopnewsModel->GetEntityByPage($where, $orderby, $perpage, 1);
	
	
 	/////////////////////////////////////////////////////
	// 读取卡 - 买卖卡
	$perpage = '12';
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
	// 读取卡 - 展示卡
	$perpage = '12';
	$where = array(
		'state' 	=> 1
	);
	$orderby = 'addDateTime desc';
 	$cardDataShow = $this->MainFCardIndexModel->GetEntityByPageForShow($where, $orderby, $perpage, 1);
   	if($cardDataShow != null)
 	{
	 	for($i=0,$count=count($cardDataShow); $i<$count; $i++)
	 	{
	 		$cardDataShow[$i]['cardImagePath'] = $cardDataShow[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathCard').'s2/'.$cardDataShow[$i]['cardImagePath'] 
					: base_url().'kweb/images/kapic2.jpg';
			$cardDataShow[$i]['period'] = date('Y-m-d', strtotime($cardDataShow[$i]['period']));
			$cardDataShow[$i]['cardUse'] = Tools::GetCardUse($cardDataShow[$i]['cardUse']); 
	 	}
 	}
 	
 	/////////////////////////////////////////////////////
	// 喜欢该频道的成员
	$perpage = '15';
	$where = array(
		'operType' 	=> 9
	);
	$orderby = 'id desc';
	$WebTotcalUser = $this->TKUserOperLogModel->GetEntityGroupByCount($where);	// 喜欢该频道的成员数 - 读取网站统计信息
 	$userDate = $this->TKUserOperLogModel->GetEntityGroupByPage($where, $orderby, $perpage, 1);
   	if($userDate != null)
 	{
	 	for($i=0,$count=count($userDate); $i<$count; $i++)
	 	{
	 		$userDate[$i]['kAvatarImage'] = $userDate[$i]['kAvatarImage'] != '' 
			 		? $this->config->item('UpPathAvatar').'s1/'.$userDate[$i]['kAvatarImage'] 
					: base_url().'kweb/images/kapic12.jpg';
	 	}
 	}
 	
 	/////////////////////////////////////////////////////
	// 听说
	$where = array(
		'infoType' 	=> 'HearInfoIndex'
	);
	$orderby = 'orderNum desc';
 	$heari = $this->MainFBaseInfoHearIModel->GetEntityAll($where, $orderby);
	
 	/////////////////////////////////////////////////////
	// 宣传言
 	$saleInfoIndex = $this->MainFBaseInfoSaleModel->GetEntityAnnount();
 	
	///////////////////////////////////////////////////////
 	// 读取广告位1
 	$ad1 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdSaleAd1');
 	if($ad1 != null)
 	{
 		$ad1['value1'] = $ad1['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad1['value1'] : '';
 	}
	#var_dump($ad1);
	
	///////////////////////////////////////////////////////
 	// 读取广告位2
 	$ad2 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdSaleAd2');
 	if($ad2 != null)
 	{
 		$ad2['value1'] = $ad2['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad2['value1'] : '';
 	}
	#var_dump($ad2);
	
	// 准备页面数据
	$data = array(
		'title' 			=> $this->config->item('Web_Title').' - 有买有卖 '
	    ,'cardData' 		=> $cardData
	    ,'cardDataShow'		=> $cardDataShow
		,'news1' 			=> $news1
		,'WebTotcalUser'	=> $WebTotcalUser
		,'userDate'			=> $userDate
		,'heari'			=> $heari
		,'saleInfoIndex'	=> $saleInfoIndex
		,'ad1'				=> $ad1
		,'ad2'				=> $ad2
		
	);
	
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this, 'sale');
	
	$this->load->view('kweb/sale/index.php', $data);
	
	$master->footv2index();

 }
 
 function more($cardSetType='sale')
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);
 	#var_dump($pageIndex);
 	
	if($cardSetType == 'sale')
	{
		/////////////////////////////////////////////////////
		// 读取卡 - 买卖卡
		$perpage = '16';
		$where = array(
			'state' 	=> 1
		);
		$orderby = 'addDateTime desc';
		$total = $this->MainFCardIndexModel->GetEntityCountForSale($where);
		
	 	$cardData = $this->MainFCardIndexModel->GetEntityByPageForSale($where, $orderby, $perpage, $pageIndex);
	   	if($cardData != null)
	 	{
		 	for($i=0,$count=count($cardData); $i<$count; $i++)
		 	{
		 		$cardData[$i]['cardImagePath'] = $cardData[$i]['cardImagePath'] != '' 
				 		? $this->config->item('UpPathCard').'s2/'.$cardData[$i]['cardImagePath'] 
						: base_url().'kweb/images/kapic2.jpg';
		 	}
	 	}
	}
	else
	{
		/////////////////////////////////////////////////////
		// 读取卡 - 展示卡
		$perpage = '16';
		$where = array(
			'state' 	=> 1
		);
		$orderby = 'addDateTime desc';
		$total = $this->MainFCardIndexModel->GetEntityCountForShow($where);
			
	 	$cardData = $this->MainFCardIndexModel->GetEntityByPageForShow($where, $orderby, $perpage, $pageIndex);
	   	if($cardData != null)
	 	{
		 	for($i=0,$count=count($cardData); $i<$count; $i++)
		 	{
		 		$cardData[$i]['cardImagePath'] = $cardData[$i]['cardImagePath'] != '' 
				 		? $this->config->item('UpPathCard').'s2/'.$cardData[$i]['cardImagePath'] 
						: base_url().'kweb/images/kapic2.jpg';
		 	}
	 	}
	}
	
	// 准备页面数据
	$data = array(
		'title' 		=> $this->config->item('Web_Title').' - 有买有卖 '
	    ,'cardData' 	=> $cardData
	    ,'total' 		=> $total
	    ,'perpage' 		=> $perpage
	    ,'cardSetType'	=> $cardSetType
	);
	
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this, 'sale');
	
	$this->load->view('kweb/sale/more.php', $data);
	
	$master->footv2index();
 }
 
 function rebatsale($id)
 {
  	// 读取卡信息
 	if($id == '')
 	{
 		$register = new Register();
 		$register->_PublicError($this, '卡不存在',site_url('member'));
 		return;
 	}
 	
 	$data = array(
		'title' => $this->config->item('Web_Title').' - 有买有卖 '
	   ,'id' 				=> $id
	   ,'name' 				=> ''
	   ,'cardType' 			=> ''
	   ,'cardUse' 			=> ''
	   ,'cardTtransactions'	=> ''
	   ,'areaDistrictId'	=> ''
	   ,'areaUrbanId' 		=> ''
	   ,'period' 			=> ''
	   ,'wayFight' 			=> ''
	   ,'remarks' 			=> ''
	   ,'cardImagePath' 	=> ''
	   ,'cardImagePathURL' 	=> ''
	   ,'price' 			=> '0.00'
	   ,'sellingPrice' 		=> '0.00'
	   ,'districtName' 		=> ''
	   ,'urbanIdName' 		=> ''
	   ,'cardMessage' 		=> null
	   ,'total' 			=> 0
	   ,'perpage' 			=> 0
	   ,'userId' 			=> ''
	   ,'cardUserId'		=> ''
 	  
	);
	
   	// 获取session中的会员ID
 	$userId = WebSession::GetUserSessionByOne('userId', $this);
 	#var_dump($userId);
 	$data['userId'] = $userId;
 	
 	// DB操作
	$entity = $this->MainFCardIndexModel->GetEntityForSaleById($id);
	if($entity == null)
	{
		$register = new Register();
 		$register->_PublicError($this, '卡不存在',site_url('member'));
 		return;
	}
	#var_dump($entity);
	$data['name'] 				= $entity['name'];
	$data['cardType'] 			= $entity['cardType'];
	$data['cardUse'] 			= $entity['cardUse'];
	$data['cardTtransactions'] 	= $entity['cardTtransactions'];
	$data['areaDistrictId'] 	= $entity['areaDistrictId'];
	$data['areaUrbanId'] 		= $entity['areaUrbanId'];
	$data['period'] 			= date('Y年m月d日',strtotime($entity['period']));
	$data['wayFight'] 			= $entity['wayFight'];
	$data['remarks'] 			= $entity['remarks'];
	$data['cardImagePath'] 		= $entity['cardImagePath'] != '' 
							 		? $this->config->item('UpPathCard').'s1/'.$entity['cardImagePath'] 
									: base_url().'kweb/images/kapic9.jpg';
	$data['price'] 				= $entity['price'];
	$data['sellingPrice'] 		= $entity['sellingPrice'];
	$data['districtName'] 		= $entity['districtName'];
	$data['urbanIdName'] 		= $entity['urbanIdName'];
	$data['cardUserId'] 		= $entity['userId'];
 	

	// 读取卡的留言
 	$perpage = '10';
	$where = array(
		'state' 	=> 1
		,'cardId'	=> $id
	);
	$orderby = 'addDateTime desc';
	$total = $this->MainFCardMessagesModel->GetEntityCount($where);
 	$cardMessage = $this->MainFCardMessagesModel->GetEntityByPage($where, $orderby, $perpage, 1);
 	$data['cardMessage'] 	= $cardMessage;
	$data['total'] 			= $total;
	$data['perpage'] 		= $perpage;
	#var_dump($cardMessage);
	
	// 绑定面面	
	$master = new Master();	
	$master->headv2index($data['name'].' - '.$data['title']);
	$master->topv2index($this, 'sale');
	
	$this->load->view('kweb/sale/salerebatsale.php', $data);
	$master->popMaskInit($this);
	$master->popMaskUserMsg($this, $userId);
	
	$master->footv2index();
 }
 
 function rebatshow($id)
 {
  	// 读取卡信息
 	if($id == '')
 	{
 		$register = new Register();
 		$register->_PublicError($this, '卡不存在',site_url('member'));
 		return;
 	}
 	
 	$data = array(
		'title' => $this->config->item('Web_Title').' - 有买有卖 '
	   ,'id' 				=> $id
	   ,'name' 				=> ''
	   ,'cardType' 			=> ''
	   ,'cardUse' 			=> ''
	   ,'cardTtransactions'	=> ''
	   ,'areaDistrictId'	=> ''
	   ,'areaUrbanId' 		=> ''
	   ,'period' 			=> ''
	   ,'wayFight' 			=> ''
	   ,'remarks' 			=> ''
	   ,'cardImagePath' 	=> ''
	   ,'cardImagePathURL' 	=> ''
	   ,'price' 			=> '0.00'
	   ,'sellingPrice' 		=> '0.00'
	   ,'districtName' 		=> ''
	   ,'urbanIdName' 		=> ''
	   ,'cardMessage' 		=> null
	   ,'total' 			=> 0
	   ,'perpage' 			=> 0
	   ,'userId' 			=> ''  
 	  
	);
	
   	// 获取session中的会员ID
 	$userId = WebSession::GetUserSessionByOne('userId', $this);
 	#var_dump($userId);
 	$data['userId'] = $userId;
 	
 	// DB操作
	$entity = $this->MainFCardIndexModel->GetEntityForShowById($id);
	if($entity == null)
	{
		$register = new Register();
 		$register->_PublicError($this, '卡不存在',site_url('member'));
 		return;
	}
	#var_dump($entity);
	$data['name'] 				= $entity['name'];
	$data['cardType'] 			= $entity['cardType'];
	$data['cardUse'] 			= $entity['cardUse'];
	$data['cardTtransactions'] 	= $entity['cardTtransactions'];
	$data['areaDistrictId'] 	= $entity['areaDistrictId'];
	$data['areaUrbanId'] 		= $entity['areaUrbanId'];
	$data['period'] 			= date('Y年m月d日',strtotime($entity['period']));
	$data['wayFight'] 			= $entity['wayFight'];
	$data['remarks'] 			= $entity['remarks'];
	$data['cardImagePath'] 		= $entity['cardImagePath'] != '' 
							 		? $this->config->item('UpPathCard').'s1/'.$entity['cardImagePath'] 
									: base_url().'kweb/images/kapic9.jpg';
	$data['price'] 				= $entity['price'];
	$data['sellingPrice'] 		= $entity['sellingPrice'];
	$data['districtName'] 		= $entity['districtName'];
	$data['urbanIdName'] 		= $entity['urbanIdName'];
 	

	// 读取卡的留言
 	$perpage = '10';
	$where = array(
		'state' 	=> 1
		,'cardId'	=> $id
	);
	$orderby = 'addDateTime desc';
	$total = $this->MainFCardMessagesModel->GetEntityCount($where);
 	$cardMessage = $this->MainFCardMessagesModel->GetEntityByPage($where, $orderby, $perpage, 1);
 	$data['cardMessage'] 	= $cardMessage;
	$data['total'] 			= $total;
	$data['perpage'] 		= $perpage;
	#var_dump($cardMessage);
	
	// 绑定面面	
	$master = new Master();	
	$master->headv2index($data['name'].' - '.$data['title']);
	$master->topv2index($this, 'sale');
	
	$this->load->view('kweb/sale/salerebatshow.php', $data);
	$master->popMaskInit($this);
	$master->popMaskUserMsg($this, $userId);
	
	$master->footv2index();
 }
 
 function doajaxrebat()
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);
 	#var_dump($pageIndex);
	$cardId = '1';
 	if( isset($_REQUEST['cid']) )
 		$cardId = trim($_REQUEST['cid']);
 	#var_dump($pageIndex);
 	
 	// DB - 获取分页数据
 	$perpage = '10';
	$where = array(
		'state' 	=> 1
		,'cardId'	=> $cardId
	);
	$orderby = 'addDateTime desc';
	$total = $this->MainFCardMessagesModel->GetEntityCount($where);
 	$cardMessage = $this->MainFCardMessagesModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
	
  	
 	// 返回页面的HTML
 	$html = '';
 	
  	// 合关HTML
  	$i=0;
	$count=count($cardMessage);
	$html = '<ul class="kaul15">';
	for($j=$i;$j<$count;$j++, $i=$j)
	{
		$row = $cardMessage[$i];
		$html .='<li ';
		if($i%2==0){ $html .='class="grali"';}
		$html .='><h4><a href="'.site_url('member/other/'.$row['userId']).'">'.$row['nickname'].' </a>'
				.'<em>发表于'.$row['addDateTime'].'</em></h4><p>'.$row['content'].'</p></li>';
	}

	// 加补翻页HTML
	$page=new page(array('total'=>$total
					,'perpage'=>$perpage
					,'nowindex'=>$pageIndex
					,'pagebarnum'=>10));
	$page->open_ajax('doAjax');
	
	$html .='</ul><div class="clear"></div>';
	$html .='<div class="position4">';
	$html .= $page->show(1);
	$html .='</div>';
			
  	#var_dump($html);

  	$action = new Action();
	$dataType = '';
	$status = true;
	$message = '数据获取成功';
	$data = $html;
	$action -> ajaxReturn($data,$message,$status,$dataType);
 }
 
 
 function dosavecardmsg()
 {
  	// 检查是否已登录
 	#var_dump(WebSession::IsUserLogined($this));
 	if(!WebSession::IsUserLogined($this)) // 未登录
 	{
 		// 进入登录页
		$status = 0;
		$message = '留言失败登录超时';
		#$data = current_url();
		$this->output->set_output($this->_js($status,$message));
 		return;
 	}
 	
 	// 获取session中的会员ID
 	$userId = WebSession::GetUserSessionByOne('userId', $this);
 	$data['userId'] = $userId;
 	#var_dump($userId);
 	if($userId=='')
 	{
 		// 进入登录页
		$status = 0;
		$message = '留言失败登录超时';
		#$data = current_url();
		$this->output->set_output($this->_js($status,$message));
 		return;
 	}
	
 	
 	// 恢复form数据
	$formdata = array(
		'userId' 	=> $userId
		,'content' 	=> $this->input->post('content')
		,'cardId'		=> $this->input->post('cid')
	);

	// DB - 加关注
	$result = $this->MainFCardMessagesModel->DoAddCardMessage($formdata);
 	
	// 返回ajax应答
	$action = new Action();
	$dataType = '';
	if($result != 0)
	{
		$status = 1;
		$message = '留言成功';
		$this->output->set_output($this->_js($status,$message));
 		return;
	}
	else 
	{
		$status = 0;
		$message = '关注失败';
		$this->output->set_output($this->_js($status,$message));
 		return;
	}
 }
 
 

 function dodelcard()
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$cid = '';
 	if( isset($_REQUEST['cid']) )
 		$cid = trim($_REQUEST['cid']);
 	$cardSetType = '';
 	if( isset($_REQUEST['t']) )
 		$cardSetType = trim($_REQUEST['t']);
 	
	$action = new Action();
	$dataType = '';
	
  	// 检查是否已登录
 	#var_dump(WebSession::IsUserLogined($this));
 	if(!WebSession::IsUserLogined($this)) // 未登录
 	{
		// 进入登录页
		$message = '会员登录超时';
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
 	}
 	
  	// 获取session中的会员ID
 	$loginUserId = WebSession::GetUserSessionByOne('userId', $this);
 	if($loginUserId=='')
 	{
		// 进入登录页
		$message = '会员登录超时';
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
 	}
 	
 	/////////////////////////////////////////////////////
	// 读取卡 
	// $cardSetType : 1 - 卡买卖类	2 - 卡展示类
	if($cardSetType==1)
		$cardData = $this->MainFCardIndexModel->GetEntityForSaleById($cid);
 	if($cardSetType==2)
 		$cardData = $this->MainFCardIndexModel->GetEntityForShowById($cid);
   	if($cardData == null)
 	{
 		// 进入登录页
		$message = '卡未找到';
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
 	}
 	
 	// 判断该活动是否为登录者的活动
 	if($loginUserId != $cardData['userId'])
 	{
 		// 进入登录页
		$message = '不能删除该卡';
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
 	}
	
 	// 执行删除卡 
	// $cardSetType : 1 - 卡买卖类	2 - 卡展示类
	if($cardSetType==1)
		$result = $this->MainFCardIndexModel->DoDelCardForSale($cid, $loginUserId);
 	if($cardSetType==2)
 		$result = $this->MainFCardIndexModel->DoDelCardForShow($cid, $loginUserId);
 			
 	
	// 返回ajax应答
	$status = true;
	$message = '已成功删除该卡';
	$action -> ajaxReturn('',$message,$status,$dataType);
		
 }
 
 
 ///////////////////////////////////////////////////////////
 // public js
 function _js($success, $message)
 {
 	header("Content-Type:text/html; charset=utf-8");
 	return '<script type="text/javascript">window.parent.Finish("'.$success.'","'.$message.'");</script>';
 }
 
 
 function _jsGOTOLogin($url='')
 {
 	header("Content-Type:text/html; charset=utf-8");
 	return '<script type="text/javascript">location.href="'.site_url('login/noLoginIndex?u='.$url).'";</script>';
 }
}
?>