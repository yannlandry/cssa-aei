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

$route['nouvelles'] = "news/index";
$route['nouvelles/(:num)/(:num)'] = "news/index/$1/$2";
$route['nouvelles/(:num)'] = "news/view/$1";

$route['evenements'] = "events/index";
$route['evenements/(:num)'] = "events/view/$1";

$route['contact'] = "main/contact";

$route['login'] = "main/login";
$route['logout'] = "main/logout";

$route['api/news'] = "api/news";

$route['admin/nouvelles'] = "admin/news";
$route['admin/nouvelles/(:num)/supp'] = "admin/deletenews/$1";
$route['admin/nouvelles/(:num)'] = "admin/editnews/$1";
$route['admin/nouvelles/nouv'] = "admin/newnews";

$route['admin/pages'] = "admin/pages";
$route['admin/pages/(:num)/supp'] = "admin/deletepage/$1";
$route['admin/pages/(:num)'] = "admin/editpage/$1";
$route['admin/pages/nouv'] = "admin/newpage";

$route['admin/comptes'] = "admin/accounts";
$route['admin/comptes/(:num)/supp'] = "admin/deleteaccount/$1";
$route['admin/comptes/(:num)'] = "admin/editaccount/$1";
$route['admin/comptes/nouv'] = "admin/newaccount";

$route['admin/images'] = "admin/pictures";
$route['admin/images/supp/(:any)'] = "admin/deletepicture/$1";

$route['admin/fichiers'] = "admin/files";
$route['admin/fichiers/supp/(:any)'] = "admin/deletefile/$1";

$route['admin/menu'] = "admin/menu";
$route['admin/diaporama'] = "admin/slideshow";
$route['admin/messages'] = "admin/messages";
$route['admin/moncompte'] = "admin/myaccount";
$route['admin/(:any)'] = "admin/index";
$route['admin'] = "admin/index";

$route['(:any)'] = "pages/view/$1";
$route['default_controller'] = "main/index";


/* End of file routes.php */
/* Location: ./application/config/routes.php */