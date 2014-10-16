<?php
$a1=array(1,2,3,4,5);
$a2=array(3,5,6,7,8);

function diff($a1, $a2){
	$l1 = count($a1);
	$l2 = count($a1);
	$arr=array();
	for($i=0;$i<$l1;$i++){
		for($j=0;$j<$l2;$j++){
			if($a1[$i] == $a2[$j]){
				break;
			}
		}
		if($j == $l2){
			array_push($arr, $a1[$i]);
		}
	}
	
	return $arr;
}

var_dump(diff($a1, $a2));
var_dump(array_diff($a1, $a2));
?>