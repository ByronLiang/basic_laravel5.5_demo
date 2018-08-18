<?php
/**
 * API路由，url前缀 api.
 */
Route::group(['middleware' => 'auth:api'], function () {
});
