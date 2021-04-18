<?php

/**
 * Auth Route's
 */
 Route::post('/login', 'AuthController@login');
 Route::post('/social/login', 'AuthController@socialLogin');
 Route::post('/signup', 'AuthController@signup');
 Route::get('/get/profile', 'AuthController@getProfile');
 Route::post('/update/profile', 'AuthController@updateProfile');
 Route::post('/change/password', 'AuthController@changePassword');
 Route::post('/forgot/password', 'AuthController@forgotPassword');

 Route::get('/exist/rut/number', 'AuthController@exitRutNumber');
 Route::get('/check/rut/number', 'AuthController@checkRutNumber');
 Route::post('/update/current/location', 'AuthController@updateCurrentLocation');
 Route::post('/forgot/password', 'AuthController@forgotPassword');

 /**
  * Home Route's
  */
  Route::get('/get/categories', 'HomeController@getCategories');
  Route::get('/get/services', 'HomeController@getServices');
  Route::get('/get/vendors', 'HomeController@getVendors');
  Route::get('/get/vendor/details', 'HomeController@getVendorDetails');
  Route::post('/book/service', 'HomeController@bookService');
  Route::get('/get/bookings', 'HomeController@getBookings');
  Route::get('/get/booking/details', 'HomeController@getBookingDetails');
  Route::post('/cancel/booking', 'HomeController@cancelBooking');
  Route::get('/get/booking/history', 'HomeController@getBookingHistory');
  Route::post('/give/rating', 'HomeController@giveRating');
  Route::get('/get/notifications', 'HomeController@getNotifications');

  Route::post('/send/message', 'HomeController@sendMessage');
  Route::get('/get/conversation/users', 'HomeController@getConversationUsers');
  Route::get('/get/conversations', 'HomeController@getConversations');

  Route::get('/get/plans', 'HomeController@getPlans');
  Route::post('/buy/plan', 'HomeController@buyPlan');
  Route::get('/get/my/plan', 'HomeController@getMyPlan');

  Route::get('/get/home', 'HomeController@home');
  Route::get('/get/offers', 'HomeController@offers');
  Route::get('/get/inspirations', 'HomeController@inspirations');

  Route::get('/get/reviews','HomeController@getReview');

  

  


  



 



