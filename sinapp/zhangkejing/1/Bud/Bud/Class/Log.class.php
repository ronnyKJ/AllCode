<?php
class Log{
	static function trace($msg){
		echo $msg.' '.strval(date('Y-m-d H:i:s')).'<br>';
	}

	static function debug($msg){
		echo $msg.' '.strval(date('Y-m-d H:i:s')).'<br>';
	}	
}
?>