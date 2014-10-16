<?php
class IndexAction extends Action{
	var $dir_name = "pics";

	// 首页
	public function index(){
		import("@.Action.MyPublicAction");
		if(MyPublicAction::getBrowserType() != "Google Chrome")
		{
			$this->redirect('MyPublic/index');
		}
		
		$this->set_viewcount();
		$this->load_data();
		$this->display();
	}
	
	//加载数据
	private function load_data()
	{
		$pics_form = D("pics");
		$last_date = $pics_form -> query("SELECT left(date, 10) date FROM pics ORDER BY date desc LIMIT 1");
		$pics_list = $this -> pick_date_list($last_date[0]["date"]);
		$this->assign('list',$pics_list);
		$this->get_date();		
	}
	
	//选择某日期照片
	private function pick_date_list($date){
		return D("pics") -> query("SELECT * FROM pics WHERE left(date, 10) = '".$date."' ORDER BY date desc");
	}
	
	//日期选择
	public function pick_date(){
		if($_GET['device'] != "phone")
		{
			import("@.Action.MyPublicAction");
			if(MyPublicAction::getBrowserType() != "Google Chrome")
			{
				$this->redirect('MyPublic/index');
			}		
		}
		$this->set_viewcount();
		$pics_list = $this -> pick_date_list($_GET['date']);
		$this->assign('list', $pics_list);
		$this->get_date();
		$this->display($_GET['device']);
	}
	
	//列出所有日期
	private function get_date(){
		$date_list = D("pics") -> query("SELECT distinct left(date, 10) date FROM pics order by date desc");
		$this->assign('date_list', $date_list);
		$this->assign('date', $date_list);
	}
	
	//把一张照片的信息写入数据库
	private function insert_pic($dir_name, $file)
	{
		$each_pic["filename"] = $file;
		$exif = exif_read_data($dir_name.'/'.$file,0, true);
		if($tmp = $exif[EXIF][DateTimeOriginal])
		{
			$each_pic["date"] = strtr(substr($tmp, 0, 10), ':', '-').substr($tmp, 10, 20);
		}
		else
		{
			$each_pic["date"] = date("Y-m-d H:i:s", filemtime($dir_name.'/'.$file));
		}
		$pics_form = D("pics");
		return $pics_form -> add($each_pic);//写入数据库		
	}
	
	// 数据同步
	public function synchronize(){
		echo 'sync';
		//打开 pics 目录
		$dir = opendir($this->dir_name);
		$pics_form = D("pics");
		//$pics_form -> execute('truncate pics');
		//列出 pics 目录中的文件
		while (($file = readdir($dir)) !== false)
		{
			if($file!='.' && $file != '..')
			{
				echo $file;
				if(!$pics_form -> query("select id from pics where filename = '".$file."'"))
				{
					$this -> insert_pic($this->dir_name, $file);
					echo '-----------------------------------NEW!!';
				}
				echo '<br />';
			}
		}
		closedir($dir);
		$this->display();
	}
	
	// 更新留言
	private function update_words()
	{
		$this->insert_words($_POST['id'], $_POST['words']);
	}
	
	// 插入留言
	private function insert_words($id, $words)
	{
		$pics_form = D("pics");
		if($pics_form -> execute("UPDATE pics SET words = '".$words."' WHERE id = ".$id))
		{
			return "success";
		}
		else
		{
			return "fail";
		}
	}
	
	
	// 接收照片,留言
	public function	receive()
	{
		$file = date('YmdHis',time()).".jpg";//文件以上传时间命名
		$data = file_get_contents('php://input');
		$arr = explode("b@_@b", $data);
		
		$handle = fopen($_SERVER['DOCUMENT_ROOT'].'/'.$this->dir_name.'/'.$file, 'w');
		if ($handle)
		{
			fwrite($handle,$arr[1]);//生成图片文件
			fclose($handle);
			$tempId = $this->insert_pic($this->dir_name, $file);
			$result = $this->insert_words($tempId, base64_decode($arr[0]));//插入留言
			if($result == "success")
			{
				echo "上传成功！";
			}
			else
			{
				echo "留言插入数据库失败...";
			}
		}
		else
		{
			echo "服务器创建图片失败...";
		}
		
	}
	
	// 手机版
	public function phone()
	{
		$this->set_viewcount();
		$this->load_data();
		$this->display();
	}
	
	// 验证管理员，返回留言编辑脚本
	public function getScript()
	{
		if($_POST["command"] == "yangfeng0124")
		{
			$script = "get_script();";
			$script .= "$('#uploadForm').attr('action', cur_url + '/upload/');";
			echo $script;
		}
		else
		{
			echo "alert('命令错误！')";
		}
	}
	
	//获取访问者外网IP
	function get_onlineip() {
		$onlineip = '';
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$onlineip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$onlineip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		return $onlineip;
	}
	
	//统计访问量
	function set_viewcount()
	{
		$ip = $this->get_onlineip();
		$view_count = D("viewcount");
		$result = $view_count -> query("SELECT COUNT(ip) ip_count FROM viewcount where ip ='" . $ip . "'");
		$c = $result[0]['ip_count'];
		if($c > 0)
		{
			$view_count -> execute("UPDATE viewcount SET time='".date("Y-m-d H:m:s")."', count=count+1 WHERE ip='".$ip."'");
		}
		else
		{
			$data["ip"] = $ip;
			$data["time"] = date("Y-m-d H:m:s");
			$data["count"] = 1;
			$view_count -> add($data);
		}
	}
	
	//PC上传图片
	public function upload()
	{
		if (!empty($_FILES)) {
            //如果有文件上传 上传附件
            $this->_upload();
        }
	}

    // 文件上传
    protected function _upload() {
        import("@.ORG.UploadFile");
        $upload = new UploadFile();
        //设置上传文件大小
        $upload->maxSize = 4000000;
        //设置上传文件类型
        $upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
        //设置附件上传目录
        $upload->savePath = 'pics/';
		if($upload->upload())
		{
			$upload_pic["filename"] = $_FILES['image']['name'];
			$upload_pic["date"] = date("Y-m-d H:i:s");
			$pics_form = D("pics");
			$pics_form -> add($upload_pic);			
			$this->redirect('Index/index');
		}
		else
		{
			dump("上传文件失败...");
		}
    }
}
?>