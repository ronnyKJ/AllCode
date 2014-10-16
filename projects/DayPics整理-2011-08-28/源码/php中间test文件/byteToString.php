<?php  
function stringToByteArray($str,$charset) {  
  
    $str = iconv($charset,'UTF-16',$str);  
    preg_match_all('/(.)/s',$str,$bytes);  //注：本文的盗版已经有了。不过，提示一下读者，这里的正则改了。  
    $bytes=array_map('ord',$bytes[1]) ;  
    return $bytes;  
  
}  
  
function byteArrayToString($bytes,$charset) {  
  
    $bytes=array_map('chr',$bytes);  
    $str=implode('',$bytes);  
    $str = iconv('UTF-16',$charset,$str);  
    return $str;  
  
}  
  
$byteArray=stringToByteArray('这是一段测试的话','utf-8');  
print_r($byteArray);  
$retStr=byteArrayToString($byteArray,'utf-8');  
echo $retStr;  
  
?> 