<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Book extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'name',
        'author',
        'updated_at', 
        'created_at',
        'user_id',
    ];
    //製作一對多與User 資料表的關係
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //多對多連結
    //一本書只能有一個作者,但可以有很多圖片
    //但目前看起來好像跟user 表單沒關係,可是因為資料都可以存在第三張表 , 所以可以透過第三張表 去取得user的關係
    public function images(){
        return $this->morphMany(Image::class, 'imageable');
    }
}
