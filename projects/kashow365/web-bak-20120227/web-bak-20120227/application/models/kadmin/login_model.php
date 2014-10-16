<?php
class Login_model extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * 检查登录
     * 返回$result: 1 - 成功; 0 - 不存在; 2 - 密码不正确; 3 - 管理员无权限; 4-管理员禁止登录 
     */
    function CheckLogin($loginEntriy)
    {
    	$result = 1;
    	$this->load->database();
   	
    	$this->db->where('loginName', $loginEntriy['adm_name']);
		$query = $this->db->get('TAdministrator');
		
		if ($query->num_rows() == 0)
		{
			$result= 0;
		}
		else 
		{
			$row = $query->first_row(); 
			if(md5($loginEntriy['adm_password']) != $row->loginPassword)
			{
				$result= 2;
			}
			if($row->kState == '0')
			{
				$result= 4;
			}
		}  

		#$result = $row->loginPassword;
        return $result;
    }
    
    /*
     * 根据用户名和密码获取管理员
     * 返回$result: 管理员实体
     */
    function GetAdminEntriy($loginEntriy)
    {
    	$result = null;
    	
    	$this->load->database();
   	
    	#$this->db->select('loginPassword');
    	$this->db->where('loginName', $loginEntriy['adm_name']);
    	$this->db->where('loginPassword', md5($loginEntriy['adm_password']));
		$query = $this->db->get('TAdministrator');
		
		if ($query->num_rows() == 1)
		{
			$result = $query->first_row('array'); 
		}

		#var_dump($query->num_rows());

        return $result;
    }

}
    
?>