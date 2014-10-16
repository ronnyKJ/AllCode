<!-- fla start (popMaskManageSpell) -->
<script src="<?php echo base_url();?>kweb/js/popMaskManageSpell.js" type="text/javascript" charset="UTF-8"></script>
<div id="popMaskManageSpell" style="background:#000; opacity:0.6; filter:alpha(opacity=60); width:100%; height:100%; position:absolute; top:0; left:0; display:none;"></div>
<div id="popBoxBodyManageSpell" style=" position:absolute; top:150px; left:0; width:100%; display:none;">
<div id="popboxManageSpell" class="popbox flacont1" style="display:none;">
<script type="text/javascript">
function doAjaxManageSpell(url){
	var n=1;
	// 分离页面 '/index.php/member?n=2'
	var regExp = /n=(\d+)/ig;
	if(regExp.test(url)){
		regExp = /n=(\d+)/ig;
		n = regExp.exec(url)[1];
	}

	//表单参数
	var uid="<?php echo $loginUserId;?>";
	param = "n="+n;
	url = "<?php echo site_url("member/doajaxformanagespell");?>";
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				$("#umdataManageSpell").empty();
				$("#umdataManageSpell").append(obj.data);
			}
			else
			{
				alert(obj.info);
			}
		}
	});
}

function doCloseManageSpell(cid){
	//表单参数
	var uid="<?php echo $loginUserId;?>";
	param = "cid="+cid;
	url = "<?php echo site_url("spell/doclosemanagespell");?>";
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				alert(obj.info);
				// 重新加载该分页
				doAjaxManageSpell(location.href);
			}
			else
			{
				alert(obj.info);
			}
		}
	});
}

function doDelManageSpell(cid){
	// 确认是否删除
	if(!confirm('确实要删除吗?')){
		return;
	}

	//表单参数
	var uid="<?php echo $loginUserId;?>";
	param = "cid="+cid;
	url = "<?php echo site_url("spell/dodelmanagespell");?>";
	$.ajax({ 
		type: "POST",
		url: url, 
		data: param+"&dataType=json",
		dataType: "json",
		success: function(obj){
			if(obj.status)
			{
				alert(obj.info);
				// 重新加载该分页
				doAjaxManageSpell(location.href);
			}
			else
			{
				alert(obj.info);
			}
		}
	});
}

</script>
<style type="text/css">
.disable{ background-color:#E3E3E3;}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><span class="r"><a onclick="initdoManageSpell()" href="javascript:void(0)"><img src="<?php echo base_url();?>kweb/images/kaicon5.gif" /></a></span><strong class="blankf">您发起的拼卡活动：</strong>
	</td>
  </tr>
 </table>

<!-- target="doManageSpell" -->
<div id="umdataManageSpell" >
	<ul class="kaul5">
	<?php if($cardData!=null){foreach ($cardData as $row):?>
	<li><div class="lpic"><a href="<?php echo site_url('spell/spellxl/'.$row['id']);?>" target="_blank"><img title="" src="<?php echo $row['cardImagePath'];?>" /></a></div>
	<div class="rtxt">
		<p>发起人： <?php echo $row['nickname'];?></p>
		<p>意向人数： <font class="redf24"><?php echo $row['regCount'];?> </font>
		<?php if($row['state']=='1'){ ?>(已 满 员）<?php } ?>
		</p>
		<p>活动参与人数限制： <?php echo $row['limitUser'];?></p>
		<p>发起时间： <?php echo $row['startDate'];?></p>
		<p>结束时间： <?php echo $row['endDate'];?></p>
		<p>联系方式： <?php echo $row['tel'];?> </p>
		<p style="padding-left:30px;">Q Q： <?php echo $row['QQ'];?></p>
		<?php if($row['state']!='3'){ ?>
		<input class="seabut" type="button" value="我要修改" onclick="location.href='<?php echo site_url('spell/spellxl/'.$row['id']);?>'" />&nbsp;
		<?php 
			$endDate = $row['endDate'];
			$endDate = str_replace("年","-",$endDate);
			$endDate = str_replace("月","-",$endDate);
			$endDate = str_replace("日","",$endDate);
		?>
		<?php if(Tools::IsOld($endDate) || $row['state']=='2'){ ?>
		<input class="seabut" type="button" value="活动结束" disabled="disabled"/> 
		<?php } else {?>
		<input class="seabut" type="button" value="结束活动" onclick="doCloseManageSpell('<?php echo $row['id']; ?>')" /> 
		<?php } ?>
		&nbsp;<input class="seabut1" type="button" value="删除" onclick="doDelManageSpell('<?php echo $row['id']; ?>')" />
		<?php } else {?>
		<input class="seabut" type="button" value="已删除" disabled="disabled" /> 
		<?php } ?>

	</div>
	</li>
	<?php endforeach;?>
	</ul><div class="clear"></div>
	<div class="position3">
		<?php
		#var_dump(array('total'=>$totalForSale,'perpage'=>$perpageForShow));
		$page=new page(array('total'=>$total,'perpage'=>$perpage,'pagebarnum'=>10));
		$page->open_ajax('doAjaxManageSpell');
		echo $page->show(4);
		?>
	</div>
	<?php }else{ ?>
		暂无拼卡活动
	<?php } ?>
	<div class="clear"></div>
</div>


<form id="formManageSpell" action="#" method="post" target="doManageSpell">
</form>
<iframe id="doManageSpell" name="doManageSpell" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
  <div class="clear"></div>
</div>
</div>
<!-- fla end -->
