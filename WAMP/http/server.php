<?php
set_time_limit(0);
$n=0;
echo(str_repeat(' ',256));
while(++$n<10)
{
	echo "<div>$n</div>";
	ob_flush();
	flush();
	sleep(1);
}
?>