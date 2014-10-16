<?php
class WebSession
{
 function __construct()
 {
	session_start();
 }
 
 static function IsUserLogined($CI)
 {
 	$userid = $CI->session->userdata('userId');
 	#var_dump($userid);
 	if($userid == false || $userid == '')
 		return false;
 	else
 		return true;
 }
 
 static function GetSessionDate()
 {
 	return array(
                  'userId'  	=> '',
                  'nickname'    => '',
                  'isverifyed' 	=> false
               );
 	
 }

 static function GetUserSession($CI)
 {
 	 return array(
                  'userId'  	=> $CI->session->userdata('userId'),
                  'nickname'    => $CI->session->userdata('nickname'),
                  'isverifyed' 	=> $CI->session->userdata('isverifyed')
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
 	$data = WebSession::GetSessionDate();
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
 	$data = WebSession::GetSessionDate($CI);
	$data['userId'] = $userInfoData['id'];
	$data['nickname'] = $userInfoData['nickname'];
	$data['isverifyed'] = $userInfoData['kState'] == '2' ? true : false;
	WebSession::SetUserSession($data, $CI);
 }
}