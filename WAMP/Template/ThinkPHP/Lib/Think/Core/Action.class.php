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
 * ThinkPHP Action控制器基类 抽象类
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Core
 * @author   liu21st <liu21st@gmail.com>
 * @version  $Id$
 +------------------------------------------------------------------------------
 */
abstract class Action extends Base
{//类定义开始

    // Action控制器名称
    protected $name =  '';

    // 视图实例对象
    protected $view   =  null;

    // 上次错误信息
    protected $error  =  '';

   /**
     +----------------------------------------------------------
     * 架构函数 取得模板对象实例
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     */
    public function __construct()
    {
        //实例化视图类
        $this->view       = View::getInstance();
        $this->name     =   substr(get_class($this),0,-6);
        //控制器初始化
        if(method_exists($this,'_initialize')) {
            $this->_initialize();
        }
    }

    // 判断是否为AjAX提交
    protected function isAjax() {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
            if(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest')
                return true;
        }
        if(!empty($_POST[C('VAR_AJAX_SUBMIT')]) || !empty($_GET[C('VAR_AJAX_SUBMIT')])) {
            // 判断Ajax方式提交
            return true;
        }
        return false;
    }

    /**
     +----------------------------------------------------------
     * 模板显示
     * 调用内置的模板引擎显示方法，
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $templateFile 指定要调用的模板文件
     * 默认为空 由系统自动定位模板文件
     * @param string $charset 输出编码
     * @param string $contentType 输出类型
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    public function display($templateFile='',$charset='',$contentType='text/html')
    {
        $this->view->display($templateFile,$charset,$contentType);
    }

    /**
     +----------------------------------------------------------
     *  获取输出页面内容
     * 调用内置的模板引擎fetch方法，
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param string $templateFile 指定要调用的模板文件
     * 默认为空 由系统自动定位模板文件
     * @param string $charset 输出编码
     * @param string $contentType 输出类型
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    protected function fetch($templateFile='',$charset='',$contentType='text/html')
    {
        return $this->view->fetch($templateFile,$charset,$contentType);
    }

    /**
     +----------------------------------------------------------
     *  创建静态页面
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $templateFile 指定要调用的模板文件
     * 默认为空 由系统自动定位模板文件
     * @htmlfile 生成的静态文件名称
     * @param string $charset 输出编码
     * @param string $contentType 输出类型
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    protected function buildHtml($htmlfile='',$templateFile='',$charset='',$contentType='text/html') {
        return $this->view->buildHtml($htmlfile,$templateFile,$charset,$contentType);
    }

    /**
     +----------------------------------------------------------
     * 模板变量赋值
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param mixed $name 要显示的模板变量
     * @param mixed $value 变量的值
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    public function assign($name,$value='')
    {
        $this->view->assign($name,$value);
    }

    /**
     +----------------------------------------------------------
     * 取得模板显示变量的值
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $name 模板显示变量
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    public function get($name)
    {
        return $this->view->get($name);
    }

    /**
     +----------------------------------------------------------
     * Trace变量赋值
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param mixed $name 要显示的模板变量
     * @param mixed $value 变量的值
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    public function trace($name,$value='')
    {
        $this->view->trace($name,$value);
    }

    /**
     +----------------------------------------------------------
     * 魔术方法 有不存在的操作的时候执行
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $method 方法名
     * @param array $parms 参数
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    public function __call($method,$parms) {
        if(strtolower($method) == strtolower(ACTION_NAME)) {
            // 检查扩展操作方法
            $_action = C('_actions_');
            if($_action) {
                // 'module:action'=>'callback'
                if(isset($_action[MODULE_NAME.':'.ACTION_NAME])) {
                    $action  =  $_action[MODULE_NAME.':'.ACTION_NAME];
                }elseif(isset($_action[ACTION_NAME])){
                    // 'action'=>'callback'
                    $action  =  $_action[ACTION_NAME];
                }
                if(!empty($action)) {
                    call_user_func($action);
                    return ;
                }
            }
            // 如果定义了_empty操作 则调用
            if(method_exists($this,'_empty')) {
                $this->_empty($method,$parms);
            }else {
                // 检查是否存在默认模版 如果有直接输出模版
                if(file_exists_case(C('TMPL_FILE_NAME'))) {
                    $this->display();
                }else{
                    // 抛出异常
                    throw_exception(L('_ERROR_ACTION_').ACTION_NAME);
                }
            }
        }else{
            throw_exception(__CLASS__.':'.$method.L('_METHOD_NOT_EXIST_'));
        }
    }

    /**
     +----------------------------------------------------------
     * 操作错误跳转的快捷方法
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $errorMsg 错误信息
     * @param Boolean $ajax 是否为Ajax方式
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    public function error($errorMsg,$ajax=false)
    {
        if($ajax || $this->isAjax()) {
            $this->ajaxReturn('',$errorMsg,0);
        }else {
			//error输出应该不受HTML静态缓存配置的影响
			C('HTML_CACHE_ON',false);
            $this->assign('error',$errorMsg);
            $this->forward();
        }
    }

    /**
     +----------------------------------------------------------
     * 操作成功跳转的快捷方法
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $message 提示信息
     * @param Boolean $ajax 是否为Ajax方式
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    public function success($message,$ajax=false)
    {
        if($ajax || $this->isAjax()) {
            $this->ajaxReturn('',$message,1);
        }else {
			//success输出应该不受HTML静态缓存配置的影响
			C('HTML_CACHE_ON',false);
            $this->assign('message',$message);
            $this->forward();
        }
    }

    /**
     +----------------------------------------------------------
     * Ajax方式返回数据到客户端
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param mixed $data 要返回的数据
     * @param String $info 提示信息
     * @param String $status 返回状态
     * @param String $status ajax返回类型 JSON XML
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    public function ajaxReturn($data='',$info='',$status='',$type='')
    {
        // 保证AJAX返回后也能保存日志
        if(C('WEB_LOG_RECORD')) Log::save();

        $result  =  array();
        if($status === '') {
            $status  = $this->get('error')?0:1;
        }
        if($info=='') {
            if($this->get('error')) {
                $info =   $this->get('error');
            }elseif($this->get('message')) {
                $info =   $this->get('message');
            }
        }
        $result['status']  =  $status;
        $result['info'] =  $info;
        $result['data'] = $data;
        if(empty($type)) $type  =   C('AJAX_RETURN_TYPE');
        if(strtoupper($type)=='JSON') {
            // 返回JSON数据格式到客户端 包含状态信息
            header("Content-Type:text/html; charset=utf-8");
            exit(json_encode($result));
        }elseif(strtoupper($type)=='EVAL'){
            // 返回可执行的js脚本
            header("Content-Type:text/html; charset=utf-8");
            exit($data);
        }else{
            // TODO 增加其它格式
        }
    }

    /**
     +----------------------------------------------------------
     * 执行某个Action操作（隐含跳转） 支持指定模块和延时执行
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param mixed $action 要跳转的Action 默认为_dispatch_jump
     * @param string $module 要跳转的Module 默认为当前模块
     * @param string $app 要跳转的App 默认为当前项目
     * @param boolean $exit  是否继续执行
     * @param integer $delay 延时跳转的时间 单位为秒
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    public function forward($action='_dispatch_jump',$module='',$app='@',$exit=false,$delay=0)
    {
        if(!empty($delay)) {
            //指定延时跳转 单位为秒
            sleep(intval($delay));
        }
        if(is_array($action)) {
            //通过类似 array(&$module,$action)的方式调用
            call_user_func($action);
        }else {
            if(empty($module)) {
                // 执行当前模块操作
                call_user_func(array(&$this,$action));
            }else{
                $class =     A($module,$app);
                call_user_func(array(&$class,$action));
            }
        }
        if($exit) {
            exit();
        }else {
            return ;
        }
    }

    /**
     +----------------------------------------------------------
     * Action跳转(URL重定向） 支持指定模块和延时跳转
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $url 跳转的URL表达式
     * @param array $params 其它URL参数
     * @param integer $delay 延时跳转的时间 单位为秒
     * @param string $msg 跳转提示信息
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    public function redirect($url,$params=array(),$delay=0,$msg='') {
        $url    =   U($url,$params);
        redirect($url,$delay,$msg);
    }

    /**
     +----------------------------------------------------------
     * 默认跳转操作 支持错误导向和正确跳转
     * 调用模板显示 默认为public目录下面的success页面
     * 提示页面为可配置 支持模板标签
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    private function _dispatch_jump()
    {
        if($this->isAjax() ) {
            // 用于Ajax附件上传 显示信息
            if($this->get('_ajax_upload_')) {
                header("Content-Type:text/html; charset=utf-8");
                exit($this->get('_ajax_upload_'));
            }else {
                $this->ajaxReturn();
            }
        }
        if($this->get('error') ) {
            $msgTitle    =   L('_OPERATION_FAIL_');
        }else {
            $msgTitle    =   L('_OPERATION_SUCCESS_');
        }
        //提示标题
        $this->assign('msgTitle',$msgTitle);
        if($this->get('message')) { //发送成功信息
            //成功操作后停留1秒
            if(!$this->get('waitSecond'))
                $this->assign('waitSecond',"1");
            //默认操作成功自动返回操作前页面
            if(!$this->get('jumpUrl'))
                $this->assign("jumpUrl",$_SERVER["HTTP_REFERER"]);
        }
        if($this->get('error')) { //发送错误信息
            //发生错误时候停留3秒
            if(!$this->get('waitSecond'))
                $this->assign('waitSecond',"3");
            //默认发生错误的话自动返回上页
            if(!$this->get('jumpUrl'))
                $this->assign('jumpUrl',"javascript:history.back(-1);");
        }
        //如果设置了关闭窗口，则提示完毕后自动关闭窗口
        if($this->get('closeWin')) {
            $this->assign('jumpUrl','javascript:window.close();');
        }

        $this->display(C('ACTION_JUMP_TMPL'));
        // 中止执行  避免出错后继续执行
        exit ;
    }

}//类定义结束
?>