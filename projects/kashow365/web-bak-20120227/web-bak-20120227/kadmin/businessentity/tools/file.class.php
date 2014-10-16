<?php
class KXFile
{
	static function DeleteFile($path,$fileName)
	{
		$delFileName = './'.$path.$fileName;
		if($fileName != '' && file_exists($delFileName))
		{
			unlink($delFileName);
		}
	}
}
?>