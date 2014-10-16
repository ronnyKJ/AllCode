<?php
// +----------------------------------------------------------------------
// | ThinkPHP
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

/**
 +------------------------------------------------------------------------------
 * Think公共函数库
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Common
 * @author   liu21st <liu21st@gmail.com>
 * @version  $Id$
 +------------------------------------------------------------------------------
 */

// URL组装 支持不同模式和路由
function U($url,$params=array(),$redirect=false) {
    if(0===strpos($url,'/')) {
        $url   =  substr($url,1);
    }
    if(!strpos($url,'://')) {// 没有指定项目名 使用当前项目名
        $url   =  APP_NAME.'://'.$url;
    }
    if(stripos($url,'@?')) { // 给路由传递参数
        $url   =  str_replace('@?','@think?',$url);
    }elseif(stripos($url,'@')) { // 没有参数的路由
        $url   =  $url.MODULE_NAME;
    }
    // 分析URL地址
    $array   =  parse_url($url);
    $app      =  isset($array['scheme'])?   $array['scheme']  :APP_NAME;
    $route    =  isset($array['user'])?$array['user']:'';
    if(isset($array['path'])) {
        $action  =  substr($array['path'],1);
        if(!isset($array['host'])) {
            // 没有指定模块名
            $module = MODULE_NAME;
        }else{// 指定模块
            $module = $array['host'];
        }
    }else{ // 只指定操作
        $module = MODULE_NAME;
        $action   =  $array['host'];
    }
    if(isset($array['query'])) {
        parse_str($array['query'],$query);
        $params = array_merge($query,$params);
    }
    if(C('DISPATCH_ON') && C('URL_MODEL')>0) {
        $depr = C('PATH_MODEL')==2?C('PATH_DEPR'):'/';
        $str    =   $depr;
        foreach ($params as $var=>$val)
            $str .= $var.$depr.$val.$depr;
        $str = substr($str,0,-1);
        if(!empty($route)) {
            $url    =   str_replace(APP_NAME,$app,__APP__).'/'.$route.$str;
        }else{
            $url    =   str_replace(APP_NAME,$app,__APP__).'/'.$module.$depr.$action.$str;
        }
        if(C('HTML_URL_SUFFIX')) {
            $url .= C('HTML_URL_SUFFIX');
        }
    }else{
        $params =   http_build_query($params);
        $url    =   str_replace(APP_NAME,$app,__APP__).'?'.C('VAR_MODULE').'='.$module.'&'.C('VAR_ACTION').'='.$action.'&'.$params;
    }
    if($redirect) {
        redirect($url);
    }else{
        return $url;
    }
}

// 错误输出
function halt($error) {
    if(IS_CLI) {
        exit ($error);
    }
    $e = array();
    if(C('DEBUG_MODE')){
        //调试模式下输出错误信息
        if(!is_array($error)) {
            $trace = debug_backtrace();
            $e['message'] = $error;
            $e['file'] = $trace[0]['file'];
            $e['class'] = $trace[0]['class'];
            $e['function'] = $trace[0]['function'];
            $e['line'] = $trace[0]['line'];
            $traceInfo='';
            $time = date("y-m-d H:i:m");
            foreach($trace as $t)
            {
                $traceInfo .= '['.$time.'] '.$t['file'].' ('.$t['line'].') ';
                $traceInfo .= $t['class'].$t['type'].$t['function'].'(';
                $traceInfo .= implode(', ', $t['args']);
                $traceInfo .=")<br/>";
            }
            $e['trace']  = $traceInfo;
        }else {
            $e = $error;
        }
        if(C('EXCEPTION_TMPL_FILE')) {
            // 定义了异常页面模板
            include C('EXCEPTION_TMPL_FILE');
        }else{
            // 使用默认的异常模板文件
            include THINK_PATH.'/Tpl/ThinkException.tpl.php';
        }
    }
    else
    {
        //否则定向到错误页面
        $error_page =   C('ERROR_PAGE');
        if(!empty($error_page)){
            redirect($error_page);
        }else {
            if(C('SHOW_ERROR_MSG')) {
                $e['message'] =  is_array($error)?$error['message']:$error;
            }else{
                $e['message'] = C('ERROR_MESSAGE');
            }
            if(C('EXCEPTION_TMPL_FILE')) {
                // 定义了异常页面模板
                include C('EXCEPTION_TMPL_FILE');
            }else{
                // 使用默认的异常模板文件
                include THINK_PATH.'/Tpl/ThinkException.tpl.php';
            }
        }
    }
    exit;
}

// URL重定向
function redirect($url,$time=0,$msg='')
{
    //多行URL地址支持
    $url = str_replace(array("\n", "\r"), '', $url);
    if(empty($msg)) {
        $msg    =   "系统将在{$time}秒之后自动跳转到{$url}！";
    }
    if (!headers_sent()) {
        // redirect
        if(0===$time) {
            header("Location: ".$url);
        }else {
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        exit();
    }else {
        $str    = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if($time!=0) {
            $str   .=   $msg;
        }
        exit($str);
    }
}

// 自定义异常处理
function throw_exception($msg,$type='ThinkException',$code=0)
{
    if(IS_CLI) {
        exit($msg);
    }
    if(class_exists($type,false)){
        throw new $type($msg,$code,true);
    }else {
        // 异常类型不存在则输出错误信息字串
        halt($msg);
    }
}

// 区间调试开始
function debug_start($label='')
{
    $GLOBALS[$label]['_beginTime'] = microtime(TRUE);
    if ( MEMORY_LIMIT_ON )  $GLOBALS[$label]['memoryUseStartTime'] = memory_get_usage();
}

// 区间调试结束，显示指定标记到当前位置的调试
function debug_end($label='')
{
    $GLOBALS[$label]['_endTime'] = microtime(TRUE);
    echo '<div style="text-align:center;width:100%">Process '.$label.': Times '.number_format($GLOBALS[$label]['_endTime']-$GLOBALS[$label]['_beginTime'],6).'s ';
    if ( MEMORY_LIMIT_ON )  {
        $GLOBALS[$label]['memoryUseEndTime'] = memory_get_usage();
        echo ' Memories '.number_format(($GLOBALS[$label]['memoryUseEndTime']-$GLOBALS[$label]['memoryUseStartTime'])/1024).' k';
    }
    echo '</div>';
}

// 浏览器友好的变量输出
function dump($var, $echo=true,$label=null, $strict=true)
{
    $label = ($label===null) ? '' : rtrim($label) . ' ';
    if(!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = "<pre>".$label.htmlspecialchars($output,ENT_QUOTES)."</pre>";
        } else {
            $output = $label . " : " . print_r($var, true);
        }
    }else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if(!extension_loaded('xdebug')) {
            $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
            $output = '<pre>'
                    . $label
                    . htmlspecialchars($output, ENT_QUOTES)
                    . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else {
        return $output;
    }
}

// 取得对象实例 支持调用类的静态方法
function get_instance_of($className,$method='',$args=array())
{
    static $_instance = array();
    if(empty($args)) {
        $identify   =   $className.$method;
    }else{
        $identify   =   $className.$method.to_guid_string($args);
    }
    if (!isset($_instance[$identify])) {
        if(class_exists($className)){
            $o = new $className();
            if(method_exists($o,$method)){
                if(!empty($args)) {
                    $_instance[$identify] = call_user_func_array(array(&$o, $method), $args);
                }else {
                    $_instance[$identify] = $o->$method();
                }
            }
            else
                $_instance[$identify] = $o;
        }
        else
            halt(L('_CLASS_NOT_EXIST_').':'.$className);
    }
    return $_instance[$identify];
}

/**
 +----------------------------------------------------------
 * 系统自动加载ThinkPHP基类库和当前项目的model和Action对象
 * 并且支持配置自动加载路径
 +----------------------------------------------------------
 * @param string $classname 对象类名
 +----------------------------------------------------------
 * @return void
 +----------------------------------------------------------
 */
function __autoload($classname)
{
    // 自动加载当前项目的Actioon类和Model类
    if(substr($classname,-5)=="Model") {
        require_cache(LIB_PATH.'Model/'.$classname.'.class.php');
    }elseif(substr($classname,-6)=="Action"){
        require_cache(LIB_PATH.'Action/'.$classname.'.class.php');
    }else {
        // 检查是否存在别名定义
        if(alias_import($classname)) return ;
        // 根据自动加载路径设置进行尝试搜索
        if(C('AUTO_LOAD_PATH')) {
            $paths  =   explode(',',C('AUTO_LOAD_PATH'));
            foreach ($paths as $path){
                if(import($path.$classname)) {
                    // 如果加载类成功则返回
                    return ;
                }
            }
        }
    }
    return ;
}

// 优化的require_once
function require_cache($filename)
{
    static $_importFiles = array();
    $filename   =  realpath($filename);
    if (!isset($_importFiles[$filename])) {
        if(file_exists_case($filename)){
            require $filename;
            $_importFiles[$filename] = true;
        }
        else
        {
            $_importFiles[$filename] = false;
        }
    }
    return $_importFiles[$filename];
}

// 区分大小写的文件存在判断
function file_exists_case($filename) {
    if(is_file($filename)) {
        if(IS_WIN && C('CHECK_FILE_CASE')) {
            if(basename(realpath($filename)) != basename($filename)) {
                return false;
            }
        }
        return true;
    }
    return false;
}

/**
 +----------------------------------------------------------
 * 导入所需的类库 同java的Import
 * 本函数有缓存功能
 +----------------------------------------------------------
 * @param string $class 类库命名空间字符串
 * @param string $baseUrl 起始路径
 * @param string $ext 导入的文件扩展名
 +----------------------------------------------------------
 * @return boolen
 +----------------------------------------------------------
 */
function import($class,$baseUrl = '',$ext='.class.php')
{
    static $_file = array();
    static $_class = array();
    $class    =   str_replace(array('.','#'), array('/','.'), $class);
    if('' === $baseUrl && false === strpos($class,'/')) {
        // 检查别名导入
        return alias_import($class);
    }    //echo('<br>'.$class.$baseUrl);
    if(isset($_file[$class.$baseUrl]))
        return true;
    else
        $_file[$class.$baseUrl] = true;
    $class_strut = explode("/",$class);
    if(empty($baseUrl)) {
        if('@'==$class_strut[0] || APP_NAME == $class_strut[0] ) {
            //加载当前项目应用类库
            $baseUrl   =  dirname(LIB_PATH);
            $class =  str_replace(array(APP_NAME.'/','@/'),LIB_DIR.'/',$class);
        }elseif(in_array(strtolower($class_strut[0]),array('think','org','com'))) {
            //加载ThinkPHP基类库或者公共类库
            // think 官方基类库 org 第三方公共类库 com 企业公共类库
            $baseUrl =  THINK_PATH.'/Lib/';
        }else {
            // 加载其他项目应用类库
            $class    =   substr_replace($class, '', 0,strlen($class_strut[0])+1);
            $baseUrl =  APP_PATH.'/../'.$class_strut[0].'/'.LIB_DIR.'/';
        }
    }
    if(substr($baseUrl, -1) != "/")    $baseUrl .= "/";
    $classfile = $baseUrl . $class . $ext;
    if($ext == '.class.php' && is_file($classfile)) {
        // 冲突检测
        $class = basename($classfile,$ext);
        if(isset($_class[$class])) {
            throw_exception(L('_CLASS_CONFLICT_').':'.$_class[$class].' '.$classfile);
        }
        $_class[$class] = $classfile;
    }
    //导入目录下的指定类库文件
    return require_cache($classfile);
}

// 快速导入第三方框架类库
// 所有第三方框架的类库文件统一放到 系统的Vendor目录下面
// 并且默认都是以.php后缀导入
function vendor($class,$baseUrl = '',$ext='.php')
{
    if(empty($baseUrl)) {
        $baseUrl    =   VENDOR_PATH;
    }
    return import($class,$baseUrl,$ext);
}

// 快速定义和导入别名
function alias_import($alias,$classfile='') {
    static $_alias   =  array();
    if('' !== $classfile) {
        // 定义别名导入
        $_alias[$alias]  = realpath($classfile);
        return ;
    }
    if(is_string($alias)) {
        if(isset($_alias[$alias])) {
            return require_cache($_alias[$alias]);
        }
    }elseif(is_array($alias)){
        foreach ($alias as $key=>$val){
            $_alias[$key]  =  realpath($val);
        }
        return ;
    }
    return false;
}

/**
 +----------------------------------------------------------
 * D函数用于实例化Model
 +----------------------------------------------------------
 * @param string className Model名称
 * @param string appName Model所在项目
 +----------------------------------------------------------
 * @return Model
 +----------------------------------------------------------
 */
function D($className='',$appName='')
{
    static $_model = array();
    if(empty($className)) {
        return new  Model();
    }
    if(empty($appName)) {
        $appName =  C('DEFAULT_MODEL_APP');
    }
    if(isset($_model[$appName.$className])) {
        return $_model[$appName.$className];
    }
    $OriClassName = $className;
    $className =  $className.'Model';
    if('@'===$appName) {
        require_cache(LIB_PATH.'Model/'.$className.'.class.php');
    }else{
        import($appName.'.Model.'.$className);
    }
    if(class_exists($className)) {
        $model = new $className();
        $_model[$appName.$OriClassName] =  $model;
        return $model;
    }else {
        throw_exception($className.L('_MODEL_NOT_EXIST_'));
    }
}

/**
 +----------------------------------------------------------
 * A函数用于实例化Action
 +----------------------------------------------------------
 * @param string className Action名称
 * @param string appName Model所在项目
 +----------------------------------------------------------
 * @return Action
 +----------------------------------------------------------
 */
function A($className,$appName='@')
{
    static $_action = array();
    if(isset($_action[$appName.$className])) {
        return $_action[$appName.$className];
    }
    $OriClassName = $className;
    $className =  $className.'Action';
    if('@'===$appName) {
        require_cache(LIB_PATH.'Action/'.$className.'.class.php');
    }else{
        import($appName.'.Action.'.$className);
    }
    if(class_exists($className)) {
        $action = new $className();
        $_action[$appName.$OriClassName] = $action;
        return $action;
    }else {
        return false;
    }
}

// 远程调用模块的操作方法
function R($module,$action,$app='@') {
    $class = A($module,$app);
    if($class) {
        return call_user_func(array(&$class,$action));
    }else{
        return false;
    }
}

// 获取语言定义
function L($name='',$value=null) {
    static $_lang = array();
    if(!is_null($value)) {
        $_lang[strtolower($name)]   =   $value;
        return;
    }
    if(empty($name)) {
        return $_lang;
    }
    if(is_array($name)) {
        $_lang = array_merge($_lang,array_change_key_case($name));
        return;
    }
    if(isset($_lang[strtolower($name)])) {
        return $_lang[strtolower($name)];
    }else{
        return $name;
    }
}

// 获取配置值
function C($name='',$value=null) {
    static $_config = array();
    if(!is_null($value)) {// 参数赋值
        if(strpos($name,'.')) {//  支持二维数组赋值
            $array   =  explode('.',$name);
            $_config[strtolower($array[0])][$array[1]] =   $value;
        }else{
            $_config[strtolower($name)] =   $value;
        }
        return ;
    }
    if(empty($name)) {// 获取全部配置参数
        return $_config;
    }
    if(is_array($name)) { // 批量赋值
        $_config = array_merge($_config,array_change_key_case($name));
        return $_config;
    }elseif(strpos($name,'.')) { // 支持获取二维数组
        $array   =  explode('.',$name);
        return $_config[strtolower($array[0])][$array[1]];
    }elseif(isset($_config[strtolower($name)])) { // 获取参数
        return $_config[strtolower($name)];
    }else{
        return NULL;
    }
}

// 处理标签
function tag($name,$params=array()) {
    $tags   =  C('_tags_.'.$name);
    if($tags) {
        foreach ($tags   as $key=>$call){
            if(is_callable($call)) {
                $result = call_user_func_array($call,$params);
            }
        }
        return $result;
    }
    return false;
}

// 执行行为
function B($name) {
    $class = $name.'Behavior';
    require_cache(LIB_PATH.'Behavior/'.$class.'.class.php');
    $behavior   =  new $class();
    $behavior->run();
}

// 渲染输出Widget
function W($name,$data=array(),$return=false) {
    $class = $name.'Widget';
    require_cache(LIB_PATH.'Widget/'.$class.'.class.php');
    $widget  =  new $class();
    $content = $widget->render($data);
    if($return) {
        return $content;
    }else{
        echo $content;
    }
}

// 全局缓存设置和读取
function S($name,$value='',$expire='',$type='') {
    static $_cache = array();
    alias_import('Cache');
    //取得缓存对象实例
    $cache  = Cache::getInstance($type);
    if('' !== $value) {
        if(is_null($value)) {
            // 删除缓存
            $result =   $cache->rm($name);
            if($result) {
                unset($_cache[$type.'_'.$name]);
            }
            return $result;
        }else{
            // 缓存数据
            $cache->set($name,$value,$expire);
            $_cache[$type.'_'.$name]     =   $value;
        }
        return ;
    }
    if(isset($_cache[$type.'_'.$name])) {
        return $_cache[$type.'_'.$name];
    }
    // 获取缓存数据
    $value      =  $cache->get($name);
    $_cache[$type.'_'.$name]     =   $value;
    return $value;
}

// 快速文件数据读取和保存 针对简单类型数据 字符串、数组
function F($name,$value='',$expire=-1,$path=DATA_PATH) {
    static $_cache = array();
    $filename   =   $path.$name.'.php';
    if('' !== $value) {
        if(is_null($value)) {
            // 删除缓存
            $result =   unlink($filename);
            if($result) {
                unset($_cache[$name]);
            }
            return $result;
        }else{
            // 缓存数据
            $content   =   "<?php\nif (!defined('THINK_PATH')) exit();\n//".sprintf('%012d',$expire)."\nreturn ".var_export($value,true).";\n?>";
            $result  =   file_put_contents($filename,$content);
            $_cache[$name]   =   $value;
        }
        return ;
    }
    if(isset($_cache[$name])) {
        return $_cache[$name];
    }
    // 获取缓存数据
    if(is_file($filename) && false !== $content = file_get_contents($filename)) {
        $expire  =  (int)substr($content,44, 12);
        if($expire != -1 && time() > filemtime($filename) + $expire) {
            //缓存过期删除缓存文件
            unlink($filename);
            return false;
        }
        $str       = substr($content,57,-2);
        $value    = eval($str);
        $_cache[$name]   =   $value;
    }else{
        $value  =   false;
    }
    return $value;
}

// 根据PHP各种类型变量生成唯一标识号
function to_guid_string($mix)
{
    if(is_object($mix) && function_exists('spl_object_hash')) {
        return spl_object_hash($mix);
    }elseif(is_resource($mix)){
        $mix = get_resource_type($mix).strval($mix);
    }else{
        $mix = serialize($mix);
    }
    return md5($mix);
}

// xml编码
function xml_encode($data,$encoding='utf-8',$root="think") {
    $xml = '<?xml version="1.0" encoding="'.$encoding.'"?>';
    $xml.= '<'.$root.'>';
    $xml.= data_to_xml($data);
    $xml.= '</'.$root.'>';
    return $xml;
}

function data_to_xml($data) {
    if(is_object($data)) {
        $data = get_object_vars($data);
    }
    $xml = '';
    foreach($data as $key=>$val) {
        is_numeric($key) && $key="item id=\"$key\"";
        $xml.="<$key>";
        $xml.=(is_array($val)||is_object($val))?data_to_xml($val):$val;
        list($key,)=explode(' ',$key);
        $xml.="</$key>";
    }
    return $xml;
}

// 编译文件
function compile($filename) {
    if(defined('STRIP_RUNTIME_SPACE') && STRIP_RUNTIME_SPACE == false ) {
        $content = file_get_contents($filename);
    }else{
        $content = php_strip_whitespace($filename);
    }
    $content = substr(trim($content),5);
    if('?>' == substr($content,-2)) {
        $content = substr($content,0,-2);
    }
    return $content;
}

// 循环创建目录
function mk_dir($dir, $mode = 0755)
{
  if (is_dir($dir) || @mkdir($dir,$mode)) return true;
  if (!mk_dir(dirname($dir),$mode)) return false;
  return @mkdir($dir,$mode);
}

// 自动转换字符集 支持数组转换
function auto_charset($fContents,$from,$to){
    $from   =  strtoupper($from)=='UTF8'? 'utf-8':$from;
    $to       =  strtoupper($to)=='UTF8'? 'utf-8':$to;
    if( strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents)) ){
        //如果编码相同或者非字符串标量则不转换
        return $fContents;
    }
    if(is_string($fContents) ) {
        if(function_exists('mb_convert_encoding')){
            return mb_convert_encoding ($fContents, $to, $from);
        }elseif(function_exists('iconv')){
            return iconv($from,$to,$fContents);
        }else{
            return $fContents;
        }
    }
    elseif(is_array($fContents)){
        foreach ( $fContents as $key => $val ) {
            $_key =     auto_charset($key,$from,$to);
            $fContents[$_key] = auto_charset($val,$from,$to);
            if($key != $_key ) {
                unset($fContents[$key]);
            }
        }
        return $fContents;
    }
    else{
        return $fContents;
    }
}
?>