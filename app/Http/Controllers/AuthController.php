<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function login(Request $resquest)
    {
        //驗證email是必須填入 長度為255
        //password 必須填入,且要符合alpha_num 只接受英文跟字母 ,最小6最大255
        $validate = $this->validate(
            $resquest,
            [
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'alpha_num', 'min:6', 'max:255'],
            ]
        );
        //若要修改驗證的資料表需要在congif/auth.php修改
        //Guard用於管理驗證和登錄
        //Provider用於定義要從哪個數據庫表中檢索資料。
        $token = Auth::attempt($validate);

        //$token 驗證結果放進變數(attempt回傳是true or false)
        //給出相對應的EQUEST
        abort_if(!$token, Response::HTTP_BAD_REQUEST, '帳號或者密碼錯誤');
        //當上面false失敗之後，已經中止，最後代表是正確的return response
        return response(['data' => $token]);
    }
    public function logout()
    {
        //使用者登出
        Auth::logout();
        //回傳無內容
        return response()->noContent();
        //測試用,的確會回傳該message
        // return response()->json(['message' => '您已經成功登出']);
    }
}
