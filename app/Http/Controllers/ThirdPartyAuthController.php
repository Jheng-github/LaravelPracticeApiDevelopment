<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class ThirdPartyAuthController extends Controller
{   
    //github
    public function redirectToGithub()
    {
        // 轉址到第三方認證
        return Socialite::driver('github')->redirect();
    }
    //facebook
    public function redirectToFacebook()
    {
        // 轉址到第三方認證
        return Socialite::driver('facebook')->redirect();
    }

        //google
        public function redirectTogoogle()
        {
            // 轉址到第三方認證
            return Socialite::driver('google')->redirect();
        }


    //github驗證
    public function handleGithubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();
            // dd($githubUser);
            // 使用 `updateOrCreate` 方法更新或新增資料庫中的使用者資料
            // 第一個參數是搜尋條件，如果有符合的資料，就更新該筆資料
            // 如果沒有符合的資料，就新增一筆資料
            $user = User::updateOrCreate([
                // 'github_id' => $githubUser->id, // 用 Github ID 作為搜尋條件
                'email' => $githubUser->email,
            ], [
                'name' => $githubUser->nickname, // 更新或新增使用者名稱
                // 'email' => $githubUser->email, // 更新或新增 使用者 Email
                'github_id' => $githubUser->id,
                'github_token' => $githubUser->token, // 用來存取 Github API 的 access token
                'github_refresh_token' => $githubUser->refreshToken, // 用來重新取得 access token 的 refresh token
                'email_verified_at' => now(), // 認證信箱的時間設為現在
            ]);
        } catch (\Exception $exception) {
            //拋出錯誤
            throw $exception;
        };
        Auth::login($user);
        return $user;
    }

    //facebook驗證
    public function handleFacebookCallback()
    {

        try {
            $facebookUser = Socialite::driver('facebook')->user();
            // 使用 `updateOrCreate` 方法更新或新增資料庫中的使用者資料
            // 第一個參數是搜尋條件，如果有符合的資料，就更新該筆資料
            // 如果沒有符合的資料，就新增一筆資料
            $user = User::updateOrCreate([
                //用mail當作搜尋條件
                'email' => $facebookUser->email,
            ], [
                'name' => $facebookUser->name, // 更新或新增使用者名稱
                'facebook_id' => $facebookUser->id, // 更新或新增使用者名稱
                'email_verified_at' => now(), // 認證信箱的時間設為現在
            ]);
        } catch (\Exception $exception) {
            //拋出錯誤
            throw $exception;
        };
        Auth::login($user);
        return $user;
    }

    //Google驗證
        public function handleGoogleCallback()
        {

            try {
               $googleUser = Socialite::driver('google')->user();
                // 使用 `updateOrCreate` 方法更新或新增資料庫中的使用者資料
                // 第一個參數是搜尋條件，如果有符合的資料，就更新該筆資料
                // 如果沒有符合的資料，就新增一筆資料
                $user = User::updateOrCreate([
                    //用mail當作搜尋條件
                    'email' => $googleUser->email,
                ], [
                    'name' => $googleUser->nickname, // 更新或新增使用者名稱
                    'google_id' => $googleUser->id, // 更新或新增使用者名稱
                    'email_verified_at' => now(), // 認證信箱的時間設為現在
                ]);
            } catch (\Exception $exception) {
                //拋出錯誤
                throw $exception;
            };
            Auth::login($user);
            return $user;
        }
}
