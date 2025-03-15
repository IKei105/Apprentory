<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TermsSeeder::class);
        $this->call(TechnologieSeeder::class);
        $this->call(RatingsTableSeeder::class);
        $this->call(MaterialCategorySeeder::class);
    }
}
