<?php
class IndexAction extends Action{
	public function index(){
		$this->display();
	}
	
	public function say(){
		$ta = M('tb_p_ta');
		$d['MY_NAME'] = $_POST['myname'];
		$d['MY_BIRTHDAY'] = $_POST['mybir'];
		$d['TA_NAME'] = $_POST['taname'];
		$d['TA_BIRTHDAY'] = $_POST['tabir'];
		if($id = $ta->add($d))
		{
			$m['RELATION_ID'] = $id;
			$m['MESSAGE_CONTENT'] = $_POST['content'];
			$msg = M('tb_p_msg');
			$msg->add($m);
			
			$msg = M('tb_p_msg');
			if($talk = $msg->query('SELECT * FROM tb_p_msg WHERE RELATION_ID='.$id))
			{
				//dump($talk);
				$this->assign("talk", $talk);
				$this->display();
			}
			else
			{
				echo "error";
			}
		}
		else
		{
			echo "error";
		}
	}
}
?>