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
Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    /** 取得資訊 */
    Route::get('me', 'AuthController@me')->name('me');
    /** 登入 */
    Route::post('login', 'AuthController@login')->name('login');
    /** 登出 */
    Route::post('logout', 'AuthController@logout')->name('logout');
    /** 更換Token */
    Route::post('refresh', 'AuthController@refresh')->name('refresh');
});

/** User */
Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    /** 使用者列表 */
    Route::get('/', 'UserController@index')->name('index');
    /** 查看使用者 */
    Route::get('/{id}', 'UserController@show')->name('show');
});

/** 公告 */
Route::group(['middleware' => ['admin.auth']], function (){

    Route::group(['prefix' => 'announcement', 'as' => 'announcement.'], function () {
        /** 公告列表 */
        Route::get('/', 'AnnouncementController@index')->name('index');
        /** 刪除公告 */
        Route::delete('/{id}', 'AnnouncementController@destroy')->name('destroy');
        /** 紀錄公告 */
        Route::group(['middleware' => ['admin.log']], function (){
            /** 新增公告 */
            Route::post('/store', 'AnnouncementController@store')->name('store');
            /** 更新公告 */
            Route::put('/{id}', 'AnnouncementController@update')->name('update');
        });
    });
    /** Banner */
    Route::group(['prefix' => 'banner', 'as' => 'banner.'], function () {
        /** Banner列表 */
        Route::get('/', 'BannerController@index')->name('index');
        /** 刪除Banner */
        Route::delete('/{id}', 'BannerController@destroy')->name('destroy');
        /** 紀錄Banner */
        Route::group(['middleware' => ['admin.log']], function (){
            /** 新增公告 */
            Route::post('/store', 'BannerController@store')->name('store');
            /** 更新公告 */
            Route::put('/{id}', 'BannerController@update')->name('update');
        });
    });
});

