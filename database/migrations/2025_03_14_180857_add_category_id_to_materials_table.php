<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->after('image_dir') // image_dir の後に追加
                ->constrained('material_categories') // material_categories.id に外部キー制約
                ->onDelete('cascade'); // カテゴリー削除時に教材も削除
        });
    }

    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};

