<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('original_product_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_product_id');
            $table->unsignedBigInteger('posted_user_profile_id');
            $table->timestamps();

            $table->foreign('original_product_id')->references('id')->on('original_products')->onDelete('cascade');
            $table->foreign('posted_user_profile_id')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('original_product_posts');
    }
};
