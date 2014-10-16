<?php

define( 'ZH_CN_PACK_OPTIONS_VERSION' , 2 );

function zh_cn_language_pack_backend_register_settings() {
    register_setting( 'zh-cn-language-pack-general-settings',
                      'zh_cn_language_pack_options_version' );
    register_setting( 'zh-cn-language-pack-general-settings',
                      'zh_cn_language_pack_enable_backend_style_modifications' );
    // XXX 移除不再使用的设置项。
    unregister_setting( 'zh-cn-language-pack-general-settings',
                        'zh_cn_language_pack_is_configured' );
}

function zh_cn_language_pack_init() {        
    if( !(get_option('zh_cn_language_pack_options_version') > 0) ) {
        // 初次使用      
        // 记录当前语言包设置版本
        update_option( 'zh_cn_language_pack_enable_backend_style_modifications', 1 );
        update_option( 'zh_cn_language_pack_options_version', ZH_CN_PACK_OPTIONS_VERSION );
    }
    
    /*        
        if( get_option('zh_cn_language_pack_options_version') < [SOME VERSION] ) {
            // 曾使用过，升级
            // TODO 未来在这里添加新选项的初始值
        }
    */
}

function zh_cn_language_pack_backend_create_menu() {
    add_options_page( '中文本地化选项', '中文本地化', 'administrator', 'zh-cn-language-pack-settings', 
                      'zh_cn_language_pack_settings_page' );
}

function zh_cn_language_pack_contextual_help() {
    add_contextual_help('settings_page_zh-cn-language-pack-settings',
        '<p>在这里对 WordPress 官方中文语言包进行自定义。</p>' .
        '<p>自 WordPress 3.0.1，WordPress 中文版本新添加了“后台样式优化”的功能。开启后可以令后台显示中文更加美观，它不会影响到您站点前台的样式。</p>' .
        '<p><strong>更多信息：</strong></p>' .
        '<p>若您发现任何文字上的错误，欢迎访问下列页面进行回报 ——<br />' .
        '<a href="http://cn.wordpress.org/contact/" target="_blank">WordPress China “联系”页面</a></p>'
    );
}

function zh_cn_language_pack_settings_page() {
    ?><div class="wrap">
<h2>中文本地化选项</h2>

<form method="post" action="options.php">
    <h3 class="title">调整设置</h3>
    <p>对中文语言包进行自定义。</p>
    <?php settings_fields( 'zh-cn-language-pack-general-settings' ); ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">后台样式优化</th>
            <td>
                <label for="zh_cn_language_pack_enable_backend_style_modifications"><input type="checkbox" id="zh_cn_language_pack_enable_backend_style_modifications" name="zh_cn_language_pack_enable_backend_style_modifications" value="1"<?php checked('1', get_option('zh_cn_language_pack_enable_backend_style_modifications')); ?> /> 对后台样式进行优化。</label>
                <br />
                <span class="description">优化控制板以及登录页面的字体样式。此操作不会影响到您的博客前台。</span>
            </td>
        </tr>
    </table>

    <input type="hidden" id="zh_cn_language_pack_is_configured" name="zh_cn_language_pack_is_configured" value="1" />
    
    <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('保存设置') ?>" />
    </p>

    <!--
    <p>
        <strong>调试信息：</strong><br />
        zh_cn_language_pack_enable_backend_style_modifications = <?php echo get_option('zh_cn_language_pack_enable_backend_style_modifications'); ?><br />
        zh_cn_language_pack_options_version = <?php echo get_option('zh_cn_language_pack_options_version'); ?><br />
        ZH_CN_PACK_OPTIONS_VERSION = <?php echo ZH_CN_PACK_OPTIONS_VERSION; ?>
    </p>
    -->
    
</form>

<h3 class="title">翻译纠错、使用中文提交 bug、免费技术支持</h3>
<p>请点击页面上方的“帮助”以获取联系信息。</p>

</div><?php
}

function zh_cn_language_pack_backend_style_modify() {
    echo <<<EOF
<style type="text/css" media="screen">
    body { font: 13px "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif,"新宋体","宋体"; }
    #adminmenu .wp-submenu a { font-size: 11.5px; }
    #adminmenu a.menu-top { font-family: Georgia,"Times New Roman","Bitstream Charter",Times,serif,"Microsoft YaHei Bold","Microsoft YaHei","微软雅黑","WenQuanYi Zen Hei","文泉驿正黑","WenQuanYi Micro Hei","文泉驿微米黑","黑体"; }
    h1#site-heading span { font-family:  Georgia,"Times New Roman","Bitstream Charter",Times,serif,"Microsoft YaHei Bold","Microsoft YaHei","微软雅黑","WenQuanYi Zen Hei","文泉驿正黑","WenQuanYi Micro Hei","文泉驿微米黑","黑体"; }
    .form-table td { font-size: 12px; }
    #footer, #footer a, #footer p { font-size: 13px; font-style: normal; }
    #screen-meta a.show-settings { font-size: 12px; }
    #favorite-actions a { font-size: 12px; }
    .postbox p, .postbox ul, .postbox ol, .postbox blockquote, #wp-version-message { font-size: 13px; }
    #dashboard_right_now p.sub { font-size: 14px; font-style: normal; }
    .row-actions { font-size: 12px; }
    .widefat td, .widefat th, .widefat td p, .widefat td ol, .widefat td ul { font-size: 13px; }
    .submit input, .button, input.button, .button-primary, input.button-primary, .button-secondary, input.button-secondary, .button-highlighted, input.button-highlighted, #postcustomstuff .submit input { font-size: 12px !important; }
    .subsubsub { font-size: 12px; }
    #wpcontent select { font-size: 12px; }
    form.upgrade .hint { font-style: normal; font-weight: bold; font-size: 100% }
    #poststuff .inside, #poststuff .inside p { font-size: 12px; line-height: 112% }
    .tablenav .displaying-num { font-size: 12px; font-style: normal; }
    p.help, p.description, span.description, .form-wrap { font-size: 13px; }
    .widget .widget-inside, .widget .widget-description { font-size: 12px; }
    .appearance_page_custom-header #upload-form p label { font-size: 12px; }
    .wp_themeSkin .mceMenu span.mceText, .wp_themeSkin .mceMenu .mcePreview { font-size: 12px; }
    form .forgetmenot label { font-size: 12px; }
    .wrap h2 { font: normal 24px/35px Georgia,"Times New Roman","Bitstream Charter",Times,serif,"Microsoft YaHei Bold","Microsoft YaHei","微软雅黑","WenQuanYi Zen Hei","文泉驿正黑","WenQuanYi Micro Hei","文泉驿微米黑","黑体"; }
    .howto { font-style: normal; }
    p.help, p.description, span.description, .form-wrap p { font-style: normal; }
    .inline-edit-row fieldset span.title, .inline-edit-row fieldset span.checkbox-title { font-style: normal; }
    #edithead .inside, #edithead .inside input { font-size: 12px; }
    h2 .nav-tab { font: normal 24px/35px Georgia,"Times New Roman","Bitstream Charter",Times,serif,"Microsoft YaHei Bold","Microsoft YaHei","微软雅黑","WenQuanYi Zen Hei","文泉驿正黑","WenQuanYi Micro Hei","文泉驿微米黑","黑体"; }
    em { font-style: normal; }
    .menu-name-label span, .auto-add-pages label { font-size: 12px; }
    #dashboard_quick_press #media-buttons { font-size: 12px; }
    p.install-help { font-style: normal; }
    .inline-edit-row fieldset ul.cat-checklist label, .inline-edit-row .catshow, .inline-edit-row .cathide, .inline-edit-row #bulk-titles div { font-size: 12px; }
    #the-comment-list .comment-item p.row-actions { font-size: 12px; }
    #utc-time, #local-time { font-style: normal; }
</style>

EOF;
}

function zh_cn_language_pack_login_screen_style_modify() {
    echo <<<EOF
<style type="text/css" media="screen">
    body { font: 13px "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif,"新宋体","宋体"; }
    .submit input, .button, input.button, .button-primary, input.button-primary, .button-secondary, input.button-secondary, .button-highlighted, input.button-highlighted, #postcustomstuff .submit input { font-size: 12px !important; }
</style>

EOF;
}

add_action( 'admin_init', 'zh_cn_language_pack_backend_register_settings' );
add_action( 'admin_init', 'zh_cn_language_pack_init' );

if ( is_admin() ) {
    add_action( 'admin_menu', 'zh_cn_language_pack_backend_create_menu' );
    add_action( 'admin_head-settings_page_zh-cn-language-pack-settings', 'zh_cn_language_pack_contextual_help');
}

if ( get_option('zh_cn_language_pack_enable_backend_style_modifications') == 1 ) {
    add_action( 'admin_head', 'zh_cn_language_pack_backend_style_modify' );
    add_action( 'login_head', 'zh_cn_language_pack_login_screen_style_modify' );
}

?>
