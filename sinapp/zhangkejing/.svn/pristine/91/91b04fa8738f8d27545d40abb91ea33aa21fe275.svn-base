<?php
class Database{
	private static $connection = null;
	private static $dbName = '';
	private static $currentDb = null;

	static function connect($host="", $name="", $password=""){
		self::$currentDb = new SaeMysql();
	}

	static function close(){
		self::$currentDb->closeDb();
	}

	// static function creatDatabase($dbName){
	// 	if (mysql_query("CREATE DATABASE $dbName", self::$connection)){
	// 		self::$dbName = $dbName;
	// 		return true;
	// 	}else{
	// 		//mysql_error();
	// 		return false;
	// 	}	
	// }

	// static function createTable($name, $colsStr){
	// 	mysql_select_db(self::$dbName, self::$connection);
	// 	$sql = "CREATE TABLE Persons ($colsStr)";
	// 	mysql_query($sql, self::$connection);
	// }

	// static function selectDatabase($name){
	// 	self::$dbName = $name;
	// 	mysql_select_db($name, self::$connection);
	// }

	static function query($sqlStr){
		return self::$currentDb->getData($sqlStr);		
	}

	static function execute($sqlStr){
		return self::$currentDb->runSql($sqlStr);
	}
}
?>