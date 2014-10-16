<?php if (!defined('WEBPATH')) die(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php echo gettext("Password required"); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
</head>

<body>

<div id="main">

	<div id="gallerytitle">
		<h2><?php echo gettext("A password is required for the page you requested"); ?></h2>
	</div>

		<div id="padbox">
		<?php printPasswordForm($hint, $show); ?>
	</div>

</div>

<div id="credit">
	<?php printZenphotoLink(); ?>
</div>
</body>
</html>
