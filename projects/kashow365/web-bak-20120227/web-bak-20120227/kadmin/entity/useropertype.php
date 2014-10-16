<?php
/**
* 网站操作分类
*/
class UserOperType  { //extends TEnum
	//定义枚举元素
	const Item0 = 1;
	const Item1 = 3;
	const Item2 = 4;
	const Item3 = 9;
	const Item4 = 10;
	const Item5 = 13;
	const Item6 = 14;
	const Item7 = 16;
	const Item8 = 8;
	const Item9 = 7;
	
	//定义枚举元素
	static  $Items = array(
		'1'=>'注册'
		,'3'=>'验证通过'
		,'4'=>'成功登录'
		,'9'=>'上传卡'
		,'10'=>'发起活动'
		,'13'=>'卖卡'
		,'14'=>'对卡留言'
		,'16'=>'发篇微博'
		,'8'=>'关注好友'
		,'7'=>'发站内消息'
		,'17'=>'分享拼卡活动给全部好友'
		,'11'=>'参与活动'
		,'12'=>'退出活动'
		,'15'=>'积分兑换卡'
	);
	

	static function GetItems()
	{
		return self::$Items;
	}
	
	/**
	* 枚举初始化。
	* @see TEnum::DoInit()
	*
	*/
	protected function DoInit() {
		/*
		self::Add(self::Item1);
		self::Add(self::Item2);
		self::Add(self::Item3);
		self::Add(self::Item4);
		self::Add(self::Item5);
		self::Add(self::Item6);
		self::Add(self::Item7);
		self::Add(self::Item8);
		self::Add(self::Item9);
		*/
	}
	
}

?>