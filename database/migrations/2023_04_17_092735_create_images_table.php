<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            //設置一個字串存檔案位置
            $table->string('url');
            //與其他資料表對應的id 
            // 例如imageable_type=User imageable_id= 2 
            //就是 User表的 id=2 上傳的圖片
            $table->unsignedBigInteger('imageable_id');
            //要抓哪個資料表的名稱, 例如 User資料表 或 Book資料表;
            $table->string('imageable_type');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
