<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    /** 取得登入資訊 */
    Route::get('/info', 'UserController@getInfo')->name('info');
    /** 註冊 */
    Route::post('/register', 'RegisterController@register')->name('register');
});

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    /** 登入 */
    Route::post('login', 'AuthController@login')->name('login');
    /** 登出 */
    Route::post('logout', 'AuthController@logout')->name('logout');
    /** 更換Token */
    Route::post('refresh', 'AuthController@refresh')->name('refresh');
});
