document.write('<form action="http://www.51cto.com/php/sendfeedback.php" target="_self" method="post" name="feedback" id="feedback" onSubmit="return commentSubmit(this)" style="padding: 0px; margin: 0px;">');
document.write('<textarea class="txtinput" name="msg" id="msg" style="height: 88px;"></textarea><br /><table width="99%" border="0" cellspacing="0" cellpadding="0"><tr><td height="6" colspan="6">');
document.write('<input type="hidden" name="artID" value="250777" />');
document.write('<input type="hidden" name="quick" value="0" />');
document.write('<input type="hidden" name="author2" value="51CTO网友" />');
document.write('</td></tr><tr><td width="9%">');
document.write('验证码：</td><td width="11%"><input name="authnum" onClick="displaysecunum();" type="text" class="test3" />');
document.write('</td><td width="51%"><img id="secunum" style="vertical-align:middle;" onclick="refimg()" style="display:none"/>');
document.write('<span style="display:none;" id="spanfont">点击图片可刷新验证码</span>');
document.write('<span style="display:inline;" id="clickfont">请点击后输入验证码</span>');
document.write('</td><td width="4%"><input name="nouser" type="checkbox" value="1" onClick="author2username2()"></td><td width="12%">匿名发表');
document.write('</td><td width="13%"><input type="image" name="Submit32" src="http://new.51cto.com/wuyou/kelly_newart/images/tijiao.gif" />');
document.write('</td></tr><tr><td height="6" colspan="6"></td></tr></table></form>');
function displaysecunum(){
				var displaystr = document.getElementById("secunum").style.display;
				if(displaystr == 'none' || !displaystr)
				{
					refimg();
					document.getElementById("clickfont").style.display = 'none';
					document.getElementById("secunum").style.display = 'inline';
					document.getElementById("spanfont").style.display = 'inline';
				}
			}
function author2username2(){
				if( islogin==1 )
				{
					if (this.checked==true)
					{
						document.getElementById("author2").value=document.getElementById("username2").value;document.getElementById("username2").value="51CTO网友";
					}else
					{
						document.getElementById("username2").value=document.getElementById("author2").value
					}
				}
			}