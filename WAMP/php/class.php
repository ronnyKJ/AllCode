<?php
class A{
	private $num = 0;
	function getNum(){
		return $this->num;
	}

	function setNum($n){
		$this->num = $n;
	}
}
$aa = 'A';
$a = new $aa();
echo $a->getNum();
echo $a->setNum(5);
echo $a->getNum();
echo '<br>';
echo '<br>';

class Test{
	function __construct(){
		echo '1';
		$this->name = 'XXX';
		$this->_before();
	}

	function _before(){
		echo 'in befor<br>';
	}

	function Test($a){
		echo '2';
		$this->name = $a;
	}

	function show(){
		echo $this->name;
	}
}

$test = new Test('ddd');
$test->show();
echo '<br>';
echo '<br>';

class Father{
	function __construct(){
		echo 'in father __construct<br>';
		$this->_before();
	}

	function _before(){
		echo 'in father befor<br>';
	}
}

// new Father();

class Son extends Father{
	function __construct(){
		echo 'in son __construct<br>';
		$this->_before();
	}

	function _before(){
		parent::_before();
		echo 'in son befor<br>';
	}
}

$son = new Son();
$son->_before();
?>