<?php
define('__ROOT__', $_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['SCRIPT_NAME']));//根目录
function parseUrl(){
	$tmp_uri = $_SERVER['REQUEST_URI'];
	if(strpos($tmp_uri, 'index.php') === false){
		if(substr($tmp_uri, -1) == '/'){
			$tmp_uri .= 'index.php/index';
		}else{
			$tmp_uri .= '/index.php/index';
		}
	}else{
		if(substr($tmp_uri, -10) == 'index.php/'){
			$tmp_uri .= 'index';
		}else if(substr($tmp_uri, -9) == 'index.php'){
			$tmp_uri .= '/index';
		}
	}
	return $tmp_uri;
}


/*
 * 从 ../index.php/say?_2345&d=we 中取出method
 */
function getMethodName($url){
	$arr = explode('/', $url);
	$str = $arr[count($arr)-1];
    $pos = strpos($str, '?');

    return substr($str, 0, $pos? $pos: strlen($str));
}

function getBaseUrl(){
	$url = parseUrl();
	$pos = strrpos($url, '/');
	return substr($url, 0, $pos+1);
}

function includes($path){
	require __ROOT__.$path;
}

function dump($var, $echo=true,$label=null, $strict=true)
{
    $label = ($label===null) ? '' : rtrim($label) . ' ';
    if(!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = "<pre>".$label.htmlspecialchars($output,ENT_QUOTES)."</pre>";
        } else {
            $output = $label . print_r($var, true);
        }
    }else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if(!extension_loaded('xdebug')) {
            $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
            $output = '<pre>'. $label. htmlspecialchars($output, ENT_QUOTES). '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}

function clearSlash($str){
    return str_replace('\\', '', $str);
}
?>