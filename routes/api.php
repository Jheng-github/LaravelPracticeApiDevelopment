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
        
        //這個參數找到的book第二本書 也就是 Book 裡面id=2
        //他會存在imageable_id = 2  , 如果 find(1) imageable_id = 1  
        //imageable_type = Book
        $book = App\Models\Book::find(2);
        //$book->images()  <=== 這個call的是 Book Model 裡面的 images()方法
        //其意思是要在Book 裏面 id=2 的書本裡面增加一張圖片
        $book->images()->create([
            'url' => $request->file('111')->store('books'),
        ]);
        return $book->images;

        //同上，我可以透過User Model 找到第一本上 也就是 imageable_id = 1
        // imageable_type = User
        // $user = App\Models\User::find(1);
        //  //接著user去call image()  這個call的是 User Model 裡面的 image()方法
        // $user->image()->create([
        //     'url' => $request->file('111')->store('users'),
        // ]);
        // return $user->image;

       
    });


    
});