<?php
class Book{
	function getBooks(){
		return Database::query('SELECT * FROM book');
	}
}
?>