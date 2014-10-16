<?php
function foobar($a, $b){
	echo $a+$b;
}

foobar(1,2);
call_user_func_array('foobar', array(2,4));

class Test{
	function say($s){
		echo $s.'<br>';
	}

	function play(){
		echo "PLAY<br>";
	}
}

$t = new Test();
$t->say("dsdasda");

call_user_method_array('say', $t, array('method!!'));
call_user_func_array(array($t, 'say'), array('func!!'));
call_user_func_array(array(&$t, 'say'));
call_user_func_array(array(&$t, $method='play'));
?>