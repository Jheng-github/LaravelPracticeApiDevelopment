<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function  register(Request $request)
    {
        //驗證使用者輸入的資料
        $validated = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'alpha_num:ascii', 'min:6', 'max:12', ' '],
            '111' => ['nullable', 'image'],
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
        //開始記錄對資料庫的後續動作
        DB::beginTransaction();
        //嘗試寫入資料庫
        try {
            //經過上述驗證之後把使用者加入資料庫
            //並且透過array_merge 把name=password欄位替換成hash過後的版本
            $user = User::create(
                array_merge(
                    $validated,
                    ['password' => Hash::make($validated['password'])]
                )
            );
            //通常第一個條件成立第二個條件就會成立,但放在判斷裡面可以防止意外
            //例如突然斷網
            if ($request->has('111') && $path = $request->file('111')->store()) {
                //當條件都成真之後就可以寫進資料庫
                //透過Morph 取得Image表
                $user->image()->create([
                    'url' => $path,
                ]);
            }
        }
        //如果try裡面異常,接住錯誤
        catch (\Exception $exception) {
            //撤銷這次對資料庫的操作
            DB::rollBack();
            //拋出錯誤
            throw $exception;
        }
        //如果沒try沒問題沒錯誤,就進行commit把這段對資料庫的動作存取起來
        DB::commit();


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
