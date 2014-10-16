<?php
class ActionController extends Action{
	function index(){
		$a = $this->get('a');
		$this->set('title', $a);
		$this->view('View/index');
	}

	function say(){
		$this->set('saying', 'This is a saying!');
		$this->set('good', 'This is good!');
		$this->set('arr', array(
				'name' => 'ronny',
				'job' => 'engineer',
				'friends' => array('dom'=>'Dom'),
				'language' => array('English', 'Chinese')
			));
		$this->view('View/say');
	}

	function play(){
		$this->set('title', 'This is a playing!');
		$this->view('View/play');		
	}	
}
?>