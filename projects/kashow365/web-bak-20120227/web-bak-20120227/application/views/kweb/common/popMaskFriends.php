<!-- fla start (popMaskFriends) -->
<script src="<?php echo base_url();?>kweb/js/popMaskFriends.js" type="text/javascript" charset="UTF-8"></script>
<div id="popMaskFriends" style="background:#000; opacity:0.6; filter:alpha(opacity=60); width:100%; height:100%; position:absolute; top:0; left:0; display:none;"></div>
<div id="popBoxBodyFriends" style=" position:absolute; top:150px; left:0; width:100%; display:none;">
<div id="popboxFriends" class="popbox flacont1" style="display:none;">
<script type="text/javascript">
function doAjax(url){
	var n=1;
	// 分离页面 '/index.php/member?n=2'
	var regExp = /n=(\d+)/ig;
	if(regExp.test(url)){
		regExp = /n=(\d+)/ig;
		n = regExp.exec(url)[1];
	}

	//表单参数
	var uid="<?php echo $loginUserId;?>";
	param = "uid="+uid+"&n="+n;
	url = "<?php echo site_url("member/doajaxforfriend");?>";
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				$("#umdata").empty();
				$("#umdata").append(obj.data);
			}
			else
			{
				alert(obj.info);
			}
		}
	});
}
function Finish(success,imagename){
	  if (success == 1){
		initdoFriends();
	  }else{
	  }
}

$(document).ready(function(){
	$("#checkall").click(function() { 
		if($("#checkall").attr("checked") == "checked") { // 全选 
			$("input[name='uf[]']").each(function(i) { 
				$(this).attr("checked", true); 
			}); 
		}else{
			$("input[name='uf[]']").each(function(i) { 
				$(this).attr("checked", false); 
			});
		}
	}); 
}); 
</script> 

<style type="text/css">
.disable{ background-color:#E3E3E3;}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><span class="r"><a onclick="initdoFriends()" href="javascript:void(0)"><img src="<?php echo base_url();?>kweb/images/kaicon5.gif" /></a></span><strong class="blankf">请选择好友:</strong>
	</td>
  </tr>
 </table>
<form id="formFriends" action="#" method="post" target="doFriends">
<!-- target="doFriends" -->
	 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fltabc">
	  <tr>
		<td width="200px" valign="top" height="220px">
			<div id="umdata" class="flacont3">
				<ul class="kaul18a kaul18as">
				<?php if(count($friendsData) == 0){echo '暂无好友';}
					  else{?>
				<?php foreach ($friendsData as $row):?>
				<li>
					<a href="<?php echo site_url('member/other/'.$row['friendUserId']);?>"><img src="<?php echo $row['kAvatarImage'];?>" /></a>
					<div><input name="uf[]" type="checkbox" value="<?php echo $row['friendUserId'];?>" /><?php echo $row['nickname'];?></div>
				</li>
				<?php endforeach;?>
				</ul>
				<div class="clear"></div>
				
				<div class="position3">
				<?php
				#var_dump(array('total'=>$totalForSale,'perpage'=>$perpageForShow));
				$page=new page(array('total'=>$total,'perpage'=>$perpage,'pagebarnum'=>4));
				$page->open_ajax('doAjaxForFriend');
				echo $page->show(1);
				?>
				<?php }?>
				</div>
			</div>
		</td>
	  </tr>
	  <tr>
	  	<td align="center" height="25px"><p style="padding-top:10px">
	  		<input class="seabut" id="button" name="button" type="submit" value="发 送" />
			&nbsp;
			<input type="checkbox"  id="checkall" name="checkall" /> 全选
			</p>
			<input type="hidden" name="param1" />
		</td>
	  </tr>
  </table>
</form>
<iframe id="doFriends" name="doFriends" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
  <div class="clear"></div>
</div>
</div>
<!-- fla end -->
