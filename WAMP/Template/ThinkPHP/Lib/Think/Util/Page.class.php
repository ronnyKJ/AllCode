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

class Page extends Base {

    // 分页名称
    protected $name =  null;
    private $_page   = null;

    /**
     +----------------------------------------------------------
     * 架构函数
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     +----------------------------------------------------------
     */
    public function __construct($totalRows,$listRows='',$parameter='')
    {
        $this->name   =  C('PAGE_THEME')?C('PAGE_THEME'):'Default';
        $className   = 'Page'.ucwords(strtolower($this->name));
        require_cache(dirname(__FILE__).'/Page/'.$className.'.class.php');
        $this->_page   =  new $className($totalRows,$listRows,$parameter);
    }

    // 获取分页参数
    public function __get($name) {
        return $this->_page->$name;
    }

    // 分页显示输出
    public function show() {
        return $this->_page->show();
    }
}
?>