<?php
$dir = 'pics';

function read_dir_all($dir) {
 $ret = array('dirs'=>array(), 'files'=>array());
 if ($handle = opendir($dir)) {
  while (false !== ($file = readdir($handle))) {
   if($file != '.' && $file !== '..') {
    $cur_path = $dir . DIRECTORY_SEPARATOR . $file;
    if(is_dir($cur_path)) {
     $ret['dirs'][$cur_path] = read_dir_all($cur_path);
    } else {
     $ret['files'][] = $cur_path;
    }
   }
  }
  closedir($handle);
 }
 return $ret;
}
/*
$p = read_dir_all($dir);
echo '<pre>';
var_dump($p);
echo '</pre>';
*/

//打开 images 目录
$dir = opendir("pics");

//列出 images 目录中的文件
while (($file = readdir($dir)) !== false)
{
	echo "filename: " . $file . "<br />";
}
  closedir($dir);
?>