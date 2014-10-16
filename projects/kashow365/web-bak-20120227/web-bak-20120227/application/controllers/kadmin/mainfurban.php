<?php
class MainFurban extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  require_once 'kadmin/businessentity/tools/formvalidation.php';
  require_once 'kadmin/businessentity/tools/action.php';
  require_once 'kadmin/businessentity/tools/common.php';
  
  $this->load->model('kadmin/news/mainfurban_model','MainFurbanModel');
 }

 function index()
 {
 	$this->output->set_output('暂无VIEW');
 }
 
 /* getparent */
 function getparent($parentId='')
 {
 	if($parentId == '')
 	{
 		// 进入操作信息提示页 
		$data = array(
			'title' => '操作失败'
			,'message' => '未能找到市 区'
			,'nexturl' => site_url("kadmin/mainfurban")
		);
		FormValidation::GotoOperMsgPage($data, $this);
		return;
 	}
 	#var_dump($parentId);
 	
 	// DB操作
	$entity = $this->MainFurbanModel->GetEntityAllByParentId($parentId);
	#var_dump($entity);

	if($entity == null)
	{
		$status = false;
		$message = '获取有误';
		$data = json_encode($entity);
	}
	else
	{
		$status = true;
		$message = '获取成功';
		#$data = json_encode($entity);
		$data = $entity;
	}
	$action = new Action();
	$dataType = '';
	$action -> ajaxReturn($data,$message,$status,$dataType);

 }
}
?>