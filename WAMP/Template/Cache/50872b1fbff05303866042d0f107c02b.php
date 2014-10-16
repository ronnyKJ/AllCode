<div class="box">
    <h3>多层嵌套输出</h3>
    <table summary="多层嵌套">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>email</th>
            <th>other</th>
            <th>子元素</th>
        </tr>
        <?php if(is_array($data)): ?><?php $i = 0;?><?php $__LIST__ = $data?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><tr>
            <td><?php echo ($vo["id"]); ?></td>
            <td><?php echo ($vo["name"]); ?></td>
            <td><?php echo ($vo["email"]); ?></td>
            <td><?php echo ($vo["other"]); ?></td>
            <td>
                <ul>
                    <?php if(is_array($vo['sub'])): ?><?php $k = 0;?><?php $__LIST__ = $vo['sub']?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$sub): ?><?php ++$k;?><?php $mod = ($k % 2 )?><li>(<?php echo ($k); ?>) sub_<?php echo ($sub["id"]); ?> | sub_<?php echo ($sub["name"]); ?></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
                </ul>
            </td>
        </tr><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
    </table>
</div>