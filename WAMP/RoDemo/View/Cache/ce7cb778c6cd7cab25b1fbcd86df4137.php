<html><head><title>View</title></head>
<body>
	<h1><?php echo $saying?></h1>
	<h1><?php echo $good?></h1>
	<ul>
		<li><?php echo $arr["name"]?></li>		<li><?php echo $arr["job"]?></li>
		<li><?php echo $arr["friends"]["dom"]?></li>
		<li><?php echo $arr["language"][1]?></li>
	</ul>
	<?php if( $arr["name"] != "ronny") {?>
	Yes! I am Ronny!
	<?php }else{?>
	No...I am not Ronny.9999
	<?php }?>

	<ul>
		<?php foreach( $arr["language"] as $key=>$val) {?>
		<li><?php echo $key+1?>.<?php echo $val?></li>
		<?php }?>
	</ul>
</body>
</html>