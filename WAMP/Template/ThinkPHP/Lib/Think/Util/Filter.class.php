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
 * 过滤器类
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Util
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id$
 +------------------------------------------------------------------------------
 */
class Filter extends Base
{
    /**
     +----------------------------------------------------------
     * 加载过滤器
     *
     +----------------------------------------------------------
     * @static
     * @access public
     +----------------------------------------------------------
     * @param string $filterNames  过滤器名称
     * @param string $method  执行的方法名称
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    static  function load($filterNames,$method='execute')
    {
        $filterPath = dirname(__FILE__).'/Filter/';
        $filters    =   explode(',',$filterNames);
        $load = false;
        foreach($filters as $key=>$val) {
            if(strpos($val,'.')) {
                $filterClass = strtolower(substr(strrchr($val, '.'),1));
                import($val);
            }else {
                $filterClass = 'Filter'.$val ;
                require_cache( $filterPath.$filterClass . '.class.php');
            }
            if(class_exists($filterClass)) {
                $filter = get_instance_of($filterClass);
                $filter->{$method}();
            }
        }
        return ;
    }
};
?>