<?php
class Tools 
{
	static function IsToday($date)
	{
		$result = false;
		
		$newdate = strtotime($date);
		$now=getdate();
		$newdate1 = strtotime($now['year'].'-'.$now['mon'].'-'.$now['mday']);
		
		if( $newdate >= $newdate1)
		{
			$result = true;
		}
		return $result;
	}
	
	static function IsYesterday($date)
	{
		$result = false;
		
		$newdate = strtotime($date);
		$now=getdate();
		$newdateTemp = $now['year'].'-'.$now['mon'].'-'.$now['mday'];
		$newdate1 = strtotime("$newdateTemp -1 day");
		
		if( $newdate - $newdate1 == 0)
		{
			$result = true;
		}
		return $result;
	}
	
	static function FormatTime($dateTime)
	{
		/*
		$result = 'N分钟前';
		$result = 'N.N小时前';
		$result = '昨天';
		$result = '前天';
		$result = 'N天前';
		*/
		
		// 得到与当前时间相差的秒数
		$difference =  time() - strtotime($dateTime);

		// 时间段，按秒算
	 	$minuteDiff = 60*60;
	 	$hourDiff = $minuteDiff*24;
	 	$todayDiff = $hourDiff*2;
	 	$yesterdayDiff = $hourDiff*3;
 	
	 	// 计算文字输出
	 	if($difference < $minuteDiff) // N分钟前
	 	{
	 		$result = round($difference/60).'分钟前';
	 		return $result;
	 	}
	 	
	 	if($difference < $hourDiff) // N.N小时前
	 	{
	 		$result = round($difference/$minuteDiff, 1).'小时前';
	 		return $result;
	 	}
	 	
	 	if($difference < $todayDiff) // 昨天
	 	{
	 		$result = '昨天';
	 		return $result;
	 	}
	 	
	 	if($difference < $yesterdayDiff) // 前天
	 	{
	 		$result = '前天';
	 		return $result;
	 	}
	 	
	 	if($difference >= $yesterdayDiff) // N天前
	 	{
	 		$result = (round($difference/$yesterdayDiff, 1)+2).'天前';
	 		return $result;
	 	}
	}
	
	static function IsOld($date)
	{
		$result = false;
		
		$newdate = strtotime($date);
		$now=getdate();
		$newdateTemp = $now['year'].'-'.$now['mon'].'-'.$now['mday'];
		$newdate1 = strtotime($newdateTemp);

		if( $newdate < $newdate1)
		{
			$result = true;
		}
		return $result;
	}
	
	
	static function GetCardUse($cardUse)
	{
		$result = '';

		if(strpos(','.$cardUse.',',',1,')!==false)
		{
			$result .= $result != '' ? ',打折' : '打折';
		}
		if(strpos(','.$cardUse.',',',2,')!==false)
		{
			$result .= $result != '' ? ',会员' : '会员';
		}
		if(strpos(','.$cardUse.',',',3,')!==false)
		{
			$result .= $result != '' ? ',提货卡' : '提货卡';
		}
		if(strpos(','.$cardUse.',',',4,')!==false)
		{
			$result .= $result != '' ? ',储值' : '储值';
		}
		if(strpos(','.$cardUse.',',',5,')!==false)
		{
			$result .= $result != '' ? ',积分' : '积分';
		}
		if(strpos(','.$cardUse.',',',6,')!==false)
		{
			$result .= $result != '' ? ',体验卡' : '体验卡';
		}
		if(strpos(','.$cardUse.',',',7,')!==false)
		{
			$result .= $result != '' ? ',VIP会员卡' : 'VIP会员卡';
		}

		return $result;
	}
	
	static function ShowDate($flag=0, $timestr=NULL)    
	{    
	    // 获取周几    
	    $warr = array(    
		    "0" => '星期日',    
		    "1" => '星期一',    
		    "2" => '星期二',    
		    "3" => '星期三',    
		    "4" => '星期四',    
		    "5" => '星期五',    
		    "6" => '星期六'   
	    );
	    $timeStamp = NULL;      
	    $i = date("w", $timeStamp);    
	
	    // 设置北京时间并获取时间戳    
	    date_default_timezone_set('PRC');    
	    $timeStamp = NULL;    
	    if ($timestr)    
	        $timeStamp = strtotime($timestr);    
	    else   
	        $timeStamp = time();    
	     
	    // 设置时间显示格式    
	    $ret1 = date("Y年m月d日 H:m:s", $timeStamp) . " " . $warr[$i];    
	    $ret2 = date("Y-m-d H:m:s", $timeStamp) . " " . $warr[$i];    
	    $ret3 = date("y/m/d", $timeStamp);    
	    $ret = $ret1; // 默认返回第一种    
	         
	    if ($flag == 2)    
	        $ret = $ret2;    
	    else if ($flag == 3)    
	        $ret = $ret3;    
	             
	    return $ret;    
	}
 }