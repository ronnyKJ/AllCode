<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );


$token = array(
	"access_token" => "2.00K7GaUDxVWCjCb1c7185515EYq9DE",
	"remind_in" => "121156",
	"expires_in" => 121156,
	"uid" => "3200293070"
);

if ($token) {
	$_SESSION['token'] = $token;
	setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
}else{
	echo "授权失败";
}

// 时间间隔 秒
$interval=1;
//$uid = '2165318722';//高中化学教师id
$uid = '1579263424';//化学朱老师id

//******************************************************************************************************
$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
//$ms  = $c->home_timeline(); // done
$uid_get = $c->get_uid();
// $uid = $uid_get['uid'];

$login_user = $c->show_user_by_id($uid_get['uid']);//根据ID获取用户等基本信息
$target_user = $c->show_user_by_id($uid);//根据ID获取用户等基本信息

echo '登陆用户：'.$login_user['screen_name'].'<br><br>目标用户：'.$target_user['screen_name'].'<br><br>';

$param['uid'] = $uid;
$m = $c->oauth->get('friendships/followers/active', $param);

echo file_get_contents('http://weibo.com/2242396275/myfans');
// foreach ($m['users'] as $key => $user) {
// 	echo $user['id'].' '.$user['screen_name'];	

// 	sleep($interval);
// 	$result=$c->follow_by_id($user['id']);

// 	if($result["error"]){
// 	  echo " error:".$result["error"].'<br>';
// 	}else{
// 	  echo " success".'<br>';
// 	}
// }
?>
