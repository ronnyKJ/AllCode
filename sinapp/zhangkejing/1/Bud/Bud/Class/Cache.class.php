<?php
class Cache{
	private $cachePath = '';

	function Cache($path){
		$this->generateCachePath($path);
	}

	private function generateCachePath($path){
		$this->cachePath = SAE_TMP_PATH.md5($path).'.php';//缓存文件在SAE_TMP_PATH中
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
		extract($values, EXTR_OVERWRITE);
		require $this->cachePath;

		$debugWindow = $_GET['_d'];
		if(isset($debugWindow)){
			echo "<br><br><br><br><br><br>======================== Console ==============================";
			dump($values);
		}		
	}
}
?>