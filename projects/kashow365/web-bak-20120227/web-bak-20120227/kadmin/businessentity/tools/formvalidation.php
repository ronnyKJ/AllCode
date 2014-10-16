<?php
class FormValidation
{
	///////////////////////////////////////////////////////////////////////////
	//  进入操作提示页
	///////////////////////////////////////////////////////////////////////////
	static function GotoOperMsgPageParms($title, $message, $nexturl, $CI_this)
	{
		$data = array(
			'title' =>  $title == '' ? '#' : $title
			,'message' => $message == '' ? '#' : $message
			,'nexturl' => $nexturl == '' ? '#' : $nexturl 
		);
		$CI_this->load->view('kadmin/opermsg.php', $data);
	}
	
	static function GotoOperMsgPage($data, $CI_this)
	{
		$CI_this->load->view('kadmin/opermsg.php', $data);
	}
	
	static function max_length500($s,$CI_this)
	{
		if(mb_strlen($s)>500)
		{
		  $CI_this->form_validation->set_message('max_length500', '长度过长,限制500');
		  return FALSE;
		}
		else
		{
		  return TRUE;
		}
	}
}
?>