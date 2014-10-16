<?php
class MainFBaseInfoAd_model extends CI_Model {

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
    	
       	// DEL原图片
       	KXFile::DeleteFile($this->config->item('UpPathAD'), $entity['value1']);
		
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
    	if($result == '1')// DB deleted OK then delete files
    	{
    		foreach ($query->result() as $row)
			{
				KXFile::DeleteFile($this->config->item('UpPathAD'), $row->value1);
			}
    	}
    	
    	return $result;
    }
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 根据infoType得到一个广告位信息
     * 返回$result: 广告位信息
     */
 	function GetEntityByInfoType($infoType)
    {
    	if($infoType == '')
    	{
    		return null;
    	}
    	$this->load->database();
		$this->db->where('infoType', $infoType);
		$this->db->from(self::tableName);
		$query = $this->db->get();
		if ($query->num_rows() == 0)
		{
			return null;
		}
		$entity=$query->first_row('array');
		return $entity;
    }
}
?>