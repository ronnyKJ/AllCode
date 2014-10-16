<?php
require_once 'common.php';

class Action
{
    public function ajaxReturn($data,$info='',$status=1,$type='')
    {
        $result  =  array();
        $result['status']	= $status;
        $result['info']		= $info;
        $result['data'] 	= $data;
        if(empty($type)) $type  =   'JSON';
        if(strtoupper($type)=='JSON') {
            // 返回JSON数据格式到客户端 包含状态信息
            header("Content-Type:text/html; charset=utf-8");
            exit(json_encode($result));
        }elseif(strtoupper($type)=='XML'){
            // 返回xml格式数据
            header("Content-Type:text/xml; charset=utf-8");
            exit(xml_encode($result));
        }elseif(strtoupper($type)=='EVAL'){
            // 返回可执行的js脚本
            header("Content-Type:text/html; charset=utf-8");
            exit($data);
        }else{
            // TODO 增加其它格式
        }
    }
}

?>