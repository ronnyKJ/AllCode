<?php
    // 引入标签类库
    import('TagLib');

    // 自定义标签库
    Class TagLibMytags extends TagLib {

        // 定义一个var方法，为免和系统的关键字冲突，在前加上一个 - 号
        public function _var ($attr) {

               $tag  = $this->parseXmlAttr($attr,'var');
               $name  = $tag['name'];
               $parseStr  = "<?php echo '".$name."';?>";
               // 标签解析方法必须使用return返回一个字符串变量，才有页面输出
               return $parseStr;
        }

    }
?>