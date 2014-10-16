<?php
class PagesAction extends Action{
	//еп╤о╣гб╫
	public function loginElse()
	{
		if(!Session::is_set('username') || Session::get('loginStatus')==0)
		{
			$this->redirect('Index/index');
		}		
	}
	//╣гЁЖ
	public function logout(){
		Session::set('loginStatus', 0);
		$this->redirect('Index/index');
	}
	
	public function init(){
		$this->loginElse();
		$uid = Session::get('userid');
		$this->assign('username', Session::get('username'));
		$this->assign('userid', $uid);
	}
	
	public function requirement(){
		$this->init();
		$this->assign('requirement', "slct");
		$this->display();
	}

	public function design(){
		$this->init();
		$this->assign('design', "slct");
		$this->display();
	}

	public function teck(){
		$this->init();
		$this->assign('teck', "slct");
		$this->display();
	}

	public function interact(){
		$this->init();
		$this->assign('interact', "slct");
		$this->display();
	}

	public function visual(){
		$this->init();
		$this->assign('visual', "slct");
		$this->display();
	}

	public function ia(){
		$this->init();
		$this->assign('ia', "slct");
		$this->display();
	}

	public function reuse(){
		$this->init();
		$this->assign('reuse', "slct");
		$this->display();
	}

	public function detail(){
		$this->init();
		$this->assign('detail', "slct");
		$this->display();
	}

	public function material(){
		$this->init();
		$this->assign('material', "slct");
		$this->display();
	}

	public function back(){
		$this->init();
		$this->assign('back', "slct");
		$this->display();
	}
	
	public function thank(){
		$this->init();
		$this->assign('thank', "slct");
		$this->display();
	}
}
?>