<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('technologies')->insert([
            ['level' => 1],
            ['level' => 2],
            ['level' => 3],
            ['level' => 4],
            ['level' => 5],
        ]);
    }
}
