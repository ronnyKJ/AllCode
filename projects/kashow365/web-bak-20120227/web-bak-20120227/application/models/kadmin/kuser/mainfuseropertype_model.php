<?php
class MainFUserOperType_model extends CI_Model {

	const tableName = 'TKUserOperType';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        require_once 'application/models/kadmin/dbcommoper.php';
    }
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 根据ID得到数据实体
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function GetEntityById($id)
    {
		$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityById(self::tableName, $id);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 得到符合条件的全部记录数
     * 返回$result: 集合个数
     */
    function GetEntityCount($where='')
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityCount(self::tableName, $where);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 按分页页码获取,符合条件的记录集合
     * 返回$result: 集合
     */
    function GetEntityByPage($where='', $order='id DESC ' , $pageSize=1, $pageIndex=1)
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityByPage(self::tableName, $where, $order , $pageSize, $pageIndex);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 获取全部记录，有条件有排序
     * 返回$result: 集合
     */
    function GetEntityAll($where='', $order='gradeId ASC,operType ASC')
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityAll(self::tableName, $where, $order);
    }
    
    /* * * * * * * * * * * * * * * * * * * * * * * * *
     * Insert
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function Insert($entity)
    {
    	// insert entity
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->Insert(self::tableName, $entity);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Udpate
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function Update($entity)
    {
    	// update entity
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->Update(self::tableName, $entity);
    }
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Udpate根据等级和操作类型更新积分
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function UpdateByGidOperType($entity)
    {
    	$result = '1';
    	$id = '';
    	if($entity==null) return;

    	$where = array(
    		'gradeId' => $entity['gradeId']
    		, 'operType' => $entity['operType']
    	);
    	
    	// 判断是否有记录
    	if($this->GetEntityCount($where)==0) // insert 
    	{	
    		// 把不需要更新的字段删除
	    	unset($entity['updateDateTime']);
    		$query = $this->Insert($entity);
    	}
    	else // update
    	{
	    	// update entity
	    	$this->db->where($where);
	    	// 把不需要更新的字段删除
	    	unset($entity['gradeId']);
	    	unset($entity['operType']);
			$query = $this->db->update(self::tableName, $entity);
    	} 

        return $result;
    }
     
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 删除1个
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function Delete($id)
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->Delete(self::tableName, $id);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 删除多个
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function Deletes($ids)
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->Deletes(self::tableName, $ids);
    }
}
?>