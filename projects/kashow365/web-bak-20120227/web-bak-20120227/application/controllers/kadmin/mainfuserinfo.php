<?php
class MainFUserInfo extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('form');
  $this->load->helper('url');
  require_once 'kadmin/businessentity/tools/formvalidation.php';
  require_once 'kadmin/businessentity/tools/common.php';
  require_once 'kadmin/entity/dbtranslate.php';
  require_once 'kadmin/businessentity/tools/page.class.php';
 }

 function index()
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$kLoginName = '';
 	if( isset($_REQUEST['kLoginName']) )
 		$kLoginName = trim($_REQUEST['kLoginName']);
	$nickname = '';
 	if( isset($_REQUEST['nickname']) )
 		$nickname = trim($_REQUEST['nickname']);
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
 	if($nickname != '')
	{
		$where .= $where == '' ? 'nickname` like "%'.$nickname.'%" ' : ' and `nickname` like "%'.$nickname.'%" ';
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
 	$this->load->model('kadmin/kuser/mainfuserinfo_model','MainFUserInfoModel');
	$totalRowsCount = $this->MainFUserInfoModel->GetEntityCount($where);
	#var_dump($totalRowsCount);
	
	/////////////////////////////////////////////////////
	// select db
	$perpage = '40';
 	$rows = $this->MainFUserInfoModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
	
 	// page To Index
 	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
 		,'kLoginName' => $kLoginName
 		,'nickname' => $nickname
 		,'by' => $by
 		,'rows' => $rows
 		,'perpage' => $perpage
 		,'total' => $totalRowsCount
	);
	$this->load->view('kadmin/kuser/mainfuserinfo.php', $data);
 }
   
 /* Update State */
function doUpState($id,$state)
 {
 	// DB操作
	$this->load->model('kadmin/kuser/mainfuserinfo_model','MainFUserInfoModel');
	if($id != '' && $state != '')
	{
		$entity = $this->MainFUserInfoModel->GetEntityById($id);
		$entity['kstate'] = $state == '2' ? '0' : '2';
		$result = $this->MainFUserInfoModel->Update($entity);
	}
		
	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$data = array(
			'title' => '操作成功'
			,'message' => '修改“会员可否登录”成功！'
			,'nexturl' => site_url("kadmin/mainfuserinfo")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '修改“会员可否登录”发布状态出错：' + $result
			,'nexturl' => site_url("kadmin/mainfuserinfo/add")
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
			,'message' => '审核会员出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfuserinfo")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$this->load->model('kadmin/kuser/mainfuserinfo_model','MainFUserInfoModel');
	$result = $this->MainFUserInfoModel->UpdateStates($idsArray, $state);
		
 	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$this->GotoOperMsgPage('多个会员审核完成！');
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '会员审核出错：' + $result
			,'nexturl' => site_url("kadmin/mainfuserinfo/add")
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
 	$this->_doUpStates($ids, '2');
 }
 /* End Update State */
 
 function GotoOperMsgPage($message)
 {
 	// page pramas
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	$kLoginName = '';
 	if( isset($_REQUEST['kLoginName']) )
 		$kLoginName = trim($_REQUEST['kLoginName']);
	$nickname = '';
 	if( isset($_REQUEST['nickname']) )
 		$nickname = trim($_REQUEST['nickname']);
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
		,'nexturl' => site_url("kadmin/mainfuserinfo"
								.'?kLoginName='.$kLoginName
								.'&nickname='.$nickname
								.'&order='.$order
								.'&by='.$by
								.'&n='.$pageIndex)
	);
	FormValidation::GotoOperMsgPage($data, $this);
 }
 /* End del */
  
 /* public */
 /* End public */
 
 /* formvalidation */
 /* End formvalidation */
}
?>