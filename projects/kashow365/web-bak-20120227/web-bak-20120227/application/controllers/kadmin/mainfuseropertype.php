<?php
class MainFUserOperType extends CI_Controller {

 function __construct()
 {
  parent::__construct();

  $this->load->helper('form');
  $this->load->helper('url');
  require_once 'kadmin/businessentity/tools/formvalidation.php';
  require_once 'kadmin/businessentity/tools/common.php';
  require_once 'kadmin/entity/useropertype.php';
 }

 function index()
 {
	/////////////////////////////////////////////////////
	// select db
	// 获得会员等 级集合
	$this->load->model('kadmin/kuser/mainfusergrade_model','MainFUserGradeModel');
 	$rowsGrade = $this->MainFUserGradeModel->GetEntityAll();
 	#var_dump($rowsGrade);
 	
 	// 获得网站会员操作类别集合
	$userOperTypeItems = UserOperType::GetItems();
	#var_dump($userOperTypeItems);
	
	// 获得操作与积分对应关系集合
	$this->load->model('kadmin/kuser/mainfuseropertype_model','MainFUserOperTypeModel');
	$rowsOperType = $this->MainFUserOperTypeModel->GetEntityAll();
	#var_dump($rowsOperType);
	
 	// page To Index
 	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
 		,'rowsGrade' => $rowsGrade
 		,'userOperTypeItems' => $userOperTypeItems
 		,'rowsOperType' => $rowsOperType
	);
	$this->load->view('kadmin/kuser/mainfuseropertype.php', $data);
 }
   
 /* Update State */
function doupdate()
 {
 	/////////////////////////////////////////////////////
	// select db
	// 获得会员等 级集合
	$this->load->model('kadmin/kuser/mainfusergrade_model','MainFUserGradeModel');
 	$rowsGrade = $this->MainFUserGradeModel->GetEntityAll();
 	#var_dump($rowsGrade);
 	
 	// 获得网站会员操作类别集合
	$userOperTypeItems = UserOperType::GetItems();
	#var_dump($userOperTypeItems);
 	
 	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');
	
	foreach (array_keys($userOperTypeItems) as $okey):
		$isHave=false;
		foreach ($rowsGrade as $rowg):
			$inputId='pv-'.$rowg['id'].'-'.$okey;
			$this->form_validation->set_rules($inputId, '积分', 'required|integer|max_length[12]');
	 	endforeach;
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
		$this->load->model('kadmin/kuser/mainfuseropertype_model','MainFUserOperTypeModel');
		$this->load->database();
		// start trans
    	$this->db->trans_start();
		foreach (array_keys($userOperTypeItems) as $okey):
			$isHave=false;
			foreach ($rowsGrade as $rowg):
				$inputId='pv-'.$rowg['id'].'-'.$okey;
				if(isset($_POST[$inputId]))
				{
					$entity['gradeId'] = $rowg['id'];
					$entity['operType'] = $okey;
					$entity['plannedPoints'] = $_POST[$inputId];
					$entity['cname'] = $userOperTypeItems[$okey];
					$nowTime=date("Y-m-d H:i:s");
					$entity['updateDateTime'] = $nowTime;
					$result = $this->MainFUserOperTypeModel->UpdateByGidOperType($entity);
				}
		 	endforeach;
		endforeach;
	 
		// do trans
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			// 进入操作信息提示页 
			$data = array(
				'title' => '操作失败'
				,'message' => '修改“卡秀积分”出错：' + $result
				,'nexturl' => site_url("kadmin/mainfuseropertype")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		}
		else 
		{
			$this->db->trans_commit();
			// 进入操作信息提示页  - 协带参数
			$data = array(
				'title' => '操作成功'
				,'message' => '修改“卡秀积分”成功！'
				,'nexturl' => site_url("kadmin/mainfuseropertype")
			);
			FormValidation::GotoOperMsgPage($data, $this);
		} 
	}
 }
 /* End Update State */
}
?>