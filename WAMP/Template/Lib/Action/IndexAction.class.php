<?php
/* 模板调用、模板赋值示例 */
class IndexAction extends Action {

    public function index(){

        // 对模板变量 $title 赋值
        $this->assign('title','功能演示');

        // 调用模板显示 对应 default/Index/index.html
        $this->display();
    }
}
?>