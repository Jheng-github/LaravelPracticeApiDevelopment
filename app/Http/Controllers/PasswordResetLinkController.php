<?php

namespace App\Http\Controllers;

// use core\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class PasswordRestLinkController extends Controller
{
    //寄信
    public function store(Request $request)
    {
        //驗證欄位
        $validate = $request->validate([
            'email' => ['required', 'email'],
        ]);
        //透過broker 找出使用者的email
        //透過sendResetLink實施發信 
        $result = Password::broker('users')->sendResetLink($validate);

        //$result 的結果會有幾種狀態 其中成功發信的狀態是 Password::RESET_LINK_SENT
        //如果不是得到 RESET_LINK_SENT  返回BAD_REQUEST
        // __()是多語言的用法
        abort_if(
            $result !== Password::RESET_LINK_SENT,
            Response::HTTP_BAD_REQUEST,
            __($result)
        );

        // dd($result,  __($result), Password::RESET_LINK_SENT);

        //可以直接在用這種方式在lang/en/auth.php 客製化訊息
        return response(['data' =>  __('auth.result')]);

        //  
        //其實也可以在這邊改掉他的輸出變成你要的 也可以選擇自己做一個
        //位置會隨著laravel版本不一樣而有所改動
        // return response(['data' =>  __($result)]);

    }
}
