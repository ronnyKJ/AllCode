<?php
class Cache{
	private $cachePath = '';

	function Cache($path){
		$this->generateCachePath($path);
	}

	private function generateCachePath($path){
		$this->cachePath = __ROOT__.'/Cache/'.md5($path).'.php';
	}

	function getCachePath(){
		return $this->cachePath;
	}

	function checkCache(){
		return is_file($this->cachePath);
	}

	function generateCache($content){
		file_put_contents($this->cachePath, $content);
	}

	function renderCache($values){
		extract($values, OVERWRITE);
		require $this->cachePath;
	}
}
?>