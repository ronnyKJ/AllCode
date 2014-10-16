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
 * 模板引擎解析类
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Util
 * @author liu21st <liu21st@gmail.com>
 * @version  $Id$
 +------------------------------------------------------------------------------
 */
class Template extends Base {
    // 模板引擎名称
    protected $name =  '';
    // 模板引擎实例
    private $_tpl =  null;

   /**
     +----------------------------------------------------------
     * 取得模板对象实例
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return Template
     +----------------------------------------------------------
     */
    static function getInstance() {
        return get_instance_of(__CLASS__);
    }

    // 构造函数
    public function __construct() {
        $this->name   =  C('TMPL_ENGINE_TYPE')?C('TMPL_ENGINE_TYPE'):'PHP';
        $className   = 'Template'.ucwords(strtolower($this->name));
        require_cache(dirname(__FILE__).'/Template/'.$className.'.class.php');
        $this->_tpl   =  new $className;
    }

    /**
     +----------------------------------------------------------
     * 渲染模板输出
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $templateFile 模板文件名
     * @param array $var 模板变量
     * @param string $charset 模板输出字符集
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
     public function fetch($templateFile,$var,$charset) {
         $this->_tpl->fetch($templateFile,$var,$charset);
     }
}
?>