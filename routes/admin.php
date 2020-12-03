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

Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    /** 使用者列表 */
    Route::get('/', 'UserController@index')->name('index');
    /** 查看使用者 */
    Route::get('/{id}', 'UserController@show')->name('show');
});
