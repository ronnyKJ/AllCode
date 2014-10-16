<script src="<?php echo base_url();?>kweb/js/formValidator-4.1.1.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/formValidatorRegex.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/jquery.timer.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kweb/js/register.js" type="text/javascript" charset="UTF-8"></script>
<script type="text/javascript">
$(document).ready(function(){
	$.formValidator.initConfig({theme:"126",submitOnce:true,formID:"form1",
		onError:function(msg){alert(msg);},
		submitAfterAjaxPrompt : '有数据正在异步验证，请稍等...',
		buttons: $("#button"),
		debug:false
	});
	$("#l").formValidator({
		onShowFixText:"2~12个字符，包括汉字、字母、数字、下划线"
		,onShowText:"请输入昵称"
		,onShow:"请输入昵称"
		,onCorrect:"该昵称可以注册"
	}).inputValidator({
		min:2
		,max:12
		,onError:"你输入的昵称长度不正确,请确认"
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
		url : "<?php echo site_url("register/checkloginname");?>",
		success : function(data){
	        if( data=='1' > 0 ) return true;
			else return false;
		},
		//buttons: $("#button"),
		error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
		onError : "该邮箱不可用，请更换邮箱",
		onWait : "正在进行合法性校验，请稍候...",
		complete : function(){}
	});
	
	$("#t").formValidator({
		onShowText:"手机、公司电话、住宅电话"
	});
	
	$("#r").formValidator({
	    onShowText:"可不填"
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
</script>
<!-- first start -->
<div class="bigcont">
	<div class="katit3">注册新用户</div>
    <div class="katit4">个人用户</div>
<form id="form1" name="form" action="<?php echo site_url("register/doreg");?>">
<!-- <input type="submit" value="test" /> -->
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
      <td colspan="2" valign="top"><div id="eFixTip">请输入您的邮箱，该邮箱将会用来登录卡网站的</div></td>
  </tr>
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
    <td width="200px" align="right">* 昵称：</td>
    <td><label>
      <input class="kainput8" type="text" name="l" id="l" />
    </label></td>
    <td><div id="lTip" style="width:280px"></div></td>
  </tr>
  <tr>
      <td align="right">&nbsp;</td>
      <td colspan="2" valign="top"><div id="lFixTip">包括汉字、字母、数字、下划线，以字母开头，字母或数字结尾</div></td>
  </tr>
  <tr>
    <td align="right">电话：</td>
    <td><label>
      <input class="kainput8" type="text" name="t"  id="t" />
    </label></td>
    <td><div id="tTip" style="width:280px"></div></td>
  </tr>
  <tr>
    <td align="right">推荐人用户名：</td>
    <td><label>
      <input class="kainput8" name="r" type="text" id="r" />
    </label></td>
    <td><div id="rTip" style="width:280px"></div></td>
  </tr>
  <tr>
    <td align="right" valign="top">验证码：</td>
    <td ><label>
      <input class="kainput9" type="text" name="v" id="v" /> <img id="verify" name="verify" src="<?php echo base_url();?>kweb/verify.php" width="65" height="25" /> 
      <a href="javascript:void(0)" onclick="jQuery('#verify').click()"><font class="grayf">看不清?</font><font class="bluef">换一张</font></a></label></td>
	  <td valign="top"><div id="vTip" style="width:280px"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><label>
      <input class="kabut5" type="button" name="button" id="button" value="同意以下协议，提交" />
    </label>
	<img id="idProcess" style="display:none;" src="<?php echo base_url();?>kweb/images/loading.gif" />
	</td>
    </tr>
  <tr>
    <td colspan="3" class="pdtop20"><label>
      <textarea class="kainput10r" name="textarea" id="textarea" cols="45" rows="5" readonly="readonly">   卡秀网（www.kashow365.com），所有刊登内容，以及所提供的信息资料，目的是为了更好地服务访问者，本网站不保证所有信息、文本、图形、链接及其它项目的绝对准确性和完整性，仅供访问者参照使用。在网站中，用户发表的文章或图片仅代表作者本人观点，与本网站立场无关，作者文责自负。
    网站会员之间通过本网站相识、交往中所发生或可能发生的任何心理、生理上的伤害和经济上的损失，本网站不承担任何责任。会员因为违反本社区规定而触犯中华人民共和国法律的，责任自负，本网站不承担任何责任。由于非故意及不可抗拒的原因（含系统维护和升级），导致的用户数据丢失、服务暂停或停止，本网站不承担赔偿及其他连带的法律责任。
    如您（单位或个人）认为本网站某部分内容有侵权嫌疑，敬请立即通知我们，我们将在第一时间予以更改或删除。
    凡以任何方式登陆本网站或直接、间接使用本网站资料者，视为自愿接受本网站声明的约束。本声明未涉及的问题参见国家有关法律法规，当本声明与国家法律法规冲突时，以国家法律法规为准。
</textarea>
    </label></td>
    </tr>
</table>

  </div>
  </form>
    <div class="clear"></div>
</div>
<!-- first end -->