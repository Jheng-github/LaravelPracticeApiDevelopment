<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
        //新增欄位,type=無符號整數
        //默認為一般用戶(2),role欄位位置在id之後
        $table->unsignedBigInteger('role')->default(User::ROLE_NORMAL)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //rollback時回到上一個狀態,也就是刪掉role
            $table->dropColumn('role');
        });
    }
};
