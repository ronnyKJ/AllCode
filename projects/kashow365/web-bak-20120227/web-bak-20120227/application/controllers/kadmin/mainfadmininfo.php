<?php
class MainFAdminInfo extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('form');
  $this->load->helper('url');
  $this->load->library('session');
  
  require_once 'kadmin/businessentity/tools/formvalidation.php';
  require_once 'kadmin/businessentity/tools/common.php';
  require_once 'kadmin/entity/dbtranslate.php';
  require_once 'kadmin/businessentity/tools/page.class.php';
  require_once 'kadmin/businessentity/webadminsession.php';
  
  $this->load->model('kadmin/kadmin/mainfadmininfo_model','MainFAdminInfoModel');
 }

 function index()
 {
  	// 获取session中的会员ID
 	$adminId = WebAdminSession::CheckUserPurviewCode('mainfadmininfo', $this);
 	#var_dump($adminId);
 	if($adminId=='')
 	{
		$this->output->set_output('非法登录 ');
 		return;
 	}
 	if($adminId=='0')
 	{
 		$this->output->set_output('登录超时 ');
 		return;
 	}
 	
 		
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$kLoginName = '';
 	if( isset($_REQUEST['kLoginName']) )
 		$kLoginName = trim($_REQUEST['kLoginName']);
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
	if($kLoginName != '')
	{
		$where = 'kLoginName` like "%'.$kLoginName.'%" ';
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
	$totalRowsCount = $this->MainFAdminInfoModel->GetEntityCount($where);
	#var_dump($totalRowsCount);
	
	/////////////////////////////////////////////////////
	// select db
	$perpage = '40';
 	$rows = $this->MainFAdminInfoModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
	
 	// page To Index
 	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
 		,'kLoginName' => $kLoginName
 		,'by' => $by
 		,'rows' => $rows
 		,'perpage' => $perpage
 		,'total' => $totalRowsCount
	);
	$this->load->view('kadmin/kadmin/mainfadmininfo.php', $data);
 }
   
 /* Update State */
function doUpState($id,$state)
 {
 	// DB操作
	if($id != '' && $state != '')
	{
		$entity = $this->MainFAdminInfoModel->GetEntityById($id);
		$entity['kstate'] = $state == '1' ? '0' : '1';
		$result = $this->MainFAdminInfoModel->Update($entity);
	}
		
	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$data = array(
			'title' => '操作成功'
			,'message' => '修改“管理员可否登录”成功！'
			,'nexturl' => site_url("kadmin/mainfadmininfo")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '修改“管理员可否登录”发布状态出错：' + $result
			,'nexturl' => site_url("kadmin/mainfadmininfo/add")
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
			,'message' => '审核管理员出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfadmininfo")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$result = $this->MainFAdminInfoModel->UpdateStates($idsArray, $state);
		
 	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$this->GotoOperMsgPage('多个管理员审核完成！');
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '管理员审核出错：' + $result
			,'nexturl' => site_url("kadmin/mainfadmininfo/add")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
 }
 function s0($ids='')
 {
 	$this->_doUpStates($ids, '0');
 }
 function s2($ids='')
 {
 	$this->_doUpStates($ids, '1');
 }
 /* End Update State */
 
 function GotoOperMsgPage($message)
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$kLoginName = '';
 	if( isset($_REQUEST['kLoginName']) )
 		$kLoginName = trim($_REQUEST['kLoginName']);
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
		,'nexturl' => site_url("kadmin/mainfadmininfo"
								.'?kLoginName='.$kLoginName
								.'&order='.$order
								.'&by='.$by
								.'&n='.$pageIndex)
	);
	FormValidation::GotoOperMsgPage($data, $this);
 }
 
 
 /* del */
 function d($id='')
 {
 	if($id == '')
 	{
 		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '删除管理员出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfadmininfo")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$entity = $this->MainFAdminInfoModel->Delete($id);
	
	// 进入操作信息提示页  - 协带参数
	$this->GotoOperMsgPage('管理员删除成功！');
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
			,'message' => '删除管理员出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfadmininfo")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$result = $this->MainFAdminInfoModel->Deletes($idsArray);
		
 	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$this->GotoOperMsgPage('多个管理员删除成功！');
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '管理员发布出错：' + $result
			,'nexturl' => site_url("kadmin/mainfadmininfo/add")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
 }
 /* End del */

 
 /* Add & Eidt */
 /* Add */
 function add()
 {
	// 恢复form数据
	$formdata = array(
		'id' 				=> ''
		,'loginName'		=> ''
		,'purviewCode'		=> ''
		,'loginPassword'	=> ''
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
			,'nexturl' => site_url("kadmin/mainfadmininfo")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$entity = $this->MainFAdminInfoModel->GetEntityById($id);
	
	if($entity == null)
	{
		$this->output->set_output('未找到实体');
		return;
	}

	// 恢复form数据
	$formdata = array(
		'id' 				=> $entity['id']
 		,'loginName'	 	=> $entity['loginName']
 		,'purviewCode' 	 	=> $entity['purviewCode']
 		,'loginPassword'	=> $entity['loginPassword']
	);
	$this->RestoreFormDate($formdata);
 }
 
 function doadd()
 {
 	// 获得form页面数据
	$formDbData = array(
		'id' 					=> $this->input->post('id')
		,'loginName' 			=> $this->input->post('loginName')
		,'purviewCode' 			=> ','.implode(',',$this->input->post('pv')).','
		,'loginPassword' 		=> ''
	);
	
 	// 启用CI的form库
	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');

	$this->form_validation->set_rules('loginName', '管理员名称', 'trim|required|max_length[50]');

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
		{
			// 初始化密码
			$entity['loginPassword'] = md5('kashow365.com');
			$entity['loginName'] = $formDbData['loginName'];
			$entity['purviewCode'] = $formDbData['purviewCode'];
			$entity['kState'] = '1';
			$result = $this->MainFAdminInfoModel->Insert($entity);
		}
		else
		{
			#$entity = $this->MainFAdminInfoModel->GetEntityById($formDbData['id']);
			$entity['id'] = $formDbData['id'];
			$entity['loginName'] = $formDbData['loginName'];
			$entity['purviewCode'] = $formDbData['purviewCode'];
			$result = $this->MainFAdminInfoModel->Update($entity);
		}
			
		if($result=="1") // 操作成功
		{
			// 进入操作信息提示页  - 协带参数
			$data = array(
				'title' => '操作成功'
				,'message' => '管理员发布成功！'
				,'nexturl' => site_url("kadmin/mainfadmininfo")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
		else 
		{
			// 进入操作信息提示页 
			$data = array(
				'title' => '操作失败'
				,'message' => '管理员发布出错：' + $result
				,'nexturl' => site_url("kadmin/mainfadmininfo/add")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
	}
 }
 /* End Add & Eidt */
 
  
 /* public */
 function RestoreFormDate($formdata)
 {
 	// 找到区域列表
	$districtRows = $this->MainFAdminInfoModel->GetEntityAll();
	
 	// 恢复form数据
	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
		,'id' 				=> $formdata['id']
		,'loginName' 		=> $formdata['loginName']
		,'purviewCode' 		=> $formdata['purviewCode']
		,'loginPassword' 	=> $formdata['loginPassword']
	);
	$this->load->view('kadmin/kadmin/mainfadmininfoadd.php', $data);
 }
 
 function CheckAdminLogin($adminId)
 {
 
 }
 
 /* End public */
 
 /* formvalidation */
 /* End formvalidation */
}
?>