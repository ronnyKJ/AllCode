<?php
class Card extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  $this->load->library('session');
  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->helper('file');
  
  require_once 'application/controllers/kweb/master.php';
  require_once 'kadmin/businessentity/websession.php';
  require_once 'kadmin/businessentity/tools/action.php';
  require_once 'register.php';
  require_once 'kadmin/businessentity/tools/file.class.php';
  require_once 'kadmin/businessentity/tools/string.class.php';
  
  $this->load->model('kadmin/kuser/mainfuserinfo_model','MainFUserInfoModel');
  $this->load->model('kadmin/kcard/mainfcardindex_model','MainFCardIndexModel');
  $this->load->model('kadmin/kcard/mainfcard_model','MainfCardModel');
  $this->load->model('kadmin/news/mainfshop_model','MainFshopModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoheari_model','MainFBaseInfoHearIModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfo_model','MainFBaseInfoModel');
 
 }

 function index()
 {
	
 }
 
 ////////////////////// 
 // upsale start
 function upsale()
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
 	
	$data = array(
		'title' => $this->config->item('Web_Title').' - 上传卡'
	   ,'id'				=> ''
	   ,'districtRows' 		=> null
 	   ,'uploadError'		=> ''
 	   ,'uploadedImage'		=> ''
 	   ,'userId'			=> ''
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
	   ,'cardImagePathURL'	=> base_url().'kweb/images/kapic2.jpg'
	   ,'price' 			=> '0.00'
	   ,'sellingPrice' 		=> '0.00'
 	  
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
	
	// 读取地市区域
	$this->load->model('kadmin/news/mainfdistrict_model','MainFdistrictModel');
	$districtRows = $this->MainFdistrictModel->GetEntityAll();
	$data['districtRows'] = $districtRows;
	#var_dump($districtRows);

	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/card/cardupsale.php', $data);
	
	$master->footv2index();
 }
 
 function editforsale($id='')
 {
 	// 读取卡信息
 	if($id == '')
 	{
 		$register = new Register();
 		$register->_PublicError($this, '卡不存在',site_url('member'));
 		return;
 	}
 	
 	// 检查是否已登录
 	#var_dump(WebSession::IsUserLogined($this));
 	if(!WebSession::IsUserLogined($this)) // 未登录
 	{
 		// 进入登录页
 		$this->output->set_output($this->_jsGOTOLogin(current_url()));
 		return;
 	}
 	
	$data = array(
		'title' => $this->config->item('Web_Title').' - 编辑卡'
	   ,'id' 				=> $id
	   ,'districtRows' 		=> null
 	   ,'uploadError'		=> ''
 	   ,'uploadedImage'		=> ''
 	   ,'userId'			=> ''
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
	
	// 读取地市区域
	$this->load->model('kadmin/news/mainfdistrict_model','MainFdistrictModel');
	$districtRows = $this->MainFdistrictModel->GetEntityAll();
	$data['districtRows'] = $districtRows;
	#var_dump($districtRows);
	
	
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
	$data['period'] 			= date('Y-m-d',strtotime($entity['period']));
	$data['wayFight'] 			= $entity['wayFight'];
	$data['remarks'] 			= $entity['remarks'];
	$data['cardImagePath'] 		= $entity['cardImagePath'];
	$data['cardImagePathURL'] 	= $entity['cardImagePath'] != '' 
							 		? $this->config->item('UpPathCard').'s2/'.$entity['cardImagePath'] 
									: base_url().'kweb/images/kapic2.jpg';
	$data['price'] 				= $entity['price'];
	$data['sellingPrice'] 		= $entity['sellingPrice'];
	

	// 加载页面
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/card/cardupsale.php', $data);
	
	$master->footv2index();
 }
 
 function doaddsale()
 {

 	#var_dump($this->input->post('newsContent'));
 	// 获得form页面数据
	$formDbData = array(
		'id' 				=> $this->input->post('id')
		,'userId' 			=> $this->input->post('uid')
 		,'name' 			=> trim($this->input->post('cn'))
 		,'cardType' 		=> $this->input->post('cbxct')
 		,'cardUse' 			=> $this->input->post('cbxcu')
 		,'cardTtransactions'=> $this->input->post('cbxcts')
 		,'areaDistrictId'	=> $this->input->post('districtId') == '' ? 0 : $this->input->post('districtId')
 		,'areaUrbanId' 		=> $this->input->post('urbanId') == '' ? 0 : $this->input->post('urbanId')
 		,'period' 			=> $this->input->post('period')
 		,'wayFight' 		=> $this->input->post('cbxwf')
 		,'remarks' 			=> $this->input->post('txtremarks')
 		,'cardImagePath' 	=> $this->input->post('cip')
 		,'price' 			=> $this->input->post('p')
 		,'sellingPrice' 	=> $this->input->post('sp')
 		,'operatorFrom'		=> '1' // 1 - 会员
 		,'cardSetType' 		=> '1' // 最新活动
	);
	#var_dump($formDbData);
	// 判断页面是否有上传图片
	$isupi 	= $this->input->post('isupi');
	
	// 处理checkbox传回的值
	$formDbData['cardType'] 			= implode(',',$formDbData['cardType']);
	$formDbData['cardUse'] 				= implode(',',$formDbData['cardUse']);
	$formDbData['cardTtransactions'] 	= implode(',',$formDbData['cardTtransactions']);
	$formDbData['wayFight'] 			= implode(',',$formDbData['wayFight']);
	#var_dump( $formDbData ); 

	// 从temp目录生成图片到相应目录
	if($isupi=='1') // 判断已传新图片
	{
		$this->dosave($formDbData['cardImagePath']);
	}
	
	// DB操作
	if($formDbData['id'] == '')
	{	
		$result = $this->MainFCardIndexModel->DoAddCardForSale($formDbData);
	}
	else
	{
		$entity = array(
			'id' 				=> $formDbData['id']
	 		,'name' 			=> ''
	 		,'cardType' 		=> ''
	 		,'cardUse' 			=> ''
	 		,'cardTtransactions'=> ''
	 		,'areaDistrictId'	=> ''
	 		,'areaUrbanId' 		=> ''
	 		,'period' 			=> ''
	 		,'wayFight' 		=> ''
	 		,'remarks' 			=> ''
	 		,'cardImagePath' 	=> ''
 			,'price' 			=> ''
 			,'sellingPrice' 	=> ''
		);
		
		$CardIndexEntity = $this->MainFCardIndexModel->GetCardIndexById($formDbData['id']);
		$CardForSaleEntity = $this->MainFCardIndexModel->GetCardForSaleById($formDbData['id']);
		$entity['name'] 				= $CardIndexEntity['name'];
		$entity['cardType'] 			= $CardForSaleEntity['cardType'];
		$entity['cardUse'] 				= $CardForSaleEntity['cardUse'];
		$entity['cardTtransactions'] 	= $CardForSaleEntity['cardTtransactions'];
		$entity['areaDistrictId'] 		= $CardForSaleEntity['areaDistrictId'];
		$entity['areaUrbanId'] 			= $CardForSaleEntity['areaUrbanId'];
		$entity['period'] 				= $CardForSaleEntity['period'];
		$entity['wayFight'] 			= $CardForSaleEntity['wayFight'];
		$entity['remarks'] 				= $CardForSaleEntity['remarks'];
		$entity['cardImagePath'] 		= $CardForSaleEntity['cardImagePath'];
		$entity['price'] 				= $CardForSaleEntity['price'];
		$entity['sellingPrice'] 		= $CardForSaleEntity['sellingPrice'];
		$oldPicName = $entity['cardImagePath'];

		$entity['name'] 				= $formDbData['name'];	
		$entity['cardType'] 			= $formDbData['cardType'];
		$entity['cardUse'] 				= $formDbData['cardUse'];
		$entity['cardTtransactions'] 	= $formDbData['cardTtransactions'];
		$entity['areaDistrictId'] 		= $formDbData['areaDistrictId'];
		$entity['areaUrbanId'] 			= $formDbData['areaUrbanId'];
		$entity['period'] 				= $formDbData['period'];
		$entity['wayFight'] 			= $formDbData['wayFight'];
		$entity['remarks'] 				= $formDbData['remarks'];
		$entity['cardImagePath'] 		= $formDbData['cardImagePath'];
		$entity['price'] 				= $formDbData['price'];
		$entity['sellingPrice'] 		= $formDbData['sellingPrice'];

		$result = $this->MainFCardIndexModel->DoUpdateCardForSale($entity);
		
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
 
 // upsale end 
 //////////////////////
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 ////////////////////// 
 // upsale start
 function upshow()
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
 	
	$data = array(
		'title' => $this->config->item('Web_Title').' - 上传卡'
	   ,'id'				=> ''
	   ,'districtRows' 		=> null
 	   ,'uploadError'		=> ''
 	   ,'uploadedImage'		=> ''
 	   ,'userId'			=> ''
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
	   ,'cardImagePathURL'	=> base_url().'kweb/images/kapic2.jpg'
	   ,'price' 			=> '0.00'
	   ,'sellingPrice' 		=> '0.00'
 	  
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
	
	// 读取地市区域
	$this->load->model('kadmin/news/mainfdistrict_model','MainFdistrictModel');
	$districtRows = $this->MainFdistrictModel->GetEntityAll();
	$data['districtRows'] = $districtRows;
	#var_dump($districtRows);

	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/card/cardupshow.php', $data);
	
	$master->footv2index();
 }
 
 function editforshow($id='')
 {
 	// 读取卡信息
 	if($id == '')
 	{
 		$register = new Register();
 		$register->_PublicError($this, '卡不存在',site_url('member'));
 		return;
 	}
 	
 	// 检查是否已登录
 	#var_dump(WebSession::IsUserLogined($this));
 	if(!WebSession::IsUserLogined($this)) // 未登录
 	{
 		// 进入登录页
 		$this->output->set_output($this->_jsGOTOLogin(current_url()));
 		return;
 	}
 	
	$data = array(
		'title' => $this->config->item('Web_Title').' - 编辑卡'
	   ,'id' 				=> $id
	   ,'districtRows' 		=> null
 	   ,'uploadError'		=> ''
 	   ,'uploadedImage'		=> ''
 	   ,'userId'			=> ''
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
	
	// 读取地市区域
	$this->load->model('kadmin/news/mainfdistrict_model','MainFdistrictModel');
	$districtRows = $this->MainFdistrictModel->GetEntityAll();
	$data['districtRows'] = $districtRows;
	#var_dump($districtRows);
	
	
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
	$data['period'] 			= date('Y-m-d',strtotime($entity['period']));
	$data['wayFight'] 			= $entity['wayFight'];
	$data['remarks'] 			= $entity['remarks'];
	$data['cardImagePath'] 		= $entity['cardImagePath'];
	$data['cardImagePathURL'] 	= $entity['cardImagePath'] != '' 
							 		? $this->config->item('UpPathCard').'s2/'.$entity['cardImagePath'] 
									: base_url().'kweb/images/kapic2.jpg';
	$data['price'] 				= $entity['price'];
	$data['sellingPrice'] 		= $entity['sellingPrice'];
	

	// 加载页面
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this);
	
	$this->load->view('kweb/card/cardupshow.php', $data);
	
	$master->footv2index();
 }
 
 function doaddshow()
 {

 	#var_dump($this->input->post('newsContent'));
 	// 获得form页面数据
	$formDbData = array(
		'id' 				=> $this->input->post('id')
		,'userId' 			=> $this->input->post('uid')
 		,'name' 			=> trim($this->input->post('cn'))
 		,'cardType' 		=> $this->input->post('cbxct')
 		,'cardUse' 			=> $this->input->post('cbxcu')
 		,'cardTtransactions'=> $this->input->post('cbxcts')
 		,'areaDistrictId'	=> $this->input->post('districtId') == '' ? 0 : $this->input->post('districtId')
 		,'areaUrbanId' 		=> $this->input->post('urbanId') == '' ? 0 : $this->input->post('urbanId')
 		,'period' 			=> $this->input->post('period')
 		,'wayFight' 		=> $this->input->post('cbxwf')
 		,'remarks' 			=> $this->input->post('txtremarks')
 		,'cardImagePath' 	=> $this->input->post('cip')
 		,'price' 			=> $this->input->post('p')
 		,'sellingPrice' 	=> $this->input->post('sp')
 		,'operatorFrom'		=> '1' // 1 - 会员
 		,'cardSetType' 		=> '1' // 最新活动
	);
	#var_dump($formDbData);
	
	// 判断页面是否有上传图片
	$isupi 	= $this->input->post('isupi');

	$formDbData['cardType'] 			= implode(',',$formDbData['cardType']);
	$formDbData['cardUse'] 				= implode(',',$formDbData['cardUse']);
	$formDbData['cardTtransactions'] 	= implode(',',$formDbData['cardTtransactions']);
	$formDbData['wayFight'] 			= implode(',',$formDbData['wayFight']);
	#var_dump( $formDbData ); 

	// 从temp目录生成图片到相应目录
 	if($isupi=='1') // 判断已传新图片
	{
		$this->dosave($formDbData['cardImagePath']);
	}
	
	// DB操作
	if($formDbData['id'] == '')
	{	
		$result = $this->MainFCardIndexModel->DoAddCardForShow($formDbData);
	}
	else
	{
		$entity = array(
			'id' 				=> $formDbData['id']
	 		,'name' 			=> ''
	 		,'cardType' 		=> ''
	 		,'cardUse' 			=> ''
	 		,'cardTtransactions'=> ''
	 		,'areaDistrictId'	=> ''
	 		,'areaUrbanId' 		=> ''
	 		,'period' 			=> ''
	 		,'wayFight' 		=> ''
	 		,'remarks' 			=> ''
	 		,'cardImagePath' 	=> ''
 			,'price' 			=> ''
 			,'sellingPrice' 	=> ''
		);
		
		$CardIndexEntity = $this->MainFCardIndexModel->GetCardIndexById($formDbData['id']);
		$CardForSaleEntity = $this->MainFCardIndexModel->GetCardForShowById($formDbData['id']);
		$entity['name'] 				= $CardIndexEntity['name'];
		$entity['cardType'] 			= $CardForSaleEntity['cardType'];
		$entity['cardUse'] 				= $CardForSaleEntity['cardUse'];
		$entity['cardTtransactions'] 	= $CardForSaleEntity['cardTtransactions'];
		$entity['areaDistrictId'] 		= $CardForSaleEntity['areaDistrictId'];
		$entity['areaUrbanId'] 			= $CardForSaleEntity['areaUrbanId'];
		$entity['period'] 				= $CardForSaleEntity['period'];
		$entity['wayFight'] 			= $CardForSaleEntity['wayFight'];
		$entity['remarks'] 				= $CardForSaleEntity['remarks'];
		$entity['cardImagePath'] 		= $CardForSaleEntity['cardImagePath'];
		$entity['price'] 				= $CardForSaleEntity['price'];
		$entity['sellingPrice'] 		= $CardForSaleEntity['sellingPrice'];
		$oldPicName = $entity['cardImagePath'];

		$entity['name'] 				= $formDbData['name'];
		$entity['cardType'] 			= $formDbData['cardType'];
		$entity['cardUse'] 				= $formDbData['cardUse'];
		$entity['cardTtransactions'] 	= $formDbData['cardTtransactions'];
		$entity['areaDistrictId'] 		= $formDbData['areaDistrictId'];
		$entity['areaUrbanId'] 			= $formDbData['areaUrbanId'];
		$entity['period'] 				= $formDbData['period'];
		$entity['wayFight'] 			= $formDbData['wayFight'];
		$entity['remarks'] 				= $formDbData['remarks'];
		$entity['cardImagePath'] 		= $formDbData['cardImagePath'];
		$entity['price'] 				= $formDbData['price'];
		$entity['sellingPrice'] 		= $formDbData['sellingPrice'];

		$result = $this->MainFCardIndexModel->DoUpdateCardForShow($entity);
		
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
 /////////////////////////////////////////////////////////////////////////
 
 
 
 
 //////////////////////////////////////////////////////////////////////
 //  上传临时图片 - 新会员卡图片
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
 
 
 function search()
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);

 	$fv = '';
 	if( isset($_REQUEST['fv']) )
 		$fv = trim($_REQUEST['fv']);
	$ft = '1';
 	if( isset($_REQUEST['ft']) )
 		$ft = trim($_REQUEST['ft']);
 	#var_dump($pageIndex);
 	
	if($ft == '1') //按卡名称搜索
	{
		if($fv != '')
		{
			$where = 'name` like "%'.$fv.'%" ';
		}
	}
	else // 按地区搜索
	{
		if($fv != '')
		{
			$where = 'districtName` like "%'.$fv.'%"  or `urbanIdName` like "%'.$fv.'%"';
		}
	}
	
	$perpage = '20';
 	$orderby = 'addDateTime desc';
	$total = $this->MainfCardModel->GetEntityCount($where);
	
 	$cardData = $this->MainfCardModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
   	if($cardData != null)
 	{
	 	for($i=0,$count=count($cardData); $i<$count; $i++)
	 	{
	 		$cardData[$i]['cardImagePath'] = $cardData[$i]['cardImagePath'] != '' 
			 		? $this->config->item('UpPathCard').'s2/'.$cardData[$i]['cardImagePath'] 
					: base_url().'kweb/images/kapic2.jpg';
	 	}
 	}
	
	// 准备页面数据
	$data = array(
		'title' 		=> $this->config->item('Web_Title').' - 搜索卡'
	    ,'cardData' 	=> $cardData
	    ,'total' 		=> $total
	    ,'perpage' 		=> $perpage
	);
	
	
	$master = new Master();	
	$master->headv2index($data['title']);
	$master->topv2index($this, 'sale');
	
	$this->load->view('kweb/card/search.php', $data);
	
	$master->footv2index();
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
 
 function carduppic()
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
	$this->load->view('kweb/card/carduppic.php', $data);
 }
 
 
 /////////////////////////////////////////////////////////////
 /* 卡图片上传 */
 function dopreview()
 {
 	 // 恢复form数据
	$formdata = array(
		'userId'		=> $this->input->post('userId')
		,'x' 			=> $this->input->post('x')
		,'y' 			=> $this->input->post('y')
		,'w' 			=> $this->input->post('w')
		,'h' 			=> $this->input->post('h')
		,'tempimage' 	=> $this->input->post('tempimage')
	);
	
	#var_dump($formdata);
	$config['source_image'] = $this->config->item('FilePathUpPathCard').'temp/'.$formdata['tempimage'];
	$config['x_axis'] = $formdata['x'];
	$config['y_axis'] = $formdata['y'];
	$config['width'] = 568;
	$config['height'] = 289;
	$config['new_image'] = $this->config->item('FilePathUpPathCard').'temp/s1'.$formdata['tempimage'];
	$this->crop($config);
	
	$config['source_image'] = $this->config->item('FilePathUpPathCard').'temp/s1'.$formdata['tempimage'];
	$config['width'] = 178;
	$config['height'] = 91;
	$config['new_image'] = $this->config->item('FilePathUpPathCard').'temp/s2'.$formdata['tempimage'];
	$this->resize($config);
	
	$action = new Action();
	$dataType = '';
	$status = true;
	$message = '卡图片保存成功';
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
 
 ///////////////////////////////////////////////////////////
 // public js
 function _js($success, $imagename)
 {
 	return '<script type="text/javascript" charset="UTF-8">window.parent.Finish("'.$success.'","'.$imagename.'");</script>';
 }
 
 function _jsGOTOLogin($url='')
 {
 	return '<script type="text/javascript" charset="UTF-8">location.href="'.site_url('login/noLoginIndex?u='.$url).'";</script>';
 }
}
?>