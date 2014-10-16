<?php
class MainFUserPointsChanges extends CI_Controller {

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
 	$order = '';
 	if( isset($_REQUEST['order']) )
 		$order = trim($_REQUEST['order']);
 	$by = '';
 	if( isset($_REQUEST['by']) )
 		$by = trim($_REQUEST['by']);
	$pageIndex = '1';
 	if( isset($_REQUEST['n']) )
 		$pageIndex = trim($_REQUEST['n']);
 		

 	$kLoginName = '';
 	if( isset($_REQUEST['kLoginName']) )
 		$kLoginName = trim($_REQUEST['kLoginName']);
	$nickname = '';
 	if( isset($_REQUEST['nickname']) )
 		$nickname = trim($_REQUEST['nickname']);
 	
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
 	$this->load->model('kadmin/kuser/mainfuserpointschanges_model','MainFUserPointsChangesModel');
	$totalRowsCount = $this->MainFUserPointsChangesModel->GetEntityCount($where);
	#var_dump($totalRowsCount);
	
	/////////////////////////////////////////////////////
	// select db
	$perpage = '40';
 	$rows = $this->MainFUserPointsChangesModel->GetEntityByPage($where, $orderby, $perpage, $pageIndex);
	
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
	$this->load->view('kadmin/kuser/mainfuserpointschanges.php', $data);
 }
   
}
?>