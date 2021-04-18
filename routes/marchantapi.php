<?php

/**
 * Auth Route's
 */
 Route::post('/login', 'AuthController@login');
 Route::post('/signup', 'AuthController@signup');
 Route::get('/get/profile', 'AuthController@getProfile');
 Route::post('/update/profile', 'AuthController@updateProfile');
 Route::post('/forgot/password', 'AuthController@forgotPassword');
 Route::post('/change/password', 'AuthController@changePassword');
 Route::post('/forgot/password', 'AuthController@forgotPassword');
 
 /*
 * Home Routes
 */
Route::get('/get/coupon/code', 'HomeController@getCouponCode');
Route::get('/get/all/products', 'HomeController@getAllProducts');
Route::post('add/bank/details','HomeController@addBankDetails');
Route::get('get/limitation','HomeController@getLimitation');

 /**
  * Product Route's
  */
  Route::post('/create/product', 'ProductController@create');
  Route::get('/get/products', 'ProductController@index');
  Route::get('/get/product/detail', 'ProductController@detail');
  Route::post('/update/product', 'ProductController@update');
  Route::post('/delete/product', 'ProductController@destroy');

  /**
  * Gift Product Route's
  */
  Route::post('/create/gift/product', 'GiftProductController@create');
  Route::get('/get/gift/products', 'GiftProductController@index');
  Route::get('/get/gift/product/detail', 'GiftProductController@detail');
  Route::post('/update/gift/product', 'GiftProductController@update');
  Route::post('/delete/gift/product', 'GiftProductController@destroy');
  


