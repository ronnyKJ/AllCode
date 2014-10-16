<?php
class MainFBaseInfoSale extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('form');
  $this->load->helper('url');
  require_once 'kadmin/businessentity/tools/formvalidation.php';
  require_once 'kadmin/businessentity/tools/common.php';
  require_once 'kadmin/entity/dbtranslate.php';
  
  $this->load->model('kadmin/kainfo/mainfbaseinfosale_model','MainFBaseInfoSaleModel');
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
 	
 	/////////////////////////////////////////////////////
 	// where 
  	$where = 'infoType` = \'SaleInfoIndex\' ';
	#var_dump($where);
	// order by 
 	$orderby = '';
	if($order != '')
	{
		$orderby = ($by == '' or $by == 'a')  ?  $order.'` ASC ' : $order.'` DESC ';
	}
	else
	{
		$orderby = 'orderNum DESC ';
	}
 	if($by == ''){$by='d';}
	#var_dump($orderby);
	/////////////////////////////////////////////////////
	// select db
 	$rows = $this->MainFBaseInfoSaleModel->GetEntityAll($where, $orderby);
	
 	// page To Index
 	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
 		,'by' 	=> $by
 		,'rows' => $rows
	);
	$this->load->view('kadmin/kainfo/mainfbaseinfosale.php', $data);
 }
 
 /* Add & Eidt */
 /* Add */
 function add()
 {
 	// 恢复form数据
	$formdata = array(
		'id' => ''
		,'value1' => ''
		,'orderNum' => '0'
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
			,'nexturl' => site_url("kadmin/mainfbaseinfosale")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$entity = $this->MainFBaseInfoSaleModel->GetEntityById($id);
	
	if($entity == null)
	{
		$this->output->set_output('未找到实体');
		return;
	}
	
	// 恢复form数据
	$formdata = array(
		'id' => $entity['id']
		,'value1' 	=> $entity['value1']
		,'orderNum' => $entity['orderNum']
	);
	$this->RestoreFormDate($formdata);
 }
 
 function doadd()
 {
 	// 获得form页面数据
	$formdata = array(
		'id' => $this->input->post('id')
		,'value1' 	=> $this->input->post('value1')
		,'orderNum' => $this->input->post('orderNum')
		,'infoType' => $this->input->post('infoType')
	);
	
 	// 启用CI的form库
	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');

	$this->form_validation->set_rules('value1', '宣传内容', 'trim|required|callback_max_length500');
	$this->form_validation->set_rules('orderNum', '是否发布', 'required');

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
			$result = $this->MainFBaseInfoSaleModel->Insert($formdata);
		else
		{
			$nowTime=date("Y-m-d H:i:s");
			$entity = $this->MainFBaseInfoSaleModel->GetEntityById($formdata['id']);
			$entity['value1'] = $formdata['value1'];
			$entity['orderNum'] = $formdata['orderNum'];
			$entity['updateDateTime'] =  $nowTime;
			$result = $this->MainFBaseInfoSaleModel->Update($entity);
		}
			
		if($result=="1") // 操作成功
		{
			// 进入操作信息提示页  - 协带参数
			$data = array(
				'title' => '操作成功'
				,'message' => '宣传发布成功！'
				,'nexturl' => site_url("kadmin/mainfbaseinfosale")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
		else 
		{
			// 进入操作信息提示页 
			$data = array(
				'title' => '操作失败'
				,'message' => '宣传发布出错：' + $result
				,'nexturl' => site_url("kadmin/mainfbaseinfosale/add")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
	}
 }
 /* End Add & Eidt */
  
 /* Update State */
function doUpState($id,$orderNum)
 {
 	// DB操作
	if($id != '' && $orderNum != '')
	{
		$nowTime=date("Y-m-d H:i:s");
		$entity = $this->MainFBaseInfoSaleModel->GetEntityById($id);
		$entity['orderNum'] = $orderNum == '1' ? '0' : '1';
		$entity['updateDateTime'] =  $nowTime;
		$result = $this->MainFBaseInfoSaleModel->Update($entity);
	}
		
	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$data = array(
			'title' => '操作成功'
			,'message' => '修改宣传发布状态成功！'
			,'nexturl' => site_url("kadmin/mainfbaseinfosale")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '修改宣传发布状态出错：' + $result
			,'nexturl' => site_url("kadmin/mainfbaseinfosale/add")
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
			,'message' => '删除宣传出错：未传入宣传编号'
			,'nexturl' => site_url("kadmin/mainfbaseinfosale")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$entity = $this->MainFBaseInfoSaleModel->Delete($id);
	
	// 进入操作信息提示页  - 协带参数
	$this->GotoOperMsgPage('宣传删除成功！');
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
			,'message' => '删除宣传出错：未传入宣传编号'
			,'nexturl' => site_url("kadmin/mainfbaseinfosale")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$result = $this->MainFBaseInfoSaleModel->Deletes($idsArray);
		
 	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$this->GotoOperMsgPage('多个宣传删除成功！');
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '宣传发布出错：' + $result
			,'nexturl' => site_url("kadmin/mainfbaseinfosale/add")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
 }
 function GotoOperMsgPage($message)
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
 	
	// 进入操作信息提示页 
	$data = array(
		'title' => '操作成功'
		,'message' => $message
		,'nexturl' => site_url("kadmin/mainfbaseinfosale"
								.'?order='.$order
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
		,'id' 		=> $formdata['id']
		,'value1' 	=> $formdata['value1']
		,'orderNum' => $formdata['orderNum']
	);
	$this->load->view('kadmin/kainfo/mainfbaseinfosaleadd.php', $data);
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