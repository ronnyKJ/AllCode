/**
modify by cao2xi 2008-11-24
修改评论提交方式
commentSubmit 函数修改：
1.form uid 内容。
2.checkform 信息提交和验证，只验证验证码，不验证用户密码。
3.ajax_sendfb 信息提交，提交用户名和uid，不再提交用户密码。
*/
function InitAjax()
{
  var ajax=false; 
  try { 
    ajax = new ActiveXObject("Msxml2.XMLHTTP"); 
  } catch (e) { 
    try { 
      ajax = new ActiveXObject("Microsoft.XMLHTTP"); 
    } catch (E) { 
      ajax = false; 
    } 
  }
  if (!ajax && typeof XMLHttpRequest!='undefined') { 
    ajax = new XMLHttpRequest(); 
  } 
  return ajax;
} 
String.prototype.trim = function(){return this.replace(/(^[ |　]*)|([ |　]*$)/g, "");}
function $(s){return document.getElementById(s);}
function $$(s){return document.frames?document.frames[s]:$(s).contentWindow;}
function $c(s){return document.createElement(s);}
function initSendTime(){
	SENDTIME = new Date();
}
var err=0;
function commentSubmit(theform){
	
	var smsg =theform.msg.value;
	var susername = theform.username.value;
	var suid = theform.uid.value;
	var snouser = theform.nouser.checked;
	var sauthnum = theform.authnum.value;	 
	var sartID = theform.artID.value;
	 
	
	var sDialog = new dialog();
	sDialog.init();
	
	if(smsg == ''){
		sDialog.event('请输入评论内容!','');
		sDialog.button('dialogOk','void 0');
		$('dialogOk').focus();
		return false;
	}
	if(smsg.length>300){
		sDialog.event('评论内容不能超过150个字...','');
		sDialog.button('dialogOk','void 0');
		$('dialogOk').focus();
		return false;
  }
	if( susername == '' && snouser == false){
		sDialog.event('请您登陆或选择匿名发表!','');
		sDialog.button('dialogOk','void 0');
		$('dialogOk').focus();
		return false;
	}	
	if(sauthnum == ''){
		sDialog.event('请输入验证码!','');
		sDialog.button('dialogOk','void 0');
		$('dialogOk').focus();
		return false;
	}
	if(sartID == ''){
		sDialog.event('非法提交,错误号#001','');
		sDialog.button('dialogOk','void 0');
		$('dialogOk').focus();
		return false;
	}
  
	
var url = "/shtml/comment/checkform.php?authnum="+sauthnum;
var ajax = InitAjax();
ajax.open("GET",url,false);
ajax.send();
err=ajax.responseText;
if(err == 0){
	var ajax = InitAjax();
	ajax.open("GET",url,false);
	ajax.send();
	err=ajax.responseText;
}

if(err == 2){
	sDialog.event('非法提交,错误号#002','');
	sDialog.button('dialogOk','void 0');
	$('dialogOk').focus();
	return false;	
}
if(err == 1){
	sDialog.event('验证码输入错误!','');
	sDialog.button('dialogOk','void 0');
	$('dialogOk').focus();
	return false;
}

smsg = encodeURI(smsg);
susername = encodeURI(susername);

var url = "/shtml/comment/ajax_sendfb.php?artID="+sartID+"&nouser="+snouser+"&authnum="+sauthnum+"&username="+susername+"&uid="+suid+"&mesg="+smsg;
 
var ajax = InitAjax();
ajax.open("GET", url, false);
ajax.send();
err_msg = ajax.responseText;
 
   if(err_msg == 1){
   	
   		sDialog.event('对不起发贴间距不得小于60s','');
	    sDialog.button('dialogOk','void 0');
	    $('dialogOk').focus();
	    return false;	
   	
   	
   	}


   if(err_msg == 2){
   	
   		sDialog.event('包含非法关键词!','');
	    sDialog.button('dialogOk','void 0');
	    $('dialogOk').focus();
	    return false;	
   	
   	
   	}


   if(err_msg == 3){
   	
   		sDialog.event('评论字数超过限制！','');
	    sDialog.button('dialogOk','void 0');
	    $('dialogOk').focus();
	    return false;	
   	
   	
   	}

   if(err_msg == 4){
   	
   		sDialog.event('信息不完整！','');
	    sDialog.button('dialogOk','void 0');
	    $('dialogOk').focus();
	    return false;	
   	
   	
   	}

	getcommentend(thistid);
	getArtCount(thistid);
	refimg();
	alert('感谢您参与评论');
	return false;
}
 

function getcommentend(tid){
 	var url = "/shtml/comment/artcomment2.php?artid="+tid;
 
	var ajax = InitAjax();
	ajax.open("GET", url, false);
	ajax.send();
	document.getElementById('artcomments').innerHTML = ajax.responseText;
  
}
function getArtCount(tid){
	var url = "/shtml/comment/getArtCount.php?artid="+tid+"&type=all";
	var ajax = InitAjax();
	ajax.open("GET", url, false);
	ajax.send();
	document.getElementById('pinglun2').innerHTML = ajax.responseText; 
	document.getElementById('feedback').innerHTML = ajax.responseText; 
}



function getcountscom(id,quick)
{


  if (typeof(id) == 'undefined')
  {
    return false;
  }
  var url = "/shtml/comment/showArtCom.php?artid="+id+"&quick="+quick; 
  
  
  var i=0;
  var ajax = InitAjax();
  ajax.open("GET", url, true); 
   ajax.onreadystatechange = function() {   
	if (ajax.readyState == 4 && ajax.status == 200) { 
		i = ajax.responseText; 
		if(i == -1){
			alert("您已经对本文进行过投票，无法重复投票。");
		}else{ 
		if(!i){
			i=0;
		}
			var x=""+id+"_"+quick; 
  
			if(quick>10){ 
			quicks=quick-10;
			  x=""+id+"_"+quicks; 
			} 
		  var show = document.getElementById(x); 
			com= "("+i+"票)"; 
			show.innerHTML= com;
			//show2.innerHTML = cTrim(i,0);
		}
	} 
  }
  //发送空
  ajax.send(null); 
}

function cTrim(sInputString,iType){
var sTmpStr = ' ';
var i = -1;
if(iType == 0 || iType == 1){
while(sTmpStr == ' '){
++i;
sTmpStr = sInputString.substr(i,1);
}
sInputString = sInputString.substring(i);
}
if(iType == 0 || iType == 2){
sTmpStr = ' ';
i = sInputString.length;
while(sTmpStr == ' '){
--i;
sTmpStr = sInputString.substr(i,1);
}
sInputString = sInputString.substring(0,i+1);
}
return sInputString;
} 
