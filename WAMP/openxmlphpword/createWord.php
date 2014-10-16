<?php
/*
	版本：0.1
	作者：偷蚊子的(monkee)
	描述：通过对DOCX文件中特殊标记字符的替换，来实现WORD文件的批量生成。
	要求：PHP>5.0。模板文件必须是MS OFFICE 07及其以上的DOCX文件，或者是ODT文件；目录中的apache文件夹具有可写权限。
	使用：详见参数说明。
	参数：
		$message	替换模板文件的数组，例如：$message['title']的值将替换 {title} 部分。
		$template	模板文件
		$wordfile	生成的文件
*/
define("MK_PATH","");	//相对于主文件的位置 末尾加“/”
include_once("pclzip.lib.php");
function createWord($message,$template,$wordfile)
{
	$file_ext=MK_PATH."/apche/0";
	$sc_rep=array();	//替换源
	$ds_rep=array();	//替换目标
	foreach($message as $key=>$item)
	{
		$sc_rep[]='{'.$key.'}';
		$ds_rep[]=$item;
	}
	if(!is_dir($file_ext))
		mkdir($file_ext);
	$zip=new Pclzip($template);
	$zip->extract($file_ext);
	unset($zip);
	$content=@file_get_contents($file_ext."/word/document.xml");
	$content=str_replace($sc_rep,$ds_rep,$content);
	@file_put_contents($file_ext."/word/document.xml",$content);
	$zip=new Pclzip($wordfile);
	$zip->create($file_ext."/[Content_Types].xml,".$file_ext."/word,".$file_ext."/docProps,".$file_ext."/_rels",PCLZIP_OPT_REMOVE_PATH,$file_ext);
	//$zip->create("[Content_Types].xml,word,docProps,_rels");
	removeDir($file_ext);
	/*
	foreach(array("[Content_Types].xml","word","docProps","_rels") as $item)
	{
		removeDir($item);
	}
	*/
	return true;
}
function removeDir($dir)
{
	  if(is_dir($dir))
	  {
		  $s=scandir($dir);
		  foreach($s as $i)
			  if($i!="." && $i!="..")
				  removeDir($dir."/".$i);
		  @rmdir($dir);
	  }
	  elseif(is_file($dir))
		  @unlink($dir);
	  else
		  return false;
	  return true;
}
?>