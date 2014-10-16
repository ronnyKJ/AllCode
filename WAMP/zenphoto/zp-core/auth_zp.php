<?php
/**
 * processes the authorization (or login) of admin users
 * @package admin
 */

// force UTF-8 Ø

global $_zp_current_admin_obj, $_zp_loggedin, $_zp_null_account, $_zp_reset_admin, $_zp_authority;
$_zp_current_admin_obj = null;
if (file_exists(dirname(dirname(__FILE__)).'/'.USER_PLUGIN_FOLDER.'/alt/lib-auth.php')) { // load a custom authroization package if it is present
	require_once(dirname(dirname(__FILE__)).'/'.USER_PLUGIN_FOLDER.'/alt/lib-auth.php');
} else {
	require_once(dirname(__FILE__).'/lib-auth.php');
	$_zp_authority = new Zenphoto_Authority();
}
foreach ($_zp_authority->getRights() as $key=>$right) {
	define($key,$right['value']);
}

define('MANAGED_OBJECT_RIGHTS_EDIT', 1);
define('MANAGED_OBJECT_RIGHTS_UPLOAD', 2);
define('LIST_RIGHTS', NO_RIGHTS);

if (defined('VIEW_ALL_RIGHTS')) {
	define('VIEW_ALBUMS_RIGHTS',VIEW_ALL_RIGHTS);
	define('VIEW_PAGES_RIGHTS',VIEW_ALL_RIGHTS);
	define('VIEW_NEWS_RIGHTS',VIEW_ALL_RIGHTS);
	define('VIEW_SEARCH_RIGHTS',NO_RIGHTS);
	define('VIEW_GALLERY_RIGHTS',NO_RIGHTS);
	define('VIEW_FULLIMAGE_RIGHTS',NO_RIGHTS);
} else {
	define('VIEW_ALL_RIGHTS',VIEW_ALBUMS_RIGHTS|VIEW_PAGES_RIGHTS|VIEW_NEWS_RIGHTS);
}


// If the auth variable gets set somehow before this, get rid of it.
$_zp_loggedin = $_zp_null_account = false;
if (isset($_GET['ticket'])) { // password reset query
	$_zp_ticket = sanitize($_GET['ticket']);
	$post_user = sanitize($_GET['user']);
	$admins = $_zp_authority->getAdministrators();
	foreach ($admins as $tuser) {
		if ($tuser['user'] == $post_user && !empty($tuser['email'])) {
			$admin = $tuser;
			$_zp_request_date = getOption('admin_reset_date');
			$adm = $admin['user'];
			$pas = $admin['pass'];
			$ref = md5($_zp_request_date . $adm . $pas);
			if ($ref === $_zp_ticket) {
				if (time() <= ($_zp_request_date + (3 * 24 * 60 * 60))) { // limited time offer
					setOption('admin_reset_date', NULL);
					$_zp_reset_admin = new Zenphoto_Administrator($adm, 1);
					$_zp_null_account = true;
				}
			}
			break;
		}
	}
}



// we have the ssl marker cookie, normally we are already logged in
// but we need to redirect to ssl to retrive the auth cookie (set as secure).
if (zp_getCookie('zenphoto_ssl') && !secureServer()) {
	$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	header("Location:$redirect");
	exit();
}

if (isset($_POST['login'])) {
	// Handle the login form.
	if (isset($_POST['login']) && isset($_POST['user']) && isset($_POST['pass'])) {
		$post_user = sanitize($_POST['user']);
		$post_pass = sanitize($_POST['pass'],0);
		$redirect = sanitize_path($_POST['redirect']);
		$_zp_loggedin = $_zp_authority->checkLogon($post_user, $post_pass, true);
		$_zp_loggedin = zp_apply_filter('admin_login_attempt', $_zp_loggedin, $post_user, $post_pass);
		if ($_zp_loggedin) {
			// https: set the 'zenphoto_ssl' marker for redirection
			if(secureServer()) {
				zp_setcookie("zenphoto_ssl", "needed");
			}
			// set cookie as secure when in https
			zp_setcookie("zenphoto_auth", $_zp_authority->passwordHash($post_user, $post_pass), NULL, NULL, secureServer());
			if (!empty($redirect)) {
				if (substr($redirect,0,1) != '/') $redirect = '/'.$redirect;
				header("Location: " . FULLWEBPATH . $redirect);
				exit();
			}
		} else {
			// Clear the cookie, just in case
			zp_setcookie("zenphoto_auth", "", time()-368000);
			zp_setcookie("zenphoto_ssl", "", time()-368000);
			// was it a request for a reset?
			if (isset($_POST['code_h']) && $_zp_captcha->checkCaptcha(trim($post_pass), sanitize($_POST['code_h'],3))) {
				require_once(dirname(__FILE__).'/class-load.php'); // be sure that the plugins are loaded for the mail handler
				if (empty($post_user)) {
					$requestor = gettext('You are receiving this e-mail because of a password reset request on your Zenphoto gallery.');
				} else {
					$requestor = sprintf(gettext("You are receiving this e-mail because of a password reset request on your Zenphoto gallery from a user who tried to log in as %s."),$post_user);
				}
				$admins = $_zp_authority->getAdministrators();
				$mails = array();
				$user = NULL;
				foreach ($admins as $key=>$tuser) {
					if (!empty($tuser['email'])) {
						if (!empty($post_user) && ($tuser['user'] == $post_user || $tuser['email'] == $post_user)) {
							$name = $tuser['name'];
							if (empty($name)) {
								$name = $tuser['user'];
							}
							$mails[$name] = $tuser['email'];
							$user = $tuser;
							unset($admins[$key]);	// drop him from alternate list.
						} else {
							if (!($tuser['rights'] & ADMIN_RIGHTS)) {
								unset($admins[$key]);	// eliminate any peons from the list
							}
						}
					} else {
						unset($admins[$key]);	// we want to ignore groups and users with no email address here!
					}
				}

				$cclist = array();
				foreach ($admins as $tuser) {
					$name = $tuser['name'];
					if (empty($name)) {
						$name = $tuser['user'];
					}
					if (is_null($user)) {
						$user = $tuser;
						$mails[$name] = $tuser['email'];
					} else {
						$cclist[$name] = $tuser['email'];
					}
				}
				if (is_null($user)) {
					$_zp_login_error = gettext('There was no one to which to send the reset request.');
				} else {
					$adm = $user['user'];
					$pas = $user['pass'];
					setOption('admin_reset_date', time());
					$req = getOption('admin_reset_date');
					$ref = md5($req . $adm . $pas);
					$msg = "\n".$requestor.
							"\n".sprintf(gettext("To reset your Zenphoto Admin passwords visit: %s"),FULLWEBPATH."/".ZENFOLDER."/admin-users.php?ticket=$ref&user=$adm") .
							"\n".gettext("If you do not wish to reset your passwords just ignore this message. This ticket will automatically expire in 3 days.");
					$err_msg = zp_mail(gettext("The Zenphoto information you requested"), $msg, $mails, $cclist);
					if (empty($err_msg)) {
						$_zp_login_error = 2;
					} else {
						$_zp_login_error = $err_msg;
					}
				}
			} else {
				$_zp_login_error = 1;
			}
		}
	}
} else {	//	no login form, check the cookie
	$_zp_loggedin = $_zp_authority->checkAuthorization(zp_getCookie('zenphoto_auth'));
	$_zp_null_account = $_zp_loggedin == ADMIN_RIGHTS;
	if (is_object($_zp_current_admin_obj)) {
		$locale = $_zp_current_admin_obj->getLanguage();
		if (!empty($locale)) {	//	set his prefered language
			setupCurrentLocale($locale);
		}
		$_zp_loggedin = zp_apply_filter('authorization_cookie',$_zp_loggedin);
	} else {
		// Clear the cookie
		zp_setcookie("zenphoto_auth", "", time()-368000);
		zp_setcookie("zenphoto_ssl", "", time()-368000);
	}
}
unset($saved_auth, $check_auth, $user, $pass);
// Handle a logout action.
if (isset($_REQUEST['logout'])) {
	zp_setcookie("zenphoto_auth", "*", time()-368000);
	zp_setcookie("zenphoto_ssl", "", time()-368000);
	$redirect = '';
	if (isset($_GET['p'])) { $redirect .= "&p=" . sanitize($_GET['p']); }
	if (isset($_GET['searchfields'])) { $redirect .= "&searchfields=" . sanitize($_GET['searchfields']); }
	if (isset($_GET['words'])) { $redirect .= "&words=" . sanitize($_GET['words']); }
	if (isset($_GET['date'])) { $redirect .= "&date=" . sanitize($_GET['date']); }
	if (isset($_GET['album'])) { $redirect .= "&album=" . sanitize($_GET['album']); }
	if (isset($_GET['image'])) { $redirect .= "&image=" . sanitize($_GET['image']); }
	if (isset($_GET['title'])) { $redirect .= "&title=" . sanitize($_GET['title']); }
	if (isset($_GET['page'])) { $redirect .= "&page=" . sanitize($_GET['page']); }
	if (!empty($redirect)) $redirect = '?'.substr($redirect, 1);
	if ($_GET['logout']) {
		$rd_protocol = 'https';
	} else {
		$rd_protocol = 'http';
	}
	$location = $rd_protocol."://".$_SERVER['HTTP_HOST'].WEBPATH.'/index.php'.$redirect;
	header("Location: " . $location);
	exit();
}

?>
