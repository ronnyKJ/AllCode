<?php
class ErrorAction extends Action{
	public function index(){
		$this->assign('msg', $_GET['msg']);
		$this->display();
	}
}
?>