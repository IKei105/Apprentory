<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('notification_types')->insert([
            ['name' => 'like', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'comment', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'follow', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
