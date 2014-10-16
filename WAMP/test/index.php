<html><head></head><body>
<?php if(0){?>

<b>Name</b>

<?php }else{ ?>

<i>Name</i>

<?php } var_dump(array('kk'=>333,'v'=>"fsdfds"));?>


<?php if(1){?>
XXXXXXXXXXX
<?php }?>
<?php $n=0;?>
<?php while($n<5){?>
kkk<br>
<?php $n++;}?>
<br><br><br>
<?php $arr = array('a', 'b', 'c')?>
<?php foreach ($arr as $key => $value) {?>
	<?php echo $value?><br>
<?php }?>
</body></html>

<?php
$now = mktime() + 8*3600;
$then = mktime(22, 10, 0, date("m"), date("d"), date("Y"));
echo (($then - $now)/60).'<br>';
echo date("Y/m/d H:i:s", $now).'<br>';
echo date("Y/m/d H:i:s", $then).'<br>';
?>