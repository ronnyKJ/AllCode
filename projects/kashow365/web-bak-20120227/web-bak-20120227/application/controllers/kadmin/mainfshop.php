<?php
class MainFshop extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('form');
  $this->load->helper('url');
  require_once 'kadmin/businessentity/tools/formvalidation.php';
  require_once 'kadmin/businessentity/tools/action.php';
  
  $this->load->model('kadmin/news/mainfshop_model','MainFshopModel');
  $this->load->model('kadmin/news/mainfdistrict_model','MainFdistrictModel');
  
 }

 function index()
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$shopname = '';
 	if( isset($_REQUEST['shopname']) )
 		$shopname = trim($_REQUEST['shopname']);
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
 	
 	/////////////////////////////////////////////////////
 	// where 
  	$where = '';
	if($shopname != '')
	{
		$where = 'shopname` like "%'.$shopname.'%" ';
	}
	if($districtId != '')
	{
		$where .= $where == '' ? 'districtId`='.$districtId : ' and `districtId`='.$districtId;
	}
 	if($urbanId != '')
	{
		$where .= $where == '' ? 'urbanId`='.$urbanId : ' and `urbanId`='.$urbanId;
	}
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
	$totalRowsCount = $this->MainFshopModel->GetEntityCount($where);
	#var_dump($totalRowsCount);
	#var_dump($where);
	#var_dump($orderby);
	/////////////////////////////////////////////////////
	// select db
	$perpage = '40';
 	$rows = $this->MainFshopModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
 	#var_dump($rows);
	$districtRows = $this->MainFdistrictModel->GetEntityAll();

	// page To Index
 	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
 		,'shopname' => $shopname
 		,'districtId' => $districtId
 		,'urbanId' => $urbanId
 		,'by' => $by
 		,'rows' => $rows
 		,'districtRows' => $districtRows
 		,'perpage' => $perpage
 		,'total' => $totalRowsCount
	);
	$this->load->view('kadmin/news/mainfshop.php', $data);
 }
 
 /* Add & Eidt */
 /* Add */
 function add()
 {
	// 恢复form数据
	$formdata = array(
		'id' 					=> ''
		,'shopname' 			=> ''
		,'districtId' 			=> ''
		,'urbanId' 				=> ''
		,'reActivityOrderNum' 	=> 0
		,'reDiscountOrderNum' 	=> 0
		,'reConversionOrderNum' => 0
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
			,'message' => '修改公告出错：未传入公告编号'
			,'nexturl' => site_url("kadmin/mainfannount")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$entity = $this->MainFshopModel->GetEntityById($id);
	
	if($entity == null)
	{
		$this->output->set_output('未找到实体');
		return;
	}
	
	$entityDistrict = $this->MainFdistrictModel->GetDistrictEntityById($entity['urbanId']);
		
	// 恢复form数据
	$formdata = array(
		'id' => $entity['id']
 		,'shopname' => $entity['shopName']
 		,'districtId' => $entityDistrict['id']
 		,'urbanId' 				=> $entity['urbanId']
		,'reActivityOrderNum' 	=> $entity['reActivityOrderNum']
		,'reDiscountOrderNum' 	=> $entity['reDiscountOrderNum']
		,'reConversionOrderNum' => $entity['reConversionOrderNum']
	);
	$this->RestoreFormDate($formdata);
 }
 
 function doadd()
 {
 	// 获得form页面数据
	$formDbData = array(
		'id' 					=> $this->input->post('id')
		,'shopname' 			=> $this->input->post('shopname')
		,'urbanId' 				=> $this->input->post('urbanId')
		,'reActivityOrderNum' 	=> $this->input->post('reActivityOrderNum')
		,'reDiscountOrderNum' 	=> $this->input->post('reDiscountOrderNum')
		,'reConversionOrderNum' => $this->input->post('reConversionOrderNum')
	);
	$formdata = array(
		'id' 					=> $this->input->post('id')
		,'shopname' 			=> $this->input->post('shopname')
		,'districtId' 			=> $this->input->post('districtId')
		,'urbanId' 				=> $this->input->post('urbanId')
		,'reActivityOrderNum' 	=> $this->input->post('reActivityOrderNum')
		,'reDiscountOrderNum' 	=> $this->input->post('reDiscountOrderNum')
		,'reConversionOrderNum' => $this->input->post('reConversionOrderNum')
	);
	
 	// 启用CI的form库
	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');

	$this->form_validation->set_rules('shopname', '商场 名称', 'trim|required|max_length[50]');
	$this->form_validation->set_rules('districtId', '市区', 'required');
	$this->form_validation->set_rules('urbanId', '区域', 'required');
	$this->form_validation->set_rules('reActivityOrderNum', '排序', 'required|is_numeric');
	$this->form_validation->set_rules('reDiscountOrderNum', '排序', 'required|is_numeric');
	$this->form_validation->set_rules('reConversionOrderNum', '排序', 'required|is_numeric');

	// 检查页面数据
	if ($this->form_validation->run() == FALSE)// 有错
	{
		// 恢复form数据
		$this->RestoreFormDate($formdata);
	}
	else// 无错可操作
	{
		// DB操作
		if($formdata['id'] == '')
			$result = $this->MainFshopModel->Insert($formDbData);
		else
		{
			$nowTime=date("Y-m-d H:i:s");
			$entity = $this->MainFshopModel->GetEntityById($formDbData['id']);
			$entity['shopname'] = $formDbData['shopname'];
			$entity['urbanId'] = $formDbData['urbanId'];
			$result = $this->MainFshopModel->Update($formDbData);
		}
			
		if($result=="1") // 操作成功
		{
			// 进入操作信息提示页  - 协带参数
			$data = array(
				'title' => '操作成功'
				,'message' => '商场发布成功！'
				,'nexturl' => site_url("kadmin/mainfshop")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
		else 
		{
			// 进入操作信息提示页 
			$data = array(
				'title' => '操作失败'
				,'message' => '商场发布出错：' + $result
				,'nexturl' => site_url("kadmin/mainfshop/add")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
	}
 }
 /* End Add & Eidt */
  
 
 /* del */
 function d($id='')
 {
 	if($id == '')
 	{
 		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '删除商场出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfshop")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$entity = $this->MainFshopModel->Delete($id);
	
	// 进入操作信息提示页  - 协带参数
	$this->GotoOperMsgPage('商场删除成功！');
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
			,'message' => '删除商场出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfshop")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$result = $this->MainFshopModel->Deletes($idsArray);
		
 	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$this->GotoOperMsgPage('多个商场删除成功！');
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '商场发布出错：' + $result
			,'nexturl' => site_url("kadmin/mainfshop/add")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
 }
 function GotoOperMsgPage($message)
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$shopname = '';
 	if( isset($_REQUEST['shopname']) )
 		$shopname = trim($_REQUEST['shopname']);
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
 	
	// 进入操作信息提示页 
	$data = array(
		'title' => '操作成功'
		,'message' => $message
		,'nexturl' => site_url("kadmin/mainfshop"
								.'?shopname='.$shopname
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
	$districtRows = $this->MainFdistrictModel->GetEntityAll();
	
 	// 恢复form数据
	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
		,'id' 					=> $formdata['id']
		,'shopname' 			=> $formdata['shopname']
		,'districtId' 			=> $formdata['districtId']
		,'urbanId' 				=> $formdata['urbanId']
		,'reActivityOrderNum' 	=> $formdata['reActivityOrderNum']
		,'reDiscountOrderNum' 	=> $formdata['reDiscountOrderNum']
		,'reConversionOrderNum' => $formdata['reConversionOrderNum']
		,'districtRows' 		=> $districtRows
	);
	$this->load->view('kadmin/news/mainfshopadd.php', $data);
 }
 /* End public */
 
 /* formvalidation */
 /* End formvalidation */
 
 
 
 /* getparent */
 function getparent($parentId='')
 {
 	if($parentId == '')
 	{
		// DB操作
		$entity = $this->MainFshopModel->GetEntityAll();
		#var_dump($entity);
	
		if($entity == null)
		{
			$status = false;
			$message = '获取全部有误';
			$data = json_encode($entity);
		}
		else
		{
			$status = true;
			$message = '获取全部成功';
			#$data = json_encode($entity);
			$data = $entity;
		}
		$action = new Action();
		$dataType = '';
		$action -> ajaxReturn($data,$message,$status,$dataType);
		return;
 	}
 	#var_dump($parentId);
 	
 	// DB操作
	$entity = $this->MainFshopModel->GetEntityAllByParentId($parentId);
	#var_dump($entity);

	if($entity == null)
	{
		$status = false;
		$message = '获取有误';
		$data = json_encode($entity);
	}
	else
	{
		$status = true;
		$message = '获取成功';
		#$data = json_encode($entity);
		$data = $entity;
	}
	$action = new Action();
	$dataType = '';
	$action -> ajaxReturn($data,$message,$status,$dataType);

 }
}
?>