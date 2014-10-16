<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<div class="tabber">

<div class="tabbertab">
<h2>Recent Post</h2>
<ul>
<?php
$myposts = get_posts('numberposts=10&offset=1&category');
foreach($myposts as $post) :
?>
<li>&nbsp;<a href="<?php the_permalink(); ?>"><?php the_title();
?></a></li>
<?php endforeach; ?>
</ul>
</div>

<div class="tabbertab">
<h2>Recent Comments</h2>
<?php
global $wpdb;

$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
comment_post_ID, comment_author, comment_date_gmt, comment_approved,
comment_type,comment_author_url,
SUBSTRING(comment_content,1,76) AS com_excerpt
FROM $wpdb->comments
LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =
$wpdb->posts.ID)
WHERE comment_approved = '1' AND comment_type = '' AND
post_password = ''
ORDER BY comment_date_gmt DESC
LIMIT 10";
$comments = $wpdb->get_results($sql);

$output = $pre_HTML;
$output .= "\n<ul>";
foreach ($comments as $comment) {
$output .= "\n<li>".strip_tags($comment->comment_author)
.":" . "<a href=\"" . get_permalink($comment->ID) .
"#comment-" . $comment->comment_ID . "\" title=\"on " .
$comment->post_title . "\">" . strip_tags($comment->com_excerpt)
."</a></li>";

}
$output .= "\n</ul>";
$output .= $post_HTML;
echo $output;?>
</div>

<div class="tabbertab">
<h2>Categories</h2>
<ul>
<?php wp_list_categories('show_count=1&title_li='); ?>
</ul>
</div>

<div class="tabbertab">
<h2>Archives</h2>
<ul>
<?php wp_get_archives('type=monthly'); ?>
</ul>
</div>

<div class="tabbertab">
<h2>Count</h2>
<a href="http://s03.flagcounter.com/more/4TE"><img src="http://s03.flagcounter.com/count/4TE/bg=FFFFFF/txt=000000/border=CCCCCC/columns=4/maxflags=24/viewers=0/labels=0/pageviews=1/" alt="free counters" border="0"></a>
</div>
<div class="tabbertab">
<h2>douban</h2>
<div><script type="text/javascript">
AC_FL_RunContent( 'codebase','http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0','width','933','height','155','id','passing','src','http://www.douban.com/doushow/2631195/collection_random__7_7_medium_nologo_noself/doushow','wmode','transparent','quality','high','name','passing','scale','noscale','align','tl','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','http://www.douban.com/doushow/2631195/collection_random__7_7_medium_nologo_noself/doushow' ); //end AC code
</script><noscript><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="933" height="155" id="passing" > <param name="movie" value="http://www.douban.com/doushow/2631195/collection_random__7_7_medium_nologo_noself/doushow.swf" /> <param name="quality" value="high" /> <param name="scale" value="noscale"/> <param name="align" value="tl"/> <param name="wmode" value="transparent"/> <embed src="http://www.douban.com/doushow/2631195/collection_random__7_7_medium_nologo_noself/doushow.swf" wmode="transparent" quality="high" width="933" height="155" name="passing" scale="noscale" align="tl" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /> </object></noscript></div></div>

</div>
<div id="tab">
</div>