<?php
class ErrorAction extends Action{
	// 查询数据
	public function index(){
		$this->assign('msg', $_GET['msg']);
		$this->display();
	}
}
?>