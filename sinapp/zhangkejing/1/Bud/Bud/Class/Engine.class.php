<?php
class Engine{
	static function start(){
		date_default_timezone_set('PRC');//时区设为东八区
		Config::init();

		$name = Config::get('dbConnectionName');
		if(!empty($name) && $name == 'CURR_SAE_SQL'){
			Database::connect();			
		}else{
			//连接其他数据库功能暂未提供
		}

		self::control();
	}

	/*
	 * 控制中心
	 */
	private function control(){
		$tmp_uri = parseUrl();
		$method = getMethodName($tmp_uri);

		$action = Factory::getInstance('ActionController');
		call_user_func_array(array($action, $method), array());

		if(Config::get('log')){
			Log::trace('ActionController::'.$method);
		}
	}
}
?>