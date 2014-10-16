<?php
class MainFAdminInfo_model extends CI_Model {

	const tableName = 'TAdministrator';

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
    function GetEntityAll($where='', $order='id DESC ')
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
    
 	/* * * * * * * * * * * * * * * * * * * * * * * * *
     * 新会员注册
     * 返回$result: 0 - 出错成功; 非0 - 会员userId主键
     */
    function DoProAddUserInfo($entity)
    {
    	$this->db->query('CALL `ProAddUserInfo` ('
    		.'\''.$entity['kLoginName'].'\', '
	    	.'\''.$entity['kPWD'].'\', '
	    	.'\''.$entity['kMail'].'\', '
	    	.'\''.$entity['kTel'].'\', '
	    	.'\''.$entity['reUserLoginName'].'\', '
	    	.'\''.$entity['verifyEncode'].'\', '
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	$result = $query['@result'];  	
    	return $result;
    }
       
    /* * * * * * * * * * * * * * * * * * * * * * * * *
     * 会员验证操作
     * 返回$result: 1 - 成功; 0 - 出错提示
     */
    function DoVerifyUserInfo($entity)
    {
    	$this->db->query('CALL `ProVerifyUserInfo` ('
    		.'\''.$entity['userId'].'\', '
	    	.'\''.$entity['verifyEncode'].'\', '
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];  	
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
    
    //////////////////////////////////////
    // 传入用户名和密码，判断是否存在
    // 返回： 
    //		0 - 该卡秀会员不存在
    // 	   -1 - 密码输入不正确
    //	   -2 - 帐号已锁定不能登录
    // userId - 完全正确,返回会员id
    function CheckUserLogin($kMail, $kPWD)
    {
    	$result = 1;
    	$this->load->database();
		$this->db->where('kMail', $kMail);
		$this->db->from(self::tableName);
		$query = $this->db->get();
		if ($query->num_rows() == 0)
		{
			$result = 0;
			return $result;
		}
		$entity=$query->first_row('array');
		$kPWD = md5($kPWD);
		if($kPWD != $entity['kPWD'] )
		{
			$result = -1;
			return $result;
		}
		if( $entity['kState'] == '2')
		{
			$result = -2;
			return $result;
		}
		
		// 更新登录时间
		$this->UpdateLoginDateTime($entity['id']);
		
		return $entity['id'];     	
    }
    
    // 更新会员头像
    function UpdateAvatarImage($entity)
    {
      	$this->db->set('kAvatarImage', $entity['kAvatarImage']);
    	$this->db->where('id', $entity['userId']);
		$this->db->update(self::tableName); 
		
		$this->db->query('CALL `ProAddUserNews` ('
 	    	.'\''.$entity['userId'].'\', '
 	    	.'6, null, null, null,'
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];  	
    	return $result;
    }
    
	// 更新会员登录时间
    function UpdateLoginDateTime($userId)
    {
    	$nowTime=date("Y-m-d H:i:s");
      	$this->db->set('loginDateTime', $nowTime);
    	$this->db->where('id', $userId);
		$this->db->update(self::tableName); 
    }

	//////////////////////////////////////
    // 传入用户名
    // 返回： 
    //		0 - 该卡秀会员不存在
    // user - 完全正确,返回会员信息
    function GetUserByMail($kMail)
    {
    	$result = 1;
    	$this->load->database();
		$this->db->where('kMail', $kMail);
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