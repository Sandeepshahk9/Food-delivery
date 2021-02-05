<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});*/
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
	
	Route::get('/', 'IndexController@index');
	
	Route::post('login', 'IndexController@postLogin');
	Route::get('logout', 'IndexController@logout');
	 
	Route::get('dashboard', 'DashboardController@index');
	
	Route::get('profile', 'AdminController@profile');	
	Route::post('profile', 'AdminController@updateProfile');	
	Route::post('profile_pass', 'AdminController@updatePassword');
	
	Route::get('settings', 'SettingsController@settings');	
	Route::post('settings', 'SettingsController@settingsUpdates');	
	Route::post('homepage_settings', 'SettingsController@homepage_settings');	
	Route::post('addthisdisqus', 'SettingsController@addthisdisqus');	
	Route::post('headfootupdate', 'SettingsController@headfootupdate');

	 
	Route::get('types', 'TypesController@types');	
	Route::get('types/addtype', 'TypesController@addeditType'); 
	Route::get('types/addtype/{id}', 'TypesController@editType');	
	Route::post('types/addtype', 'TypesController@addnew');	
	Route::get('types/delete/{id}', 'TypesController@delete');


	Route::get('restaurants', 'RestaurantsController@restaurants');	
	Route::get('restaurants/addrestaurant', 'RestaurantsController@addeditrestaurant'); 
	Route::get('restaurants/addrestaurant/{id}', 'RestaurantsController@editrestaurant');	
	Route::get('restaurants/images/{id}', 'RestaurantsController@restaurants_images');	
	Route::get('restaurants/images_delete/{id}/{res_id}', 'RestaurantsController@images_delete');	
	Route::get('restaurants/addimages/{id}', 'RestaurantsController@restaurants_addimages');	
	Route::post('restaurants/addimages', 'RestaurantsController@addimages');	
	Route::post('restaurants/addrestaurant', 'RestaurantsController@addnew');	
	Route::get('restaurants/delete/{id}', 'RestaurantsController@delete');
	Route::get('restaurants/view/{id}', 'RestaurantsController@restaurantview');	
	
	Route::get('restaurants/view/{id}/categories', 'CategoriesController@categories');
	Route::get('restaurants/view/{id}/categories/addcategory', 'CategoriesController@addeditCategory'); 
	Route::get('restaurants/view/{id}/categories/addcategory/{cat_id}', 'CategoriesController@editCategory');	
	Route::post('restaurants/view/{id}/categories/addcategory', 'CategoriesController@addnew');
	Route::get('restaurants/view/{id}/categories/delete/{cat_id}', 'CategoriesController@delete'); 
	
	Route::get('restaurants/view/{id}/menu', 'MenuController@menulist');
	Route::post('import_excel', 'MenuController@import_excel');
	Route::get('restaurants/view/{id}/menu/addmenu', 'MenuController@addeditmenu'); 
	Route::get('restaurants/view/{id}/menu/addmenu/{menu_id}', 'MenuController@editmenu');	
	Route::post('restaurants/view/{id}/menu/addmenu', 'MenuController@addnew');
	Route::get('restaurants/view/{id}/menu/delete/{menu_id}', 'MenuController@delete');

	Route::get('restaurants/view/{id}/orderlist', 'OrderController@orderlist');
	Route::get('restaurants/view/{id}/orderlist/{order_id}/{status}', 'OrderController@order_status');
	Route::get('restaurants/view/{id}/orderlist/{order_id}', 'OrderController@delete');

	Route::get('restaurants/view/{id}/review', 'RestaurantsController@reviewlist');

	Route::get('allorder', 'OrderController@alluser_order');

	//Owner
	Route::get('myrestaurants', 'RestaurantsController@my_restaurants');

	Route::get('categories', 'CategoriesController@owner_categories');		
	Route::get('categories/addcategory', 'CategoriesController@owner_addeditCategory'); 
	Route::get('categories/addcategory/{cat_id}', 'CategoriesController@editCategory');	
	Route::post('categories/addcategory', 'CategoriesController@addnew');
	Route::get('categories/delete/{cat_id}', 'CategoriesController@delete');

	Route::get('menu', 'MenuController@owner_menu');
	Route::get('menu/addmenu', 'MenuController@owner_addeditmenu'); 
	Route::get('menu/addmenu/{menu_id}', 'MenuController@owner_editmenu');	
	Route::post('menu/addmenu', 'MenuController@addnew');
	Route::get('menu/delete/{menu_id}', 'MenuController@delete'); 
	
	Route::get('location', 'LocationController@location_list');
	Route::get('location/addlocation', 'LocationController@addeditlocation'); 
	Route::get('location/editlocation/{loc_id}', 'LocationController@editlocation');	
	Route::post('location/addlocation', 'LocationController@addnew');
	Route::get('location/delete/{loc_id}', 'LocationController@delete'); 

	Route::get('orderlist', 'OrderController@owner_orderlist');
	Route::get('orderlist/{order_id}/{status}', 'OrderController@owner_order_status');
	Route::get('orderlist/{order_id}', 'OrderController@owner_delete');

	Route::get('reviews', 'RestaurantsController@owner_reviewlist');

	 

	
	Route::get('users', 'UsersController@userslist');	
	Route::get('users/adduser', 'UsersController@addeditUser');	
	Route::post('users/adduser', 'UsersController@addnew');	
	Route::get('users/adduser/{id}', 'UsersController@editUser');	
	Route::get('users/delete/{id}', 'UsersController@delete');	
	
	Route::get('widgets', 'WidgetsController@index');	
	Route::post('footer_widgets', 'WidgetsController@footer_widgets');
	Route::post('about_widgets', 'WidgetsController@about_widgets');	
	Route::post('socialmedialink', 'WidgetsController@socialmedialink');	
	Route::post('need_help', 'WidgetsController@need_help');	
	Route::post('featuredpost', 'WidgetsController@featuredpost');	
	Route::post('advertise', 'WidgetsController@advertise');
	
});

Route::get('/', 'IndexController@index');
Route::get('home', 'IndexController@index');

Route::get('login', 'IndexController@login');

Route::post('login', 'IndexController@postLogin');

Route::get('forgot_password', 'IndexController@forgot_password');

Route::post('forgot_password', 'IndexController@postforgot_password');

Route::get('register', 'IndexController@register');

Route::post('register', 'IndexController@register_user');

Route::get('logout', 'IndexController@logout');

Route::get('profile', 'IndexController@profile');

Route::post('profile', 'IndexController@editprofile');

Route::get('change_pass/{token}', 'IndexController@change_newpassword');
Route::post('change_newpassword', 'IndexController@edit_newpassword');
Route::get('change_pass', 'IndexController@change_password');

Route::post('change_pass', 'IndexController@edit_password');


Route::get('about', 'IndexController@about_us');

Route::get('contact', 'IndexController@contact_us');

Route::get('search', 'RestaurantsController@search');

Route::get('restaurants', 'RestaurantsController@index');
Route::post('restaurants', 'RestaurantsController@restaurants_search');

//Route::get('restaurants/type/{type}', 'RestaurantsController@restaurants_type');
Route::get('restaurants/type/{type}', 'RestaurantsController@restaurants_search_home');

Route::get('restaurants/rating/{rating}', 'RestaurantsController@restaurants_rating');



Route::get('restaurants/menu/{slug}', 'RestaurantsController@restaurants_menu');
Route::post('restaurants/menu/{slug}', 'RestaurantsController@restaurants_search_menu');

Route::get('restaurants/{slug}', 'RestaurantsController@restaurants_details');

Route::post('restaurants/{slug}/restaurant_review', 'RestaurantsController@restaurant_review');

Route::get('add_item/{item_id}/{field_name}/{menu_price}/{row_num}/{slug}', 'CartController@add_cart_item');

Route::get('delete_item/{item_id}', 'CartController@delete_cart_item');

//Route::get('order_details', 'CartController@order_details');
Route::get('order_details', 'CartController@order_details');

Route::post('order_details', 'CartController@confirm_order_details');
Route::post('order_confirm_sms', 'CartController@confirm_order_sms_details');

Route::get('myorder', 'CartController@user_orderlist');

Route::get('cancel_order/{order_id}', 'CartController@cancel_order');
Route::get('apply_coupon/{coupon_code}/{user_id}', 'CartController@apply_coupon');
Route::get('auto_refresh/{tot}/{res_id}', 'CartController@auto_refresh');
Route::get('send_otp', 'CartController@send_otp');
Route::post('location_submit', 'CartController@location_submit');




// Password reset link request routes...
Route::get('admin/password/email', 'Auth\PasswordController@getEmail');
Route::post('admin/password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('admin/password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('admin/password/reset', 'Auth\PasswordController@postReset');

Route::post('contact_send', 'IndexController@contact_send');
Route::get('check_otp/{otp}', 'IndexController@check_otp');

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});
Route::get('404',['as'=>'404','uses'=>'ErrorHandlerController@errorCode404']);
 
