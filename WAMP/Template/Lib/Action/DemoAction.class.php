<?php
/* ---------------------------------------------------- */
/* 内置模板引擎应用示例
/* ---------------------------------------------------- */
class DemoAction extends Action {

    // 批量赋值 | 布局模板输出
    public function index(){

        // 使用定义数组的方式批量赋值变量
        $val['name']        =    'thinkphp';
        $val['email']       =    'zzguo28@gmail.com';
        $val['now_time']    =    time();
        $val['title']       =    '批量赋值 | 使用布局模板';
        $val['content']     =    'demo_index';
        $this->assign($val);

        // 使用布局模板
        $this->display('Layout:demo_layout');
    }

    /* ---------------------------------------------------- */
    /* 通常从数据库中使用select()获取到的数据会类似下面这种形式：
        $data   =   array(
            0   =>  array(
                'id'    =>  1,
                'name'  =>  'think',
                'email' =>  'think@thinkphp.cn',
                'other'  =>  'aaaaaaaaaa',
            ),
            1   =>  array(
                'id'    =>  2,
                'name'  =>  'topthink',
                'email' =>  'top@thinkphp.cn',
                'other'  =>  'bbbbbbbbbb',
            )
            .........
        );
    /* 下面创建的模拟数据集都是类似上面这种形式
    /* ---------------------------------------------------- */

    /* 循环输出例子一 */
    public function loop1() {

        $data   =   $this->build_data();            // 创建模拟数据集

        $this->assign('data',$data);                // 对数据赋值
        $this->assign('content','demo_loop1');
        $this->display('Layout:demo_layout');
    }

    /* 多层嵌套循环输出例子 */
    public function loop2() {

        $data   =   $this->build_data(10,1);        // 创建模拟数据集
        $this->assign('data',$data);                // 对数据赋值
        $this->assign('content','demo_loop2');
        $this->display('Layout:demo_layout');
    }

    /* if标签、switch、session标签 */
    public function other() {

        $data[0]  =  array('sayyou' => '很喜欢' , 'sayme' => '谢谢您支持！');
        $data[1]  =  array('sayyou' => '还不错' , 'sayme' => '我们会加倍努力！');
        $data[2]  =  array('sayyou' => '一般般' ,'sayme' => '请提交您的宝贵意见！');

        $this->assign('data',$data);
        $this->assign('content','demo_other');
        $this->display('Layout:demo_layout');
    }


    /* 自定义标签库(标签扩展)使用示例 */
    public function mytags() {

        $this->assign('title','自定义标签库');
        $this->assign('content','demo_tags');
        $this->display('Layout:demo_layout');

    }

    // 模拟数据集创建方法
    function build_data($num = 20 , $sub = false) {

        $data   =   array(); // 模拟数据集

        for ($i = 1; $i <= $num; $i++)
        {
            $data[$i-1]['id']     =   $i;
            $data[$i-1]['name']   =   'name'.$i;
            $data[$i-1]['email']  =   'email'.$i.'@thinkphp.cn';
            $data[$i-1]['other']  =   md5($i);
        }

        if ($sub) {
            foreach($data as $key => $val){
                $data[$key]['sub'] = $this->build_data(5);
            }
        }

        return $data;
    }
}
?>