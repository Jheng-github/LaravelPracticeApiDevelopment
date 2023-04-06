<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function  register(Request $request){
    //驗證使用者輸入的資料
     $validated = $this->validate($request,[
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'password' => ['required', 'alpha_num:ascii', 'min:6', 'max:12', ' ']
     ]);
     //abort_if() 
     //具體來說，abort_if 函式接受三個參數：
    // 第一個參數是一個條件式，如果該條件為真，則函式會執行中斷並返回 HTTP 錯誤頁面。
    // 第二個參數是中斷時所要回傳的 HTTP 錯誤碼。
    // 第三個參數是中斷時所要顯示的錯誤訊息。在lang/en的auth.php執行設定對應的參數要顯示什麼
    // __('auth.duplicate email')//auth代表檔案lang/en這隻檔案底下的auth這隻檔案duplicate email 則是名字

     abort_if(
        User::where('email', $request->input('email'))->first(),
        Response::HTTP_BAD_REQUEST,
        __('auth.duplicate email')
    ); 
    //經過上述驗證之後把使用者加入資料庫
    //並且透過array_merge 把name=password欄位替換成hash過後的版本
    $user = User::create(
        array_merge(
            $validated, ['password' => Hash::make($validated['password'])]
        )
    );
    //data 就是把內容包起來的東西
    // "data": {
    // "name": "jheng123",
    // "email": "jheng123@example.com",
    // "updated_at": "2023-04-06T02:58:54.000000Z",
    // "created_at": "2023-04-06T02:58:54.000000Z",
    // "id": 2
    // }
    return response(['data' => $user]);
}
}
