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
 * Pgsql数据库驱动类
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Db
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id$
 +------------------------------------------------------------------------------
 */
class DbPgsql extends Db{

    /**
     +----------------------------------------------------------
     * 架构函数 读取数据库配置信息
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $config 数据库配置数组
     +----------------------------------------------------------
     */
    public function __construct($config=''){
        if ( !extension_loaded('pgsql') ) {
            throw_exception(L('_NOT_SUPPERT_').':pgsql');
        }
        if(!empty($config)) {
            $this->config   =   $config;
        }
    }

    /**
     +----------------------------------------------------------
     * 连接数据库方法
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    public function connect($config='',$linkNum=0) {
        if ( !isset($this->linkID[$linkNum]) ) {
            if(empty($config))  $config =   $this->config;
            $conn = $this->pconnect ? 'pg_pconnect':'pg_connect';
            $this->linkID[$linkNum] =  $conn(
            'host='         . $config['hostname'] .
            ' port='            . $config['hostport'] .
            ' dbname='  . $config['database'] .
            ' user='            . $config['username'] .
            ' password='    . $config['password']
            );

            if (pg_connection_status($this->linkID[$linkNum]) !== 0){
                throw_exception($this->error(false));
            }
            $pgInfo = pg_version($this->linkID[$linkNum]);
            $this->dbVersion = $pgInfo['server'];
            // 标记连接成功
            $this->connected    =   true;
            //注销数据库安全信息
            if(1 != C('DB_DEPLOY_TYPE')) unset($this->config);
        }
        return $this->linkID[$linkNum];
    }

    /**
     +----------------------------------------------------------
     * 释放查询结果
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     */
    public function free() {
        @pg_free_result($this->queryID);
        $this->queryID = 0;
    }

    /**
     +----------------------------------------------------------
     * 执行查询 主要针对 SELECT, SHOW 等指令
     * 返回数据集
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param string $str  sql指令
     +----------------------------------------------------------
     * @return ArrayObject
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    protected function _query($str='') {
        $this->initConnect(false);
        if ( !$this->_linkID ) return false;
        if ( $str != '' ) $this->queryStr = $str;
        //释放前次的查询结果
        if ( $this->queryID ) {    $this->free();    }
        $this->queryTimes ++;
        $this->Q(1);
        $this->queryID = pg_query($this->_linkID,$this->queryStr );
        $this->debug();
        if ( !$this->queryID ) {
            if ( $this->debug)
                throw_exception($this->error());
            else
                return false;
        } else {
            $this->numRows = pg_num_rows($this->queryID);
            $this->resultSet = $this->getAll();
            return $this->resultSet;
        }
    }

    /**
     +----------------------------------------------------------
     * 执行语句 针对 INSERT, UPDATE 以及DELETE
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param string $str  sql指令
     +----------------------------------------------------------
     * @return integer
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    protected function _execute($str='') {
        $this->initConnect(true);
        if ( !$this->_linkID ) return false;
        if ( $str != '' ) $this->queryStr = $str;
        //释放前次的查询结果
        if ( $this->queryID ) {    $this->free();    }

        $this->writeTimes ++;
        $this->W(1);
        $this->debug();
        $tableName  =   '';
        if(substr($this->queryStr,0,6)=="INSERT"){
            $tableName=explode(" ",$this->queryStr);
            $tableName=";select last_value from {$tableName[2]}_id_seq;";
        }
        $result =   pg_query($this->_linkID,$this->queryStr.$tableName);
        $this->debug();
        if ( false === $result ) {
            if ( $this->debug)
                throw_exception($this->error());
            else
                return false;
        } else {
            $this->numRows = pg_affected_rows($result);
            if($tableName!=""){
                $result=pg_fetch_array($result);
                $this->lastInsID =$result[0];
            }
            return $this->numRows;
        }
    }

    /**
     +----------------------------------------------------------
     * 启动事务
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    public function startTrans() {
        $this->initConnect(true);
        if ( !$this->_linkID ) return false;
        //数据rollback 支持
        if ($this->transTimes == 0) {
            pg_exec($this->_linkID,'begin;');
        }
        $this->transTimes++;
        return ;
    }

    /**
     +----------------------------------------------------------
     * 用于非自动提交状态下面的查询提交
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return boolen
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    public function commit()
    {
        if ($this->transTimes > 0) {
            $result = pg_exec($this->_linkID,'end;');
            if(!$result){
                throw_exception($this->error());
                return false;
            }
            $this->transTimes = 0;
        }
        return true;
    }

    /**
     +----------------------------------------------------------
     * 事务回滚
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return boolen
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    public function rollback()
    {
        if ($this->transTimes > 0) {
            $result = pg_exec($this->_linkID,'abort;');
            if(!$result){
                throw_exception($this->error());
                return false;
            }
            $this->transTimes = 0;
        }
        return true;
    }

    /**
     +----------------------------------------------------------
     * 获得所有的查询数据
     * 查询结果放到 resultSet 数组中
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return resultSet
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    public function getAll() {
        if ( !$this->queryID ) {
            throw_exception($this->error());
            return false;
        }
        //返回数据集
        $result   =  pg_fetch_all($this->queryID);
        pg_result_seek($this->queryID,0);
        return $result;
    }

    /**
     +----------------------------------------------------------
     * 取得数据表的字段信息
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    public function getFields($tableName) {
        $result   =  $this->_query("select a.attname as \"Field\",
            t.typname as \"Type\",
            a.attnotnull as \"Null\",
            i.indisprimary as \"Key\",
            d.adsrc as \"Default\"
            from pg_class c
            inner join pg_attribute a on a.attrelid = c.oid
            inner join pg_type t on a.atttypid = t.oid
            left join pg_attrdef d on a.attrelid=d.adrelid and d.adnum=a.attnum
            left join pg_index i on a.attnum=ANY(i.indkey) and c.oid = i.indrelid
            where (c.relname='{$tablename}' or c.relname = lower('{$tablename}'))   AND a.attnum > 0
                order by a.attnum asc;");
        $info   =   array();
        foreach ($result as $key => $val) {
            $info[$val['Field']] = array(
            'name'    => $val['Field'],
            'type'    => $val['Type'],
            'notnull' => (bool) ($val['Null'] == 't'?1:0), // 't' is 'not null'
            'default' => $val['Default'],
            'primary' => (strtolower($val['Key']) == 't'),
            'autoinc' => (strtolower($val['Extra']) == "nextval('{$tableName}_id_seq'::regclass)"),
            );
        }
        return $info;
    }

    /**
     +----------------------------------------------------------
     * 取得数据库的表信息
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    public function getTables($dbName='') {
        $result = $this->_query("select tablename as Tables_in_test from pg_tables where  schemaname ='public'");
        $info   =   array();
        foreach ($result as $key => $val) {
            $info[$key] = current($val);
        }
        return $info;
    }
    /**
     +----------------------------------------------------------
     * 关闭数据库
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    public function close() {
        if (!empty($this->queryID))
        pg_free_result($this->queryID);
        if($this->_linkID && !pg_close($this->_linkID)){
            throw_exception($this->error(false));
        }
        $this->_linkID = 0;
    }

    /**
     +----------------------------------------------------------
     * 数据库错误信息
     * 并显示当前的SQL语句
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    public function error($result = true) {
        if($result){
            $this->error = pg_result_error($this->queryID);
        }else{
            $this->error = pg_last_error($this->_linkID);
        }
        if($this->queryStr!=''){
            $this->error .= "\n [ SQL语句 ] : ".$this->queryStr;
        }
        return $this->error;
    }

    /**
     +----------------------------------------------------------
     * SQL指令安全过滤
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $str  SQL指令
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    public function escape_string($str) {
        return pg_escape_string($str);
    }

    /**
     +----------------------------------------------------------
     * limit
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function parseLimit($limit) {
        $limitStr    = '';
        if(!empty($limit)) {
            $limit  =   explode(',',$limit);
            if(count($limit)>1) {
                $limitStr .= ' LIMIT '.$limit[1].' OFFSET '.$limit[0].' ';
            }else{
                $limitStr .= ' LIMIT '.$limit[0].' ';
            }
        }
        return $limitStr;
    }

   /**
     +----------------------------------------------------------
     * 析构方法
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     */
    public function __destruct()
    {
        // 关闭连接
        $this->close();
    }
}//类定义结束
?>