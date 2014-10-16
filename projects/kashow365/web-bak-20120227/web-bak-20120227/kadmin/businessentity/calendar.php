<?php
class Calendar{

　　var $YEAR,$MONTH,$DAY;
　　var $WEEK=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
　　var $_MONTH=array(
　　　　　　"01"=>"一月",
　　　　　　"02"=>"二月",
　　　　　　"03"=>"三月",
　　　　　　"04"=>"四月",
　　　　　　"05"=>"五月",
　　　　　　"06"=>"六月",
　　　　　　"07"=>"七月",
　　　　　　"08"=>"八月",
　　　　　　"09"=>"九月",
　　　　　　"10"=>"十月",
　　　　　　"11"=>"十一月",
　　　　　　"12"=>"十二月"
　　　　);
　　//设置年份
　　function setYear($year){
　　　　$this->YEAR=$year;
　　}
　　//获得年份
　　function getYear(){
　　　　return $this->YEAR;
　　}
　　//设置月份
　　function setMonth($month){
　　　　$this->MONTH=$month;
　　}
　　//获得月份
　　function getMonth(){
　　　　return $this->MONTH;
　　}
　　//设置日期
　　function setDay($day){
　　　　$this->DAY=$day;
　　}
　　//获得日期
　　function getDay(){
　　　　return $this->DAY;
　　}
　　//打印日历
　　function OUT(){
　　　　$this->_env();
　　　　$week=$this->getWeek($this->YEAR,$this->MONTH,$this->DAY);//获得日期为星期几 （例如今天为2003-07-18，星期五）
　　　　$fweek=$this->getWeek($this->YEAR,$this->MONTH,1);//获得此月第一天为星期几
　　　　echo "<div style=\"margin:0;border:1 solid black;width:300;font:9pt\">
　　　　　　<form action=$_SERVER[PHP_SELF] method=\"post\" style=\"margin:0\">
　　　　　　<select name=\"month\" onchange=\"this.form.submit();\">";
　　　　for($ttmpa=1;$ttmpa<13;$ttmpa++){//打印12个月
　　　　　　$ttmpb=sprintf("%02d",$ttmpa);
　　　　　　if(strcmp($ttmpb,$this->MONTH)==0){
　　　　　　　　$select="selected style=\"background-color:#c0c0c0\"";
　　　　　　}else{
　　　　　　　　$select="";
　　　　　　}
　　　　　　echo "<option value=\"$ttmpb\" $select>".$this->_MONTH[$ttmpb]."</option>\r\n";
　　　　}
　　　　echo "　　</select> <select name=\"year\" onchange=\"this.form.submit();\">";//打印年份，前后10年
　　　　for($ctmpa=$this->YEAR-10;$ctmpa<$this->YEAR+10;$ctmpa++){
　　　　　　if($ctmpa>2037){
　　　　　　　　break;
　　　　　　}
　　　　　　if($ctmpa<1970){
　　　　　　　　continue;
　　　　　　}
　　　　　　if(strcmp($ctmpa,$this->YEAR)==0){
　　　　　　　　$select="selected style=\"background-color:#c0c0c0\"";
　　　　　　}else{
　　　　　　　　$select="";
　　　　　　}
　　　　　　echo "<option value=\"$ctmpa\" $select>$ctmpa</option>\r\n";
　　　　}
　　　　echo　　 "</select>
　　　　　　</form>
　　　　　　<table border=0 align=center>";
　　　　for($Tmpa=0;$Tmpa<count($this->WEEK);$Tmpa++){//打印星期标头
　　　　　　echo "<td>".$this->WEEK[$Tmpa];
　　　　}
　　　　for($Tmpb=1;$Tmpb<=date("t",mktime(0,0,0,$this->MONTH,$this->DAY,$this->YEAR));$Tmpb++){//打印所有日期
　　　　　　if(strcmp($Tmpb,$this->DAY)==0){　　//获得当前日期，做标记
　　　　　　　　$flag=" bgcolor='#ff0000'";
　　　　　　}else{
　　　　　　　　$flag=' bgcolor=#ffffff';
　　　　　　}
　　　　　　if($Tmpb==1){　　　 
　　　　　　　　echo "<tr>";　　　　//补充打印
　　　　　　　　for($Tmpc=0;$Tmpc<$fweek;$Tmpc++){
　　　　　　　　　　echo "<td>";
　　　　　　　　}
　　　　　　}
　　　　　　if(strcmp($this->getWeek($this->YEAR,$this->MONTH,$Tmpb),0)==0){
　　　　　　　　echo "<tr><td align=center $flag>$Tmpb";
　　　　　　}else{
　　　　　　　　echo "<td align=center $flag>$Tmpb";
　　　　　　}
　　　　}
　　　　echo "</table></div>";
　　}
　　//获得方法内指定的日期的星期数
　　function getWeek($year,$month,$day){
　　　　$week=date("w",mktime(0,0,0,$month,$day,$year));//获得星期
　　　　return $week;//获得星期
　　}
　　function _env(){
　　　　if(isset($_POST[month])){　　//有指定月
　　　　　　$month=$_POST[month];
　　　　}else{
　　　　　　$month=date("m");　　//默认为本月
　　　　}
　　　　if(isset($_POST[year])){　　//有指年
　　　　　　$year=$_POST[year];
　　　　}else{
　　　　　　$year=date("Y");　　//默认为本年
　　　　}
	　　$this->setYear($year);
	　　$this->setMonth($month);
	　　$this->setDay(date("d"));
　　}
}
echo '1';
$D=new Calendar;
$D->OUT();

?>


