<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Book;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    //增加兩個常數,定義成角色 作用是權限判別
    const ROLE_ADMIN = 1;
    const ROLE_NORMAL = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
     // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    //製作UserModel 與 BokkModel 的關係
    //一個使用者可以有很多本書,所以是復數
    public function books(){
        return $this->hasMany(Book::class);
    }
    //管理者權限製作
    //Model可以直接用$this去撈出所有欄位,故role =資料庫欄位
    //return true or false
    public function isAdmin(){
        return $this->role === self::ROLE_ADMIN;
    }
    //一般使用者權限製作
    //Model可以直接用$this去撈出所有欄位,故role =資料庫欄位
    //return true or false
    public function isNormalUser(){
        return $this->role === self::ROLE_NORMAL;
    }
    //確認是否有權限在policy引用
    public function hasPermissionToCreateBook(){
        return $this->isAdmin() || $this->isNormalUser();
    }



}
