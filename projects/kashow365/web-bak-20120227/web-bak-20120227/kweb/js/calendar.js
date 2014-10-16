function montharr(m0, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11) 
{
	this[0] = m0;
	this[1] = m1;
	this[2] = m2;
	this[3] = m3;
	this[4] = m4;
	this[5] = m5;
	this[6] = m6;
	this[7] = m7;
	this[8] = m8;
	this[9] = m9;
	this[10] = m10;
	this[11] = m11;
}
//实现月历
function calendar() {
	var monthNames = "JanFebMarAprMayJunJulAugSepOctNovDec";
	var today = new Date();
	var thisDay;
	var monthDays = new montharr(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	year = today.getYear() +1900;
	thisDay = today.getDate();
	if (((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0)) monthDays[1] = 29;
	nDays = monthDays[today.getMonth()];
	firstDay = today;
	firstDay.setDate(1);
	testMe = firstDay.getDate();
	if (testMe == 2) firstDay.setDate(0);
	startDay = firstDay.getDay();
	document.write("<TABLE BORDER='0' CELLSPACING='0' CELLPADDING='2' ALIGN='CENTER' >")
	document.write("<TR><TD><table border='0' cellspacing='1' cellpadding='2' bgcolor='#d3d3d3'>");
	document.write("<TR><th colspan='7'>");
	var dayNames = new Array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
	var monthNames = new Array("1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月");
	var now = new Date();
	//document.writeln("<FONT STYLE='font-size:9pt;Color:#330099'>" + "公元 " + now.getYear() + "年" + monthNames[now.getMonth()] + " " + now.getDate() + "日 " + dayNames[now.getDay()] + "</FONT>");
	document.writeln("</TH></TR><TR><TH width='25'><FONT STYLE='font-size:9pt;Color:#333333'>日</FONT></TH>");
	document.writeln("<th width='25'><FONT STYLE='font-size:9pt;Color:#333333'>一</FONT></TH>");
	document.writeln("<TH width='25'><FONT STYLE='font-size:9pt;Color:#333333'>二</FONT></TH>");
	document.writeln("<TH width='25'><FONT STYLE='font-size:9pt;Color:#333333'>三</FONT></TH>");
	document.writeln("<TH width='25'><FONT STYLE='font-size:9pt;Color:#333333'>四</FONT></TH>");
	document.writeln("<TH width='25'><FONT STYLE='font-size:9pt;Color:#333333'>五</FONT></TH>");
	document.writeln("<TH width='25'><FONT STYLE='font-size:9pt;Color:#333333'>六</FONT></TH>");
	document.writeln("</TR><TR>");
	column = 0;
	for (i=0; i<startDay; i++) {
	document.writeln("\n<TD><FONT STYLE='font-size:9pt'> </FONT></TD>");
	column++;
	}
	
	for (i=1; i<=nDays; i++) {
	if (i == thisDay) {
	document.writeln("</TD><TD ALIGN='CENTER' BGCOLOR='#FF8040'><FONT STYLE='font-size:9pt;Color:#ffffff'><B>")
	}
	else {
	document.writeln("</TD><TD BGCOLOR='#FFFFFF' ALIGN='CENTER'><FONT STYLE='font-size:9pt;font-family:Arial;font-weight:bold;Color:#330066'>");
	}
	document.writeln(i);
	if (i == thisDay) document.writeln("</FONT></TD>")
	column++;
	if (column == 7) {
		document.writeln("<TR>"); 
		column = 0;
	}
	}
	document.writeln("<TR><TD COLSPAN='7' ALIGN='CENTER' VALIGN='TOP'>")
	document.writeln("<FORM NAME='clock' onSubmit='0'><FONT STYLE='font-size:9pt;Color:#333333'>")
	document.writeln("<div id='face'></div></FONT></TD></TR></TABLE>")
	document.writeln("</TD></TR></TABLE></FORM>");
}

var timerID = null;
var timerRunning = false;

function stopclock (){
	if(timerRunning)
	clearTimeout(timerID);
	timerRunning = false;
}

//显示当前时间
function showtime () {
	var now = new Date();
	var hours = now.getHours();
	var minutes = now.getMinutes();
	var seconds = now.getSeconds();
	var timeValue = " " + ((hours >12) ? hours -12 :hours);
	timeValue += ((minutes < 10) ? ":0" : ":") + minutes;
	timeValue += ((seconds < 10) ? ":0" : ":") + seconds;
	timeValue += (hours >= 12) ? " 下午 " : " 上午 ";
	document.getElementById("face").innerText = timeValue;
	timerID = setTimeout("showtime()",1000);//设置超时,使时间动态显示
	timerRunning = true;
}

function startclock () {
	stopclock();
	showtime();
}

