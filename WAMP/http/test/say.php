<?php 
$content = trim($_POST['content']); 
if ($content) { 
$fp = fopen('./chat.txt', 'a'); 
fwrite($fp, $content . "\n"); 
fclose($fp); 
clearstatcache(); 
} 
?> 