<?php

 
abstract class TEnum {
	/**
	* 枚举元素的数组。
	*
	* @var array
	*/
	protected $FValues;
	
	/**
	* 添加元素
	*
	* @param integer $Element
	*/
	protected function Add($Element) {
		$this->FValues[$Element] = $Element;
	}
	
	/**
	* 进行初始化，定义枚举范围。
	*
	*/
	abstract protected function DoInit();
	

	/**
	* 选择枚举元素。
	*
	* @param integer $Element 元素名称
	* @return integer 元素值
	*/
	public static function Get($Element) {
		if (array_key_exists($Element, $this->FValues)) {
			return ($this->FValues[$Element]);
		}
		else {
			throw new ENotInEnum("{$Element} is not in enum {__CLASS__}"); //ENotInEnum是一个自定义的异常类。
		}
	}
	
	function __construct($Element) {
		#$this->DoInit();
		#$this->Get($Element);
	}
}
?>