<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('api/reset/password/success',function(){ return view('api.forgot_password_success_response'); })->name('api.rest.password.success');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Membership Plan
 */
Route::get('/mebership/plans', 'MembershipPlanController@index')->name('index.membership');
Route::get('/create/membership/plan', 'MembershipPlanController@create')->name('create.membership');
Route::post('/store/membership/plan', 'MembershipPlanController@store')->name('store.membership');
Route::get('/edit/membership/plan/{id}', 'MembershipPlanController@edit')->name('edit.membership');
Route::put('/update/membership/plan/{id}', 'MembershipPlanController@update')->name('update.membership');
Route::delete('/delete/membership/plan', 'MembershipPlanController@destroy')->name('destroy.membership');
Route::get('/export/membership/plan', 'MembershipPlanController@export')->name('export.membership');

Route::get('/profile', 'HomeController@profile')->name('profile');
Route::put('/update/profile', 'HomeController@updateProfile')->name('update.profile');
Route::put('/add/service', 'HomeController@addService')->name('add.service');
Route::put('/change/password', 'HomeController@changePassword')->name('change.password');

Route::get('/marchants', 'HomeController@marchants')->name('marchants');
Route::get('/marchant/details/{id}', 'HomeController@marchantDetails')->name('marchant.details');
Route::get('marchants/export/', 'HomeController@exportMarchants')->name('export.marchants');

Route::get('/members', 'HomeController@members')->name('members');
Route::get('/member/details/{id}', 'HomeController@memberDetails')->name('member.details');
Route::get('members/export/', 'HomeController@exportMembers')->name('export.members');

Route::delete('/delete/account', 'HomeController@deleteAccount')->name('delete.account');
Route::put('/active/account', 'HomeController@activeAccount')->name('active.account');
Route::put('/deactive/account', 'HomeController@deactiveAccount')->name('deactive.account');

Route::get('/products', 'HomeController@products')->name('products');
Route::get('/product/details/{id}', 'HomeController@productDetails')->name('product.details');
Route::delete('/delete/product', 'HomeController@deleteProduct')->name('delete.product');
Route::get('products/export/', 'HomeController@exportProducts')->name('export.products');

/**
 *  Banner Route's
 */
Route::get('get/banners', 'BannerController@index')->name('index.banner');
Route::get('create/banner', 'BannerController@create')->name('create.banner');
Route::post('store/banner', 'BannerController@store')->name('store.banner');
Route::get('show/banner/{id}', 'BannerController@show')->name('show.banner');
Route::put('update/banner/{id}', 'BannerController@update')->name('update.banner');
Route::delete('delete/banner', 'BannerController@destroy')->name('delete.banner');


/**
 * Category Route's
 */
Route::get('get/categories', 'CategoryController@index')->name('index.category');
Route::get('create/category', 'CategoryController@create')->name('create.category');
Route::post('store/category', 'CategoryController@store')->name('store.category');
Route::get('show/category/{id}', 'CategoryController@show')->name('show.category');
Route::put('update/category/{id}', 'CategoryController@update')->name('update.category');
Route::delete('delete/category', 'CategoryController@destroy')->name('delete.category');

/**
 * Service Route's
 */
Route::get('get/services', 'ServiceController@index')->name('index.service');
Route::get('create/service', 'ServiceController@create')->name('create.service');
Route::post('store/service', 'ServiceController@store')->name('store.service');
Route::get('show/service/{id}', 'ServiceController@show')->name('show.service');
Route::put('update/service/{id}', 'ServiceController@update')->name('update.service');
Route::delete('delete/service', 'ServiceController@destroy')->name('delete.service');

/**
 * Vendor Route's
 */
Route::get('get/vendors', 'VendorController@index')->name('index.vendor');
Route::get('create/vendor', 'VendorController@create')->name('create.vendor');
Route::post('store/vendor', 'VendorController@store')->name('store.vendor');
Route::get('show/vendor/{id}', 'VendorController@show')->name('show.vendor');
Route::put('update/vendor/{id}', 'VendorController@update')->name('update.vendor');
Route::get('export/vendor', 'VendorController@export')->name('export.vendor');
Route::put('active/vendor', 'VendorController@activeAccount')->name('active.vendor');
Route::delete('delete/vendor', 'VendorController@destroy')->name('delete.vendor');
Route::put('/deactive/vendor', 'VendorController@deactiveAccount')->name('deactive.vendor');

/**
 * User Route's
 */
Route::get('get/users', 'UserController@index')->name('index.user');
Route::get('show/user/{id}', 'UserController@show')->name('show.user');
Route::put('update/user/{id}', 'UserController@update')->name('update.user');
Route::get('export/user', 'UserController@export')->name('export.user');
Route::put('active/user', 'UserController@activeAccount')->name('active.user');
Route::delete('delete/user', 'UserController@destroy')->name('delete.user');
Route::put('/deactive/user', 'UserController@deactiveAccount')->name('deactive.user');

/**
 * My Service Route's
 */
Route::get('get/myservices', 'MyServiceController@index')->name('index.myservice');
Route::get('create/myservice', 'MyServiceController@create')->name('create.myservice');
Route::post('store/myservice', 'MyServiceController@store')->name('store.myservice');
Route::get('show/myservice/{id}', 'MyServiceController@show')->name('show.myservice');
Route::put('update/myservice/{id}', 'MyServiceController@update')->name('update.myservice');
Route::delete('delete/myservice', 'MyServiceController@destroy')->name('delete.myservice');
Route::get('ajax/get/services', 'MyServiceController@getServices')->name('ajax.get.services');

/**
 * Booking Route's
 */
Route::get('bookings','BookingController@index')->name('index.booking');
Route::get('booking/details/{id}', 'BookingController@show')->name('show.booking');
Route::put('booking/status/{id}', 'BookingController@status')->name('status.booking');

/**
 * Plan Route's
 */
Route::get('get/plans','HomeController@planList')->name('index.plan');
Route::get('buy/plan','HomeController@buyPlan')->name('buy.plan');