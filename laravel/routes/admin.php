<?php
/**
 * 后台路由，url前缀 admin.
 */
Route::group(['middleware' => ['spa:admin']], function () {
    Route::post('auth/login', 'AuthController@postLogin');
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('my/profile', 'MyController@getProfile');
        Route::put('my/profile', 'MyController@putProfile');
        Route::get('my/logout', 'MyController@getLogout');

        Route::resources([
            'users' => 'UsersController',
        ]);
    });
    Route::view('{capture?}', 'admin')->where(['capture' => '.*']);
});
