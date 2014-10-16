<?php
class MainFBlogMessages_model extends CI_Model {

	const tableName = 'TKUserBlogMessages';

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
     * 按分页页码获取,符合条件的记录集合
     * 返回$result: 集合
     */
    function GetEntityViewByPage($where='', $order='id DESC ' , $pageSize=1, $pageIndex=1)
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityByPage('View_TKUserBlogMessages', $where, $order , $pageSize, $pageIndex);
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
     * 批量审核
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function UpdateStates($ids, $state)
    {
    	$result = '1';
    	if($ids==null) return;
    	
    	// start trans
    	$this->db->trans_start();
    	
    	foreach($ids as $id)
    	{
    		$this->db->set('state', $state);
	    	$this->db->where('id', $id);
			$this->db->update(self::tableName); 
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
    
    /* * * * * * * * * * * * * * * * * * * * * * * * *
     * 添加微博
     * 返回$result: 1 - 成功; 0 - 出错提示
     */
    function DoAddUserBlogMessages($entity)
    {
    	$this->db->query('CALL `ProAdUserBlogMessages` ('
    		.'\''.$entity['userId'].'\', '
	    	.'\''.$entity['content'].'\', '
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];  	
    	return $result;
    }
    
 	/* * * * * * * * * * * * * * * * * * * * * * * * *
     * 微博人数
     * 返回$result: 发微博人数
     */
    function GetEntityCountByUsers($where='')
    {
    	$result = 0;
    	if($where != '')
    	{
    		$this->db->where($where);
    	}
		$this->db->from(self::tableName);
		$this->db->group_by('userId');
		$result = $this->db->count_all_results();
		return $result;
    }
}
?>