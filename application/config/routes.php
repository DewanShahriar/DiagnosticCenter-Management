<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['gallery'] = "news/gallery_view";
$route['gallery-photo/(:any)'] = "news/image_gallery_view/$1";

$route['article/(:any)'] = "news/description/$1";
$route['article/(:any)/(:any)'] = "news/description/$1/$2";
$route['article/(:any)/(:any)/(:any)'] = "news/description/$1/$2/$3";
$route['article/(:any)/(:any)/(:any)/(:any)'] = "news/description/$1/$2/$3/$4";


$route['category/(:any)'] = "news/category/$1";
$route['category/(:any)/(:any)'] = "news/category/$1/$2";
$route['category/(:any)/(:any)/(:any)'] = "news/category/$1/$2/$3";
$route['category/(:any)/(:any)/(:any)/(:any)'] = "news/category/$1/$2/$3/$4";


//admin routing 
$route['admin'] = 'backend/admin';
$route['admin/(:any)'] = 'backend/admin/$1';
$route['admin/(:any)/(:any)'] = 'backend/admin/$1/$2';
$route['admin/(:any)/(:any)/(:any)'] = 'backend/admin/$1/$2/$3';
$route['admin/(:any)/(:any)/(:any)/(:any)'] = 'backend/admin/$1/$2/$3/$4';
$route['admin/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'backend/admin/$1/$2/$3/$4/$5';


//accounts routing 
$route['accounts'] = 'backend/accounts';
$route['accounts/(:any)'] = 'backend/accounts/$1';
$route['accounts/(:any)/(:any)'] = 'backend/accounts/$1/$2';
$route['accounts/(:any)/(:any)/(:any)'] = 'backend/accounts/$1/$2/$3';
$route['accounts/(:any)/(:any)/(:any)/(:any)'] = 'backend/accounts/$1/$2/$3/$4';
$route['accounts/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'backend/accounts/$1/$2/$3/$4/$5';

//accounts routing 
$route['lab'] = 'backend/lab';
$route['lab/(:any)'] = 'backend/lab/$1';
$route['lab/(:any)/(:any)'] = 'backend/lab/$1/$2';
$route['lab/(:any)/(:any)/(:any)'] = 'backend/lab/$1/$2/$3';
$route['lab/(:any)/(:any)/(:any)/(:any)'] = 'backend/lab/$1/$2/$3/$4';
$route['lab/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'backend/lab/$1/$2/$3/$4/$5';

//user routing
$route['user'] = 'backend/user';
$route['user/(:any)'] = 'backend/user/$1';
$route['user/(:any)/(:any)'] = 'backend/user/$1/$2';
$route['user/(:any)/(:any)/(:any)'] = 'backend/user/$1/$2/$3';


//login routing 
$route['login'] = 'backend/login';
$route['login/(:any)'] = 'backend/login/$1';
$route['login/(:any)/(:any)'] = 'backend/login/$1/$2';



$route['default_controller'] = 'site';

$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;
