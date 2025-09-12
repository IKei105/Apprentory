<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('original_product_images', function (Blueprint $table) {
            $table->id();
            $table->string('image_dir');
            $table->unsignedBigInteger('original_product_id');

            $table->foreign('original_product_id')->references('id')->on('original_products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('original_product_images');
    }
};
