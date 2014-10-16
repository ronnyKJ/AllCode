<?php
class Spell extends CI_Controller {

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
  $this->load->model('kadmin/kcard/tkcardactivityregistration_model','TKCardActivityRegistrationModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfospell_model','MainFBaseInfoSpellModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoad_model','MainFBaseInfoAdModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoheari_model','MainFBaseInfoHearIModel');
  $this->load->model('kadmin/news/mainfshop_model','MainFshopModel');
 }

function index()
 {
 	 // page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);
 	#var_dump($pageIndex);
 	
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
	// 读取活动卡
	$where = array(
		'state !=' 	=> 3
	);
	$orderby = 'addDateTime desc';
	$totalForActivityRowsCount = $this->MainFCardIndexModel->GetEntityCountForActivity($where);
	// select db
	$activityperpage = '3';
 	$cardData = $this->MainFCardIndexModel->GetEntityByPageForActivity($where, $orderby, $activityperpage, $pageIndex);
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
	// 宣传言
 	$spellInfoIndex = $this->MainFBaseInfoSpellModel->GetEntityAnnount();
	
	///////////////////////////////////////////////////////
 	// 读取广告位1
 	$ad1 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdSpellAd1');
 	if($ad1 != null)
 	{
 		$ad1['value1'] = $ad1['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad1['value1'] : '';
 	}
 	
	 ///////////////////////////////////////////////////////
 	// 读取广告位2
 	$ad2 = $this->MainFBaseInfoAdModel->GetEntityByInfoType('AdSpellAd2');
 	if($ad2 != null)
 	{
 		$ad2['value1'] = $ad2['value1'] != '' ? $this->config->item('UpPathAD').'/'.$ad2['value1'] : '';
 	}
	
	// 准备页面数据
	$data = array(
		'title' 			=> $this->config->item('Web_Title').' - 合伙拼卡'
	    ,'cardData' 		=> $cardData
	    ,'perpage'			=> $activityperpage
	    ,'total'			=> $totalForActivityRowsCount
		,'news1' 			=> $news1
		,'WebTotcalUser'	=> $WebTotcalUser 
		,'userDate'			=> $userDate
		,'spellInfoIndex'	=> $spellInfoIndex
		,'ad1'				=> $ad1
 		,'ad2'				=> $ad2
	);
	
	// 获取session中的会员ID
 	$loginUserId = WebSession::GetUserSessionByOne('userId', $this);
 	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this, 'spell');
	
	$this->load->view('kweb/spell/index.php', $data);
	$master->popMaskInit($this);
	$master->popMaskFriends($this, $loginUserId);
	
	$master->footv2index();

 }
 
 
 //////////////////////////////////////////////////////////////////////
 //  上传临时图片
 function doupphoto()
 {
 	// 恢复form数据
	$formdata = array(
		'userId' => $this->input->post('userId')
		,'uploadError' => ''
		,'uploadedImage' => ''
	);
	
 	#var_dump($_FILES);
	/////////////////////////////////////////////////////////////////////////////
	// 上传文件
	$uploadConfig['upload_path'] = $this->config->item('FilePathUpPathCard').'temp/';
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
		$this->output->set_output($this->_js($formdata['uploadError'], ''));
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
 //////////////////////////////////////////////////////////////////////
 
function carduppic()
 {
 	// 初始化
 	$data = array(
		'title' => $this->config->item('Web_Title')
 		,'uploadedImage' => ''
 	);
 	
  	 // page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$uploadedImage = '1';
 	if( isset($_REQUEST['ui']) )
 		$uploadedImage = trim($_REQUEST['ui']);
 	$data['uploadedImage'] = $uploadedImage;
 	#var_dump($pageIndex);
 	
 	$master = new Master();	
	$this->load->view('kweb/spell/carduppic.php', $data);
 }
 
 
 /////////////////////////////////////////////////////////////
 /* 卡图片上传 */
 function dopreview()
 {
 	 // 恢复form数据
	$formdata = array(
		'x' 			=> $this->input->post('x')
		,'y' 			=> $this->input->post('y')
		,'w' 			=> $this->input->post('w')
		,'h' 			=> $this->input->post('h')
		,'tempimage' 	=> $this->input->post('tempimage')
	);
	
	#var_dump($formdata);
	$config['source_image'] = $this->config->item('FilePathUpPathCard').'temp/'.$formdata['tempimage'];
	$config['x_axis'] = $formdata['x'];
	$config['y_axis'] = $formdata['y'];
	$config['width'] = 372;
	$config['height'] = 243;
	$config['new_image'] = $this->config->item('FilePathUpPathCard').'temp/s1'.$formdata['tempimage'];
	$this->crop($config);
	
	$config['source_image'] = $this->config->item('FilePathUpPathCard').'temp/s1'.$formdata['tempimage'];
	$config['width'] = 138;
	$config['height'] = 90;
	$config['new_image'] = $this->config->item('FilePathUpPathCard').'temp/s2'.$formdata['tempimage'];
	$this->resize($config);
	
	$action = new Action();
	$dataType = '';
	$status = true;
	$message = '卡活动图保存成功';
	$info = $formdata['tempimage'];
	$action -> ajaxReturn($info,$message,$status,$dataType);
	#var_dump($config);
	
 }
 
 function dosave($tempimage)
 {
	$source_image = $this->config->item('FilePathUpPathCard').'temp/s1'.$tempimage;
	$new_image1 = $this->config->item('FilePathUpPathCard').'s1/'.$tempimage;
	rename($source_image, $new_image1);
	
	$source_image = $this->config->item('FilePathUpPathCard').'temp/s2'.$tempimage;
	$new_image2 = $this->config->item('FilePathUpPathCard').'s2/'.$tempimage;
	rename($source_image, $new_image2);
 }
 
 
 function doaddspell()
 {

 	#var_dump($this->input->post('newsContent'));
 	// 获得form页面数据
	$formDbData = array(
		'id' 				=> $this->input->post('id')
		,'userId' 			=> $this->input->post('uid')
 		,'name' 			=> trim($this->input->post('cn'))
 		,'matter' 			=> trim($this->input->post('m'))
 		,'characteristic' 	=> trim($this->input->post('c'))
 		,'detail' 			=> trim($this->input->post('d'))
 		,'tel' 				=> trim($this->input->post('tel'))
 		,'QQ' 				=> trim($this->input->post('QQ'))
 		,'cardImagePath' 	=> $this->input->post('cip')
 		,'startDate' 		=> $this->input->post('sd')
 		,'endDate' 			=> $this->input->post('ed')
 		,'limitUser' 		=> trim($this->input->post('lu'))
 		,'operatorFrom'		=> '1' // 1 - 会员
 		,'cardSetType' 		=> '3' // 最新活动
	);
	#var_dump($formDbData);
	
	// 判断页面是否有上传图片
	$isupi 	= $this->input->post('isupi');
	
	// 从temp目录生成图片到相应目录
	if($isupi=='1') // 判断已传新图片
	{
		$this->dosave($formDbData['cardImagePath']);
	}
	
	// DB操作
	if($formDbData['id'] == '')
	{	
		$result = $this->MainFCardIndexModel->DoAddCardForActivity($formDbData);
	}
	else
	{
		$entity = array(
			'id' 				=> $formDbData['id']
	 		,'matter' 			=> ''
	 		,'name' 			=> ''
	 		,'characteristic' 	=> ''
	 		,'detail' 			=> ''
	 		,'tel' 				=> ''
	 		,'QQ' 				=> ''
	 		,'cardImagePath' 	=> ''
	 		,'startDate' 		=> ''
	 		,'endDate' 			=> ''
	 		,'limitUser' 		=> ''
		);
		
		$CardIndexEntity = $this->MainFCardIndexModel->GetCardIndexById($formDbData['id']);
		$CardForActivityEntity = $this->MainFCardIndexModel->GetCardForActivityById($formDbData['id']);
		$entity['name'] 			= $CardIndexEntity['name'];
		$entity['matter'] 			= $CardForActivityEntity['matter'];
		$entity['characteristic'] 	= $CardForActivityEntity['characteristic'];
		$entity['detail'] 			= $CardForActivityEntity['detail'];
		$entity['tel'] 				= $CardForActivityEntity['tel'];
		$entity['QQ'] 				= $CardForActivityEntity['QQ'];
		$entity['cardImagePath'] 	= $CardForActivityEntity['cardImagePath'];
		$entity['startDate'] 		= $CardForActivityEntity['startDate'];
		$entity['endDate'] 			= $CardForActivityEntity['endDate'];
		$entity['limitUser'] 		= $CardForActivityEntity['limitUser'];
		$oldPicName = $entity['cardImagePath'];

		$entity['name'] 				= $formDbData['name'];
		$entity['matter'] 			= $formDbData['matter'];	
		$entity['cardUse'] 			= $formDbData['cardUse'];
		$entity['characteristic'] 	= $formDbData['characteristic'];
		$entity['detail'] 			= $formDbData['detail'];
		$entity['tel'] 				= $formDbData['tel'];
		$entity['QQ'] 				= $formDbData['QQ'];
		$entity['cardImagePath'] 	= $formDbData['cardImagePath'];
		$entity['startDate'] 		= $formDbData['startDate'];
		$entity['endDate'] 			= $formDbData['endDate'];
		$entity['limitUser'] 		= $formDbData['limitUser'];

		$result = $this->MainFCardIndexModel->DoUpdateCardForActivity($entity);
		
		// 图片有修改则删除原图片
		if($oldPicName!=$entity['cardImagePath'])// DEL原图片 
		{
			KXFile::DeleteFile($this->config->item('UpPathCard').'s1/', $oldPicName);
			KXFile::DeleteFile($this->config->item('UpPathCard').'s2/', $oldPicName);
		}
	}
	
	if($result!=0) // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$action = new Action();
		$dataType = '';
		$status = true;
		$message = '成功发布一张卡';
		$info = '';
		$action -> ajaxReturn($info,$message,$status,$dataType);
	}
	else 
	{
		// 进入操作信息提示页 
		$action = new Action();
		$dataType = '';
		$status = false;
		$message = '发卡失败';
		$info = '';
		$action -> ajaxReturn($info,$message,$status,$dataType);
	}
 }
 
 // upspell end 
 //////////////////////
 
 function spellxl($id)
 {
   	// 读取卡信息
 	if($id == '')
 	{
 		$register = new Register();
 		$register->_PublicError($this, '卡不存在',site_url('spell'));
 		return;
 	}
 	
	$cardData = $this->MainFCardIndexModel->GetCardForActivityById($id);
	if($cardData['state'] == '3')
	{
		$register = new Register();
 		$register->_PublicError($this, '卡已退出',site_url('spell'));
 		return;
	}
 	$cardData['cardImagePath'] = $cardData['cardImagePath'] != '' 
	 		? $this->config->item('UpPathCard').'s1/'.$cardData['cardImagePath'] 
			: base_url().'kweb/images/kapic2.jpg';
	$cardData['startDate'] = $cardData['startDate'] != '' 
	 		? date('Y年m月d日', strtotime($cardData['startDate'])) 
			: '';
	$cardData['endDate'] = $cardData['endDate'] != '' 
	 		? date('Y年m月d日', strtotime($cardData['endDate'])) 
			: '';
	$toUserId = $cardData['userId'];
			
  	// DB-获取会员信息 
 	$userInfoData = $this->MainFUserInfoModel->GetEntityByIdForView($toUserId);
 	if($userInfoData != null)	// 找到当前会员的头像文件名
 	{
 		$userInfoData['kAvatarImage'] = $userInfoData['kAvatarImage'] != '' 
								? $this->config->item('UpPathAvatar').'b/'.$userInfoData['kAvatarImage'] 
								: base_url().'kweb/images/kapic11.jpg';
 	}
 	
  	// 获取session中的会员ID
 	$loginUserId = WebSession::GetUserSessionByOne('userId', $this);
 	
 	// 已报名中的会员是否有当前登录会员
 	$IsMyRegedCard = '0';
 	
 	// DB-获取会员信息 
 	$where  = array(
 		'state' 	=> 1
 		,'cardId'	=> $id
 	);
 	$orderby = 'regDateTime desc';
 	$regUserInfoData = $this->TKCardActivityRegistrationModel->GetEntityAll($where, $orderby);
 	#var_dump($regUserInfoData);
 	if($regUserInfoData != null)	// 找到当前会员的头像文件名
 	{
 		for($i=0,$count=count($regUserInfoData); $i<$count; $i++)
	 	{
	 		// 已报名中的会员是否有当前登录会员
			if($loginUserId == $regUserInfoData[$i]['regUserId'])
			{
				$IsMyRegedCard = '1';
			}	
	 		$regUserInfoData[$i]['kAvatarImage'] = $regUserInfoData[$i]['kAvatarImage'] != '' 
			 		? $this->config->item('UpPathAvatar').'s1/'.$regUserInfoData[$i]['kAvatarImage'] 
					: base_url().'kweb/images/kapic12.jpg';
	 	}
 	}
 	
	$data = array(
		'title' 			=> $this->config->item('Web_Title').' - 合伙拼卡'
		,'cardData' 		=> $cardData
		,'userInfoData'		=> $userInfoData
		,'regUserInfoData'	=> $regUserInfoData
		,'IsMyRegedCard'	=> $IsMyRegedCard
		,'id'				=> $id
		,'loginUserId'		=> $loginUserId
	);
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this, 'spell');
	
	$this->load->view('kweb/spell/spellxl.php', $data);
	$master->popMaskInit($this);
	$master->popMaskUserMsg($this, $toUserId);
	$master->popMaskFriends($this, $loginUserId);

	$master->footv2index();
 }
 
 
 ///////////////////////////////////////////////////////////
 // 参加活动
 function doreg($cid)
 {
 	$action = new Action();
	$dataType = '';
	
  	// 检查是否已登录
 	#var_dump(WebSession::IsUserLogined($this));
 	if(!WebSession::IsUserLogined($this)) // 未登录
 	{
		// 进入登录页
 		$status = false;
		$message = '会员登录超时';
		$url = site_url('login');
		$action -> ajaxReturn($url,$message,$status,$dataType);
 		return;
 	}
 	
  	// 获取session中的会员ID
 	$userId = WebSession::GetUserSessionByOne('userId', $this);
 	$data['userId'] = $userId;
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
 	
	// 保存到数据库
	$formdata = array(
		'cardId'		=> $cid
		,'regUserId'	=> $userId
	);
	$result = $this->TKCardActivityRegistrationModel->DoAddCardActivityRegistration($formdata);
	#var_dump($result);
	
	// 返回ajax应答
	$status = true;
	$message = '参加成功';
	$action -> ajaxReturn('',$message,$status,$dataType);
	#var_dump($config);
 }
 
 function doexitreg($cid)
 {
 	$action = new Action();
	$dataType = '';
	
  	// 检查是否已登录
 	#var_dump(WebSession::IsUserLogined($this));
 	if(!WebSession::IsUserLogined($this)) // 未登录
 	{
		// 进入登录页
 		$status = false;
		$message = '会员登录超时';
		$url = site_url('login');
		$action -> ajaxReturn($url,$message,$status,$dataType);
 		return;
 	}
 	
  	// 获取session中的会员ID
 	$userId = WebSession::GetUserSessionByOne('userId', $this);
 	$data['userId'] = $userId;
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
 	
	// 保存到数据库
	$formdata = array(
		'cardId'		=> $cid
		,'regUserId'	=> $userId
	);
	$result = $this->TKCardActivityRegistrationModel->DoExitCardActivityRegistration($formdata);
	#var_dump($result);
	
	// 返回ajax应答
	$status = true;
	$message = '退出成功';
	$action -> ajaxReturn('',$message,$status,$dataType);
	#var_dump($config);
 }
 
 
 function dosendfriends($cid)
 {
 	$action = new Action();
	$dataType = '';
	
  	// 检查是否已登录
 	#var_dump(WebSession::IsUserLogined($this));
 	if(!WebSession::IsUserLogined($this)) // 未登录
 	{
		// 进入登录页
 		$status = false;
		$message = '会员登录超时';
		$url = site_url('login');
		$action -> ajaxReturn($url,$message,$status,$dataType);
 		return;
 	}
 	
  	// 获取session中的会员ID
 	$loginUserId = WebSession::GetUserSessionByOne('userId', $this);
 	if($loginUserId=='')
 	{
		// 进入登录页
 		$status = false;
		$message = '会员登录超时';
		$url = site_url('login');
		$action -> ajaxReturn($url,$message,$status,$dataType);
 		return;
 	}
 	
 	// DB-获取会员信息 
 	$userInfoData = $this->MainFUserInfoModel->GetEntityByIdForView($loginUserId);
 	
	// 保存到数据库
	$content = '您的好友”'.$userInfoData['nickname'].'“向您分享拼卡活动。'
				.'卡秀提示：<a href="'.site_url('spell/spellxl/'.$cid).'" target="_blank">点击查看拼卡</a>';
	$formdata = array(
		'cardId'		=> $cid
		,'loginUserId'	=> $loginUserId
		,'content'		=> $content
	);
	$result = $this->TKCardActivityRegistrationModel->DoSendFriendsCardActivity($formdata);
	#var_dump($result);
	
	// 返回ajax应答
	$status = true;
	$message = '已分享给全部好友';
	$action -> ajaxReturn('',$message,$status,$dataType);
	#var_dump($config);
 }
 
 function dosendfriend($cid)
 {
 	// 获得form页面数据
	$formDbData = array(
		'uf' => $this->input->post('uf')
	);
	#var_dump($formDbData);
	
	if($formDbData['uf'] == '')
	{
		$message = '未选择好友';
		$js='alert("'.$message.'");';
		$this->output->set_output($this->_js('', $message, $js));
		return;
	}
	
	// 处理checkbox传回的值
	$formDbData['uf'] = implode(',',$formDbData['uf']);
	#var_dump( $formDbData ); 

	$action = new Action();
	$dataType = '';
	
  	// 检查是否已登录
 	#var_dump(WebSession::IsUserLogined($this));
 	if(!WebSession::IsUserLogined($this)) // 未登录
 	{
		// 进入登录页
		$message = '会员登录超时';
		$js='alert("'.$message.'");location.href="'.site_url('login').'";';
		$this->output->set_output($this->_js('', $message, $js));
		return;
 	}
 	
  	// 获取session中的会员ID
 	$loginUserId = WebSession::GetUserSessionByOne('userId', $this);
 	if($loginUserId=='')
 	{
		// 进入登录页
		$message = '会员登录超时';
		$js='alert("'.$message.'");location.href="'.site_url('login').'";';
		$this->output->set_output($this->_js('', $message, $js));
		return;
 	}
 	
 	// DB-获取会员信息 
 	$userInfoData = $this->MainFUserInfoModel->GetEntityByIdForView($loginUserId);
 	
	// 保存到数据库
	$content = '您的好友”'.$userInfoData['nickname'].'“向您分享拼卡活动。'
				.'卡秀提示：<a href="'.site_url('spell/spellxl/'.$cid).'" target="_blank">点击查看拼卡</a>';
	$formdata = array(
		'cardId'			=> $cid
		,'loginUserId'		=> $loginUserId
		,'content'			=> $content
		,'friendUserIds'	=> $formDbData['uf']
	);
	$result = $this->TKCardActivityRegistrationModel->DoSendFriendCardActivity($formdata);
	#var_dump($result);
	
	// 返回ajax应答
	$status = true;
	$message = '已分享给所选好友';
	$js='alert("'.$message.'");';
	$this->output->set_output($this->_js('1',$message,$js));
	return;
 }
 
 function doclosemanagespell()
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$cid = '';
 	if( isset($_REQUEST['cid']) )
 		$cid = trim($_REQUEST['cid']);
 	
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
	// 读取活动卡
	$where = array(
		'userId' => $loginUserId
		,'id'	 => $cid
	);
 	$cardData = $this->MainFCardIndexModel->GetCardForActivityById($cid);
   	if($cardData == null)
 	{
 		// 进入登录页
		$message = '活动未找到';
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
 	}
 	
 	// 判断该活动是否为登录者的活动
 	if($loginUserId != $cardData['userId'])
 	{
 		// 进入登录页
		$message = '不能结束该活动';
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
 	}
	
 	$result = $this->MainFCardIndexModel->DoCloseCardForActivity($cid);
 	
 	
	// 返回ajax应答
	$status = true;
	$message = '已成功结束活动';
	$action -> ajaxReturn('',$message,$status,$dataType);
		
 }
 
 
 function dodelmanagespell()
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$cid = '';
 	if( isset($_REQUEST['cid']) )
 		$cid = trim($_REQUEST['cid']);
 	
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
	// 读取活动卡
	$where = array(
		'userId' => $loginUserId
		,'id'	 => $cid
	);
 	$cardData = $this->MainFCardIndexModel->GetCardForActivityById($cid);
   	if($cardData == null)
 	{
 		// 进入登录页
		$message = '活动未找到';
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
 	}
 	
 	// 判断该活动是否为登录者的活动
 	if($loginUserId != $cardData['userId'])
 	{
 		// 进入登录页
		$message = '不能删除该活动';
		$action -> ajaxReturn('',$message,$status,$dataType);
		return;
 	}
	
 	$result = $this->MainFCardIndexModel->DoDelCardForActivity($cid, $loginUserId);
 	
 	
	// 返回ajax应答
	$status = true;
	$message = '已成功删除活动';
	$action -> ajaxReturn('',$message,$status,$dataType);
		
 }
 
 
 ///////////////////////////////////////////////////////////
 // public js
 function _js($success, $imagename, $js='')
 {
 	header("Content-Type:text/html; charset=utf-8");
 	return '<script type="text/javascript">window.parent.Finish("'.$success.'","'.$imagename.'");'.$js.'</script>';
 }
 
 function _jsGOTOLogin($url='')
 {
	header("Content-Type:text/html; charset=utf-8");
 	return '<script type="text/javascript">location.href="'.site_url('login/noLoginIndex?u='.$url).'";</script>';
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
 	#var_dump($config);
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
}
?>