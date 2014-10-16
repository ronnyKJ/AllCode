<?php
// +----------------------------------------------------------------------
// | ThinkPHP
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

/**
 +------------------------------------------------------------------------------
 * ThinkPHP标签库TagLib解析基类
 *
 * 要在模板页面中引入标签库，使用taglib标签，例如:
 * <taglib name='cs' />
 * 如果要引入多个标签库，可以使用
 * <taglib name='cs,mx,html' />
 *
 * 如果要指定标签库解析类，可以使用
 * <taglib name='cx'  class='Think.Template.TagLib.TagLib_cx' />
 * 系统内置引入了cx标签库，所以，如果需要使用cx标签库，无需使用taglib标签引入
 * 但是无需写cs前缀
 * 例如 <cx:vo name='user' value='id' />
 * 应该写成 <vo name='user' value='id' />
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Template
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id$
 +------------------------------------------------------------------------------
 */
class TagLib extends Base
{//类定义开始

    /**
     +----------------------------------------------------------
     * 标签库定义XML文件
     +----------------------------------------------------------
     * @var string
     * @access protected
     +----------------------------------------------------------
     */
    protected $xml = '';

    /**
     +----------------------------------------------------------
     * 标签库名称
     +----------------------------------------------------------
     * @var string
     * @access protected
     +----------------------------------------------------------
     */
    protected $tagLib ='';

    /**
     +----------------------------------------------------------
     * 标签库标签列表
     +----------------------------------------------------------
     * @var string
     * @access protected
     +----------------------------------------------------------
     */
    protected $tagList = array();

    /**
     +----------------------------------------------------------
     * 标签库分析数组
     +----------------------------------------------------------
     * @var string
     * @access protected
     +----------------------------------------------------------
     */
    protected $parse = array();

    /**
     +----------------------------------------------------------
     * 标签库是否有效
     +----------------------------------------------------------
     * @var string
     * @access protected
     +----------------------------------------------------------
     */
    protected $valid = false;

    /**
     +----------------------------------------------------------
     * 当前模板对象
     +----------------------------------------------------------
     * @var object
     * @access protected
     +----------------------------------------------------------
     */
    protected $tpl;

    protected $comparison = array(' nheq '=>' !== ',' heq '=>' === ',' neq '=>' != ',' eq '=>' == ',' egt '=>' >= ',' gt '=>' > ',' elt '=>' <= ',' lt '=>' < ');

    /**
     +----------------------------------------------------------
     * 架构函数
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     */
    public function __construct()
    {
        $this->tagLib  = strtolower(substr(get_class($this),6));
        $this->tpl       = ThinkTemplate::getInstance();
        $this->_initialize();
        $this->load();
    }

    // 初始化标签库的定义文件
    public function _initialize() {
        $this->xml = dirname(__FILE__).'/Tags/'.$this->tagLib.'.xml';
    }

    public function load() {
        $array = (array)(simplexml_load_file($this->xml));
        if($array !== false) {
            $this->parse = $array;
            $this->valid = true;
        }else{
            $this->valid = false;
        }
    }

    /**
     +----------------------------------------------------------
     * 分析TagLib文件的信息是否有效
     * 有效则转换成数组
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param mixed $name 数据
     * @param string $value  数据表名
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function valid()
    {
        return $this->valid;
    }

    /**
     +----------------------------------------------------------
     * 获取TagLib名称
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function getTagLib()
    {
        return $this->tagLib;
    }

    /**
     +----------------------------------------------------------
     * 获取Tag列表
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function getTagList()
    {
        if(empty($this->tagList)) {
            $tags = $this->parse['tag'];
            $list = array();
            if(is_object($tags)) {
                $list[] =  array(
                    'name'=>$tags->name,
                    'content'=>$tags->bodycontent,
                    'nested'=>isset($tags->nested)?$tags->nested:0,
                    'attribute'=>isset($tags->attribute)?$tags->attribute:'',
                    );
                if(isset($tags->alias)) {
                    $alias  =   explode(',',$tag->alias);
                    foreach ($alias as $tag){
                        $list[] =  array(
                            'name'=>$tag,
                            'content'=>$tags->bodycontent,
                            'nested'=>isset($tags->nested)?$tags->nested:0,
                            'attribute'=>isset($tags->attribute)?$tags->attribute:'',
                            );
                    }
                }
            }else{
                foreach($tags as $tag) {
                    $tag = (array)$tag;
                    $list[] =  array(
                        'name'=>$tag['name'],
                        'content'=>$tag['bodycontent'],
                        'nested'=>isset($tag['nested'])?$tag['nested']:0,
                        'attribute'=>isset($tag['attribute'])?$tag['attribute']:'',
                        );
                    if(isset($tag['alias'])) {
                        $alias  =   explode(',',$tag['alias']);
                        foreach ($alias as $tag1){
                            $list[] =  array(
                                'name'=>$tag1,
                                'content'=>$tag['bodycontent'],
                                'nested'=>isset($tag['nested'])?$tag['nested']:0,
                                'attribute'=>isset($tag['attribute'])?$tag['attribute']:'',
                                );
                        }
                    }
                }
            }
            $this->tagList = $list;
        }
        return $this->tagList;
    }

    /**
     +----------------------------------------------------------
     * 获取某个Tag属性的信息
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function getTagAttrList($tagName)
    {
        static $_tagCache   = array();
        $_tagCacheId        =   md5($this->tagLib.$tagName);
        if(isset($_tagCache[$_tagCacheId])) {
            return $_tagCache[$_tagCacheId];
        }
        $list = array();
        $tags = $this->parse['tag'];
        foreach($tags as $tag) {
            $tag = (array)$tag;
            if( strtolower($tag['name']) == strtolower($tagName)) {
                if(isset($tag['attribute'])) {
                    if(is_object($tag['attribute'])) {
                        // 只有一个属性
                        $attr = $tag['attribute'];
                        $list[] = array(
                            'name'=>$attr->name,
                            'required'=>$attr->required
                            );
                    }else{
                        // 存在多个属性
                        foreach($tag['attribute'] as $attr) {
                            $attr = (array)$attr;
                            $list[] = array(
                                'name'=>$attr['name'],
                                'required'=>$attr['required']
                                );
                        }
                    }
                }
            }
        }
        $_tagCache[$_tagCacheId]    =   $list;
        return $list;
    }

    /**
     +----------------------------------------------------------
     * TagLib标签属性分析 返回标签属性数组
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $tagStr 标签内容
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    public function parseXmlAttr($attr,$tag)
    {
        //XML解析安全过滤
        $attr = str_replace("<","&lt;", $attr);
        $attr = str_replace(">","&gt;", $attr);
        $xml =  '<tpl><tag '.$attr.' /></tpl>';
        $xml = simplexml_load_string($xml);
        if(!$xml) {
            throw_exception(L('_XML_TAG_ERROR_').' : '.$attr);
        }
        $xml = (array)($xml->tag->attributes());
        $array = array_change_key_case($xml['@attributes']);
        $attrs  = $this->getTagAttrList($tag);
        foreach($attrs as $val) {
            if( !isset($array[strtolower($val['name'])])) {
                $array[strtolower($val['name'])] = '';
            }
        }
        return $array;
    }

    /**
     +----------------------------------------------------------
     * 解析条件表达式
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $condition 表达式标签内容
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    public function parseCondition($condition) {
        $condition = str_ireplace(array_keys($this->comparison),array_values($this->comparison),$condition);
        $condition = preg_replace('/\$(\w+):(\w+)\s/is','$\\1->\\2 ',$condition);
        $condition = preg_replace('/\$(\w+)\.(\w+)\s/is','(is_array($\\1)?$\\1["\\2"]:$\\1->\\2) ',$condition);
        return $condition;
    }

    /**
     +----------------------------------------------------------
     * 自动识别构建变量
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $name 变量描述
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function autoBuildVar($name) {
        if('Think.' == substr($name,0,6)){
            // 特殊变量
            return $this->parseThinkVar($name);
        }elseif(strpos($name,'.')) {
            // 数组和对象自动判断支持
            $vars = explode('.',$name);
            $name = 'is_array($'.$vars[0].')?$'.$vars[0].'["'.$vars[1].'"]:$'.$vars[0].'->'.$vars[1];
        }elseif(strpos($name,':')){
            // 额外的对象方式支持
            $name   =   '$'.str_replace(':','->',$name);
        }elseif(!defined($name)) {
            $name = '$'.$name;
        }
        return $name;
    }

    /**
     +----------------------------------------------------------
     * 用于标签属性里面的特殊模板变量解析
     * 格式 以 Think. 打头的变量属于特殊模板变量
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $varStr  变量字符串
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function parseThinkVar($varStr){
        $vars = explode('.',$varStr);
        $vars[1] = strtoupper(trim($vars[1]));
        $parseStr = '';

        if(count($vars)==3){
            $vars[2] = trim($vars[2]);
            switch($vars[1]){
                case 'SERVER':    $parseStr = '$_SERVER[\''.$vars[2].'\']';break;
                case 'GET':         $parseStr = '$_GET[\''.$vars[2].'\']';break;
                case 'POST':       $parseStr = '$_POST[\''.$vars[2].'\']';break;
                case 'COOKIE':    $parseStr = '$_COOKIE[\''.$vars[2].'\']';break;
                case 'SESSION':   $parseStr = '$_SESSION[\''.$vars[2].'\']';break;
                case 'ENV':         $parseStr = '$_ENV[\''.$vars[2].'\']';break;
                case 'REQUEST':  $parseStr = '$_REQUEST[\''.$vars[2].'\']';break;
                case 'CONST':     $parseStr = strtoupper($vars[2]);break;
                case 'LANG':       $parseStr = 'L("'.$vars[2].'")';break;
                case 'CONFIG':    $parseStr = 'C("'.$vars[2].'")';break;
                default:break;
            }
        }else if(count($vars)==2){
            switch($vars[1]){
                case 'NOW':       $parseStr = "date('Y-m-d g:i a',time())";break;
                case 'VERSION':  $parseStr = 'THINK_VERSION';break;
                case 'TEMPLATE':$parseStr = 'C("TMPL_FILE_NAME")';break;
                case 'LDELIM':    $parseStr = 'C("TMPL_L_DELIM")';break;
                case 'RDELIM':    $parseStr = 'C("TMPL_R_DELIM")';break;
            }
            if(defined($vars[1])){ $parseStr = strtoupper($vars[1]);}
        }
        return $parseStr;
    }

}//类定义结束
?>