<?php

// DB
class DBtranslate
{
	// TKWebAnnouncement.state
	static function IsPublish($state)
	{
		$result = '';
		switch($state)
		{
			case '1':
				$result = '发布中';
				break;
			case '0':
				$result = '未发布';
				break;
			default:
				$result = '';
				break;
		}
		
		return $result;
	}
	
	// Card state
	static function IsPublishCard($state)
	{
		$result = '';
		switch($state)
		{
			case '1':
				$result = '发布中';
				break;
			case '3':
				$result = '未发布';
				break;
		}
		
		return $result;
	}
	
	// TKCardForActivity.state
	static function IsPublishActivityCard($state)
	{
		$result = '';
		switch($state)
		{
			case '0':
				$result = '已发布人数未满';
				break;
			case '1':
				$result = '人数已满';
				break;
			case '2':
				$result = '活动结束';
				break;
			case '3':
				$result = '未发布';
				break;
		}
		
		return $result;
	}
	
	// TKUserInfo.kState
	static function IsRegOK($state)
	{
		$result = '';
		switch($state)
		{
			case '1':
				$result = '已注册已验证';
				break;
			case '0':
				$result = '已注册未验证';
				break;
			case '2':
				$result = '注销';
				break;
			default:
				$result = '';
				break;
		}
		
		return $result;
	}
	
	static function IsCanLogin($state)
	{
		$result = '';
		switch($state)
		{
			case '1':
				$result = '可登录';
				break;
			case '0':
				$result = '可登录';
				break;
			case '2':
				$result = '不可登录';
				break;
			default:
				$result = '';
				break;
		}
		
		return $result;
	}
	
	static function IsCanAdIndexUserInfo($state)
	{
		$result = '';
		switch($state)
		{
			case '':
				$result = '未推荐';
				break;
			default:
				$result = '已推荐';
				break;
		}
		
		return $result;
	}
	
	static function IsAdminCanLogin($state)
	{
		$result = '';
		switch($state)
		{
			case '1':
				$result = '可登录';
				break;
			case '0':
				$result = '不可登录';
				break;
		}
		
		return $result;
	}
}

?>