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


<div class="box">
    <h2>ThinkPHP模板引擎简介：</h2>
    <p>ThinkPHP内置的模板引擎是一个自主创新的XML编译性模板引擎。</p>
    <p>这里演示了常用的模板标签的用法。包括变量输出、循环、判断、比较等。</p>
    <p>更多功能和特性可参考相关文档。</p>
</div>


<div class="box">
    <h3>模板引擎常用功能演示</h3>

    <table summary="模板引擎功能链接">
        <tr>
            <th colspan="3"><h5>基本功能演示 <em>( IndexAction.class.php )</em></h5></th>
        </tr>
        <tr>
            <td>
                <a href="#TB_inline?height=420&width=600&inlineId=exp1" title="模板变量赋值与模板调用示例" class="thickbox">模板变量赋值 | 模板调用</a>
            </td>
            <td>
                <a href="#TB_inline?height=420&width=600&inlineId=exp2" title="加载标签库示例" class="thickbox">加载标签库</a>
            </td>
            <td>
                <a href="#TB_inline?height=420&width=600&inlineId=exp3" title="包含外部文件示例" class="thickbox">包含外部文件</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="#TB_inline?height=420&width=650&inlineId=exp4" title="导入外部js文件和css文件示例" class="thickbox">导入外部js文件和css文件</a>
            </td>
            <td>
                <a href="#TB_inline?height=420&width=650&inlineId=exp5" title="模板变量输出示例" class="thickbox">模板变量输出</a>
            </td>
             <td>
                <a href="#TB_inline?height=420&width=600&inlineId=exp6" title="便捷路径定义示例" class="thickbox">便捷路径定义</a>
            </td>
        </tr>
        <tr>
            <td colspan="3"><span></span></td>
        </tr>
        <tr>
            <th colspan="3"><h5>布局功能演示 <em>( DemoAction.class.php) </em></h5></th>
        </tr>
        <tr>
            <td>
                <a href="#TB_inline?height=420&width=600&inlineId=exp7" title="批量赋值和使用布局模板示例" class="thickbox">批量赋值 | 使用布局模板</a>
            </td>

            <td>
                <a href="#TB_inline?height=420&width=600&inlineId=exp8" title="模板中直接使用PHP代码示例" class="thickbox">模板中直接使用PHP代码</a>
            </td>

            <td><a href="#TB_inline?height=420&width=600&inlineId=exp9" title="对模板变量使用函数示例" class="thickbox">对模板变量使用函数</a></td>
        </tr>
        <tr>
            <td><a href="#TB_inline?height=420&width=600&inlineId=exp10" title="循环输出数据示例" class="thickbox">循环输出数据</a></td>
            <td><a href="#TB_inline?height=420&width=600&inlineId=exp11" title="多层嵌套循环输出示例" class="thickbox">多层嵌套循环输出</a></td>
            <td><a href="#TB_inline?height=420&width=600&inlineId=exp12" title="保持原样输出示例" class="thickbox">保持原样输出</a></td>
        </tr>
        <tr>
            <td colspan="3"><span></span></td>
        </tr>
        <tr>
            <th colspan="3"><h5>标签使用演示</h5></th>
        </tr>
        <tr>
            <td>
                <a href="#TB_inline?height=420&width=650&inlineId=exp13" title="使用比较标签输出示例" class="thickbox">使用比较标签</a>
            </td>
            <td><a href="#TB_inline?height=420&width=600&inlineId=exp14" title="使用if标签示例" class="thickbox">使用 if 标签</a></td>
            <td>
                <a href="#TB_inline?height=420&width=600&inlineId=exp15" title="使用Present标签示例" class="thickbox">使用Present标签</a>
            </td>
        </tr>
        <tr>
            <td><a href="#TB_inline?height=420&width=600&inlineId=exp16" title="使用session标签示例" class="thickbox">使用session标签</a></td>
            <td><a href="#TB_inline?height=420&width=600&inlineId=exp17" title="使用switch标签示例" class="thickbox">使用switch标签</a></td>
            <td><a href="#TB_inline?height=420&width=600&inlineId=exp18" title="标签扩展示例" class="thickbox">标签扩展</a></td>
        </tr>

    </table>
</div>


<div class="hidebox" id="exp1">
    <div class="examples">
        <h6>模板赋值与模板调用</h6>
        <p>变量赋值统一用 $this->assign('变量名称','值')这种方法。
        <p>也可以使用 $this->变量名称 = '变量值' 这种方式。</p>

        <div class="code">
            <?php highlight_file(LIB_PATH.'Action/IndexAction.class.php'); ?>
        </div>
    </div>
</div>


<div class="hidebox" id="exp2">
    <div class="examples">
        <h6>加载标签库</h6>

        <p>要在模板页面中使用TagLib标签库功能，需要在开始时候使用taglib 标签导入需要使用的标签，防止以后标签库大量扩展后增加解析工作量，如示例中header.html文件首行：</p>

        <div class="code">
            <pre>&lt;tagLib name="cx,html" /&gt;</pre>
        </div>

        <p>ThinkPHP框架内置的模板引擎，会自动加载CX标签库，所以下面的方式效果相同：</p>

        <div class="code">
            <pre>&lt;tagLib name='html' /&gt;</pre>
        </div>

    </div>
</div>


<div class="hidebox" id="exp3">
    <div class="examples">
        <h6>包含外部文件</h6>

        <p>可以使用Include标签来包含外部文件</p>
        <p>如示例代码index.html中引入了Public目录header.html公用模板：</p>
        <div class="code">
            <pre>&lt;include file="Public:header" /&gt;</pre>
        </div>
        <br /><br />
        <h6>更多用法</h6>
        <div class="code">
            <?php highlight_file(LIB_PATH.'Code/exp_include_file.php'); ?>
        </div>

        <h6>注意：</h6>
        <p>由于模板解析的特点，会从入口模板开始解析，如果外部模板有所更改，模板引擎并不会重新编译模板，除非缓存已经过期。</p>
        <p>如果遇到比较大的更改，您可以尝试把模块的缓存目录清空，系统就会重新编译，并解析到最新的外部文件了。</p>
    </div>
</div>


<div class="hidebox" id="exp4">
    <div class="examples">
        <h6>导入外部js文件和css文件</h6>
        <p>导入外部Js和Css文件除了使用的传统方式来导入外，Html标签库还提供了两个标签用于专门导入用于导入外部JS和CSS文件。(header.html中使用了link标签引入js和css)</p>

        <h6>使用import标签</h6>
        <p>import标签：用以导入网站的公共JS或者CSS。</p>
        <div class="code">
            <?php highlight_file(LIB_PATH.'Code/exp_tags_html_import.php'); ?>
        </div>

        <br /><br /><br />

        <h6>使用Html link 标签</h6>

        <p>link标签用以导入当前项目的公共JS或者CSS文件，例如：</p>
        <div class="code">
            <?php highlight_file(LIB_PATH.'Code/exp_tags_html_link.php'); ?>
        </div>

    </div>
</div>


<div class="hidebox" id="exp5">
    <div class="examples">

        <h6>模板变量输出</h6>
        <p>在模板中使用对应的标签输出各种变量</p>
        <p>例如本示例中，对$title的输出</p>
        <div class="code">
            <pre>&lt;title&gt;ThinkPHP示例：{$title}&lt;/title&gt;</pre>
        </div>
        <br /><br />

        <h6>更多示例</h6>
        <div class="code">
            <?php highlight_file(LIB_PATH.'Code/exp_value_echo.php'); ?>
        </div>

    </div>
</div>


<div class="hidebox" id="exp6">
    <div class="examples">

        <h6>便捷路径定义</h6>
        <p>可以在模板文件里面使用一些已经定义好的特殊字符串，系统在解析模板的时候会自动替换成相关的系统常量</p>
        <p>例如本示例中导入Tpl/default/Public/Css/style.css文件，使用了../ Public 的便捷路径定义。</p>
        <div class="code">
            <pre>../ Public/Css/style.css</pre>
        </div>
        <p>自动替换标签是可以在config中自定义的，可以根据项目需要增加和修改</p>
        <br /><br />

        <h6>更多可替换的字符串</h6>
        <div class="code">
            <?php highlight_file(LIB_PATH.'Code/exp_const_path.php'); ?>
        </div>

    </div>
</div>


<div class="hidebox" id="exp7">
    <div class="examples">
        <h6>批量赋值</h6>
        <p>代码演示：Demo/index &nbsp;&nbsp;<a href="__APP__/Demo/" title="会在新窗口打开" target="_blank">浏览输出结果</a></p>
        <p>如果要同时输出多个模板变量，可以使用下面这种方式：</p>
        <div class="code">
            <?php highlight_file(LIB_PATH.'Code/exp_value_define.php'); ?>
        </div>
        <br /><br />
        <h6>使用布局模板</h6>
        <p>由于Include标签导入的外部文件无法检测模板更新，而布局模板恰好可以很好的解决这个问题</p>
        <p>布局模板调用只要在display方法中使用Layout指定模板文件</p>

        <div class="code">
            <pre>$this->display('Layout:demo_layout');</pre>
        </div>

        <p>这样就可以使用layout标签去调用模板了</p>
        <div class="code">
            <pre>&lt;layout name="Public:header" cache="60" /&gt;</pre>
        </div>
        <p>并且可以使用动态布局模板来简化布局模板的定义</p>
        <div class="code">
            <pre>&lt;layout name="$content" cache="30" /&gt;</pre>
        </div>
    </div>
</div>


<div class="hidebox" id="exp8">
    <div class="examples">

        <h6>在模板中使用php代码</h6>
        <p>代码演示：Tpl/default/Demo/demo_index.html</p>
        <br /><br />
        <p>可以用php标签括起要书写的代码</p>
        <div class="code">
            <pre>&lt;php&gt;echo 'Hello,world!';&lt;/php&gt;</pre>
        </div>

        <p>也可以直接使用</p>
        <div class="code">
            <pre>&lt;?php echo 'Hello,world!'; ?&gt;</pre>
        </div>

    </div>
</div>


<div class="hidebox" id="exp9">
    <div class="examples">
        <h6>对模板变量使用函数</h6>
        <p>代码演示：Tpl/defalut/Demo/demo_index.html</p>
        <div class="code">
            <pre>{ $now_time|date='Y-m-d',###}</pre>
        </div>
        <br /><br />
        <h6>使用说明：</h6>
        <p>内置模板引擎支持对模板变量使用函数，并支持多个函数同时使用。</p>
        <p>模板变量的函数调用格式为{ $varname|function1|function2=arg1,arg2,### }</p>
        <p>{ 和 $ 符号之间不能有空格，后面参数的空格就没有问题</p>
        <p>###表示模板变量本身的参数位置 </p>
        <p>支持多个函数，函数之间支持空格 </p>
        <p>支持函数屏蔽功能，在配置文件中可以配置禁止使用的函数列表 </p>
        <p>支持变量缓存功能，重复变量字串不多次解析</p>
    </div>
</div>


<div class="hidebox" id="exp10">
    <div class="examples">
        <h6>循环数据输出</h6>
        <p>代码示例： Demo/loop1 和 demo_loop1.html &nbsp;<a href="__APP__/Demo/loop1" title="会在新窗口打开" target="_blank">浏览输出结果</a></p>
        <p>通常对数据库进行查询，如果使用数组类型返回的结果集会类似如下的形式：</p>
        <div class="code">
            <pre>
                $data   =   array(
                    0   =>  array(
                        'id'    =>  1,
                        'name'  =>  'think',
                        'email' =>  'think@thinkphp.cn',
                        'other'  =>  'aaaaaaaaaa',
                    ),
                    1   =>  array(
                        'id'    =>  2,
                        'name'  =>  'topthink',
                        'email' =>  'top@thinkphp.cn',
                        'other'  =>  'bbbbbbbbbb',
                    )
                    .........
                );
            </pre>
        </div>
        <p>在模板中可以使用iterate(或使用别名volist)标签进行循环输出</p>
        <div class="code">
            <pre>
                 &lt;iterate name="data" id="vo"&gt;
                    {$vo.id}
                    {$vo.name}
                    {$vo.email}
                    {$vo.other}
                &lt;/iterate&gt;
            </pre>
        </div>
    </div>
</div>


<div class="hidebox" id="exp11">
    <div class="examples">
        <h6>多层嵌套循环输出</h6>
        <p>代码演示： demo_loop2.html</p>
        <p>模板引擎提供了多层嵌套功能，可以对标签库的标签指定可以嵌套</p>
        <p>默认的Cx标签库中，iterate、php、if、elseif、else、foreach、compare、present、notpresent及其别名都可以嵌套使用，例如</p><br />
        <div class="code">
        <pre>
        
            &lt;volist name="list" id="vo"&gt;
                &lt;volist name="vo['sub']" id="sub"&gt;
                    {$sub.name}
                &lt;/volist&gt;
            &lt;/volist&gt;
        
        </pre>
        </div>
    </div>
</div>


<div class="hidebox" id="exp12">
    <div class="examples">
        <h6>保持原样输出</h6>
        <p>可以使用literal标签来防止模板标签被解析。</p>
        <p>代码示例：index.html</p>
        <br />
        <div class="code">
            <pre>
                &lt;literal&gt;
                    &lt;if condition="$name eq 1 "&gt; value1
                    &lt;elseif condition="$name eq 2" /&gt;value2
                    &lt;else /&gt; value3
                    &lt;/if&gt;
                &lt;/literal&gt;
            </pre>
        </div>
    </div>
</div>


<div class="hidebox" id="exp13">
    <div class="examples">

        <h6>使用比较标签</h6>
        <p>模板引擎提供了非常丰富的判断标签，用于对数据进行比较输出。</p>
        <p>例如本示例中，判断当前模块名称常量如果不等于Index时则输出</p>
        <div class="code">
            <pre>&lt;neq name="Think.const.MODULE_NAME" value="Index"&gt;...&lt;/neq&gt;</pre>
        </div>
        <br /><br />

        <h6>更多比较标签用法</h6>
        <div class="code">
            <?php highlight_file(LIB_PATH.'Code/exp_tags_cx_compare.php'); ?>
        </div>
    </div>
</div>


<div class="hidebox" id="exp14">
    <div class="examples">

        <h6>使用if标签</h6>
        <p>代码示例：demo_other.html</p>
        <p>复杂的条件判断可以使用if标签。例如：</p>
        <div class="code">
        <pre>
&lt;if condition="$name eq 1 "&gt; value1
&lt;elseif condition="$name eq 2" /&gt;value2
&lt;else /&gt; value3
&lt;/if&gt;
        </pre>
        </div>
        <p>在condition属性中可以支持eq等判断表达式 ，同上面的判断标签，但是不支持带有"&gt;"、"&lt;"等符号的用法，因为会混淆模板解析。</p>
        <p>if标签的condition属性里面基本上使用的是php语法，可以直接书写php代码</p>
        <p>例如示例代码中，直接应用了函数</p>
    </div>
</div>


<div class="hidebox" id="exp15">
    <div class="examples">

        <h6>使用Present标签</h6>
        <p>present标签可以判断模板变量是否已经赋值</p>
        <p>notpresent标签判断如果没有赋值</p>
        <p>例如本示例header.html中，使用present标签判断title变量是否赋值决定是否显链接</p>
        <div class="code">
            <pre>&lt;present name="title"&gt;...&lt;/present&gt;</pre>
        </div>
        <br /><br />

        <p>如果name没有赋值则输出</p>
        <div class="code">
            <pre>&lt;notpresent name="name"&gt;name没有赋值&lt;/notpresent&gt;</pre>
        </div>
        <br /><br />
        <p>上面两个标签也可以合并为</p>
        <div class="code">
        <pre>&lt;present name="name"&gt;name已经赋值&lt;else /&gt;name还没有赋值&lt;/present&gt;</pre>
        </div>

    </div>
</div>


<div class="hidebox" id="exp16">
    <div class="examples">

        <h6>使用session标签</h6>
        <p>session标签和present使用类似，因此示例省略</p>
        <p>其中nosesion标签判断如果没有注册session变量则输出,session标签判断已注册该变量则输出</p>
        <div class="code">
            <pre>&lt;session name="userid"&gt;session变量userid已注册&lt;/session&gt;</pre>
        </div>
        <br /><br />

        <p>如果session变量还没有设置</p>
        <div class="code">
            <pre>&lt;nosession name="userid"&gt;session变量userid还没注册&lt;/nosession&gt;</pre>
        </div>
    </div>
</div>


<div class="hidebox" id="exp17">
    <div class="examples">

        <h6>使用switch标签</h6>
        <p>代码示例：demo_other.html <em><a href="__APP__/Demo/other" title="会在新窗口打开" target="_blank">浏览</a></em></p>
        <p>可用方法：</p>
        <div class="code">
            <?php highlight_file(LIB_PATH.'Code/exp_tags_cx_switch.php'); ?>
        </div>
    </div>
</div>


<div class="hidebox" id="exp18">
    <div class="examples">

        <h6>标签扩展（自定义标签）</h6>
        <p>代码示例：ThinkPHP/Lib/Think/Template/Tags/mytags.xml</p>
        <p>代码示例：ThinkPHP/Lib/Think/Template/TagLib/TagLibMytags.class.php</p>
        <p><a href="__APP__/Demo/mytags" title="会在新窗口打开" target="_blank">浏览自定义标签示例</a></p><br />
        <p>ThinkPHP模板引擎提供了强大的定制功能，支持自定义标签库和标签，可以根据标签库的定义规则来增加和修改标签解析规则</p>
        <p>标签库由定义文件和解析类构成。每个标签库存在一个XML定义文件，用来定义标签库中的标签和属性。并且一个标签库文件对应一个标签库解析类，每个标签就是解析类中的一个方法。</p>
        <p>要增加自己的标签库定义，需要首先在系统目录下面的ThinkTemplate/Template/Tags/目录下面增加标签库定义的xml文件，示例中演示了一个简单的标签库定义：</p>
        <div class="code">
            <?php highlight_file(THINK_PATH.'/Lib/Think/Template/Tags/mytags.xml'); ?>
        </div>
        <p>详细扩展方法可参考相关手册文档和cx、html标签库的定义模式。</p>
        <h6>解释标签库</h6>
        <p>标签库解析类的作用其实就是把某个标签定义解析成为有效的模版文件（可以包括PHP语句或者HTML标签）。每个标签的解析方法就是标签解析类的一个方法。</p>

        <div class="code">
            <?php highlight_file(THINK_PATH.'/Lib/Think/Template/TagLib/TagLibMytags.class.php'); ?>
        </div>
    </div>
</div>




</div>

<div class="footer">
    <p>ThinkPHP 努力打造 { 轻量级 + 企业级 + 门户级 } 的PHP框架
    <a href="http://thinkphp.cn" title="官方首页">ThinkPHP官方网站</a></p>
</div>

</div>
</body>
</html>