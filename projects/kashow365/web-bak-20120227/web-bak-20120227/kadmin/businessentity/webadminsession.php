<?php
class WebAdminSession
{
 function __construct()
 {
	session_start();
 }
 
 static function IsUserLogined($CI)
 {
 	$userid = $CI->session->userdata('adminId');
 	#var_dump($userid);
 	if($userid == false || $userid == '')
 		return false;
 	else
 		return true;
 }
 
 static function GetSessionDate()
 {
 	return array(
                  'adminId'   	 => '',
                  'loginName'    => '',
 				  'purviewCode'	 => array()
               );
 	
 }

 static function GetUserSession($CI)
 {
 	 return array(
                  'adminId'  	=> $CI->session->userdata('adminId'),
                  'loginName'   => $CI->session->userdata('loginName'),
 	 			  'purviewCode'   => $CI->session->userdata('purviewCode')
     );
 }
 
 static function GetUserSessionByOne($name, $CI)
 {
 	$result = $CI->session->userdata($name);
 	if(!$result)
 	{
 		$result = '';
 	}
 	
 	return $result;
 }
 
 static function SetUserSession($data, $CI)
 {
	$CI->session->set_userdata($data);
 }
 
 static function SetUserSessionByOne($name, $value, $CI)
 {
 	$CI->session->set_userdata($name, $value);
 }
 
 static function UnsetSession($CI)
 {
 	$data = WebAdminSession::GetSessionDate();
 	foreach(array_keys($data) as $key)
 	{
 		#var_dump($key);
 		$CI->session->unset_userdata($key);	
 	}
 }
 
 
 ////////////////////////////////////////////////////////////////////
 // 将会员实体创建session在线，自动配对session键
 static function SetUserSessionByDBInfo($userInfoData, $CI)
 {
 	$data = WebAdminSession::GetSessionDate($CI);
	$data['adminId'] = $userInfoData['id'];
	$data['loginName'] = $userInfoData['loginName'];
	$data['purviewCode'] = $userInfoData['purviewCode'];
	WebAdminSession::SetUserSession($data, $CI);
 }
 
 //////////////////////////////////////////////////////////////
 // 权限
 // 判断当前登录的管理员是否有当前页的操作权限
 // 返回值：0 - 未登录; '' - 没有权限; 整数 - 管理员ID 
 static function CheckUserPurviewCode($pageCode, $CI)
 {
 	$result = '';
 	
 	// 获取session中的会员ID
 	$adminId = WebAdminSession::GetUserSessionByOne('adminId', $CI);
 	if($adminId==null)
 	{ 
 		$result = 0; 
 		return $result;
 	}
 	else 
 	{
 		$result = $adminId; 
 	}
 	
 	$adminEntriy = $CI->MainFAdminInfoModel->GetEntityById($adminId);
 	#var_dump($adminEntriy);
 	if($adminEntriy!=null)
 	{
 		$purviewCodes = explode(',', $adminEntriy['purviewCode']);
 	}
 	#var_dump($purviewCodes);
 	
 	if(!in_array($pageCode, $purviewCodes))
 	{
 		$result = ''; 
 	}
 	
 	return $result;
 }
 
 static function GetSessionPurviewCode($CI)
 {
 	$purviewCodes = '';
 	
 	// 获取session中的会员ID
 	$sessionUserData = WebAdminSession::GetUserSession($CI);
 	#var_dump($sessionUserData);
 	if($sessionUserData!=null)
 	{
 		$purviewCodes = explode(',', $sessionUserData['purviewCode']);
 	}
 	return $purviewCodes;
 }
 
}