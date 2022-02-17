<?php
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE");
header('Access-Control-Allow-Credentials: true');
// header('Content-Type: plain/text');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

require_once __DIR__.'/vendor/autoload.php' ;
use NoahBuscher\Macaw\Macaw;
//Macaw::get('user/index','controllers\UserController@get_info');
//Macaw::dispatch();

//print_r($_SERVER);
Macaw::get('mvc/category/list', 'app\controllers\CategoryController@read');
Macaw::post('mvc/category/create', 'app\controllers\CategoryController@create');
Macaw::put('mvc/category/update', 'app\controllers\CategoryController@update');
Macaw::delete('mvc/category/delete/(:num)', 'app\controllers\CategoryController@delete');
Macaw::get('mvc/category/page/(:num)', 'app\controllers\CategoryController@paging');

Macaw::get('mvc/news/list', 'app\controllers\NewsController@read_all');
Macaw::post('mvc/news/create', 'app\controllers\NewsController@create');
Macaw::put('mvc/news/update', 'app\controllers\NewsController@update');
Macaw::delete('mvc/news/delete/(:num)', 'app\controllers\NewsController@delete');
Macaw::get('mvc/news/read-by-category/(:num)', 'app\controllers\NewsController@read_by_category');
Macaw::get('mvc/news/read-by-id/(:num)', 'app\controllers\NewsController@read_by_id');
Macaw::post('mvc/news/search', 'app\controllers\NewsController@search');
Macaw::get('mvc/news/page/(:num)', 'app\controllers\NewsController@paging');
Macaw::get('mvc/news/num-record', 'app\controllers\NewsController@total_record');


Macaw::post('mvc/admin/login', 'app\controllers\AdminController@login');
Macaw::delete('mvc/admin/logout', 'app\controllers\AdminController@logout');


try {
    Macaw::dispatch();
}catch (\mysql_xdevapi\Exception $e){

};



