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
        Schema::create('original_products', function (Blueprint $table) {
            $table->id();
            $table->string('element');
            $table->string('title');
            $table->text('subtitle');
            $table->text('product_detail');
            $table->text('product_url')->nullable();
            $table->text('github_url')->nullable();
            $table->timestamps();

            // 256文字の部分インデックスを追加
            $table->index([DB::raw('product_url(256)')], 'product_url_index');
            $table->index([DB::raw('github_url(256)')], 'github_url_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('original_products');
    }
};
