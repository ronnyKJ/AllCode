<?php
class Config{
	private static $_CONF = array();

	static function init(){
        $defaultConfPath = dirname(dirname(__FILE__));
        $defaultJson = file_get_contents($defaultConfPath.'/Config/config.cfg');//这里难道不能用相对路径
        $defaultConf = json_decode($defaultJson, true);

        $userJson = file_get_contents(__ROOT__.'/Config/config.cfg');
        $userConf = json_decode($userJson, true);
        
        self::$_CONF = array_merge($defaultConf, $userConf);
	}

	static function get($key){
		return self::$_CONF[$key];
	}
}
?>