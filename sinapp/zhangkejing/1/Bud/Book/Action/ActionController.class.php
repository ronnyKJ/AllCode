<?php
class ActionController extends Action{
	function index(){
		$title = $this->get('title');
		$this->set('title', $title);

		$this->getBooks();
		
		$this->view('View/tpl/index');
	}

	function say(){
		$this->getBooks();

		$this->set('saying', 'This is a saying!');
		$this->set('good', 'This is good!');
		$this->set('arr', array(
				'name' => 'ronny',
				'job' => 'engineer',
				'friends' => array('dom'=>'Dom'),
				'language' => array('English', 'Chinese')
			));
		$this->view('View/tpl/say');
	}

	function play(){
		$this->set('title', 'This is a playing!');
		$this->view('View/tpl/play');		
	}

	private function getBooks(){
		$book = Service::get('Book');
		$books = $book->getBooks();
		$this->set('books', $books);
	}
}
?>