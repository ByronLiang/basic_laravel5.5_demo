<?php
/**
 * 前台路由，默认路由，无前缀
 */

Route::group(['middleware' => ['spa:web']], function () {
    Route::group(['namespace' => 'My'], function () {
        Route::get('profile', 'MyController@getProfile');
    });
    Route::post('login', 'AuthController@postLogin');
    Route::post('register', 'AuthController@postRegister');
    Route::view('{capture?}', 'web')->where(['capture' => '.*']);
});
// Route::group(['middleware' => 'auth:web'], function () {

// });

// Route::get('/', function () {
//     return view('welcome');
// });
