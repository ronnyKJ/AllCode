<?php


class Index extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  $this->load->helper('url');
 }

 function index()
 {
	$data = array(
		'title' => $this->config->item('AdminSystem_Title')
	);

	$this->load->view('kadmin/index.php', $data);
 }
}
?>