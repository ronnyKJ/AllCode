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
 * ThinkPHP 高级模型类
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Core
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id$
 +------------------------------------------------------------------------------
 */
class AdvModel extends Model {
    const MODEL_INSERT      =   1;      //  插入模型数据
    const MODEL_UPDATE    =   2;      //  更新模型数据
    const MODEL_BOTH      =   3;      //  包含上面两种方式
    const MUST_VALIDATE         =   1;// 必须验证
    const EXISTS_VAILIDATE      =   2;// 表单存在字段则验证
    const VALUE_VAILIDATE       =   3;// 表单值不为空则验证

    // 字段信息
    protected $fields = array();
    // 字段类型信息
    protected $type  =   array();
    // 数据库连接对象列表
    private $_db = array();
    // 自动写入时间戳的字段名称
    protected $autoCreateTimestamps = 'create_time';
    protected $autoUpdateTimestamps = 'update_time';
    // 自动写入的时间格式
    protected $autoTimeFormat = '';

    public function __construct() {
        parent::__construct();
        // 设置默认的数据库连接
        $this->_db[0]   =   $this->db;
        // 数据表字段检测
        $this->_checkTableInfo();
    }

    protected function _checkTableInfo() {
        // 如果不是Model类 自动记录数据表信息
        // 只在第一次执行记录
        if(empty($this->fields)) {
            // 如果数据表字段没有定义则自动获取
            if(C('DB_FIELDS_CACHE')) {
                $identify   =   $this->name.'_fields';
                $this->fields = F($identify);
                if(!$this->fields) {
                    $this->flush();
                }
            }else{
                // 每次都会读取数据表信息
                $this->flush();
            }
        }
    }

    public function flush() {
        // 缓存不存在则查询数据表信息
        $fields =   $this->db->getFields($this->getTableName());
        $this->fields   =   array_keys($fields);
        $this->fields['_autoinc'] = false;
        foreach ($fields as $key=>$val){
            // 记录字段类型
            $this->type[$key]    =   $val['type'];
            if($val['primary']) {
                $this->fields['_pk'] = $key;
                if($val['autoinc']) $this->fields['_autoinc']   =   true;
            }
        }
        // 2008-3-7 增加缓存开关控制
        if(C('DB_FIELDS_CACHE')) {
            // 永久缓存数据表信息
            // 2007-10-31 更改为F方法保存，保存在项目的Data目录，并且始终采用文件形式
            $identify   =   $this->name.'_fields';
            F($identify,$this->fields);
        }
    }

    /**
     +----------------------------------------------------------
     * 获取主键名称
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function getPk() {
        return $this->fields['_pk']?$this->fields['_pk']:'id';
    }

    public function getDbFields(){
        return $this->fields;
    }

    // 查询成功后的回调方法
    protected function _after_find(&$result,$options='') {
        // 检查序列化字段
        $result   =  $this->checkSerializeField($result);
        // 检查字段过滤
        $result   =  $this->getFilterFields($result);
    }

    // 查询数据集成功后的回调方法
    protected function _after_select(&$resultSet,$options='') {
        // 检查序列化字段
        $resultSet   =  $this->checkListSerializeField($resultSet);
        // 检查列表字段过滤
        $resultSet   =  $this->getFilterListFields($resultSet);
    }

    // 写入前的回调方法
    protected function _before_insert(&$data,$options='') {
        $data   =  $this->setFilterFields($data);
        $data = $this->serializeField($data);
    }

    // 更新前的回调方法
    protected function _before_update(&$data,$options='') {
        // 检查只读字段
        $data = $this->checkReadonlyField($data);
        $data   =  $this->setFilterFields($data);
        // 检查序列化字段
        $data = $this->serializeField($data);
    }

    // 创建数据前的回调方法
    protected function _before_create($data,$type){
        // 自动验证
        return $this->autoValidation($data,$type);
    }

    // 创建数据后的回调方法
    protected function _after_create(&$data,$type) {
        // 自动保存时间戳
        $this->autoSaveTime($data,$type);
        // 自动完成
        $this->autoOperation($data,$type);
    }

    /**
     +----------------------------------------------------------
     * 字段值增长
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $field  字段名
     * @param mixed $condition  条件
     * @param integer $step  增长值
     * @param integer $lazyTime  延时时间(s)
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    public function setInc($field,$condition='',$step=1,$lazyTime=0) {
        if(empty($condition) && isset($this->options['where'])) {
            $condition   =  $this->options['where'];
        }
        if($lazyTime>0) {// 延迟写入
            $guid =  md5($this->name.'_'.$field);
            $step = $this->lazyWrite($guid,$step,$lazyTime);
            if(false === $step ) {
                // 等待下次写入
                return true;
            }
        }
        return $this->setField($field,array('exp',$field.'+'.$step),$condition);
    }

    /**
     +----------------------------------------------------------
     * 字段值减少
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $field  字段名
     * @param mixed $condition  条件
     * @param integer $step  减少值
     * @param integer $lazyTime  延时时间(s)
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    public function setDec($field,$condition='',$step=1,$lazyTime=0) {
        if(empty($condition) && isset($this->options['where'])) {
            $condition   =  $this->options['where'];
        }
        if($lazyTime>0) {// 延迟写入
            $guid =  md5($this->name.'_'.$field);
            $step = $this->lazyWrite($guid,$step,$lazyTime);
            if(false === $step ) {
                // 等待下次写入
                return true;
            }
        }
        return $this->setField($field,array('exp',$field.'-'.$step),$condition);
    }

    /**
     +----------------------------------------------------------
     * 延时写入检查 返回false表示需要延时
     * 否则返回实际写入的数值
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $guid  写入标识
     * @param integer $step  写入步进值
     * @param integer $lazyTime  延时时间(s)
     +----------------------------------------------------------
     * @return false|integer
     +----------------------------------------------------------
     */
    protected function lazyWrite($guid,$step,$lazyTime) {
        if(false !== ($value = F($guid))) { // 存在缓存写入数据
            if(time()>F($guid.'_time')+$lazyTime) {
                // 延时写入时间到了，删除缓存数据 并实际写入数据库
                F($guid,NULL);
                F($guid.'_time',NULL);
                return $value+$step;
            }else{
                // 追加数据到缓存
                F($guid,$value+$step);
                return false;
            }
        }else{ // 没有缓存数据
            F($guid,$step);
            // 计时开始
            F($guid.'_time',time());
            return false;
        }
    }

    /**
     +----------------------------------------------------------
     * 检查序列化数据字段
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param array $data 数据
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
     protected function serializeField(&$data) {
        // 检查序列化字段
        if(!empty($this->serializeField)) {
            // 定义方式  $this->serializeField = array('ser'=>array('name','email'));
            foreach ($this->serializeField as $key=>$val){
                if(empty($data[$key])) {
                    $serialize  =   array();
                    foreach ($val as $name){
                        if(isset($data[$name])) {
                            $serialize[$name]   =   $data[$name];
                            unset($data[$name]);
                        }
                    }
                    $data[$key] =   serialize($serialize);
                }
            }
        }
        return $data;
     }

    // 检查返回数据的序列化字段
    protected function checkSerializeField(&$result) {
        // 检查序列化字段
        if(!empty($this->serializeField)) {
            foreach ($this->serializeField as $key=>$val){
                if(isset($result[$key])) {
                    $serialize   =   unserialize($result[$key]);
                    foreach ($serialize as $name=>$value){
                        $result[$name]  =   $value;
                    }
                    unset($serialize,$result[$key]);
                }
            }
        }
        return $result;
    }

    // 检查数据集的序列化字段
    protected function checkListSerializeField(&$resultSet) {
        // 检查序列化字段
        if(!empty($this->serializeField)) {
            foreach ($this->serializeField as $key=>$val){
                foreach ($resultSet as $k=>$result){
                    if(isset($result[$key])) {
                        $serialize   =   unserialize($result[$key]);
                        foreach ($serialize as $name=>$value){
                            $result[$name]  =   $value;
                        }
                        unset($serialize,$result[$key]);
                        $resultSet[$k] =   $result;
                    }
                }
            }
        }
        return $resultSet;
    }

    /**
     +----------------------------------------------------------
     * 获取数据的时候过滤数据字段
     +----------------------------------------------------------
     * @access pubic
     +----------------------------------------------------------
     * @param mixed $result 查询的数据
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    public function getFilterFields(&$result) {
        if(!empty($this->_filter)) {
            foreach ($this->_filter as $field=>$filter){
                if(isset($result[$field])) {
                    $fun  =  $filter[1];
                    if(!empty($fun)) {
                        if(isset($filter[2]) && $filter[2]){
                            // 传递整个数据对象作为参数
                            $result[$field]  =  call_user_func($fun,$result);
                        }else{
                            // 传递字段的值作为参数
                            $result[$field]  =  call_user_func($fun,$result[$field]);
                        }
                    }
                }
            }
        }
        return $result;
    }

    public function getFilterListFields(&$resultSet) {
        if(!empty($this->_filter)) {
            foreach ($resultSet as $key=>$result){
                $resultSet[$key]  =  $this->getFilterFields($result);
            }
        }
        return $resultSet;
    }

    /**
     +----------------------------------------------------------
     * 写入数据的时候过滤数据字段
     +----------------------------------------------------------
     * @access pubic
     +----------------------------------------------------------
     * @param mixed $result 查询的数据
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    public function setFilterFields($data) {
        if(!empty($this->_filter)) {
            foreach ($this->_filter as $field=>$filter){
                if(isset($data[$field])) {
                    $fun              =  $filter[0];
                    if(!empty($fun)) {
                        if(isset($filter[2]) && $filter[2]) {
                            // 传递整个数据对象作为参数
                            $data[$field]   =  call_user_func($fun,$data);
                        }else{
                            // 传递字段的值作为参数
                            $data[$field]   =  call_user_func($fun,$data[$field]);
                        }
                    }
                }
            }
        }
        return $data;
    }

    /**
     +----------------------------------------------------------
     * 检查只读字段
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param array $data 数据
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    protected function checkReadonlyField(&$data) {
        if(!empty($this->readonlyField)) {
            foreach ($this->readonlyField as $key=>$field){
                if(isset($data[$field])) {
                    unset($data[$field]);
                }
            }
        }
        return $data;
    }

    /**
     +----------------------------------------------------------
     * 增加数据库连接
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param mixed $config 数据库连接信息
     * 支持批量添加 例如 array(1=>$config1,2=>$config2)
     * @param mixed $linkNum  创建的连接序号
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    public function addConnect($config,$linkNum=NULL) {
        if(isset($this->_db[$linkNum])) {
            return false;
        }
        if(NULL === $linkNum && is_array($config)) {
            // 支持批量增加数据库连接
            foreach ($config as $key=>$val){
                $this->_db[$key]            =    Db::getInstance($val);
            }
            return true;
        }
        // 创建一个新的实例
        $this->_db[$linkNum]            =    Db::getInstance($config);
        return true;
    }

    /**
     +----------------------------------------------------------
     * 删除数据库连接
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param integer $linkNum  创建的连接序号
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    public function delConnect($linkNum) {
        if(isset($this->_db[$linkNum])) {
            $this->_db[$linkNum]->close();
            unset($this->_db[$linkNum]);
            return true;
        }
        return false;
    }

    /**
     +----------------------------------------------------------
     * 关闭数据库连接
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param integer $linkNum  创建的连接序号
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    public function closeConnect($linkNum) {
        if(isset($this->_db[$linkNum])) {
            $this->_db[$linkNum]->close();
            return true;
        }
        return false;
    }

    /**
     +----------------------------------------------------------
     * 切换数据库连接
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param integer $linkNum  创建的连接序号
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    public function switchConnect($linkNum) {
        if(isset($this->_db[$linkNum])) {
            // 在不同实例直接切换
            $this->db   =   $this->_db[$linkNum];
            return true;
        }else{
            return false;
        }
    }

    /**
     +----------------------------------------------------------
     * 批处理执行SQL语句
     * 批处理的指令都认为是execute操作
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $sql  SQL批处理指令
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    public function patchQuery($sql=array()) {
        if(!is_array($sql)) {
            return false;
        }
        // 自动启动事务支持
        $this->startTrans();
        try{
            foreach ($sql as $_sql){
                $result   =  $this->execute($_sql);
                if(false === $result) {
                    // 发生错误自动回滚事务
                    $this->rollback();
                    return false;
                }
            }
            // 提交事务
            $this->commit();
        } catch (Exception $e) {
            $this->rollback();
        }
        return true;
    }

    // 自动保存时间戳字段
    protected function autoSaveTime(&$data,$type) {
        switch($type) {
            case self::INSERT_STATUS:
                $name   = $this->autoCreateTimestamps;
                break;
            case self::UPDATE_STATUS:
                $name   = $this->autoUpdateTimestamps;
        }
        // 自动保存时间戳
        if(!empty($this->autoTimeFormat)) {
            // 用指定日期格式记录时间戳
            $data[$name] =    date($this->autoTimeFormat);
        }else{
            // 默认记录时间戳
            $data[$name] = time();
        }
        return $data;
    }

    /**
     +----------------------------------------------------------
     * 自动表单处理
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $data 创建数据
     * @param string $type 创建类型
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    private function autoOperation(&$data,$type) {
        // 自动填充
        if(!empty($this->_auto)) {
            foreach ($this->_auto as $auto){
                // 填充因子定义格式
                // array('field','填充内容','填充条件','附加规则',[额外参数])
                if(empty($auto[2])) $auto[2] = self::MODEL_INSERT;// 默认为新增的时候自动填充
                else $auto[2]   =   strtoupper($auto[2]);
                if( ($type ==self::INSERT_STATUS  && $auto[2] == self::MODEL_INSERT) ||   ($type == self::UPDATE_STATUS  && $auto[2] == self::MODEL_UPDATE) || $auto[2] == self::MODEL_BOTH)
                {
                    switch($auto[3]) {
                        case 'function':    //  使用函数进行填充 字段的值作为参数
                        case 'callback': // 使用回调方法
                            if(isset($auto[4])) {
                                $args = $auto[4];
                            }else{
                                $args = array();
                            }
                            array_unshift($args,$data[$auto[0]]);
                            if('function'==$auto[3]) {
                                $data[$auto[0]]  = call_user_func_array($auto[1], $args);
                            }else{
                                $data[$auto[0]]  =  call_user_func_array(array(&$this,$auto[1]), $args);
                            }
                            break;
                        case 'field':    // 用其它字段的值进行填充
                            $data[$auto[0]] = $data[$auto[1]];
                            break;
                        case 'string':
                        default: // 默认作为字符串填充
                            $data[$auto[0]] = $auto[1];
                    }
                    if(false === $data[$auto[0]] ) {
                        unset($data[$auto[0]]);
                    }
                }
            }
        }
        return $data;
    }

    /**
     +----------------------------------------------------------
     * 自动表单验证
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $data 创建数据
     * @param string $type 创建类型
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function autoValidation($data,$type) {
        // 属性验证
        if(!empty($this->_validate)) {
            // 如果设置了数据自动验证
            // 则进行数据验证
            // 重置验证错误信息
            foreach($this->_validate as $key=>$val) {
                // 验证因子定义格式
                // array(field,rule,message,condition,type,when,params)
                // 判断是否需要执行验证
                if(empty($val[5]) || $val[5]== self::ALL_STATUS || $val[5]== $type ) {
                    if(0==strpos($val[2],'{%') && strpos($val[2],'}')) {
                        // 支持提示信息的多语言 使用 {%语言定义} 方式
                        $val[2]  =  L(substr($val[2],2,-1));
                    }
                    $val[3]  =  isset($val[3])?$val[3]:self::EXISTS_VAILIDATE;
                    $val[4]  =  isset($val[4])?$val[4]:'regex';
                    // 判断验证条件
                    switch($val[3]) {
                        case self::MUST_VALIDATE:   // 必须验证 不管表单是否有设置该字段
                            if(false === $this->_validationField($data,$val)){
                                $this->error    =   $val[2];
                                return false;
                            }
                            break;
                        case self::VALUE_VAILIDATE:    // 值不为空的时候才验证
                            if('' != trim($data[$val[0]])){
                                if(false === $this->_validationField($data,$val)){
                                    $this->error    =   $val[2];
                                    return false;
                                }
                            }
                            break;
                        default:    // 默认表单存在该字段就验证
                            if(isset($data[$val[0]])){
                                if(false === $this->_validationField($data,$val)){
                                    $this->error    =   $val[2];
                                    return false;
                                }
                            }
                    }
                }
            }
        }
        return true;
    }

    /**
     +----------------------------------------------------------
     * 根据验证因子验证字段
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $data 创建数据
     * @param string $val 验证规则
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function _validationField($data,$val) {
        switch($val[4]) {
            case 'function':// 使用函数进行验证
            case 'callback':// 调用方法进行验证
                if(isset($val[6])) {
                    $args = $val[6];
                }else{
                    $args = array();
                }
                array_unshift($args,$data[$val[0]]);
                if('function'==$val[4]) {
                    return call_user_func_array($val[1], $args);
                }else{
                    return call_user_func_array(array(&$this, $val[1]), $args);
                }
            case 'confirm': // 验证两个字段是否相同
                if($data[$val[0]] != $data[$val[1]] ) {
                    return false;
                }
                break;
            case 'in': // 验证是否在某个数组范围之内
                if(!in_array($data[$val[0]] ,$val[1]) ) {
                    return false;
                }
                break;
            case 'equal': // 验证是否等于某个值
                if($data[$val[0]] != $val[1]) {
                    return false;
                }
                break;
            case 'unique': // 验证某个值是否唯一
                if(is_string($val[0]) && strpos($val[0],',')) {
                    $val[0]  =  explode(',',$val[0]);
                }
                $map = array();
                if(is_array($val[0])) {
                    // 支持多个字段验证
                    foreach ($val[0] as $field){
                        $map[$field]   =  $data[$field];
                    }
                }else{
                    $map[$val[0]] = $data[$val[0]];
                }
                if($this->where($map)->find()) {
                    return false;
                }
                break;
            case 'regex':
            default:    // 默认使用正则验证 可以使用验证类中定义的验证名称
                // 检查附加规则
                if(!$this->validate($data[$val[0]],$val[1])) {
                    return false;
                }
        }
        return true;
    }

    /**
     +----------------------------------------------------------
     * 使用正则验证数据
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $value  要验证的数据
     * @param string $rule 验证规则
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    protected function validate($value,$rule) {
        $validate = array(
            'require'=> '/.+/',
            'email' => '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
            'url' => '/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/',
            'currency' => '/^\d+(\.\d+)?$/',
            'number' => '/\d+$/',
            'zip' => '/^[1-9]\d{5}$/',
            'integer' => '/^[-\+]?\d+$/',
            'double' => '/^[-\+]?\d+(\.\d+)?$/',
            'english' => '/^[A-Za-z]+$/',
        );
        // 检查是否有内置的正则表达式
        if(isset($validate[strtolower($rule)])) {
            $rule   =   $validate[strtolower($rule)];
        }
        return preg_match($rule,$value)===1;
    }

    /**
     +----------------------------------------------------------
     * 得到分表的的数据表名
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $data 操作的数据
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function getPartitionTableName($data=array()) {
        // 对数据表进行分区
        if(isset($data[$this->partition['field']])) {
            $field   =   $data[$this->partition['field']];
            switch($this->partition['type']) {
                case 'id':
                    // 按照id范围分表
                    $step    =   $this->partition['expr'];
                    $seq    =   floor($field / $step)+1;
                    break;
                case 'year':
                    // 按照年份分表
                    if(!is_numeric($field)) {
                        $field   =   strtotime($field);
                    }
                    $seq    =   date('Y',$field)-$this->partition['expr']+1;
                    break;
                case 'mod':
                    // 按照id的模数分表
                    $seq    =   ($field % $this->partition['num'])+1;
                    break;
                case 'md5':
                    // 按照md5的序列分表
                    $seq    =   (ord(substr(md5($field),0,1)) % $this->partition['num'])+1;
                    break;
                default :
                    if(function_exists($this->partition['type'])) {
                        // 支持指定函数哈希
                        $fun    =   $this->partition['type'];
                        $seq    =   (ord(substr($fun($field),0,1)) % $this->partition['num'])+1;
                    }else{
                        // 按照字段的首字母的值分表
                        $seq    =   (ord($field{0}) % $this->partition['num'])+1;
                    }
            }
            return $this->getTableName().'_'.$seq;
        }else{
            // 当设置的分表字段不在查询条件或者数据中
            // 进行联合查询，必须设定 partition['num']
            $tableName  =   array();
            for($i=0;$i<$this->partition['num'];$i++) {
                $tableName[] = 'SELECT * FROM '.$this->getTableName().'_'.$i;
            }
            $tableName = '( '.implode(" UNION ",$tableName).') AS '.$this->name;
            return $tableName;
        }
    }

    /**
     +----------------------------------------------------------
     * 把返回的数据集转换成Tree
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $list 要转换的数据集
     * @param string $pid parent标记字段
     * @param string $level level标记字段
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    public function toTree($list=null, $pk='id',$pid = 'pid',$child = '_child',$root=0)
    {
        if(null === $list) {
            // 默认直接取查询返回的结果集合
            $list   =   &$this->dataList;
        }
        // 创建Tree
        $tree = array();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $_key = is_object($data)?$data->$pk:$data[$pk];
                $refer[$_key] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = is_object($data)?$data->$pid:$data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                }else{
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }

    /**
     +----------------------------------------------------------
     * 对查询结果集进行排序
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $field 排序的字段名
     * @param array $sortby 排序类型 asc arsort natcaseror
     * @param array $list 查询结果
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    public function sortBy($field, $sortby='asc', $list='' ) {
       if(empty($list) && !empty($this->dataList)) {
           $list     =   $this->dataList;
       }
       if(is_array($list)){
           $refer = $resultSet = array();
           foreach ($list as $i => $data) {
               $refer[$i] = &$data[$field];
           }
           switch ($sortby) {
               case 'asc': // 正向排序
                    asort($refer);
                    break;
               case 'desc':// 逆向排序
                    arsort($refer);
                    break;
               case 'nat': // 自然排序
                    natcasesort($refer);
                    break;
           }
           foreach ( $refer as $key=> $val) {
               $resultSet[] = &$list[$key];
           }
           return $resultSet;
       }
       return false;
    }

    /**
     +----------------------------------------------------------
     * 在数据列表中搜索
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param mixed $condition 查询条件
     * 支持 array('name'=>$value) 或者 name=$value
     * @param array $list 数据列表
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    public function search($condition,$list=null) {
        if(null === $list) {
            // 默认直接在查询返回的结果集中搜索
            $list   =   &$this->dataList;
        }
        if(is_string($condition))
            parse_str($condition,$condition);
        // 返回的结果集合
        $resultSet = array();
        foreach ($list as $key=>$data){
            $find   =   false;
            foreach ($condition as $field=>$value){
                if(isset($data[$field])) {
                    if(0 === strpos($value,'/')) {
                        $find   =   preg_match($value,$data[$field]);
                    }elseif($data[$field]==$value){
                        $find = true;
                    }
                }
            }
            if($find) {
                $resultSet[]     =   &$list[$key];
            }
        }
        return $resultSet;
    }
}
?>