<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** 認證 */
Route::group(['prefix' => 'auth'], function () {
    /** 取得資訊 */
    Route::get('me', 'AuthController@me');
    /** 登入 */
    Route::post('login', 'AuthController@login');
    /** 登出 */
    Route::post('logout', 'AuthController@logout');
    /** 更換Token */
    Route::post('refresh', 'AuthController@refresh');
});

/** User */
Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    /** 使用者列表 */
    Route::get('/', 'UserController@index')->name('index');
    /** 查看使用者 */
    Route::get('/{id}', 'UserController@show')->name('show');
});
