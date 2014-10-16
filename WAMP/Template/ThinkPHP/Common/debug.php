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
 * ThinkPHP 默认的调试模式配置文件
 *  如果项目有定义自己的调试模式配置文件，本文件无效
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Common
 * @author   liu21st <liu21st@gmail.com>
 * @version  $Id$
 +------------------------------------------------------------------------------
 */
if (!defined('THINK_PATH')) exit();
return  array(
    /* 日志设置 */
    'WEB_LOG_RECORD'=>true,  // 默认进行日志记录

    /* 模板设置 */
    'TMPL_CACHE_ON'=>true,      // 默认开启模板缓存
    'TMPL_CACHE_TIME'=>1,      // 模板缓存有效期 -1 永久 单位为秒

    /* 数据库设置 */
    'SQL_DEBUG_LOG'=>true,          // 记录SQL语句到日志文件
    'LOG_RECORD_LEVEL'       =>   array('EMERG','ALERT','CRIT','ERR','WARN','NOTIC','INFO','DEBUG','SQL'),  // 允许记录的日志级别
    'DB_FIELDS_CACHE'=> false,

    /* 运行时间设置 */
    'SHOW_RUN_TIME'=>true,          // 运行时间显示
    'SHOW_ADV_TIME'=>true,          // 显示详细的运行时间
    'SHOW_DB_TIMES'=>true,          // 显示数据库查询和写入次数
    'SHOW_CACHE_TIMES'=>true,       // 显示缓存操作次数
    'SHOW_USE_MEM'=>true,           // 显示内存开销
    'SHOW_PAGE_TRACE'=>true,        // 显示页面Trace信息 由Trace文件定义和Action操作赋值
    'CHECK_FILE_CASE'  =>   true, // 是否检查文件的大小写 对Windows平台有效
);
?>