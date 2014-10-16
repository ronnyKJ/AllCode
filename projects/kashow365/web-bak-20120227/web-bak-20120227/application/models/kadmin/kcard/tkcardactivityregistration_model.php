<?php
class TKCardActivityRegistration_model extends CI_Model {

	const tableName = 'TKCardActivityRegistration';

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
    	return $DBCommOper->GetEntityCount('View_TKCardActivityRegistration', $where);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 按分页页码获取,符合条件的记录集合
     * 返回$result: 集合
     */
    function GetEntityByPage($where='', $order='changeDateTime DESC ' , $pageSize=1, $pageIndex=1)
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityByPage('View_TKCardActivityRegistration', $where, $order , $pageSize, $pageIndex);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 获取全部记录，有条件有排序
     * 返回$result: 集合
     */
    function GetEntityAll($where, $order)
    {
		$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityAll('View_TKCardActivityRegistration', $where, $order);
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
    		$this->db->set('kState', $state);
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
     * 添加报名
     * 返回$result: 非空为新卡ID - 成功; 0 - 出错提示
     */
    function DoAddCardActivityRegistration($entity)
    {
    	$this->db->query('CALL `ProAddCardActivityRegistration` ('
 	    	.'\''.$entity['cardId'].'\', '
	    	.'\''.$entity['regUserId'].'\', '
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];  	
    	return $result;
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * *
     * 添加退出报名
     * 返回$result: 非空为新卡ID - 成功; 0 - 出错提示
     */
    function DoExitCardActivityRegistration($entity)
    {
    	$this->db->query('CALL `ProExitCardActivityRegistration` ('
 	    	.'\''.$entity['cardId'].'\', '
	    	.'\''.$entity['regUserId'].'\', '
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];  	
    	return $result;
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * *
     * 添加分享给全部好友
     * 返回$result: 非空为新卡ID - 成功; 0 - 出错提示
     */
    function DoSendFriendsCardActivity($entity)
    {
    	$this->db->query('CALL `ProSendFriendsCardActivity` ('
 	    	.'\''.$entity['cardId'].'\', '
	    	.'\''.$entity['loginUserId'].'\', '
	    	.'\''.$entity['content'].'\', '
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];  	
    	return $result;
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * *
     * 添加分享给全部好友
     * 返回$result: 非空为新卡ID - 成功; 0 - 出错提示
     */
    function DoSendFriendCardActivity($entity)
    {
    	$this->db->query('CALL `ProSendFriendCardActivity` ('
 	    	.'\''.$entity['cardId'].'\', '
	    	.'\''.$entity['loginUserId'].'\', '
	    	.'\''.$entity['content'].'\', '
	    	.'\''.$entity['friendUserIds'].'\', '
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];  	
    	return $result;
    }
    
    
}
?>