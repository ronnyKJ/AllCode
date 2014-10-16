<?php
class MainFUserGrade extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('form');
  $this->load->helper('url');
  require_once 'kadmin/businessentity/tools/formvalidation.php';
  require_once 'kadmin/businessentity/tools/common.php';
 }

 function index()
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$name = '';
 	if( isset($_REQUEST['name']) )
 		$name = trim($_REQUEST['name']);
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
	if($name != '')
	{
		$where = 'name` like "%'.$name.'%" ';
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
 	$this->load->model('kadmin/kuser/mainfusergrade_model','MainFUserGradeModel');
	$totalRowsCount = $this->MainFUserGradeModel->GetEntityCount($where);
		
	/////////////////////////////////////////////////////
	// select db
	$perpage = '40';
 	$rows = $this->MainFUserGradeModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
	
 	// page To Index
 	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
 		,'name' => $name
 		,'by' => $by
 		,'rows' => $rows
 		,'perpage' => $perpage
 		,'total' => $totalRowsCount
	);
	$this->load->view('kadmin/kuser/mainfusergrade.php', $data);
 }
 
 /* Add & Eidt */
 /* Add */
 function add()
 {
 	// 恢复form数据
	$formdata = array(
		'id' => ''
		,'name' => ''
		,'accumulativePoint' => '0'
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
			,'message' => '修改“会员等级”出错：未传入“会员等级”编号'
			,'nexturl' => site_url("kadmin/mainfusergrade")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$this->load->model('kadmin/kuser/mainfusergrade_model','MainFUserGradeModel');
	$entity = $this->MainFUserGradeModel->GetEntityById($id);
	
	if($entity == null)
	{
		$this->output->set_output('未找到实体');
		return;
	}
	
	// 恢复form数据
	$formdata = array(
		'id' => $entity['id']
		,'name' => $entity['name']
		,'accumulativePoint' => $entity['accumulativePoint']
	);
	$this->RestoreFormDate($formdata);
 }
 
 function doadd()
 {
 	// 获得form页面数据
	$formdata = array(
		'id' => $this->input->post('id')
		,'name' => $this->input->post('name')
		,'accumulativePoint' => $this->input->post('accumulativePoint')
	);
	
 	// 启用CI的form库
	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');

	$this->form_validation->set_rules('name', '会员等级', 'trim|required|max_length[20]');
	$this->form_validation->set_rules('accumulativePoint', '是否发布', 'required|integer');

	// 检查页面数据
	if ($this->form_validation->run() == FALSE)// 有错
	{
		// 恢复form数据
		$this->RestoreFormDate($formdata);
	}
	else// 无错可操作
	{
		// DB操作
		$this->load->model('kadmin/kuser/mainfusergrade_model','MainFUserGradeModel');
		if($formdata['id'] == '')
			$result = $this->MainFUserGradeModel->Insert($formdata);
		else
		{
			$nowTime=date("Y-m-d H:i:s");
			$entity = $this->MainFUserGradeModel->GetEntityById($formdata['id']);
			$entity['name'] = $formdata['name'];
			$entity['accumulativePoint'] = $formdata['accumulativePoint'];
			$entity['updateDateTime'] =  $nowTime;
			$result = $this->MainFUserGradeModel->Update($entity);
		}
			
		if($result=="1") // 操作成功
		{
			// 进入操作信息提示页  - 协带参数
			$data = array(
				'title' => '操作成功'
				,'message' => '“会员等级”发布成功！'
				,'nexturl' => site_url("kadmin/mainfusergrade")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
		else 
		{
			// 进入操作信息提示页 
			$data = array(
				'title' => '操作失败'
				,'message' => '“会员等级”发布出错：' + $result
				,'nexturl' => site_url("kadmin/mainfusergrade/add")
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
			,'message' => '删除“会员等级”出错：未传入“会员等级”编号'
			,'nexturl' => site_url("kadmin/mainfusergrade")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$this->load->model('kadmin/kuser/mainfusergrade_model','MainFUserGradeModel');
	$entity = $this->MainFUserGradeModel->Delete($id);
	
	// 进入操作信息提示页  - 协带参数
	$this->GotoOperMsgPage('“会员等级”删除成功！');
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
			,'message' => '删除“会员等级”出错：未传入“会员等级”编号'
			,'nexturl' => site_url("kadmin/mainfusergrade")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$this->load->model('kadmin/kuser/mainfusergrade_model','MainFUserGradeModel');
	$result = $this->MainFUserGradeModel->Deletes($idsArray);
		
 	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$this->GotoOperMsgPage('多个“会员等级”删除成功！');
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '“会员等级”发布出错：' + $result
			,'nexturl' => site_url("kadmin/mainfusergrade/add")
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
		,'nexturl' => site_url("kadmin/mainfusergrade"
								.'?name='.$name
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
		,'id' => $formdata['id']
		,'name' => $formdata['name']
		,'accumulativePoint' => $formdata['accumulativePoint']
	);
	$this->load->view('kadmin/kuser/mainfusergradeadd.php', $data);
 }
 /* End public */
 
 /* formvalidation */
 /* End formvalidation */
}
?>