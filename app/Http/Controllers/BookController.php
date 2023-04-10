<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;

class BookController extends Controller
{
    //新增書籍到資料庫method
    public function store(Request $requset)
    {
        //檢查權限第一個參數是行為,
        //第二個參數則是透過BookModel 轉至Policy 在使用裡面的create method
        //Policy會在去確認是否UserModel 裡面有沒有開放權限給這個人可以創造書本
        $this->authorize('create', [Book::class]);

        //檢查是否是登入的狀態
        //並把撈出來的是哪一個使用者存放在$user變數
        $user = Auth::user();
        
        //驗證使用者的request 是否符合規定
        $validate = $this->validate(
            $requset,
            [
                'name'   => ['required', 'string', 'max:255'],
                'author' => ['required', 'string', 'max:255'],
            ]
        );

        //如果上述驗證都有過,$user 登入者 去取得UserModel中books method 與 BookModel 的關聯
        //並創建一本書
        return $user->books()->create($validate);
        //上下這兩個都可以
        // return Book::create(array_merge($validate, ['user_id' => $user->id]));
    }
    //檢視所有使用者書籍
    public function index(Request $request)
    {
        //檢視權限是否能夠觀看書籍
        $this->authorize('viewany', [Book::class]);
        //把文章最新更新的一筆顯示在第一筆
        $books = Book::latest();
        //設定一個欄位名稱為'owned',如果值為true表示只顯示自己的文章
        //反則跳脫這個判斷式
        if($request->boolean('owned')){
             $books->where('user_id', Auth::user()->getKey());
        }
        //製作分頁，沒填入數字預設15/一頁
        return $books->paginate();
    }
}
