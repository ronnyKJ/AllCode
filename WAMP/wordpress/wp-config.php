<?php
/** 
 * WordPress 基础配置文件。
 *
 * 本文件包含以下配置选项: MySQL 设置、数据库表名前缀、
 * 密匙、WordPress 语言设定以及 ABSPATH。如需更多信息，请访问
 * {@link http://codex.wordpress.org/Editing_wp-config.php 编辑
 * wp-config.php} Codex 页面。MySQL 设置具体信息请咨询您的空间提供商。
 *
 * 这个文件用在于安装程序自动生成 wp-config.php 配置文件，
 * 您可以手动复制这个文件，并重命名为 wp-config.php，然后输入相关信息。
 *
 *
 * @package WordPress
 */

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** WordPress 数据库的名称 */
define('DB_NAME', 'wordpress');

/** MySQL 数据库用户名 */
define('DB_USER', 'root');

/** MySQL 数据库密码 */
define('DB_PASSWORD', '');

/** MySQL 主机 */
define('DB_HOST', 'localhost');

/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'utf8');

/** 数据库整理类型。如不确定请勿更改 */
define('DB_COLLATE', '');

/**#@+
 * 身份密匙设定。
 *
 * 您可以随意写一些字符
 * 或者直接访问 {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org 私钥生成服务}，
 * 任何修改都会导致 cookie 失效，所有用户必须重新登录。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '2!|JGoT64P}&(Vc2NHyLu>)IomgdF^J oHFaIwBd;32r#7eQqJ;RGeWRw!T1pB+n');
define('SECURE_AUTH_KEY',  'jh2dUa3a:!T<0ERmELa%p+os#}f=ds{?[yg(|D}=p8,R3z$E$+k^Y-1Y|_`UOY|Z');
define('LOGGED_IN_KEY',    '1C8p-3(5.D=R>M*7J?2&vuqi!5j~cgQ+=Kv97y[o@=,6A+g3/x9!5jG:(M$:}E_>');
define('NONCE_KEY',        '`6K-(xzSpkgQo`%6E[8 Cix40DBK.)=q-ohebX=5-Uvxi^5t7XF=V0a6P-0&W)6A');
define('AUTH_SALT',        'z$$(P]~,6^C$;Ek|iLM/AL_Q{CYLoc#^:_$s%!e`i!Or=T15NhM5(6Cm_=<MUF>j');
define('SECURE_AUTH_SALT', 'IcOHxGsvH8t0?~4S_BS2A~9.3:&r``mD]~8)R2t(*a/5Zom5@8x-rj9L]_ji{=$3');
define('LOGGED_IN_SALT',   '#7mMBv@rftF)#kD)De9J7x-/mz-P6QUCG|>oQ261VdLQ%M`m+A9g|/wbtQVi-mKx');
define('NONCE_SALT',       'Xo^).-bnrf&;J>@PP]I_!,jX|yVN-X/|snaQp#Xf h5:2[ywm>F4MW-jB?k@%`o:');

/**#@-*/

/**
 * WordPress 数据表前缀。
 *
 * 如果您有在同一数据库内安装多个 WordPress 的需求，请为每个 WordPress 设置不同的数据表前缀。
 * 前缀名只能为数字、字母加下划线。
 */
$table_prefix  = 'wp_';

/**
 * WordPress 语言设置，默认为英语。
 *
 * 本项设定能够让 WordPress 显示您需要的语言。
 * 	wp-content/languages 内应放置同名的 .mo 语言文件。
 * 要使用 WordPress 简体中文界面，只需填入 zh_CN。
 */
define ('WPLANG', 'zh_CN');

/**
 * 开发者专用：WordPress 调试模式。
 *
 * 将这个值改为“true”，WordPress 将显示所有开发过程中的提示。
 * 强烈建议插件开发者在开发环境中启用本功能。
 */
define('WP_DEBUG', false);

/* 好了！请不要再继续编辑。请保存该文件。 */

/** WordPress 目录的绝对路径。 */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** 设置 WordPress 变量和包含文件。 */
require_once(ABSPATH . 'wp-settings.php');
