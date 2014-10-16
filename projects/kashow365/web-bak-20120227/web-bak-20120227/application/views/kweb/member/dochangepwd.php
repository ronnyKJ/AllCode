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
	$("#p").formValidator({
		onShowFixText:"6~16个字符，包括字母、数字、特殊符号，区分大小写"
		,onShow:"请输入密码"
		,onFocus:"至少1个长度"
		,onCorrect:"密码合法"
	}).inputValidator({
		min:6,max:16
		,empty:{
			leftEmpty:false
			,rightEmpty:false
			,emptyError:"密码两边不能有空符号"
		}
		,onError:"密码长度错误,请确认"
	}).passwordValidator({compareID:"us"});
	
	$("#p2").formValidator({
		onShowFixText:"请再次输入密码"
		,onShow:"输再次输入密码"
		,onFocus:"至少1个长度"
		,onCorrect:"密码一致"
	}).inputValidator({
		min:1
		,empty:{
			leftEmpty:false
			,rightEmpty:false
			,emptyError:"重复密码两边不能有空符号"
		}
		,onError:"重复密码不能为空,请确认"
	}).compareValidator({
		desID:"p"
		,operateor:"="
		,onError:"两次密码不一致,请确认"
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
	<div class="katit3">恭喜您通过了身份验证，请修改您的新密码</div>
    <div class="katit4">修改密码</div>
<form id="form1" name="form" action="<?php echo site_url("changepwd/dochange");?>">
<!-- <input type="submit" value="test" /> -->
  <div class="katab4">
	<div id="msg" class="katit5"><!-- error --></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="katable1 martop25">
  <tr>
    <td align="right">* 设置密码：</td>
    <td><label>
      <input class="kainput8" type="password" name="p" id="p" />
    </label></td>
    <td><div id="pTip" style="width:280px"></div></td>
  </tr>
  <tr>
      <td align="right">&nbsp;</td>
      <td colspan="2" valign="top"><div id="pFixTip">6~16个字符，包括字母、数字、特殊符号，区分大小写</div></td>
  </tr>
  <tr>
    <td align="right">* 确认密码：</td>
    <td><label>
      <input class="kainput8" type="password" name="p2" id="p2" />
    </label></td>
    <td><div id="p2Tip" style="width:280px"></div></td>
  </tr>
  <tr>
      <td align="right">&nbsp;</td>
      <td colspan="2" valign="top"><div id="p2FixTip">请再次输入密码</div></td>
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
		<input type="hidden" id="uid" name="uid" value="<?php echo $userId; ?>" />
		<input type="hidden" id="cid" name="cid" value="<?php echo $userChangePwdId; ?>" />
		<input class="kabut5" type="button" name="button" id="button" value="同意以下协议，提交" />
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