<?php
class Service{
	static function get($module){
		$path = __ROOT__.'/Model/'.$module.'.model.php';
		require $path;

		return new $module();
	}
}
?>