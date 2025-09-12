<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedInteger('price');
            $table->text('material_detail');
            $table->text('material_url')->nullable();
            $table->unsignedBigInteger('rating_id');
            $table->string('image_dir');
            $table->timestamps();

            $table->foreign('rating_id')->references('id')->on('ratings')->onDelete('cascade');
            $table->index([DB::raw('material_url(256)')], 'material_url_index');
            

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
