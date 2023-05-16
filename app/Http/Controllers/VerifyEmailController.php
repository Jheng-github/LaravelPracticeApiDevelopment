<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function store(Request $request){
        $user =User::find($request->route('id'));

        if (! hash_equals((string) $user->getKey(), (string) $request->route('id'))) {
           // return false;
            return '無效的使用者';
        }

        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
            //return false;
            return '無效的驗證';
        }
        if(!$user->hasVerifiedEmail()){
            $user->update(['email_verified_at' => now()]);
            return '驗證成功';
        }

        return '您已經驗證過';

    }
}
