<div class="box">
    <h3>使用iterate标签对数据循环输出</h3>
    <table summary="模拟数据循环输出">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>email</th>
            <th>other</th>
        </tr>
        <?php if(is_array($data)): ?><?php $i = 0;?><?php $__LIST__ = $data?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><tr>
            <td><?php echo ($vo["id"]); ?></td>
            <td><?php echo ($vo["name"]); ?></td>
            <td><?php echo ($vo["email"]); ?></td>
            <td><?php echo ($vo["other"]); ?></td>
        </tr><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
    </table>
</div>

<div class="box">
    <h3>只输出第5～10条记录</h3>
    <table summary="模拟数据循环输出">
         <tr>
            <th>ID</th>
            <th>Name</th>
            <th>email</th>
            <th>other</th>
        </tr>
        <?php if(is_array($data)): ?><?php $i = 0;?><?php $__LIST__ = array_slice($data,5,5) ?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><tr>
            <td><?php echo ($vo["id"]); ?></td>
            <td><?php echo ($vo["name"]); ?></td>
            <td><?php echo ($vo["email"]); ?></td>
            <td><?php echo ($vo["other"]); ?></td>
        </tr><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
    </table>
</div>

<div class="box">
    <h3>使用别名volist输出偶数记录</h3>
    <table summary="模拟数据循环输出">
         <tr>
            <th>ID</th>
            <th>Name</th>
            <th>email</th>
            <th>other</th>
        </tr>
        <?php if(is_array($data)): ?><?php $i = 0;?><?php $__LIST__ = $data?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><?php if(($mod)  !=  "1"): ?><tr>
            <td><?php echo ($vo["id"]); ?></td>
            <td><?php echo ($vo["name"]); ?></td>
            <td><?php echo ($vo["email"]); ?></td>
            <td><?php echo ($vo["other"]); ?></td>
        </tr><?php endif; ?><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
    </table>
</div>