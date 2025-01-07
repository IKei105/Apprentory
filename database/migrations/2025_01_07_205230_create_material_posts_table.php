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
        Schema::create('material_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');     // 教材ID(外部キー)
            $table->unsignedBigInteger('posted_user_id');  // ユーザーID（外部キー）
            $table->timestamps();

            //外部キー制約
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            //materialのプライマリキー
            $table->foreign('posted_user_id')->references('id')->on('users')->onDelete('cascade');
            //userのプライマリキー
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_posts');
    }
};
