<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />





<title>ThinkPHP示例：<?php if(isset($title)): ?><?php echo ($title); ?><?php else: ?>更多特性<?php endif; ?></title>




<link rel='stylesheet' type='text/css' href='../Public/Css/style.css' />


<script type='text/javascript' src='../Public/Js/jquery.js'></script> 




<script type="text/javascript">
function consts(v) {
    var cons = {
        public  :   '../Public/'
    };
    return cons[v];
}
</script>
<script type='text/javascript' src='../Public/Js/thickbox.js'></script> 

<!--这种注释模板缓存时不会删除，所以会占用模板字节-->


</head>
<body>
<div class="wrap">


<div class="header">
    <h1>ThinkPHP内置模板引擎使用：  <strong><?php if(isset($title)): ?><?php echo ($title); ?><?php else: ?>更多特性<?php endif; ?></strong> </h1>
</div>



<?php if((MODULE_NAME)  !=  "Index"): ?><p style="text-align:right">
    <a href="__APP__/Index/" title="返回首页">Index/index</a>&nbsp;&nbsp;
    <a href="__APP__/Demo/" title="批量赋值输出">Demo/index</a>&nbsp;&nbsp;
    <a href="__APP__/Demo/loop1" title="循环输出">Demo/loop1</a>&nbsp;&nbsp;
    <a href="__APP__/Demo/loop2" title="多层嵌套">Demo/loop2</a>&nbsp;&nbsp;
    <a href="__APP__/Demo/mytags" title="自定义标签示例">Demo/mytags</a>
</p><?php endif; ?>

<div class="content">