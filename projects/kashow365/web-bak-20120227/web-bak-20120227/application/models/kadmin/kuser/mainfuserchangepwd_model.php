<?php
class MainFUserChangePwd_model extends CI_Model {

	const tableName = 'TKUserChangePwd';

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
    
	function GetEntityByIdForView($id)
    {
		$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityById('View_User', $id);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 得到符合条件的全部记录数
     * 返回$result: 集合个数
     */
    public function GetEntityCount($where='')
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityCount('View_User', $where);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 按分页页码获取,符合条件的记录集合
     * 返回$result: 集合
     */
    function GetEntityByPage($where='', $order='id DESC ' , $pageSize=1, $pageIndex=1)
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityByPage('View_User', $where, $order , $pageSize, $pageIndex);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 按分页页码获取,符合条件的记录集合
     * 返回$result: 集合
     */
    function GetEntityAll($where='', $order='id DESC ')
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityAll('View_User', $where, $order);
    }
    
    /* * * * * * * * * * * * * * * * * * * * * * * * *
     * Insert
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function Insert($entity)
    {
    	// insert entity
    	$DBCommOper = new DBCommOper();    	
    	$DBCommOper->Insert(self::tableName, $entity);
    	
    	$query = $this->db->query('select @@IDENTITY;')->first_row('array');
    	$result = $query['@@IDENTITY'];
    	#var_dump($result);
    	return $result;
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

     /* * * * * * * * * * * * * * * * * * * * * * * * *
     * 会员验证操作
     * 返回$result: 1 - 成功; 0 - 出错提示
     */
    function DoVerifyUserInfo($entity)
    {
    	$result = 1;
    	$this->load->database();
		$this->db->where('id', $entity['userChangePwdId']);
		$this->db->where('verifyEncode', $entity['verifyEncode']);
		$this->db->where('state', 1);
		$this->db->from(self::tableName);
		$query = $this->db->get();
		if ($query->num_rows() == 0)
		{
			$result = 0;
			return $result;
		}
		$entity=$query->first_row('array');
		return $entity;
    }
    

}
?>