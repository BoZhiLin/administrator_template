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

/** 登入認證 */
Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    /** 登入 */
    Route::post('/login', 'AuthController@login')->name('login');
    /** 登出 */
    Route::post('/logout', 'AuthController@logout')->name('logout')->middleware('api.auth');
    /** 更換Token */
    Route::post('/refresh', 'AuthController@refresh')->name('refresh')->middleware('api.auth');
});

/** 密碼 */
Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
    /** 忘記密碼 */
    Route::post('/forgot', 'PasswordController@forgot')->name('forgot');
    /** 重設密碼 */
    Route::post('/reset', 'PasswordController@reset')->name('reset')->middleware('api.auth');
});

/** 使用者 */
Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    /** 註冊 */
    Route::post('/register', 'UserController@register')->name('register');
});

/** Banner */
Route::group(['prefix' => 'banner', 'as' => 'banner.'], function () {
    /** 開放中Banner */
    Route::get('/', 'BannerController@index')->name('index');
});

/** 公告 */
Route::group(['prefix' => 'announcement', 'as' => 'announcement.'], function () {
    /** 開放中公告 */
    Route::get('/', 'AnnouncementController@index')->name('index');
    /** 指定公告 */
    Route::get('/{announcement_id}', 'AnnouncementController@show')->name('show');
});

/** Authenticated Allow */
Route::group(['middleware' => ['api.auth']], function () {
    /** 驗證 */
    Route::group(['prefix' => 'verify', 'as' => 'verify.'], function () {
        /** 註冊驗證 */
        Route::post('/registration', 'VerifyController@registration')->name('registration');
        /** 寄發驗證碼 */
        Route::post('/registration/send', 'VerifyController@sendRegistration')->name('registration.send');
    });

    /** 使用者登入後行為 */
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        /** 取得登入資訊 */
        Route::get('/info', 'UserController@getInfo')->name('info');
        /** 更新個人資訊 */
        Route::post('/info', 'UserController@setInfo')->name('info.set');
        /** 配對邀請 (LIKE) */
        Route::post('/match', 'UserController@match')->name('match');
        /** 解除配對 */
        Route::delete('/match', 'UserController@removeMatch')->name('match.remove');
        /** 每日簽到 */
        Route::post('/sign', 'UserController@signIn')->name('sign');

        /** 通知中心 */
        Route::group(['prefix' => 'notifications', 'as' => 'notifications.'], function () {
            /** 取得列表 */
            Route::get('/', 'UserController@getNotifications')->name('notifications');
            /** 已讀 */
            Route::patch('/{id}/read', 'UserController@markNotificationRead')->name('notification.read');
        });

        /** VIP */
        Route::group(['prefix' => 'vip', 'as' => 'vip.'], function () {
            /** 購買 */
            Route::post('/buy', 'UserController@buyVIP')->name('buy');
        });
    });
    
    /** 文章 */
    Route::group(['prefix' => 'post', 'as' => 'post.'], function () {
        /** 搜尋使用者文章 */
        Route::get('/', 'PostController@index')->name('index');
        /** 特定文章 */
        Route::get('/{post_id}', 'PostController@show')->name('show');
        /** PO文 */
        Route::post('/', 'PostController@store')->name('store');
        /** 按讚 */
        Route::patch('/{post_id}/like', 'PostController@like')->name('like');
        /** 取消讚 */
        Route::patch('/{post_id}/dislike', 'PostController@dislike')->name('dislike');
    });

    /** 約會 */
    Route::group(['prefix' => 'date', 'as' => 'date.'], function () {
        /** 開放中的約會 */
        Route::get('/list', 'DateController@getOpeningList')->name('opening');
        /** 約會明細 */
        Route::get('/{date_id}', 'DateController@getDetail')->name('detail');
        /** 發佈 */
        Route::post('/publish', 'DateController@publish')->name('publish');
        /** 報名 */
        Route::post('/{date_id}/signup', 'DateController@signUp')->name('signup');
        /** 配對 */
        Route::post('/{date_id}/match', 'DateController@match')->name('match');
    });
});
