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

abstract class Widget extends Base {
    // 渲染输出
    // data 要渲染的数据
    abstract public function render($data);
    // 渲染模板输出
    protected function renderFile($templateFile='',$var='',$charset='utf-8') {
        $template   = Template::getInstance();
        ob_start();
        ob_implicit_flush(0);
        if(!file_exists_case($templateFile)){
            // 自动定位模板文件
            $filename   =  empty($templateFile)?substr(get_class($this),0,-6):$templateFile;
            $templateFile = LIB_PATH.'Widget/'.$filename.C('TEMPLATE_SUFFIX');
            if(!file_exists_case($templateFile)){
                throw_exception(L('_TEMPLATE_NOT_EXIST_').'['.$templateFile.']');
            }
        }
        $template->fetch($templateFile,$var,$charset);
        $content = ob_get_clean();
        return $content;
    }

}
?>