<?php
class TKUserFriends_model extends CI_Model {

	const tableName = 'TKUserFriends';

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
    	return $DBCommOper->GetEntityCount('View_TKUserFriends', $where);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 按分页页码获取,符合条件的记录集合
     * 返回$result: 集合
     */
    function GetEntityByPage($where='', $order='id DESC ' , $pageSize=1, $pageIndex=1)
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityByPage('View_TKUserFriends', $where, $order , $pageSize, $pageIndex);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 获取全部记录，有条件有排序
     * 返回$result: 集合
     */
    function GetEntityAll($where, $order)
    {
		$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityAll('View_TKUserFriends', $where, $order);
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
    
    
    //////////////////////////////////////////////////////
    // 得到某会员的全部好友
    function GetEntityByPageFriendId($userId, $pageSize, $pageIndex)
    {
    	$where = array(
    		'userId' => $userId
    		,'friendkState !=' => 2 
    	);
    	$order = 'addDateTime DESC';
    	
		$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityByPage('View_TKUserFriends', $where, $order , $pageSize, $pageIndex);

    }
    
	//////////////////////////////////////////////////////
    // 得到某会员的关注的全部好友
    function GetEntityByPageMyFriendId($userId, $pageSize, $pageIndex)
    {
    	$where = array(
    		'friendUserId' => $userId
    		,'kState != ' => 2 
    	);
    	$order = 'addDateTime DESC';
    	
		$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityByPage('View_TKUserFriends', $where, $order , $pageSize, $pageIndex);

    }
    
    /* * * * * * * * * * * * * * * * * * * * * * * * *
     * 添加关注操作
     * 返回$result: 1 - 成功; 0 - 出错提示
     */
    function DoAddUserFriend($entity)
    {
    	$this->db->query('CALL `ProAddUserFriend` ('
    		.'\''.$entity['userId'].'\', '
	    	.'\''.$entity['friendUserId'].'\', '
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];  	
    	return $result;
    }
    
     /* * * * * * * * * * * * * * * * * * * * * * * * *
     * 检查是否是好友
     * 返回$result: 1 - 成功; 0 - 不是
     */
    function CheckIsMyFriend($myUserId,$friendUserId)
    {
    	$result = false;
    	$where = array('userId' => $myUserId, 'friendUserId' => $friendUserId);
    	if($this->GetEntityCount($where)>0)
    	{
    		$result = true;
    	}
    	return $result;
    	
    }
    
}
?>