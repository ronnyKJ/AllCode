<?php
class DBCommOper extends CI_Model {

	private $tableName = '';
	
    function __construct()
    {
        parent::__construct();
        $this->load->database();
       
        $tableName = 'TKWebAnnouncement';
    }
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 根据ID得到数据实体
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function GetEntityById($tableName, $id, $primaryKey='id')
    {
    	if($id == '')
    	{
    		return null;
    	}
    	$this->load->database();
		$this->db->where($primaryKey, $id);
		$this->db->from($tableName);
		$query = $this->db->get();
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
    function GetEntityCount($tableName, $where)
    {
    	$result = 0;
    	if($where != '')
    	{
    		$this->db->where($where);
    	}
		$this->db->from($tableName);
		$result = $this->db->count_all_results();
		return $result;
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 按分页页码获取,符合条件的记录集合
     * 返回$result: 集合
     */
    function GetEntityByPage($tableName, $where, $order , $pageSize, $pageIndex)
    {
    	if($where != ''){$this->db->where($where);}
    	if($order != ''){$this->db->order_by($order);}
    	
    	$startNum = ((int)$pageIndex - 1) * (int)$pageSize;
		$result = $this->db->get($tableName, $pageSize, $startNum )->result('array');
		
		return $result;   	
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 获取全部记录，有条件有排序
     * 返回$result: 集合
     */
    function GetEntityAll($tableName, $where, $order)
    {
    	if($where != ''){$this->db->where($where);}
    	if($order != ''){$this->db->order_by($order);}
    	
		$result = $this->db->get($tableName)->result('array');
		
		return $result;   	
    }
    
    /* * * * * * * * * * * * * * * * * * * * * * * * *
     * Insert
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function Insert($tableName, $entity, $primaryKey='id')
    {
    	$result = '1';
    	// insert entity
    	unset($entity[$primaryKey]);
		$query = $this->db->insert($tableName, $entity); 
        return $result;
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Udpate
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function Update($tableName, $entity, $primaryKey='id')
    {
    	$result = '1';
    	$id = '';
    	if($entity==null) return;
    	    	
    	// update entity
    	$id = $entity[$primaryKey];
    	unset($entity[$primaryKey]);
    	$this->db->where($primaryKey,$id);
    	#var_dump($entity);
		$query = $this->db->update($tableName, $entity); 

        return $result;
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 删除1个
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function Delete($tableName, $id, $primaryKey='id')
    {
    	$result = '1';
    	if($id==null) return $result;
    	$this->db->where($primaryKey, $id);
		$this->db->delete($tableName); 
		
        return $result;
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 删除多个
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function Deletes($tableName, $ids, $primaryKey='id')
    {
    	$result = '1';
    	if($ids==null) return;
    	
    	// start trans
    	$this->db->trans_start();
    	
    	foreach($ids as $id)
    	{
	    	$this->db->where($primaryKey, $id);
			$this->db->delete($tableName); 
    	}
    	
		// do trans
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$result = '数据库执行有错'; 
		}
		else 
		{
			$this->db->trans_commit();
			$result = '1';
		} 
        return $result;
    }
}
?>