 <?php if($loginUserId == ''){ # 未登录 ?>
 <script type="text/javascript">function pupInit(title){alert("未登录或登录超时，请登录");window.location.hash="top";goTop();title="Login";eval("pup"+title+"();");}</script>
 <?php }else{ # 已登录 ?>
 <script type="text/javascript">function pupInit(title){window.location.hash="top";goTop();eval("pup"+title+"();");}</script>
 <?php } ?>
 <?php 
 	if($loginUserId == ''){ # 未登录
 ?>
<!-- fla start (popMaskLogin) -->
<script src="<?php echo base_url();?>kweb/js/formValidator-4.1.1.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/formValidatorRegex.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/jquery.timer.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kweb/js/popMaskLogin.js" type="text/javascript" charset="UTF-8"></script>
<script type="text/javascript">
$(document).ready(function(){
	//绑定提交按钮
	$("#btnloginLogin").bind("click",function(){ doActionLogin();});
	
	$.formValidator.initConfig({theme:"Default",submitOnce:true,formID:"formloginLogin",
		onError:function(msg){$("#msgLogin").html(msg);},
		submitAfterAjaxPrompt : '有数据正在异步验证，请稍等...',
		buttons: $("#btnloginLogin"),
		debug:false
	});

	$("#lLogin")
	<?php if($kLoginName == ''){?>
	.formValidator({
		onShowText:"请输入登录邮箱"
		,onShow:""
	})
	<?php }?>
	.inputValidator({
		min:1
		,onError:"登录邮箱未输入"
	}).regexValidator({
		regExp:"^([\\w-.]+)@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.)|(([\\w-]+.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(]?)$"
		,onError:"登录邮箱输入不正确"
	});
	
	<?php if($kPWD == '1'){?>
	$("#pLogin").formValidator({
		onShowText:"**********"
	});
	<?php }?>
});
</script>
<div id="popMaskLogin" style="background:#000; opacity:0.6; filter:alpha(opacity=60); width:100%; height:100%; position:absolute; top:0; left:0; display:none;"></div>
<div id="popBoxBodyLogin" style=" position:absolute; top:300px; left:0; width:100%; display:none;">
<div id="popboxLogin" class="popbox flacont5" style="display:none;">

	<form id="formloginLogin" name="form1" action="<?php echo site_url("login/dologin");?>" method="post" target="_blank">
		<!-- <input type="submit" value="test" /> -->
	  <table width="100%" border="0" cellspacing="3" cellpadding="0">
        <tr>
          <td>Email：</td>
          <td><label>
            <input class="kainput2" id="lLogin" name="l" type="text" <?php if($kLoginName != ''){ echo 'value="'.$kLoginName.'"';}?>  />
          </label>
		  </td>
		  <td><span class="r"><a onclick="closeLayerLogin()" href="javascript:void(0)"><img src="<?php echo base_url();?>kweb/images/kaicon5.gif" /></a></span></td>
        </tr>
        <tr>
          <td class="pdtop10">密 码：</td>
          <td colspan="2"><label>
            <input class="kainput2" id="pLogin" name="p" type="password" <?php if($kPWD == ''){ echo 'value="'.$kPWD.'"';}?>/>
          </label></td>
        </tr>
        <tr>
          <td colspan="3" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <label>
          <input type="checkbox" id="r" name="r" value="1" />记住我　</label>
		  <span class="bluef"><a href="<?php echo site_url('register');?>">马上注册</a></span> 
		  <span class="bluef"><a href="<?php echo site_url("changepwd");?>">忘记密码</a></span> &nbsp;
          <input class="kabut2" type="button" id="btnloginLogin" name="btnloginLogin" value="登 录" />
		  <input type="hidden" id="u" name="u" value="<?php echo current_url();?>" />
          </td>
        </tr>
      </table>
	  <div id="msgLogin" style="width:280px"></div>
	</form>

  <div class="clear"></div>
</div>
</div>
<!-- fla end -->
<?php } ?>



 