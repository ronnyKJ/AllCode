<?php
class EventAction extends Action{
	//判断登陆
	public function loginElse()
	{
		if(!Session::is_set('username') || Session::get('loginStatus')==0)
		{
			$this->redirect('Index/index');
		}		
	}
	//登出
	public function logout(){
		Session::set('loginStatus', 0);
		$this->redirect('Index/index');
	}
	
	// 首页
	public function index(){
		$this->loginElse();
		$Userevent	= M("Userevent");
		$uid = Session::get('userid');
		$this->assign('username', Session::get('username'));
		$this->assign('userid', $uid);
		//查分类表think_category
		$cate = $Userevent->query('SELECT cid, categoryname, count FROM think_category WHERE uid="'.$uid.'"');
		$this->assign('cate',$cate);
		$this->assign('cate',$cate);
		//查事件及内容think_attribute_content
		$A_ct = M("Attribute_content");
		$list = $A_ct->query( 'SELECT * FROM think_attribute_content
								LEFT JOIN think_userevent ON think_attribute_content.eventid = think_userevent.id
								LEFT JOIN think_category ON think_userevent.categoryid = think_category.cid 
								WHERE think_category.uid ='.$uid.' ORDER BY id DESC, aid ASC');
		$this->assign('list',$list);
		$this->display();
	}

	// 处理表单数据
	public function insert() {
		$Userevent = M("Userevent");
		$data['date'] = $_POST['date'];
		$data['title'] = $_POST['title'];
		$data['starttime'] = $_POST['starttime'];
		$data['endtime'] = $_POST['endtime'];
		$data['categoryid'] = $_POST['category'];
		$data['userid'] = $_POST['uid'];
		if($eid = $Userevent->add($data))
		{
			for($i=0; $i<count($_POST['content']); $i++)
			{
				$data1['eventid'] = $eid;
				$data1['content'] = $_POST['content'][$i];
				$data1['attributeid'] = $_POST['attrid'][$i];
				if(!M("Attribute_content")->add($data1))
				{
					$this->success("插入事件属性失败");
				}
			}
			$this->redirect('index');
		}
		else
		{
			$this->success("插入事件数据失败");
		}
	}

	public function update() {
		$AttrCon = M("Attribute_content");
		$Evt = M("Userevent");
		$data0['date'] = $_POST['date'];
		$data0['title'] = $_POST['title'];
		$data0['starttime'] = $_POST['starttime'];
		$data0['endtime'] = $_POST['endtime'];
		if(($Evt->where('id='.$_POST['eventid'])->save($data0)) > -1)
		{
			for($i=0; $i<count($_POST['attributeid']); $i++)
			{
				$data1['content'] = $_POST['content'][$i];
				if(($AttrCon->where('aid='.$_POST['attributeid'][$i])->save($data1)) < 0)
				{
					$this->success("更新事件属性内容数据失败");
				}
			}
		}
		else
		{
			$this->success("更新事件数据失败");
		}
		$this->redirect('index');
	}
	
	public function deleteEvt(){
		$Userevent = M("Userevent");
		if($Userevent->execute('DELETE FROM think_userevent WHERE id="'.$_GET['id'].'"'))
		{
			$this->redirect('index'); 
		}
		else
		{
			$this->success($_GET['id']."删除数据失败");
		}
	}
	
	public function addCategory() {
		$this->assign('username', Session::get('username'));
		$this->assign('userid', Session::get('userid'));
		$this->display();
	}
	
	public function addCateSubmit(){
		$Cate = M("Category");
		$data['uid'] = $_POST['userid'];
		$data['categoryname'] = $_POST['categoryname'];
		$cid = $Cate->add($data);
		if($cid)
		{
			$C_attr = M("Category_attributes");
			$name = $_POST['name'];
			$type = $_POST['type'];
			$label = $_POST['label'];
			$fill = $_POST['fill'];
			for($i=0; $i<count($name); $i++)
			{
				$data1['categoryid'] = $cid;
				$data1['ctrl_type'] = $type[$i];
				$data1['name'] = $name[$i];
				$data1['label'] = $label[$i];
				if($fill[$i]=='on')
				{
					$data1['fill'] = 1;
				}
				else
				{
					$data1['fill'] = 0;
				}
				if(($C_attr->add($data1))==false)
				{
					$this->success("attributes--failed");
				}
			}
		}
		else
		{
			$this->success("category-failed");
		}
		$this->redirect('index');
	}
	
	public function queryCateAttr()
	{
		$cid = $_POST['cid'];  
        $attr = M('Category_attributes')->where('categoryid='.$cid)->select(); 
        echo json_encode($attr);
	}

	public function queryAttrContent()
	{
		$eid = $_POST['eid'];  
        $content = M('Category_attributes')->query('SELECT * FROM think_attribute_content
													LEFT JOIN think_category_attributes ON think_attribute_content.attributeid = think_category_attributes.attrid
													WHERE eventid = '.$eid); 
        echo json_encode($content);
	}
}
?>