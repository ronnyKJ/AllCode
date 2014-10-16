<?php
class IndexAction extends Action{
	public function index(){
		$this->assign('pswdError', Session::get('pswdError'));
		$this->assign('verifyError', Session::get('verifyError'));
		$this->display();
	}
	
	public function login(){
		$User = M('User');
		if($uaccount = $User->query('SELECT uid, uaccount FROM `think_user` WHERE uaccount="'.$_POST['account'].'" AND upassword="'.$_POST['password'].'"'))
		{
			$userid = $uaccount[0]['uid'];
			$username = $uaccount[0]['uaccount'];
			Session::set('userid', $userid);
			Session::set('username', $username);
			Session::set('loginStatus', 1);
			unset($_SESSION['pswdError']);
			unset($_SESSION['verifyError']);
			//检验验证码是否正确
			if($_SESSION['verify'] != md5($_POST['verify'])) {
				Session::set('verifyError', '验证码错误！');
				$this->redirect('index');
			}
			$this->redirect('Event/index');
		}
		else
		{
			Session::set('pswdError', "密码错误...");
			$this->redirect('index');
		}
	}
	
	public function verify(){
		$type = isset($_GET['type'])?$_GET['type']:'gif';
        import("@.ORG.Image");
        Image::buildImageVerify(4,1,$type);
	}

	public function register(){
		$this->assign('verifyError1', $_SESSION['verifyError1']);
		$this->display();
	}

	public function regSubmit(){
		//检验验证码是否正确
		if($_SESSION['verify'] != md5($_POST['verify']))
		{
			$_SESSION['verifyError1']='验证码错误！';
			$this->redirect('register');
		}
		$User = M('User');
		$User->execute('INSERT INTO think_user(uaccount, upassword) VALUE("'.$_POST['account'].'", "'.$_POST['password'].'")');
		$this->redirect('index');
	}
}
?>