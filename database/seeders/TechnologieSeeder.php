<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TechnologieSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('technologies')->insert([
            ['name' => 'Ruby'],
            ['name' => 'PHP'],
            ['name' => 'SQL'],
            ['name' => 'HTML'],
            ['name' => 'CSS'],
            ['name' => 'JavaScript'],
            ['name' => 'GitHub'],
            ['name' => 'Linux'],
            ['name' => 'Docker'],
            ['name' => 'AWS'],
        ]);
    }
}
