<div class="box">
    <h2>
        
        <?php $str = $title.' 演示代码的变量输出结果'; ?>

        
        <?php
            $str .= " <em>(这是由php代码直接echo的标题)</em>";
            echo $str;
        ?>
    </h2>

    <ul class="demo">
        <li>name变量：<?php echo ($name); ?></li>
        <li>email变量： <?php echo ($email); ?></li>
        <li>now_time变量： <?php echo (date('Y-m-d',$now_time)); ?> <em>(这里对模板变量使用了函数)</em></li>
        <li>title变量： <?php echo ($title); ?></li>
        <li>content变量： <?php echo ($content); ?> <em>(<?php echo ($content); ?> 是布局模板中动态调用的模板文件名称)</em></li>
    </ul>

</div>