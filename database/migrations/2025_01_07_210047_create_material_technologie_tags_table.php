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
        Schema::create('material_technologie_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('material_id');     // 教材ID(外部キー)
            $table->unsignedBigInteger('technologie_id');  // ユーザーID（外部キー）

            //外部キー制約
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            //materialのプライマリキー
            $table->foreign('technologie_id')->references('id')->on('technologies')->onDelete('cascade');
            //userのプライマリキー
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_technologie_tags');
    }
};
