<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: ThinkPHP.php 1829 2010-10-18 08:15:58Z liu21st $

// 记录和统计时间（微秒）
function G($start,$end='',$dec=3) {
    static $_info = array();
    if(!empty($end)) { // 统计时间
        if(!isset($_info[$end])) {
            $_info[$end]   =  microtime(TRUE);
        }
        return number_format(($_info[$end]-$_info[$start]),$dec);
    }else{ // 记录时间
        $_info[$start]  =  microtime(TRUE);
    }
}

//记录开始运行时间
G('beginTime');
if(!defined('APP_PATH')) define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']));
if(!defined('RUNTIME_PATH')) define('RUNTIME_PATH',APP_PATH.'/Runtime/');
if(!defined('APP_CACHE_NAME')) define('APP_CACHE_NAME','app');// 指定缓存名称

// ThinkPHP系统目录定义
if(!defined('THINK_PATH')) define('THINK_PATH', dirname(__FILE__));
if(!defined('APP_NAME')) define('APP_NAME', basename(dirname($_SERVER['SCRIPT_FILENAME'])));

// 生成核心编译缓存
function build_runtime() {
    // 加载常量定义文件
    require THINK_PATH.'/Common/defines.php';

    // 加载路径定义文件
    require THINK_PATH.'/Common/paths.php';

	$list = array(
	    THINK_PATH.'/Common/functions.php',   // 系统函数库
	    THINK_PATH.'/Lib/Think/Core/Think.class.php',
	    THINK_PATH.'/Lib/Think/Exception/ThinkException.class.php',  // 异常处理类
	    THINK_PATH.'/Lib/Think/Core/Log.class.php',    // 日志处理类
	    THINK_PATH.'/Lib/Think/Core/App.class.php',   // 应用程序类
	    THINK_PATH.'/Lib/Think/Core/Action.class.php', // 控制器类
	    //THINK_PATH.'/Lib/Think/Core/Model.class.php', // 模型类
	    THINK_PATH.'/Lib/Think/Core/View.class.php',  // 视图类
	    THINK_PATH.'/Common/alias.php',  // 加载别名
	);
    // 加载核心编译文件列表
    foreach ($list as $key=>$file){
        if(is_file($file))  require $file;
    }
}
// 生成核心编译~runtime缓存
build_runtime();

// 记录加载文件时间
G('loadTime');
?>