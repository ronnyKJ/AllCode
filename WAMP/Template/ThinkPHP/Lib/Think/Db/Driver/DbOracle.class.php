<?php
// +----------------------------------------------------------------------
// | ThinkPHP
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: ZhangXuehun <zhangxuehun@sohu.com>
// +----------------------------------------------------------------------
// $Id: DbOracle.class.php,v 1.1 2008/12/23 10:06:30 wangyufeng Exp $

/**
+------------------------------------------------------------------------------
* Oracle数据库驱动类
+------------------------------------------------------------------------------
* @category   Think
* @package  Think
* @subpackage  Db
* @author    ZhangXuehun <zhangxuehun@sohu.com>
* @version   $Id: DbOracle.class.php,v 1.1 2008/12/23 10:06:30 wangyufeng Exp $
+------------------------------------------------------------------------------
*/
class DbOracle extends Db{

    private $mode = OCI_COMMIT_ON_SUCCESS;
    protected $selectSql  =     'SELECT * FROM (SELECT rownum AS numrow, thinkphp.* FROM (SELECT  %DISTINCT% %FIELDS% FROM %TABLE%%JOIN%%WHERE%%GROUP%%HAVING%%ORDER%) thinkphp ) WHERE %LIMIT%';
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
        putenv("NLS_LANG=AMERICAN_AMERICA.UTF8");
        if ( !extension_loaded('oci8') ) {
            throw_exception(L('_NOT_SUPPERT_').'oracle');
        }
        if(!empty($config)) {
            $this->config        =        $config;
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
            if(empty($config))  $config = $this->config;
            $conn = $this->pconnect ? 'oci_pconnect':'oci_new_connect';
            $this->linkID[$linkNum] = $conn($config['username'], $config['password'],
            "//{$config['hostname']}:{$config['hostport']}/{$config['database']}");//modify by wyfeng at 2008.12.19

            if (!$this->linkID[$linkNum]){
                $error = $this->error(false);
                throw_exception($error["message"], '', $error["code"]);
                return false;
            }
            // 标记连接成功
            $this->connected = true;
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
        @oci_free_statement($this->queryID);
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
        //更改事务模式
        $this->mode = OCI_COMMIT_ON_SUCCESS;
        //释放前次的查询结果
        if ( $this->queryID ) {    $this->free();    }
        $this->Q(1);
        $this->queryID = oci_parse($this->_linkID,$this->queryStr);
        $this->debug();
        if (!oci_execute($this->queryID, $this->mode)) {
		    if ( $this->debug)
                throw_exception($this->error());
            else
                return false;
        } else {

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
        //更改事务模式
        $this->mode = OCI_COMMIT_ON_SUCCESS;
        //释放前次的查询结果
        if ( $this->queryID ) {    $this->free();    }
        $this->W(1);
        $stmt = oci_parse($this->_linkID,$this->queryStr);
        $this->debug();
        if (!oci_execute($stmt)) {
            if ( $this->debug )
                throw_exception($this->error());
            else
                return false;
        } else {
            $this->numRows = oci_num_rows($stmt);
            $this->lastInsID = preg_match("/^\s*(INSERT\s+INTO|REPLACE\s+INTO)\s+/i", $this->queryStr)?$this->insert_last_id():0;//add by wyfeng at 2008.12.22
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
        //数据rollback 支持
        if ($this->transTimes == 0) {
                $this->mode = OCI_DEFAULT;
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
    public function commit(){
        if ($this->transTimes > 0) {
                $result = oci_commit($this->_linkID);
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
     public function rollback(){
        if ($this->transTimes > 0) {
            $result = oci_rollback($this->_linkID);
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
        $result = array();
        $this->numRows = oci_fetch_all($this->queryID, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);
		//add by wyfeng at 2008-12-23 强制将字段名转换为小写，以配合Model类函数如count等
		if(C("DB_CASE_LOWER"))
		{
			foreach($result as $k=>$v)
			{
				$result[$k] = array_change_key_case($result[$k], CASE_LOWER);
			}
		}
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
        $result = $this->_query("select a.column_name,data_type,decode(nullable,'Y',0,1) notnull,data_default,decode(a.column_name,b.column_name,1,0) pk "
                  ."from user_tab_columns a,(select column_name from user_constraints c,user_cons_columns col "
          ."where c.constraint_name=col.constraint_name and c.constraint_type='P'and c.table_name='".strtoupper($tableName)
          ."') b where table_name='".strtoupper($tableName)."' and a.column_name=b.column_name(+)");

        $info   =   array();
        foreach ($result as $key => $val) {
            $info[strtolower($val['column_name'])] = array(
                'name'    => strtolower($val['column_name']),
                'type'    => strtolower($val['data_type']),
                'notnull' => $val['notnull'],
                'default' => $val['data_default'],
                'primary' => $val['pk'],
                'autoinc' => $val['pk'],
            );
        }
        return $info;
    }

    /**
     +----------------------------------------------------------
     * 取得数据库的表信息（暂时实现取得用户表信息）
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    public function getTables($dbName='') {
        $result = $this->_query("select table_name from user_tables");
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
            oci_free_statement($this->queryID);
        if(!oci_close($this->_linkID)){
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
           $this->error = oci_error($this->queryID);
        }elseif(!$this->_linkID){
            $this->error = oci_error();
        }else{
            $this->error = oci_error($this->_linkID);
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
     * @param mix $str  SQL指令
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    public function escape_string($str) {
        return str_ireplace("'", "''", $str);//add by wyfeng at 2008.12.22
    }

	/**
     +----------------------------------------------------------
     * 获取最后插入id ,仅适用于采用序列+触发器结合生成ID的方式
	 * 在config.php中指定
 		'DB_TRIGGER_PREFIX'	=>	'tr_',
		'DB_SEQUENCE_PREFIX' =>	'ts_',
	 * eg:表 tb_user
	   相对tb_user的序列为：
	 	-- Create sequence
		create sequence TS_USER
		minvalue 1
		maxvalue 999999999999999999999999999
		start with 1
		increment by 1
		nocache;
	   相对tb_user,ts_user的触发器为：
		create or replace trigger TR_USER
		  before insert on "TB_USER"
		  for each row
		begin
			select "TS_USER".nextval into :NEW.ID from dual;
		end;
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $str  序列名称，默认为序列前缀+表名（无前缀）
     +----------------------------------------------------------
     * @return integer
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
	 */
 	//add by wyfeng at 2008.12.22
	public function insert_last_id()
	{
		if(empty($this->tableName))
		{
			return 0;
		}
		$sequenceName = C("DB_SEQUENCE_PREFIX") . $this->tableName;
		$vo = $this->_query("SELECT {$sequenceName}.currval currval FROM dual");
		return $vo?$vo[0]["currval"]:0;
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
			$limit	=	explode(',',$limit);
			if(count($limit)>1)
				$limitStr = "(numrow>" . $limit[0] . ") AND (numrow<=" . $limit[1] . ")";
			else
				$limitStr = "(numrow>0 AND numrow<=".$limit[0].")";
		}
		return $limitStr;
	}
}//类定义结束
?>