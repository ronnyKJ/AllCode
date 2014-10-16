<!-- fla start (popMaskStartSpell) -->
<script src="<?php echo base_url();?>kweb/js/formValidator-4.1.1.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/formValidatorRegex.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/jquery.timer.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kweb/js/popMaskStartSpell.js" type="text/javascript" charset="UTF-8"></script>
<script type="text/javascript">
$(document).ready(function(){
	$.formValidator.initConfig({theme:"126",submitOnce:false,formID:"formStartSpell",
		onError:function(msg){alert(msg);},
		submitAfterAjaxPrompt : '有数据正在异步验证，请稍等...',
		buttons: $("#button"),
		debug:false
	});
	
	$("#cn").formValidator({
		onShowFixText:"请输入活动标题"
		,onShow:"请输入活动标题"
		,onCorrect:"您已成功输入活动标题"
	}).inputValidator({
		min:1,max:200
		,onError:"活动标题最大200字以内"
	});
	$("#lu").formValidator({
		onShowFixText:"请输入最大参与人数"
		,onShow:"请输入最大参与人数"
		,onCorrect:"您已成功输入人数限制"
	}).regexValidator({
		 regExp:"intege1"
		 ,dataType:"enum"
		 ,onError:"只能输入数字"
	}).inputValidator({
		min:1,max:4
		,onError:"人数限制最大4位数以内"
	});
	
	$("#sd").inputValidator({
		min:8,max:10
		,onError:"发起时间未选"
	});
	
	$("#ed").inputValidator({
		min:8,max:10
		,onError:"结束时间未选"
	});
	
	$("#m").formValidator({
		onShowFixText:"请输入发起事项"
		,onShow:"请输入发起事项"
		,onCorrect:"您已成功输入发起事项"
	}).inputValidator({
		min:1,max:100
		,onError:"发起事项不能为空且最大100字"
	});
	
	$("#c").formValidator({
		onShowFixText:"请输入活动特点"
		,onShow:"请输入活动特点"
		,onCorrect:"您已成功输入活动特点"
	}).inputValidator({
		min:1,max:100
		,onError:"活动特点不能为空且最大200字"
	});
	
	$("#d").formValidator({
		onShowFixText:"请输入具体细则"
		,onShow:"请输入具体细则"
		,onCorrect:"您已成功输入具体细则"
	}).inputValidator({
		min:1,max:500
		,onError:"具体细则不能为空且最大500字"
	});
	
	$("#tel").formValidator({
		onShowFixText:"请输入联系方式"
		,onShow:"请输入联系方式"
		,onCorrect:"您已成功输入联系方式"
	}).inputValidator({
		min:1,max:20
		,onError:"联系方式不能为空且最大20字"
	});

	$("#QQ").formValidator({
		onShowFixText:"请输入QQ"
		,onShow:"请输入QQ"
		,onCorrect:"您已成功输入QQ"
	})
});

$(document).ready(function(){
	$("#userfile").change(function() {
		//var fn = $("#userfile").val();
		//fn = fn.substring(fn.lastIndexOf('\\')+1,fn.length);
		//$("#filename").val(fn);
		
		$("#idProcess").show();
		$("#userfile").hide();
		$("#uploadForm").submit();
	});
	
	$("#save").click(function() {
		dosave();
	});
})
</script>
<script type="text/javascript">
function Finish(success,imagename){
	  if (success == 1){
		$("#idProcess").hide();
		$("#userfile").show();
		$("#tempimg").attr("src","<?php echo site_url('spell/carduppic?ui=');?>"+ imagename);
		$("#tempimg").show();
		$("#isupi").val("1");
		$("#idMsg").html("上传成功");
		$("#save").show();
	  }else{
		$("#idMsg").html(success);
		$("#idProcess").hide();
		$("#userfile").show();
	  }
}

function dosave(){
	// 锁定按钮
	$("#btnStartSpell").attr("disabled",true);
	$("#reset").attr("disabled",true);
	$("#closeStartSpell").attr("disabled",true);
	$("#save").attr("disabled",true);
	$("#idProcess").show();
	
	//表单参数
	//var iframe = document.frames['tempimg'];
	var iframe = document.getElementById('tempimg').contentWindow;
	//param = $("#test").serialize();
	var x = iframe.document.getElementById('x').value;
	var y = iframe.document.getElementById('y').value;
	var w = iframe.document.getElementById('w').value;
	var h = iframe.document.getElementById('h').value;
	var tempimage = iframe.document.getElementById('tempimage').value;
	
	param = "x="+x+"&y="+y+"&w="+w+"&h="+h+"&tempimage="+tempimage;
	url = "<?php echo site_url("spell/dopreview");?>";
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				timenow = new Date().getTime();
				$("#msg").html(obj.info);
				$("#cpardp").attr("src","<?php echo $this->config->item('UpPathCard').'temp/s2';?>" + obj.data+"?rand="+timenow);
				$("#cip").val(obj.data);
				
				// 解定按钮
				document.getElementById("btnStartSpell").removeAttribute("disabled"); 
				document.getElementById("reset").removeAttribute("disabled"); 
				document.getElementById("closeStartSpell").removeAttribute("disabled"); 
				document.getElementById("save").removeAttribute("disabled"); 
			}
			else
			{
				$("#msg").html("保存出错了");
				
				// 解定按钮
				document.getElementById("btnStartSpell").removeAttribute("disabled"); 
				document.getElementById("reset").removeAttribute("disabled"); 
				document.getElementById("closeStartSpell").removeAttribute("disabled"); 
				document.getElementById("save").removeAttribute("disabled"); 
			}
			$("#idProcess").hide();
		}
	});
}

function dosaveadd(){

	// 锁定按钮
	$("#btnStartSpell").attr("disabled",true);
	$("#reset").attr("disabled",true);
	$("#closeStartSpell").attr("disabled",true);
	$("#save").attr("disabled",true);
	

	// 校验表单 
	if(!$.formValidator.pageIsValid('1')){
		document.getElementById("btnStartSpell").removeAttribute("disabled"); 
		document.getElementById("reset").removeAttribute("disabled"); 
		document.getElementById("closeStartSpell").removeAttribute("disabled"); 
		document.getElementById("save").removeAttribute("disabled"); 
		return;
	}

	// 判断是否要上传图片
	if(	$("#isupi").val() == "1"){// 需要上传图片直接发布
		$("#idProcess").show();
		
		//表单参数
		//var iframe = document.frames['tempimg'];
		var iframe = document.getElementById('tempimg').contentWindow;
		//param = $("#test").serialize();
		var x = iframe.document.getElementById('x').value;
		var y = iframe.document.getElementById('y').value;
		var w = iframe.document.getElementById('w').value;
		var h = iframe.document.getElementById('h').value;
		var tempimage = iframe.document.getElementById('tempimage').value;
		
		param = "x="+x+"&y="+y+"&w="+w+"&h="+h+"&tempimage="+tempimage;
		url = "<?php echo site_url("spell/dopreview");?>";
		$.ajax({ 
			type: "POST",
			url: url, 
			data: param+"&dataType=json",
			dataType: "json",
			success: function(obj){
				if(obj.status)
				{
					timenow = new Date().getTime();
					$("#msg").html(obj.info);
					$("#cpardp").attr("src","<?php echo $this->config->item('UpPathCard').'temp/s2';?>" + obj.data+"?rand="+timenow);
					$("#cip").val(obj.data);
					
					// 发布
					doadd();
				}
				else
				{
					$("#msg").html("保存出错了");
					
					// 解定按钮
					document.getElementById("btnStartSpell").removeAttribute("disabled"); 
					document.getElementById("reset").removeAttribute("disabled"); 
					document.getElementById("closeStartSpell").removeAttribute("disabled"); 
					document.getElementById("save").removeAttribute("disabled"); 
				}
				$("#idProcess").hide();
			}
		});
	}else{ // 无需上传图片直接发布
		doadd();
	}}

function doadd(){
	param = $("#formStartSpell").serialize();
	url = $("#formStartSpell").attr("action");
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			// alert(obj.status);
			if(obj.status)
			{
				alert("活动发布成功");
				initdoStartSpell();
				location.reload();
				
				// 解定按钮
				document.getElementById("btnStartSpell").removeAttribute("disabled"); 
				document.getElementById("reset").removeAttribute("disabled"); 
				document.getElementById("closeStartSpell").removeAttribute("disabled"); 
				document.getElementById("save").removeAttribute("disabled"); 
			}
			else
			{
				alert("保存出错了");
				
				// 解定按钮
				document.getElementById("btnStartSpell").removeAttribute("disabled"); 
				document.getElementById("reset").removeAttribute("disabled"); 
				document.getElementById("closeStartSpell").removeAttribute("disabled"); 
				document.getElementById("save").removeAttribute("disabled"); 
			}
		}
	});
}
</script>
<div id="popMaskStartSpell" style="background:#000; opacity:0.6; filter:alpha(opacity=60); width:100%; height:100%; position:absolute; top:0; left:0; display:none;"></div>
<div id="popBoxBodyStartSpell" style=" position:absolute; top:30px; left:0; width:100%; display:none;">
<div id="popboxStartSpell" class="popbox flacont1" style="display:none;">
 <script type="text/javascript">
	$(document).ready(function(){
		//绑定提交按钮
		$("#btnStartSpell").bind("click",function(){ dosaveadd();});
		$("#closeStartSpell").bind("click",function(){ initdoStartSpell();});
	});
 </script>
<style type="text/css">
.disable{ background-color:#E3E3E3;}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><span class="r"><a onclick="initdoStartSpell()" href="javascript:void(0)"><img src="<?php echo base_url();?>kweb/images/kaicon5.gif" /></a></span>
	</td>
  </tr>
 </table>
<iframe id="tempimg" src="<?php echo site_url('spell/carduppic?ui=5ab7585f9750dcb2ce6539145365434f.jpg');?>" width="600px" height="326px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" style="display:none; padding-bottom:10px;"></iframe>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="160" valign="top"><div class="defaltpic"><img id="cpardp" src="<?php echo base_url();?>kweb/images/defaltpic.gif" />
	<p>
	<form id="uploadForm" action="<?php echo site_url("spell/doupphoto");?>" enctype="multipart/form-data" method="post" target="upload_target">
	<!-- target="upload_target" -->
	<input type="file" id="userfile" name="userfile" class="seabut3" size="30"  />
	<img id="idProcess" style="display:none;" src="<?php echo base_url();?>kweb/images/loading.gif" />
	<br />
	<input class="seabut" type="button" id="save" name="save" value="上传预览" style="display:none" />
	</form>
	<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
	</p>
	<p id="msg" class="midbut1"></p><p id="idMsg" class="midbut1"></p>
	</div>
	<div class="midbut1">
		<p>
		上传卡图片说明： <br />
		1. gif | jpg | png <br />
		2. 图片将被剪切372px*243px <br />
		3. 图片可编辑区域为600px*326px <br />
		4. 图片大小限制5M <br />
		</p>
	</div>
	</td>
    <td>
	<form id="formStartSpell" action="<?php echo site_url('spell/doaddspell');?>" target="_blank" method="post">
	<!-- <input type="submit" value="test" />  --> 
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30px">发&nbsp;&nbsp;起&nbsp;&nbsp;人： <label><?php echo $nickname;?></label></td>
      </tr>
	  <tr>
        <td height="30px">活动标题：
          <label>
          <input type="text" id="cn" name="cn" size="50" maxlength="200" />
          <font id="cnTip" class="grayf"></font></label></td>
      </tr>
      <tr>
        <td height="30px">人数限制：
          <label>
          <input type="text" id="lu" name="lu" size="5" maxlength="4" />
          <font id="luTip" class="grayf"></font></label></td>
        </tr>
      <tr>
        <td height="30px">发起时间：
		<label>
          <input type="text" id="sd" name="sd"  class="kainput10 Wdate" readonly="readonly"/>
          <font id="sdTip" class="grayf"></font></label>
		  <script type="text/javascript">ESONCalendar.bind("sd");</script>
		  
		  结束时间：
		  <label>
          <input type="text" id="ed" name="ed"  class="kainput10 Wdate" readonly="readonly"/>
          <font id="edTip" class="grayf"></font></label>
		  <script type="text/javascript">ESONCalendar.bind("ed");</script>
		</td>
        </tr>
      <tr>
        <td height="30px">发起事项：
		  <label>
          <input type="text" id="m" name="m" size="50" maxlength="100" />
          <font id="mTip" class="grayf"></font></label></td>
        </tr>
	  <tr>
        <td height="30px">活动特点：
		  <label>
          <input type="text" id="c" name="c" size="50" maxlength="200" />
          <font id="cTip" class="grayf"></font></label></td>
        </tr>
      <tr>
        <td height="30px" valign="top">具体细则：
		  <label>
		  <textarea name="d" id="d" cols="50" rows="7"></textarea>
          <font id="lTip" class="grayf"></font></label>
		</td>
		<td></td>
        </tr>
	  <tr>
        <td height="30px">联系方式：
		  <label>
          <input type="text" id="tel" name="tel" size="15" maxlength="20" />
          </label>
		  
		  QQ：
		  <label>
          <input type="text" id="QQ" name="QQ" size="15" maxlength="20" />
          </label>
		  
		  <font id="telTip" class="grayf"></font>
		  <font id="QQTip" class="grayf"></font>
		</td>
        </tr>
      <tr>
        <td align="center"><label>
	    <input type="hidden" id="isupi" name="isupi" value="0" />
 	    <input type="hidden" id="cip" name="cip" />
		<input type="hidden" id="uid" name="uid" value="<?php echo $userId;?>" />
		<input class="seabut" name="btnStartSpell" id="btnStartSpell" type="button" value="确认提交" />　
        <input class="seabut" type="reset" id="reset" name="reset" value="重新编辑" />　
		<input class="but10"  name="closeStartSpell" id="closeStartSpell" type="button" value="返回个人首页" />
        </label></td>
        </tr>
    </table>
	</form>
	</td>
  </tr>
</table>
  <div class="clear"></div>
</div>
</div>
<!-- fla end -->