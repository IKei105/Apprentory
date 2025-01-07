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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');                // アカウントID(外部キー)
            $table->unsignedBigInteger('term_id');         // 学期ID（外部キーにする予定）
            $table->string('username');                 // ユーザー名
            $table->string('profile_image');            // プロフィール画像
            $table->timestamps();
            
            //外部キー制約
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            //Accountのプライマリキー
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
            //termのプライマリキー
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
