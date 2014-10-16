<?php
class View{
	private $tplPath = '';
	private $tplCache = null;

	private $tplContent = '';
	private $values = null;

	private $tagPattern = '/\{(.*?)\}/e';

	function View($path, $values){
		$this->tplPath = __ROOT__.'/'.$path.'.tpl';
		$this->values = $values;
		$this->tplCache = new Cache($path);
	}

	private function compile(){
		return preg_replace($this->tagPattern,"\$this->getTagType('$0')", $this->tplContent);
	}

	private function getTagType($tag){
		$tagStr = str_replace('\\', '', $tag);//filter '\'
		$tagStr = substr($tagStr, 1, -1);		
		$type = substr($tagStr, 0, 1);
		if(in_array($type, array('$'))){
			return $this->processValType($type, $tagStr);
		}else{
			return $this->processConditionType($tagStr);
		}
	}

	private function processValType($type, $tagStr){
		switch ($type) {
			case '$':
				return "<?php echo $tagStr?>";
			default:
				break;
		}
	}

	private function processConditionType($tagStr){
		$char = substr($tagStr, 0, 1);
		if($char === '/'){
			return "<?php }?>";			
		}else{
			$arr = explode(' ', $tagStr);
			$len = strlen($arr[0]);
			$con = substr($tagStr, $len);
			switch ($arr[0]) {
				case 'if':
					return "<?php if($con) {?>";
				case 'else':
					return "<?php }else{?>";
				case 'foreach':
					return "<?php foreach($con) {?>";
				default:
					break;
			}		
		}
	}

	function render(){
		//重新编译
		if(!CONFIG('enableCache') || !$this->tplCache->checkCache()){
			echo "no cache";
			$str = file_get_contents($this->tplPath);
			$this->tplContent = $str;
			$str = $this->compile();
			$this->tplCache->generateCache($str);
		}
		$this->tplCache->renderCache($this->values);	
	}
}
?>