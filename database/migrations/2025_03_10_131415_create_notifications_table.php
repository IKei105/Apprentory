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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // 通知を受け取るユーザー
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // 通知を発生させたユーザー
            $table->foreignId('from_user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // 通知タイプ（notification_typesテーブル参照）
            $table->foreignId('notification_type_id')
                ->constrained()
                ->onDelete('cascade');

            // 通知対象の多態的リレーション
            $table->string('notifiable_type')->nullable(); // App\Models\Materialなど
            $table->unsignedBigInteger('notifiable_id')->nullable(); // 教材IDなど

            // 既読状態（初期値は未読）
            $table->boolean('is_read')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

