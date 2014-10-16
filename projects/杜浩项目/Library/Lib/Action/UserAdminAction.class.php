<?php
class UserAdminAction extends Action{
	// index page login
	public function index(){
		$this->display();
	}
	
	//get all users data
	private function getAllUser()
	{
		// get users data from DB
		$U = D("user_table");
		$bookAdminUn = $U->query('select * from user_table where type = 0');
		$bookAdminAu = $U->query('select * from user_table where type = 1');
		$userList = $U->query('select * from user_table where type = 2');

		//assgin value in the template
		$this->assign('bookAdminUn', $bookAdminUn);
		$this->assign('bookAdminAu', $bookAdminAu);
		$this->assign('userList', $userList);
	}

	//administrator login
	public function login()
	{
		$A = D("admin_table");
		if($A->query('select * from admin_table where name = "'.$_POST['name'].'" AND password = "'.$_POST['password'].'"'))
		{	
			$_SESSION['AdminState'] = true;
			$this->redirect('main');
		}
		else
		{
			$msg = "Administrator name or password error";
			$this->redirect('Error/index/msg/'.$msg);			
		}		
	}	
	
	//the main page with data
	public function main()
	{
		if($_SESSION['AdminState'])
		{
			$this->getAllUser();
			$this->display();
		}
		else
		{
			$this->redirect('index');
		}		
	}
	
	//give a book rights the manage library
	public function authorize(){
		$U = D("user_table");
		if($U->execute('UPDATE user_table SET type = 1 where id = '.$_POST['id']))
		{
			$this->getAllUser();
			$this->redirect('main');
		}
		else
		{
			$msg = "Database error";
			$this->redirect('Error/index/msg/'.$msg);			
		}
	}
	
	// check borrower with books
	public function checkUserBooks()
	{
		if(!$_SESSION['AdminState'])
		{
			$this->redirect('index');
		}
		
		$B = D("book_table");
		$list = $B->query('select * from book_table where borrowerid = '.$_GET['uid']);
		$this->assign('id', $_GET['uid']);
		$this->assign('booksList', $list);
		$this->display();
	}
}
?>