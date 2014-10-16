<?php
class Model{
	private $connection = null;
	private $dbName = '';

	function connect($host, $name, $password){
		$this->connection = mysql_connect($host, $name, $password);
		if (!$this->connection){
			die('Could not connect: '.mysql_error());
		}
	}

	function close(){
		mysql_close($this->connection);
	}

	function creatDatabase($dbName){
		if (mysql_query("CREATE DATABASE $dbName", $this->connection)){
			$this->dbName = $dbName;
			return true;
		}else{
			//mysql_error();
			return false;
		}	
	}

	function createTable($name, $colsStr){
		mysql_select_db($this->dbName, $this->connection);
		$sql = "CREATE TABLE Persons ($colsStr)";
		mysql_query($sql, $this->connection);
	}

	function selectDatabase($name){
		$this->dbName = $name;
		mysql_select_db($name, $this->connection);
	}

	function execute($sqlStr){
		mysql_query($sqlStr, $this->connection);
	}
}
?>