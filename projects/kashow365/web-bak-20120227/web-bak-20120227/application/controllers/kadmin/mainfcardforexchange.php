<?php
class MainFCardForExchange extends CI_Controller {
 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  $this->load->library('session');
  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->helper('file');
  
  require_once 'kadmin/businessentity/tools/formvalidation.php';
  require_once 'kadmin/businessentity/tools/common.php';
  require_once 'kadmin/entity/dbtranslate.php';
  require_once 'kadmin/businessentity/tools/page.class.php';
  require_once 'kadmin/businessentity/tools/file.class.php';
  
  $this->load->model('kadmin/kcard/MainfCardForExchange_model','MainfCardForExchangeModel');
 }

 function index()
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$name = '';
 	if( isset($_REQUEST['name']) )
 		$name = trim($_REQUEST['name']);

	$exchangPoint = '';
 	if( isset($_REQUEST['exchangPoint']) )
 		$exchangPoint = trim($_REQUEST['exchangPoint']);
 		
 	$districtId = '';
 	if( isset($_REQUEST['districtId']) )
 		$districtId = trim($_REQUEST['districtId']);
 	$urbanId = '';
 	if( isset($_REQUEST['urbanId']) )
 		$urbanId = trim($_REQUEST['urbanId']);
 		 		
	$order = '';
 	if( isset($_REQUEST['order']) )
 		$order = trim($_REQUEST['order']);
 	$by = '';
 	if( isset($_REQUEST['by']) )
 		$by = trim($_REQUEST['by']);
	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);
 	#var_dump($pageIndex);
 	
 	/////////////////////////////////////////////////////
 	// where 
  	$where = 'cardSetType` = 4 '; // 搜索 - 4 - 卡兑换类
	if($name != '')
	{
		$where .= $where == '' ? 'name` like "%'.$name.'%" ' : ' and `name` like "%'.$name.'%" ';
	}
 	if($exchangPoint != '')
	{
		$where .= $where == '' ? 'exchangPoint`='.$exchangPoint : ' and `exchangPoint`='.$exchangPoint;
	}
	if($districtId != '')
	{
		$where .= $where == '' ? 'districtId`='.$districtId : ' and `districtId`='.$districtId;
	}
 	if($urbanId != '')
	{
		$where .= $where == '' ? 'urbanId`='.$urbanId : ' and `urbanId`='.$urbanId;
	}
 	
	#var_dump($where);
	
	// order by 
 	$orderby = '';
	if($order != '')
	{
		$orderby = ($by == '' or $by == 'a')  ?  $order.'` ASC ' : $order.'` DESC ';
	}
 	else
	{
		$orderby = 'id DESC ';
	}
 	if($by == ''){$by='d';}

 	/////////////////////////////////////////////////////
 	// get DB entity Count
 	$rows = $this->MainfCardForExchangeModel->GetEntityAll($where, $orderby);
 	#var_dump($rows);	
 	
 	// get district
	$this->load->model('kadmin/news/mainfdistrict_model','MainFdistrictModel');
	$districtRows = $this->MainFdistrictModel->GetEntityAll();
	#var_dump($districtRows);

	
	// page To Index
 	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
 		,'name'			=> $name
 		,'exchangPoint' => $exchangPoint
 		,'districtId' 	=> $districtId
 		,'urbanId' 		=> $urbanId
 		
 		,'by' 			=> $by

 		,'rows' 		=> $rows
 		,'districtRows' => $districtRows
	);
	
	#var_dump($data);
	$this->load->view('kadmin/kcard/mainfcardforexchange.php', $data);
	
 }
 
 /* Add & Eidt */
 /* Add */
 function add()
 {
	// 恢复form数据
	$formdata = array(
		'id' 					=> ''
 		,'name' 				=> ''
 		,'cardType' 			=> ''
 		,'cardUse' 				=> ''
 		,'cardTtransactions'	=> ''
 		,'districtId' 			=> ''
 		,'urbanId' 				=> ''
 		,'period' 				=> ''
 		,'exchangPoint' 		=> ''
 		,'surplusCount' 		=> '0'
 		,'remarks' 				=> ''
 		,'state' 				=> '1'
 		,'orderNum' 			=> '0'
 		,'isSponsors'			=> '0'
 		,'cardImagePath'		=> ''
 		,'uploadError'			=> ''
	);

	$this->RestoreFormDate($formdata);
 }
 
 /* edit */
 function edit($id='')
 {
 	if($id == '')
 	{
 		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '修改“最新活动”出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfshopnews2")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$entity = $this->MainfCardForExchangeModel->GetEntityById($id);
	if($entity == null)
	{
		$this->output->set_output('未找到实体');
		return;
	}
		
	// 恢复form数据
	$formdata = array(
		'id' 				=> $entity['id']
 		,'name' 			=> $entity['name']
 		,'cardType' 		=> $entity['cardType']
		,'cardUse' 			=> $entity['cardUse']
 		,'cardTtransactions'=> $entity['cardTtransactions']
 		,'districtId' 		=> $entity['areaDistrictId']
 		,'urbanId' 			=> $entity['areaUrbanId']
 		,'period' 			=> date('Y-m-d', strtotime($entity['period']))
 		,'exchangPoint' 	=> $entity['exchangPoint']
 		,'surplusCount' 	=> $entity['surplusCount']
 		,'state' 			=> $entity['state']
 		,'remarks' 			=> $entity['remarks']
 		,'orderNum' 		=> $entity['orderNum']
 		,'isSponsors' 		=> $entity['isSponsors']
 		,'cardImagePath' 	=> $entity['cardImagePath']
 		,'uploadError'		=> ''
 		
	);
	$this->RestoreFormDate($formdata);
 }
 
 function doadd()
 {
 	// 获得form页面数据
	$formDbData = array(
		'id' 				=> $this->input->post('id')
 		,'name' 			=> $this->input->post('name')
 		,'userId' 			=> '0' // 管理员添加
 		,'operatorFrom' 	=> '2' // 2 - 网站管理员
 		,'cardSetType' 		=> '4' // 4 - 卡兑换类
 		,'cardType' 		=> $this->input->post('cbxct')
 		,'cardUse' 			=> $this->input->post('cbxcu')
 		,'cardTtransactions'=> $this->input->post('cbxcts')
 		,'districtId'		=> $this->input->post('districtId')
 		,'urbanId'			=> $this->input->post('urbanId')
 		,'period' 			=> $this->input->post('period')
 		,'exchangPoint' 	=> $this->input->post('exchangPoint')
 		,'surplusCount' 	=> $this->input->post('surplusCount')
 		,'state' 			=> $this->input->post('state')
 		,'remarks' 			=> $this->input->post('remarks')
 		,'orderNum' 		=> $this->input->post('orderNum')
 		,'isSponsors' 		=> $this->input->post('isSponsors')
 		,'cardImagePath' 	=> array_key_exists("userfile",$_FILES) ? $_FILES['userfile']['name'] : ''
 		,'uploadError'		=> ''
	);
	#var_dump( array_key_exists("userfile",$_FILES) );
	
	// 处理checkbox传回的值
	$formDbData['cardType'] 			= $formDbData['cardType'] !== false ? implode(',',$formDbData['cardType']) : '';
	$formDbData['cardUse'] 				= $formDbData['cardUse'] !== false ? implode(',',$formDbData['cardUse']) : '';
	$formDbData['cardTtransactions'] 	= $formDbData['cardTtransactions'] !== false ? implode(',',$formDbData['cardTtransactions']) : '';

 	// 启用CI的form库
	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');
	
	
	
	$this->form_validation->set_rules('name', 			'卡标题', 		'trim|required|max_length[200]');
	$this->form_validation->set_rules('cbxct[]', 		'卡的种类', 		'required');
	$this->form_validation->set_rules('cbxcu[]', 		'卡的用途', 		'required');
	$this->form_validation->set_rules('cbxcts[]', 		'卡的交易', 		'required');
	$this->form_validation->set_rules('districtId', 	'市区', 			'required');
	$this->form_validation->set_rules('urbanId', 		'区域', 			'required');
	$this->form_validation->set_rules('period', 		'有 效 期', 		'required');
	$this->form_validation->set_rules('exchangPoint', 	'兑换积分值', 	'required');
	$this->form_validation->set_rules('surplusCount', 	'剩余个数:', 	'required|numeric');
	$this->form_validation->set_rules('remarks', 		'备注', 			'required');
	$this->form_validation->set_rules('orderNum', 		'区域排序', 		'required|numeric');


	/////////////////////////////////////////////////////////////////////////////
	// 上传文件
	if($formDbData['cardImagePath'] != '')
	{ 
		$uploadConfig['upload_path'] = $this->config->item('FilePathUpPathCard').'temp/';
	  	$uploadConfig['allowed_types'] = 'gif|jpg|png';
		$uploadConfig['max_size'] = $this->config->item('upload_maxSize');
		$uploadConfig['max_width']  = '2048';
		$uploadConfig['max_height']  = '1526';
		$uploadConfig['encrypt_name']  = true;

		$this->load->library('upload', $uploadConfig);

		$this->upload->display_errors('<div class="message_row">', '</div>');
		if ( ! $this->upload->do_upload())
		{
		    $uploadError = array('error' => $this->upload->display_errors());
		    $formDbdata['uploadError'] = $uploadError['error'];
			// 出错恢复form数据并返回
			$this->RestoreFormDate($formDbdata);
			return;
		} 
		else
		{
		   $uploadedData = array('upload_data' => $this->upload->data());
		   $formDbData['cardImagePath'] = $uploadedData["upload_data"]['file_name'];
		   #var_dump($formDbdata['cardImagePath']);
		   
		   // 缩放图片
		   $config['source_image'] = $this->config->item('FilePathUpPathCard').'temp/'.$formDbData['cardImagePath'];
		   $config['width'] = 568;
		   $config['height'] = 289;
		   $config['new_image'] = $this->config->item('FilePathUpPathCard').'s1/'.$formDbData['cardImagePath'];
		   $this->resize($config);
		   
		   $config['source_image'] = $this->config->item('FilePathUpPathCard').'temp/'.$formDbData['cardImagePath'];
		   $config['width'] = 178;
		   $config['height'] = 91;
		   $config['new_image'] = $this->config->item('FilePathUpPathCard').'s2/'.$formDbData['cardImagePath'];
		   $this->resize($config);
		   
		} 
	}
	else if($formDbData['id'] == '')
	{
	    $formDbData['uploadError'] = '未选择要上传的文件';
		// 出错恢复form数据并返回
		$this->RestoreFormDate($formDbData);
		return;
	}

	#var_dump($this->form_validation->run());
	// 检查页面数据
	if ($this->form_validation->run() == FALSE)// 有错
	{	
		// 恢复form数据
		$this->RestoreFormDate($formDbData);
	}
	else// 无错可操作
	{
		// DB操作
		if($formDbData['id'] == '')
			$result = $this->MainfCardForExchangeModel->DoAddCardForExchange($formDbData);
		else
		{
			$nowTime=date("Y-m-d H:i:s");
			$entity = $this->MainfCardForExchangeModel->GetEntityById($formDbData['id']);
			$oldPicName = $entity['cardImagePath'];
			
			$entity['name'] 				= $formDbData['name'];
			$entity['cardType'] 			= $formDbData['cardType'];
			$entity['cardUse'] 				= $formDbData['cardUse'];
			$entity['cardTtransactions'] 	= $formDbData['cardTtransactions'];
			$entity['districtId'] 			= $formDbData['districtId'];
			$entity['urbanId'] 				= $formDbData['urbanId'];
			$entity['period'] 				= $formDbData['period'];
			$entity['exchangPoint'] 		= $formDbData['exchangPoint'];
			$entity['surplusCount'] 		= $formDbData['surplusCount'];
			$entity['state'] 				= $formDbData['state'];
			$entity['remarks'] 				= $formDbData['remarks'];
			$entity['orderNum'] 			= $formDbData['orderNum'];
			$entity['isSponsors'] 			= $formDbData['isSponsors'];
			$entity['cardImagePath'] 		= $formDbData['cardImagePath'] != '' ? $formDbData['cardImagePath'] : $entity['cardImagePath'];
			$result = $this->MainfCardForExchangeModel->Update($entity);
			
			// 图片有修改则删除原图片
			if($oldPicName!=$entity['cardImagePath'])// DEL原图片 
			{
				KXFile::DeleteFile($this->config->item('UpPathCard').'s1/', $oldPicName);
				KXFile::DeleteFile($this->config->item('UpPathCard').'s2/', $oldPicName);
			}
		}
			
		if($result!="0") // 操作成功
		{
			// 进入操作信息提示页  - 协带参数
			$data = array(
				'title' => '操作成功'
				,'message' => '“兑换卡”发布成功！'
				,'nexturl' => site_url("kadmin/mainfcardforexchange")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
		else 
		{
			// 进入操作信息提示页 
			$data = array(
				'title' => '操作失败'
				,'message' => '“兑换卡”发布出错：' + $result
				,'nexturl' => site_url("kadmin/mainfcardforexchange/add")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
	}
 }
 /* End Add & Eidt */
  
 
 /* Update State */
function doUpState($id,$state)
 {
 	// DB操作
	if($id != '' && $state != '')
	{
		$entity = $this->MainfCardForExchangeModel->GetEntityById($id);
		$entity['state'] = $state == '1' ? '0' : '1';
		$result = $this->MainfCardForExchangeModel->Update($entity);
	}
		
	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$data = array(
			'title' => '操作成功'
			,'message' => '修改“兑换卡”发布状态成功！'
			,'nexturl' => site_url("kadmin/mainfcardforexchange")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '修改“兑换卡”发布状态出错：' + $result
			,'nexturl' => site_url("kadmin/mainfcardforexchange/add")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
 }
 /* End Update State */
 
 /* del */
 function d($id='')
 {
 	if($id == '')
 	{
 		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '删除“兑换卡”出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfcardforexchange")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$entity = $this->MainfCardForExchangeModel->Delete($id);
	
	// 进入操作信息提示页  - 协带参数
	$this->GotoOperMsgPage('兑换卡删除成功！');
 } 
 function ds($ids='')
 {
 	#var_dump($ids);
 	$idsArray = explode('-', $ids);
 	#var_dump($idsArray);
 	
 	if($ids == '')
 	{
 		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '删除“最新活动”出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfcardforexchange")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$result = $this->MainfCardForExchangeModel->Deletes($idsArray);
		
 	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$this->GotoOperMsgPage('多个“最新活动”删除成功！');
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '商场发布出错：' + $result
			,'nexturl' => site_url("kadmin/mainfcardforexchange/add")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
 }
 function GotoOperMsgPage($message)
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$name = '';
 	if( isset($_REQUEST['name']) )
 		$name = trim($_REQUEST['name']);

	$exchangPoint = '';
 	if( isset($_REQUEST['exchangPoint']) )
 		$exchangPoint = trim($_REQUEST['exchangPoint']);
 		
 	$districtId = '';
 	if( isset($_REQUEST['districtId']) )
 		$districtId = trim($_REQUEST['districtId']);
 	$urbanId = '';
 	if( isset($_REQUEST['urbanId']) )
 		$urbanId = trim($_REQUEST['urbanId']);
 		 		
	$order = '';
 	if( isset($_REQUEST['order']) )
 		$order = trim($_REQUEST['order']);
 	$by = '';
 	if( isset($_REQUEST['by']) )
 		$by = trim($_REQUEST['by']);
	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);
 	#var_dump($pageIndex);
 	
	// 进入操作信息提示页 
	$data = array(
		'title' => '操作成功'
		,'message' => $message
		,'nexturl' => site_url("kadmin/mainfcardforexchange"
								.'?name='.$name
								.'&exchangPoint='.$exchangPoint
								.'&districtId='.$districtId
								.'&urbanId='.$urbanId
								.'&order='.$order
								.'&by='.$by
								.'&n='.$pageIndex)
	);
	FormValidation::GotoOperMsgPage($data, $this);
 }
 /* End del */
 
 /* public */
 function RestoreFormDate($formdata)
 {
 	// 找到区域列表
	$this->load->model('kadmin/news/mainfdistrict_model','MainFdistrictModel');
	$districtRows = $this->MainFdistrictModel->GetEntityAll();
	
	#var_dump($formdata);
	
 	// 恢复form数据
	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
		,'id' 					=> $formdata['id']
 		,'name' 				=> $formdata['name']
 		,'cardType' 			=> $formdata['cardType']
 		,'cardUse' 				=> $formdata['cardUse']
 		,'cardTtransactions'	=> $formdata['cardTtransactions']
		,'districtId' 			=> $formdata['districtId']
		,'urbanId' 				=> $formdata['urbanId']
		,'period' 				=> $formdata['period']
 		,'exchangPoint' 		=> $formdata['exchangPoint']
 		,'surplusCount' 		=> $formdata['surplusCount']
 		,'state' 				=> $formdata['state']
 		,'remarks' 				=> $formdata['remarks']
 		,'orderNum' 			=> $formdata['orderNum']
 		,'isSponsors' 			=> $formdata['isSponsors']
 		,'cardImagePath' 		=> $formdata['cardImagePath']
 		,'uploadError'			=> $formdata['uploadError']
 		
		,'districtRows' 		=> $districtRows
	);
	#var_dump($data);
	$this->load->view('kadmin/kcard/mainfcardforexchangeadd.php', $data);
	
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
 
 
 /* End public */
 
 
 
 /* formvalidation */
 /* End formvalidation */
}
?>