<?php
class MainFBaseInfo_model extends CI_Model {

	const tableName = 'TKWebBaseInfo';

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->load->helper('file');
        
        require_once 'application/models/kadmin/dbcommoper.php';
        require_once 'kadmin/businessentity/tools/file.class.php';
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
    function GetEntityByPage($where='', $order='orderNum DESC ' , $pageSize=1, $pageIndex=1)
    {
    	$DBCommOper = new DBCommOper();    	
    	return $DBCommOper->GetEntityByPage(self::tableName, $where, $order , $pageSize, $pageIndex);
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 获取全部记录，有条件有排序
     * 返回$result: 集合
     */
    function GetEntityAll($where='', $order='orderNum DESC ')
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
     * Udpate仅更新排序字段
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function UpdateByOrderNum($entity)
    {
    	$result = '1';
    	$id = '';
    	if($entity==null) return;

    	$where = array(
    		'id' => $entity['id']
    	);
    	
    	// update entity
    	$this->db->where($where);
    	
    	// 把不需要更新的字段删除
    	unset($entity['id']);
    	
		$this->db->update(self::tableName, $entity);

        return $result;
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 删除1个
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function Delete($id)
    {
    	if($id == '')
    	{
    		return null;
    	}
    	
    	$DBCommOper = new DBCommOper();
    	$entity = $this->GetEntityById($id);

    	$DBCommOper->Delete(self::tableName, $id);

		return '1';
    }
    
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 删除多个
     * 返回$result: 1 - 成功; 非1 - 出错提示
     */
    function Deletes($ids)
    {
    	$strIds = implode(',', $ids);   	
    	if($strIds != ''){$this->db->where_in('id', $strIds);}
   		$query = $this->db->get(self::tableName);
		
    	$DBCommOper = new DBCommOper();    	
    	$result = $DBCommOper->Deletes(self::tableName, $ids);
     	
    	return $result;
    }
    
    
    // 得到站点的统计数据
    function GetWebStatistics()
    {
    	#WebTotcalCZ - 储值卡数
		#WebTotcalJF - 积分卡数
		#WebTotcalHY - 会员卡数
		#WebTotcalTY - 体验卡数
		#WebTotcalTH - 提货卡数
		#WebTotcalUser - 网站会员数
		
    	$WebTotcal=array(
    		'WebTotcalCZ'	=> 0
    		,'WebTotcalJF'	=> 0
    		,'WebTotcalHY'	=> 0
    		,'WebTotcalTY'	=> 0
    		,'WebTotcalTH'	=> 0
    		,'WebTotcalUser'=> 0
    	);
		
	
		$this->db->like('infoType', 'WebTotcal', 'after'); 
        $query = $this->db->get(self::tableName);
    	if ($query->num_rows() > 0)
    	{
	    	foreach ($query->result() as $row)
			{
			   switch($row->infoType)
			   {
			   	case 'WebTotcalCZ':
			   		$WebTotcal['WebTotcalCZ'] = $row->count;
			   		break;
			   	case 'WebTotcalJF':
			   		$WebTotcal['WebTotcalJF'] = $row->count;
			   		break;
			   	case 'WebTotcalHY':
			   		$WebTotcal['WebTotcalHY'] = $row->count;
			   		break;
			   	case 'WebTotcalTY':
			   		$WebTotcal['WebTotcalTY'] = $row->count;
			   		break;
			   	case 'WebTotcalTH':
			   		$WebTotcal['WebTotcalTH'] = $row->count;
			   		break;
			   	case 'WebTotcalUser':
			   		$WebTotcal['WebTotcalUser'] = $row->count;
			   		break;
			   }
			}
    	} 
		return $WebTotcal;
    }
    
    
	// 得到站点某个统计数据
    function GetWebStatisticsByOne($infoType)
    {
    	#WebTotcalCZ - 储值卡数
		#WebTotcalJF - 积分卡数
		#WebTotcalHY - 会员卡数
		#WebTotcalTY - 体验卡数
		#WebTotcalTH - 提货卡数
		#WebTotcalUser - 网站会员数
		
    	$result = '';
		
	
		$this->db->where('infoType', $infoType); 
        $query = $this->db->get(self::tableName);
    	if ($query->num_rows() > 0)
    	{
    		$row = $query->first_row();
	    	$result = $row->count;
    	}
		return $result;
    }
}
?>