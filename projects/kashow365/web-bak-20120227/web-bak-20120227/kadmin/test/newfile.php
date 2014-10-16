<?php

Header("Content-type: image/gif");
$im = imagecreate(400,30);
$black = ImageColorAllocate($im, 0,0,0);
$white = ImageColorAllocate($im, 255,255,255);
imageline($im, 1, 1, 350, 25, $black);
imagearc($im, 200, 15, 20, 20, 35, 190, $white);
imagestring($im, 5, 4, 10, "Graph TEST!!", $white);
ImageGif($im);
ImageDestroy($im);

?>