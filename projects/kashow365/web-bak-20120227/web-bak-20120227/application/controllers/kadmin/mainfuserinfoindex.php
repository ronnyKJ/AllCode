<?php
class MainFUserInfoIndex extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('form');
  $this->load->helper('url');
  require_once 'kadmin/businessentity/tools/formvalidation.php';
  require_once 'kadmin/businessentity/tools/common.php';
  require_once 'kadmin/entity/dbtranslate.php';
  require_once 'kadmin/businessentity/tools/page.class.php';
  
  $this->load->model('kadmin/kuser/mainfuserinfo_model','MainFUserInfoModel');
  $this->load->model('kadmin/kuser/mainfuserinfoindex_model','MainFUserInfoIndexmodel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoad_model','MainFBaseInfoAdModel');
  
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
		$orderby = 'orderNum desc, wbid DESC ';
	}
 	if($by == ''){$by='d';}
	#var_dump($where);
	/////////////////////////////////////////////////////
 	// get DB entity Count
	$totalRowsCount = $this->MainFUserInfoIndexmodel->GetEntityCount($where);
	#var_dump($totalRowsCount);
	
	/////////////////////////////////////////////////////
	// select db
	$perpage = '40';
 	$rows = $this->MainFUserInfoIndexmodel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
	
 	// page To Index
 	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
 		,'kLoginName' 	=> $kLoginName
 		,'nickname' 	=> $nickname
 		,'by' 			=> $by
 		,'rows' 		=> $rows
 		,'perpage' 		=> $perpage
 		,'total' 		=> $totalRowsCount
	);
	$this->load->view('kadmin/kuser/mainfuserinfoindex.php', $data);
 }
   
 /* Update State */
 function doUpState($id,$state)
 {
 	// DB操作
	if($id != '' && $state != '')
	{
		$entity = $this->MainFUserInfoIndexmodel->GetEntityById($id);
		if($state == 1 && $entity['wbid']=='')// 创建记录
		{
			$entity = array(
				'value1' 	=> $id
				,'orderNum' => 0
				,'infoType' => 'AdIndexUserInfo'
			);
			$result = $this->MainFUserInfoIndexmodel->Insert($entity);
		}
		if($state == 0 && $entity['wbid']!='')// 删除记录
		{
			$result = $this->MainFUserInfoIndexmodel->Delete($entity['wbid']);
		}
	}
		
	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$data = array(
			'title' => '操作成功'
			,'message' => '修改“会员设置”成功！'
			,'nexturl' => site_url("kadmin/mainfuserinfoindex")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '修改“会员设置”发布状态出错：' + $result
			,'nexturl' => site_url("kadmin/mainfuserinfoindex/add")
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
			,'nexturl' => site_url("kadmin/mainfuserinfoindex")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$result = $this->MainFUserInfoIndexmodel->UpdateStates($idsArray, $state);
		
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
			,'nexturl' => site_url("kadmin/mainfuserinfoindex/add")
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
		,'nexturl' => site_url("kadmin/mainfuserinfoindex"
								.'?kLoginName='.$kLoginName
								.'&nickname='.$nickname
								.'&order='.$order
								.'&by='.$by
								.'&n='.$pageIndex)
	);
	FormValidation::GotoOperMsgPage($data, $this);
 }
 /* End del */
  
 
 /* Update State */
 function doupdate()
 {
	
 	/////////////////////////////////////////////////////
	// select db
	// 获得首页Flash集合
	// where 
  	/////////////////////////////////////////////////////
 	// where 
	$where = array(
		'infoType' => 'AdIndexUserInfo'
	);
 	$rows = $this->MainFBaseInfoAdModel->GetEntityAll($where);
 	#var_dump($rowsGrade);
 	
 	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');
	foreach ($rows as $row):
		$inputId='p'.$row['id'];
		$this->form_validation->set_rules($inputId, '排序', 'required|numeric|max_length[6]');
 	endforeach;

	 
	// 检查页面数据
	if ($this->form_validation->run() == FALSE)// 有错
	{
		// 恢复form数据
		$this->index();
	}
	else// 无错可操作
	{
	 	// DB操作
		$this->load->database();
		// start trans
    	$this->db->trans_start();
		foreach ($rows as $row):
			$inputId='p'.$row['id'];
			if(isset($_POST[$inputId]))
			{
				$entity['id'] = $row['id'];
				$entity['orderNum'] = $_POST[$inputId];
				$nowTime=date("Y-m-d H:i:s");
				$entity['updateDateTime'] = $nowTime;
				$result = $this->MainFBaseInfoAdModel->UpdateByOrderNum($entity);
			}
	 	endforeach;
	 
		// do trans
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			// 进入操作信息提示页 
			$data = array(
				'title' => '操作失败'
				,'message' => '修改出错：' + $result
				,'nexturl' => site_url('kadmin/mainfuserinfoindex')
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
		else 
		{
			$this->db->trans_commit();
			// 进入操作信息提示页  - 协带参数
			$data = array(
				'title' => '操作成功'
				,'message' => '修改成功！'
				,'nexturl' => site_url('kadmin/mainfuserinfoindex')
			);
			FormValidation::GotoOperMsgPage($data, $this);
		} 
	}
 }
 /* End Update State */
 
 /* public */
 /* End public */
 
 /* formvalidation */
 /* End formvalidation */
}
?>