<?php
class Factory{
	static function getInstance($classname){
		return new $classname;
	}
}
?>