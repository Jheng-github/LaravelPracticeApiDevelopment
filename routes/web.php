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


// //驗證信的頁面
// Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request){
//     //EmailVerificationRequest $request 這個$requset 會去自動驗證 {id} {hash}
//     //fulfill,會去call一些底層, 去抓出  這個email位置 是否真的符合,並在email_verified_at位置 驗證成功
//     ddd($request);
//     $request->fulfill();
//     //接著重導向
//     ddd($request);
//     // sanctum
//     return 'wwww';
// })->middleware(['auth:api','signed'])->name('verification.verify');

// //提醒你應該去信箱點擊驗證信的畫面
// Route::get('/email/verify', function () {
//     return '提醒你應該去信箱點擊驗證信的畫面';
// })->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    // ->middleware(['throttle:6,1'])
    ->name('verification.verify');






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