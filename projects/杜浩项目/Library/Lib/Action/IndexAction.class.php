<?php
class IndexAction extends Action{
	public function index(){
		$this->display();
	}

	// student register
	public function register(){
		$this->display();
	}
	
	// query username in DB
	private function queryName($name)
	{
		$U = D("user_table");
		return $U->query('select id from user_table where username = "'.$name.'"');
	}
	
	//if username exists, reqquest from ajax
	public function checkNameAjax()
	{
		//check if user name in DB
		if($this->queryName($_POST['username']))
		{
			echo "1";
		}
		else
		{
			echo "0";
		}
	}
	
	//if username exists
	private function checkName()
	{
		//check if user name in DB
		if($this->queryName($_POST['username']))
		{
			$msg = 'User name existed, try another one.';
			$this->redirect('Error/index/msg/'.$msg);
			return false;
		}
		return true;
	}
	
	//user data validate
	private function userDataValidate($ifValidateName)
	{
		if($ifValidateName)
		{
			// if validated
			if(!ereg("^[a-zA-Z0-9_]{6,30}$", $_POST['username']))
			{
				$msg = 'User name is not validated.';
				$this->redirect('Error/index/msg/'.$msg);
				return false;				
			}
		
			//if user name exists
			if(!$this->checkName())
			{
				return false;
			}
		}
			
		//if password confirmed and validated
		if($_POST['password'] != $_POST['confirm'])
		{
			$msg = 'The password to confirm is different.';
			$this->redirect('Error/index/msg/'.$msg);
			return false;
		}
		else
		{
			if(!ereg("^[a-zA-Z0-9]{6,20}$", $_POST['password']))
			{
				$msg = 'Password is not validated.';
				$this->redirect('Error/index/msg/'.$msg);
				return false;				
			}		
		}
		
		//if e-mail validated
		if(!ereg("^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+", $_POST['email']))
		{
			$msg = 'E-mail is not validated.';
			$this->redirect('Error/index/msg/'.$msg);
			return false;				
		}
		
		return true;
	}
	
	// add a new borrower user
	public function addNewUser()
	{
		if(!$this->userDataValidate(true))
		{
			return;
		}
		
		$U = D("user_table");
		$type = 2;
		if($_POST['ifAdmin'] == 'on')
		{
			$type = 0;
		}
		
		// user data
		$data['username'] = $_POST['username'];
		$data['password'] = md5($_POST['password']);//encrypt
		$data['email'] = $_POST['email'];
		$data['type'] = $type;
		$uid = $U->add($data);
		if($uid)// add data success
		{
			// set SESSION attributes
			$_SESSION['state'] = true;
			$_SESSION['id'] = $uid;
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['type'] = $type;
			
			$this->redirect('main');
		}
		else
		{
			$msg = 'Database error';
			$this->redirect('Error/index/msg/'.$msg);			
		}
	}
	
	// add a new borrower user
	public function login()
	{
		$U = D("user_table");
		$q = $U->query('select id, username, email, type from user_table where username = "'.$_POST['username'].'" AND password = "'.md5($_POST['password']).'"');
		if($q)// login success
		{	
			// set SESSION attributes
			$_SESSION['state'] = true;
			$_SESSION['id'] = $q[0]['id'];
			$_SESSION['username'] = $q[0]['username'];
			$_SESSION['email'] = $q[0]['email'];
			$_SESSION['type'] = $q[0]['type'];
			
			$this->redirect('main');
		}
		else
		{
			$msg = 'User name or password is not correct';
			$this->redirect('Error/index/msg/'.$msg);				
		}
	}
	
	// user logout
	public function logout()
	{
		$_SESSION['state'] = false;
		$_SESSION['id'] = null;
		$_SESSION['username'] = null;
		$_SESSION['email'] = null;
		$_SESSION['type'] = null;		
		$this->redirect('index');
	}

	// edit user data
	public function edit()
	{
		if(!$_SESSION['state'])// if user login
		{
			$this->redirect('index');// to index
		}
		$this->assign('id', $_SESSION['id']);
		$this->assign('username', $_SESSION['username']);
		$this->assign('email', $_SESSION['email']);
		$this->display();
	}
	
	// revise user data
	public function reviseUserData()
	{
		if(!$_SESSION['state'])// if user login
		{
			$this->redirect('index');// to index
		}
		
		if(!$this->userDataValidate(false))// data illegal
		{
			return;
		}
		
		$U = D("user_table");
		$_SESSION['email'] = $email = $_POST['email'];
		$sql = 'UPDATE user_table SET password="'.md5($_POST['password']).'", email="'.$email.'" WHERE id='.$_POST['id'];
		$U->execute($sql);

		$this->assign('username', $name);
		$this->assign('email', $email);
		$this->redirect('main');
	}
	
	// main page with data
	public function main()
	{
		if($_SESSION['state'])// if user login
		{
			$this->assign('id', $_SESSION['id']);
			$this->assign('username', $_SESSION['username']);
			$this->assign('email', $_SESSION['email']);
			$type = $_SESSION['type'];
			$this->assign('usertype', $type);
		
			$B = D('book_table');
			if($type == 1) // book administrator
			{
				$bookList = $B->query('select * from book_table');
				$this->assign('bookList', $bookList);
			}
			else if($type == 2) // borrower
			{
				$borrowList = $B->query('select * from book_table where borrowerid = '.$_SESSION['id']);
				$this->assign('borrowList', $borrowList);
				$otherBooksList = $B->query('select * from book_table where borrowerid = 0');
				$this->assign('otherBooksList', $otherBooksList);				
			}
			
			$this->display();
		}
		else
		{
			$this->redirect('index');
		}
	}
	
	// check book title
	private function checkBooktitle($title)
	{
		if(strlen($title) == 0)// value empty
		{
			return true;
		}
		return ereg("[\'\"<>&/]", $title);// contain illegal char
	}
	
	// add a book
	public function addBook()
	{
		if(!$_SESSION['state'])// if user login
		{
			$this->redirect('index');// to index
		}
		$this->display();
	}
	
	// submit a book
	public function submitBook()
	{
		if($this->checkBooktitle($_POST['title']))
		{
			$msg = 'Book title connot be empty or contain \'"<>& or slash';
			$this->redirect('Error/index/msg/'.$msg);	
		}
		else
		{
			// add a new book to DB
			$book['booktitle'] = $_POST['title'];
			$book['borrowerid'] = 0;
			$B = D('book_table');
			$B->add($book);
			$this->redirect('main');		
		}
	}
	
	// edit a book
	public function editBook()
	{	
		if(!$_SESSION['state'])// if user login
		{
			$this->redirect('index');// to index
		}
		$this->assign('id', $_GET['bid']);
		$this->assign('booktitle', $_GET['booktitle']);
		$this->display();
	}
	
	// update a book
	public function updateBook()
	{
		if($this->checkBooktitle($_POST['title'])) // new title illegal
		{
			$msg = 'Book title connot be empty or contain \'"<>& or slash';
			$this->redirect('Error/index/msg/'.$msg);	
		}
		else
		{
			//update book with specific ID
			$B = D('book_table');
			$B->execute('UPDATE book_table SET booktitle = "'.$_POST['title'].'"WHERE id='.$_POST['id']);
			$this->redirect('main');
		}
	}
	
	// delete a book
	public function delBook()
	{
		if(!$_SESSION['state'])// if user login
		{
			$this->redirect('index');// to index
		}
		
		if(!$_GET['borrowerid'])
		{
			$B = D('book_table');
			$B->execute('delete from book_table where id = '.$_GET['bid']);
			$this->redirect('main');
		}
		else// the book lended out
		{
			$msg = 'The book is not returned yet.';
			$this->redirect('Error/index/msg/'.$msg);				
		}
	}
	
	// borrow a book
	public function borrowBook()
	{
		if(!$_SESSION['state'])// if user login
		{
			$this->redirect('index');// to index
		}
		
		$B = D('book_table');
		$B->execute('UPDATE book_table SET borrowerid = "'.$_SESSION['id'].'"WHERE id='.$_GET['bid']);
		$this->redirect('main');
	}
	
	// return a book
	public function returnBook()
	{
		if(!$_SESSION['state'])// if user login
		{
			$this->redirect('index');// to index
		}
		
		$B = D('book_table');
		$B->execute('UPDATE book_table SET borrowerid = 0 WHERE id='.$_GET['bid']);
		$this->redirect('main');
	}
}
?>