<?php
/**
 *
 * Zenphoto cron task handler
 */

define('OFFSET_PATH', 1);

require_once('admin-functions.php');
require_once('admin-globals.php');

$_zp_current_admin_obj = $_zp_loggedin = $_zp_null_account = NULL;
$link = sanitize($_POST['link']);
if (isset($_POST['auth'])) {
	$auth = $_POST['auth'];
	$admins = $_zp_authority->getAdministrators();
	foreach ($admins as $admin) {
		if (md5($link.serialize($admin)) == $auth && $admin['rights'] & UPLOAD_RIGHTS) {
			$_zp_loggedin = $_zp_authority->checkAuthorization($admin['pass']);
			$_zp_current_admin_obj = $_zp_authority->newAdministrator($admin['user']);
			break;
		}
	}
}


admin_securityChecks(NULL, currentRelativeURL(__FILE__));

if (isset($_POST['XSRFTag'])) {
	$_REQUEST['XSRFToken'] = $_POST['XSRFToken'] = $_GET['XSRFToken'] = getXSRFToken(sanitize($_POST['XSRFTag']));
} else {
	unset($_POST['XSRFToken']);
	unset($_GET['XSRFToken']);
	unset($_REQUEST['XSRFToken']);
}
require_once($link);

?>