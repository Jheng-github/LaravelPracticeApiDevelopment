<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

//設定群組,預設連接 http://127.0.0.1:8000/api/user/....等
Route::prefix('user')->group(function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    //只有驗證過登入的人,才可以訪問這個logout的url
    Route::middleware('auth')->group(function () {
        //編輯個人檔案的API
        Route::get('profile', function () {
            return Auth::user();
            // 兩種是一樣的
            // return auth()->user();
        });
        //登出
        Route::get('logout', [AuthController::class, 'logout']);
        //製作books這個route 只限定only裡面的方法 透過BookController 且要經過middle,登入後才能訪問
        Route::apiResource('books', BookController::class)
        ->only('store','index','update','destroy','show');
    });
    Route::post('photo', function (Request $request) {
        
        //找出書本關聯,去call Model method(關聯資料)
        //進入create 新增資料庫
        //因為Driver 已經設定Gcp 所以上傳位置會從本地到Gcp
        $book = App\Models\Book::find(2);
       foreach($request -> file('111') as $file){
        $book->images()->create([
            'url' => $file->store(),
        ]);
       }
       return '上傳成功';

       
    });


    
});