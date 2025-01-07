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
        Schema::create('user_follows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('following_id');   // ユーザーID(外部キー)
            $table->unsignedBigInteger('follower_id');   // ユーザーID(外部キー)

            //外部キー制約
            $table->foreign('following_id')->references('id')->on('users')->onDelete('cascade');
            //userのプライマリキー
            $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
            //userのプライマリキー
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_follows');
    }
};
