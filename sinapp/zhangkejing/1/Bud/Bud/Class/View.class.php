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
		//文件引用
		$content = preg_replace($this->tagPattern,"\$this->processTagType('$0')", $this->tplContent);
 //return $content;
		return preg_replace($this->tagPattern,"\$this->getTagType('$0')", $content);
	}

	private function parseLabel($label){
		$label = clearSlash($label);//filter '\'
		$content = substr($label, 1, -1);
		$arr = explode(' ', $content);
		$tag = $arr[0];//标签名
		$len = strlen($tag);
		$condition = substr($content, $len+1);//标签名后面
		$type = substr($content, 0, 1);//标签第一个字符，如$ @
		return array(
			'label' => $label,
			'content' => $content,
			'type' => $type,
			'tag' => $tag,
			'condition' => $condition
		);
	}

	private function getTagType($label){
		$label = $this->parseLabel($label);
		if(in_array($label['type'], array('$'))){
			return $this->processValType($label['type'], $label['tag']);
		}else if(in_array($label['type'], array('/'))){
			return "<?php }?>";
		}else if(in_array($label['tag'], array('if', 'else', 'foreach'))){
			return $this->processConditionType($label['tag'], $label['condition']);
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

	private function processConditionType($tag, $con){
		switch ($tag) {
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

	private function processTagType($labelStr){
		$label = $this->parseLabel($labelStr);
		if(!in_array($label['tag'], array('include'))) return clearSlash($labelStr);
		$params = $this->parseCondition($label['content']);

		switch ($label['tag']) {
			case 'include':
				$path = __ROOT__.$params['file'];
				return file_get_contents($path);
			default:
				break;
		}
	}

	private function parseCondition($condition){
		$params = array();
		$arr = explode(' ', $condition);//分隔符应该是空白字符，不是简单的空格，要改进
		foreach ($arr as $pair) {
			if(!empty($pair)){
				$tmp = explode('=', $pair);
				$params[$tmp[0]] = substr($tmp[1], 1, -1);
			}
		}
		return $params;
	}

	function render(){
		if(!Config::get('enableCache') || !$this->tplCache->checkCache()){
			//重新编译
			$str = file_get_contents($this->tplPath);
			$this->tplContent = $str;
			$str = $this->compile();
			$this->tplCache->generateCache($str);
		}
		$this->tplCache->renderCache($this->values);
	}
}
?>