<?php
class OperMsg extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  $this->load->helper('url');
 }

 function index()
 {
	$this->okget();
 }
 
 /* ok */
 function okget()
 {
	$this->doForGet();
 }
 /* End ok */
 
 /* nook */
 function nookget()
 {
 	$this->doForGet();
 }
 /* End nook */
 
 function doForGet()
 {
 	$message = '';
 	$nexturl = '';
 	
 	parse_str($_SERVER['QUERY_STRING'],$_GET);
 	if( isset($_REQUEST['url']))
 		$nexturl = trim($_REQUEST['url']);
 	if( isset($_REQUEST['message']))
 		$message = trim($_REQUEST['message']);
 	
	$data = array(
		'title' => '操作成功'
		,'message' => $message == '' ? '提交成功': $message
		,'nexturl' => $nexturl == '' ? '#': $nexturl 
		
	);
	$this->load->view('kadmin/opermsg.php', $data);
 }
}
?>