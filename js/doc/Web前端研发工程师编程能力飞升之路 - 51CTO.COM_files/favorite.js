 
	document.getElementById('pinglun_1').innerHTML = document.getElementById("pinglun").innerHTML;
	document.getElementById('pinglun_2').innerHTML = document.getElementById("pinglun").innerHTML;
	document.getElementById('tonglanad').innerHTML=document.getElementById('tonglan').innerHTML;
    document.getElementById('tonglan').innerHTML="";
	function refimg(){
		var randval = Math.random();
		document.getElementById('secunum').src='http://www.51cto.com/php/seccode.php?rnum='+randval;
	}
 
function copy(id, text, txt) {
	var clip = null;
	clip = new ZeroClipboard.Client();
	clip.setHandCursor( true );	
	clip.addEventListener('load', my_load);
	clip.addEventListener('complete', my_complete);	
	clip.glue( id );	
	function my_load(client){
			clip.setText(text);
	}	
	function my_complete(client) {
		alert(txt);
	}
}
 /*
var idstr = document.getElementById('indexliststr').innerHTML;
if(idstr != ''){
	document.getElementById('indexbar').style.display = '';
}*/


function validate(theform) {
	
	if( theform.msg.value == '' || theform.msg.value == ''){
		alert('请输入评论内容');
		theform.msg.focus();
		return false;
	}
	
	if(theform.password.value == '' && theform.nouser.checked==false ){
			alert('请您登陆或选择匿名发表!');
			
			return false;
		}
	if(theform.username.value == '' && theform.nouser.checked==false){
			alert('请您登陆或选择匿名发表!');
			
			return false;
		}
	if( theform.authnum.value == ''){
		alert('请输入验证码');
		theform.authnum.focus();
		return false;
	}

	
} 

var clickCount = 0;
function clearCommentContent(oObject){
	clickCount++;
	if (clickCount == 1){
		oObject.value = "";
	}
}

function indexshow(){
		var indexbar = document.getElementById('indexbar');
		var indexa = document.getElementById('indexa');
		var indexlist = document.getElementById('indexlist');
		var classname = indexbar.className;
		if(classname == 'tagcol'){
			indexa.innerHTML = '显示';
			indexbar.className = 'tagcol-a';
			indexlist.style.display = 'none';
		}else{
			indexa.innerHTML = '隐藏';
			indexbar.className = 'tagcol';
			indexlist.style.display = '';
		}
		
	}
	var fsize=14;
	function setfont(size){
              var divBody = document.getElementById("content");
              if(!divBody)
              {
                  return;
              }
			  if(fsize!=14){
			  		if(size>fsize){
						size -= 2; 
					}else if(size<fsize){
						size += 2;
					}
			  }
			  fsize = size;
			  recfont(divBody);
              
          }
	function recfont(obj){
		  obj.style.fontSize = fsize + "px";
		  var divChildBody = obj.childNodes;
		  if(divChildBody.length>0){
			  for(var i = 0; i < divChildBody.length; i++)
			  {
				 if (divChildBody[i].nodeType==1)
				 {
				 	 recfont(divChildBody[i]);
					  //divChildBody[i].style.fontSize = fsize + "px";
				 }
			  }
		  }
	}
	function doempty(o, str){
		var val = o.value;
		if(val == str){
			o.value = '';
		}else if(val == ''){
			o.value = str;
		}
	}
	
	function AddFavorite(sURL, sTitle)
	{
		try
		{
			window.external.addFavorite(sURL, sTitle);
		}
		catch (e)
		{
			try
			{
				window.sidebar.addPanel(sTitle, sURL, "");
			}
			catch (e)
			{
				alert("加入收藏失败，请使用Ctrl+D进行添加");
			}
		}
	}
	
	// JavaScript Document
function email_test(str) 
{ 
var i,flag=0; 
var at_symbol=0; 
//“@”检测的位置 
var dot_symbol=0; 
//“.”检测的位置 
//if(char_test(str.charAt(0))==0 ) 
//return (1); 
//首字符必须用字母 

for (i=1;i<str.length;i++) 
if(str.charAt(i)=='@') 
{ 
at_symbol=i; 
break; 
} 
//检测“@”的位置 

if(at_symbol==str.length-1 || at_symbol==0) 
return(2); 
//没有邮件服务器域名 

if(at_symbol<3) 
return(3); 
//帐号少于三个字符 

if(at_symbol>19 ) 
return(4); 
//帐号多于十九个字符 

for(i=1;i<at_symbol;i++) 
if(char_test(str.charAt(i))==0 && spchar_test(str.charAt(i))==0) 
return (5); 
for(i=at_symbol+1;i<str.length;i++) 
if(char_test(str.charAt(i))==0 && spchar_test(str.charAt(i))==0) 
return (5); 
//不能用其它的特殊字符 

for(i=at_symbol+1;i<str.length;i++) 
if(str.charAt(i)=='.') dot_symbol=i; 
for(i=at_symbol+1;i<str.length;i++) 
if(dot_symbol==0 || dot_symbol==str.length-1) 
//简单的检测有没有“.”，以确定服务器名是否合法 
return (6); 

return (0); 
//邮件名合法 
}
function mail_process(stringin){ 
var num=email_test(stringin); 
var str=""; 
if (num!=0) 
{
switch (num) 
{
case 1: 
str="首字符必须用字母！或不能为空！请返回重填。"; 
break; 
case 2: 
str="您忘了填写邮件服务器的地址了！请返回重填。"; 
break; 
case 3: 
str="您的帐号太短，不能少于三个字符!请返回重填。"; 
break; 
case 4: 
str="您的帐号太长，不能多于十九个字符!请返回重填。"; 
break; 
case 5: 
str="您使用了非法字符!请返回重填。"; 
break; 
case 6: 
str="您的邮件服务器的地址不合法!请返回重填。"; 
break; 
default: 
str="您的email地址不合法!请返回重填。"; 
} 
alert(str); 
return false;
} 
}
function cmouseover(divName,over,counts,oclass){
	if(signover==1){
		for(var i=0;i<counts;i++){
			var divClassName = document.getElementById(divName+'top_'+i);
			
				divClassName.className = divClassName.className.substr(0,divClassName.className.length-2)+"_b";
		}
		document.getElementById(divName+'top_'+over).className = divClassName.className.substr(0,divClassName.className.length-2)+"_a";
		for(i=0;i<counts;i++){
			document.getElementById(divName+'_'+i).style.display = "none";
		}
		document.getElementById(divName+'_'+over).style.display = "";
	}
	signover = 0;
	return false;
}
function change_con(up,down){
	if(up && down){
		document.getElementById("con_"+up).style.display="";
		document.getElementById("jiantou_"+up).style.display="";
		document.getElementById("con_"+down).style.display="none";
		document.getElementById("jiantou_"+down).style.display="none";
	}
}
function change_read(up,down){
	if(up && down){
		document.getElementById("com_"+up).style.display="";
		document.getElementById("bt_com_"+up).className="right_4_2";
		document.getElementById("com_"+down).style.display="none";
		document.getElementById("bt_com_"+down).className="right_4_3";
	}
}
function change_top(tnum){
	if(tnum){
		for(var i=1;i<5;i++){
			document.getElementById("bt_top_"+i).className="right_4_3";
			document.getElementById("div_top_"+i).style.display="none";
		}
		document.getElementById("bt_top_"+tnum).className="right_4_2";
		document.getElementById("div_top_"+tnum).style.display="";
	}
}
function change_spec(tnum){
	if(tnum){
		for(var i=1;i<4;i++){
			document.getElementById("bt_spec_"+i).className="right_4_3";
			document.getElementById("spec_"+i).style.display="none";
		}
		document.getElementById("bt_spec_"+tnum).className="right_4_2";
		document.getElementById("spec_"+tnum).style.display="";
	}
}
function change_down(tnum){
	for(var i=0;i<3;i++){
		document.getElementById("download_"+i).style.display="none";
	}
	document.getElementById("download_"+tnum).style.display="";
}
function FormMenu(targ,selObj,restore){ 
	window.open(selObj.options[selObj.selectedIndex].value);
	if (restore) selObj.selectedIndex=0;
}
//TOP10滑动门
function change_top10(id){
	document.getElementById("top_1").className = "";
	document.getElementById("top_2").className = "";
	document.getElementById("top_3").className = "";
	document.getElementById("top_"+id).className = "myon";
	document.getElementById("top10_1").style.display = "none";
	document.getElementById("top10_2").style.display = "none";
	document.getElementById("top10_3").style.display = "none";
	document.getElementById("top10_"+id).style.display = "block";
}

//广告延展
var intervalId = null;

slideAd('MyMoveAd',10); 
key = 1;
set_search();
function set_foot(){
	if(key != 1) return;
	document.getElementById("tanc").style.top = (document.body.clientHeight - 240) + "px";
	document.getElementById("tanc").style.left = (document.body.clientWidth - 260) + "px";

	document.getElementById("tanc").style.display = "block";
}

function getPosition() { 
	var top = document.documentElement.scrollTop; 
	var left = document.documentElement.scrollLeft; 
	var height = document.documentElement.clientHeight; 
	var width = document.documentElement.clientWidth; 
	return {top:top,left:left,height:height,width:width}; 
}

function close_this(){
	key = 0;
	document.getElementById("tanc").style.display = "none";
}

function set_search(){
	var kw = get_kw();
	if(kw == undefined || kw == ""){
		return;
	}
	var ajax = InitAjax();
	var url = "/shtml/art_search.php?type=name&keyword=" + kw;
	ajax.open("GET",url,false);
	ajax.send();
	err=ajax.responseText;
	document.getElementById("search_title").innerHTML = err;
	document.getElementById("search_foot").innerHTML = err;

	var url = "/shtml/art_search.php?type=keyword&keyword=" + kw;
	ajax.open("GET",url,false);
	ajax.send();
	err=ajax.responseText;
	document.getElementById("search_url").href = "http://www.51cto.com/php/search.php?keyword="+err;

	//ajax = InitAjax();
	var url = "/shtml/art_search.php?type=art&keyword=" + kw;
	ajax.open("GET",url,false);
	ajax.send();
	err=ajax.responseText;
	if(err != ""){
		document.getElementById("search_body").innerHTML = err;
	}else{
		return;
	}
	set_sreach();
	document.getElementById("tanc").style.display = "block";
}

function set_sreach(){
	//var win = document.getElementById("tanc").style;
	//win.top = (document.body.clientHeight - 220) + "px";
	//win.left = (document.body.clientWidth - 260) + "px";
}

function get_kw(){
	url = document.referrer;
	if(url == "" || url == undefined){
		return "";
	}
	urls = url.split("&");
	for(i=0;i<urls.length;i++){
		if(urls[i].match("wd=") == "wd="){
			return urls[i].substr(urls[i].indexOf("wd=")+3,urls[i].length);
		}
		if(urls[i].match("q=") == "q=" && urls[i].match("aq=") != "aq="){
			return urls[i].substr(urls[i].indexOf("q=")+2,urls[i].length);
		}
	}
}




function InitAjax()
{
  var ajax=false; 
  try { 
    ajax = new ActiveXObject("Msxml2.XMLHTTP.3.0"); 
  } catch (e) { 
    try { 
      ajax = new ActiveXObject("Microsoft.XMLHTTP.3.0"); 
    } catch (E) { 
      ajax = false; 
    } 
  }
  if (!ajax && typeof XMLHttpRequest!='undefined') { 
    ajax = new XMLHttpRequest(); 
  } 
  return ajax;
}


function check_clean(){
	if(document.getElementById("msg").innerHTML == "发表评论请注意语言文明"){
		document.getElementById("msg").innerHTML = "";
	}
}

function slideAd(id,nStayTime,sState,nMaxHth,nMinHth){
  this.stayTime=nStayTime*1000 || 3000; 
  this.maxHeigth=nMaxHth || 380; 
  this.minHeigth=nMinHth || 1; 
  this.state=sState || "down" ; 
  var obj = document.getElementById(id); 
  if(intervalId != null)window.clearInterval(intervalId); 
  function openBox(){ 
   var h = obj.offsetHeight; 
   obj.style.height = ((this.state == "down") ? (h + 2) : (h - 2))+"px"; 
    if(obj.offsetHeight>this.maxHeigth){ 
    window.clearInterval(intervalId); 
    } 
    if (obj.offsetHeight<this.minHeigth){ 
    window.clearInterval(intervalId); 
    obj.style.display="none"; 
    } 
  } 
  intervalId = window.setInterval(openBox,2); 
}

/*add by kelly 2010-12-6*/
function tanc_click_count(){
	var ajax = InitAjax();
	var url = "/shtml/art_search_count.php";
	ajax.open("GET",url,false);
	ajax.send();
}

function big(o)
{
	 
	//return false;
	return true;
}