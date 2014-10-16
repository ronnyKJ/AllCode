<?php 
//chat.php 
header('cache-control: private'); 
header('Content-Type: text/html; charset=utf-8'); 
?> 
<html> 
<script type="text/javascript"> 
function submitChat(obj) { 
obj.submit(); 
document.getElementsByName('content')[0].value = ''; 
} 
</script> 
<iframe src="./chat_content.php" height="300" width="100%"></iframe> 
<iframe name="say" height="0" width="0"></iframe> 
<form method="POST" target="say" action="./say.php" onsubmit="submitChat(this)"> 
<input type="text" size="30" name="content" /> <input type="button" value="say" onclick="submitChat(this.form)" /> 
</form> 
</html> 