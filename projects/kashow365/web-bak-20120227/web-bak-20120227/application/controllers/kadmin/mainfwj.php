<?php
class MainFWJ extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('form');
  $this->load->helper('url');
  require_once 'kadmin/businessentity/tools/formvalidation.php';
  require_once 'kadmin/businessentity/tools/common.php';
  require_once 'kadmin/entity/dbtranslate.php';
  $this->load->model('kadmin/kainfo/mainfwjproblem_model','MainFWJProblemModel');
  $this->load->model('kadmin/kainfo/mainfwjanser_model','MainFWJAnserModel');
 }

 function index()
 {

 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$content = '';
 	if( isset($_REQUEST['content']) )
 		$content = trim($_REQUEST['content']);
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
	if($content != '')
	{
		$where = 'content` like "%'.$content.'%" ';
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
	$totalRowsCount = $this->MainFWJProblemModel->GetEntityCount($where);
		
	/////////////////////////////////////////////////////
	// select db
	$perpage = '40';
 	$rows = $this->MainFWJProblemModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
	
 	// page To Index
 	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
 		,'content' => $content
 		,'by' => $by
 		,'rows' => $rows
 		,'perpage' => $perpage
 		,'total' => $totalRowsCount
	);
	$this->load->view('kadmin/kainfo/mainfwjindex.php', $data);

 }
 

 /* Add & Eidt */
 /* Add */
 function add()
 {
 	// 恢复form数据
	$formdata = array(
		'id' => ''
		,'content' => ''
		,'state' => '0'
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
			,'message' => '修改问卷出错：未传入问卷编号'
			,'nexturl' => site_url("kadmin/mainfwj")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$entity = $this->MainFWJProblemModel->GetEntityById($id);
	
	if($entity == null)
	{
		$this->output->set_output('未找到实体');
		return;
	}
	
	// 恢复form数据
	$formdata = array(
		'id' => $entity['id']
		,'content' => $entity['content']
		,'state' => $entity['state']
	);
	$this->RestoreFormDate($formdata);
 }
 
 function doadd()
 {
 	// 获得form页面数据
	$formdata = array(
		'id' => $this->input->post('id')
		,'content' => $this->input->post('content')
		,'state' => $this->input->post('state')
	);
	
 	// 启用CI的form库
	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');

	$this->form_validation->set_rules('content', '问卷内容', 'trim|required|callback_max_length500');
	$this->form_validation->set_rules('state', '是否发布', 'required');

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
			$result = $this->MainFWJProblemModel->Insert($formdata);
		else
		{
			$nowTime=date("Y-m-d H:i:s");
			$entity = $this->MainFWJProblemModel->GetEntityById($formdata['id']);
			$entity['content'] = $formdata['content'];
			$entity['state'] = $formdata['state'];
			$entity['updateDateTime'] =  $nowTime;
			$result = $this->MainFWJProblemModel->Update($entity);
		}
			
		if($result=="1") // 操作成功
		{
			// 进入操作信息提示页  - 协带参数
			$data = array(
				'title' => '操作成功'
				,'message' => '问卷发布成功！'
				,'nexturl' => site_url("kadmin/mainfwj")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
		else 
		{
			// 进入操作信息提示页 
			$data = array(
				'title' => '操作失败'
				,'message' => '问卷发布出错：' + $result
				,'nexturl' => site_url("kadmin/mainfwj/add")
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
		$nowTime=date("Y-m-d H:i:s");
		$entity = $this->MainFWJProblemModel->GetEntityById($id);
		$entity['state'] = $state == '1' ? '0' : '1';
		$result = $this->MainFWJProblemModel->Update($entity);
	}
		
	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$data = array(
			'title' => '操作成功'
			,'message' => '修改问卷发布状态成功！'
			,'nexturl' => site_url("kadmin/mainfwj")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '修改问卷发布状态出错：' + $result
			,'nexturl' => site_url("kadmin/mainfwj/add")
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
			,'message' => '删除问卷出错：未传入问卷编号'
			,'nexturl' => site_url("kadmin/mainfwj")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$entity = $this->MainFWJProblemModel->Delete($id);
	
	// 进入操作信息提示页  - 协带参数
	$this->GotoOperMsgPage('问卷删除成功！');
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
			,'message' => '删除问卷出错：未传入问卷编号'
			,'nexturl' => site_url("kadmin/mainfwj")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$result = $this->MainFWJProblemModel->Deletes($idsArray);
		
 	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$this->GotoOperMsgPage('多个问卷删除成功！');
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '问卷发布出错：' + $result
			,'nexturl' => site_url("kadmin/mainfwj/add")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
 }
 function GotoOperMsgPage($message)
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$content = '';
 	if( isset($_REQUEST['content']) )
 		$content = trim($_REQUEST['content']);
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
		,'nexturl' => site_url("kadmin/mainfwj"
								.'?content='.$content
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
		,'content' => $formdata['content']
		,'state' => $formdata['state']
	);
	$this->load->view('kadmin/kainfo/mainfwjadd.php', $data);
 }
 /* End public */
 
 /* formvalidation */
 function max_length500($s)
 {
	return FormValidation::max_length500($s, $this);
 }
 /* End formvalidation */
 
 
 public function getansers($pid)
 {
	$where = array(
		'problemId' 	=> $pid
	);
	$orderby = 'orderNum desc';
 	$wjA = $this->MainFWJAnserModel->GetEntityAll($where, $orderby);
 	return $wjA ;
 }
}
?>