var  bsYear;
var  bsDate;
var  bsWeek;
var  arrLen=22;    //数组长度
var  sValue=0;    //当年的秒数
var  dayiy=0;    //当年第几天
var  miy=0;    //月份的下标
var  iyear=0;    //年份标记
var  dayim=0;    //当月第几天
var  spd=86400;    //每天的秒数

var  year1999="30;29;29;30;29;29;30;29;30;30;30;29";    //354
var  year2000="30;30;29;29;30;29;29;30;29;30;30;29";    //354
var  year2001="30;30;29;30;29;30;29;29;30;29;30;29;30";    //384
var  year2002="30;30;29;30;29;30;29;29;30;29;30;29";    //354
var  year2003="30;30;29;30;30;29;30;29;29;30;29;30";    //355
var  year2004="29;30;29;30;30;29;30;29;30;29;30;29;30";    //384
var  year2005="29;30;29;30;29;30;30;29;30;29;30;29";    //354
var  year2006="30;29;30;29;30;30;29;29;30;30;29;29;30"; //384
var  year2007="29;29;30;29;29;30;29;30;30;30;29;30";    //354
var  year2008="30;29;29;30;29;29;30;29;30;30;29;30";    //354
var  year2009="30;30;29;29;30;29;29;30;29;30;29;30;30"; //384
var  year2010="30;29;30;29;30;29;29;30;29;30;29;30";    //354
var  year2011="30;29;30;30;29;30;29;29;30;29;30;29";    //354
var  year2012="30;29;30;30;29;30;29;30;29;30;29;30;29"; //384
var  year2013="30;29;30;29;30;30;29;30;29;30;29;30";    //355
var  year2014="29;30;29;30;29;30;29;30;30;29;30;29;30"; //384
var  year2015="29;30;29;29;30;29;30;30;30;29;30;29";    //354
var  year2016="30;29;30;29;29;30;29;30;30;29;30;30";    //355
var  year2017="29;30;29;30;29;29;30;29;30;29;30;30;30"; //384
var  year2018="29;30;29;30;29;29;30;29;30;29;30;30";    //354
var  year2019="30;29;30;29;30;29;29;30;29;29;30;30";    //354
var  year2020="29;30;30;30;29;30;29;29;30;29;30;29;30"; //384

var  month1999="正月;二月;三月;四月;五月;六月;七月;八月;九月;十月;十一月;十二月"
var  month2001="正月;二月;三月;四月;闰四月;五月;六月;七月;八月;九月;十月;十一月;十二月"
var  month2004="正月;二月;闰二月;三月;四月;五月;六月;七月;八月;九月;十月;十一月;十二月"
var  month2006="正月;二月;三月;四月;五月;六月;七月;闰七月;八月;九月;十月;十一月;十二月"
var  month2009="正月;二月;三月;四月;五月;闰五月;六月;七月;八月;九月;十月;十一月;十二月"
var  month2012="正月;二月;三月;四月;闰四月;五月;六月;七月;八月;九月;十月;十一月;十二月"
var  month2014="正月;二月;三月;四月;五月;六月;七月;八月;九月;闰九月;十月;十一月;十二月"
var  month2017="正月;二月;三月;四月;五月;六月;闰六月;七月;八月;九月;十月;十一月;十二月"
var  month2020="正月;二月;三月;四月;闰四月;五月;六月;七月;八月;九月;十月;十一月;十二月"
var  Dn="初一;初二;初三;初四;初五;初六;初七;初八;初九;初十;十一;十二;十三;十四;十五;十六;十七;十八;十九;二十;廿一;廿二;廿三;廿四;廿五;廿六;廿七;廿八;廿九;三十";

var  Ys=new  Array(arrLen);
Ys[0]=919094400;Ys[1]=949680000;Ys[2]=980265600;
Ys[3]=1013443200;Ys[4]=1044028800;Ys[5]=1074700800;
Ys[6]=1107878400;Ys[7]=1138464000;Ys[8]=1171728000;
Ys[9]=1202313600;Ys[10]=1232899200;Ys[11]=1266076800;
Ys[12]=1296662400;Ys[13]=1327248000;Ys[14]=1360425600;
Ys[15]=1391097600;Ys[16]=1424275200;Ys[17]=1454860800;
Ys[18]=1485532800;Ys[19]=1518710400;Ys[20]=1549296000;
Ys[21]=1579881600;

var  Yn=new  Array(arrLen);      //农历年的名称
Yn[0]="己卯年";Yn[1]="庚辰年";Yn[2]="辛巳年";
Yn[3]="壬午年";Yn[4]="癸未年";Yn[5]="甲申年";
Yn[6]="乙酉年";Yn[7]="丙戌年";Yn[8]="丁亥年";
Yn[9]="戊子年";Yn[10]="己丑年";Yn[11]="庚寅年";
Yn[12]="辛卯年";Yn[13]="壬辰年";Yn[14]="癸巳年";
Yn[15]="甲午年";Yn[16]="乙未年";Yn[17]="丙申年";
Yn[18]="丁酉年";Yn[19]="戊戌年";Yn[20]="己亥年";
Yn[21]="庚子年";
var  D=new  Date();
var  yy=D.getFullYear();
var  mm=D.getMonth()+1;
var  dd=D.getDate();
var  ww=D.getDay();
if  (ww==0)  ww="<font  color=RED>星期日</font>";
if  (ww==1)  ww="星期一";
if  (ww==2)  ww="星期二";
if  (ww==3)  ww="星期三";
if  (ww==4)  ww="星期四";
if  (ww==5)  ww="星期五";
if  (ww==6)  ww="<font  color=green>星期六</font>";
ww=ww;
var  ss=parseInt(D.getTime()  /  1000);
if  (yy<100)  yy="19"+yy;

for  (i=0;i<arrLen;i++)
if  (ss>=Ys[i]){
iyear=i;
sValue=ss-Ys[i];        //当年的秒数
}
dayiy=parseInt(sValue/spd)+1;        //当年的天数

var  dpm=year1999;
if  (iyear==1)  dpm=year2000;
if  (iyear==2)  dpm=year2001;
if  (iyear==3)  dpm=year2002;
if  (iyear==4)  dpm=year2003;
if  (iyear==5)  dpm=year2004;
if  (iyear==6)  dpm=year2005;
if  (iyear==7)  dpm=year2006;
if  (iyear==8)  dpm=year2007;
if  (iyear==9)  dpm=year2008;
if  (iyear==10)  dpm=year2009;
if  (iyear==11)  dpm=year2010;
if  (iyear==12)  dpm=year2011;
if  (iyear==13)  dpm=year2012;
if  (iyear==14)  dpm=year2013;
if  (iyear==15)  dpm=year2014;
if  (iyear==16)  dpm=year2015;
if  (iyear==17)  dpm=year2016;
if  (iyear==18)  dpm=year2017;
if  (iyear==19)  dpm=year2018;
if  (iyear==20)  dpm=year2019;
if  (iyear==21)  dpm=year2020;
dpm=dpm.split(";");

var  Mn=month1999;
if  (iyear==2)  Mn=month2001;
if  (iyear==5)  Mn=month2004;
if  (iyear==7)  Mn=month2006;
if  (iyear==10)  Mn=month2009;
if  (iyear==13)  Mn=month2012;
if  (iyear==15)  Mn=month2014;
if  (iyear==18)  Mn=month2017;
if  (iyear==21)  Mn=month2020;
Mn=Mn.split(";");

var  Dn="初一;初二;初三;初四;初五;初六;初七;初八;初九;初十;十一;十二;十三;十四;十五;十六;十七;十八;十九;二十;廿一;廿二;廿三;廿四;廿五;廿六;廿七;廿八;廿九;三十";
Dn=Dn.split(";");

dayim=dayiy;

var  total=new  Array(13);
total[0]=parseInt(dpm[0]);
for  (i=1;i<dpm.length-1;i++)  total[i]=parseInt(dpm[i])+total[i-1];
for  (i=dpm.length-1;i>0;i--)
if  (dayim>total[i-1]){
dayim=dayim-total[i-1];
miy=i;break;//2007/11/9若不加break则这天的农历显示為正月初一
}
bsWeek=ww;
bsDate="<span class=month>"+mm+"月</span>";
bsDate2="<span class=day>"+dd+"</span>";
bsYear="农历"+Yn[iyear];
bsYear2=Mn[miy]+Dn[dayim-1];
if  (ss>=Ys[21]||ss<Ys[0])  bsYear=Yn[21];
function  rtnDateString(){
	html= bsDate+bsDate2+'<span class=week>' +bsWeek+'</span>'
	//return html;
	document.getElementById('lunar').innerHTML=html;
	document.getElementById('lunar2').innerHTML=bsYear+bsYear2;
	
}

