<script src="<?php echo base_url();?>kweb/js/formValidator-4.1.1.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/formValidatorRegex.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/jquery.timer.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kweb/js/login.js" type="text/javascript" charset="UTF-8"></script>
<script type="text/javascript">
$(document).ready(function(){
	$.formValidator.initConfig({theme:"Default",submitOnce:true,formID:"form1",
		onError:function(msg){$("#msg").html(msg);},
		submitAfterAjaxPrompt : '有数据正在异步验证，请稍等...',
		buttons: $("#button"),
		debug:false
	});

	$("#l")
	<?php if($kLoginName == ''){?>
	.formValidator({
		onShowText:"请输入登录邮箱"
		,onShow:""
	})
	<?php }?>
	.inputValidator({
		min:1
		,onError:"账号未输入"
	})
	.regexValidator({
		regExp:"^([\\w-.]+)@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.)|(([\\w-]+.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(]?)$"
		,onError:"登录邮箱输入不正确"
	});
	
	<?php if($kPWD == '1'){?>
	$("#p").formValidator({
	    onShowText:"**********"
	});
	<?php }?>
});
</script>
<!-- first start -->
<div class="bigcont">
	<div class="katit3">用户登录</div>
    <div class="logintabl">
	<form id="form1" name="form1" action="<?php echo site_url("login/dologin");?>" method="post" target="_blank">
		<table width="95%" border="0" cellspacing="0" cellpadding="0" class="katable2">
		  <tr>
			<td>Email：</td>
			<td><label>
			  <input class="kainput11" id="l" name="l" type="text" <?php if($kLoginName != ''){ echo 'value="'.$kLoginName.'"';}?>  />
			</label></td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>密  码：</td>
			<td><label>
			  <input class="kainput12" id="p" name="p" type="password" <?php if($kPWD == ''){ echo 'value="'.$kPWD.'"';}?>/>
			</label></td>
			<td><font class="f12bline"><a href="<?php echo site_url("changepwd");?>">忘记密码</a></font></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td colspan="2" class="f12"><label>
			  <input type="checkbox" id="r" name="r" value="1" /> 
			记住用户名
			<input type="checkbox" name="rp" id="rp" />
			自动登录</label></td>
			</tr>
		  <tr>
			<td>&nbsp;</td>
			<td><label>
			  <!-- <input type="submit" value="test" /> -->
			  <input class="seabut" type="button" id="button" name="button" value="登 录" />
			  <input type="hidden" id="u" name="u" value="<?php echo $url;?>" />
			</label></td>
			<td>&nbsp;</td>
		  </tr>
		</table>
	</form>
	<div class="pdtop20 f14 redf" id="msg"></div>
    </div>
  <div class="logintabr">
    	<h3>还不是卡秀网用户？<div class="clear"></div><p>现在免费注册成为卡秀网用户，便能立刻享受便宜又放心的购物乐趣</p></h3>
		<div>
		  <input class="loginbut" name="input" type="button" value="注册新用户" onclick="javascript:location.href='<?php echo site_url('register');?>'" />
		</div>
  </div>
    <div class="clear"></div>
</div>
<!-- first end -->
