<?php
//author:PHPer.yang@gmail.com


if(file_exists('11.jpg')){
	ini_set('exif.encode_unicode', 'UTF-8');
	$exif = exif_read_data('11.jpg',0, true);
	
	echo "<img src='11.jpg' width='100'/><br />";

	echo "文件名: ".$exif[FILE][FileName].'<br />';
	echo "文件类型: ".$imgtype[$exif[FILE][FileType]].'<br />';
	echo "文件格式: ".$exif[FILE][MimeType].'<br />';
	echo "文件大小: ".$exif[FILE][FileSize].'<br />';
	echo "时间戳: ".date("Y-m-d H:i:s",$exif[FILE][FileDateTime]).'<br />';
	echo "图片说明: ".$exif[IFD0][ImageDescription].'<br />';
	echo "制造商: ".$exif[IFD0][Make].'<br />';
	echo "型号: ".$exif[IFD0][Model].'<br />';
	echo "方向: ". $Orientation[$exif[IFD0][Orientation]].'<br />';
	echo "水平分辨率: ".$exif[IFD0][XResolution].$ResolutionUnit[$exif[IFD0][ResolutionUnit]].'<br />';
	echo "垂直分辨率: ".$exif[IFD0][YResolution].$ResolutionUnit[$exif[IFD0][ResolutionUnit]].'<br />';
	echo "创建软件: ".$exif[IFD0][Software].'<br />';
	echo "修改时间: ".$exif[IFD0][DateTime].'<br />';
	echo "作者: ".$exif[IFD0][Artist].'<br />';
	echo "YCbCr位置控制: ".$YCbCrPositioning[$exif[IFD0][YCbCrPositioning]].'<br />';
	echo "版权: ".$exif[IFD0][Copyright].'<br />';
	echo "摄影版权: ".$exif[COMPUTED][Copyright.Photographer].'<br />';
	echo "编辑版权: ".$exif[COMPUTED][Copyright.Editor].'<br />';
	echo "Exif版本: ".$exif[EXIF][ExifVersion].'<br />';
	echo "FlashPix版本: "."Ver. ".number_format($exif[EXIF][FlashPixVersion]/100,2).'<br />';
	echo "拍摄时间: ".$exif[EXIF][DateTimeOriginal].'<br />';
	echo "数字化时间: ".$exif[EXIF][DateTimeDigitized].'<br />';
	echo "拍摄分辨率高: ".$exif[COMPUTED][Height].'<br />';
	echo "拍摄分辨率宽: ".$exif[COMPUTED][Width].'<br />';
	echo "光圈: ".$exif[EXIF][ApertureValue].'<br />';
	echo "快门速度: ".$exif[EXIF][ShutterSpeedValue].'<br />';
	echo "快门光圈: ".$exif[COMPUTED][ApertureFNumber].'<br />';
	echo "最大光圈值: "."F".$exif[EXIF][MaxApertureValue].'<br />';
	echo "曝光时间: ".$exif[EXIF][ExposureTime].'<br />';
	echo "F-Number: ".$exif[EXIF][FNumber].'<br />';
	//echo "测光模式: ".GetImageInfoVal($exif[EXIF][MeteringMode],$MeteringMode_arr).'<br />';
	//echo "光源: ".GetImageInfoVal($exif[EXIF][LightSource], $Lightsource_arr).'<br />';
	//echo "闪光灯: ".GetImageInfoVal($exif[EXIF][Flash], $Flash_arr).'<br />';
	echo "曝光模式: ".($exif[EXIF][ExposureMode]==1?"手动":"自动").'<br />';
	echo "白平衡: ".($exif[EXIF][WhiteBalance]==1?"手动":"自动").'<br />';
	echo "曝光程序: ".$ExposureProgram[$exif[EXIF][ExposureProgram]].'<br />';
	echo "曝光补偿: ".$exif[EXIF][ExposureBiasValue]."EV".'<br />';
	echo "ISO感光度: ".$exif[EXIF][ISOSpeedRatings].'<br />';
	echo " 分量配置: ".(bin2hex($exif[EXIF][ComponentsConfiguration])=="01020300"?"YCbCr":"RGB").'<br />';//'0x04,0x05,0x06,0x00'="RGB" '0x01,0x02,0x03,0x00'="YCbCr"
	echo "图像压缩率: ".$exif[EXIF][CompressedBitsPerPixel]."Bits/Pixel".'<br />';
	echo "对焦距离: ".$exif[COMPUTED][FocusDistance]."m".'<br />';
	echo "焦距: ".$exif[EXIF][FocalLength]."mm".'<br />';
	echo "等价35mm焦距: ".$exif[EXIF][FocalLengthIn35mmFilm]."mm".'<br />';
	
}
else{
	echo 'Unable to open file 11.jpg.';
}
//$exif_data = exif_read_data( '11.jpg' );
//echo '<pre>';
//print_r($exif_data);
?>