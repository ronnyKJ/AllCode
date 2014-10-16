<?php
class MainFshopnews4 extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('form');
  $this->load->helper('url');
  
  require_once 'kadmin/businessentity/tools/formvalidation.php';
  require_once 'kadmin/businessentity/tools/common.php';
  require_once 'kadmin/entity/dbtranslate.php';
  
  $this->load->model('kadmin/news/mainfshopnews_model','MainFshopnewsModel');
 }

 function index()
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$newsTitle = '';
 	if( isset($_REQUEST['newsTitle']) )
 		$newsTitle = trim($_REQUEST['newsTitle']);
	
	$state = '';
 	if( isset($_REQUEST['state']) )
 		$state = trim($_REQUEST['state']);
 		
 	$orderNum = '';
 	if( isset($_REQUEST['orderNum']) )
 		$orderNum = trim($_REQUEST['orderNum']);
 		
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
  	$where = 'newsType` = 4 '; // 搜索 - 网站公告
	if($newsTitle != '')
	{
		$where .= $where == '' ? 'newsTitle` like "%'.$newsTitle.'%" ' : ' and `newsTitle` like "%'.$newsTitle.'%" ';
	}
 	if($state != '')
	{
		$where .= $where == '' ? 'state`='.$state : ' and `state`='.$state;
	}
 	if($orderNum != '')
	{
		$where .= $where == '' ? 'orderNum`='.$orderNum : ' and `orderNum`='.$orderNum;
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
	$totalRowsCount = $this->MainFshopnewsModel->GetEntityCount($where);
	#var_dump($totalRowsCount);
	#var_dump($where);
	#var_dump($orderby);
	/////////////////////////////////////////////////////
	// select db
	$perpage = '40';
 	$rows = $this->MainFshopnewsModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
 	#var_dump($rows);

	// page To Index
 	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
 		,'newsTitle' 	=> $newsTitle
 		,'state' 		=> $state
 		,'orderNum' 	=> $orderNum
 		
 		,'by' => $by

 		,'rows' => $rows
 		
 		,'perpage' => $perpage
 		,'total' => $totalRowsCount

	);
	
	#var_dump($data);
	$this->load->view('kadmin/news/mainfshopnews4.php', $data);
	
 }
 
 /* Add & Eidt */
 /* Add */
 function add()
 {
	// 恢复form数据
	$formdata = array(
		'id' => ''
 		,'newsTitle' => ''
 		,'newsContent' => ''
 		,'newsSummary' => ''
 		,'state' => ''
 		,'orderNum' => '0'
 		,'startDate' => null
 		,'endDate' => null
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
			,'message' => '修改“公告”出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfshopnews4")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$entity = $this->MainFshopnewsModel->GetEntityById($id);
	
	if($entity == null)
	{
		$this->output->set_output('未找到实体');
		return;
	}
	
	$this->load->model('kadmin/news/mainfdistrict_model','MainFdistrictModel');
	$entityDistrict = $this->MainFdistrictModel->GetDistrictEntityById($entity['urbanId']);
		
	// 恢复form数据
	$formdata = array(
		'id' 			=> $entity['id']
 		,'newsTitle' 	=> $entity['newsTitle']
 		,'newsContent' 	=> $entity['newsContent']
		,'newsSummary' 	=> $entity['newsSummary']
 		,'state' 		=> $entity['state']
 		,'orderNum' 	=> $entity['orderNum']
 		,'startDate' 	=> $entity['startDate']
 		,'endDate' 		=> $entity['endDate']
	);
	$this->RestoreFormDate($formdata);
 }
 
 function doadd()
 {
 	#var_dump($this->input->post('newsContent'));
 	// 获得form页面数据
	$formDbData = array(
		'id' 				=> $this->input->post('id')
 		,'newsTitle' 		=> $this->input->post('newsTitle')
 		,'newsContent' 		=> $this->input->post('newsContent')
 		,'newsSummary' 		=> $this->input->post('newsSummary')
 		,'state' 			=> $this->input->post('state')
 		,'orderNum' 		=> $this->input->post('orderNum')
 		,'startDate' 		=> $this->input->post('startDate') == '' ? null : $this->input->post('startDate')
 		,'endDate' 			=> $this->input->post('endDate') == '' ? null : $this->input->post('endDate')
 		,'newsType' 		=> '4' // 公告
	);
	
	$formdata = array(
		'id' 				=> $this->input->post('id')
 		,'newsTitle' 		=> $this->input->post('newsTitle')
 		,'newsContent' 		=> $this->input->post('newsContent')
		,'newsSummary' 		=> $this->input->post('newsSummary')
 		,'state' 			=> $this->input->post('state')
 		,'startDate' 		=> $this->input->post('startDate') == '' ? null : $this->input->post('startDate')
 		,'endDate' 			=> $this->input->post('endDate') == '' ? null : $this->input->post('endDate')
 		,'orderNum' 		=> $this->input->post('orderNum')
	);
	
 	// 启用CI的form库
	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');
	
	$this->form_validation->set_rules('newsTitle', '标题', 'trim|required|max_length[100]');
	$this->form_validation->set_rules('newsSummary', '摘要', 'trim|required|max_length[500]');
	$this->form_validation->set_rules('state', '状态', 'required');
	$this->form_validation->set_rules('orderNum', '排序', 'required|numeric');

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
			$result = $this->MainFshopnewsModel->Insert($formDbData);
		else
		{
			$nowTime=date("Y-m-d H:i:s");
			$entity = $this->MainFshopnewsModel->GetEntityById($formDbData['id']);
			$entity['newsTitle'] 	= $formDbData['newsTitle'];
			$entity['newsContent'] 	= $formDbData['newsContent'];
			$entity['newsSummary'] 	= $formDbData['newsSummary'];
			$entity['state'] 		= $formDbData['state'];
			$entity['orderNum'] 	= $formDbData['orderNum'];
			$entity['startDate'] 	= $formDbData['startDate'];
			$entity['endDate'] 		= $formDbData['endDate'];
			$result = $this->MainFshopnewsModel->Update($formDbData);
		}
			
		if($result=="1") // 操作成功
		{
			// 进入操作信息提示页  - 协带参数
			$data = array(
				'title' => '操作成功'
				,'message' => '“公告”发布成功！'
				,'nexturl' => site_url("kadmin/mainfshopnews4")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
		else 
		{
			// 进入操作信息提示页 
			$data = array(
				'title' => '操作失败'
				,'message' => '“公告”发布出错：' + $result
				,'nexturl' => site_url("kadmin/mainfshopnews4/add")
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
		$entity = $this->MainFshopnewsModel->GetEntityById($id);
		$entity['state'] = $state == '1' ? '0' : '1';
		$result = $this->MainFshopnewsModel->Update($entity);
	}
		
	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$data = array(
			'title' => '操作成功'
			,'message' => '修改“公告”发布状态成功！'
			,'nexturl' => site_url("kadmin/mainfshopnews4")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '修改“公告”发布状态出错：' + $result
			,'nexturl' => site_url("kadmin/mainfshopnews4/add")
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
			,'message' => '删除“公告”出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfshopnews4")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$entity = $this->MainFshopnewsModel->Delete($id);
	
	// 进入操作信息提示页  - 协带参数
	$this->GotoOperMsgPage('公告删除成功！');
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
			,'message' => '删除“公告”出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfshopnews4")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$result = $this->MainFshopnewsModel->Deletes($idsArray);
		
 	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$this->GotoOperMsgPage('多个“公告”删除成功！');
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '公告发布出错：' + $result
			,'nexturl' => site_url("kadmin/mainfshopnews4/add")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
 }
 function GotoOperMsgPage($message)
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$newsTitle = '';
 	if( isset($_REQUEST['newsTitle']) )
 		$newsTitle = trim($_REQUEST['newsTitle']);
 		
	$state = '';
 	if( isset($_REQUEST['state']) )
 		$state = trim($_REQUEST['state']);
 		
 	$orderNum = '';
 	if( isset($_REQUEST['orderNum']) )
 		$orderNum = trim($_REQUEST['orderNum']);
 		
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
		,'nexturl' => site_url("kadmin/mainfshopnews4"
								.'?newsTitle='.$newsTitle
								.'&state='.$state
								.'&orderNum='.$orderNum
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
 	// 恢复form数据
	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
		,'id' 			=> $formdata['id']
 		,'newsTitle' 	=> $formdata['newsTitle']
 		,'newsContent' 	=> $formdata['newsContent']
 		,'newsSummary' 	=> $formdata['newsSummary']
 		,'state' 		=> $formdata['state']
 		,'orderNum' 	=> $formdata['orderNum']
 		,'startDate' 	=> $formdata['startDate']
 		,'endDate' 		=> $formdata['endDate']
	);
	#var_dump($data);
	$this->load->view('kadmin/news/mainfshopnewsadd4.php', $data);
 }
 /* End public */
 
 /* formvalidation */
 /* End formvalidation */
}
?>