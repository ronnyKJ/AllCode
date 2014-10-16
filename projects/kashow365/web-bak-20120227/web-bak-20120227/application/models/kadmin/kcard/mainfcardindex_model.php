<?php
class MainFCardIndex_model extends CI_Model {

	const tableName = 'TKCardIndex';

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
    
	function GetEntityByIdForView($id,$cardView)
    {
		$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityById($cardView, $id);
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
    
    
    ////////////////////////////////////////////////////////////////////
    // 买卖卡
    
    /* * * * * * * * * * * * * * * * * * * * * * * * *
     * 添加买卖卡
     * 返回$result: 非空为新卡ID - 成功; 0 - 出错提示
     */
    function DoAddCardForSale($entity)
    {
    	$this->db->query('CALL `ProAddCardForSale` ('
    		.'\''.$entity['name'].'\', '
	    	.'\''.$entity['userId'].'\', '
	    	.'\''.$entity['operatorFrom'].'\', '
	    	.'\''.$entity['cardType'].'\', '
	    	.'\''.$entity['cardUse'].'\', '
	    	.'\''.$entity['cardTtransactions'].'\', '
	    	.'\''.$entity['areaDistrictId'].'\', '
	    	.'\''.$entity['areaUrbanId'].'\', '
	    	.'\''.$entity['period'].'\', '
	    	.'\''.$entity['wayFight'].'\', '
	    	.'\''.$entity['remarks'].'\', '
	    	.'\''.$entity['cardImagePath'].'\', '
	    	.'\''.$entity['price'].'\', '
	    	.'\''.$entity['sellingPrice'].'\', '
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];  	
    	return $result;
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 根据ID得到数据实体
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function GetCardIndexById($id)
    {
		$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityById('TKCardIndex', $id);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 根据ID得到数据实体
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function GetCardForSaleById($id)
    {
		$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityById('TKCardForSale', $id);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * *
     * 添加买卖卡
     * 返回$result: 1 - 成功; 0 - 出错提示
     */
    function DoUpdateCardForSale($entity)
    {
    	$result = 0;
    	
		// update entity
    	$DBCommOper = new DBCommOper();
    	
    	$CardIndexEntity['id'] 		= $entity['id'];
    	$CardIndexEntity['name'] 	= $entity['name'];    	
    	$result = $DBCommOper->Update('TKCardIndex', $CardIndexEntity);

    	$CardForSaleEntity['id'] 				= $entity['id'];
    	$CardForSaleEntity['cardType'] 			= $entity['cardType'];
    	$CardForSaleEntity['cardUse'] 			= $entity['cardUse'];
    	$CardForSaleEntity['cardTtransactions'] = $entity['cardTtransactions'];
    	$CardForSaleEntity['areaDistrictId'] 	= $entity['areaDistrictId'];
    	$CardForSaleEntity['areaUrbanId'] 		= $entity['areaUrbanId'];
    	$CardForSaleEntity['period'] 			= $entity['period'];
    	$CardForSaleEntity['wayFight'] 			= $entity['wayFight'];
    	$CardForSaleEntity['remarks'] 			= $entity['remarks'];
    	$CardForSaleEntity['cardImagePath'] 	= $entity['cardImagePath'];
    	$CardForSaleEntity['price'] 			= $entity['price'];
    	$CardForSaleEntity['sellingPrice'] 		= $entity['sellingPrice'];
    	$result = $DBCommOper->Update('TKCardForSale', $CardForSaleEntity);
 	
    	return $result;
    }
    
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 得到符合条件的全部记录数
     * 返回$result: 集合个数
     */
    function GetEntityCountForSale($where='')
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityCount('View_TKCardForSale', $where);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 按分页页码获取,符合条件的记录集合
     * 返回$result: 集合
     */
    function GetEntityByPageForSale($where='', $order='id DESC ' , $pageSize=1, $pageIndex=1)
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityByPage('View_TKCardForSale', $where, $order , $pageSize, $pageIndex);
    }
    
 	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 根据ID得到数据实体
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function GetEntityForSaleById($id)
    {
		$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityById('View_TKCardForSale', $id);
    }
    
    /* * * * * * * * * * * * * * * * * * * * * * * * *
     * 删除买卖卡
     * 返回$result: 1 - 成功; 0 - 出错提示
     */
    function DoDelCardForSale($cid,$loginUserId)
    {
    	$this->db->query('CALL `ProDelCardForSale` ('
 	    	.'\''.$cid.'\', '
 	    	.'\''.$loginUserId.'\', '
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];  	
    	return $result;
    }
    
    
    ///////////////////////////////////////////////////////////////
    
    
	////////////////////////////////////////////////////////////////////
    // 展示卡
    
    /* * * * * * * * * * * * * * * * * * * * * * * * *
     * 添加展示卡
     * 返回$result: 非空为新卡ID - 成功; 0 - 出错提示
     */
    function DoAddCardForShow($entity)
    {
    	$this->db->query('CALL `ProAddCardForShow` ('
    		.'\''.$entity['name'].'\', '
	    	.'\''.$entity['userId'].'\', '
	    	.'\''.$entity['operatorFrom'].'\', '
	    	.'\''.$entity['cardType'].'\', '
	    	.'\''.$entity['cardUse'].'\', '
	    	.'\''.$entity['cardTtransactions'].'\', '
	    	.'\''.$entity['areaDistrictId'].'\', '
	    	.'\''.$entity['areaUrbanId'].'\', '
	    	.'\''.$entity['period'].'\', '
	    	.'\''.$entity['wayFight'].'\', '
	    	.'\''.$entity['remarks'].'\', '
	    	.'\''.$entity['cardImagePath'].'\', '
	    	.'\''.$entity['price'].'\', '
	    	.'\''.$entity['sellingPrice'].'\', '
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];  	
    	return $result;
    }
        
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 根据ID得到数据实体
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function GetCardForShowById($id)
    {
		$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityById('TKCardForShow', $id);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * *
     * 添回展示卡
     * 返回$result: 1 - 成功; 0 - 出错提示
     */
    function DoUpdateCardForShow($entity)
    {
    	$result = 0;
    	
		// update entity
    	$DBCommOper = new DBCommOper();
    	
    	$CardIndexEntity['id'] 		= $entity['id'];
    	$CardIndexEntity['name'] 	= $entity['name'];    	
    	$result = $DBCommOper->Update('TKCardIndex', $CardIndexEntity);

    	$CardForSaleEntity['id'] 				= $entity['id'];
    	$CardForSaleEntity['cardType'] 			= $entity['cardType'];
    	$CardForSaleEntity['cardUse'] 			= $entity['cardUse'];
    	$CardForSaleEntity['cardTtransactions'] = $entity['cardTtransactions'];
    	$CardForSaleEntity['areaDistrictId'] 	= $entity['areaDistrictId'];
    	$CardForSaleEntity['areaUrbanId'] 		= $entity['areaUrbanId'];
    	$CardForSaleEntity['period'] 			= $entity['period'];
    	$CardForSaleEntity['wayFight'] 			= $entity['wayFight'];
    	$CardForSaleEntity['remarks'] 			= $entity['remarks'];
    	$CardForSaleEntity['cardImagePath'] 	= $entity['cardImagePath'];
    	$CardForSaleEntity['price'] 			= $entity['price'];
    	$CardForSaleEntity['sellingPrice'] 		= $entity['sellingPrice'];
    	$result = $DBCommOper->Update('TKCardForShow', $CardForSaleEntity);
 	
    	return $result;
    }
    
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 得到符合条件的全部记录数
     * 返回$result: 集合个数
     */
    function GetEntityCountForShow($where='')
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityCount('View_TKCardForShow', $where);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 按分页页码获取,符合条件的记录集合
     * 返回$result: 集合
     */
    function GetEntityByPageForShow($where='', $order='id DESC ' , $pageSize=1, $pageIndex=1)
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityByPage('View_TKCardForShow', $where, $order , $pageSize, $pageIndex);
    }
    
 	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 根据ID得到数据实体
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function GetEntityForShowById($id)
    {
		$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityById('View_TKCardForShow', $id);
    }
    

	/* * * * * * * * * * * * * * * * * * * * * * * * *
     * 删除展示卡
     * 返回$result: 1 - 成功; 0 - 出错提示
     */
    function DoDelCardForShow($cid,$loginUserId)
    {
    	$this->db->query('CALL `ProDelCardForShow` ('
 	    	.'\''.$cid.'\', '
 	    	.'\''.$loginUserId.'\', '
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];  	
    	return $result;
    }
    
    ///////////////////////////////////////////////////////////////
    
    
    
    
    
    ////////////////////////////////////////////////////////////////////
    // 活动卡
    
    /* * * * * * * * * * * * * * * * * * * * * * * * *
     * 添加展示卡
     * 返回$result: 非空为新卡ID - 成功; 0 - 出错提示
     */
    function DoAddCardForActivity($entity)
    {
    	$this->db->query('CALL `ProAddCardForActivity` ('
 	    	.'\''.$entity['userId'].'\', '
	    	.'\''.$entity['operatorFrom'].'\', '
	    	.'\''.$entity['name'].'\', '
	    	.'\''.$entity['matter'].'\', '
	    	.'\''.$entity['characteristic'].'\', '
	    	.'\''.$entity['detail'].'\', '
	    	.'\''.$entity['tel'].'\', '
	    	.'\''.$entity['QQ'].'\', '
	    	.'\''.$entity['cardImagePath'].'\', '
	    	.'\''.$entity['startDate'].'\', '
	    	.'\''.$entity['endDate'].'\', '
	    	.'\''.$entity['limitUser'].'\', '
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];  	
    	return $result;
    }
        
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 根据ID得到数据实体
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function GetCardForActivityById($id)
    {
		$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityById('View_TKCardForActivity', $id);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * *
     * 添回展示卡
     * 返回$result: 1 - 成功; 0 - 出错提示
     */
    function DoUpdateCardForActivity($entity)
    {
    	$result = 0;
    	
		// update entity
    	$DBCommOper = new DBCommOper();
    	
    	$CardIndexEntity['id'] 		= $entity['id'];
    	$CardIndexEntity['name'] 	= $entity['name'];    	
    	$result = $DBCommOper->Update('TKCardIndex', $CardIndexEntity);
    	
    	$CardForSaleEntity['id'] 				= $entity['id'];
    	$CardForSaleEntity['matter'] 			= $entity['matter'];
    	$CardForSaleEntity['characteristic'] 	= $entity['characteristic'];
    	$CardForSaleEntity['detail'] 			= $entity['detail'];
    	$CardForSaleEntity['tel'] 				= $entity['tel'];
    	$CardForSaleEntity['QQ'] 				= $entity['QQ'];
    	$CardForSaleEntity['cardImagePath'] 	= $entity['cardImagePath'];
    	$CardForSaleEntity['startDate'] 		= $entity['startDate'];
    	$CardForSaleEntity['endDate'] 			= $entity['endDate'];
    	$CardForSaleEntity['limitUser'] 		= $entity['limitUser'];
    	$result = $DBCommOper->Update('TKCardForActivity', $CardForSaleEntity);
 	
    	return $result;
    }
    
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 得到符合条件的全部记录数
     * 返回$result: 集合个数
     */
    function GetEntityCountForActivity($where='')
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityCount('View_TKCardForActivity', $where);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 按分页页码获取,符合条件的记录集合
     * 返回$result: 集合
     */
    function GetEntityByPageForActivity($where='', $order='id DESC ' , $pageSize=1, $pageIndex=1)
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityByPage('View_TKCardForActivity', $where, $order , $pageSize, $pageIndex);
    }
    
 	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 根据ID得到数据实体
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function GetEntityForActivityById($id)
    {
		$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityById('View_TKCardForActivity', $id);
    }

	/* * * * * * * * * * * * * * * * * * * * * * * * *
     * 结束拼卡活动
     * 返回$result: 1 - 成功; 0 - 出错提示
     */
    function DoCloseCardForActivity($cid)
    {
    	$this->db->query('CALL `ProCloseCardForActivity` ('
 	    	.'\''.$cid.'\', '
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];  	
    	return $result;
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * *
     * 删除拼卡活动
     * 返回$result: 1 - 成功; 0 - 出错提示
     */
    function DoDelCardForActivity($cid,$loginUserId)
    {
    	$this->db->query('CALL `ProDelCardForActivity` ('
 	    	.'\''.$cid.'\', '
 	    	.'\''.$loginUserId.'\', '
	    	.'@result); '
    	);
    	
    	$query = $this->db->query('select @result;')->first_row('array');
    	#var_dump($query);
    	$result = $query['@result'];  	
    	return $result;
    }
    
    ///////////////////////////////////////////////////////////////
    
}
?>