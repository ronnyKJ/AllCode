<script src="<?php echo base_url();?>kweb/js/formValidator-4.1.1.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/formValidatorRegex.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>kweb/js/jquery.timer.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kweb/js/ESONCalendar.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>kweb/js/upphoto.js" type="text/javascript"></script>
<script type="text/javascript">
var gloabDistrictId = "";
window.onload=function(){
	var districtId = "<?php echo $areaDistrictId;?>";
	gloabDistrictId = districtId;
	var urbanId = "<?php echo $areaUrbanId;?>";
	if(districtId!=""){
		areaSelect('<?php echo site_url('kadmin/mainfurban/getparent');?>/', districtId, urbanId);
	}
}
//地区连动
function areaSelect(url,districtId,urbanId){
	if(gloabDistrictId == districtId){return;}else{gloabDistrictId = districtId;}

	//表单参数
	param = ""
	url = url+"/"+districtId;
	//$("#district").attr("disabled",true);
	//$("#urban").attr("disabled",true);
	$("#urban").empty(); 
	//alert(url);
	$.ajax({ 
		url: url, 
		data: "",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				//alert(obj.data);
				$("#urban").append("<option value=''>请选择</option>"); 
				//循环取json中的数据,并呈现在列表中
				var json = obj.data;
				$.each(json,function(i,n){
					if(urbanId == json[i].id)
						$("#urban").append("<option value='"+json[i].id+"' selected='selected'>"+json[i].name+"</option>");
					else
						$("#urban").append("<option value='"+json[i].id+"'>"+json[i].name+"</option>");
				});
			}
			//$("#district").removeAttr("disabled");
			//$("#urban").removeAttr("disabled");
			
		},
		error: function(){
				$("#urban").append("<option value=''>请选择</option>"); 
				//$("#district").removeAttr("disabled");
				//$("#urban").removeAttr("disabled");
		}
	});
}
</script>
<script type="text/javascript">
$(document).ready(function(){
	$.formValidator.initConfig({theme:"126",submitOnce:false,formID:"formcard",
		onError:function(msg){alert(msg);},
		submitAfterAjaxPrompt : '有数据正在异步验证，请稍等...',
		buttons: $("#button"),
		debug:false
	});
	$("#cn").formValidator({
		onShow:"请输入卡的名字"
		,onCorrect:"您已成功输入卡名字"
		<?php if($name == ''){?>
		,onShowText:"请输入卡的名字"
		<?php } ?>
	}).inputValidator({
		min:6
		,max:200
		,onError:"你输入的卡名称长度不正确,请确认"
	});
	$(":checkbox[name='cbxct[]']").formValidator({
		tipID:"cbxctTip"
		,onShow:"请选择卡的种类(至少选择1个)"
		,onFocus:"至少选择1个"
		,onCorrect:"恭喜你,你选了卡的种类"
	}).inputValidator({
		min:1,max:6
		,onError:"你选的个数不对(至少选择1个)"
	});
	
	
	$(":checkbox[name='cbxcu[]']").formValidator({
		tipID:"cbxcuTip"
		,onShow:"请选择卡的用途(至少选择1个)"
		,onFocus:"至少选择1个"
		,onCorrect:"恭喜你,你选了卡的用途"
	}).inputValidator({
		min:1,max:7
		,onError:"你选的个数不对(至少选择1个)"
	});
	
	$(":checkbox[name='cbxcts[]']").formValidator({
		tipID:"cbxctsTip"
		,onShow:"请选择卡的交易(至少选择1个)"
		,onFocus:"至少选择1个"
		,onCorrect:"恭喜你,你选了卡的交易"
	}).inputValidator({
		min:1,max:3
		,onError:"你选的个数不对(至少选择1个)"
	});
	
	$("#district").formValidator({
		tipID:"districtTip"
		,onShow:"请选择地点"
		,onFocus:"至少选择2个"
		,onCorrect:"恭喜你,你选了地点"
	}).inputValidator({
		min:1
		,onError:"你选的个数不对(至少选择2个)"
	});
	
	$("#p").formValidator({
		tipID:"pTip"
		,onShow:"请输入卡的市场价"
		,onFocus:"请输入卡的市场价"
		,onCorrect:"恭喜你,你填写了卡的市场价"
	}).regexValidator({
		 regExp:"decmal3"
		 ,dataType:"enum"
		 ,onError:"只能输入数字"
	});
	
	
	$("#sp").formValidator({
		tipID:"spTip"
		,onShow:"请输入卡的售价"
		,onFocus:"请输入卡的售价"
		,onCorrect:"恭喜你,你填写了卡的售价"
	}).regexValidator({
		 regExp:"decmal3"
		 ,dataType:"enum"
		 ,onError:"只能输入数字"
	});
	
	$("#period").formValidator({
		tipID:"periodTip"
		,onShow:"请选择有效期"
		,onFocus:"请选择有效期"
		,onCorrect:"恭喜你,你选了有效期"
	}).inputValidator({
		min:8,max:10
		,onError:"有效期未选择"
	});
	
	$(":checkbox[name='cbxwf[]']").formValidator({
		tipID:"cbxwfTip"
		,onShow:"请选择拼卡方式(至少选择1个)"
		,onFocus:"至少选择1个"
		,onCorrect:"恭喜你,你选了拼卡方式"
	}).inputValidator({
		min:1,max:2
		,onError:"你选的个数不对(至少选择1个)"
	});
	
	<?php if($remarks == ''){?>
	$("#txtremarks").formValidator({
		onShowText:"例如：卡号，使用规则等"
	})
	<?php }?>
	
	
	
});
</script>
<script type="text/javascript">
function Finish(success,imagename){
	  if (success == 1){
		$("#idProcess").hide();
		$("#userfile").show();
		$("#tempimg").attr("src","<?php echo site_url('card/carduppic?ui=');?>"+ imagename);
		$("#tempimg").show();
		$("#isupi").val("1");
		// $("#tempimage").val(imagename);
		// alert("上传成功");
		$("#idMsg").html("上传成功");
		$("#save").show();
	  }else{
		$("#idMsg").html(success);
		$("#idProcess").hide();
		$("#userfile").show();
	  }
}

function dosave(){
	$("#idProcess").show();
	//表单参数
	//var iframe = document.frames['tempimg'];
	var iframe = document.getElementById('tempimg').contentWindow;
	//param = $("#test").serialize();
	var x = iframe.document.getElementById('x').value;
	var y = iframe.document.getElementById('y').value;
	var w = iframe.document.getElementById('w').value;
	var h = iframe.document.getElementById('h').value;
	var userId = iframe.document.getElementById('userId').value;
	var tempimage = iframe.document.getElementById('tempimage').value;
	
	param = "x="+x+"&y="+y+"&w="+w+"&h="+h+"&userId="+userId+"&tempimage="+tempimage;
	url = "<?php echo site_url("card/dopreview");?>";
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
			}
			else
			{
				$("#msg").html("保存出错了");
			}
			$("#idProcess").hide();
		}
	});
}


function dosaveadd(){

	// 校验表单 
	if(!$.formValidator.pageIsValid('1')){return;}

	// 判断是否要上传图片
	if(	$("#isupi").val() == "1"){// 需要上传图片直接发布
	
		$("#idProcess").show();
			
	
		//表单参数
		// var iframe = document.frames['tempimg'];
		var iframe = document.getElementById('tempimg').contentWindow;
		//param = $("#test").serialize();
		var x = iframe.document.getElementById('x').value;
		var y = iframe.document.getElementById('y').value;
		var w = iframe.document.getElementById('w').value;
		var h = iframe.document.getElementById('h').value;
		var userId = iframe.document.getElementById('userId').value;
		var tempimage = iframe.document.getElementById('tempimage').value;
		
		param = "x="+x+"&y="+y+"&w="+w+"&h="+h+"&userId="+userId+"&tempimage="+tempimage;
		url = "<?php echo site_url("card/dopreview");?>";
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
					
					doadd();
				}
				else
				{
					$("#msg").html("保存出错了");
				}
				$("#idProcess").hide();
			}
		});
	}else{ // 无需上传图片直接发布
		doadd();
	}
}

function doadd(){
	param = $("#formcard").serialize();
	url = $("#formcard").attr("action");
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			// alert(obj.status);
			if(obj.status)
			{
				window.location.hash="top";
				pup('popbox01');
			}
			else
			{
				alert("保存出错了");
			}
		}
	});
}
</script>

<!-- first start -->
<div class="bigcont">
	<!-- left -->
  <div class="leftcont4">
   		<div class="katab3c"><img id="cpardp" src="<?php echo $cardImagePathURL;?>" /></div>
        <div class="midbut">
			<form id="uploadForm" action="<?php echo site_url("card/doupphoto");?>" enctype="multipart/form-data" method="post" target="upload_target">
			<!-- target="upload_target" -->
			<input type="file" id="userfile" name="userfile" class="seabut3" size="30"  />
			<img id="idProcess" style="display:none;" src="<?php echo base_url();?>kweb/images/loading.gif" />
			<br />
			<input class="seabut" type="button" id="save" name="save" value="上传预览" style="display:none" />
			</form>
			<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
			<p id="msg" class="midbut1"></p><p id="idMsg" class="midbut1"><?php echo $uploadError ?></p>
        </div>
		<div class="midbut1">
			<p>
			上传卡图片说明： <br />
			1. gif | jpg | png <br />
			2. 图片将被剪切568px*289px <br />
			3. 图片可编辑区域为700px*370px <br />
			4. 图片大小限制5M <br />
			</p>
		</div>
    	<div class="clear"></div>
  </div>
    <!-- right -->
  <div class="rightcont4">
	<iframe id="tempimg" src="http://ceopen-pct2:90/kx/index.php/card/carduppic?ui=5ab7585f9750dcb2ce6539145365434f.jpg" width="700px" height="370px"
		frameborder="0" scrolling="no" marginheight="0" marginwidth="0" style="display:none; padding-bottom:20px;"></iframe>
  <form id="formcard" name="formcard" action="<?php echo site_url("card/doaddshow");?>" method="post" target="_blank">
	<!--  <input type="button" value="asfasdfasdf" onclick="dosaveadd();$('#formcard').submit()" /> --> 
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="f14">
  <tr>
    <td width="11%" valign="top">卡的名字：</td>
    <td>
	<input name="cn" id="cn" type="text" size="50" maxlength="200" value="<?php echo $name;?>" />
	<div id="cnTip" style="width:300px"></div>
	</td>
  </tr>
  <tr>
    <td class="pdtop20" valign="top">卡的种类：</td>
    <td class="pdtop20">
    <input type="checkbox" name="cbxct[]" id="cbxct1" value="1" <?php if(strpos(','.$cardType.',',',1,')!==false){echo 'checked="checked"';}?> />餐饮　
    <input type="checkbox" name="cbxct[]" id="cbxct2" value="2" <?php if(strpos(','.$cardType.',',',2,')!==false){echo 'checked="checked"';}?> />购物　
    <input type="checkbox" name="cbxct[]" id="cbxct3" value="3" <?php if(strpos(','.$cardType.',',',3,')!==false){echo 'checked="checked"';}?> />丽人　
    <input type="checkbox" name="cbxct[]" id="cbxct4" value="4" <?php if(strpos(','.$cardType.',',',4,')!==false){echo 'checked="checked"';}?> />休闲　
    <input type="checkbox" name="cbxct[]" id="cbxct5" value="5" <?php if(strpos(','.$cardType.',',',5,')!==false){echo 'checked="checked"';}?> />运动
    <input type="checkbox" name="cbxct[]" id="cbxct6" value="6" <?php if(strpos(','.$cardType.',',',6,')!==false){echo 'checked="checked"';}?> />旅游　
	<div id="cbxctTip" style="width:300px"></div>
    </td>
  </tr>
  <tr>
    <td class="pdtop20" valign="top">卡的用途：</td>
    <td class="pdtop20"><label>
    <input type="checkbox" name="cbxcu[]" id="cbxcu1" value="1" <?php if(strpos(','.$cardUse.',',',1,')!==false){echo 'checked="checked"';}?> />打折　
    <input type="checkbox" name="cbxcu[]" id="cbxcu2" value="2" <?php if(strpos(','.$cardUse.',',',2,')!==false){echo 'checked="checked"';}?> />会员　
    <input type="checkbox" name="cbxcu[]" id="cbxcu3" value="3" <?php if(strpos(','.$cardUse.',',',3,')!==false){echo 'checked="checked"';}?> />提货卡　
    </label>
	<br />
	<input type="checkbox" name="cbxcu[]" id="cbxcu4" value="4" <?php if(strpos(','.$cardUse.',',',4,')!==false){echo 'checked="checked"';}?> />储值　
    <input type="checkbox" name="cbxcu[]" id="cbxcu5" value="5" <?php if(strpos(','.$cardUse.',',',5,')!==false){echo 'checked="checked"';}?> />积分　
    <input type="checkbox" name="cbxcu[]" id="cbxcu6" value="6" <?php if(strpos(','.$cardUse.',',',6,')!==false){echo 'checked="checked"';}?> />体验卡　
    <input type="checkbox" name="cbxcu[]" id="cbxcu7" value="7" <?php if(strpos(','.$cardUse.',',',7,')!==false){echo 'checked="checked"';}?> />VIP会员卡
	<div id="cbxcuTip" style="width:300px"></div>
	</td>
  </tr>
  <tr>
    <td class="pdtop20" valign="top">卡的交易：</td>
    <td class="pdtop20"><label>
      <input type="checkbox" name="cbxcts[]" id="cbxcts1" value="1" <?php if(strpos(','.$cardTtransactions.',',',1,')!==false){echo 'checked="checked"';}?> />储值卡</label>
	<br />
    <label>
		<input type="checkbox" name="cbxcts[]" id="cbxcts2" value="2" <?php if(strpos(','.$cardTtransactions.',',',2,')!==false){echo 'checked="checked"';}?> />提货卡　　
    </label>
	<br />
	<label>
		<input type="checkbox" name="cbxcts[]" id="cbxcts3" value="3" <?php if(strpos(','.$cardTtransactions.',',',3,')!==false){echo 'checked="checked"';}?> />礼品卡
    </label>
	<div id="cbxctsTip" style="width:300px"></div>
	</td>
  </tr>
  <tr>
    <td class="pdtop20" valign="top">地&nbsp;&nbsp;&nbsp;&nbsp;点：</td>
    <td class="pdtop20">
	<select class="kainput3">
	  <option>北京</option>
	</select>
	  <label>
	  <select id="district" name="districtId" onChange="areaSelect('<?php echo site_url('kadmin/mainfurban/getparent');?>',this.value,'')">
		<option value="" <?php if($areaDistrictId==''){echo 'selected="selected"';}?>>请选择</option>
		<?php foreach ($districtRows as $row):?>
		<option value="<?php echo $row['id'];?>" <?php echo $row['id']== $areaDistrictId ? 'selected="selected"' : '';?>><?php echo $row['name'];?></option>
		<?php endforeach;?>
	  </select>
	  </label>
	  <label>
	  <select id="urban" name="urbanId">
		<option value="" selected="selected">请选择</option>
	  </select>
	  </label>
	  <div id="districtTip" style="width:300px"></div></td>
  </tr>
  <tr>
    <td class="pdtop20" valign="top">市 场 价：</td>
    <td class="pdtop20"><label>
		<input name="p" id="p" type="text" size="10" maxlength="10" value="<?php echo $price;?>" />
		<div id="pTip" style="width:300px"></div>
    </label>
	</td>
  </tr>
  <tr>
    <td class="pdtop20" valign="top">卡的售价：</td>
    <td class="pdtop20"><label>
		<input name="sp" id="sp" type="text" size="10" maxlength="10" value="<?php echo $sellingPrice;?>" />
		<div id="spTip" style="width:300px"></div>
    </label>
	</td>
  </tr>
  <tr>
    <td class="pdtop20" valign="top">有 效 期：</td>
    <td class="pdtop20"><label>
	  <input class="kainput10 Wdate" type="text" name="period" id="period" value="<?php 
	  if($period==''){$now=getdate();$newdate1 = strtotime($now['year'].'-'.$now['mon'].'-'.$now['mday']);echo date('Y-m-d', $newdate1);}
	  else{echo $period;}
	  ?>" />（ 点击输入框显示日历 ）</label>
	  <script type="text/javascript">ESONCalendar.bind("period");</script>
    </label>
	<div id="periodTip" style="width:300px"></div></td>
  </tr>
  <tr>
  <td class="pdtop20" valign="top">拼卡方式：</td>
    <td class="pdtop20"><label>
      <input type="checkbox" name="cbxwf[]" id="cbxwf1" value="1" <?php if(strpos(','.$wayFight.',',',1,')!==false){echo 'checked="checked"';}?> />打折</label>
  	<br />
  	<label>
	  <input type="checkbox" name="cbxwf[]" id="cbxwf2" value="2" <?php if(strpos(','.$wayFight.',',',2,')!==false){echo 'checked="checked"';}?> />积分</label>
	<div id="cbxwfTip" style="width:300px"></div>
	</td>
  </tr>
  <tr>
    <td valign="top" class="pdtop20">备　　注：</td>
    <td class="pdtop20"><label>
      <textarea name="txtremarks" id="txtremarks" cols="50" rows="7"><?php echo $remarks;?></textarea>
    </label></td>
  </tr>
  <tr>
    <td class="pdtb20">&nbsp;</td>
    <td class="pdtb20"><label>
	  <input type="hidden" id="isupi" name="isupi" value="0" />
	  <input type="hidden" id="cip" name="cip" value="<?php echo $cardImagePath;?>" />
	  <input type="hidden" id="id" name="id" value="<?php echo $id;?>" />
	  <input type="hidden" id="uid" name="uid" value="<?php echo $userId;?>" />
	  <input class="seabut" type="button" name="btnAdd" id="btnAdd" value="提交" onclick="dosaveadd()" />
      <input class="seabut" type="reset" name="btnReset"id="btnReset"  value="重新编写" />
    </label></td>
  </tr>
</table>
 </form>
  </div>
<div class="clear"></div>
</div>
<!-- first end -->

<!-- fla start -->
<div id="popMask" style="background:#000; opacity:0.6; filter:alpha(opacity=60); width:100%; height:100%; position:absolute; top:0; left:0; display:none;"></div>
<div id="popBox" style=" position:absolute; top:200px; left:0; width:100%; display:none;">
<div id="popbox01" class="popbox flacont2" style="display:none;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><strong class="redf">恭喜您，已经提交成功，请选择下一步。</strong></td>
  </tr>
  <tr>
    <td class="pdtop30" align="center"><label>
	  <?php if($id==''){?>
      <input class="seabut" type="button" value="继续添加" onclick="location.href='<?php echo site_url("card/upshow");?>'" name="btnN" id="btnN" />　
	  <?php } ?>
      <input class="seabut" type="button" value="返回首页" onclick="location.href='<?php echo site_url("member");?>'" name="btnH" />
    </label></td>
  </tr>
</table>
  <div class="clear"></div>
</div>
</div>
<!-- fla end -->