<script src="<?php echo base_url();?>kweb/js/formValidator-4.1.1.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/formValidatorRegex.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/jquery.timer.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$.formValidator.initConfig({theme:"126",submitOnce:true,formID:"form1",
		onError:function(msg){alert(msg);},
		submitAfterAjaxPrompt : '有数据正在异步验证，请稍等...',
		buttons: $("#button"),
		debug:false
	});

	$("#e").formValidator({
		onShowFixText:"请输入您的邮箱，该邮箱将会用来登录卡网站的"
		,onShow:"请输入邮箱"
		,onFocus:"邮箱6-100个字符,输入正确了才能离开焦点"
		,onCorrect:"恭喜你,你输对了"
		,defaultValue:"@"
	}).inputValidator({
		min:6,max:100
		,onError:"你输入的邮箱长度非法,请确认"
	}).regexValidator({
		regExp:"^([\\w-.]+)@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.)|(([\\w-]+.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(]?)$"
		,onError:"你输入的邮箱格式不正确"
	}).ajaxValidator({
		dataType : "html",
		async : true,
		url : "<?php echo site_url("changepwd/checkloginname");?>",
		success : function(data){
	        if( data=='1' > 0 ) return true;
			else return false;
		},
		//buttons: $("#button"),
		error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
		onError : "该邮箱不存在，请确认您注册时留下的邮箱",
		onWait : "正在进行合法性校验，请稍候...",
		complete : function(){}
	});
	
	
	$("#v").formValidator({
		onShowText:"验证码"
		,onFocus:"验证码"
		,onCorrect:"您已输入验证码"
	}).inputValidator({
		min:4,max:4
		,onError:"你输入的长度非法,请确认"
	});
});

$(document).ready(function(){
	//绑定提交按钮
	$("#button").bind("click",function(){ doAction();});
	
	// verify
	$("#verify").bind("click",function(){
		timenow = new Date().getTime();
		$(this).attr("src",$(this).attr("src")+"?rand="+timenow);
	});
	$("#verify").bind("keypress",function(event){if(event.keyCode==13){doAction();}});
});

function doAction(){

	$("#idProcess").show();
	
	// 检查表单
	if(!$.formValidator.pageIsValid())
	{
		$("#idProcess").hide();
		return;
	}

	$(this).attr("disabled",true);
	$(".e").attr("disabled",true);
	$(".v").attr("disabled",true);
	

	//表单参数
	param = $("form").serialize();
	url = $("#form1").attr("action");
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				$("#msg").html(obj.info);
				$("#msg").oneTime(1000, function() {
				    $(this).html("");
				    location.href = obj.data;
				});
				$("#idProcess").hide();
			}
			else
			{
				$("#msg").html(obj.info);
				$("#msg").oneTime(500, function() {
				    // $("#button").removeAttr("disabled");
					document.getElementById("button").removeAttribute("disabled"); 
					$("#verify").click();
				});
				$("#idProcess").hide();
			}
		}
	});
}
</script>
<!-- first start -->
<div class="bigcont">
	<div class="katit3">忘记密码</div>
    <div class="katit4">个人用户</div>
<form id="form1" name="form" action="<?php echo site_url("changepwd/domail");?>">
<!--<input type="submit" value="test" />-->
  <div class="katab4">
	<div id="msg" class="katit5"><!-- error --></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="katable1 martop25">
  <tr>
    <td align="right">* 邮箱：</td>
    <td><label>
      <input class="kainput8" type="text" name="e" id="e" />
    </label></td>
    <td><div id="eTip" style="width:280px"></div></td>
  </tr>
  <tr>
      <td align="right">&nbsp;</td>
      <td colspan="2" valign="top"><div id="eFixTip">请输入您的邮箱，该邮箱将会用来发送确认邮件</div></td>
  </tr>
  <tr>
    <td align="right" valign="top">验证码：</td>
    <td ><label>
      <input class="kainput9" type="text" name="v" id="v" />
    	
      <img id="verify" name="verify" src="<?php echo base_url();?>kweb/verify.php" width="70" height="25" /> 
      <a href="javascript:void(0)" onclick="jQuery('#verify').click()"><font class="grayf">看不清？</font><font class="bluef">换一张</font></a></label></td>
	  <td valign="top"><div id="vTip" style="width:280px"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><label>
      <input class="kabut5" type="button" name="button" id="button" value="确认注册邮箱" />
    </label>
	<img id="idProcess" style="display:none;" src="<?php echo base_url();?>kweb/images/loading.gif" />
	</td>
    </tr>
</table>

  </div>
  </form>
    <div class="clear"></div>
</div>
<!-- first end -->