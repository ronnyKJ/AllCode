IP地址查询3.0
演示地址：http://tbip.sinaapp.com
1.IP地址查询php版，采用淘宝IP地址库，非常的精准。并且会随着淘宝IP地址库实时更新。所以您获得的数据将会是最新的。
2.此3.0核心函数代码加密 其它2.0 1.0 版本完全开源
3.define('SINA_SAE', '0'); //是否启用新浪SAE平台1为使用0为不使用
4.define('REWRITE', '0'); //是否启用伪静态
5.集成WhoIs信息查询接口

.htaccess 通用伪静态规则 其它规则请参考下面的进行修改
RewriteEngine on
RewriteRule ^(.*)$ index.php?id=$1 [L]

sina SAE专版伪静态规则
- rewrite: if (!is_dir() && !is_file() && path ~ "/(.*)" ) goto "index.php?$1"

文件说明
index.php      主程序
function.php   主函数
 
其它文件
readme.txt     说明文件
taobaoapi.txt  淘宝api接口说明
htaccess.txt   通用伪静态规则
config.yaml    sina SAE伪静态规则
cacheip.txt    数据缓存文件
bg_body.jpg    背景图
whois.php      WhoIs信息查询接口

新浪SAE免费php空间申请地址:http://sae.sina.com.cn/activity/invite/101149/weibo
新浪SAE免费php空间注册功略:http://hbwanghai.blog.163.com/blog/static/199297147201222310226519/


最新代码公布地址:http://xiaogg.ctdisk.com/u/349707/437278

推荐其它ip查询工具，http://ip.1tt.net 采用纯真IP库本地库
下载地址:http://www.ctdisk.com/file/1048404


2.0下载
http://sae.sina.com.cn/?m=apps&a=detail&aid=103
1.0下载
http://www.ctdisk.com/file/6453343
http://down.chinaz.com/soft/32286.htm