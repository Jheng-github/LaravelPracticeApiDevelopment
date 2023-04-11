<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;

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
        //return $user->books()->create($validate);
        //上下這兩個都可以
        // return Book::create(array_merge($validate, ['user_id' => $user->id]));

        //透過Resources 來設定出現json的格式
        return BookResource::make($user->books()->create($validate));
    }
    //檢視所有使用者書籍
    public function index(Request $request)
    {
        //檢視權限是否能夠觀看書籍
        $this->authorize('viewany', [Book::class]);
        //把文章最新更新的一筆顯示在第一筆
        // $books = Book::latest()->with('user');

        //透過'creator' => UserResource::make($this->whenLoaded('user')),
        //透過這樣可以防止n+1
        $books = Book::latest()->with('user');

        //設定一個欄位名稱為'owned',如果值為true表示只顯示自己的文章
        //反則跳脫這個判斷式
        if ($request->boolean('owned')) {
            //Auth::user()確認是哪個使用者並透過getKey()method取得id
            //並且撈出user_id = id 的所有資料
            $books->where('user_id', Auth::user()->getKey());
        }
        //製作分頁，沒填入數字預設15/一頁
        //return $books->paginate();

        //透過Resources 來設定出現json的格式
        return BookCollection::make($books->paginate());
    }

    //update 更新Book 的資料
    //第二個參數Book 是因為會對資料庫修正,所以會有一個參數
    public function update(Request $request, Book $book)
    {
        //檢視權限是否能夠對資料庫更新
        //需要第二個參數因為會對資料庫動作,所以需要此參數
        $this->authorize('update', [Book::class, $book]);
        //驗證欄位
        $validated = $this->validate($request, [
            'name'   => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
        ]);
        //把request進來的值傳入update進行更新
        $book->update($validated);
        //並回傳值
        // return $book;

        //透過Resources 來設定出現json的格式
        //load 防止N+1
        return  BookResource::make($book->load('user'));
    }
    //刪除某一本書籍
    public function destroy(Book $book)
    {
        //檢查權限是否能夠刪除
        $this->authorize('delete', [Book::class, $book]);
        //執行刪除
        $book->delete();
        //回傳json
        return response()->json(['message' => '書本資料已刪除']);
    }
    //要找某一本書,因為會像資料庫丟搜尋,所以需要參數是$book
    public function show(Book $book)
    {
        // type hint
        //確認使用者有無權限
        $this->authorize('view', [Book::class, $book]);

        //  return $book;

        //透過Resources 來設定出現json的格式
        return BookResource::make($book);
    }
}
