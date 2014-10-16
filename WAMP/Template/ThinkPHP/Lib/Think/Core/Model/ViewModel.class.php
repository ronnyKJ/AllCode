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
 * ThinkPHP 视图模型类
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Core
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id$
 +------------------------------------------------------------------------------
 */
class ViewModel extends Model {

    /**
     +----------------------------------------------------------
     * 得到完整的数据表名
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function getTableName()
    {
        if(empty($this->trueTableName)) {
            $tableName = '';
            foreach ($this->viewFields as $key=>$view){
                $Model  =   D($key);
                if($Model) {
                    // 存在模型 获取模型定义的数据表名称
                    $tableName .= $Model->getTableName();
                }else{
                    // 直接把key作为表名来对待
                    $viewTable  = !empty($this->tablePrefix) ? $this->tablePrefix : '';
                    $viewTable .= $key;
                    $tableName .= strtolower($viewTable);
                }
                if(isset($view['_as'])) {
                    $tableName .= ' '.$view['_as'];
                }else{
                    $tableName .= ' '.$key;
                }
                if(isset($view['_on'])) {
                    // 支持ON 条件定义
                    $tableName .= ' ON '.$view['_on'];
                }
                if(!empty($view['_type'])) {
                    // 指定JOIN类型 例如 RIGHT INNER LEFT 下一个表有效
                    $type = $view['_type'];
                }else{
                    $type = '';
                }
                $tableName   .= ' '.strtoupper($type).' JOIN ';
                $len  =  strlen($type.'_JOIN ');
            }
            $tableName = substr($tableName,0,-$len);
            $this->trueTableName    =   $tableName;
        }
        return $this->trueTableName;
    }

    /**
     +----------------------------------------------------------
     * 表达式过滤方法
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param string $options 表达式
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    protected function _options_filter(&$options) {
        if(isset($options['field'])) {
            $options['field'] = $this->checkFields($options['field']);
        }else{
            $options['field'] = $this->checkFields();
        }
        if(isset($options['group']))
            $options['group']  =  $this->checkGroup($options['group']);
        if(isset($options['order']))
            $options['order']  =  $this->checkOrder($options['order']);
    }

    /**
     +----------------------------------------------------------
     * 检查条件中的视图字段
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param mixed $data 条件表达式
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    protected function checkCondition($where) {
        if(is_array($where)) {
            $view   =   array();
            // 检查视图字段
            foreach ($this->viewFields as $key=>$val){
                $k = isset($val['_as'])?$val['_as']:$key;
                foreach ($where as $name=>$value){
                    if(false !== $field = array_search($name,$val)) {
                        // 存在视图字段
                        $_key   =   is_numeric($field)?    $k.'.'.$name   :   $k.'.'.$field;
                        $view[$_key]    =   $value;
                        unset($where[$name]);
                    }
                }
            }
            $where    =   array_merge($where,$view);
         }
        return $where;
    }

    /**
     +----------------------------------------------------------
     * 检查Order表达式中的视图字段
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param string $order 字段
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    protected function checkOrder($order='') {
         if(!empty($order)) {
            $orders = explode(',',$order);
            $_order = array();
            foreach ($orders as $order){
                $array = explode(' ',$order);
                $field   =   $array[0];
                $sort   =   isset($array[1])?$array[1]:'ASC';
                // 解析成视图字段
                foreach ($this->viewFields as $name=>$val){
                    $k = isset($val['_as'])?$val['_as']:$name;
                    if(false !== $_field = array_search($field,$val)) {
                        // 存在视图字段
                        $field     =  is_numeric($_field)?$k.'.'.$field:$k.'.'.$_field;
                        break;
                    }
                }
                $_order[] = $field.' '.$sort;
            }
            $order = implode(',',$_order);
         }
        return $order;
    }

    /**
     +----------------------------------------------------------
     * 检查Group表达式中的视图字段
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param string $group 字段
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    protected function checkGroup($group='') {
         if(!empty($group)) {
            $groups = explode(',',$group);
            $_group = array();
            foreach ($groups as $group){
                $array = explode(' ',$group);
                $field   =   $array[0];
                $sort   =   isset($array[1])?$array[1]:'';
                // 解析成视图字段
                foreach ($this->viewFields as $name=>$val){
                    $k = isset($val['_as'])?$val['_as']:$name;
                    if(false !== $_field = array_search($field,$val)) {
                        // 存在视图字段
                        $field     =  is_numeric($_field)?$k.'.'.$field:$k.'.'.$_field;
                        break;
                    }
                }
                $_group[$field] = $field.' '.$sort;
            }
            $group  =   $_group;
         }
        return $group;
    }

    /**
     +----------------------------------------------------------
     * 检查fields表达式中的视图字段
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $fields 字段
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function checkFields($fields='') {
        if(empty($fields) || '*'==$fields ) {
            // 获取全部视图字段
            $fields =   array();
            foreach ($this->viewFields as $name=>$val){
                $k = isset($val['_as'])?$val['_as']:$name;
                foreach ($val as $key=>$field){
                    if(is_numeric($key)) {
                        $fields[]    =   $k.'.'.$field.' AS '.$field;
                    }elseif('_' != substr($key,0,1)) {
                        // 以_开头的为特殊定义
                        if( false !== strpos($key,'*') ||  false !== strpos($key,'(') || false !== strpos($key,'.')) {
                            //如果包含* 或者 使用了sql方法 则不再添加前面的表名
                            $fields[]    =   $key.' AS '.$field;
                        }else{
                            $fields[]    =   $k.'.'.$key.' AS '.$field;
                        }
                    }
                }
            }
            $fields = implode(',',$fields);
        }else{
            if(!is_array($fields)) {
                $fields =   explode(',',$fields);
            }
            // 解析成视图字段
            $array =  array();
            foreach ($fields as $key=>$field){
                if(strpos($field,'(') || strpos(strtolower($field),' as ')){
                    // 使用了函数或者别名
                    $array[] =  $field;
                    unset($fields[$key]);
                }
            }
            foreach ($this->viewFields as $name=>$val){
                $k = isset($val['_as'])?$val['_as']:$name;
                foreach ($fields as $key=>$field){
                    if(false !== $_field = array_search($field,$val)) {
                        // 存在视图字段
                        if(is_numeric($_field)) {
                            $array[]    =   $k.'.'.$field.' AS '.$field;
                        }else{
                            if( false !== strpos($_field,'*') ||  false !== strpos($_field,'(') || false !== strpos($_field,'.')) {
                                //如果包含* 或者 使用了sql方法 则不再添加前面的表名
                                $array[]    =   $_field.' AS '.$field;
                            }else{
                                $array[]    =   $k.'.'.$_field.' AS '.$field;
                            }
                        }
                    }
                }
            }
            $fields = implode(',',$array);
        }
        return $fields;
    }

}
?>