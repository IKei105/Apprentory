<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_technologie_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('material_id');
            $table->unsignedBigInteger('technologie_id');

            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            $table->foreign('technologie_id')->references('id')->on('technologies')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_technologie_tags');
    }
};
