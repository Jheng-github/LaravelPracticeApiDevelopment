<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//設定一個router 名為 password.reset 讓laravel 可以吃到
//url 的名字不需要一定是reset-password    ooo也可以
Route::get('/reset-password/{token}', function () {
    return '重設密碼的頁面';
})->name('password.reset');