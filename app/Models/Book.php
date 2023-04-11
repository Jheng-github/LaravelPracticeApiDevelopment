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
}
