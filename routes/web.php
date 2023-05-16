<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\ThirdPartyAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\VerifyEmailController; 


Route::get('/', function () {
    return view('oauth');
})->name('login');

//設定一個router 名為 password.reset 讓laravel 可以吃到
//url 的名字不需要一定是reset-password    ooo也可以
Route::get('/reset-password/{token}', function () {
    return '重設密碼的頁面';
})->name('password.reset');


//github login
Route::get('/auth/github', [ThirdPartyAuthController::class, 'redirectToGithub']);

Route::get('/auth/github/callback', [ThirdPartyAuthController::class, 'handleGithubCallback']);


//facebook login
Route::get('/auth/facebook', [ThirdPartyAuthController::class, 'redirectToFacebook']);

Route::get('/auth/facebook/callback', [ThirdPartyAuthController::class, 'handleFacebookCallback']);

//goole login
Route::get('/auth/google', [ThirdPartyAuthController::class, 'redirectToGoogle']);

Route::get('/auth/google/callback', [ThirdPartyAuthController::class, 'handleGoogleCallback']);

//line login
Route::get('/auth/line', [ThirdPartyAuthController::class, 'redirectToLine']);

Route::get('/auth/line/callback', [ThirdPartyAuthController::class, 'handleLineCallback']);