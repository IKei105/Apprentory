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
        Schema::create('original_product_images', function (Blueprint $table) {
            $table->id();
            $table->string('image_dir'); //画像のパスを保持
            $table->unsignedBigInteger('original_product_id');   // オリプロID(外部キー)

            //外部キー制約
            $table->foreign('original_product_id')->references('id')->on('original_products')->onDelete('cascade');
            //original_productのプライマリキー
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('original_product_images');
    }
};
