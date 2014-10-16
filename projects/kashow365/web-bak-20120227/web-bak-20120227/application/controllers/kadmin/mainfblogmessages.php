<?php
class MainFBlogMessages extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('form');
  $this->load->helper('url');
  require_once 'kadmin/businessentity/tools/formvalidation.php';
  require_once 'kadmin/businessentity/tools/common.php';
  require_once 'kadmin/entity/dbtranslate.php';
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
	#var_dump($where);
	/////////////////////////////////////////////////////
 	// get DB entity Count
 	$this->load->model('kadmin/message/mainfblogmessages_model','MainFBlogMessagesModel');
	$totalRowsCount = $this->MainFBlogMessagesModel->GetEntityCount($where);
	#var_dump($totalRowsCount);
	
	/////////////////////////////////////////////////////
	// select db
	$perpage = '40';
 	$rows = $this->MainFBlogMessagesModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
	
 	// page To Index
 	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
 		,'content' => $content
 		,'by' => $by
 		,'rows' => $rows
 		,'perpage' => $perpage
 		,'total' => $totalRowsCount
	);
	$this->load->view('kadmin/message/mainfblogmessages.php', $data);
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
		,'userId' => '1'
		,'userName' => 'pct'
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
			,'message' => '修改“微博”出错：未传入“微博”编号'
			,'nexturl' => site_url("kadmin/mainfblogmessages")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$this->load->model('kadmin/message/mainfblogmessages_model','MainFBlogMessagesModel');
	$entity = $this->MainFBlogMessagesModel->GetEntityById($id);

	$this->load->model('kadmin/kuser/mainfuserinfo_model','MainFUserInfoModel');
	$entityUser = $this->MainFUserInfoModel->GetEntityById($entity['userId']);
	
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
		,'userId' => $entity['userId']
		,'userName' => $entityUser['nickname']
	);
	$this->RestoreFormDate($formdata);
 }
 
 function doadd()
 {
 	// 获得form页面数据
	$formDBdata = array(
		'id' => $this->input->post('id')
		,'content' => $this->input->post('content')
		,'state' => $this->input->post('state')
		,'userId' => $this->input->post('userId')
	);
	$formdata = array(
		'id' => $this->input->post('id')
		,'content' => $this->input->post('content')
		,'state' => $this->input->post('state')
		,'userId' => $this->input->post('userId')
		,'userName' => $this->input->post('hiduserName')
	);
	

 	// 启用CI的form库
	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');

	$this->form_validation->set_rules('content', '消息内容', 'trim|required|callback_max_length500');
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
		$this->load->model('kadmin/message/mainfblogmessages_model','MainFBlogMessagesModel');
		if($formDBdata['id'] == '')
			$result = $this->MainFBlogMessagesModel->Insert($formDBdata);
		else
		{
			$entity = $this->MainFBlogMessagesModel->GetEntityById($formDBdata['id']);
			$entity['content'] = $formDBdata['content'];
			$entity['state'] = $formDBdata['state'];
			$result = $this->MainFBlogMessagesModel->Update($entity);
		}
			
		if($result=="1") // 操作成功
		{
			// 进入操作信息提示页  - 协带参数
			$data = array(
				'title' => '操作成功'
				,'message' => '“微博”发布成功！'
				,'nexturl' => site_url("kadmin/mainfblogmessages")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
		else 
		{
			// 进入操作信息提示页 
			$data = array(
				'title' => '操作失败'
				,'message' => '“微博”发布出错：' + $result
				,'nexturl' => site_url("kadmin/mainfblogmessages/add")
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
	$this->load->model('kadmin/message/mainfblogmessages_model','MainFBlogMessagesModel');
	if($id != '' && $state != '')
	{
		$entity = $this->MainFBlogMessagesModel->GetEntityById($id);
		$entity['state'] = $state == '1' ? '0' : '1';
		$result = $this->MainFBlogMessagesModel->Update($entity);
	}
		
	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$data = array(
			'title' => '操作成功'
			,'message' => '修改“微博”发布状态成功！'
			,'nexturl' => site_url("kadmin/mainfblogmessages")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '修改“微博”发布状态出错：' + $result
			,'nexturl' => site_url("kadmin/mainfblogmessages/add")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
 }
 function _doUpStates($ids,$state)
 {
 	#var_dump($ids);
 	$idsArray = explode('-', $ids);
 	#var_dump($idsArray);
 	
 	if($ids == '')
 	{
 		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '审核“微博”出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfblogmessages")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$this->load->model('kadmin/message/mainfblogmessages_model','MainFBlogMessagesModel');
	$result = $this->MainFBlogMessagesModel->UpdateStates($idsArray, $state);
		
 	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$this->GotoOperMsgPage('多个“微博”审核完成！');
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '“微博”审核出错：' + $result
			,'nexturl' => site_url("kadmin/mainfblogmessages/add")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
 }
 function s0($ids='')
 {
 	$this->_doUpStates($ids, '0');
 }
 function s1($ids='')
 {
 	$this->_doUpStates($ids, '1');
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
			,'message' => '删除“微博”出错：未传入“微博”编号'
			,'nexturl' => site_url("kadmin/mainfblogmessages")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$this->load->model('kadmin/message/mainfblogmessages_model','MainFBlogMessagesModel');
	$entity = $this->MainFBlogMessagesModel->Delete($id);
	
	// 进入操作信息提示页  - 协带参数
	$this->GotoOperMsgPage('“微博”删除成功！');
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
			,'message' => '删除“微博”出错：未传入“微博”编号'
			,'nexturl' => site_url("kadmin/mainfblogmessages")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$this->load->model('kadmin/message/mainfblogmessages_model','MainFBlogMessagesModel');
	$result = $this->MainFBlogMessagesModel->Deletes($idsArray);
		
 	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$this->GotoOperMsgPage('多个“微博”删除成功！');
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '“微博”发布出错：' + $result
			,'nexturl' => site_url("kadmin/mainfblogmessages/add")
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
		,'nexturl' => site_url("kadmin/mainfblogmessages"
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
		,'userId' => $formdata['userId']
		,'userName' =>$formdata['userName']
	);
	$this->load->view('kadmin/message/mainfblogmessagesadd.php', $data);
 }
 /* End public */
 
 /* formvalidation */
 function max_length500($s)
 {
	return FormValidation::max_length500($s, $this);
 }
 /* End formvalidation */
}
?>