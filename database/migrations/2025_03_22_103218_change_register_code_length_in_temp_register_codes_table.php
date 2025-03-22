<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('temp_register_codes', function (Blueprint $table) {
            $table->string('register_code', 1024)->change();
        });
    }

    public function down(): void
    {
        Schema::table('temp_register_codes', function (Blueprint $table) {
            $table->string('register_code', 16)->change();
        });
    }
};
