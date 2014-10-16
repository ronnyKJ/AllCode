<?php
class MainFCardForShow extends CI_Controller {
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
  
  $this->load->model('kadmin/kcard/MainfCardForShow_model','MainfCardForShowModel');
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
 	#var_dump($pageIndex);
 	
 	/////////////////////////////////////////////////////
 	// where 
  	$where = 'cardSetType` = 2 '; // 搜索 - 2 - 卡展示类
	if($name != '')
	{
		$where .= $where == '' ? 'name` like "%'.$name.'%" ' : ' and `name` like "%'.$name.'%" ';
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
 	$totalRowsCount = $this->MainfCardForShowModel->GetEntityCount($where);
	
 	/////////////////////////////////////////////////////
	// select db
	$perpage = '20';
 	$rows = $this->MainfCardForShowModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
 	#var_dump($rows);	

	
	// page To Index
 	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
 		,'name'		=> $name
 		,'by' 		=> $by
 		,'rows' 	=> $rows
		,'perpage' 	=> $perpage
 		,'total'	=> $totalRowsCount
	);
	
	#var_dump($data);
	$this->load->view('kadmin/kcard/mainfcardforshow.php', $data);
	
 }
 
 /* Add & Eidt */
 /* Add */

 /* End Add & Eidt */
  
 
 /* Update State */
function doUpState($id,$state)
 {
 	// DB操作
	if($id != '' && $state != '')
	{
		#$entity = $this->MainfCardForShowModel->GetEntityById($id);
		$entity['id'] = $id;
		$entity['state'] = $state == '1' ? '3' : '1'; 
		$result = $this->MainfCardForShowModel->Update($entity);
	}
		
	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$data = array(
			'title' => '操作成功'
			,'message' => '修改“卡”发布状态成功！'
			,'nexturl' => site_url("kadmin/mainfcardforshow")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '修改“卡”发布状态出错：' + $result
			,'nexturl' => site_url("kadmin/mainfcardforshow/add")
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
			,'message' => '删除“卡”出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfcardforshow")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$entity = $this->MainfCardForShowModel->Delete($id);
	
	// 进入操作信息提示页  - 协带参数
	$this->GotoOperMsgPage('卡删除成功！');
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
			,'message' => '删除“卡”出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfcardforshow")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$result = $this->MainfCardForShowModel->Deletes($idsArray);
		
 	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$this->GotoOperMsgPage('多个“卡”删除成功！');
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '卡发布出错：' + $result
			,'nexturl' => site_url("kadmin/mainfcardforshow/add")
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
 	#var_dump($pageIndex);
 	
	// 进入操作信息提示页 
	$data = array(
		'title' => '操作成功'
		,'message' => $message
		,'nexturl' => site_url("kadmin/mainfcardforshow"
								.'?name='.$name
								.'&order='.$order
								.'&by='.$by
								.'&n='.$pageIndex)
	);
	FormValidation::GotoOperMsgPage($data, $this);
 }
 /* End del */
 
 /* public */
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