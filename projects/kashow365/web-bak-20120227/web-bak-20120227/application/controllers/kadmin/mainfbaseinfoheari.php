<?php
class MainFBaseInfoHearI extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  $this->load->helper('form');
  $this->load->helper(array('form', 'url'));
  
  require_once 'kadmin/businessentity/tools/formvalidation.php';
  require_once 'kadmin/businessentity/tools/common.php';
  require_once 'kadmin/businessentity/tools/file.class.php';
  
  $this->load->model('kadmin/kainfo/mainfbaseinfoheari_model','MainFBaseInfoHearIModel');
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
  	$where = 'infoType` = \'HearInfoIndex\' ';
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
 	$rows = $this->MainFBaseInfoHearIModel->GetEntityAll($where, $orderby);
	
 	// page To Index
 	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
 		,'by' 	=> $by
 		,'rows' => $rows
	);
	$this->load->view('kadmin/kainfo/mainfbaseinfoheari.php', $data);
 }

 /* Add & Eidt */
 /* Add */
 function add()
 {
 	// 恢复form数据
	$formdata = array(
		'id' => ''
		,'value1' => ''
		,'value2' => ''
		,'orderNum' => '0'
		,'uploadError' => ''
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
			,'message' => '修改“听说”出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfbaseinfoheari")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$entity = $this->MainFBaseInfoHearIModel->GetEntityById($id);
	
	if($entity == null)
	{
		$this->output->set_output('未找到实体');
		return;
	}
	
	// 恢复form数据
	$formdata = array(
		'id' => $entity['id']
		,'value1' => $entity['value1']
		,'value2' => $entity['value2']
		,'orderNum' => $entity['orderNum']
		,'uploadError' => ''
	);
	$this->RestoreFormDate($formdata);
 }
 
 function doadd()
 {
 	// 获得form页面数据
	$formDBdata = array(
		'id' => $this->input->post('id')
		,'value1' => $this->input->post('value1')
		,'value2' => $this->input->post('value2')
		,'orderNum' => $this->input->post('orderNum')
		,'infoType' => $this->input->post('infoType')
	);
	$formdata = array(
		'id' => $this->input->post('id')
		,'value1' => $this->input->post('value1')
		,'value2' => $this->input->post('value2')
		,'orderNum' => $this->input->post('orderNum')
		,'infoType' => $this->input->post('infoType')
		,'uploadError' => ''
	);
 	// 启用CI的form库
	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');
	
	// 控件校验
	$this->form_validation->set_rules('value1', '显示文本', 'trim|required|max_length[100]');
	$this->form_validation->set_rules('orderNum', '排序', 'required|numeric|max_length[6]');
	
 	///////////////////////////////////////////////////////
	// 检查页面数据
	if ($this->form_validation->run() == FALSE)// 有错
	{		
		// 出错恢复form数据并返回
		$this->RestoreFormDate($formdata);
	}
	else// 无错可操作
	{
		// DB操作
		if($formdata['id'] == '')
		{	
 			$result = $this->MainFBaseInfoHearIModel->Insert($formDBdata);
		}
		else
		{
			$nowTime=date("Y-m-d H:i:s");
			$entity = $this->MainFBaseInfoHearIModel->GetEntityById($formDBdata['id']);
			$entity['value1'] = $formDBdata['value1'];
			$entity['value2'] = $formDBdata['value2'];
			$entity['orderNum'] = $formDBdata['orderNum'];
			$entity['updateDateTime'] =  $nowTime;
			$result = $this->MainFBaseInfoHearIModel->Update($entity);
		}
			
		if($result=="1") // 操作成功
		{
			// 进入操作信息提示页  - 协带参数
			$data = array(
				'title' => '操作成功'
				,'message' => '“听说”发布成功！'
				,'nexturl' => site_url("kadmin/mainfbaseinfoheari")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
		else 
		{
			// 进入操作信息提示页 
			$data = array(
				'title' => '操作失败'
				,'message' => '“听说”发布出错：' + $result
				,'nexturl' => site_url("kadmin/mainfbaseinfoheari/add")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
	}
 }
 /* End Add & Eidt */
 
 /* Update State */
 function doupdate()
 {
 	/////////////////////////////////////////////////////
	// select db
	// 获得首页Flash集合
	// where 
  	$where = 'infoType` = \'HearInfoIndex\' ';
 	$rows = $this->MainFBaseInfoHearIModel->GetEntityAll($where);
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
				var_dump($_POST[$inputId]);
				$nowTime=date("Y-m-d H:i:s");
				$entity['updateDateTime'] = $nowTime;
				$result = $this->MainFBaseInfoHearIModel->UpdateByOrderNum($entity);
			}
	 	endforeach;
	 
		// do trans
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			// 进入操作信息提示页 
			$data = array(
				'title' => '操作失败'
				,'message' => '修改“听说”出错：' + $result
				,'nexturl' => site_url("kadmin/mainfbaseinfoheari")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
		else 
		{
			$this->db->trans_commit();
			// 进入操作信息提示页  - 协带参数
			$data = array(
				'title' => '操作成功'
				,'message' => '修改“听说”成功！'
				,'nexturl' => site_url("kadmin/mainfbaseinfoheari")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		} 
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
			,'message' => '删除“听说”出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfbaseinfoheari")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$entity = $this->MainFBaseInfoHearIModel->Delete($id);
	
	// 进入操作信息提示页  - 协带参数
	$this->GotoOperMsgPage('“听说”删除成功！');
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
			,'message' => '删除“听说”出错：未传入编号'
			,'nexturl' => site_url("kadmin/mainfbaseinfoheari")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	
 	// DB操作
	$result = $this->MainFBaseInfoHearIModel->Deletes($idsArray);
		
 	if($result=="1") // 操作成功
	{
		// 进入操作信息提示页  - 协带参数
		$this->GotoOperMsgPage('多个“听说”删除成功！');
	}
	else 
	{
		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '“听说”发布出错：' + $result
			,'nexturl' => site_url("kadmin/mainfbaseinfoheari/add")
		);
		FormValidation::GotoOperMsgPage($data, $this);
	}
 }
 

 function GotoOperMsgPage($message)
 {
 	// 进入操作信息提示页 
	$data = array(
		'title' => '操作成功'
		,'message' => $message
		,'nexturl' => site_url("kadmin/mainfbaseinfoheari")
	);
	FormValidation::GotoOperMsgPage($data, $this);
 }
 /* del end */
 
  /* public */
 function RestoreFormDate($formdata)
 {
 	// 恢复form数据
	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
		,'id' => $formdata['id']
		,'value1' => $formdata['value1']
		,'value2' => $formdata['value2']
		,'orderNum' => $formdata['orderNum']
		,'uploadError' => $formdata['uploadError']
	);
	$this->load->view('kadmin/kainfo/mainfbaseinfoheariadd.php', $data);
	
 }
 /* End public */
}
?>