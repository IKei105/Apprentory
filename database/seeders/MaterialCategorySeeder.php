<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaterialCategory;

class MaterialCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            '書籍',
            'オンライン記事',
            '動画教材',
        ];

        foreach ($categories as $category) {
            MaterialCategory::create(['category_name' => $category]);
        }
    }
}
