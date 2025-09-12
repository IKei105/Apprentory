<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('original_product_technologie_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('original_product_id');
            $table->unsignedBigInteger('technologie_id');
            $table->unique(['original_product_id', 'technologie_id'],'product_technologie_unique');
            $table->foreign('original_product_id')->references('id')->on('original_products')->onDelete('cascade');
            $table->foreign('technologie_id')->references('id')->on('technologies')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('original_product_technologie_tags');
    }
};
