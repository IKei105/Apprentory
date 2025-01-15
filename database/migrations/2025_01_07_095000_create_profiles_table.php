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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')       // アカウントID(外部キー)
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();            
            
            $table->string('username')->nullable();                 // ユーザー名
            $table->string('profile_image')->nullable();            // プロフィール画像
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
