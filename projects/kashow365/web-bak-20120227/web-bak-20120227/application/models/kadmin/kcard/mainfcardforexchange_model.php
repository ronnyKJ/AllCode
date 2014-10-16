<?php
class MainfCardForExchange_model extends CI_Model {

	const tableName = 'TKCardForExchange';

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
    	return $DBCommOper->GetEntityById('View_TKCardForExchange', $id);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 得到符合条件的全部记录数
     * 返回$result: 集合个数
     */
    function GetEntityCount($where='')
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityCount('View_TKCardForExchange', $where);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 按分页页码获取,符合条件的记录集合
     * 返回$result: 集合
     */
    function GetEntityByPage($where='', $order='changeDateTime DESC ' , $pageSize=1, $pageIndex=1)
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityByPage('View_TKCardForExchange', $where, $order , $pageSize, $pageIndex);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 获取全部记录，有条件有排序
     * 返回$result: 集合
     */
    function GetEntityAll($where, $order)
    {
		$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityAll('View_TKCardForExchange', $where, $order);
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
		$result = 0;
    	
		// start trans
    	$this->db->trans_start();
    	
		// update entity
    	$DBCommOper = new DBCommOper();
    	
    	$CardIndexEntity['id'] 		= $entity['id'];
    	$CardIndexEntity['name'] 	= $entity['name'];    	
    	$result = $DBCommOper->Update('TKCardIndex', $CardIndexEntity);
			
    	$CardForExchange['id'] 					= $entity['id'];
    	$CardForExchange['cardType'] 			= $entity['cardType'];
    	$CardForExchange['cardUse'] 			= $entity['cardUse'];
    	$CardForExchange['cardTtransactions'] 	= $entity['cardTtransactions'];
    	$CardForExchange['areaDistrictId'] 		= $entity['districtId'];
    	$CardForExchange['areaUrbanId'] 		= $entity['urbanId'];
    	$CardForExchange['period'] 				= $entity['period'];
    	$CardForExchange['exchangPoint'] 		= $entity['exchangPoint'];
    	$CardForExchange['surplusCount'] 		= $entity['surplusCount'];
    	$CardForExchange['state'] 				= $entity['state'];
    	$CardForExchange['remarks'] 			= $entity['remarks'];
    	$CardForExchange['orderNum'] 			= $entity['orderNum'];
    	$CardForExchange['isSponsors'] 			= $entity['isSponsors'];
    	$CardForExchange['cardImagePath'] 		= $entity['cardImagePath'];
    	$result = $DBCommOper->Update('TKCardForExchange', $CardForExchange);
    	
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
    	$result = 0;
    	if($id == '')
    	{
    		return $result;
    	}
    	
    	// start trans
    	$this->db->trans_start();
    	
    	$DBCommOper = new DBCommOper();
    	$entity = $this->GetEntityById($id);

    	$this->db->where('cardId', $id);
		$this->db->delete('TKCardExchLog'); 
    	$result = $DBCommOper->Delete('TKCardForExchange', $id);
    	$result = $DBCommOper->Delete('TKCardIndex', $id);
    	
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
        
       	// DEL原图片
       	KXFile::DeleteFile($this->config->item('UpPathCard').'s1/', $entity['cardImagePath']);
       	KXFile::DeleteFile($this->config->item('UpPathCard').'s2/', $entity['cardImagePath']);
		
    	return $result;
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 删除多个
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function Deletes($ids)
    {
    	$result = '1';
    	if($ids==null) return;
    	
    	// start trans
    	$this->db->trans_start();
    	
    	foreach($ids as $id)
    	{
	    	$this->Delete($id);
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
    
    
 	/* * * * * * * * * * * * * * * * * * * * * * * * *
     * 添加兑换卡
     * 返回$result: 非空为新卡ID - 成功; 0 - 出错提示
     */
    function DoAddCardForExchange($entity)
    {
    	$this->db->query('CALL `ProAddCardForExchange` ('
 	    	.'\''.$entity['name'].'\', '
	    	.'\''.$entity['userId'].'\', '
	    	.'\''.$entity['cardType'].'\', '
	    	.'\''.$entity['cardUse'].'\', '
	    	.'\''.$entity['cardTtransactions'].'\', '
	    	.'\''.$entity['districtId'].'\', '
	    	.'\''.$entity['urbanId'].'\', '
	    	.'\''.$entity['period'].'\', '
	    	.'\''.$entity['exchangPoint'].'\', '
	    	.'\''.$entity['surplusCount'].'\', '
	    	.'\''.$entity['state'].'\', '
	    	.'\''.$entity['remarks'].'\', '
	    	.'\''.$entity['orderNum'].'\', '
	    	.'\''.$entity['isSponsors'].'\', '
	    	.'\''.$entity['cardImagePath'].'\', '
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];  	
    	return $result;
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * *
     * 操作兑换卡
     * 返回$result: 非空为新卡ID - 成功; 0 - 出错提示
     */
    function DoUserExchange($entity, $kPoints=0)
    {
    	$this->db->query('CALL `ProUserExchange` ('
	    	.'\''.$entity['userId'].'\', '
	    	.'\''.$entity['cardId'].'\', '
	    	.'@result'
	    	.',@kPoints); '
    	);
    	
    	$query = $this->db->query('select @result, @kPoints;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];
    	#$kPoints = $query['@kPoints'];
    	return $result;
    }

}
?>