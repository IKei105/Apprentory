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
        Schema::create('original_product_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_product_id');   // オリプロID(外部キー)
            $table->unsignedBigInteger('posted_user_profile_id');        // ユーザーID（外部キー）
            $table->timestamps();

            //外部キー制約
            $table->foreign('original_product_id')->references('id')->on('original_products')->onDelete('cascade');
            //original_productのプライマリキー
            $table->foreign('posted_user_profile_id')->references('id')->on('profiles')->onDelete('cascade');
            //userのプライマリキー
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('original_product_posts');
    }
};
