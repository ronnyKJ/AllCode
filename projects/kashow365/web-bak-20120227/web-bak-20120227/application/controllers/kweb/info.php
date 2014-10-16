<?php
class Info extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  
  $this->load->helper('url');
  $this->load->library('session');
  
  require_once 'application/controllers/kweb/master.php';
  require_once 'kadmin/businessentity/websession.php';
  require_once 'kadmin/businessentity/tools/action.php';
  require_once 'kadmin/businessentity/tools/string.class.php';
  
  $this->load->model('kadmin/kuser/mainfuserinfo_model','MainFUserInfoModel');
  $this->load->model('kadmin/kcard/MainfCardForExchange_model','MainfCardForExchangeModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoad_model','MainFBaseInfoAdModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfoheari_model','MainFBaseInfoHearIModel');
  $this->load->model('kadmin/kainfo/mainfbaseinfo_model','MainFBaseInfoModel');
  $this->load->model('kadmin/news/mainfshop_model','MainFshopModel');
 } 
  
 function novice()
 {
	// 绑定面面	
	$master = new Master();	
	$master->headv2index();
	$master->topv2index($this, 'index');
	$this->load->view('kweb/info/commonleft.php');
	$this->load->view('kweb/info/novice.php');
	$master->footv2index();
 }
 
 function about()
 {
	// 绑定面面	
	$master = new Master();	
	$master->headv2index();
	$master->topv2index($this, 'index');
	$this->load->view('kweb/info/commonleft.php');
	$this->load->view('kweb/info/about.php');
	$master->footv2index();
 }
 
 function baike()
 {
	// 绑定面面	
	$master = new Master();	
	$master->headv2index();
	$master->topv2index($this, 'index');
	$this->load->view('kweb/info/commonleft.php');
	$this->load->view('kweb/info/baike.php');
	$master->footv2index();
 }
 
 function help()
 {
	// 绑定面面	
	$master = new Master();	
	$master->headv2index();
	$master->topv2index($this, 'index');
	$this->load->view('kweb/info/commonleft.php');
	$this->load->view('kweb/info/help.php');
	$master->footv2index();
 }
 
 function join()
 {
	// 绑定面面	
	$master = new Master();	
	$master->headv2index();
	$master->topv2index($this, 'index');
	$this->load->view('kweb/info/commonleft.php');
	$this->load->view('kweb/info/join.php');
	$master->footv2index();
 }
 
 
 
}
