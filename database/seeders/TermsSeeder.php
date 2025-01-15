<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('terms')->insert([
            ['term' => '1期生'],
            ['term' => '2期生'],
            ['term' => '3期生'],
            ['term' => '4期生'],
            ['term' => '5期生'],
            ['term' => '6期生'],
            ['term' => '7期生'],
        ]);
    }
}
