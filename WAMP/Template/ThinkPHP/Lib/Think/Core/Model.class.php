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
 * ThinkPHP Model模型类
 * 实现了ORM和ActiveRecords模式
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Core
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id$
 +------------------------------------------------------------------------------
 */
class Model extends Base implements IteratorAggregate
{
    // 操作状态
    const INSERT_STATUS    =  1;  // 插入
    const UPDATE_STATUS   =  2;  // 更新
    const ALL_STATUS          =  3;  // 全部

    // 当前数据库操作对象
    protected $db = null;

    // 主键名称
    protected $pk  = 'id';

    // 数据表前缀
    protected $tablePrefix  =   '';

    // 模型名称
    protected $name = '';

    // 数据库名称
    protected $dbName  = '';

    // 数据表名（不包含表前缀）
    protected $tableName = '';

    // 实际数据表名（包含表前缀）
    protected $trueTableName ='';

    // 最近错误信息
    protected $error = '';

    // 数据信息
    protected $data =   array();

    // 查询表达式参数
    protected $options  =   array();

    // 数据列表信息
    protected $dataList =   array();

    // 返回数据类型
    protected $returnType  =  'array';

    /**
     +----------------------------------------------------------
     * 架构函数
     * 取得DB类的实例对象 数据表字段检查
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param mixed $data 要创建的数据对象内容
     +----------------------------------------------------------
     */
    public function __construct()
    {
        // 模型初始化
        $this->_initialize();
        // 模型名称获取
        $this->name =   $this->getModelName();
        // 数据库初始化操作
        import("Db");
        // 获取数据库操作对象
        if(!empty($this->connection)) {
            // 当前模型有独立的数据库连接信息
            $this->db = Db::getInstance($this->connection);
        }else{
            $this->db = Db::getInstance();
        }
        // 设置表前缀
        $this->tablePrefix = $this->tablePrefix?$this->tablePrefix:C('DB_PREFIX');
    }

    /**
     +----------------------------------------------------------
     * 取得模型实例对象
     +----------------------------------------------------------
     * @static
     * @access public
     +----------------------------------------------------------
     * @return Model 返回数据模型实例
     +----------------------------------------------------------
     */
    public static function getInstance()
    {
        return get_instance_of(__CLASS__);
    }

    /**
     +----------------------------------------------------------
     * 获取Iterator因子
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return Iterate
     +----------------------------------------------------------
     */
    public function getIterator()
    {
        if(!empty($this->dataList)) {
            // 存在数据集则返回数据集
            return new ArrayObject($this->dataList);
        }elseif(!empty($this->data)){
            // 存在数据对象则返回对象的Iterator
            return new ArrayObject($this->data);
        }
    }

    /**
     +----------------------------------------------------------
     * 设置数据对象的值 （魔术方法）
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $name 名称
     * @param mixed $value 值
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    public function __set($name,$value) {
        // 设置数据对象属性
        $this->data[$name]  =   $value;
    }

    /**
     +----------------------------------------------------------
     * 获取数据对象的值 （魔术方法）
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $name 名称
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    public function __get($name) {
        if(isset($this->data[$name])) {
            return $this->data[$name];
        }else{
            return null;
        }
    }

    /**
     +----------------------------------------------------------
     * 利用__call方法实现一些特殊的Model方法 （魔术方法）
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $method 方法名称
     * @param array $args 调用参数
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    public function __call($method,$args) {
        if(in_array(strtolower($method),array('field','table','where','order','limit','having','group','distinct','lazy'),true)) {
            // 连贯操作的实现
            $this->options[strtolower($method)] =   $args[0];
            return $this;
        }elseif(in_array(strtolower($method),array('count','sum','min','max','avg'),true)){
            // 统计查询的实现
            $field =  isset($args[0])?$args[0]:'*';
            return $this->getField($method.'('.$field.') AS tp_'.$method);
        }elseif(strtolower(substr($method,0,5))=='getby') {
            // 根据某个字段获取记录
            $field   =   $this->parseName(substr($method,5));
            $options['where'] =  $field.'=\''.$args[0].'\'';
            return $this->find($options);
        }else{
            throw_exception(__CLASS__.':'.$method.L('_METHOD_NOT_EXIST_'));
            return;
        }
    }

    // 回调方法 初始化模型
    protected function _initialize() {}

    /**
     +----------------------------------------------------------
     * 对保存到数据库的数据进行处理
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param mixed $data 要操作的数据
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
     protected function _facade($data) {
        // 检查非数据字段
        if(isset($this->fields)) {
            foreach ($data as $key=>$val){
                if(!in_array($key,$this->fields,true)) {
                    unset($data[$key]);
                }
            }
        }
        return $data;
     }

    /**
     +----------------------------------------------------------
     * 新增数据
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param mixed $data 数据
     * @param array $options 表达式
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    public function add($data='',$options=array()) {
        if(empty($data)) {
            // 没有传递数据，获取当前数据对象的值
            if(!empty($this->data)) {
                $data    =   $this->data;
            }else{
                $this->error = L('_DATA_TYPE_INVALID_');
                return false;
            }
        }
        // 分析表达式
        $options =  $this->_parseOptions($options);
        // 数据处理
        $data = $this->_facade($data);
        $this->_before_insert($data,$options);
        // 写入数据到数据库
        if(false === $result = $this->db->insert($data,$options)){
            // 数据库插入操作失败
            $this->error = L('_OPERATION_WRONG_');
            return false;
        }else {
            $insertId   =   $this->getLastInsID();
            if($insertId) {
                $data[$this->getPk()]  = $insertId;
                $this->_after_insert($data,$options);
                return $insertId;
            }
            //成功后返回插入ID
            return $result;
        }
    }
    // 插入数据前的回调方法
    protected function _before_insert(&$data,$options) {}
    // 插入成功后的回调方法
    protected function _after_insert($data,$options) {}

    /**
     +----------------------------------------------------------
     * 保存数据
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param mixed $data 数据
     * @param array $options 表达式
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    public function save($data='',$options=array()) {
        if(empty($data)) {
            // 没有传递数据，获取当前数据对象的值
            if(!empty($this->data)) {
                $data    =   $this->data;
            }else{
                $this->error = L('_DATA_TYPE_INVALID_');
                return false;
            }
        }
        // 数据处理
        $data = $this->_facade($data);
        // 如果存在主键数据 则自动作为更新条件
        if(empty($options['where']) && isset($data[$this->getPk()])) {
            $pk   =  $this->getPk();
            $options['where']  =  $pk.'=\''.$data[$pk].'\'';
            $pkValue = $data[$pk];
            unset($data[$pk]);
        }
        // 分析表达式
        $options =  $this->_parseOptions($options);
        $this->_before_update($data,$options);
        if(false === $this->db->update($data,$options)){
            $this->error = L('_OPERATION_WRONG_');
            return false;
        }else {
            if(isset($pkValue)) {
                $data[$this->getPk()]   =  $pkValue;
            }
            $this->_after_update($data,$options);
            return true;
        }
    }
    // 插入数据前的回调方法
    protected function _before_update(&$data,$options) {}
    // 更新成功后的回调方法
    protected function _after_update($data,$options) {}

    /**
     +----------------------------------------------------------
     * 删除数据
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param mixed $options 表达式
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    public function delete($options=array()) {
        if(empty($options) && empty($this->options)) {
            // 如果删除条件为空 则删除当前数据对象所对应的记录
            if(!empty($this->data) && isset($this->data[$this->getPk()])) {
                return $this->delete($this->data[$this->getPk()]);
            }else{
                return false;
            }
        }
        if(is_numeric($options)  || is_string($options)) {
            // 根据主键删除记录
            $where  =  $this->getPk().'=\''.$options.'\'';
            $pkValue = $options;
            $options =  array();
            $options['where'] =  $where;
        }
        // 分析表达式
        $options =  $this->_parseOptions($options);
        $result=    $this->db->delete($options);
        if(false === $result ){
            $this->error =  L('_OPERATION_WRONG_');
            return false;
        }else {
            $data = array();
            if(isset($pkValue)) {
                $data[$this->getPk()]   =  $pkValue;
            }
            $this->_after_delete($data,$options);
            // 返回删除记录个数
            return $result;
        }
    }
    // 删除成功后的回调方法
    protected function _after_delete($data,$options) {}

    /**
     +----------------------------------------------------------
     * 查询数据集
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $options 表达式参数
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    public function select($options=array()) {
        // 分析表达式
        $options =  $this->_parseOptions($options);
        if($resultSet = $this->db->select($options)) {
            $this->dataList = $resultSet;
            $this->_after_select($resultSet,$options);
            return $this->returnResultSet($resultSet);
        }else{
            return false;
        }
    }
    // 查询成功后的回调方法
    protected function _after_select(&$result,$options) {}

    public function findAll($options=array()) {
        return $this->select($options);
    }

    /**
     +----------------------------------------------------------
     * 分析表达式
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param array $options 表达式参数
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    private function _parseOptions($options) {
        if(is_array($options)) {
            $options =  array_merge($this->options,$options);
        }
        // 查询过后清空sql表达式组装 避免影响下次查询
        $this->options  =   array();
        if(!isset($options['table'])) {
            // 自动获取表名
            $options['table'] =$this->getTableName();
        }
        // 表达式过滤
        $this->_options_filter($options);
        return $options;
    }
    // 表达式过滤回调方法
    protected function _options_filter(&$options) {}

    /**
     +----------------------------------------------------------
     * 查询数据
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param mixed $options 表达式参数
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
     public function find($options=array()) {
         if(is_numeric($options) || is_string($options)) {
             $where = $this->getPk().'=\''.$options.'\'';
             $options = array();
             $options['where'] = $where;
         }
         // 总是查找一条记录
        $options['limit'] = 1;
        // 分析表达式
        $options =  $this->_parseOptions($options);
        if($result = $this->db->select($options)) {
            $this->data = $result[0];
            $this->_after_find($this->data,$options);
            return $this->returnResult($this->data);
        }else{
            return false;
        }
     }
     // 查询成功的回调方法
     protected function _after_find(&$result,$options) {}

    /**
     +----------------------------------------------------------
     * 返回数据
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param array $data 数据
     * @param string $type 返回类型 默认为数组
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    protected function returnResult($data,$type='') {
        if('' === $type) {
            $type = $this->returnType;
        }
        switch($type) {
            case 'array' :  return $data;
            case 'object':  return (object)$data;
            default:// 允许用户自定义返回类型
                if(class_exists($type)){
                    return new $type($data);
                }else{
                    throw_exception(L('_CLASS_NOT_EXIST_').':'.$type);
                }
        }
    }

    /**
     +----------------------------------------------------------
     * 返回数据列表
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param array $resultSet 数据
     * @param string $type 返回类型 默认为数组
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    protected function returnResultSet(&$resultSet,$type='') {
        foreach ($resultSet as $key=>$data){
            $resultSet[$key]  =  $this->returnResult($data,$type);
        }
        return $resultSet;
    }

    /**
     +----------------------------------------------------------
     * 设置返回数据类型
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $type 返回类型
     * @param string $classpath 类路径
     * 当type为用户自定义类型的时候使用
     * 会自动完成类的导入工作
     +----------------------------------------------------------
     * @return model
     +----------------------------------------------------------
     */
    public function returnAs($type,$classpath=NULL) {
        $this->returnType = $type;
        if(NULL !== $classpath) {
            // 如果设置了类路径 则首先导入自定义类
            import($classpath.$type);
        }
        return $this;
    }

    /**
     +----------------------------------------------------------
     * 设置记录的某个字段值
     * 支持使用数据库字段和方法
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string|array $field  字段名
     * @param string|array $value  字段值
     * @param mixed $condition  条件
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    public function setField($field,$value,$condition='') {
        if(empty($condition) && isset($this->options['where'])) {
            $condition   =  $this->options['where'];
        }
        $options['where'] =  $condition;
        if(is_array($field)) {
            foreach ($field as $key=>$val){
                $data[$val]    = $value[$key];
            }
        }else{
            $data[$field]   =  $value;
        }
        return $this->save($data,$options);
    }

    /**
     +----------------------------------------------------------
     * 获取一条记录的某个字段值
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $field  字段名
     * @param mixed $condition  查询条件
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    public function getField($field,$condition='') {
        if(empty($condition) && isset($this->options['where'])) {
            $condition   =  $this->options['where'];
        }
        $options['where'] =  $condition;
        $options['field']    =  $field;
        $result   =  $this->find($options);
        if($result) {
            return reset($result);
        }else{
            return null;
        }
    }

    /**
     +----------------------------------------------------------
     * 获取数据集的个别字段值
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $field 字段名称
     * @param mixed $condition  条件
     * @param string $spea  多字段分割符号
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    public function getFields($field,$condition='',$sepa=' ')
    {
        if(empty($condition) && isset($this->options['where'])) {
            $condition   =  $this->options['where'];
        }
        $options['where'] =  $condition;
        $options['field']    =  $field;
        $rs = $this->select($options);
        if($rs) {
            $field  =   explode(',',$field);
            $cols    =   array();
            $length  = count($field);
            foreach ($rs as $result){
                if($length>1) {
                    $cols[$result[$field[0]]]   =   '';
                    for($i=1; $i<$length; $i++) {
                        if($i+1<$length){
                            $cols[$result[$field[0]]] .= $result[$field[$i]].$sepa;
                        }else{
                            $cols[$result[$field[0]]] .= $result[$field[$i]];
                        }
                    }
                }else{
                    $cols[]  =   $result[$field[0]];
                }
            }
            return $cols;
        }else{
            return null;
        }
    }

    /**
     +----------------------------------------------------------
     * 创建数据对象 但不保存到数据库
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param mixed $data 创建数据
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
     public function create($data='') {
        // 如果没有传值默认取POST数据
        if(empty($data)) {
            $data    =   $_POST;
        }elseif(is_object($data)){
            $data   =   get_object_vars($data);
        }elseif(!is_array($data)){
            $this->error = L('_DATA_TYPE_INVALID_');
            return false;
        }
        $type = self::INSERT_STATUS;// 新增数据
        if(isset($data[$this->getPk()])) {
            $pk   =  $this->getPk();
            if($this->field($pk)->where($pk.'=\''.$data[$pk].'\'')->find()) {
                // 编辑状态
                $type = self::UPDATE_STATUS; // 编辑数据
            }
        }
        // 验证回调接口
        if(!$this->_before_create($data,$type)) {
            return false;
        }
        // 检查字段映射
        if(isset($this->_map)) {
            foreach ($this->_map as $key=>$val){
                if(isset($data[$key])) {
                    $data[$val] =   $data[$key];
                    unset($data[$key]);
                }
            }
        }
        // 创建完成后回调接口
        $this->_after_create($data,$type);
        // 赋值当前数据对象
        $this->data =   $data;
        return $data;
     }
     // 数据创建成功前的验证方法
     protected function _before_create($data,$type) {return true;}
     // 数据创建成功后的回调方法
     protected function _after_create(&$data,$type) {}

    /**
     +----------------------------------------------------------
     * SQL查询
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param mixed $sql  SQL指令
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    public function query($sql)
    {
        if(is_array($sql)) {
            return $this->patchQuery($sql);
        }
        if(!empty($sql)) {
            if(strpos($sql,'__TABLE__')) {
                $sql    =   str_replace('__TABLE__',$this->getTableName(),$sql);
            }
            return $this->db->query($sql);
        }else{
            return false;
        }
    }

    /**
     +----------------------------------------------------------
     * 执行SQL语句
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $sql  SQL指令
     +----------------------------------------------------------
     * @return false | integer
     +----------------------------------------------------------
     */
    public function execute($sql='')
    {
        if(!empty($sql)) {
            if(strpos($sql,'__TABLE__')) {
                $sql    =   str_replace('__TABLE__',$this->getTableName(),$sql);
            }
            $result =   $this->db->execute($sql);
            return $result;
        }else {
            return false;
        }
    }

    /**
     +----------------------------------------------------------
     * 得到当前的数据对象名称
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function getModelName()
    {
        if(empty($this->name)) {
            $this->name =   substr(get_class($this),0,-5);
        }
        return $this->name;
    }

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
            $tableName  = !empty($this->tablePrefix) ? $this->tablePrefix : '';
            if(!empty($this->tableName)) {
                $tableName .= $this->tableName;
            }elseif(C('AUTO_NAME_IDENTIFY')){
                // 智能识别表名
                $tableName .= $this->parseName($this->name);
            }else{
                $tableName .= $this->name;
            }
            if(!empty($this->dbName)) {
                $tableName    =  $this->dbName.'.'.$tableName;
            }
            $this->trueTableName    =   strtolower($tableName);
        }
        return $this->trueTableName;
    }

    /**
     +----------------------------------------------------------
     * 启动事务
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    public function startTrans()
    {
        $this->commit();
        $this->db->startTrans();
        return ;
    }

    /**
     +----------------------------------------------------------
     * 提交事务
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    public function commit()
    {
        return $this->db->commit();
    }

    /**
     +----------------------------------------------------------
     * 事务回滚
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    public function rollback()
    {
        return $this->db->rollback();
    }

    /**
     +----------------------------------------------------------
     * 返回模型的错误信息
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function getError(){
        return $this->error;
    }

    /**
     +----------------------------------------------------------
     * 返回数据库的错误信息
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function getDbError() {
        return $this->db->getError();
    }

    /**
     +----------------------------------------------------------
     * 返回最后插入的ID
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function getLastInsID() {
        return $this->db->lastInsID;
    }

    /**
     +----------------------------------------------------------
     * 返回最后执行的sql语句
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function getLastSql() {
        return $this->db->getLastSql();
    }

    /**
     +----------------------------------------------------------
     * 查询SQL组装 join
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $join
     +----------------------------------------------------------
     * @return Model
     +----------------------------------------------------------
     */
    public function join($join) {
        if(is_array($join)) {
            $this->options['join'] =  $join;
        }else{
            $this->options['join'][]  =   $join;
        }
        return $this;
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
        return $this->pk?$this->pk:'id';
    }

};
?>