<?php
class EncryptTranslte
{
 static function encode($string, $CI)
 {
 	$encode = $CI->encrypt->encode($string);	
 	$encode = preg_replace('/\+/','-', $encode);
 	$encode = preg_replace('/\//','_', $encode);
 	return $encode;
 }
 
 static function decode($string, $CI)
 {
 	$string = preg_replace('/\-/','+', $string);
 	$string = preg_replace('/_/','/', $string);
 	return $CI->encrypt->decode($string);
 }
}
?>