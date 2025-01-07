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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedInteger('price');
            $table->text('material_detail');
            $table->text('material_url')->nullable();
            $table->unsignedBigInteger('rating_id');   // 技術ID(外部キー)
            $table->string('image_dir'); //画像のパスを保持
            $table->timestamps();

            //外部キー制約
            $table->foreign('rating_id')->references('id')->on('ratings')->onDelete('cascade');
            //ratingのプライマリキー

            // 256文字の部分インデックスを追加
            $table->index([DB::raw('material_url(256)')], 'material_url_index');
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
