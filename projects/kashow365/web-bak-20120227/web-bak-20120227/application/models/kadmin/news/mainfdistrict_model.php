<?php
class MainFdistrict_model extends CI_Model {

	const tableName = 'TKAreaDistrict';

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
     * 根据你ID得到父实体
     * 返回$result: 父实体
     */
	function GetDistrictEntityById($urbanId)
    {
    	if($urbanId == '')
    	{
    		return null;
    	}
    	$this->load->database();
		$query = $this->db->query('select * from `TKAreaDistrict` where `id` = (select `parentId` from `TKAreaUrban` where `id`='.$urbanId.') ');
		if ($query->num_rows() == 0)
		{
			return null;
		}
		$entity=$query->first_row('array');
		return $entity;   
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 得到符合条件的全部记录数
     * 返回$result: 集合个数
     */
    function GetEntityCount($where)
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityCount(self::tableName, $where);
    }
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 获取全部记录，有条件有排序
     * 返回$result: 集合
     */
    function GetEntityAll($where='', $order='orderNum` DESC')
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityAll(self::tableName, $where, $order);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 按分页页码获取,符合条件的记录集合
     * 返回$result: 集合
     */
    function GetEntityByPage($where='', $order='orderNum` DESC' , $pageSize=1, $pageIndex=1)
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityByPage(self::tableName, $where, $order , $pageSize, $pageIndex);
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