<?php
$file=fopen("test.txt","r") or exit("Unable to open file!");
while (!feof($file)) 
  { 
  echo fgetc($file); 
  }
fclose($file);
?>