<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** 後台 */
Route::any('/admin/{all?}', function () {
    return view('layouts.backend');
})->where(['all' => '.*']);

/** 前台 */
Route::any('{all}', function () {
    return view('layouts.frontend');
})->where(['all' => '.*']);
