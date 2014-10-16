<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>ThinkPHP示例：Ajax表单提交</title>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/common.css" />
    <script type="text/javascript" src="__PUBLIC__/Js/Jquery/jquery.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Js/Jquery/jquery.form.js"></script>
</head>
<body><script language="JavaScript">
    <!--
    $(function(){
        $('#form1').ajaxForm({
            beforeSubmit:  checkForm,  // pre-submit callback
            success:       complete,  // post-submit callback
            dataType: 'json'
        });
        function checkForm(){
            if( '' == $.trim($('#title').val())){
                $('#result').html('标题不能为空').show();
                return false;
            }
            //可以在此添加其它判断
        }
    function complete(data){
        if (data.status==1)
        {
            $('#result').html(data.info).show();
            // 更新列表
            data = data.data;
            var html =  '<div class="result" style=\'font-weight:normal;background:#A6FF4D\'><div style="border-bottom:1px dotted silver">'+data.title+'  ['+data.email+data.create_time+']</div><div class="content">'+data.content+'</div></div>';
            $('#list').prepend(html);
			//alert(data);
        }else{
            $('#result').html(data.info).show();
        }
    }

});
function checkTitle(){
    $.post('__URL__/checkTitle',{'title':$('#title').val()},function(data){
        $('#result').html(data.info).show();
    },'json');
} 
//-->
    </script>
    <div class="main">
        <h2>ThinkPHP示例之：Ajax表单提交</h2>
        本示例同表单处理，只是改变提示方式为Ajax方式，采用了jquery类库实现。其他Ajax类库的实现方式类似~
        <form id="form1" method='post' action="__URL__/insert">
            <table cellpadding=2 cellspacing=2>
                <tr>
                    <td colspan="2"><div id="result" class="none result" style="font-family:微软雅黑,Tahoma;letter-spacing:2px"></div></td>
                </tr>

                <tr>
                    <td class="tRight" width="12%">标题：</td>
                    <td class="tLeft" ><input type="text" name="title" id="title" style="height:23px" class="large bLeft"> <input type="button" value="检 查" class="small button" onClick="checkTitle()"></td>
                </tr>
                <tr>
                    <td class="tRight" >邮箱：</td>
                    <td class="tLeft" ><input type="text" name="email" id="email" style="height:23px" class="huge bLeft"></td>
                </tr>
                <tr>
                    <td class="tRight tTop" >内容：</td>
                    <td><textarea name="content" id="content" class="huge bLeft" rows="8" cols="25"></textarea></td>
                </tr>
                <tr>
                    <td><input type="hidden" name="ajax" value="1"></td>
                    <td><input type="submit"  class="button" value="提 交"> <input type="reset" class="button" value="清 空"></td>
                </tr>

                <tr>
                    <td></td>
                    <td><hr></td>
                </tr>
                <tr>
                    <td></td>
                    <td> <div id="list" >
                            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><div class="result" style='font-weight:normal;<?php if(($mod)  ==  "1"): ?>background:#ECECFF<?php endif; ?>'><div style="border-bottom:1px dotted silver"><?php echo ($vo["title"]); ?>  [<?php echo ($vo["email"]); ?> <?php echo (date('Y-m-d H:i:s',$vo["create_time"])); ?>]</div>
                                    <div class="content"><?php echo (nl2br($vo["content"])); ?></div></div><?php endforeach; endif; else: echo "" ;endif; ?></div></td>
                </tr>
                <tr>
                    <td></td>
                    <td><hr> 示例源码<br/>控制器IndexAction类<br/><?php highlight_file(LIB_PATH.'Action/IndexAction.class.php'); ?><br/>模型FormModel类<br/><?php highlight_file(LIB_PATH.'Model/FormModel.class.php'); ?></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>