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
 * ThinkPHP惯例配置文件
 * 项目配置文件只需要配置和惯例不符的配置项
 * 请不要修改该文件 修改请在项目配置文件中定义
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Common
 * @author   liu21st <liu21st@gmail.com>
 * @version  $Id$
 +------------------------------------------------------------------------------
 */
if (!defined('THINK_PATH')) exit();

// 惯例配置定义 变量名大小写任意，都会统一转换成小写
// 如果要覆盖惯例配置的值，请在项目配置文件中设置
// 所有配置参数都可以在生效前动态改变
return  array(

    /* Dispatch设置 */
    'DISPATCH_ON'				=>	true,	// 是否启用Dispatcher
    // URL模式： 0 普通模式 1 PATHINFO 2 REWRITE 3 兼容模式 当DISPATCH_ON开启后有效
    'URL_MODEL'					=>	1,		// 默认为PATHINFO 模式，提供最好的用户体验和SEO支持
    // PATHINFO 模式
    // 普通模式1 参数没有顺序/m/module/a/action/id/1
    // 智能模式2 自动识别模块和操作/module/action/id/1/ 或者 /module,action,id,1/...
    // 兼容模式3 通过一个GET变量将PATHINFO传递给dispather，默认为s index.php?s=/module/action/id/1
    'PATH_MODEL'					=>	2,	// 默认采用智能模式
    'PATH_DEPR'					=>	'/',	// PATHINFO参数之间分割号
    'ROUTER_ON'                  =>   false, // 是否开启URL路由

    'CHECK_FILE_CASE'          =>   false, // 是否检查文件的大小写 对Windows平台有效
    'TAG_PLUGIN_ON'               =>   false, // 是否开启插件机制

    'SESSION_AUTO_START'   =>   true,  // 是否自动开启Session
    /* 日志设置 */
    'WEB_LOG_RECORD'			=>	false,	 // 默认不记录日志
    'LOG_RECORD_LEVEL'       =>   array('EMERG','ALERT','CRIT','ERR'),  // 允许记录的日志级别
    'LOG_FILE_SIZE'				=>	2097152,	// 日志文件大小限制

    /* 错误设置 */
    'DEBUG_MODE'				=>	false,	 // 调试模式默认关闭
    'ERROR_MESSAGE'			=>	'您浏览的页面暂时发生了错误！请稍后再试～',	// 错误显示信息 非调试模式有效
    'ERROR_PAGE'					=>	'',	// 错误定向页面
    'SHOW_ERROR_MSG'        =>   true,

    /* 系统变量设置 */
    'VAR_PATHINFO'				=>	's',	// PATHINFO 兼容模式获取变量例如 ?s=/module/action/id/1 后面的参数取决于PATH_MODEL 和 PATH_DEPR
    'VAR_MODULE'					=>	'm',		// 默认模块获取变量
    'VAR_ACTION'					=>	'a',		// 默认操作获取变量
   	'VAR_PAGE'						=>	'p',		// 默认分页跳转变量
    'VAR_TEMPLATE'				=>	't',		// 默认模板切换变量
	'VAR_LANGUAGE'				=>	'l',		// 默认语言切换变量
    'VAR_AJAX_SUBMIT'			=>	'ajax', // 默认的AJAX提交变量

    /* 模块和操作设置 */
    'DEFAULT_MODULE'			=>	'Index', // 默认模块名称
    'DEFAULT_ACTION'			=>	'index', // 默认操作名称

    /* 模板设置 */
    'TMPL_CACHE_ON'			=>	true,		// 默认开启模板编译缓存 false 的话每次都重新编译模板
    'TMPL_CACHE_TIME'		=>	-1,		// 模板缓存有效期 -1 永久 单位为秒
    'TMPL_SWITCH_ON'			=>	true,	// 启用多模版支持
    'AUTO_DETECT_THEME'   =>   false, // 自动侦测模板主题
    'DEFAULT_TEMPLATE'		=>	'default',	// 默认模板名称
    'TEMPLATE_SUFFIX'			=>	'.html',	 // 默认模板文件后缀
    'CACHFILE_SUFFIX'			=>	'.php',	// 默认模板缓存后缀
    'OUTPUT_CHARSET'			=>	'utf-8',	// 默认输出编码
    'TMPL_VAR_IDENTIFY'      =>   'array',    // 模板变量识别 留空自动判断 array 数组 obj 对象

	/* 分页设置 */
	'PAGE_NUMBERS'				=>	5,			// 分页显示页数
	'LIST_NUMBERS'				=>	20,			// 分页每页显示记录数

    /* 模型设置 */
    'AUTO_NAME_IDENTIFY'  =>    true, // 模型对应数据表名称智能识别 UserType => user_type
    'DEFAULT_MODEL_APP'     =>   '@',   // 默认模型类所在的项目名称 @ 表示当前项目

    /* 静态缓存设置 */
    'HTML_FILE_SUFFIX'			=>	'.shtml',	 // 默认静态文件后缀
    'HTML_CACHE_ON'			=>	false,		 // 默认关闭静态缓存
    'HTML_CACHE_TIME'		=>	60,		 // 静态缓存有效期
    'HTML_READ_TYPE'			=>	1,			// 静态缓存读取方式 0 readfile 1 redirect
    'HTML_URL_SUFFIX'			=>	'',	// 伪静态后缀设置

    /* 语言时区设置 */
    'TIME_ZONE'					=>	'PRC',		 // 默认时区
	'LANG_SWITCH_ON'			=>	false,	 // 默认关闭多语言包功能
	'DEFAULT_LANGUAGE'		=>	'zh-cn',	 // 默认语言
    'AUTO_DETECT_LANG'      =>   false,     // 自动侦测语言

    /* 数据库设置 */
    'DB_CHARSET'					=>	'utf8',			// 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'			=>	0,			// 数据库部署方式 0 集中式（单一服务器） 1 分布式（主从服务器）
    'DB_RW_SEPARATE'         =>    false,
    'DB_FIELDS_CACHE'         =>    true,

    /* 数据缓存设置 */
    'DATA_CACHE_TIME'		=>	-1,			// 数据缓存有效期
    'DATA_CACHE_COMPRESS'=>	false,		// 数据缓存是否压缩缓存
    'DATA_CACHE_CHECK'		=>	false,		// 数据缓存是否校验缓存
    'DATA_CACHE_TYPE'		=>	'File',		// 数据缓存类型 支持 File Db Apc Memcache Shmop Sqlite Xcache Apachenote Eaccelerator
    'DATA_CACHE_PATH'       =>    TEMP_PATH,  // 缓存路径设置 (仅对File方式缓存有效)
    'DATA_CACHE_SUBDIR'		=>	false,		// 使用子目录缓存 (自动根据缓存标识的哈希创建子目录)
    'DATA_PATH_LEVEL'        =>    1, // 子目录缓存级别
    'CACHE_SERIAL_HEADER'	=>	"<?php\n//",	// 文件缓存开始标记
    'CACHE_SERIAL_FOOTER'	=>	"\n?".">",	// 文件缓存结束标记


    /* 运行时间设置 */
    'SHOW_RUN_TIME'			=>	false,			// 运行时间显示
    'SHOW_ADV_TIME'			=>	false,			// 显示详细的运行时间
    'SHOW_DB_TIMES'			=>	false,			// 显示数据库查询和写入次数
    'SHOW_CACHE_TIMES'		=>	false,		// 显示缓存操作次数
    'SHOW_USE_MEM'			=>	false,			// 显示内存开销
    'SHOW_PAGE_TRACE'		=>	false,		// 显示页面Trace信息 由Trace文件定义和Action操作赋值

    /* 模板引擎设置 */
    'TMPL_ENGINE_TYPE'		=>	'Think',		// 默认模板引擎 以下设置仅对使用Think模板引擎有效
    'TMPL_DENY_FUNC_LIST'	=>	'echo,exit',	// 模板引擎禁用函数
    'TMPL_L_DELIM'				=>	'{',			// 模板引擎普通标签开始标记
    'TMPL_R_DELIM'				=>	'}',			// 模板引擎普通标签结束标记
    'TAGLIB_BEGIN'				=>	'<',			// 标签库标签开始标记
    'TAGLIB_END'					=>	'>',			// 标签库标签结束标记
    'TAG_NESTED_LEVEL'		=>	3,				// 标签库
    'TAGLIB_LIST'                 =>   'cx,html',    // 内置标签库名称

    /* Cookie设置 */
    'COOKIE_EXPIRE'				=>	3600,		// Coodie有效期
    'COOKIE_DOMAIN'			=>	'',	// Cookie有效域名
    'COOKIE_PATH'				=>	'/',			// Cookie路径
    'COOKIE_PREFIX'				=>	'', // Cookie前缀 避免冲突

    /* 数据格式设置 */
    'AJAX_RETURN_TYPE'		=>	'JSON', //AJAX 数据返回格式 JSON XML ...

    /* 其它设置 */
    'AUTO_LOAD_PATH'			=>	'Think.Util.',	//	 __autoLoad 的路径设置 当前项目的Model和Action类会自动加载，无需设置 注意搜索顺序
    'ACTION_JUMP_TMPL'=>	'Public:success',    // 页面跳转的模板文件
    'ACTION_404_TMPL'=>	'Public:404',         // 404错误的模板文件
    'APP_DOMAIN_DEPLOY'     =>  false,     // 是否使用独立域名部署项目

    /* 需要加载的外部配置文件 */
    'EXTEND_CONFIG_LIST'=>array('taglibs','routes','tags','htmls','modules','actions'),
    // 内置可选配置包括：taglibs 标签库定义 routes 路由定义 tags 标签定义 htmls 静态缓存定义 modules 扩展模块 actions 扩展操作
);
?>