<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserEmailVerification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;



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
            //註冊之後發出驗證信,可能你需要打開驗證信之後才能使用某些功能之類的
            event(new Registered($user));
            //註冊後純寄信使用,可能像是 歡迎你註冊...等
             Mail::to($user)->send( new UserEmailVerification($user));

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

        return response([
            'data' => $user

        ],201);
    }
}
