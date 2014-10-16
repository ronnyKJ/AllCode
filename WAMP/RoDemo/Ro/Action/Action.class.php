<?php
class Action{

	private $variables = array();

	function get($key){
		if($_SERVER['REQUEST_METHOD']=='POST') {
			return $_POST[$key];
		}else{  
			return $_GET[$key];
		}		
	}

	function set($name, $val){
		$this->variables[$name] = $val;
	}

	function view($path){
		$view = new View($path, $this->variables);
		$view->render();	
	}
}
?>