<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller'] = 'kweb/index';
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * /
# kweb
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * /*/
$route['index/(:any)'] = 'kweb/index/$1';
$route['index'] = 'kweb/index/index';

$route['member/(:any)'] = 'kweb/member/$1';
$route['member'] = 'kweb/member/index';

$route['login/(:any)'] = 'kweb/login/$1';
$route['login'] = 'kweb/login/index';

$route['register/(:any)'] = 'kweb/register/$1';
$route['register'] = 'kweb/register/index';

$route['card/(:any)'] = 'kweb/card/$1';
$route['card'] = 'kweb/card/index';

$route['sale/(:any)'] = 'kweb/sale/$1';
$route['sale'] = 'kweb/sale/index';

$route['spell/(:any)'] = 'kweb/spell/$1';
$route['spell'] = 'kweb/spell/index';

$route['gift/(:any)'] = 'kweb/gift/$1';
$route['gift'] = 'kweb/gift/index';

$route['life/(:any)'] = 'kweb/life/$1';
$route['life'] = 'kweb/life/index';

$route['news/(:any)'] = 'kweb/news/$1';
$route['news'] = 'kweb/news/index';

$route['info/(:any)'] = 'kweb/info/$1';
$route['info'] = 'kweb/info/index';

$route['changepwd/(:any)'] = 'kweb/changepwd/$1';
$route['changepwd'] = 'kweb/changepwd/index';
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * /
# kadmin
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * /

/* kadmin/menuframe */
$route['kadmin/menuframe/(:num)'] = 'kadmin/menuframe/indexn/$1';