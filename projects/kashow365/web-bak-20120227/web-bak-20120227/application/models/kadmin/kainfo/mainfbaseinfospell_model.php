<?php
class MainFBaseInfoSpell_model extends CI_Model {

	const tableName = 'TKWebBaseInfo';

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
    function GetEntityAll($where, $order)
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
    	$result = '1';
    	
    	// start trans
    	$this->db->trans_start();
    	
    	//if TKWebAnnouncement.state is 1 then set all TKWebAnnouncement's record  TKWebAnnouncement.state=0;
		if($entity['orderNum'] == '1')
		{
			$data = array(
               'orderNum' 		=> 0
            );
            $this->db->where('infoType', 'SpellInfoIndex');
            $this->db->update(self::tableName, $data); 
		}
    	// insert entity
    	$DBCommOper = new DBCommOper();    	
    	$DBCommOper->Insert(self::tableName, $entity);
		
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
     * Udpate
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function Update($entity)
    {
    	$result = '1';
    	$id = '';
    	if($entity==null) return;
    	 	
    	// start trans
    	$this->db->trans_start();
    	
    	//if TKWebAnnouncement.state is 1 then set all TKWebAnnouncement's record  TKWebAnnouncement.state=0;
		if($entity['orderNum'] == '1')
		{
			$data = array(
               'orderNum' 		=> 0
            );
            $this->db->where('infoType', 'SpellInfoIndex');
			$this->db->update(self::tableName, $data); 
		}
    	// update entity
    	$DBCommOper = new DBCommOper();    	
    	$DBCommOper->Update(self::tableName, $entity);
		
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
        
    //////////////////////////////////
	// 获取当前宣传言
    function GetEntityAnnount()
    {
    	$result = '';
    	$where = array('orderNum' => 1, 'infoType' => 'SpellInfoIndex');
    	$this->db->where($where);
    	$query = $this->db->get(self::tableName);
    	if ($query->num_rows() > 0)
    	{
	    	$row = $query->first_row('array');
    		
	    	$result = $row['value1'];
    	}
    	return $result;
    }
}
?>