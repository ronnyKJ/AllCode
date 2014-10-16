<script src="<?php echo base_url();?>kweb/js/upphoto.js" type="text/javascript"></script>
<script type="text/javascript">
function Finish(success,imagename){
	timenow = new Date().getTime();
	if (success == 1){
		$("#idProcess").hide();
		$("#userfile").show();
		$("#tempimg").attr("src","<?php echo site_url('member/useruppic?ui=');?>"+ imagename+"&rand="+timenow);
		$("#tempimg").show();
		$("#tempimage").val(imagename);
		alert("上传成功");
		$("#idMsg").html("上传成功");
		$("#save").show();
	}else{
		$("#idMsg").html(imagename);
		$("#idProcess").hide();
	}
}

function dosave(){
	$("#idProcess2").show();
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
	url = "<?php echo site_url("member/dosave");?>";
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			//alert(obj.status);
			if(obj.status)
			{
				timenow = new Date().getTime();
				$("#msg").html(obj.info);
				$("#b").attr("src","<?php echo $this->config->item('UpPathAvatar').'b/';?>" + obj.data+"?rand="+timenow);
				$("#s1").attr("src","<?php echo $this->config->item('UpPathAvatar').'s1/';?>" + obj.data+"?rand="+timenow);
				$("#s2").attr("src","<?php echo $this->config->item('UpPathAvatar').'s2/';?>" + obj.data+"?rand="+timenow);
				alert("上传成功");
				location.href="<?php echo site_url('member');?>";
			}
			else
			{
				$("#msg").html("保存出错了");
			}
			$("#idProcess2").hide();
		}
	});
}
</script>
<!-- second start -->
<div class="bigcont marbot30">
	<!-- left -->
	<div class="leftcont1 martop25">
		<form id="uploadForm" action="<?php echo site_url("member/doupphoto");?>" enctype="multipart/form-data" 
		method="post" target="upload_target">
		<!--  target="upload_target" -->
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td colspan="3">
			<input type="file" id="userfile" name="userfile" class="seabut3"  />
			<br />
			<input class="seabut" type="button" id="save" name="save" value="保 存" style="display:none; margin-top:10px;" />
			<img id="idProcess2" style="display:none;" src="<?php echo base_url();?>kweb/images/loading.gif" /><br />
			<span id="msg" style="color:red" ></span> 
			<br />
			<img id="idProcess" style="display:none;" src="<?php echo base_url();?>kweb/images/loading.gif" />
			<font class="grayf"><span id="idMsg" style="color:red"><?php echo $uploadError ?></span>支持JPG、GIF、PNG图片文件，且文件大小5M。请注意中小尺寸的头像是否</font>
			</td>
		  </tr>
		  <tr>
			<td width="350px" valign="top" class="pdtop30">
			<iframe id="tempimg" src="<?php echo site_url('member/useruppic?ui=5ab7585f9750dcb2ce6539145365434f.jpg');?>" width="300px" height="200px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
			</td>
			<td valign="top" width="230" class="pdtop30">
			  <p class="midt"><img id="b" class="bor" src="<?php echo $bkAvatarImage;?>" width="180" height="180" />大尺寸头像，180*180像素</p></td>
			<td valign="top" class="pdtop30"><div class="kaupic1"><img id="s1" class="bor" src="<?php echo $s1kAvatarImage;?>" width="50" height="50" /><p>中尺寸头像
		50*50像素
		(自动生成)</p></div><div class="kaupic1"><img id="s2" class="bor" src="<?php echo $s2kAvatarImage;?>" width="40" height="40" /><p>小尺寸头像
		40*40像素
		(自动生成)</p></div></td>
		  </tr>
		</table>
		</form>
		<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
		<div class="clear"></div>
	</div>
	<!-- right -->
	<div class="rightcont6 martop25">
		<div class="katit1"><h3>最新会员</h3><div class="clear"></div></div>
		<ul class="karul19">
			<?php if($newUserInfo!=null){foreach ($newUserInfo as $row):?>
			<li><a href="<?php echo site_url('member/other/'.$row['id']);?>"><img src="<?php echo $row['kAvatarImage'];?>" alt="<?php echo $row['nickname'];?>" width="50px" height="50px" /></a></li>
			<?php endforeach;}?>
		</ul>
		<!--<div class="advd"><img src="<?php echo base_url();?>kweb/images/kadv12.jpg" /></div>-->
		<div class="clear"></div>
	</div>
<div class="clear"></div>
</div>
<!-- second end -->
