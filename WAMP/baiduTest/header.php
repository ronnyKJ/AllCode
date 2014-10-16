<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<script src="<?php bloginfo('template_directory'); ?>/focus.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/tabber.js" type="text/javascript"></script>
<?php wp_head(); ?>
</head>
<body>
<div id="main">
<div id="wrapper">

	<div id="top">
		<div id="logo"><h1><a href="<?php echo get_option('home'); ?>/" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
		</div>
		<div id="menu">
			<ul>
			<li class="<?php if (((is_home()) && !(is_paged())) or (is_archive()) or (is_single()) or (is_paged()) or (is_search())) { ?>current_page_item<?php } else { ?>page_item<?php } ?>"><a href="<?php echo get_settings('home'); ?>" title="Home">Home</a></li>
<?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
<li id="searchbox">
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
		<input type="text" onfocus="if (this.value == 'Search...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search...';}" name="s" id="s" />
		<input type="image" src="<?php bloginfo('template_directory'); ?>/images/transparent.gif" id="go" alt="Search" title="Search" />
		</form>
</li>
</ul>
	  </div>
</div>
<div id="content">
