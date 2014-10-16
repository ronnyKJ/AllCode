<?php
class MainFrame extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  $this->load->helper('url');
  
  require_once 'kadmin/businessentity/tools.php';
  
  $this->load->model('kadmin/kainfo/mainfbaseinfo_model','MainFBaseInfoModel');
  $this->load->model('kadmin/kuser/mainfuserinfo_model','MainFUserInfoModel');
  $this->load->model('kadmin/kcard/mainfcardindex_model','MainFCardIndexModel');
  $this->load->model('kadmin/message/mainfblogmessages_model','MainFBlogMessagesModel');
 }
 
 
 function index()
 {
 	// 读取网站统计信息
	#WebTotcalUser - 网站会员数
	$webStatistics = $this->MainFBaseInfoModel->GetWebStatistics();
	
	/////////////////////////////////////////////////////
	// 查询会员统计数据
 	$userCount = $this->MainFUserInfoModel->GetEntityCount(); 
  	$where = array('kState'=>0);
	$userCount0 = $this->MainFUserInfoModel->GetEntityCount($where);
	$where = array('kState'=>1);
	$userCount1 = $this->MainFUserInfoModel->GetEntityCount($where);
	$where = array('kState'=>2);
	$userCount2 = $this->MainFUserInfoModel->GetEntityCount($where);
	
 
 	/////////////////////////////////////////////////////
	// 读取卡 - 买卖卡
	$where = array(
		'state' 	=> 1
	);
	$cardForSale = $this->MainFCardIndexModel->GetEntityCountForSale($where);
	
 	
	/////////////////////////////////////////////////////
	// 读取卡 - 展示卡
	$where = array(
		'state' 	=> 1
	);
	$cardForShow = $this->MainFCardIndexModel->GetEntityCountForShow($where);	
	
	/////////////////////////////////////////////////////
	// 读取卡 - 活动卡
	$where = array(
		'state' 	=> 1
	);
	$cardForActivity = $this->MainFCardIndexModel->GetEntityCountForActivity($where);

	/////////////////////////////////////////////////////
	// 微博留言数
	$where = array(
    	'state' => '1'
    );
 	$blogCount = $this->MainFBlogMessagesModel->GetEntityCount($where);
 	$blogCountForUsers = $this->MainFBlogMessagesModel->GetEntityCountByUsers();
	
	
	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
		,'nowdate'			=> Tools::ShowDate(0,null)
		,'userCount'		=> $userCount
		,'userCount0'		=> $userCount0
		,'userCount1'		=> $userCount1
		,'userCount2'		=> $userCount2
		,'cardForSale'		=> $cardForSale
		,'cardForShow'		=> $cardForShow
		,'cardForActivity'	=> $cardForActivity
		,'blogCount'		=> $blogCount
		,'blogCountForUsers'=> $blogCountForUsers		
		
	);

	$this->load->view('kadmin/mainframe.php', $data);
 }
}
?>